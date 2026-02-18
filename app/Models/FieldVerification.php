<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FieldVerification extends Model
{
    protected $fillable = [
        'submission_id',
        'validator_id',
        'visit_date',
        'verified_latitude',
        'verified_longitude',
        'notes',
        'recommendation',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'verified_latitude' => 'decimal:8',
        'verified_longitude' => 'decimal:8',
    ];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(CulturalSubmission::class, 'submission_id');
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validator_id');
    }
}
