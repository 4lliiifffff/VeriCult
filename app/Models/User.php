<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_suspended',
        'suspended_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'last_seen_at'      => 'datetime',
            'is_suspended'      => 'boolean',
            'suspended_at'      => 'datetime',
        ];
    }

    protected static function booted()
    {
        // Explicitly delete pengusulDesaProfile before DB cascade
        // so PengusulDesaProfile's deleting event fires and cleans up surat file
        static::deleting(function ($user) {
            $user->pengusulDesaProfile?->delete();
        });
    }

    /**
     * Get the route name for the user's dashboard based on their role.
     *
     * @return string
     */
    public function getDashboardRoute(): string
    {
        if ($this->hasRole('super-admin')) {
            return 'super-admin.dashboard';
        } elseif ($this->hasRole('admin')) {
            return 'admin.dashboard';
        } elseif ($this->hasRole('validator')) {
            return 'validator.dashboard';
        } elseif ($this->hasRole('pengusul')) {
            return 'pengusul.dashboard';
        } elseif ($this->hasRole('pengusul-desa')) {
            return 'pengusul-desa.dashboard';
        }

        return 'dashboard';
    }

    /**
     * Check if user is a pengusul-desa pending admin approval.
     *
     * @return bool
     */
    public function isPendingAdminApproval(): bool
    {
        return $this->hasRole('pengusul-desa') && !$this->profile?->is_approved_by_admin;
    }

    /**
     * Get admin approval status for pengusul-desa users.
     *
     * @return string
     */
    public function getAdminApprovalStatus(): string
    {
        if (!$this->hasRole('pengusul-desa')) {
            return 'N/A';
        }

        if ($this->profile?->is_approved_by_admin) {
            return 'Disetujui';
        }

        return 'Menunggu Persetujuan';
    }

    /**
     * Get the specialized profile relationship for the user based on their current role.
     * Note: This is an accessor (lazy-loading). Do not use with load() or with().
     */
    public function getProfileAttribute()
    {
        $role = $this->roles->first()?->name;

        return match ($role) {
            'super-admin'   => $this->superAdminProfile,
            'admin'         => $this->adminProfile,
            'validator'     => $this->validatorProfile,
            'pengusul'      => $this->pengusulProfile,
            'pengusul-desa' => $this->pengusulDesaProfile,
            default         => null,
        };
    }

    /* specialized relationships */

    public function superAdminProfile(): HasOne
    {
        return $this->hasOne(SuperAdminProfile::class);
    }

    public function adminProfile(): HasOne
    {
        return $this->hasOne(AdminProfile::class);
    }

    public function validatorProfile(): HasOne
    {
        return $this->hasOne(ValidatorProfile::class);
    }

    public function pengusulProfile(): HasOne
    {
        return $this->hasOne(PengusulProfile::class);
    }

    public function pengusulDesaProfile(): HasOne
    {
        return $this->hasOne(PengusulDesaProfile::class);
    }

    /**
     * Get the village that the user belongs to (via profile).
     */
    public function getVillageAttribute()
    {
        return $this->profile?->village;
    }

    /**
     * Get the village ID that the user belongs to (via profile).
     */
    public function getVillageIdAttribute()
    {
        return $this->profile?->village_id;
    }

    /**
     * Account suspension status attribute.
     */
    public function getStatusAttribute(): string
    {
        if ($this->is_suspended) {
            return 'Suspended';
        }

        if ($this->hasRole('pengusul-desa') && !$this->is_approved_by_admin) {
            return 'Pending Approval';
        }

        return 'Active';
    }

    /* Backward compatibility accessors (all point to the specific profile) */

    public function getIsApprovedByAdminAttribute()
    {
        return $this->profile?->is_approved_by_admin ?? false;
    }

    public function getApprovedByAdminAtAttribute()
    {
        return $this->profile?->approved_by_admin_at;
    }

    public function getJabatanDesaAttribute()
    {
        return $this->hasRole('pengusul-desa') ? $this->profile?->jabatan_desa : null;
    }

    public function getNipAttribute()
    {
        return $this->hasRole('pengusul-desa') ? $this->profile?->nip : null;
    }

    public function getInstansiAttribute()
    {
        return $this->profile?->instansi;
    }

    public function getNoHpAttribute()
    {
        return $this->profile?->no_hp;
    }
}
