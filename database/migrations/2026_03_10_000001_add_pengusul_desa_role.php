<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create pengusul-desa role with same permissions as pengusul
        Role::firstOrCreate(['name' => 'pengusul-desa', 'guard_name' => 'web']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Delete the pengusul-desa role
        Role::where('name', 'pengusul-desa')->delete();
    }
};
