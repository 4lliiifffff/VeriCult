<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        // Update 'pengusul' role ID from 4 to 3 if it exists as 4 and 3 is free
        DB::table('roles')->where('id', 4)->update(['id' => 3]);
        DB::table('model_has_roles')->where('role_id', 4)->update(['role_id' => 3]);

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        // Revert 'pengusul' role ID from 3 back to 4
        DB::table('roles')->where('id', 3)->update(['id' => 4]);
        DB::table('model_has_roles')->where('role_id', 3)->update(['role_id' => 4]);

        Schema::enableForeignKeyConstraints();
    }
};
