<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->unique();

            // Status & Governance (all roles)
            $table->boolean('is_suspended')->default(false);
            $table->timestamp('suspended_at')->nullable();

            // Admin approval (pengusul-desa specific)
            $table->boolean('is_approved_by_admin')->nullable();
            $table->timestamp('approved_by_admin_at')->nullable();

            // Village association (pengusul-desa)
            $table->foreignId('village_id')->nullable()->constrained()->onDelete('set null');
            $table->string('jabatan_desa')->nullable(); // ex: Kepala Desa, Sekdes

            // Future extensible fields
            $table->string('nip')->nullable();       // for validator / admin PNS
            $table->string('instansi')->nullable();  // for validator / super-admin
            $table->string('no_hp')->nullable();     // all roles

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};

