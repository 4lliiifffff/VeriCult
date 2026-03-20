<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, change columns to string to allow temporary values
        Schema::table('administrative_reviews', function (Blueprint $table) {
            $table->string('action')->change();
        });

        DB::table('administrative_reviews')->where('action', 'disetujui')->update(['action' => 'forwarded']);
        DB::table('administrative_reviews')->where('action', 'revisi')->update(['action' => 'revision']);
        DB::table('administrative_reviews')->where('action', 'ditolak')->update(['action' => 'rejected']);

        Schema::table('administrative_reviews', function (Blueprint $table) {
            $table->enum('action', ['forwarded', 'revision', 'rejected'])->change();
        });

        // Field verifications
        Schema::table('field_verifications', function (Blueprint $table) {
            $table->string('recommendation')->change();
        });

        DB::table('field_verifications')->where('recommendation', 'diverifikasi')->update(['recommendation' => 'verified']);
        DB::table('field_verifications')->where('recommendation', 'revisi')->update(['recommendation' => 'revision']);
        DB::table('field_verifications')->where('recommendation', 'ditolak')->update(['recommendation' => 'rejected']);

        Schema::table('field_verifications', function (Blueprint $table) {
            $table->enum('recommendation', ['verified', 'rejected', 'revision'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('administrative_reviews', function (Blueprint $table) {
            $table->string('action')->change();
        });

        DB::table('administrative_reviews')->where('action', 'forwarded')->update(['action' => 'disetujui']);
        DB::table('administrative_reviews')->where('action', 'revision')->update(['action' => 'revisi']);
        DB::table('administrative_reviews')->where('action', 'rejected')->update(['action' => 'ditolak']);

        Schema::table('administrative_reviews', function (Blueprint $table) {
            $table->enum('action', ['disetujui', 'ditolak', 'revisi'])->change();
        });

        Schema::table('field_verifications', function (Blueprint $table) {
            $table->string('recommendation')->change();
        });

        DB::table('field_verifications')->where('recommendation', 'verified')->update(['recommendation' => 'diverifikasi']);
        DB::table('field_verifications')->where('recommendation', 'revision')->update(['recommendation' => 'revisi']);
        DB::table('field_verifications')->where('recommendation', 'rejected')->update(['recommendation' => 'ditolak']);

        Schema::table('field_verifications', function (Blueprint $table) {
            $table->enum('recommendation', ['diverifikasi', 'ditolak', 'revisi'])->change();
        });
    }
};
