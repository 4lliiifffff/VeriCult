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
     */
    public function create(User $user): bool
    {
        return $user->hasRole('pengusul');
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
        return $user->hasRole('validator') && $submission->canBeClaimed();
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
               $submission->status === CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW && 
               $submission->reviewed_by === $user->id;
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
