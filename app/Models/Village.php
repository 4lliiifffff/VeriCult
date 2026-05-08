<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Village extends Model
{
    protected $fillable = ['name', 'kecamatan_id'];

    /**
     * Kecamatan tempat desa ini berada.
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }

    /**
     * Pengguna (perwakilan desa) yang terdaftar di desa ini.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Pengajuan kebudayaan yang berasal dari desa ini.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(CulturalSubmission::class);
    }
}
