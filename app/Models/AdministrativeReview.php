<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdministrativeReview extends Model
{
    /**
     * Action constants
     */
    const ACTION_FORWARDED = 'forwarded';
    const ACTION_REVISION = 'revision';
    const ACTION_REJECTED = 'rejected';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'submission_id',
        'validator_id',
        'action',
        'notes',
    ];

    /**
     * Get the submission that this review belongs to.
     */
    public function submission(): BelongsTo
    {
        return $this->belongsTo(CulturalSubmission::class, 'submission_id');
    }

    /**
     * Get the validator who performed this review.
     */
    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validator_id');
    }
}
