<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kecamatan;
use App\Models\Village;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Give each village a valid kecamatan_id
        $kecamatanSubang = Kecamatan::where('name', 'Subang')->first() ?? Kecamatan::first();

        $villages = [
            'Cidahu',
            'Sukamaju',
            'Karanganyar',
            'Mekarsari',
            'Bojongloa',
        ];

        foreach ($villages as $name) {
            Village::firstOrCreate(
                ['name' => $name],
                ['kecamatan_id' => $kecamatanSubang ? $kecamatanSubang->id : null]
            );
        }
    }
}
