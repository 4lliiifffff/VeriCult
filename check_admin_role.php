<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

$roleName = 'admin';
$role = Role::where('name', $roleName)->first();

if (!$role) {
    echo "Role '$roleName' does not exist.\n";
    exit;
}

$count = User::role($roleName)->count();
echo "Role '$roleName' exists.\n";
echo "Users with this role: $count\n";

if ($count > 0) {
    echo "List of users:\n";
    foreach (User::role($roleName)->get() as $user) {
        echo "- {$user->name} ({$user->email})\n";
    }
}
