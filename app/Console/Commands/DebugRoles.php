<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DebugRoles extends Command
{
    protected $signature = 'debug:roles';
    protected $description = 'Debug user roles';

    public function handle()
    {
        $this->info("Checking Users and Roles...");

        $users = User::with('roles')->latest()->take(5)->get();

        foreach ($users as $user) {
            $this->line("User: " . $user->name . " (ID: " . $user->id . ")");
            $this->line("  Column 'role': " . ($user->role ?? 'N/A'));
            $this->line("  Spatie Roles count: " . $user->roles->count());
            
            if ($user->roles->count() > 0) {
                foreach ($user->roles as $role) {
                    $this->info("    - " . $role->name);
                }
            } else {
                $this->warn("    - No Spatie roles assigned.");
            }
            $this->line("--------------------------------");
        }

        $this->info("Total Roles in DB: " . Role::count());
        $roles = Role::all();
        foreach($roles as $r) {
            $this->line(" - " . $r->name);
        }
    }
}
