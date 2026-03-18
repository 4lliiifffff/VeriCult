<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change enum column to string first to allow new values
        Schema::table('cultural_submissions', function (Blueprint $table) {
            $table->string('submission_type')->change();
        });

        // Update existing data
        DB::table('cultural_submissions')->where('submission_type', 'opk')->update(['submission_type' => 'statistik']);
        DB::table('cultural_submissions')->where('submission_type', 'active_culture')->update(['submission_type' => 'aktif']);

        // Remove columns
        Schema::table('cultural_submissions', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cultural_submissions', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Revert data
            DB::table('cultural_submissions')->where('submission_type', 'statistik')->update(['submission_type' => 'opk']);
            DB::table('cultural_submissions')->where('submission_type', 'aktif')->update(['submission_type' => 'active_culture']);
        });
    }
};
