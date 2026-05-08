<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('villages', function (Blueprint $table) {
            $table->foreignId('kecamatan_id')
                ->nullable()
                ->after('id')
                ->constrained('kecamatans')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('villages', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Kecamatan::class);
            $table->dropColumn('kecamatan_id');
        });
    }
};
