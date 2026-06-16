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
        // 1. Get villages and users
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

        $opkCategories = [
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
        ];

        $cagarBudayaCategories = [
            CulturalSubmission::CATEGORY_CAGAR_BUDAYA,
            CulturalSubmission::CATEGORY_POTENSI_CAGAR_BUDAYA,
        ];

        $potensiCategories = [
            CulturalSubmission::CATEGORY_POTENSI_KEBUDAYAAN,
        ];

        // Define groups
        $typeGroups = [
            'opk' => $opkCategories,
            'cagar-budaya' => $cagarBudayaCategories,
            'potensi-kebudayaan' => $potensiCategories,
        ];

        foreach ($years as $year) {
            foreach ($typeGroups as $type => $categories) {
                foreach ($categories as $category) {
                    // Create multiple submissions per category per year for variety
                    for ($i = 0; $i < 2; $i++) {
                        // Force the first item to be PUBLISHED for guaranteed published data across all categories and years!
                        $status = $i === 0 ? CulturalSubmission::STATUS_PUBLISHED : $statuses[array_rand($statuses)];
                        $village = $allVillages->random();
                        $name = $category . ' - ' . $village->name . ' - ' . $year . ' (' . ($i + 1) . ')';
                        $submittedAt = Carbon::create($year, rand(1, 6), rand(1, 28), rand(9, 17));
                        $verifiedAt = in_array($status, [CulturalSubmission::STATUS_VERIFIED, CulturalSubmission::STATUS_PUBLISHED]) ? (clone $submittedAt)->addDays(rand(5, 15)) : null;
                        $publishedAt = $status === CulturalSubmission::STATUS_PUBLISHED ? (clone $verifiedAt)->addDays(rand(2, 7)) : null;

                        $submission = CulturalSubmission::create([
                            'user_id' => $pengusul->id,
                            'village_id' => $village->id,
                            'name' => $name,
                            'slug' => Str::slug($name) . '-' . uniqid(),
                            'category' => $category,
                            'description' => "Deskripsi untuk data $name. Data ini dihasilkan oleh seeder untuk perbandingan tahun $year.",
                            'category_data' => $this->generateCategoryData($category, $village),
                            'address' => 'Jl. Kebudayaan No. ' . rand(1, 100),
                            'status' => $status,
                            'period_year' => $year,
                            'submission_type' => $type,
                            'reviewed_by' => $status !== CulturalSubmission::STATUS_DRAFT ? $validator->id : null,
                            'review_started_at' => $status !== CulturalSubmission::STATUS_DRAFT ? $submittedAt : null,
                            'submitted_at' => $status !== CulturalSubmission::STATUS_DRAFT ? $submittedAt : null,
                            'verified_at' => $verifiedAt,
                            'published_at' => $publishedAt,
                        ]);

                        $this->seedRelations($submission, $validator);
                    }
                }
            }

            // Also seed 'aktif' reports for each year
            for ($i = 0; $i < 5; $i++) {
                // Ensure at least two are published for comparison
                $status = $i < 2 ? CulturalSubmission::STATUS_PUBLISHED : $statuses[array_rand($statuses)];
                $village = $allVillages->random();
                $name = "Laporan Aktif - " . $village->name . " - " . $year . " - " . ($i + 1);
                
                $submittedAt = Carbon::create($year, rand(1, 6), rand(1, 28), rand(9, 17));
                $verifiedAt = in_array($status, [CulturalSubmission::STATUS_VERIFIED, CulturalSubmission::STATUS_PUBLISHED]) ? (clone $submittedAt)->addDays(rand(5, 15)) : null;
                $publishedAt = $status === CulturalSubmission::STATUS_PUBLISHED ? (clone $verifiedAt)->addDays(rand(2, 7)) : null;

                $submission = CulturalSubmission::create([
                    'user_id' => $pengusulDesa ? $pengusulDesa->id : $pengusul->id,
                    'village_id' => $village->id,
                    'name' => $name,
                    'slug' => Str::slug($name) . '-' . uniqid(),
                    'category' => CulturalSubmission::CATEGORY_LAPORAN_AKTIF,
                    'description' => "Laporan kegiatan kebudayaan aktif di $village->name pada tahun $year.",
                    'category_data' => [
                        'kategori_opk' => $opkCategories[array_rand($opkCategories)],
                        'nama_dan_jenis_kebudayaan' => 'Kegiatan ' . $name,
                        'kecamatan_lokasi' => $village->kecamatan->name ?? 'Subang',
                        'desa_lokasi' => $village->name,
                        'detail_lokasi' => 'Area ' . $village->name,
                        'tanggal_pelaksanaan' => $year . '-' . rand(1, 12) . '-' . rand(1, 28),
                    ],
                    'address' => 'Balai Desa ' . $village->name,
                    'status' => $status,
                    'period_year' => $year,
                    'submission_type' => 'aktif',
                    'reviewed_by' => $status !== CulturalSubmission::STATUS_DRAFT ? $validator->id : null,
                    'review_started_at' => $status !== CulturalSubmission::STATUS_DRAFT ? $submittedAt : null,
                    'submitted_at' => $status !== CulturalSubmission::STATUS_DRAFT ? $submittedAt : null,
                    'verified_at' => $verifiedAt,
                    'published_at' => $publishedAt,
                ]);

                $this->seedRelations($submission, $validator);
            }
        }
    }

    private function seedRelations($submission, $validator)
    {
        // 1. Files
        $files = [
            [
                'name' => 'sample_dance.jpg',
                'mime' => 'image/jpeg',
                'type' => 'image'
            ],
            [
                'name' => 'sample_temple.jpg',
                'mime' => 'image/jpeg',
                'type' => 'image'
            ],
            [
                'name' => 'sample_batik.jpg',
                'mime' => 'image/jpeg',
                'type' => 'image'
            ],
            [
                'name' => 'sample_video.mp4',
                'mime' => 'video/mp4',
                'type' => 'video'
            ]
        ];

        $fileCount = rand(1, 2);
        $selectedFiles = (array) array_rand($files, $fileCount);

        foreach ($selectedFiles as $index) {
            $fileData = $files[$index];
            SubmissionFile::create([
                'cultural_submission_id' => $submission->id,
                'original_name' => $fileData['name'],
                'stored_name' => Str::random(40) . "." . pathinfo($fileData['name'], PATHINFO_EXTENSION),
                'file_type' => $fileData['type'],
                'mime_type' => $fileData['mime'],
                'file_size' => rand(500000, 5000000),
                'path' => "submissions/" . $fileData['name'],
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

    private function generateCategoryData(string $category, $village): array
    {
        $faker = \Faker\Factory::create('id_ID');
        $periodes = ['Prasejarah', 'Masa Klasik (Hindu-Buddha)', 'Masa Islam', 'Masa Kolonial', 'Kemerdekaan', 'Kontemporer'];
        $kondisi = ['Baik', 'Rusak Ringan', 'Rusak Sedang', 'Rusak Berat', 'Kurang Terawat', 'Terawat'];
        $etnis = ['Jawa', 'Sunda', 'Madura', 'Bugis', 'Minangkabau', 'Batak', 'Bali', 'Dayak', 'Sasak', 'Melayu'];

        $baseData = [
            'kecamatan_lokasi' => $village->kecamatan->name ?? 'Subang',
            'desa_lokasi' => $village->name,
        ];

        $specificData = match($category) {
            CulturalSubmission::CATEGORY_TRADISI_LISAN => [
                'sub_kategori_tradisi_lisan' => $faker->randomElement(['cerita_rakyat', 'mitos', 'legenda', 'dongeng', 'pepatah', 'pantun']),
                'nama_objek' => 'Tradisi Lisan ' . $faker->words(2, true),
                'kategori_cerita' => 'Kisah Leluhur',
                'etnis_penutur' => $faker->randomElement($etnis),
                'medium_penyajian' => $faker->randomElement(['Lisan', 'Tembang', 'Mantra']),
                'komponen_tokoh' => $faker->name(),
            ],
            CulturalSubmission::CATEGORY_BAHASA => [
                'nama_objek' => 'Bahasa/Dialek ' . $faker->words(2, true),
                'jenis_aksara' => $faker->randomElement(['Latin', 'Pegon', 'Jawa', 'Lontara', 'Batak', 'Kaganga']),
                'etnis' => $faker->randomElement($etnis),
                'memiliki_dialek' => $faker->randomElement(['Ya', 'Tidak']),
                'dialek_table' => [
                    ['nama_dialek' => 'Dialek ' . $faker->word(), 'jumlah_penutur' => (string)$faker->numberBetween(100, 10000)],
                    ['nama_dialek' => 'Dialek ' . $faker->word(), 'jumlah_penutur' => (string)$faker->numberBetween(100, 5000)],
                ]
            ],
            CulturalSubmission::CATEGORY_MANUSKRIP => [
                'nama_objek' => 'Naskah Kuno ' . $faker->words(2, true),
                'judul' => 'Kitab ' . $faker->words(3, true),
                'bahan' => $faker->randomElement(['Lontar', 'Kertas Daluang', 'Bambu', 'Kulit Binatang']),
                'bahasa' => $faker->randomElement(['Jawa Kuno', 'Melayu Kuno', 'Sunda Kuno', 'Arab']),
                'jumlah' => (string)$faker->numberBetween(1, 10),
                'satuan' => $faker->randomElement(['Buku', 'Gulungan', 'Lembar']),
            ],
            CulturalSubmission::CATEGORY_RITUS => [
                'nama_objek' => 'Upacara ' . $faker->words(2, true),
                'jenis' => $faker->randomElement(['Kelahiran', 'Pernikahan', 'Kematian', 'Panen', 'Tolak Bala']),
                'etnis' => $faker->randomElement($etnis),
                'lokasi' => 'Desa ' . $faker->city(),
                'masih_dilaksanakan' => $faker->randomElement(['Ya, secara terbuka', 'Ya, tertutup', 'Jarang', 'Sudah Punah']),
            ],
            CulturalSubmission::CATEGORY_SENI => [
                'sub_kategori_seni' => $faker->randomElement(['seni_tari', 'seni_suara', 'seni_musik', 'seni_teater', 'seni_rupa']),
                'nama_objek' => 'Seni ' . $faker->words(2, true),
                'jenis' => 'Kesenian Tradisional',
                'etnis' => $faker->randomElement($etnis),
                'properti' => $faker->word(),
                'fungsi' => $faker->randomElement(['Hiburan Rakyat', 'Ritual', 'Pendidikan', 'Penyambutan Tamu']),
            ],
            CulturalSubmission::CATEGORY_ADAT_ISTIADAT => [
                'nama_objek' => 'Adat ' . $faker->words(2, true),
                'jenis' => $faker->randomElement(['Hukum Adat', 'Sistem Kekerabatan', 'Sistem Ekonomi Tradisional']),
                'etnis' => $faker->randomElement($etnis),
                'lokasi' => 'Wilayah ' . $faker->city(),
            ],
            CulturalSubmission::CATEGORY_PENGETAHUAN_TRADISIONAL => [
                'nama_objek' => 'Pengetahuan ' . $faker->words(2, true),
                'jenis' => $faker->randomElement(['Pengobatan', 'Pertanian', 'Astronomi', 'Arsitektur']),
                'etnis' => $faker->randomElement($etnis),
                'pemanfaatan' => $faker->sentence(),
            ],
            CulturalSubmission::CATEGORY_TEKNOLOGI_TRADISIONAL => [
                'nama_objek' => 'Teknologi ' . $faker->words(2, true),
                'jenis' => $faker->randomElement(['Alat Transportasi', 'Senjata', 'Alat Pertanian', 'Penenunan']),
                'bahan_dasar' => $faker->randomElement(['Kayu', 'Bambu', 'Besi', 'Batu']),
                'etnis' => $faker->randomElement($etnis),
            ],
            CulturalSubmission::CATEGORY_PERMAINAN_RAKYAT => [
                'nama_objek' => 'Permainan ' . $faker->words(2, true),
                'jenis' => $faker->randomElement(['Ketangkasan', 'Strategi', 'Hiburan']),
                'peralatan' => $faker->randomElement(['Bambu', 'Kayu', 'Tanpa Alat']),
                'jumlah_pemain' => (string)$faker->numberBetween(2, 20),
            ],
            CulturalSubmission::CATEGORY_OLAHRAGA_TRADISIONAL => [
                'nama_objek' => 'Olahraga ' . $faker->words(2, true),
                'jenis' => $faker->randomElement(['Bela Diri', 'Adu Ketangkasan', 'Lomba Fisik']),
                'peralatan' => $faker->word(),
                'jumlah_pemain' => (string)$faker->numberBetween(2, 50),
            ],
            CulturalSubmission::CATEGORY_CAGAR_BUDAYA => [
                'jenis_objek' => $faker->randomElement(['Situs Arkeologi', 'Bangunan Bersejarah', 'Benda Purbakala', 'Struktur Cagar Budaya']),
                'periode_sejarah' => $faker->randomElement($periodes),
                'kondisi' => $faker->randomElement($kondisi),
                'bahan_material' => $faker->randomElement(['Batu Andesit', 'Bata Merah', 'Kayu Jati', 'Tanah Liat', 'Logam']),
            ],
            CulturalSubmission::CATEGORY_POTENSI_CAGAR_BUDAYA => [
                'nama_objek' => 'Potensi CB ' . $faker->words(2, true),
                'perkiraan_zaman' => $faker->randomElement($periodes),
                'kondisi_saat_ini' => $faker->randomElement($kondisi),
            ],
            CulturalSubmission::CATEGORY_POTENSI_KEBUDAYAAN => [
                'kategori_potensi' => $faker->randomElement(['Tenaga Kebudayaan', 'Lembaga Kebudayaan', 'Sarana Prasarana']),
                'nama_tenaga' => $faker->name(),
                'bidang_keahlian' => $faker->randomElement(['Seni Musik', 'Seni Tari', 'Seni Rupa', 'Peneliti Sejarah', 'Pelestari Adat']),
            ],
            default => [
                'nama_objek' => $category . ' Sample',
                'etnis' => $faker->randomElement($etnis),
                'lokasi' => $faker->city(),
            ]
        };

        return array_merge($baseData, $specificData);
    }
}
