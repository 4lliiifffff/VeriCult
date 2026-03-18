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
        // 1. administrative_reviews table (uses 'action' column)
        Schema::table('administrative_reviews', function (Blueprint $table) {
            $table->string('action')->change();
        });

        $adminReplacements = [
            'forwarded' => 'disetujui',
            'rejected' => 'ditolak',
            'revision' => 'revisi'
        ];

        foreach ($adminReplacements as $old => $new) {
            DB::table('administrative_reviews')->where('action', $old)->update(['action' => $new]);
        }

        Schema::table('administrative_reviews', function (Blueprint $table) {
            $table->enum('action', ['disetujui', 'ditolak', 'revisi'])->change();
        });

        // 2. field_verifications table (uses 'recommendation' column)
        Schema::table('field_verifications', function (Blueprint $table) {
            $table->string('recommendation')->change();
        });

        $fieldReplacements = [
            'verified' => 'diverifikasi',
            'rejected' => 'ditolak',
            'revision' => 'revisi'
        ];

        foreach ($fieldReplacements as $old => $new) {
            DB::table('field_verifications')->where('recommendation', $old)->update(['recommendation' => $new]);
        }

        Schema::table('field_verifications', function (Blueprint $table) {
            $table->enum('recommendation', ['diverifikasi', 'ditolak', 'revisi'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse for administrative_reviews
        Schema::table('administrative_reviews', function (Blueprint $table) {
            $table->string('action')->change();
        });

        $adminReverse = [
            'disetujui' => 'forwarded',
            'ditolak' => 'rejected',
            'revisi' => 'revision'
        ];

        foreach ($adminReverse as $old => $new) {
            DB::table('administrative_reviews')->where('action', $old)->update(['action' => $new]);
        }

        Schema::table('administrative_reviews', function (Blueprint $table) {
            $table->enum('action', ['forwarded', 'rejected', 'revision'])->change();
        });

        // Reverse for field_verifications
        Schema::table('field_verifications', function (Blueprint $table) {
            $table->string('recommendation')->change();
        });

        $fieldReverse = [
            'diverifikasi' => 'verified',
            'ditolak' => 'rejected',
            'revisi' => 'revision'
        ];

        foreach ($fieldReverse as $old => $new) {
            DB::table('field_verifications')->where('recommendation', $old)->update(['recommendation' => $new]);
        }

        Schema::table('field_verifications', function (Blueprint $table) {
            $table->enum('recommendation', ['verified', 'rejected', 'revision'])->change();
        });
    }
};
