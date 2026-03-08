<?php

/**
 * Definisi field per kategori OPK (Objek Pemajuan Kebudayaan)
 * Setiap kategori bisa memiliki sub_categories atau langsung fields.
 * 
 * Field types: text, textarea, select, radio, checkbox_group, dynamic_table, dimension
 * Conditional: 'condition' => ['field' => 'field_key', 'value' => 'expected_value']
 */

return [

    // ========================================================================
    // A. TRADISI LISAN (2 sub-kategori)
    // ========================================================================
    'Tradisi Lisan' => [
        'has_sub' => true,
        'sub_field' => 'sub_kategori_tradisi_lisan',
        'sub_label' => 'Pilih Jenis Tradisi Lisan',
        'sub_options' => [
            'pantun' => 'Pantun/Peribahasa/Teka-teki',
            'cerita_rakyat' => 'Cerita Rakyat',
        ],
        'fields' => [
            'pantun' => [
                'b1_nama_objek' => ['label' => 'B1. Nama Objek', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_jenis_objek' => ['label' => 'B2. Jenis Objek', 'type' => 'text', 'placeholder' => 'Masukkan jenis objek'],
                'b3_etnis_penutur' => ['label' => 'B3. Etnis Penutur', 'type' => 'text', 'placeholder' => 'Masukkan etnis penutur'],
            ],
            'cerita_rakyat' => [
                'b1_nama_objek' => ['label' => 'B1. Nama Objek Cerita Rakyat', 'type' => 'text', 'placeholder' => 'Masukkan nama objek cerita rakyat'],
                'b2_kategori_cerita' => ['label' => 'B2. Kategori Cerita Rakyat', 'type' => 'text', 'placeholder' => 'Masukkan kategori cerita rakyat'],
                'b3_etnis_penutur' => ['label' => 'B3. Etnis Penutur', 'type' => 'text', 'placeholder' => 'Masukkan etnis penutur'],
                'b4_medium_penyajian' => ['label' => 'B4. Medium Penyajian', 'type' => 'text', 'placeholder' => 'Masukkan medium penyajian'],
                'b5_komponen_tokoh' => ['label' => 'B5. Komponen Tokoh/Pelaku Dalam Cerita Rakyat', 'type' => 'textarea', 'placeholder' => 'Sebutkan komponen tokoh/pelaku'],
            ],
        ],
    ],

    // ========================================================================
    // B. BAHASA
    // ========================================================================
    'Bahasa' => [
        'has_sub' => false,
        'fields' => [
            'b1_nama_objek' => ['label' => 'B1. Nama Objek Bahasa', 'type' => 'text', 'placeholder' => 'Masukkan nama objek bahasa'],
            'b2_jenis_aksara' => ['label' => 'B2. Jenis Aksara yang Digunakan', 'type' => 'text', 'placeholder' => 'Masukkan jenis aksara'],
            'b3_etnis' => ['label' => 'B3. Etnis yang menggunakan bahasa tersebut', 'type' => 'text', 'placeholder' => 'Masukkan etnis pengguna bahasa'],
            'b4_memiliki_dialek' => ['label' => 'B4. Apakah bahasa tersebut memiliki dialek?', 'type' => 'radio', 'options' => ['Ya', 'Tidak']],
            'c_dialek_table' => [
                'label' => 'C. Identifikasi Dialek Bahasa yang Masih Ada',
                'type' => 'dynamic_table',
                'columns' => ['Nama Dialek', 'Jumlah Penutur (Orang)'],
                'column_keys' => ['nama_dialek', 'jumlah_penutur'],
                'condition' => ['field' => 'b4_memiliki_dialek', 'value' => 'Ya'],
            ],
        ],
    ],

    // ========================================================================
    // C. MANUSKRIP
    // ========================================================================
    'Manuskrip' => [
        'has_sub' => false,
        'fields' => [
            'b1_nama_objek' => ['label' => 'B1. Nama Objek Manuskrip', 'type' => 'text', 'placeholder' => 'Masukkan nama objek manuskrip'],
            'b2_judul' => ['label' => 'B2. Judul Manuskrip', 'type' => 'text', 'placeholder' => 'Masukkan judul manuskrip'],
            'b3_bahan' => ['label' => 'B3. Bahan Manuskrip', 'type' => 'select', 'options' => ['Kertas', 'Lontar', 'Kayu', 'Batu', 'Lainnya'], 'placeholder' => 'Pilih bahan manuskrip'],
            'b3_bahan_lainnya' => ['label' => 'Sebutkan bahan lainnya', 'type' => 'text', 'placeholder' => 'Sebutkan bahan lainnya', 'condition' => ['field' => 'b3_bahan', 'value' => 'Lainnya']],
            'b4_bahasa' => ['label' => 'B4. Bahasa yang digunakan', 'type' => 'text', 'placeholder' => 'Masukkan bahasa yang digunakan'],
            'b5_karya' => ['label' => 'B5. Karya', 'type' => 'text', 'placeholder' => 'Masukkan karya'],
            'b6_subjek' => ['label' => 'B6. Subjek', 'type' => 'text', 'placeholder' => 'Masukkan subjek'],
            'b7_periode' => ['label' => 'B7. Periode', 'type' => 'select', 'options' => ['Masa Prasejarah', 'Masa Klasik Hindu Buddha', 'Masa Islam', 'Masa Kolonial', 'Masa Kemerdekaan', 'Masa Modern'], 'placeholder' => 'Pilih periode'],
            'b8_nama_tempat' => ['label' => 'B8. Nama tempat lokasi', 'type' => 'text', 'placeholder' => 'Masukkan nama tempat lokasi'],
            'b9_alamat_penyimpanan' => ['label' => 'B9. Alamat lokasi penyimpanan (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
            'b10_jumlah' => ['label' => 'B10. Jumlah Manuskrip', 'type' => 'text', 'placeholder' => 'Masukkan jumlah manuskrip'],
            'b11_satuan' => ['label' => 'B11. Satuan Manuskrip', 'type' => 'select', 'options' => ['Lembar', 'Gulungan', 'Buku', 'Jilid', 'Berkas', 'Lempeng', 'Lainnya'], 'placeholder' => 'Pilih satuan'],
            'b11_satuan_lainnya' => ['label' => 'Sebutkan satuan lainnya', 'type' => 'text', 'placeholder' => 'Sebutkan satuan lainnya', 'condition' => ['field' => 'b11_satuan', 'value' => 'Lainnya']],
            'b12_panjang' => ['label' => 'B12. Ukuran - Panjang (cm)', 'type' => 'text', 'placeholder' => 'Panjang'],
            'b12_lebar' => ['label' => 'B12. Ukuran - Lebar (cm)', 'type' => 'text', 'placeholder' => 'Lebar'],
            'b12_tinggi' => ['label' => 'B12. Ukuran - Tinggi (cm)', 'type' => 'text', 'placeholder' => 'Tinggi'],
            'b13_mengetahui_pencipta' => ['label' => 'B13. Apakah mengetahui pencipta asli manuskrip?', 'type' => 'radio', 'options' => ['Ya', 'Tidak']],
            'b14_nama_pencipta' => ['label' => 'B14. Nama pencipta manuskrip', 'type' => 'text', 'placeholder' => 'Masukkan nama pencipta', 'condition' => ['field' => 'b13_mengetahui_pencipta', 'value' => 'Ya']],
        ],
    ],

    // ========================================================================
    // D. ADAT ISTIADAT
    // ========================================================================
    'Adat Istiadat' => [
        'has_sub' => false,
        'fields' => [
            'b1_nama_objek' => ['label' => 'B1. Nama Objek Adat Istiadat', 'type' => 'text', 'placeholder' => 'Masukkan nama objek adat istiadat'],
            'b2_jenis' => ['label' => 'B2. Jenis Adat Istiadat', 'type' => 'text', 'placeholder' => 'Masukkan jenis adat istiadat'],
            'b3_etnis' => ['label' => 'B3. Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis yang melaksanakan'],
            'b4_masih_dilaksanakan' => ['label' => 'B4. Apakah adat istiadat tersebut masih dilaksanakan hingga saat ini?', 'type' => 'radio', 'options' => ['Ya', 'Tidak']],
            'c1_tahun_terakhir_ya' => ['label' => 'C1. Tahun terakhir pelaksanaan', 'type' => 'text', 'placeholder' => 'Masukkan tahun terakhir pelaksanaan', 'condition' => ['field' => 'b4_masih_dilaksanakan', 'value' => 'Ya']],
            'c2_tahun_terakhir_tidak' => ['label' => 'C2. Tahun terakhir pelaksanaan', 'type' => 'text', 'placeholder' => 'Masukkan tahun terakhir pelaksanaan', 'condition' => ['field' => 'b4_masih_dilaksanakan', 'value' => 'Tidak']],
        ],
    ],

    // ========================================================================
    // E. RITUS
    // ========================================================================
    'Ritus' => [
        'has_sub' => false,
        'fields' => [
            'b1_nama_objek' => ['label' => 'B1. Nama Objek Ritus', 'type' => 'text', 'placeholder' => 'Masukkan nama objek ritus'],
            'b2_jenis' => ['label' => 'B2. Jenis Ritus', 'type' => 'text', 'placeholder' => 'Masukkan jenis ritus'],
            'b3_etnis' => ['label' => 'B3. Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis yang melaksanakan'],
            'b4_lokasi' => ['label' => 'B4. Lokasi pelaksanaan Ritus', 'type' => 'text', 'placeholder' => 'Masukkan lokasi pelaksanaan'],
            'b5_komponen_pelaku' => ['label' => 'B5. Komponen Pelaku Ritus', 'type' => 'textarea', 'placeholder' => 'Sebutkan komponen pelaku ritus'],
            'b6_tujuan_rapalan' => ['label' => 'B6. Tujuan Penggunaan Rapalan/Mantra', 'type' => 'textarea', 'placeholder' => 'Jelaskan tujuan penggunaan rapalan/mantra'],
            'b7_perlengkapan' => ['label' => 'B7. Perlengkapan Ritus', 'type' => 'textarea', 'placeholder' => 'Sebutkan perlengkapan ritus'],
            'b8_masih_dilaksanakan' => ['label' => 'B8. Apakah Ritus tersebut masih dilaksanakan hingga saat ini?', 'type' => 'radio', 'options' => ['Ya, secara terbuka', 'Ya, secara tertutup', 'Tidak']],
            'c1_tahun_terakhir' => ['label' => 'C1. Tahun Terakhir Pelaksanaan', 'type' => 'text', 'placeholder' => 'Masukkan tahun terakhir pelaksanaan', 'condition' => ['field' => 'b8_masih_dilaksanakan', 'value' => 'Tidak']],
            'c1_alasan' => ['label' => 'C1. Alasan sudah tidak dilaksanakan', 'type' => 'textarea', 'placeholder' => 'Jelaskan alasan', 'condition' => ['field' => 'b8_masih_dilaksanakan', 'value' => 'Tidak']],
        ],
    ],

    // ========================================================================
    // F. PENGETAHUAN TRADISIONAL (7 sub-kategori)
    // ========================================================================
    'Pengetahuan Tradisional' => [
        'has_sub' => true,
        'sub_field' => 'sub_kategori_pengetahuan',
        'sub_label' => 'Pilih Jenis Pengetahuan Tradisional',
        'sub_options' => [
            'makanan_minuman' => 'Makanan/Minuman',
            'pengetahuan' => 'Pengetahuan',
            'rempah_bumbu' => 'Rempah/Bumbu',
            'pakaian_tradisional' => 'Pakaian Tradisional',
            'kerajinan' => 'Kerajinan',
            'metode_penyehatan' => 'Metode Penyehatan',
            'jamu_ramuan' => 'Jamu/Ramuan',
        ],
        'fields' => [
            'makanan_minuman' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (makanan/minuman)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_jenis' => ['label' => 'B2. Jenis makanan/minuman', 'type' => 'text', 'placeholder' => 'Masukkan jenis makanan/minuman'],
                'b3_etnis' => ['label' => 'B3. Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis'],
                'b4_lokasi_sentra' => ['label' => 'B4. Lokasi sentra pembuatan/produksi (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'b5_bahan_baku' => ['label' => 'B5. Bahan baku pembuatan', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan baku pembuatan'],
                'b6_cara_pembuatan' => ['label' => 'B6. Cara pembuatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan cara pembuatan'],
                'b7_cara_waktu_penyajian' => ['label' => 'B7. Cara dan waktu penyajian', 'type' => 'textarea', 'placeholder' => 'Jelaskan cara dan waktu penyajian'],
                'b8_cara_waktu_penyimpanan' => ['label' => 'B8. Cara dan waktu penyimpanan', 'type' => 'textarea', 'placeholder' => 'Jelaskan cara dan waktu penyimpanan'],
            ],
            'pengetahuan' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (pengetahuan)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_jenis' => ['label' => 'B2. Jenis pengetahuan', 'type' => 'checkbox_group', 'options' => ['Bercocok tanam', 'Ilmu falak/ilmu perbintangan', 'Pengetahuan keharmonisan rumah tangga', 'Pengetahuan kebencanaan', 'Lainnya']],
                'b2_jenis_lainnya' => ['label' => 'Sebutkan jenis lainnya', 'type' => 'text', 'placeholder' => 'Sebutkan jenis pengetahuan lainnya'],
                'b3_etnis' => ['label' => 'B3. Etnis yang menggunakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis'],
                'b4_lokasi' => ['label' => 'B4. Lokasi penggunaan (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'b5_perkiraan_usia' => ['label' => 'B5. Perkiraan usia penggunaan', 'type' => 'text', 'placeholder' => 'Masukkan perkiraan usia penggunaan'],
                'b6_kegunaan' => ['label' => 'B6. Kegunaan pengetahuan tradisional', 'type' => 'textarea', 'placeholder' => 'Jelaskan kegunaan pengetahuan tradisional'],
            ],
            'rempah_bumbu' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (Rempah dan Bumbu)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_etnis' => ['label' => 'B2. Etnis yang menggunakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis'],
                'b3_lokasi_sentra' => ['label' => 'B3. Lokasi sentra pembuatan (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'b4_masih_ada' => ['label' => 'B4. Apakah bumbu dan rempah tersebut masih ada dan digunakan?', 'type' => 'radio', 'options' => ['Ada', 'Tidak ada']],
                'b5_cara_penggunaan' => ['label' => 'B5. Cara penggunaan', 'type' => 'textarea', 'placeholder' => 'Jelaskan cara penggunaan'],
                'b6_manfaat' => ['label' => 'B6. Manfaat penggunaan', 'type' => 'textarea', 'placeholder' => 'Jelaskan manfaat penggunaan'],
            ],
            'pakaian_tradisional' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (pakaian tradisional)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_etnis' => ['label' => 'B2. Etnis yang menggunakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis'],
                'b3_lokasi_sentra' => ['label' => 'B3. Lokasi sentra pembuatan (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'b4_teknik' => ['label' => 'B4. Teknik pembuatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan teknik pembuatan'],
                'b5_bahan' => ['label' => 'B5. Bahan yang digunakan', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan yang digunakan'],
                'b6_orang_pengguna' => ['label' => 'B6. Kriteria - Orang yang menggunakan', 'type' => 'text', 'placeholder' => 'Siapa yang menggunakan'],
                'b6_waktu_penggunaan' => ['label' => 'B6. Kriteria - Waktu penggunaan', 'type' => 'text', 'placeholder' => 'Kapan digunakan'],
                'b6_tempat_penggunaan' => ['label' => 'B6. Kriteria - Tempat penggunaan', 'type' => 'text', 'placeholder' => 'Di mana digunakan'],
            ],
            'kerajinan' => [
                'b1_nama_objek' => ['label' => 'B1. Nama Objek (Kerajinan)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_etnis' => ['label' => 'B2. Etnis yang membuat kerajinan tersebut', 'type' => 'text', 'placeholder' => 'Masukkan etnis'],
                'b3_lokasi_sentra' => ['label' => 'B3. Lokasi sentra pembuatan (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'b4_teknik' => ['label' => 'B4. Teknik pembuatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan teknik pembuatan'],
                'b5_bahan_baku' => ['label' => 'B5. Bahan baku', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan baku'],
                'b6_kegunaan' => ['label' => 'B6. Kegunaan/tujuan pembuatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan kegunaan/tujuan pembuatan'],
            ],
            'metode_penyehatan' => [
                'b1_nama_objek' => ['label' => 'B1. Nama Objek (Metode Penyehatan)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_etnis' => ['label' => 'B2. Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis'],
                'b3_lokasi' => ['label' => 'B3. Lokasi Praktik Metode Penyehatan (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'b4_tata_cara' => ['label' => 'B4. Tata Cara Penyehatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan tata cara penyehatan'],
                'b5_peralatan' => ['label' => 'B5. Peralatan yang digunakan', 'type' => 'textarea', 'placeholder' => 'Sebutkan peralatan yang digunakan'],
            ],
            'jamu_ramuan' => [
                'b1_nama_objek' => ['label' => 'B1. Nama Objek (Jamu/Ramuan Tradisional)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_jenis' => ['label' => 'B2. Jenis Ramuan Tradisional', 'type' => 'text', 'placeholder' => 'Masukkan jenis ramuan'],
                'b3_etnis' => ['label' => 'B3. Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis'],
                'b4_lokasi_sentra' => ['label' => 'B4. Lokasi Sentra Pembuatan/Produksi (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'b5_khasiat' => ['label' => 'B5. Khasiat Jamu/Ramuan Tradisional', 'type' => 'textarea', 'placeholder' => 'Jelaskan khasiat'],
                'b6_bahan_baku' => ['label' => 'B6. Bahan Baku Pembuatan', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan baku'],
                'b7_cara_pembuatan' => ['label' => 'B7. Cara Pembuatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan cara pembuatan'],
            ],
        ],
    ],

    // ========================================================================
    // G. TEKNOLOGI TRADISIONAL (6 sub-kategori)
    // ========================================================================
    'Teknologi Tradisional' => [
        'has_sub' => true,
        'sub_field' => 'sub_kategori_teknologi',
        'sub_label' => 'Pilih Jenis Teknologi Tradisional',
        'sub_options' => [
            'arsitektur' => 'Arsitektur Tradisional',
            'pengolahan_lahan' => 'Sistem Pengolahan Lahan',
            'instrumen_musik' => 'Instrumen Musik',
            'alat_produksi' => 'Alat Produksi',
            'senjata' => 'Senjata',
            'teknologi_penunjang' => 'Teknologi Penunjang',
        ],
        'fields' => [
            'arsitektur' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (arsitektur tradisional)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_fungsi_utama' => ['label' => 'B2. Fungsi utama arsitektur', 'type' => 'text', 'placeholder' => 'Masukkan fungsi utama'],
                'b3_etnis' => ['label' => 'B3. Etnis yang menggunakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis'],
                'b4_lokasi' => ['label' => 'B4. Lokasi arsitektur (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'b5_bahan' => ['label' => 'B5. Bahan arsitektur', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan arsitektur'],
                'b6_nama_simbol' => ['label' => 'B6. Nama unsur/simbol', 'type' => 'text', 'placeholder' => 'Masukkan nama unsur/simbol'],
                'b7_makna_simbol' => ['label' => 'B7. Makna yang terkandung dalam unsur/simbol', 'type' => 'textarea', 'placeholder' => 'Jelaskan makna simbol'],
            ],
            'pengolahan_lahan' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (sistem pengolahan lahan)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_etnis' => ['label' => 'B2. Etnis yang menggunakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis'],
                'b3_waktu_mulai' => ['label' => 'B3. Waktu mulai penggunaan', 'type' => 'text', 'placeholder' => 'Harap diisi dengan satuan waktu yang digunakan'],
                'b4_lokasi' => ['label' => 'B4. Lokasi penggunaan (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'b5_bahan_baku' => ['label' => 'B5. Bahan baku yang digunakan', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan baku'],
                'b6_fungsi' => ['label' => 'B6. Fungsi teknologi', 'type' => 'textarea', 'placeholder' => 'Jelaskan fungsi teknologi'],
            ],
            'instrumen_musik' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (Instrumen musik)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_etnis' => ['label' => 'B2. Etnis yang menggunakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis'],
                'b3_lokasi_sentra' => ['label' => 'B3. Lokasi sentra pembuatan instrumen (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'b4_bahan_baku' => ['label' => 'B4. Bahan baku pembuatan instrumen', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan baku'],
                'b5_cara_pembuatan' => ['label' => 'B5. Cara pembuatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan cara pembuatan'],
                'b6_cara_penggunaan' => ['label' => 'B6. Cara penggunaan', 'type' => 'textarea', 'placeholder' => 'Jelaskan cara penggunaan'],
            ],
            'alat_produksi' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (Alat produksi)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_etnis' => ['label' => 'B2. Etnis yang menggunakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis'],
                'b3_lokasi' => ['label' => 'B3. Lokasi pembuatan alat produksi (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'b4_bahan_baku' => ['label' => 'B4. Bahan baku pembuatan alat produksi', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan baku'],
                'b5_waktu_mulai' => ['label' => 'B5. Waktu mulai penggunaan', 'type' => 'text', 'placeholder' => 'Harap diisi dengan satuan waktu yang digunakan'],
                'b6_fungsi' => ['label' => 'B6. Fungsi alat produksi', 'type' => 'textarea', 'placeholder' => 'Jelaskan fungsi alat produksi'],
                'b7_objek_dihasilkan' => ['label' => 'B7. Objek yang dihasilkan dari alat produksi', 'type' => 'textarea', 'placeholder' => 'Sebutkan objek yang dihasilkan'],
            ],
            'senjata' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (senjata tradisional)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_etnis' => ['label' => 'B2. Etnis yang menggunakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis'],
                'b3_lokasi_sentra' => ['label' => 'B3. Lokasi sentra pembuatan senjata (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'b4_bahan_baku' => ['label' => 'B4. Bahan baku pembuatan senjata', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan baku'],
                'b5_fungsi' => ['label' => 'B5. Fungsi senjata', 'type' => 'textarea', 'placeholder' => 'Jelaskan fungsi senjata'],
            ],
            'teknologi_penunjang' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (teknologi penunjang)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_opk_terkait' => ['label' => 'B2. OPK terkait', 'type' => 'text', 'placeholder' => 'Masukkan OPK terkait'],
                'b3_etnis' => ['label' => 'B3. Etnis yang menggunakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis'],
                'b4_waktu_mulai' => ['label' => 'B4. Waktu mulai penggunaan teknologi', 'type' => 'text', 'placeholder' => 'Harap diisi dengan satuan waktu yang digunakan'],
                'b5_lokasi' => ['label' => 'B5. Lokasi penggunaan (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'b6_bahan_baku' => ['label' => 'B6. Bahan baku/peralatan yang digunakan', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan baku/peralatan'],
                'b7_fungsi' => ['label' => 'B7. Fungsi teknologi', 'type' => 'textarea', 'placeholder' => 'Jelaskan fungsi teknologi'],
            ],
        ],
    ],

    // ========================================================================
    // H. SENI (9 sub-kategori)
    // ========================================================================
    'Seni' => [
        'has_sub' => true,
        'sub_field' => 'sub_kategori_seni',
        'sub_label' => 'Pilih Jenis Seni',
        'sub_options' => [
            'seni_rupa' => 'Seni Rupa',
            'seni_media_baru' => 'Seni Media Baru',
            'seni_film' => 'Seni Film',
            'seni_sastra' => 'Seni Sastra',
            'lagu' => 'Lagu',
            'naskah_skenario' => 'Naskah Skenario',
            'seni_pertunjukan' => 'Seni Pertunjukan',
            'seni_musik' => 'Seni Musik',
            'seni_tari' => 'Seni Tari',
        ],
        'fields' => [
            'seni_rupa' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (seni rupa)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_jenis' => ['label' => 'B2. Jenis seni rupa', 'type' => 'text', 'placeholder' => 'Masukkan jenis seni rupa'],
                'b3_media' => ['label' => 'B3. Media pembuatan', 'type' => 'text', 'placeholder' => 'Masukkan media pembuatan'],
                'b4_teknik' => ['label' => 'B4. Teknik pembuatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan teknik pembuatan'],
                'b5_tahun' => ['label' => 'B5. Tahun penciptaan', 'type' => 'text', 'placeholder' => 'Masukkan tahun penciptaan'],
                'b6_jumlah_publikasi' => ['label' => 'B6. Jumlah publikasi/pameran seni rupa dalam lima tahun terakhir', 'type' => 'text', 'placeholder' => 'Masukkan jumlah'],
            ],
            'seni_media_baru' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (seni media baru)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_teknik' => ['label' => 'B2. Teknik pembuatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan teknik pembuatan'],
                'b3_tahun' => ['label' => 'B3. Tahun penciptaan', 'type' => 'text', 'placeholder' => 'Masukkan tahun penciptaan'],
                'b4_jumlah_publikasi' => ['label' => 'B4. Jumlah publikasi/pameran seni media baru dalam setahun terakhir', 'type' => 'text', 'placeholder' => 'Masukkan jumlah'],
            ],
            'seni_film' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (film)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_jenis' => ['label' => 'B2. Jenis film', 'type' => 'text', 'placeholder' => 'Masukkan jenis film'],
                'b3_tahun' => ['label' => 'B3. Tahun penciptaan', 'type' => 'text', 'placeholder' => 'Masukkan tahun'],
                'b4_produser' => ['label' => 'B4. Produser', 'type' => 'text', 'placeholder' => 'Masukkan nama produser'],
                'b5_sutradara' => ['label' => 'B5. Sutradara', 'type' => 'text', 'placeholder' => 'Masukkan nama sutradara'],
                'b6_penulis' => ['label' => 'B6. Penulis', 'type' => 'text', 'placeholder' => 'Masukkan nama penulis'],
                'b7_pemeran' => ['label' => 'B7. Pemeran', 'type' => 'textarea', 'placeholder' => 'Sebutkan pemeran'],
                'b8_genre' => ['label' => 'B8. Genre', 'type' => 'text', 'placeholder' => 'Masukkan genre'],
                'b9_durasi' => ['label' => 'B9. Durasi', 'type' => 'text', 'placeholder' => 'Masukkan durasi'],
            ],
            'seni_sastra' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (seni sastra)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_media' => ['label' => 'B2. Media penyebaran seni sastra', 'type' => 'text', 'placeholder' => 'Masukkan media penyebaran'],
                'b3_tahun' => ['label' => 'B3. Tahun penciptaan', 'type' => 'text', 'placeholder' => 'Masukkan tahun penciptaan'],
                'b4_jumlah_publikasi' => ['label' => 'B4. Jumlah publikasi karya sastra dalam setahun terakhir', 'type' => 'text', 'placeholder' => 'Masukkan jumlah'],
            ],
            'lagu' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (lagu)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_pencipta' => ['label' => 'B2. Nama pencipta lagu', 'type' => 'text', 'placeholder' => 'Masukkan nama pencipta'],
                'b3_tahun' => ['label' => 'B3. Tahun penciptaan', 'type' => 'text', 'placeholder' => 'Masukkan tahun penciptaan'],
                'b4_label' => ['label' => 'B4. Label/publisher', 'type' => 'text', 'placeholder' => 'Masukkan label/publisher'],
                'b5_genre' => ['label' => 'B5. Genre lagu', 'type' => 'text', 'placeholder' => 'Masukkan genre'],
            ],
            'naskah_skenario' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (naskah skenario)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_penulis' => ['label' => 'B2. Nama penulis naskah skenario', 'type' => 'text', 'placeholder' => 'Masukkan nama penulis'],
                'b3_tahun' => ['label' => 'B3. Tahun penciptaan', 'type' => 'text', 'placeholder' => 'Masukkan tahun penciptaan'],
            ],
            'seni_pertunjukan' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (seni pertunjukan)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_jenis' => ['label' => 'B2. Jenis seni pertunjukan', 'type' => 'text', 'placeholder' => 'Masukkan jenis seni pertunjukan'],
                'b3_etnis' => ['label' => 'B3. Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis'],
                'b4_penokohan' => ['label' => 'B4. Penokohan dalam seni pertunjukan', 'type' => 'textarea', 'placeholder' => 'Jelaskan penokohan'],
                'b5_nilai' => ['label' => 'B5. Nilai yang disampaikan dalam seni pertunjukan', 'type' => 'textarea', 'placeholder' => 'Jelaskan nilai yang disampaikan'],
            ],
            'seni_musik' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (seni musik)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_jenis' => ['label' => 'B2. Jenis seni musik', 'type' => 'text', 'placeholder' => 'Masukkan jenis seni musik'],
                'b3_etnis' => ['label' => 'B3. Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis'],
                'b4_bahasa' => ['label' => 'B4. Bahasa yang digunakan', 'type' => 'text', 'placeholder' => 'Masukkan bahasa'],
                'b5_komponen_alat' => ['label' => 'B5. Komponen alat musik', 'type' => 'textarea', 'placeholder' => 'Sebutkan komponen alat musik'],
            ],
            'seni_tari' => [
                'b1_nama_objek' => ['label' => 'B1. Nama objek (seni tari)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
                'b2_jenis' => ['label' => 'B2. Jenis seni tari', 'type' => 'text', 'placeholder' => 'Masukkan jenis seni tari'],
                'b3_etnis' => ['label' => 'B3. Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis'],
                'b4_properti' => ['label' => 'B4. Properti yang digunakan', 'type' => 'textarea', 'placeholder' => 'Sebutkan properti yang digunakan'],
                'b5_fungsi' => ['label' => 'B5. Fungsi seni tari', 'type' => 'textarea', 'placeholder' => 'Jelaskan fungsi seni tari'],
            ],
        ],
    ],

    // ========================================================================
    // I. PERMAINAN RAKYAT
    // ========================================================================
    'Permainan Rakyat' => [
        'has_sub' => false,
        'fields' => [
            'b1_nama_objek' => ['label' => 'B1. Nama objek (permainan rakyat)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
            'b2_etnis' => ['label' => 'B2. Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis'],
            'b3_lokasi' => ['label' => 'B3. Lokasi permainan rakyat', 'type' => 'text', 'placeholder' => 'Masukkan lokasi'],
            'b4_jumlah_min' => ['label' => 'B4. Jumlah pemain minimal', 'type' => 'text', 'placeholder' => 'Masukkan jumlah minimal'],
            'b5_jumlah_max' => ['label' => 'B5. Jumlah pemain maksimal', 'type' => 'text', 'placeholder' => 'Masukkan jumlah maksimal'],
            'b6_perlengkapan' => ['label' => 'B6. Perlengkapan permainan rakyat', 'type' => 'textarea', 'placeholder' => 'Sebutkan perlengkapan'],
            'b7_aturan' => ['label' => 'B7. Aturan permainan', 'type' => 'textarea', 'placeholder' => 'Jelaskan aturan permainan'],
            'b8_nilai_moral' => ['label' => 'B8. Nilai moral yang terkandung', 'type' => 'textarea', 'placeholder' => 'Jelaskan nilai moral'],
        ],
    ],

    // ========================================================================
    // J. OLAHRAGA TRADISIONAL
    // ========================================================================
    'Olahraga Tradisional' => [
        'has_sub' => false,
        'fields' => [
            'b1_nama_objek' => ['label' => 'B1. Nama objek (olahraga tradisional)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek'],
            'b2_etnis' => ['label' => 'B2. Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis'],
            'b3_lokasi' => ['label' => 'B3. Lokasi olahraga tradisional', 'type' => 'text', 'placeholder' => 'Masukkan lokasi'],
            'b4_jumlah_min' => ['label' => 'B4. Jumlah pemain minimal', 'type' => 'text', 'placeholder' => 'Masukkan jumlah minimal'],
            'b5_jumlah_max' => ['label' => 'B5. Jumlah pemain maksimal', 'type' => 'text', 'placeholder' => 'Masukkan jumlah maksimal'],
            'b6_perlengkapan' => ['label' => 'B6. Perlengkapan olahraga tradisional', 'type' => 'textarea', 'placeholder' => 'Sebutkan perlengkapan'],
            'b7_aturan' => ['label' => 'B7. Aturan permainan', 'type' => 'textarea', 'placeholder' => 'Jelaskan aturan permainan'],
            'b8_nilai_moral' => ['label' => 'B8. Nilai moral yang terkandung', 'type' => 'textarea', 'placeholder' => 'Jelaskan nilai moral'],
        ],
    ],

    // ========================================================================
    // K. CAGAR BUDAYA (existing, keep for backward compat)
    // ========================================================================
    'Cagar Budaya' => [
        'has_sub' => false,
        'fields' => [
            'jenis_objek' => ['label' => 'Jenis Objek', 'type' => 'select', 'options' => ['Candi', 'Benteng', 'Istana/Keraton', 'Makam', 'Situs Arkeologi', 'Benda Bersejarah', 'Keris', 'Prasasti', 'Lainnya'], 'placeholder' => 'Pilih jenis objek'],
            'periode_sejarah' => ['label' => 'Periode Sejarah', 'type' => 'text', 'placeholder' => 'Periode atau era sejarah'],
            'kondisi' => ['label' => 'Kondisi', 'type' => 'select', 'options' => ['Baik', 'Cukup Baik', 'Rusak Ringan', 'Rusak Berat', 'Reruntuhan'], 'placeholder' => 'Pilih kondisi'],
            'dimensi_ukuran' => ['label' => 'Dimensi / Ukuran', 'type' => 'text', 'placeholder' => 'Ukuran atau dimensi objek'],
            'bahan_material' => ['label' => 'Bahan Material', 'type' => 'text', 'placeholder' => 'Material utama objek'],
        ],
    ],
];
