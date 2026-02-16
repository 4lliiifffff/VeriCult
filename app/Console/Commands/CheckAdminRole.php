<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class CheckAdminRole extends Command
{
    protected $signature = 'auth:check-admin';
    protected $description = 'Check usages of admin role';

    public function handle()
    {
        $roleName = 'admin';
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            $this->error("Role '$roleName' does not exist.");
            return;
        }

        $count = User::role($roleName)->count();
        $this->info("Role '$roleName' exists.");
        $this->info("Users with this role: $count");

        if ($count > 0) {
            $this->info("List of users:");
            foreach (User::role($roleName)->get() as $user) {
                $this->line("- {$user->name} ({$user->email})");
            }
        }
    }
}
