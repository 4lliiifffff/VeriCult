<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class SyncUserRoles extends Command
{
    protected $signature = 'auth:sync-roles';
    protected $description = 'Sync legacy user role column to Spatie roles';

    public function handle()
    {
        $this->info("Starting role synchronization...");

        $users = User::all();
        $count = 0;

        foreach ($users as $user) {
            $roleName = $user->role; // Access legacy column
            
            if (empty($roleName)) {
                $this->warn("User {$user->email} has no role defined in column.");
                continue;
            }

            // Check if role exists in Spatie
            if (!Role::where('name', $roleName)->exists()) {
                $this->error("Role '{$roleName}' does not exist in roles table. Skipping user {$user->email}.");
                continue;
            }

            // Assign role if not already assigned
            if (!$user->hasRole($roleName)) {
                $user->assignRole($roleName);
                $this->info("Assigned role '{$roleName}' to user {$user->email}.");
                $count++;
            } else {
                $this->line("User {$user->email} already has role '{$roleName}'.");
            }
        }

        $this->info("Synchronization complete. Updated {$count} users.");
    }
}
