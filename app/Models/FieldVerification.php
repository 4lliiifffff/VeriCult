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
        'notes',
        'recommendation',
    ];

    protected $casts = [
        'visit_date' => 'date',
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
