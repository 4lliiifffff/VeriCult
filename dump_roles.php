<?php

use Spatie\Permission\Models\Role;

$roles = Role::all();
$output = "";
foreach ($roles as $role) {
    $output .= "ID: " . $role->id . " - Name: " . $role->name . "\n";
}
file_put_contents('roles_dump.txt', $output);
