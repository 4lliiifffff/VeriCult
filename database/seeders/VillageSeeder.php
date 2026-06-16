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
        $kecamatanDesa = [
            'Subang' => ['Cigadung', 'Karanganyar', 'Parung', 'Pasirkareumbi', 'Soklat', 'Sukamelang', 'Dangdeur', 'Wanareja'],
            'Cibogo' => ['Cibogo', 'Belendung', 'Padaasih', 'Sadawarna', 'Sumurbarang', 'Cidahu'],
            'Kalijati' => ['Kalijati Barat', 'Kalijati Timur', 'Marengmang', 'Tanggulun Barat', 'Bojongloa'],
            'Jalancagak' => ['Jalancagak', 'Tambakmekar', 'Bunihayu', 'Curugrendeng'],
            'Ciater' => ['Ciater', 'Sanca', 'Palasari', 'Cisaat'],
            'Pamanukan' => ['Pamanukan', 'Pamanukan Sebrang', 'Rancasari', 'Lengkongjaya'],
            'Blanakan' => ['Blanakan', 'Cilamaya Girang', 'Rawameneng', 'Muaracikadu'],
            'Ciasem' => ['Ciasem Hilir', 'Ciasem Tengah', 'Sukamandijaya', 'Pinangsari'],
            'Pagaden' => ['Pagaden', 'Sukamelang', 'Gunungsari', 'Gambarsari'],
            'Kasomalang' => ['Kasomalang Wetan', 'Kasomalang Kulon', 'Sindangsari', 'Tenjolaya'],
        ];

        foreach ($kecamatanDesa as $kecamatanName => $villages) {
            $kecamatan = Kecamatan::where('name', $kecamatanName)->first();
            
            if ($kecamatan) {
                foreach ($villages as $name) {
                    Village::firstOrCreate(
                        ['name' => $name],
                        ['kecamatan_id' => $kecamatan->id]
                    );
                }
            }
        }
        
        // Pastikan beberapa desa default lama tetap ada untuk fallback jika diperlukan
        $defaultKecamatan = Kecamatan::first();
        if ($defaultKecamatan) {
            $oldVillages = ['Sukamaju', 'Mekarsari'];
            foreach ($oldVillages as $name) {
                Village::firstOrCreate(
                    ['name' => $name],
                    ['kecamatan_id' => $defaultKecamatan->id]
                );
            }
        }
    }
}
