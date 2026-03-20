<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Remove columns from users table that have been moved to user_profiles.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Must drop foreign key constraints before dropping columns
            $table->dropForeign(['village_id']);
            $table->dropColumn([
                'is_suspended',
                'suspended_at',
                'is_approved_by_admin',
                'approved_by_admin_at',
                'village_id',
                'role',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_suspended')->default(false)->after('password');
            $table->timestamp('suspended_at')->nullable()->after('is_suspended');
            $table->boolean('is_approved_by_admin')->default(true)->after('suspended_at');
            $table->timestamp('approved_by_admin_at')->nullable()->after('is_approved_by_admin');
            $table->foreignId('village_id')->nullable()->constrained()->onDelete('set null')->after('approved_by_admin_at');
            $table->string('role')->nullable()->after('password');
        });
    }
};
