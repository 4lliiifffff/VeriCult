<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kecamatan;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecamatans = [
            'Binong',
            'Blanakan',
            'Ciasem',
            'Ciater',
            'Cibogo',
            'Cijambe',
            'Cikaum',
            'Cipeundeuy',
            'Cipunagara',
            'Cisalak',
            'Compreng',
            'Dawuan',
            'Jalancagak',
            'Kalijati',
            'Kasomalang',
            'Legonkulon',
            'Pabuaran',
            'Pagaden',
            'Pagaden Barat',
            'Pamanukan',
            'Patokbeusi',
            'Purwadadi',
            'Pusakajaya',
            'Pusakanagara',
            'Sagalaherang',
            'Serangpanjang',
            'Subang',
            'Sukasari',
            'Tambakdahan',
            'Tanjungsiang',
        ];

        foreach ($kecamatans as $kecamatan) {
            Kecamatan::firstOrCreate(['name' => $kecamatan]);
        }
    }
}
