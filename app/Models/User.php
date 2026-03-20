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
        ];
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
     * Get the profile for the user.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
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
     /**
     * Backward compatibility accessor for village_id
     */
    public function getVillageIdAttribute()
    {
        return $this->profile?->village_id;
    }

    /**
     * Backward compatibility accessor for is_suspended
     */
    public function getIsSuspendedAttribute()
    {
        return $this->profile?->is_suspended ?? false;
    }

    /**
     * Backward compatibility accessor for suspended_at
     */
    public function getSuspendedAtAttribute()
    {
        return $this->profile?->suspended_at;
    }

    /**
     * Backward compatibility accessor for is_approved_by_admin
     */
    public function getIsApprovedByAdminAttribute()
    {
        return $this->profile?->is_approved_by_admin ?? false;
    }

    /**
     * Backward compatibility accessor for approved_by_admin_at
     */
    public function getApprovedByAdminAtAttribute()
    {
        return $this->profile?->approved_by_admin_at;
    }

    /**
     * Backward compatibility accessor for jabatan_desa
     */
    public function getJabatanDesaAttribute()
    {
        return $this->profile?->jabatan_desa;
    }

    /**
     * Backward compatibility accessor for nip
     */
    public function getNipAttribute()
    {
        return $this->profile?->nip;
    }

    /**
     * Backward compatibility accessor for instansi
     */
    public function getInstansiAttribute()
    {
        return $this->profile?->instansi;
    }

    /**
     * Backward compatibility accessor for no_hp
     */
    public function getNoHpAttribute()
    {
        return $this->profile?->no_hp;
    }
}
