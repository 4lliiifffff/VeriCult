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
        $users = Illuminate\Support\Facades\DB::table('users')->get();
        $userProfiles = Illuminate\Support\Facades\DB::table('user_profiles')->get()->keyBy('user_id');

        foreach ($users as $user) {
            $profile = $userProfiles->get($user->id);
            if (!$profile) continue;

            // Move suspension status to users table
            Illuminate\Support\Facades\DB::table('users')->where('id', $user->id)->update([
                'is_suspended' => $profile->is_suspended,
                'suspended_at' => $profile->suspended_at,
            ]);

            // Get user role
            $role = Illuminate\Support\Facades\DB::table('model_has_roles')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->where('model_id', $user->id)
                ->where('model_type', 'App\Models\User')
                ->value('name');

            if ($role === 'super-admin') {
                Illuminate\Support\Facades\DB::table('super_admin_profiles')->insert(['user_id' => $user->id, 'created_at' => now(), 'updated_at' => now()]);
            } elseif ($role === 'admin') {
                Illuminate\Support\Facades\DB::table('admin_profiles')->insert(['user_id' => $user->id, 'created_at' => now(), 'updated_at' => now()]);
            } elseif ($role === 'validator') {
                Illuminate\Support\Facades\DB::table('validator_profiles')->insert([
                    'user_id' => $user->id,
                    'instansi' => $profile->instansi,
                    'no_hp' => $profile->no_hp,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } elseif ($role === 'pengusul') {
                Illuminate\Support\Facades\DB::table('pengusul_profiles')->insert([
                    'user_id' => $user->id,
                    'instansi' => $profile->instansi,
                    'no_hp' => $profile->no_hp,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } elseif ($role === 'pengusul-desa') {
                Illuminate\Support\Facades\DB::table('pengusul_desa_profiles')->insert([
                    'user_id' => $user->id,
                    'village_id' => $profile->village_id,
                    'jabatan_desa' => $profile->jabatan_desa,
                    'nip' => $profile->nip,
                    'no_hp' => $profile->no_hp,
                    'is_approved_by_admin' => $profile->is_approved_by_admin,
                    'approved_by_admin_at' => $profile->approved_by_admin_at,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Illuminate\Support\Facades\DB::table('super_admin_profiles')->truncate();
        Illuminate\Support\Facades\DB::table('admin_profiles')->truncate();
        Illuminate\Support\Facades\DB::table('validator_profiles')->truncate();
        Illuminate\Support\Facades\DB::table('pengusul_profiles')->truncate();
        Illuminate\Support\Facades\DB::table('pengusul_desa_profiles')->truncate();
    }
};
