<?php

namespace App\Observers;

use App\Models\AuditLog;
use App\Models\CulturalSubmission;

class CulturalSubmissionObserver
{
    /**
     * Handle the CulturalSubmission "created" event.
     * Fires when a new draft/submission is saved for the first time.
     */
    public function created(CulturalSubmission $submission): void
    {
        AuditLog::create([
            'user_id'    => auth()->check() ? auth()->id() : null,
            'action'     => 'submission_created',
            'model_type' => CulturalSubmission::class,
            'model_id'   => $submission->id,
            'new_data'   => [
                'name'            => $submission->name,
                'category'        => $submission->category,
                'submission_type' => $submission->submission_type,
                'status'          => $submission->status,
                'period_year'     => $submission->period_year,
                'user_id'         => $submission->user_id,
            ],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Handle the CulturalSubmission "updated" event.
     * Fires on any update including status transitions (submit, claim, review, publish).
     */
    public function updated(CulturalSubmission $submission): void
    {
        $changed = $submission->getChanges();

        // Skip pure timestamp-only updates that carry no meaningful information
        $meaningfulKeys = array_diff(array_keys($changed), ['updated_at']);
        if (empty($meaningfulKeys)) {
            return;
        }

        // Build a human-readable action label based on the status change
        $action = 'submission_updated';
        if (isset($changed['status'])) {
            $action = match ($changed['status']) {
                CulturalSubmission::STATUS_SUBMITTED             => 'submission_submitted',
                CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW => 'submission_claimed_for_review',
                CulturalSubmission::STATUS_FIELD_VERIFICATION    => 'submission_forwarded_to_field',
                CulturalSubmission::STATUS_REVISION              => 'submission_needs_revision',
                CulturalSubmission::STATUS_REJECTED              => 'submission_rejected',
                CulturalSubmission::STATUS_VERIFIED              => 'submission_verified',
                CulturalSubmission::STATUS_PUBLISHED             => 'submission_published',
                default                                          => 'submission_status_changed',
            };
        }

        // Only keep relevant old fields for the diff
        $originalData = collect($submission->getOriginal())
            ->only($meaningfulKeys)
            ->except(['category_data', 'updated_at'])
            ->toArray();

        $newData = collect($changed)
            ->except(['category_data', 'updated_at'])
            ->toArray();

        // Always include name + status in new_data for readability in the log viewer
        $newData['name']   = $submission->name;
        $newData['status'] = $submission->status;

        AuditLog::create([
            'user_id'    => auth()->check() ? auth()->id() : null,
            'action'     => $action,
            'model_type' => CulturalSubmission::class,
            'model_id'   => $submission->id,
            'old_data'   => $originalData,
            'new_data'   => $newData,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Handle the CulturalSubmission "deleted" event.
     */
    public function deleted(CulturalSubmission $submission): void
    {
        AuditLog::create([
            'user_id'    => auth()->check() ? auth()->id() : null,
            'action'     => 'submission_deleted',
            'model_type' => CulturalSubmission::class,
            'model_id'   => $submission->id,
            'old_data'   => [
                'name'            => $submission->name,
                'category'        => $submission->category,
                'submission_type' => $submission->submission_type,
                'status'          => $submission->status,
                'user_id'         => $submission->user_id,
            ],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
