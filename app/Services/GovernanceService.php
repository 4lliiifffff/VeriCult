<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\AuditLog;

class GovernanceService
{
    /**
     * Suspend a user.
     */
    public function suspendUser(User $user, User $actor): void
    {
        if ($user->hasRole('super-admin')) {
            throw new \Exception('Cannot suspend a Super Admin.');
        }

        DB::transaction(function () use ($user, $actor) {
            $user->update([
                'is_suspended' => true,
                'suspended_at' => now(),
            ]);

            AuditLog::create([
                'user_id' => $actor->id,
                'action' => 'suspended_user',
                'model_type' => get_class($user),
                'model_id' => $user->id,
                'new_data' => ['is_suspended' => true, 'suspended_at' => now()],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });
    }

    /**
     * Unsuspend a user.
     */
    public function unsuspendUser(User $user, User $actor): void
    {
        DB::transaction(function () use ($user, $actor) {
            $user->update([
                'is_suspended' => false,
                'suspended_at' => null,
            ]);

            AuditLog::create([
                'user_id' => $actor->id,
                'action' => 'unsuspended_user',
                'model_type' => get_class($user),
                'model_id' => $user->id,
                'new_data' => ['is_suspended' => false],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });
    }
}
