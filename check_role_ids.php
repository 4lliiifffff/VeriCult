<?php

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

$roles = Role::all();
echo "Current Roles:\n";
foreach ($roles as $role) {
    echo "ID: " . $role->id . " - Name: " . $role->name . "\n";
}

$assignments = DB::table('model_has_roles')->get();
echo "\nRole Assignments (model_has_roles):\n";
foreach ($assignments as $a) {
    echo "Role ID: " . $a->role_id . " - Model ID: " . $a->model_id . "\n";
}
