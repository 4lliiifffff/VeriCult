<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Village;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@vericult.co.id'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole('super-admin');
        \App\Models\SuperAdminProfile::firstOrCreate(['user_id' => $superAdmin->id]);

        // 2. Admin Wilayah
        $admin = User::firstOrCreate(
            ['email' => 'admin@vericult.co.id'],
            [
                'name' => 'Admin Wilayah',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');
        \App\Models\AdminProfile::firstOrCreate(['user_id' => $admin->id]);

        // 3. Validator
        $validator = User::firstOrCreate(
            ['email' => 'validator@vericult.co.id'],
            [
                'name' => 'Tim Validator Ahli',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $validator->assignRole('validator');
        \App\Models\ValidatorProfile::firstOrCreate(['user_id' => $validator->id]);

        // 4. Pengusul Umum
        $pengusul = User::firstOrCreate(
            ['email' => 'pengusul@vericult.co.id'],
            [
                'name' => 'Pengusul Masyarakat',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $pengusul->assignRole('pengusul');
        \App\Models\PengusulProfile::firstOrCreate(
            ['user_id' => $pengusul->id],
            ['proposer_type' => 'individu']
        );

        // 5. Pengusul Desa
        $village = Village::first(); // Ensure there is at least one village, or wait until after villages are seeded
        if ($village) {
            $pengusulDesa = User::firstOrCreate(
                ['email' => 'desa@vericult.co.id'],
                [
                    'name' => 'Perangkat Desa',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
            $pengusulDesa->assignRole('pengusul-desa');

            // Set user profile
            \App\Models\PengusulDesaProfile::updateOrCreate(
                ['user_id' => $pengusulDesa->id],
                [
                    'village_id' => $village->id,
                    'is_approved_by_admin' => true,
                    'approved_by_admin_at' => now(),
                ]
            );
        }
    }
}
