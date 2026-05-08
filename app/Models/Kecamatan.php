<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    protected $fillable = ['name'];

    /**
     * Desa-desa yang tergabung dalam kecamatan ini.
     */
    public function villages(): HasMany
    {
        return $this->hasMany(Village::class);
    }
}
