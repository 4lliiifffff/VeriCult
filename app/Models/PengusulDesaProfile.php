<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengusulDesaProfile extends Model
{
    protected $fillable = [
        'user_id',
        'village_id',
        'jabatan_desa',
        'nip',
        'no_hp',
        'surat_pengajuan_path',
        'is_approved_by_admin',
        'approved_by_admin_at',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::deleting(function ($profile) {
            if ($profile->surat_pengajuan_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($profile->surat_pengajuan_path);
            }
        });
    }

    protected function casts(): array
    {
        return [
            'is_approved_by_admin' => 'boolean',
            'approved_by_admin_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
