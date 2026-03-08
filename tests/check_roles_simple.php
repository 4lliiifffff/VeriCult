<?php

use Spatie\Permission\Models\Role;

$roles = Role::all();
foreach ($roles as $role) {
    echo $role->id . ':' . $role->name . PHP_EOL;
}
