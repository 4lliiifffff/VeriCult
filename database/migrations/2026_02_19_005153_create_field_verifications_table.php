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
        Schema::create('field_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('cultural_submissions')->onDelete('cascade');
            $table->foreignId('validator_id')->constrained('users')->onDelete('cascade');
            $table->date('visit_date');
            $table->decimal('verified_latitude', 10, 8)->nullable();
            $table->decimal('verified_longitude', 11, 8)->nullable();
            $table->text('notes');
            $table->enum('recommendation', ['verified', 'rejected', 'revision']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_verifications');
    }
};
