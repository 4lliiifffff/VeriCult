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
            $table->enum('submission_type', ['opk', 'active_culture'])->default('opk')->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cultural_submissions', function (Blueprint $table) {
            $table->dropColumn('submission_type');
        });
    }
};
