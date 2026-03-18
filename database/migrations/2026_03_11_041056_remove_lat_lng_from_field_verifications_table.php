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
        Schema::table('field_verifications', function (Blueprint $table) {
            $table->dropColumn(['verified_latitude', 'verified_longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('field_verifications', function (Blueprint $table) {
            $table->decimal('verified_latitude', 10, 8)->nullable();
            $table->decimal('verified_longitude', 11, 8)->nullable();
        });
    }
};
