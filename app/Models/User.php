<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'role', // temporary for existing logic
        'is_suspended',
        'suspended_at',
        'is_approved_by_admin',
        'approved_by_admin_at',
        'village_id',
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
            'password' => 'hashed',
            'is_suspended' => 'boolean',
            'suspended_at' => 'datetime',
            'last_seen_at' => 'datetime',
            'is_approved_by_admin' => 'boolean',
            'approved_by_admin_at' => 'datetime',
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
        return $this->hasRole('pengusul-desa') && !$this->is_approved_by_admin;
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

        if ($this->is_approved_by_admin) {
            return 'Disetujui';
        }

        return 'Menunggu Persetujuan';
    }

    /**
     * Get the village that the user belongs to.
     */
    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
