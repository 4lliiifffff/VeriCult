<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Copy user-level attributes into user_profiles.
     * Creates a profile row for every existing user.
     */
    public function up(): void
    {
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            DB::table('user_profiles')->insert([
                'user_id'               => $user->id,
                'is_suspended'          => $user->is_suspended ?? false,
                'suspended_at'          => $user->suspended_at ?? null,
                'is_approved_by_admin'  => $user->is_approved_by_admin ?? null,
                'approved_by_admin_at'  => $user->approved_by_admin_at ?? null,
                'village_id'            => $user->village_id ?? null,
                'jabatan_desa'          => null,
                'nip'                   => null,
                'instansi'              => null,
                'no_hp'                 => null,
                'created_at'            => now(),
                'updated_at'            => now(),
            ]);
        }
    }

    public function down(): void
    {
        // On rollback: just truncate profiles (the previous migration drop will handle the rest)
        DB::table('user_profiles')->truncate();
    }
};
