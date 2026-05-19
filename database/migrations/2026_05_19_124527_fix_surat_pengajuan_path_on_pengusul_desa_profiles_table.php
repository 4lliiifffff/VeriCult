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
        Schema::table('pengusul_desa_profiles', function (Blueprint $table) {
            $table->string('surat_pengajuan_path')->nullable()->after('no_hp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengusul_desa_profiles', function (Blueprint $table) {
            $table->dropColumn('surat_pengajuan_path');
        });
    }
};
