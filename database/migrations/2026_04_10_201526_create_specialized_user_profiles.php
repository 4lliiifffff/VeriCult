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
        Schema::create('super_admin_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('admin_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('validator_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('instansi')->nullable();
            $table->string('no_hp')->nullable();
            $table->timestamps();
        });

        Schema::create('pengusul_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('instansi')->nullable();
            $table->string('no_hp')->nullable();
            $table->timestamps();
        });

        Schema::create('pengusul_desa_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('village_id')->nullable()->constrained()->onDelete('set null');
            $table->string('jabatan_desa')->nullable();
            $table->string('nip')->nullable();
            $table->string('no_hp')->nullable();
            $table->boolean('is_approved_by_admin')->default(false);
            $table->timestamp('approved_by_admin_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengusul_desa_profiles');
        Schema::dropIfExists('pengusul_profiles');
        Schema::dropIfExists('validator_profiles');
        Schema::dropIfExists('admin_profiles');
        Schema::dropIfExists('super_admin_profiles');
    }
};
