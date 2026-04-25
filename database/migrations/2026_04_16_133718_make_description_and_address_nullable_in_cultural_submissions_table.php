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
            $table->text('description')->nullable()->change();
            $table->string('address')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cultural_submissions', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
        });
    }
};
