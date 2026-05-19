<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengusulProfile extends Model
{
    protected $fillable = [
        'user_id',
        'proposer_type',
        'instansi',
        'no_hp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
