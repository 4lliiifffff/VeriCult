<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'is_suspended',
        'suspended_at',
        'is_approved_by_admin',
        'approved_by_admin_at',
        'village_id',
        'jabatan_desa',
        'nip',
        'instansi',
        'no_hp',
    ];

    protected function casts(): array
    {
        return [
            'is_suspended'         => 'boolean',
            'suspended_at'         => 'datetime',
            'is_approved_by_admin' => 'boolean',
            'approved_by_admin_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns this profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the village associated with this profile (for pengusul-desa).
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }
}
