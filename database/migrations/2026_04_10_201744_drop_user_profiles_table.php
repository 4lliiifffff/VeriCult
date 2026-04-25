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
        Schema::dropIfExists('user_profiles');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_suspended')->default(false);
            $table->timestamp('suspended_at')->nullable();
            $table->boolean('is_approved_by_admin')->default(false);
            $table->timestamp('approved_by_admin_at')->nullable();
            $table->foreignId('village_id')->nullable()->constrained()->onDelete('set null');
            $table->string('jabatan_desa')->nullable();
            $table->string('nip')->nullable();
            $table->string('instansi')->nullable();
            $table->string('no_hp')->nullable();
            $table->timestamps();
        });
    }
};
