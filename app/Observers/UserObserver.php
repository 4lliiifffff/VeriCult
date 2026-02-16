<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'model_type' => get_class($user),
            'model_id' => $user->id,
            'new_data' => $user->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        $oldData = $user->getOriginal();
        $newData = $user->getChanges();

        // Exclude sensitive or unneeded fields from diff
        unset($oldData['password'], $oldData['remember_token'], $newData['updated_at']);
        
        // Only log if meaningful changes occurred
        if (empty($newData)) {
            return;
        }

        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'model_type' => get_class($user),
            'model_id' => $user->id,
            'old_data' => $oldData,
            'new_data' => $newData,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'model_type' => get_class($user),
            'model_id' => $user->id,
            'old_data' => $user->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'restored',
            'model_type' => get_class($user),
            'model_id' => $user->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
