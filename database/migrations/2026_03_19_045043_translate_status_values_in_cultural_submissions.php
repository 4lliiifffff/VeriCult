<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First change to string (or add the new values to enum if supported, but string is safer)
        Schema::table('cultural_submissions', function (Blueprint $table) {
            $table->string('status')->change();
        });

        $translations = [
            'draft' => 'draf',
            'submitted' => 'diajukan',
            'administrative_review' => 'tinjauan_administratif',
            'field_verification' => 'verifikasi_lapangan',
            'verified' => 'diverifikasi',
            'published' => 'diterbitkan',
            'rejected' => 'ditolak',
            'revision' => 'revisi',
        ];

        foreach ($translations as $old => $new) {
            DB::table('cultural_submissions')
                ->where('status', $old)
                ->update(['status' => $new]);
        }

        // Change back to enum with new values
        Schema::table('cultural_submissions', function (Blueprint $table) {
            $table->enum('status', [
                'draf', 'diajukan', 'tinjauan_administratif', 'verifikasi_lapangan',
                'diverifikasi', 'diterbitkan', 'ditolak', 'revisi'
            ])->default('draf')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cultural_submissions', function (Blueprint $table) {
            $table->string('status')->change();
        });

        $translations = [
            'draf' => 'draft',
            'diajukan' => 'submitted',
            'tinjauan_administratif' => 'administrative_review',
            'verifikasi_lapangan' => 'field_verification',
            'diverifikasi' => 'verified',
            'diterbitkan' => 'published',
            'ditolak' => 'rejected',
            'revisi' => 'revision',
        ];

        foreach ($translations as $old => $new) {
            DB::table('cultural_submissions')
                ->where('status', $old)
                ->update(['status' => $new]);
        }

        Schema::table('cultural_submissions', function (Blueprint $table) {
            $table->enum('status', [
                'draft', 'submitted', 'administrative_review', 'field_verification',
                'verified', 'published', 'rejected', 'revision'
            ])->default('draft')->change();
        });
    }
};
