<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

echo "Checking Users and Roles...\n";

$users = User::with('roles')->latest()->take(5)->get();

foreach ($users as $user) {
    echo "User: " . $user->name . " (ID: " . $user->id . ")\n";
    echo "  Column 'role': " . ($user->role ?? 'N/A') . "\n";
    echo "  Spatie Roles count: " . $user->roles->count() . "\n";
    if ($user->roles->count() > 0) {
        foreach ($user->roles as $role) {
            echo "    - " . $role->name . "\n";
        }
    } else {
        echo "    - No Spatie roles assigned.\n";
    }
    echo "--------------------------------\n";
}

echo "Total Roles in DB: " . Role::count() . "\n";
$roles = Role::all();
foreach($roles as $r) {
    echo " - " . $r->name . "\n";
}
