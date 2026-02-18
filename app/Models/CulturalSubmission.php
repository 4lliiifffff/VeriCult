<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CulturalSubmission extends Model
{
    /**
     * Status constants
     */
    const STATUS_DRAFT = 'draft';
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_ADMINISTRATIVE_REVIEW = 'administrative_review';
    const STATUS_FIELD_VERIFICATION = 'field_verification';
    const STATUS_VERIFIED = 'verified';
    const STATUS_PUBLISHED = 'published';
    const STATUS_REJECTED = 'rejected';
    const STATUS_REVISION = 'revision';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'category',
        'description',
        'address',
        'latitude',
        'longitude',
        'status',
        'submitted_at',
        'verified_at',
        'published_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'submitted_at' => 'datetime',
            'verified_at' => 'datetime',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the submission.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the files for the submission.
     */
    public function files(): HasMany
    {
        return $this->hasMany(SubmissionFile::class);
    }

    /**
     * Get the validator who is currently reviewing the submission.
     */
    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Get the administrative reviews for the submission.
     */
    public function administrativeReviews(): HasMany
    {
        return $this->hasMany(AdministrativeReview::class, 'submission_id');
    }

    /**
     * Get the field verifications for the submission.
     */
    public function fieldVerifications(): HasMany
    {
        return $this->hasMany(FieldVerification::class, 'submission_id');
    }

    /**
     * Scope to filter by status.
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get submissions in review (submitted, admin review, field verification).
     */
    public function scopeInReview($query)
    {
        return $query->whereIn('status', [
            self::STATUS_SUBMITTED,
            self::STATUS_ADMINISTRATIVE_REVIEW,
            self::STATUS_FIELD_VERIFICATION,
        ]);
    }

    /**
     * Scope to get only authenticated user's submissions.
     */
    public function scopeOwnedBy($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Check if submission can be edited.
     */
    public function isEditable(): bool
    {
        return in_array($this->status, [self::STATUS_DRAFT, self::STATUS_REVISION]);
    }

    /**
     * Check if submission can be submitted.
     */
    public function canBeSubmitted(): bool
    {
        return in_array($this->status, [self::STATUS_DRAFT, self::STATUS_REVISION]);
    }

    /**
     * Check if the submission can be claimed for review.
     */
    public function canBeClaimed(): bool
    {
        return $this->status === self::STATUS_SUBMITTED && is_null($this->reviewed_by);
    }

    /**
     * Check if the submission can be unclaimed.
     */
    public function canBeUnclaimed(int $userId): bool
    {
        return $this->status === self::STATUS_ADMINISTRATIVE_REVIEW && $this->reviewed_by === $userId;
    }

    /**
     * Get human-readable status name.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_SUBMITTED => 'Submitted',
            self::STATUS_ADMINISTRATIVE_REVIEW => 'Administrative Review',
            self::STATUS_FIELD_VERIFICATION => 'Field Verification',
            self::STATUS_VERIFIED => 'Verified',
            self::STATUS_PUBLISHED => 'Published',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_REVISION => 'Needs Revision',
            default => 'Unknown',
        };
    }

    /**
     * Get status badge color class.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_DRAFT => 'gray',
            self::STATUS_REVISION => 'amber',
            self::STATUS_SUBMITTED => 'blue',
            self::STATUS_ADMINISTRATIVE_REVIEW, self::STATUS_FIELD_VERIFICATION => 'indigo',
            self::STATUS_VERIFIED => 'emerald',
            self::STATUS_PUBLISHED => 'green',
            self::STATUS_REJECTED => 'red',
            default => 'gray',
        };
    }
}
