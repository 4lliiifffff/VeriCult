<?php

namespace Database\Seeders;

use App\Models\AdministrativeReview;
use App\Models\CulturalSubmission;
use App\Models\FieldVerification;
use App\Models\SubmissionFile;
use App\Models\User;
use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CulturalSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure we have villages
        $villages = [
            'Desa Cidahu',
            'Desa Sukamaju',
            'Desa Karanganyar',
            'Desa Mekarsari',
            'Desa Bojongloa',
        ];

        foreach ($villages as $name) {
            Village::firstOrCreate(['name' => $name]);
        }

        $allVillages = Village::all();
        $pengusul = User::role('pengusul')->first(['*']);
        $pengusulDesa = User::role('pengusul-desa')->first(['*']);
        $validator = User::role('validator')->first(['*']);

        if (!$pengusul || !$validator) {
            $this->command->error('Users with roles "pengusul" and "validator" are required.');
            return;
        }

        $years = [2024, 2025, 2026];
        $statuses = [
            CulturalSubmission::STATUS_DRAFT,
            CulturalSubmission::STATUS_SUBMITTED,
            CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW,
            CulturalSubmission::STATUS_FIELD_VERIFICATION,
            CulturalSubmission::STATUS_VERIFIED,
            CulturalSubmission::STATUS_PUBLISHED,
        ];

        $categories = [
            CulturalSubmission::CATEGORY_TRADISI_LISAN,
            CulturalSubmission::CATEGORY_MANUSKRIP,
            CulturalSubmission::CATEGORY_ADAT_ISTIADAT,
            CulturalSubmission::CATEGORY_RITUS,
            CulturalSubmission::CATEGORY_PENGETAHUAN_TRADISIONAL,
            CulturalSubmission::CATEGORY_TEKNOLOGI_TRADISIONAL,
            CulturalSubmission::CATEGORY_SENI,
            CulturalSubmission::CATEGORY_BAHASA,
            CulturalSubmission::CATEGORY_PERMAINAN_RAKYAT,
            CulturalSubmission::CATEGORY_OLAHRAGA_TRADISIONAL,
            CulturalSubmission::CATEGORY_CAGAR_BUDAYA,
        ];

        foreach ($years as $year) {
            foreach ($categories as $category) {
                // Create multiple submissions per category per year for variety
                for ($i = 0; $i < 2; $i++) {
                    $type = 'statistik'; // OPK
                    $status = $statuses[array_rand($statuses)];
                    $village = $allVillages->random();
                    $name = $category . ' - ' . $village->name . ' - ' . $year . ' (' . ($i + 1) . ')';
                    
                    $submission = CulturalSubmission::create([
                        'user_id' => $pengusul->id,
                        'village_id' => $village->id,
                        'name' => $name,
                        'slug' => Str::slug($name) . '-' . uniqid(),
                        'category' => $category,
                        'description' => "Deskripsi untuk data $name. Data ini dihasilkan oleh seeder untuk perbandingan tahun $year.",
                        'category_data' => $this->generateCategoryData($category),
                        'address' => 'Jl. Kebudayaan No. ' . rand(1, 100),
                        'status' => $status,
                        'period_year' => $year,
                        'submission_type' => $type,
                        'submitted_at' => $status !== CulturalSubmission::STATUS_DRAFT ? Carbon::now()->subMonths(rand(1, 12)) : null,
                    ]);

                    $this->seedRelations($submission, $validator);
                }
            }

            // Also seed 'aktif' reports for each year
            for ($i = 0; $i < 5; $i++) {
                $status = $statuses[array_rand($statuses)];
                $village = $allVillages->random();
                $name = "Laporan Aktif - " . $village->name . " - " . $year . " - " . ($i + 1);
                
                $submission = CulturalSubmission::create([
                    'user_id' => $pengusulDesa ? $pengusulDesa->id : $pengusul->id,
                    'village_id' => $village->id,
                    'name' => $name,
                    'slug' => Str::slug($name) . '-' . uniqid(),
                    'category' => CulturalSubmission::CATEGORY_LAPORAN_AKTIF,
                    'description' => "Laporan kegiatan kebudayaan aktif di $village->name pada tahun $year.",
                    'category_data' => [
                        'kategori_opk' => $categories[array_rand($categories)],
                        'nama_dan_jenis_kebudayaan' => 'Kegiatan ' . $name,
                        'desa_lokasi' => $village->name,
                        'detail_lokasi' => 'Area ' . $village->name,
                        'tanggal_pelaksanaan' => $year . '-' . rand(1, 12) . '-' . rand(1, 28),
                    ],
                    'address' => 'Balai Desa ' . $village->name,
                    'status' => $status,
                    'period_year' => $year,
                    'submission_type' => 'aktif',
                    'submitted_at' => $status !== CulturalSubmission::STATUS_DRAFT ? Carbon::now()->subMonths(rand(1, 12)) : null,
                ]);

                $this->seedRelations($submission, $validator);
            }
        }
    }

    private function seedRelations($submission, $validator)
    {
        // 1. Files
        $fileCount = rand(1, 3);
        for ($j = 0; $j < $fileCount; $j++) {
            SubmissionFile::create([
                'cultural_submission_id' => $submission->id,
                'original_name' => "file_$j.jpg",
                'stored_name' => Str::random(40) . ".jpg",
                'file_type' => 'image',
                'mime_type' => 'image/jpeg',
                'file_size' => rand(100000, 2000000),
                'path' => "submissions/sample_$j.jpg",
            ]);
        }

        // 2. Reviews
        if (in_array($submission->status, [
            CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW,
            CulturalSubmission::STATUS_FIELD_VERIFICATION,
            CulturalSubmission::STATUS_VERIFIED,
            CulturalSubmission::STATUS_PUBLISHED
        ])) {
            AdministrativeReview::create([
                'submission_id' => $submission->id,
                'validator_id' => $validator->id,
                'action' => AdministrativeReview::ACTION_FORWARDED,
                'notes' => 'Data administratif lengkap dan sesuai.',
            ]);
        }

        // 3. Verifications
        if (in_array($submission->status, [
            CulturalSubmission::STATUS_VERIFIED,
            CulturalSubmission::STATUS_PUBLISHED
        ])) {
            FieldVerification::create([
                'submission_id' => $submission->id,
                'validator_id' => $validator->id,
                'visit_date' => Carbon::now()->subDays(rand(1, 30)),
                'notes' => 'Verifikasi lapangan telah dilakukan. Objek ditemukan dan sesuai dengan laporan.',
                'recommendation' => 'verified',
            ]);
        }
    }

    private function generateCategoryData(string $category): array
    {
        return match($category) {
            CulturalSubmission::CATEGORY_TRADISI_LISAN => [
                'sub_kategori_tradisi_lisan' => 'cerita_rakyat',
                'nama_objek' => 'Legenda ' . Str::random(5),
                'kategori_cerita' => 'Legenda Lokal',
                'etnis_penutur' => 'Sunda',
                'medium_penyajian' => 'Lisan',
                'komponen_tokoh' => 'Tokoh Masyarakat',
            ],
            CulturalSubmission::CATEGORY_BAHASA => [
                'nama_objek' => 'Dialek ' . Str::random(5),
                'jenis_aksara' => 'Latin',
                'etnis' => 'Jawa',
                'memiliki_dialek' => 'Ya',
                'dialek_table' => [
                    ['nama_dialek' => 'Dialek Utara', 'jumlah_penutur' => '1000'],
                    ['nama_dialek' => 'Dialek Selatan', 'jumlah_penutur' => '500'],
                ]
            ],
            CulturalSubmission::CATEGORY_MANUSKRIP => [
                'nama_objek' => 'Naskah ' . Str::random(5),
                'judul' => 'Kitab ' . Str::random(10),
                'bahan' => 'Lontar',
                'bahasa' => 'Jawa Kuno',
                'jumlah' => '1',
                'satuan' => 'Buku',
            ],
            CulturalSubmission::CATEGORY_RITUS => [
                'nama_objek' => 'Upacara ' . Str::random(5),
                'jenis' => 'Panen',
                'etnis' => 'Sunda',
                'lokasi' => 'Sawah Desa',
                'masih_dilaksanakan' => 'Ya, secara terbuka',
            ],
            CulturalSubmission::CATEGORY_SENI => [
                'sub_kategori_seni' => 'seni_tari',
                'nama_objek' => 'Tari ' . Str::random(5),
                'jenis' => 'Tari Tradisional',
                'etnis' => 'Sunda',
                'properti' => 'Selendang',
                'fungsi' => 'Hiburan Rakyat',
            ],
            CulturalSubmission::CATEGORY_CAGAR_BUDAYA => [
                'jenis_objek' => 'Situs Arkeologi',
                'periode_sejarah' => 'Masa Klasik',
                'kondisi' => 'Baik',
                'bahan_material' => 'Batu Andesit',
            ],
            default => [
                'nama_objek' => $category . ' Sample',
                'etnis' => 'Lokal',
                'lokasi' => 'Kabupaten',
            ]
        };
    }
}
