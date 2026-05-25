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
        Schema::table('cultural_submissions', function (Blueprint $table) {
            if (Schema::hasColumn('cultural_submissions', 'latitude')) {
                $table->dropColumn('latitude');
            }
            if (Schema::hasColumn('cultural_submissions', 'longitude')) {
                $table->dropColumn('longitude');
            }
        });

        Schema::table('field_verifications', function (Blueprint $table) {
            if (Schema::hasColumn('field_verifications', 'verified_latitude')) {
                $table->dropColumn('verified_latitude');
            }
            if (Schema::hasColumn('field_verifications', 'verified_longitude')) {
                $table->dropColumn('verified_longitude');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cultural_submissions', function (Blueprint $table) {
            if (!Schema::hasColumn('cultural_submissions', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable();
            }
            if (!Schema::hasColumn('cultural_submissions', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable();
            }
        });

        Schema::table('field_verifications', function (Blueprint $table) {
            if (!Schema::hasColumn('field_verifications', 'verified_latitude')) {
                $table->decimal('verified_latitude', 10, 8)->nullable();
            }
            if (!Schema::hasColumn('field_verifications', 'verified_longitude')) {
                $table->decimal('verified_longitude', 11, 8)->nullable();
            }
        });
    }
};
