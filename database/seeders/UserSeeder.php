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
            ['email' => 'admin@vericult.co.id'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('Admin123'),
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole('super-admin');

        // 2. Admin Wilayah
        $admin = User::firstOrCreate(
            ['email' => 'admin_wilayah@vericult.co.id'],
            [
                'name' => 'Admin Wilayah',
                'password' => Hash::make('Admin123'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

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
                ['village_id' => $village->id]
            );
            
            // Note: If user status is managed via a field on the user model, we might need to add it differently,
            // but the `status` column doesn't seem to exist on the base User model according to the error.
        }
    }
}
