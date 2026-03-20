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
        Schema::table('administrative_reviews', function (Blueprint $table) {
            $table->enum('action', ['forwarded', 'revision', 'rejected', 'verified'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('administrative_reviews', function (Blueprint $table) {
            $table->enum('action', ['forwarded', 'revision', 'rejected'])->change();
        });
    }
};
