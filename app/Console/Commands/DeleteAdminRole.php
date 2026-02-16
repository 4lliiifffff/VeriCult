<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class DeleteAdminRole extends Command
{
    protected $signature = 'auth:delete-admin';
    protected $description = 'Delete the admin role';

    public function handle()
    {
        $roleName = 'admin';
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            $this->warn("Role '$roleName' does not exist.");
            return;
        }

        if ($role->users()->count() > 0) {
            $this->error("Cannot delete role '$roleName'. It has assigned users.");
            return;
        }

        $role->delete();
        $this->info("Role '$roleName' has been deleted successfully.");
    }
}
