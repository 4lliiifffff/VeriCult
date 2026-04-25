<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidatorProfile extends Model
{
    protected $fillable = [
        'user_id',
        'instansi',
        'no_hp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
