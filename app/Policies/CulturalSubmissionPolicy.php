<?php

namespace App\Policies;

use App\Models\CulturalSubmission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CulturalSubmissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('pengusul') || $user->hasRole('super-admin') || $user->hasRole('validator');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CulturalSubmission $submission): bool
    {
        return $user->id == $submission->user_id || $user->hasRole('super-admin') || $user->hasRole('validator');
    }

    /**
     * Determine whether the user can create models.
     *
     * pengusul: can only create aktif submissions
     * pengusul-desa: can create both statistik and aktif submissions
     */
    public function create(User $user, string $submissionType = 'aktif'): bool
    {
        // Regular pengusul can only submit active culture
        if ($user->hasRole('pengusul') && !$user->hasRole('pengusul-desa')) {
            return $submissionType === 'aktif';
        }

        // pengusul-desa can submit both types (if approved)
        if ($user->hasRole('pengusul-desa')) {
            // Check if pengusul-desa is approved
            if (!$user->is_approved_by_admin) {
                return false;
            }
            return in_array($submissionType, ['statistik', 'aktif']);
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CulturalSubmission $submission): bool
    {
        return $user->id == $submission->user_id && $submission->isEditable();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CulturalSubmission $submission): bool
    {
        return $user->id == $submission->user_id && $submission->status == CulturalSubmission::STATUS_DRAFT;
    }

    /**
     * Determine whether the user can claim the mission.
     */
    public function claim(User $user, CulturalSubmission $submission): bool
    {
        return $user->hasRole('validator') &&
               ($submission->canBeClaimed() || $submission->reviewed_by == $user->id);
    }

    /**
     * Determine whether the user can unclaim the mission.
     */
    public function unclaim(User $user, CulturalSubmission $submission): bool
    {
        return $user->hasRole('validator') && $submission->canBeUnclaimed($user->id);
    }

    /**
     * Determine whether the user can review the mission.
     */
    public function review(User $user, CulturalSubmission $submission): bool
    {
        return $user->hasRole('validator') &&
               in_array($submission->status, [
                   CulturalSubmission::STATUS_SUBMITTED,
                   CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW,
                   CulturalSubmission::STATUS_FIELD_VERIFICATION
               ]) &&
               $submission->reviewed_by === $user->id;
    }

    /**
     * Determine whether the user can publish the submission.
     */
    public function publish(User $user, CulturalSubmission $submission): bool
    {
        return $user->hasRole('validator') && $submission->status === CulturalSubmission::STATUS_VERIFIED;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CulturalSubmission $submission): bool
    {
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function permanentDelete(User $user, CulturalSubmission $submission): bool
    {
        return $user->hasRole('super-admin');
    }
}
