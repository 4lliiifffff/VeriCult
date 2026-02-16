<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class CheckRoleIds extends Command
{
    protected $signature = 'debug:role-ids';
    protected $description = 'Check role IDs and assignments';

    public function handle()
    {
        $output = "Current Roles:\n";
        $roles = Role::all();
        foreach ($roles as $role) {
            $output .= "ID: " . $role->id . " - Name: " . $role->name . "\n";
        }

        $output .= "\nRole Assignments (model_has_roles):\n";
        $assignments = DB::table('model_has_roles')->orderBy('role_id')->get();
        foreach ($assignments as $a) {
            $output .= "Role ID: " . $a->role_id . " - Model ID: " . $a->model_id . "\n";
        }
        
        file_put_contents(base_path('roles_dump.txt'), $output);
        $this->info("Roles dumped to roles_dump.txt");
    }
}
