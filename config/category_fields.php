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
                'nama_objek' => ['label' => 'Nama Objek', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'jenis_objek' => ['label' => 'Jenis Objek', 'type' => 'text', 'placeholder' => 'Masukkan jenis objek'],
                'etnis_penutur' => ['label' => 'Etnis Penutur', 'type' => 'text', 'placeholder' => 'Masukkan etnis penutur', 'required' => true],
            ],
            'cerita_rakyat' => [
                'nama_objek' => ['label' => 'Nama Objek Cerita Rakyat', 'type' => 'text', 'placeholder' => 'Masukkan nama objek cerita rakyat', 'required' => true],
                'kategori_cerita' => ['label' => 'Kategori Cerita Rakyat', 'type' => 'text', 'placeholder' => 'Masukkan kategori cerita rakyat'],
                'etnis_penutur' => ['label' => 'Etnis Penutur', 'type' => 'text', 'placeholder' => 'Masukkan etnis penutur', 'required' => true],
                'medium_penyajian' => ['label' => 'Medium Penyajian', 'type' => 'text', 'placeholder' => 'Masukkan medium penyajian'],
                'komponen_tokoh' => ['label' => 'Komponen Tokoh/Pelaku Dalam Cerita Rakyat', 'type' => 'textarea', 'placeholder' => 'Sebutkan komponen tokoh/pelaku'],
            ],
        ],
    ],

    // ========================================================================
    // B. BAHASA
    // ========================================================================
    'Bahasa' => [
        'has_sub' => false,
        'fields' => [
            'nama_objek' => ['label' => 'Nama Objek Bahasa', 'type' => 'text', 'placeholder' => 'Masukkan nama objek bahasa', 'required' => true],
            'jenis_aksara' => ['label' => 'Jenis Aksara yang Digunakan', 'type' => 'text', 'placeholder' => 'Masukkan jenis aksara'],
            'etnis' => ['label' => 'Etnis yang menggunakan bahasa tersebut', 'type' => 'text', 'placeholder' => 'Masukkan etnis pengguna bahasa', 'required' => true],
            'memiliki_dialek' => ['label' => 'Apakah bahasa tersebut memiliki dialek?', 'type' => 'radio', 'options' => ['Ya', 'Tidak']],
            'dialek_table' => [
                'label' => 'Identifikasi Dialek Bahasa yang Masih Ada',
                'type' => 'dynamic_table',
                'columns' => ['Nama Dialek', 'Jumlah Penutur (Orang)'],
                'column_keys' => ['nama_dialek', 'jumlah_penutur'],
                'condition' => ['field' => 'memiliki_dialek', 'value' => 'Ya'],
            ],
        ],
    ],

    // ========================================================================
    // C. MANUSKRIP
    // ========================================================================
    'Manuskrip' => [
        'has_sub' => false,
        'fields' => [
            'nama_objek' => ['label' => 'Nama Objek Manuskrip', 'type' => 'text', 'placeholder' => 'Masukkan nama objek manuskrip', 'required' => true],
            'judul' => ['label' => 'Judul Manuskrip', 'type' => 'text', 'placeholder' => 'Masukkan judul manuskrip', 'required' => true],
            'bahan' => ['label' => 'Bahan Manuskrip', 'type' => 'select', 'options' => ['Kertas', 'Lontar', 'Kayu', 'Batu', 'Lainnya'], 'placeholder' => 'Pilih bahan manuskrip', 'required' => true],
            'bahan_lainnya' => ['label' => 'Sebutkan bahan lainnya', 'type' => 'text', 'placeholder' => 'Sebutkan bahan lainnya', 'condition' => ['field' => 'bahan', 'value' => 'Lainnya']],
            'bahasa' => ['label' => 'Bahasa yang digunakan', 'type' => 'text', 'placeholder' => 'Masukkan bahasa yang digunakan'],
            'karya' => ['label' => 'Karya', 'type' => 'text', 'placeholder' => 'Masukkan karya'],
            'subjek' => ['label' => 'Subjek', 'type' => 'text', 'placeholder' => 'Masukkan subjek'],
            'periode' => ['label' => 'Periode', 'type' => 'select', 'options' => ['Masa Prasejarah', 'Masa Klasik Hindu Buddha', 'Masa Islam', 'Masa Kolonial', 'Masa Kemerdekaan', 'Masa Modern'], 'placeholder' => 'Pilih periode'],
            'nama_tempat' => ['label' => 'Nama tempat lokasi', 'type' => 'text', 'placeholder' => 'Masukkan nama tempat lokasi'],
            'alamat_penyimpanan' => ['label' => 'Alamat lokasi penyimpanan (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
            'jumlah' => ['label' => 'Jumlah Manuskrip', 'type' => 'text', 'placeholder' => 'Masukkan jumlah manuskrip'],
            'satuan' => ['label' => 'Satuan Manuskrip', 'type' => 'select', 'options' => ['Lembar', 'Gulungan', 'Buku', 'Jilid', 'Berkas', 'Lempeng', 'Lainnya'], 'placeholder' => 'Pilih satuan'],
            'satuan_lainnya' => ['label' => 'Sebutkan satuan lainnya', 'type' => 'text', 'placeholder' => 'Sebutkan satuan lainnya', 'condition' => ['field' => 'satuan', 'value' => 'Lainnya']],
            'panjang' => ['label' => 'Ukuran - Panjang (cm)', 'type' => 'text', 'placeholder' => 'Panjang'],
            'lebar' => ['label' => 'Ukuran - Lebar (cm)', 'type' => 'text', 'placeholder' => 'Lebar'],
            'tinggi' => ['label' => 'Ukuran - Tinggi (cm)', 'type' => 'text', 'placeholder' => 'Tinggi'],
            'mengetahui_pencipta' => ['label' => 'Apakah mengetahui pencipta asli manuskrip?', 'type' => 'radio', 'options' => ['Ya', 'Tidak']],
            'nama_pencipta' => ['label' => 'Nama pencipta manuskrip', 'type' => 'text', 'placeholder' => 'Masukkan nama pencipta', 'condition' => ['field' => 'mengetahui_pencipta', 'value' => 'Ya']],
        ],
    ],

    // ========================================================================
    // D. ADAT ISTIADAT
    // ========================================================================
    'Adat Istiadat' => [
        'has_sub' => false,
        'fields' => [
            'nama_objek' => ['label' => 'Nama Objek Adat Istiadat', 'type' => 'text', 'placeholder' => 'Masukkan nama objek adat istiadat', 'required' => true],
            'jenis' => ['label' => 'Jenis Adat Istiadat', 'type' => 'text', 'placeholder' => 'Masukkan jenis adat istiadat'],
            'etnis' => ['label' => 'Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis yang melaksanakan', 'required' => true],
            'masih_dilaksanakan' => ['label' => 'Apakah adat istiadat tersebut masih dilaksanakan hingga saat ini?', 'type' => 'radio', 'options' => ['Ya', 'Tidak']],
            'tahun_terakhir_pelaksanaan_ya' => ['label' => 'Tahun terakhir pelaksanaan', 'type' => 'date', 'placeholder' => 'Pilih tanggal terakhir pelaksanaan', 'condition' => ['field' => 'masih_dilaksanakan', 'value' => 'Ya']],
            'tahun_terakhir_pelaksanaan_tidak' => ['label' => 'Tahun terakhir pelaksanaan', 'type' => 'date', 'placeholder' => 'Pilih tanggal terakhir pelaksanaan', 'condition' => ['field' => 'masih_dilaksanakan', 'value' => 'Tidak']],
        ],
    ],

    // ========================================================================
    // E. RITUS
    // ========================================================================
    'Ritus' => [
        'has_sub' => false,
        'fields' => [
            'nama_objek' => ['label' => 'Nama Objek Ritus', 'type' => 'text', 'placeholder' => 'Masukkan nama objek ritus', 'required' => true],
            'jenis' => ['label' => 'Jenis Ritus', 'type' => 'text', 'placeholder' => 'Masukkan jenis ritus'],
            'etnis' => ['label' => 'Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis yang melaksanakan', 'required' => true],
            'lokasi' => ['label' => 'Lokasi pelaksanaan Ritus', 'type' => 'text', 'placeholder' => 'Masukkan lokasi pelaksanaan'],
            'komponen_pelaku' => ['label' => 'Komponen Pelaku Ritus', 'type' => 'textarea', 'placeholder' => 'Sebutkan komponen pelaku ritus'],
            'tujuan_rapalan' => ['label' => 'Tujuan Penggunaan Rapalan/Mantra', 'type' => 'textarea', 'placeholder' => 'Jelaskan tujuan penggunaan rapalan/mantra'],
            'perlengkapan' => ['label' => 'Perlengkapan Ritus', 'type' => 'textarea', 'placeholder' => 'Sebutkan perlengkapan ritus'],
            'masih_dilaksanakan' => ['label' => 'Apakah Ritus tersebut masih dilaksanakan hingga saat ini?', 'type' => 'radio', 'options' => ['Ya, secara terbuka', 'Ya, secara tertutup', 'Tidak']],
            'tahun_terakhir_pelaksanaan' => ['label' => 'Tahun Terakhir Pelaksanaan', 'type' => 'date', 'placeholder' => 'Pilih tanggal terakhir pelaksanaan', 'condition' => ['field' => 'masih_dilaksanakan', 'value' => 'Tidak']],
            'alasan_tidak_dilaksanakan' => ['label' => 'Alasan sudah tidak dilaksanakan', 'type' => 'textarea', 'placeholder' => 'Jelaskan alasan', 'condition' => ['field' => 'masih_dilaksanakan', 'value' => 'Tidak']],
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
                'nama_objek' => ['label' => 'Nama objek (makanan/minuman)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'jenis' => ['label' => 'Jenis makanan/minuman', 'type' => 'text', 'placeholder' => 'Masukkan jenis makanan/minuman'],
                'etnis' => ['label' => 'Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis', 'required' => true],
                'lokasi_sentra' => ['label' => 'Lokasi sentra pembuatan/produksi (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'bahan_baku' => ['label' => 'Bahan baku pembuatan', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan baku pembuatan'],
                'cara_pembuatan' => ['label' => 'Cara pembuatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan cara pembuatan'],
                'cara_waktu_penyajian' => ['label' => 'Cara dan waktu penyajian', 'type' => 'textarea', 'placeholder' => 'Jelaskan cara dan waktu penyajian'],
                'cara_waktu_penyimpanan' => ['label' => 'Cara dan waktu penyimpanan', 'type' => 'textarea', 'placeholder' => 'Jelaskan cara dan waktu penyimpanan'],
            ],
            'pengetahuan' => [
                'nama_objek' => ['label' => 'Nama objek (pengetahuan)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'jenis' => ['label' => 'Jenis pengetahuan', 'type' => 'checkbox_group', 'options' => ['Bercocok tanam', 'Ilmu falak/ilmu perbintangan', 'Pengetahuan keharmonisan rumah tangga', 'Pengetahuan kebencanaan', 'Lainnya'], 'required' => true],
                'jenis_lainnya' => ['label' => 'Sebutkan jenis lainnya', 'type' => 'text', 'placeholder' => 'Sebutkan jenis pengetahuan lainnya'],
                'etnis' => ['label' => 'Etnis yang menggunakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis', 'required' => true],
                'lokasi' => ['label' => 'Lokasi penggunaan (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'perkiraan_usia' => ['label' => 'Perkiraan usia penggunaan', 'type' => 'text', 'placeholder' => 'Masukkan perkiraan usia penggunaan'],
                'kegunaan' => ['label' => 'Kegunaan pengetahuan tradisional', 'type' => 'textarea', 'placeholder' => 'Jelaskan kegunaan pengetahuan tradisional'],
            ],
            'rempah_bumbu' => [
                'nama_objek' => ['label' => 'Nama objek (Rempah dan Bumbu)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'etnis' => ['label' => 'Etnis yang menggunakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis', 'required' => true],
                'lokasi_sentra' => ['label' => 'Lokasi sentra pembuatan (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'masih_ada' => ['label' => 'Apakah bumbu dan rempah tersebut masih ada dan digunakan?', 'type' => 'radio', 'options' => ['Ada', 'Tidak ada']],
                'cara_penggunaan' => ['label' => 'Cara penggunaan', 'type' => 'textarea', 'placeholder' => 'Jelaskan cara penggunaan'],
                'manfaat' => ['label' => 'Manfaat penggunaan', 'type' => 'textarea', 'placeholder' => 'Jelaskan manfaat penggunaan'],
            ],
            'pakaian_tradisional' => [
                'nama_objek' => ['label' => 'Nama objek (pakaian tradisional)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'etnis' => ['label' => 'Etnis yang menggunakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis', 'required' => true],
                'lokasi_sentra' => ['label' => 'Lokasi sentra pembuatan (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'teknik' => ['label' => 'Teknik pembuatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan teknik pembuatan'],
                'bahan' => ['label' => 'Bahan yang digunakan', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan yang digunakan'],
                'kriteria_pengguna' => ['label' => 'Kriteria - Orang yang menggunakan', 'type' => 'text', 'placeholder' => 'Siapa yang menggunakan'],
                'kriteria_waktu' => ['label' => 'Kriteria - Waktu penggunaan', 'type' => 'text', 'placeholder' => 'Kapan digunakan'],
                'kriteria_tempat' => ['label' => 'Kriteria - Tempat penggunaan', 'type' => 'text', 'placeholder' => 'Di mana digunakan'],
            ],
            'kerajinan' => [
                'nama_objek' => ['label' => 'Nama Objek (Kerajinan)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'etnis' => ['label' => 'Etnis yang membuat kerajinan tersebut', 'type' => 'text', 'placeholder' => 'Masukkan etnis', 'required' => true],
                'lokasi_sentra' => ['label' => 'Lokasi sentra pembuatan (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'teknik' => ['label' => 'Teknik pembuatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan teknik pembuatan'],
                'bahan_baku' => ['label' => 'Bahan baku', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan baku'],
                'kegunaan' => ['label' => 'Kegunaan/tujuan pembuatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan kegunaan/tujuan pembuatan'],
            ],
            'metode_penyehatan' => [
                'nama_objek' => ['label' => 'Nama Objek (Metode Penyehatan)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'etnis' => ['label' => 'Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis', 'required' => true],
                'lokasi' => ['label' => 'Lokasi Praktik Metode Penyehatan (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'tata_cara' => ['label' => 'Tata Cara Penyehatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan tata cara penyehatan'],
                'peralatan' => ['label' => 'Peralatan yang digunakan', 'type' => 'textarea', 'placeholder' => 'Sebutkan peralatan yang digunakan'],
            ],
            'jamu_ramuan' => [
                'nama_objek' => ['label' => 'Nama Objek (Jamu/Ramuan Tradisional)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'jenis' => ['label' => 'Jenis Ramuan Tradisional', 'type' => 'text', 'placeholder' => 'Masukkan jenis ramuan'],
                'etnis' => ['label' => 'Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis', 'required' => true],
                'lokasi_sentra' => ['label' => 'Lokasi Sentra Pembuatan/Produksi (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan'],
                'khasiat' => ['label' => 'Khasiat Jamu/Ramuan Tradisional', 'type' => 'textarea', 'placeholder' => 'Jelaskan khasiat'],
                'bahan_baku' => ['label' => 'Bahan Baku Pembuatan', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan baku'],
                'cara_pembuatan' => ['label' => 'Cara Pembuatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan cara pembuatan'],
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
                'nama_objek' => ['label' => 'Nama objek (arsitektur tradisional)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'fungsi_utama' => ['label' => 'Fungsi utama arsitektur', 'type' => 'text', 'placeholder' => 'Masukkan fungsi utama'],
                'etnis' => ['label' => 'Etnis yang menggunakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis', 'required' => true],
                'lokasi' => ['label' => 'Lokasi arsitektur (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan', 'required' => true],
                'bahan' => ['label' => 'Bahan arsitektur', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan arsitektur'],
                'nama_simbol' => ['label' => 'Nama unsur/simbol', 'type' => 'text', 'placeholder' => 'Masukkan nama unsur/simbol'],
                'makna_simbol' => ['label' => 'Makna yang terkandung dalam unsur/simbol', 'type' => 'textarea', 'placeholder' => 'Jelaskan makna simbol'],
            ],
            'pengolahan_lahan' => [
                'nama_objek' => ['label' => 'Nama objek (sistem pengolahan lahan)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'etnis' => ['label' => 'Etnis yang menggunakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis', 'required' => true],
                'waktu_mulai' => ['label' => 'Waktu mulai penggunaan', 'type' => 'text', 'placeholder' => 'Harap diisi with satuan waktu yang digunakan'],
                'lokasi' => ['label' => 'Lokasi penggunaan (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan', 'required' => true],
                'bahan_baku' => ['label' => 'Bahan baku yang digunakan', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan baku'],
                'fungsi' => ['label' => 'Fungsi teknologi', 'type' => 'textarea', 'placeholder' => 'Jelaskan fungsi teknologi'],
            ],
            'instrumen_musik' => [
                'nama_objek' => ['label' => 'Nama objek (Instrumen musik)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'etnis' => ['label' => 'Etnis yang menggunakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis', 'required' => true],
                'lokasi_sentra' => ['label' => 'Lokasi sentra pembuatan instrumen (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan', 'required' => true],
                'bahan_baku' => ['label' => 'Bahan baku pembuatan instrumen', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan baku'],
                'cara_pembuatan' => ['label' => 'Cara pembuatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan cara pembuatan'],
                'cara_penggunaan' => ['label' => 'Cara penggunaan', 'type' => 'textarea', 'placeholder' => 'Jelaskan cara penggunaan'],
            ],
            'alat_produksi' => [
                'nama_objek' => ['label' => 'Nama objek (Alat produksi)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'etnis' => ['label' => 'Etnis yang menggunakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis', 'required' => true],
                'lokasi' => ['label' => 'Lokasi pembuatan alat produksi (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan', 'required' => true],
                'bahan_baku' => ['label' => 'Bahan baku pembuatan alat produksi', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan baku'],
                'waktu_mulai' => ['label' => 'Waktu mulai penggunaan', 'type' => 'text', 'placeholder' => 'Harap diisi with satuan waktu yang digunakan'],
                'fungsi' => ['label' => 'Fungsi alat produksi', 'type' => 'textarea', 'placeholder' => 'Jelaskan fungsi alat produksi'],
                'objek_dihasilkan' => ['label' => 'Objek yang dihasilkan dari alat produksi', 'type' => 'textarea', 'placeholder' => 'Sebutkan objek yang dihasilkan'],
            ],
            'senjata' => [
                'nama_objek' => ['label' => 'Nama objek (senjata tradisional)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'etnis' => ['label' => 'Etnis yang menggunakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis', 'required' => true],
                'lokasi_sentra' => ['label' => 'Lokasi sentra pembuatan senjata (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan', 'required' => true],
                'bahan_baku' => ['label' => 'Bahan baku pembuatan senjata', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan baku'],
                'fungsi' => ['label' => 'Fungsi senjata', 'type' => 'textarea', 'placeholder' => 'Jelaskan fungsi senjata'],
            ],
            'teknologi_penunjang' => [
                'nama_objek' => ['label' => 'Nama objek (teknologi penunjang)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'opk_terkait' => ['label' => 'OPK terkait', 'type' => 'text', 'placeholder' => 'Masukkan OPK terkait'],
                'etnis' => ['label' => 'Etnis yang menggunakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis', 'required' => true],
                'waktu_mulai' => ['label' => 'Waktu mulai penggunaan teknologi', 'type' => 'text', 'placeholder' => 'Harap diisi with satuan waktu yang digunakan'],
                'lokasi' => ['label' => 'Lokasi penggunaan (dari provinsi hingga desa/kelurahan)', 'type' => 'textarea', 'placeholder' => 'Harap diisi mulai dari provinsi hingga desa/kelurahan', 'required' => true],
                'bahan_baku' => ['label' => 'Bahan baku/peralatan yang digunakan', 'type' => 'textarea', 'placeholder' => 'Sebutkan bahan baku/peralatan'],
                'fungsi' => ['label' => 'Fungsi teknologi', 'type' => 'textarea', 'placeholder' => 'Jelaskan fungsi teknologi'],
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
                'nama_objek' => ['label' => 'Nama objek (seni rupa)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'jenis' => ['label' => 'Jenis seni rupa', 'type' => 'text', 'placeholder' => 'Masukkan jenis seni rupa'],
                'media' => ['label' => 'Media pembuatan', 'type' => 'text', 'placeholder' => 'Masukkan media pembuatan', 'required' => true],
                'teknik' => ['label' => 'Teknik pembuatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan teknik pembuatan'],
                'tahun' => ['label' => 'Tahun penciptaan', 'type' => 'date', 'placeholder' => 'Pilih tanggal penciptaan'],
                'jumlah_publikasi' => ['label' => 'Jumlah publikasi/pameran seni rupa dalam lima tahun terakhir', 'type' => 'text', 'placeholder' => 'Masukkan jumlah'],
            ],
            'seni_media_baru' => [
                'nama_objek' => ['label' => 'Nama objek (seni media baru)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'teknik' => ['label' => 'Teknik pembuatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan teknik pembuatan'],
                'tahun' => ['label' => 'Tahun penciptaan', 'type' => 'date', 'placeholder' => 'Pilih tanggal penciptaan'],
                'jumlah_publikasi' => ['label' => 'Jumlah publikasi/pameran seni media baru dalam setahun terakhir', 'type' => 'text', 'placeholder' => 'Masukkan jumlah'],
            ],
            'seni_film' => [
                'nama_objek' => ['label' => 'Nama objek (film)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'jenis' => ['label' => 'Jenis film', 'type' => 'text', 'placeholder' => 'Masukkan jenis film'],
                'tahun' => ['label' => 'Tahun penciptaan', 'type' => 'date', 'placeholder' => 'Pilih tanggal penciptaan'],
                'produser' => ['label' => 'Produser', 'type' => 'text', 'placeholder' => 'Masukkan nama produser'],
                'sutradara' => ['label' => 'Sutradara', 'type' => 'text', 'placeholder' => 'Masukkan nama sutradara'],
                'penulis' => ['label' => 'Penulis', 'type' => 'text', 'placeholder' => 'Masukkan nama penulis'],
                'pemeran' => ['label' => 'Pemeran', 'type' => 'textarea', 'placeholder' => 'Sebutkan pemeran'],
                'genre' => ['label' => 'Genre', 'type' => 'text', 'placeholder' => 'Masukkan genre'],
                'durasi' => ['label' => 'Durasi', 'type' => 'text', 'placeholder' => 'Masukkan durasi'],
            ],
            'seni_sastra' => [
                'nama_objek' => ['label' => 'Nama objek (seni sastra)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'media' => ['label' => 'Media penyebaran seni sastra', 'type' => 'text', 'placeholder' => 'Masukkan media penyebaran'],
                'tahun' => ['label' => 'Tahun penciptaan', 'type' => 'date', 'placeholder' => 'Pilih tanggal penciptaan'],
                'jumlah_publikasi' => ['label' => 'Jumlah publikasi karya sastra dalam setahun terakhir', 'type' => 'text', 'placeholder' => 'Masukkan jumlah'],
            ],
            'lagu' => [
                'nama_objek' => ['label' => 'Nama objek (lagu)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'pencipta' => ['label' => 'Nama pencipta lagu', 'type' => 'text', 'placeholder' => 'Masukkan nama pencipta'],
                'tahun' => ['label' => 'Tahun penciptaan', 'type' => 'date', 'placeholder' => 'Pilih tanggal penciptaan'],
                'label_penerbit' => ['label' => 'Label/publisher', 'type' => 'text', 'placeholder' => 'Masukkan label/publisher'],
                'genre' => ['label' => 'Genre lagu', 'type' => 'text', 'placeholder' => 'Masukkan genre'],
            ],
            'naskah_skenario' => [
                'nama_objek' => ['label' => 'Nama objek (naskah skenario)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'penulis' => ['label' => 'Nama penulis naskah skenario', 'type' => 'text', 'placeholder' => 'Masukkan nama penulis'],
                'tahun' => ['label' => 'Tahun penciptaan', 'type' => 'date', 'placeholder' => 'Pilih tanggal penciptaan'],
            ],
            'seni_pertunjukan' => [
                'nama_objek' => ['label' => 'Nama objek (seni pertunjukan)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'jenis' => ['label' => 'Jenis seni pertunjukan', 'type' => 'text', 'placeholder' => 'Masukkan jenis seni pertunjukan'],
                'etnis' => ['label' => 'Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis', 'required' => true],
                'penokohan' => ['label' => 'Penokohan dalam seni pertunjukan', 'type' => 'textarea', 'placeholder' => 'Jelaskan penokohan'],
                'nilai' => ['label' => 'Nilai yang disampaikan dalam seni pertunjukan', 'type' => 'textarea', 'placeholder' => 'Jelaskan nilai yang disampaikan'],
            ],
            'seni_musik' => [
                'nama_objek' => ['label' => 'Nama objek (seni musik)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'jenis' => ['label' => 'Jenis seni musik', 'type' => 'text', 'placeholder' => 'Masukkan jenis seni musik'],
                'etnis' => ['label' => 'Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis', 'required' => true],
                'bahasa' => ['label' => 'Bahasa yang digunakan', 'type' => 'text', 'placeholder' => 'Masukkan bahasa'],
                'komponen_alat' => ['label' => 'Komponen alat musik', 'type' => 'textarea', 'placeholder' => 'Sebutkan komponen alat musik'],
            ],
            'seni_tari' => [
                'nama_objek' => ['label' => 'Nama objek (seni tari)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'jenis' => ['label' => 'Jenis seni tari', 'type' => 'text', 'placeholder' => 'Masukkan jenis seni tari'],
                'etnis' => ['label' => 'Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis', 'required' => true],
                'properti' => ['label' => 'Properti yang digunakan', 'type' => 'textarea', 'placeholder' => 'Sebutkan properti yang digunakan'],
                'fungsi' => ['label' => 'Fungsi seni tari', 'type' => 'textarea', 'placeholder' => 'Jelaskan fungsi seni tari'],
            ],
        ],
    ],

    // ========================================================================
    // I. PERMAINAN RAKYAT
    // ========================================================================
    'Permainan Rakyat' => [
        'has_sub' => false,
        'fields' => [
            'nama_objek' => ['label' => 'Nama objek (permainan rakyat)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
            'etnis' => ['label' => 'Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis', 'required' => true],
            'lokasi' => ['label' => 'Lokasi permainan rakyat', 'type' => 'text', 'placeholder' => 'Masukkan lokasi', 'required' => true],
            'jumlah_pemain_minimal' => ['label' => 'Jumlah pemain minimal', 'type' => 'text', 'placeholder' => 'Masukkan jumlah minimal'],
            'jumlah_pemain_maksimal' => ['label' => 'Jumlah pemain maksimal', 'type' => 'text', 'placeholder' => 'Masukkan jumlah maksimal'],
            'perlengkapan' => ['label' => 'Perlengkapan permainan rakyat', 'type' => 'textarea', 'placeholder' => 'Sebutkan perlengkapan'],
            'aturan' => ['label' => 'Aturan permainan', 'type' => 'textarea', 'placeholder' => 'Jelaskan aturan permainan'],
            'nilai_moral' => ['label' => 'Nilai moral yang terkandung', 'type' => 'textarea', 'placeholder' => 'Jelaskan nilai moral'],
        ],
    ],

    // ========================================================================
    // J. OLAHRAGA TRADISIONAL
    // ========================================================================
    'Olahraga Tradisional' => [
        'has_sub' => false,
        'fields' => [
            'nama_objek' => ['label' => 'Nama objek (olahraga tradisional)', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
            'etnis' => ['label' => 'Etnis yang melaksanakan', 'type' => 'text', 'placeholder' => 'Masukkan etnis', 'required' => true],
            'lokasi' => ['label' => 'Lokasi olahraga tradisional', 'type' => 'text', 'placeholder' => 'Masukkan lokasi', 'required' => true],
            'jumlah_pemain_minimal' => ['label' => 'Jumlah pemain minimal', 'type' => 'text', 'placeholder' => 'Masukkan jumlah minimal'],
            'jumlah_pemain_maksimal' => ['label' => 'Jumlah pemain maksimal', 'type' => 'text', 'placeholder' => 'Masukkan jumlah maksimal'],
            'perlengkapan' => ['label' => 'Perlengkapan olahraga tradisional', 'type' => 'textarea', 'placeholder' => 'Sebutkan perlengkapan'],
            'aturan' => ['label' => 'Aturan permainan', 'type' => 'textarea', 'placeholder' => 'Jelaskan aturan permainan'],
            'nilai_moral' => ['label' => 'Nilai moral yang terkandung', 'type' => 'textarea', 'placeholder' => 'Jelaskan nilai moral'],
        ],
    ],

    // ========================================================================
    // K. CAGAR BUDAYA (existing, keep for backward compat)
    // ========================================================================
    'Cagar Budaya' => [
        'has_sub' => true,
        'sub_field' => 'jenis_cagar_budaya',
        'sub_label' => 'Jenis Cagar Budaya',
        'sub_options' => [
            'kawasan' => 'Kawasan',
            'situs' => 'Situs',
            'struktur' => 'Struktur',
            'bangunan' => 'Bangunan',
            'benda' => 'Benda',
        ],
        'fields' => [
            'kawasan' => [
                // Identitas Umum
                'nama_objek' => ['label' => 'Nama ODCB/CB di lapangan', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'fungsi_kawasan' => [
                    'label' => 'Fungsi kawasan', 
                    'type' => 'select', 
                    'options' => ['Pemukiman', 'Perindustrian', 'Peribadatan', 'Kota lama', 'Militer', 'Lingkungan purba', 'Pemerintah', 'Lainnya'],
                    'placeholder' => 'Pilih fungsi kawasan',
                    'required' => true
                ],
                'sifat_objek' => ['label' => 'Sifat objek', 'type' => 'select', 'options' => ['Sakral', 'Profan'], 'placeholder' => 'Pilih sifat', 'required' => true],
                'lokasi_penemuan' => ['label' => 'Lokasi penemuan', 'type' => 'textarea', 'placeholder' => 'Masukkan lokasi penemuan', 'required' => true],
                'koordinat_lokasi' => ['label' => 'Koordinat lokasi penemuan', 'type' => 'text', 'placeholder' => 'Contoh: -8.1234, 115.1234'],
                'elevasi' => ['label' => 'Elevasi (ketinggian)', 'type' => 'text', 'placeholder' => 'Contoh: 500 mdpl'],
                'periode_objek' => ['label' => 'Periode objek', 'type' => 'select', 'options' => ['Prasejarah', 'Klasik', 'Kolonial', 'Pergerakan', 'Modern'], 'placeholder' => 'Pilih periode'],
                
                // Dimensi
                'luas_kawasan' => ['label' => 'Luas kawasan (m2/km2/ha)', 'type' => 'text', 'placeholder' => 'Masukkan luas kawasan'],
                
                // Kondisi
                'keutuhan' => ['label' => 'Keutuhan', 'type' => 'select', 'options' => ['Utuh', 'Tinggal sebagian', 'Musnah/hilang'], 'placeholder' => 'Pilih kondisi keutuhan', 'required' => true],
                'pemeliharaan' => ['label' => 'Pemeliharaan', 'type' => 'select', 'options' => ['Terpelihara', 'Tidak terpelihara'], 'placeholder' => 'Pilih status pemeliharaan', 'required' => true],
                'pemugaran' => ['label' => 'Pemugaran', 'type' => 'select', 'options' => ['Pernah dipugar', 'Belum pernah dipugar'], 'placeholder' => 'Pilih status pemugaran'],
                'riwayat_pemugaran' => [
                    'label' => 'Riwayat pemugaran', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan riwayat pemugaran',
                    'condition' => ['field' => 'pemugaran', 'value' => 'Pernah dipugar']
                ],
                'adaptasi' => ['label' => 'Adaptasi', 'type' => 'select', 'options' => ['Ada adaptasi', 'Tidak ada penambahan'], 'placeholder' => 'Pilih status adaptasi'],
                'riwayat_adaptasi' => [
                    'label' => 'Riwayat adaptasi', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan riwayat adaptasi',
                    'condition' => ['field' => 'adaptasi', 'value' => 'Ada adaptasi']
                ],
                
                // Kepemilikan
                'status_kepemilikan' => ['label' => 'Status kepemilikan', 'type' => 'select', 'options' => ['Pemerintah', 'Non-pemerintah'], 'placeholder' => 'Pilih status kepemilikan', 'required' => true],
                'nama_pemilik' => ['label' => 'Nama orang/instansi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan nama pemilik', 'required' => true],
                'alamat_pemilik' => ['label' => 'Alamat', 'type' => 'textarea', 'placeholder' => 'Masukkan alamat pemilik', 'required' => true],
                'koordinat_pemilik' => ['label' => 'Koordinat lokasi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan koordinat pemilik'],
                'perolehan_bangunan' => ['label' => 'Perolehan bangunan', 'type' => 'select', 'options' => ['Warisan', 'Pembelian', 'Hadiah', 'Hibah', 'Tukar menukar', 'Penemuan', 'Putusan pengadilan'], 'placeholder' => 'Pilih cara perolehan'],
                
                // Pengelolaan
                'status_pengelolaan' => ['label' => 'Status pengelolaan', 'type' => 'select', 'options' => ['Dikelola sendiri', 'Dikelola pemerintah', 'Dikelola non-pemerintah'], 'placeholder' => 'Pilih status pengelolaan', 'required' => true],
                'nama_pengelola' => [
                    'label' => 'Nama orang/instansi pengelola', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan nama pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'alamat_pengelola' => [
                    'label' => 'Alamat', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan alamat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'koordinat_pengelola' => [
                    'label' => 'Koordinat', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan koordinat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                
                // Deskripsi
                'deskripsi_detail' => ['label' => 'Deskripsi', 'type' => 'textarea', 'placeholder' => 'Masukkan deskripsi detail'],
                'batas_zonasi' => ['label' => 'Batas zonasi', 'type' => 'textarea', 'placeholder' => 'Masukkan batas zonasi'],
            ],
            
            'situs' => [
                // Identitas Umum
                'nama_objek' => ['label' => 'Nama ODCB/CB di lapangan', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'kelompok_objek' => [
                    'label' => 'Kelompok objek', 
                    'type' => 'select', 
                    'options' => ['Hunian', 'Perindustrian', 'Perkuburan/pemakaman', 'Peribadatan', 'Pertempuran', 'Bawah air', 'Lainnya'],
                    'placeholder' => 'Pilih kelompok objek',
                    'required' => true
                ],
                'sifat_objek' => ['label' => 'Sifat objek', 'type' => 'select', 'options' => ['Sakral', 'Profan'], 'placeholder' => 'Pilih sifat', 'required' => true],
                'lokasi_penemuan' => ['label' => 'Lokasi penemuan', 'type' => 'textarea', 'placeholder' => 'Masukkan lokasi penemuan', 'required' => true],
                'koordinat_lokasi' => ['label' => 'Koordinat lokasi penemuan', 'type' => 'text', 'placeholder' => 'Contoh: -8.1234, 115.1234'],
                'elevasi' => ['label' => 'Elevasi (ketinggian)', 'type' => 'text', 'placeholder' => 'Contoh: 500 mdpl'],
                'periode_objek' => ['label' => 'Periode objek', 'type' => 'select', 'options' => ['Prasejarah', 'Klasik', 'Kolonial', 'Pergerakan', 'Modern'], 'placeholder' => 'Pilih periode'],
                
                // Dimensi
                'panjang' => ['label' => 'Panjang (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan panjang'],
                'lebar' => ['label' => 'Lebar (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan lebar'],
                'luas_tanah' => ['label' => 'Luas tanah (m2/km2/ha)', 'type' => 'text', 'placeholder' => 'Masukkan luas tanah'],
                
                // Kondisi
                'keutuhan' => ['label' => 'Keutuhan', 'type' => 'select', 'options' => ['Utuh', 'Tinggal sebagian', 'Musnah/hilang'], 'placeholder' => 'Pilih kondisi keutuhan', 'required' => true],
                'pemeliharaan' => ['label' => 'Pemeliharaan', 'type' => 'select', 'options' => ['Terpelihara', 'Tidak terpelihara'], 'placeholder' => 'Pilih status pemeliharaan', 'required' => true],
                'pemugaran' => ['label' => 'Pemugaran', 'type' => 'select', 'options' => ['Pernah dipugar', 'Belum pernah dipugar'], 'placeholder' => 'Pilih status pemugaran'],
                'riwayat_pemugaran' => [
                    'label' => 'Riwayat pemugaran', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan riwayat pemugaran',
                    'condition' => ['field' => 'pemugaran', 'value' => 'Pernah dipugar']
                ],
                'adaptasi' => ['label' => 'Adaptasi', 'type' => 'select', 'options' => ['Ada adaptasi', 'Tidak ada penambahan'], 'placeholder' => 'Pilih status adaptasi'],
                'riwayat_adaptasi' => [
                    'label' => 'Riwayat adaptasi', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan riwayat adaptasi',
                    'condition' => ['field' => 'adaptasi', 'value' => 'Ada adaptasi']
                ],
                
                // Kepemilikan
                'status_kepemilikan' => ['label' => 'Status kepemilikan', 'type' => 'select', 'options' => ['Pemerintah', 'Non-pemerintah'], 'placeholder' => 'Pilih status kepemilikan', 'required' => true],
                'nama_pemilik' => ['label' => 'Nama orang/instansi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan nama pemilik', 'required' => true],
                'alamat_pemilik' => ['label' => 'Alamat', 'type' => 'textarea', 'placeholder' => 'Masukkan alamat pemilik', 'required' => true],
                'koordinat_pemilik' => ['label' => 'Koordinat lokasi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan koordinat pemilik'],
                'perolehan_bangunan' => ['label' => 'Perolehan bangunan', 'type' => 'select', 'options' => ['Warisan', 'Pembelian', 'Hadiah', 'Hibah', 'Tukar menukar', 'Penemuan', 'Putusan pengadilan'], 'placeholder' => 'Pilih cara perolehan'],
                
                // Pengelolaan
                'status_pengelolaan' => ['label' => 'Status pengelolaan', 'type' => 'select', 'options' => ['Dikelola sendiri', 'Dikelola pemerintah', 'Dikelola non-pemerintah'], 'placeholder' => 'Pilih status pengelolaan', 'required' => true],
                'nama_pengelola' => [
                    'label' => 'Nama orang/instansi pengelola', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan nama pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'alamat_pengelola' => [
                    'label' => 'Alamat', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan alamat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'koordinat_pengelola' => [
                    'label' => 'Koordinat', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan koordinat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                
                // Deskripsi
                'deskripsi_detail' => ['label' => 'Deskripsi', 'type' => 'textarea', 'placeholder' => 'Masukkan deskripsi detail'],
                'batas_zonasi' => ['label' => 'Batas zonasi', 'type' => 'textarea', 'placeholder' => 'Masukkan batas zonasi'],
            ],
            
            'struktur' => [
                // Identitas Umum
                'nama_objek' => ['label' => 'Nama ODCB/CB di lapangan', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'fungsi_objek' => [
                    'label' => 'Fungsi objek', 
                    'type' => 'select', 
                    'options' => ['Tembok', 'Sumur', 'Kapal selam', 'Kapal', 'Pesawat', 'Saluran air', 'Dermaga', 'Terowongan', 'Gua buatan', 'Menara', 'Bendung', 'Fondasi', 'Tugu', 'Gapura', 'Monumen', 'Pagar', 'Tiang', 'Lantai', 'Umpak', 'Jembatan', 'Makam', 'Lintasan rel', 'Jalan', 'Lainnya'],
                    'placeholder' => 'Pilih fungsi objek',
                    'required' => true
                ],
                'sifat_objek' => ['label' => 'Sifat objek', 'type' => 'select', 'options' => ['Sakral', 'Profan'], 'placeholder' => 'Pilih sifat', 'required' => true],
                'lokasi_penemuan' => ['label' => 'Lokasi penemuan', 'type' => 'textarea', 'placeholder' => 'Masukkan lokasi penemuan', 'required' => true],
                'koordinat_lokasi' => ['label' => 'Koordinat lokasi penemuan', 'type' => 'text', 'placeholder' => 'Contoh: -8.1234, 115.1234'],
                'elevasi' => ['label' => 'Elevasi (ketinggian)', 'type' => 'text', 'placeholder' => 'Contoh: 500 mdpl'],
                'periode_objek' => ['label' => 'Periode objek', 'type' => 'select', 'options' => ['Prasejarah', 'Klasik', 'Kolonial', 'Pergerakan', 'Modern'], 'placeholder' => 'Pilih periode'],
                
                // Informasi Fisik
                'bahan' => ['label' => 'Bahan', 'type' => 'select', 'options' => ['Kayu', 'Bambu', 'Tanah', 'Bata', 'Beton', 'Batu', 'Lainnya'], 'placeholder' => 'Pilih bahan'],
                'waktu_pembuatan' => ['label' => 'Waktu pembuatan (Tahun/Abad)', 'type' => 'text', 'placeholder' => 'Contoh: Abad 14 atau Tahun 1920'],
                'hiasan_ornamen' => [
                    'label' => 'Hiasan/ornamen', 
                    'type' => 'checkbox_group', 
                    'options' => ['Angka', 'Huruf', 'Inskripsi', 'Manusia', 'Antropomorf', 'Tumbuhan', 'Vegemorf', 'Binatang', 'Zuomorf', 'Geometris', 'Lukisan/relief adegan', 'Abstrak', 'Lainnya']
                ],
                'tanda_struktur' => [
                    'label' => 'Tanda yang dimiliki struktur', 
                    'type' => 'checkbox_group', 
                    'options' => ['Angka', 'Huruf', 'Inskripsi', 'Manusia', 'Antropomorf', 'Tumbuhan', 'Vegemorf', 'Binatang', 'Zuomorf', 'Geometris', 'Abstrak', 'Lainnya']
                ],
                
                // Dimensi
                'panjang' => ['label' => 'Panjang (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan panjang'],
                'lebar' => ['label' => 'Lebar (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan lebar'],
                'tinggi' => ['label' => 'Tinggi', 'type' => 'text', 'placeholder' => 'Masukkan tinggi'],
                'diameter_atas' => ['label' => 'Diameter atas (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan diameter atas'],
                'diameter_badan' => ['label' => 'Diameter badan (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan diameter badan'],
                'diameter_kaki' => ['label' => 'Diameter kaki', 'type' => 'text', 'placeholder' => 'Masukkan diameter kaki'],
                'luas_tanah' => ['label' => 'Luas tanah (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan luas tanah'],
                'luas_struktur' => ['label' => 'Luas struktur (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan luas struktur'],
                
                // Kondisi
                'keutuhan' => ['label' => 'Keutuhan', 'type' => 'select', 'options' => ['Utuh', 'Tinggal sebagian', 'Musnah/hilang'], 'placeholder' => 'Pilih kondisi keutuhan', 'required' => true],
                'pemeliharaan' => ['label' => 'Pemeliharaan', 'type' => 'select', 'options' => ['Terpelihara', 'Tidak terpelihara'], 'placeholder' => 'Pilih status pemeliharaan', 'required' => true],
                'pemugaran' => ['label' => 'Pemugaran', 'type' => 'select', 'options' => ['Pernah dipugar', 'Belum pernah dipugar'], 'placeholder' => 'Pilih status pemugaran'],
                'riwayat_pemugaran' => [
                    'label' => 'Riwayat pemugaran', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan riwayat pemugaran',
                    'condition' => ['field' => 'pemugaran', 'value' => 'Pernah dipugar']
                ],
                'adaptasi' => ['label' => 'Adaptasi', 'type' => 'select', 'options' => ['Ada adaptasi', 'Tidak ada penambahan'], 'placeholder' => 'Pilih status adaptasi'],
                
                // Kepemilikan
                'status_kepemilikan' => ['label' => 'Status kepemilikan', 'type' => 'select', 'options' => ['Pemerintah', 'Non-pemerintah'], 'placeholder' => 'Pilih status kepemilikan', 'required' => true],
                'nama_pemilik' => ['label' => 'Nama orang/instansi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan nama pemilik', 'required' => true],
                'alamat_pemilik' => ['label' => 'Alamat', 'type' => 'textarea', 'placeholder' => 'Masukkan alamat pemilik', 'required' => true],
                'koordinat_pemilik' => ['label' => 'Koordinat lokasi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan koordinat pemilik'],
                'perolehan_bangunan' => ['label' => 'Perolehan bangunan', 'type' => 'select', 'options' => ['Warisan', 'Pembelian', 'Hadiah', 'Hibah', 'Tukar menukar', 'Penemuan', 'Putusan pengadilan'], 'placeholder' => 'Pilih cara perolehan'],
                
                // Pengelolaan
                'status_pengelolaan' => ['label' => 'Status pengelolaan', 'type' => 'select', 'options' => ['Dikelola sendiri', 'Dikelola pemerintah', 'Dikelola non-pemerintah'], 'placeholder' => 'Pilih status pengelolaan', 'required' => true],
                'nama_pengelola' => [
                    'label' => 'Nama orang/instansi pengelola', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan nama pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'alamat_pengelola' => [
                    'label' => 'Alamat', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan alamat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'koordinat_pengelola' => [
                    'label' => 'Koordinat', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan koordinat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                
                // Deskripsi
                'deskripsi_detail' => ['label' => 'Deskripsi', 'type' => 'textarea', 'placeholder' => 'Masukkan deskripsi detail'],
                'batas_zonasi' => ['label' => 'Batas zonasi', 'type' => 'textarea', 'placeholder' => 'Masukkan batas zonasi'],
            ],
            
            'bangunan' => [
                // Identitas Umum
                'nama_objek' => ['label' => 'Nama ODCB/CB di lapangan', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'fungsi_objek' => [
                    'label' => 'Fungsi Objek', 
                    'type' => 'select', 
                    'options' => ['Penginapan', 'Rumah', 'Masjid', 'Musholla', 'Katedral', 'Gereja', 'Kapel', 'Wihara', 'Pura', 'Klenteng', 'Warung', 'Toko', 'Rumah toko', 'Pertokoan', 'Balai adat/masyarakat', 'Gedung permuan', 'Museum', 'Galeri', 'Sanggar', 'Teater', 'Rekreasi', 'Stadion', 'Gelanggang', 'Pusat Kebugaran', 'Bangunan Kelas', 'Laboratorium', 'Observatorium', 'Bangunan utama pelabuhan', 'Bangunan utama statsiun', 'Bangunan utama terminal', 'Bangunan utama bandara', 'Bengkel', 'Mercusuar', 'Penjara', 'Industri/pabrik', 'Barak', 'Pertahanan garis depan', 'Klinik', 'Puskesmas', 'Rumah sakit', 'Kantor', 'Musoleum', 'Gudang', 'Lainnya'],
                    'placeholder' => 'Pilih fungsi objek',
                    'required' => true
                ],
                'sifat_objek' => ['label' => 'Sifat Objek', 'type' => 'select', 'options' => ['Sakral', 'Profan'], 'placeholder' => 'Pilih sifat', 'required' => true],
                'lokasi_penemuan' => ['label' => 'Lokasi', 'type' => 'textarea', 'placeholder' => 'Masukkan lokasi', 'required' => true],
                'koordinat_lokasi' => ['label' => 'Koordinat lokasi penemuan', 'type' => 'text', 'placeholder' => 'Contoh: -8.1234, 115.1234'],
                'elevasi' => ['label' => 'Elevasi (ketinggian)', 'type' => 'text', 'placeholder' => 'Contoh: 500 mdpl'],
                'periode_objek' => ['label' => 'Periode objek', 'type' => 'select', 'options' => ['Prasejarah', 'Klasik', 'Kolonial', 'Pergerakan modern'], 'placeholder' => 'Pilih periode'],
                
                // Informasi Fisik
                'bahan' => ['label' => 'Bahan', 'type' => 'checkbox_group', 'options' => ['Kayu', 'Bambu', 'Tanah', 'Bata', 'Beton bertulang', 'Batu', 'Karang', 'Lainnya']],
                'waktu_pembuatan' => ['label' => 'Waktu pembuatan (Tahun/Abad)', 'type' => 'text', 'placeholder' => 'Contoh: Abad 14 atau Tahun 1920'],
                'gaya_arsitektur' => ['label' => 'Gaya arsitektur', 'type' => 'select', 'options' => ['Hindu/Budha', 'Islam', 'Cina', 'Tradisional', 'Kolonial', 'Modern', 'Lainnya'], 'placeholder' => 'Pilih gaya arsitektur'],
                'bentuk_atap' => ['label' => 'Bentuk atap', 'type' => 'select', 'options' => ['Tumpang', 'Kubah', 'Pelana', 'Limas', 'Menara', 'Lainnya'], 'placeholder' => 'Pilih bentuk atap'],
                'hiasan_ornamen' => [
                    'label' => 'Hiasan/ornamen', 
                    'type' => 'checkbox_group', 
                    'options' => ['Angka', 'Huruf', 'Inskripsi', 'Manusia', 'Antropomorf', 'Tumbuhan', 'Vegemorf', 'Binatang', 'Zuomorf', 'Geometris', 'Campuran', 'Lukisan/relief adegan', 'Abstrak', 'Lainnya']
                ],
                'tanda_bangunan' => [
                    'label' => 'Tanda yang dimiliki bangunan', 
                    'type' => 'checkbox_group', 
                    'options' => ['Angka', 'Huruf', 'Inskripsi', 'Manusia', 'Antropomorf', 'Tumbuhan', 'Vegemorf', 'Binatang', 'Zuomorf', 'Geometris', 'Abstrak', 'Lainnya']
                ],
                'warna' => ['label' => 'Warna', 'type' => 'text', 'placeholder' => 'Masukkan warna bangunan'],
                
                // Dimensi
                'panjang' => ['label' => 'Panjang (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan panjang'],
                'lebar' => ['label' => 'Lebar (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan lebar'],
                'tinggi' => ['label' => 'Tinggi (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan tinggi'],
                'luas_bangunan' => ['label' => 'Luas bangunan (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan luas bangunan'],
                'luas_tanah' => ['label' => 'Luas tanah (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan luas tanah'],
                
                // Kondisi
                'keutuhan' => ['label' => 'Keutuhan', 'type' => 'select', 'options' => ['Utuh', 'Tinggal sebagian', 'Musnah/hilang'], 'placeholder' => 'Pilih kondisi keutuhan', 'required' => true],
                'pemeliharaan' => ['label' => 'Pemeliharaan', 'type' => 'select', 'options' => ['Terpelihara', 'Tidak terpelihara'], 'placeholder' => 'Pilih status pemeliharaan', 'required' => true],
                'pemugaran' => ['label' => 'Pemugaran', 'type' => 'select', 'options' => ['Pernah dipugar', 'Belum pernah dipugar'], 'placeholder' => 'Pilih status pemugaran'],
                'riwayat_pemugaran' => [
                    'label' => 'Riwayat pemugaran', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan riwayat pemugaran',
                    'condition' => ['field' => 'pemugaran', 'value' => 'Pernah dipugar']
                ],
                'adaptasi' => ['label' => 'Adaptasi', 'type' => 'select', 'options' => ['Ada adaptasi', 'Tidak ada penambahan'], 'placeholder' => 'Pilih status adaptasi'],
                'riwayat_adaptasi' => [
                    'label' => 'Riwayat adaptasi', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan riwayat adaptasi',
                    'condition' => ['field' => 'adaptasi', 'value' => 'Ada adaptasi']
                ],
                
                // Kepemilikan
                'status_kepemilikan' => ['label' => 'Status kepemilikan', 'type' => 'select', 'options' => ['Pemerintah', 'Non-pemerintah'], 'placeholder' => 'Pilih status kepemilikan', 'required' => true],
                'nama_pemilik' => ['label' => 'Nama orang/instansi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan nama pemilik', 'required' => true],
                'alamat_pemilik' => ['label' => 'Alamat', 'type' => 'textarea', 'placeholder' => 'Masukkan alamat pemilik', 'required' => true],
                'koordinat_pemilik' => ['label' => 'Koordinat lokasi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan koordinat pemilik'],
                'perolehan_bangunan' => ['label' => 'Perolehan bangunan', 'type' => 'select', 'options' => ['Warisan', 'Pembelian', 'Hadiah', 'Hibah', 'Tukar menukar', 'Penemuan', 'Putusan pengadilan'], 'placeholder' => 'Pilih cara perolehan'],
                
                // Pengelolaan
                'status_pengelolaan' => ['label' => 'Status pengelolaan', 'type' => 'select', 'options' => ['Dikelola sendiri', 'Dikelola pemerintah', 'Dikelola non-pemerintah'], 'placeholder' => 'Pilih status pengelolaan', 'required' => true],
                'nama_pengelola' => [
                    'label' => 'Nama orang/instansi pengelola', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan nama pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'alamat_pengelola' => [
                    'label' => 'Alamat', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan alamat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'koordinat_pengelola' => [
                    'label' => 'Koordinat', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan koordinat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                
                // Deskripsi
                'deskripsi_detail' => ['label' => 'Deskripsi', 'type' => 'textarea', 'placeholder' => 'Masukkan deskripsi detail'],
                'batas_zonasi' => ['label' => 'Batas zonasi', 'type' => 'textarea', 'placeholder' => 'Masukkan batas zonasi'],
            ],
            
            'benda' => [
                // Identitas Umum
                'nama_objek' => ['label' => 'Nama ODCB/CB di lapangan', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'kelompok_objek_benda' => [
                    'label' => 'Kelompok objek benda', 
                    'type' => 'select', 
                    'options' => ['Prasasti/inkripsi', 'Peralatan masak', 'Peralatan rumah tangga', 'Peralatan musik', 'Senjata', 'Naskah', 'Rekaman', 'Kendaraan', 'Citra', 'Pakaian', 'Aksesori pakaian', 'Perhiasan', 'Peralatan makan', 'Peralatan seni pertunjukan', 'Peralatan komunikasi', 'Peralatan tulis/gambar', 'Peralatan pertanian/perkebunan', 'Peralatan medis', 'Peralatan perekam audio/visual', 'Peralatan spiritual', 'Fosil', 'Dekorasi rumah', 'Jam dinding/jam almari', 'Alat hitung', 'Alat pembayaran', 'Lainnya'],
                    'placeholder' => 'Pilih kelompok objek',
                    'required' => true
                ],
                'sifat_benda' => ['label' => 'Sifat benda', 'type' => 'select', 'options' => ['Sakral', 'Profan'], 'placeholder' => 'Pilih sifat', 'required' => true],
                'lokasi_penemuan' => ['label' => 'Lokasi penemuan (Provinsi s.d Desa)', 'type' => 'textarea', 'placeholder' => 'Masukkan lokasi penemuan', 'required' => true],
                'koordinat_lokasi' => ['label' => 'Koordinat lokasi penemuan (Lintang & Bujur)', 'type' => 'text', 'placeholder' => 'Contoh: -8.1234, 115.1234'],
                'elevasi' => ['label' => 'Elevasi (ketinggian)', 'type' => 'text', 'placeholder' => 'Contoh: 500 mdpl'],
                'periode_benda' => ['label' => 'Periode benda', 'type' => 'select', 'options' => ['Prasejarah', 'Klasik', 'Kolonial', 'Pergerakan', 'Modern'], 'placeholder' => 'Pilih periode'],
                
                // Informasi Fisik
                'bahan' => [
                    'label' => 'Bahan', 
                    'type' => 'select', 
                    'options' => ['Kayu', 'Rotan', 'Bambu', 'Serat', 'Daun', 'Kulit kayu', 'Karet', 'Getah', 'Bunga', 'Kelopak', 'Buah', 'Kulit buah', 'Biji', 'Tepung', 'Gabus', 'Tulang', 'Gigi', 'Gading', 'Kulit', 'Bulu', 'Rambut', 'Daging', 'Otot', 'Tanduk', 'Cula', 'Paruh', 'Kuku', 'Sutra', 'Katun', 'Sabut', 'Tempurung', 'Lidi', 'Karton', 'Duri', 'Sisik', 'Karapas', 'Kerang', 'Siput', 'Mutiara', 'Karang', 'Batu', 'Pre-fosil', 'Fosil', 'Logam', 'Kaca', 'Tanah', 'Kapur', 'Pasir', 'Keramik', 'Terakota', 'Lilin', 'Aspal', 'Plastik', 'Mika', 'Mineral', 'Poliester', 'Sintetis', 'Lainnya'],
                    'placeholder' => 'Pilih bahan utama'
                ],
                'waktu_pembuatan' => ['label' => 'Waktu pembuatan (Tahun/Abad)', 'type' => 'text', 'placeholder' => 'Contoh: Abad 14 atau Tahun 1920'],
                'hiasan_ornamen' => [
                    'label' => 'Hiasan/ornamen', 
                    'type' => 'checkbox_group', 
                    'options' => ['Angka', 'Huruf', 'Inskripsi/tulisan', 'Manusia', 'Antromorf', 'Abstrak', 'Tumbuhan', 'Vegemorf', 'Binatang', 'Zuomorf', 'Geometris', 'Panorama', 'Campuran', 'Lainnya']
                ],
                'tanda' => [
                    'label' => 'Tanda', 
                    'type' => 'checkbox_group', 
                    'options' => ['Angka', 'Huruf', 'Inskripsi/tulisan', 'Manusia', 'Antromorf', 'Abstrak', 'Tumbuhan', 'Vegemorf', 'Binatang', 'Zuomorf', 'Geometris', 'Panorama', 'Campuran', 'Lainnya']
                ],
                'warna' => ['label' => 'Warna', 'type' => 'text', 'placeholder' => 'Masukkan warna benda'],
                
                // Dimensi
                'panjang' => ['label' => 'Panjang (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan panjang'],
                'lebar' => ['label' => 'Lebar (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan lebar'],
                'tinggi' => ['label' => 'Tinggi (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan tinggi'],
                'tebal' => ['label' => 'Tebal', 'type' => 'text', 'placeholder' => 'Masukkan tebal'],
                'berat' => ['label' => 'Berat', 'type' => 'text', 'placeholder' => 'Masukkan berat'],
                'volume' => ['label' => 'Volume', 'type' => 'text', 'placeholder' => 'Masukkan volume'],
                'diameter_atas' => ['label' => 'Diameter atas', 'type' => 'text', 'placeholder' => 'Masukkan diameter atas'],
                'diameter_badan' => ['label' => 'Diameter badan', 'type' => 'text', 'placeholder' => 'Masukkan diameter badan'],
                'diameter_kaki' => ['label' => 'Diameter kaki', 'type' => 'text', 'placeholder' => 'Masukkan diameter kaki'],
                
                // Kondisi
                'keutuhan' => ['label' => 'Keutuhan', 'type' => 'select', 'options' => ['Utuh', 'Tinggal sebagian', 'Musnah/hilang'], 'placeholder' => 'Pilih kondisi keutuhan', 'required' => true],
                'pemeliharaan' => ['label' => 'Pemeliharaan', 'type' => 'select', 'options' => ['Terpelihara', 'Tidak terpelihara'], 'placeholder' => 'Pilih status pemeliharaan', 'required' => true],
                'pemugaran' => ['label' => 'Pemugaran', 'type' => 'select', 'options' => ['Pernah dipugar', 'Belum pernah dipugar'], 'placeholder' => 'Pilih status pemugaran'],
                'riwayat_pemugaran' => [
                    'label' => 'Riwayat pemugaran', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan riwayat pemugaran',
                    'condition' => ['field' => 'pemugaran', 'value' => 'Pernah dipugar']
                ],
                'adaptasi' => ['label' => 'Adaptasi', 'type' => 'select', 'options' => ['Ada adaptasi', 'Tidak ada penambahan'], 'placeholder' => 'Pilih status adaptasi'],
                'riwayat_adaptasi' => [
                    'label' => 'Riwayat adaptasi', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan riwayat adaptasi',
                    'condition' => ['field' => 'adaptasi', 'value' => 'Ada adaptasi']
                ],
                
                // Kepemilikan
                'status_kepemilikan' => ['label' => 'Status kepemilikan', 'type' => 'select', 'options' => ['Pemerintah', 'Non-pemerintah'], 'placeholder' => 'Pilih status kepemilikan', 'required' => true],
                'nama_pemilik' => ['label' => 'Nama orang/instansi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan nama pemilik', 'required' => true],
                'alamat_pemilik' => ['label' => 'Alamat (Provinsi s.d Desa)', 'type' => 'textarea', 'placeholder' => 'Masukkan alamat pemilik', 'required' => true],
                'koordinat_pemilik' => ['label' => 'Koordinat (Lintang & Bujur)', 'type' => 'text', 'placeholder' => 'Masukkan koordinat pemilik'],
                'perolehan_benda' => ['label' => 'Perolehan benda', 'type' => 'select', 'options' => ['Warisan', 'Pembelian', 'Hadiah', 'Hibah', 'Tukar menukar', 'Penemuan', 'Putusan pengadilan'], 'placeholder' => 'Pilih cara perolehan'],
                
                // Pengelolaan
                'status_pengelolaan' => ['label' => 'Status pengelolaan', 'type' => 'select', 'options' => ['Dikelola sendiri', 'Dikelola pemerintah', 'Dikelola non-pemerintah'], 'placeholder' => 'Pilih status pengelolaan', 'required' => true],
                'nama_pengelola' => [
                    'label' => 'Nama orang/instansi pengelola', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan nama pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'alamat_pengelola' => [
                    'label' => 'Alamat', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan alamat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'koordinat_pengelola' => [
                    'label' => 'Koordinat', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan koordinat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                
                // Deskripsi
                'deskripsi_sejarah' => ['label' => 'Deskripsi Sejarah', 'type' => 'textarea', 'placeholder' => 'Masukkan deskripsi sejarah'],
            ],
        ],
    ],

    'Potensi Cagar Budaya' => [
        'has_sub' => true,
        'sub_field' => 'jenis_cagar_budaya',
        'sub_label' => 'Jenis Cagar Budaya',
        'sub_options' => [
            'kawasan' => 'Kawasan',
            'situs' => 'Situs',
            'struktur' => 'Struktur',
            'bangunan' => 'Bangunan',
            'benda' => 'Benda',
        ],
        'fields' => [
            'kawasan' => [
                // Identitas Umum
                'nama_objek' => ['label' => 'Nama ODCB/CB di lapangan', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'fungsi_kawasan' => [
                    'label' => 'Fungsi kawasan', 
                    'type' => 'select', 
                    'options' => ['Pemukiman', 'Perindustrian', 'Peribadatan', 'Kota lama', 'Militer', 'Lingkungan purba', 'Pemerintah', 'Lainnya'],
                    'placeholder' => 'Pilih fungsi kawasan',
                    'required' => true
                ],
                'sifat_objek' => ['label' => 'Sifat objek', 'type' => 'select', 'options' => ['Sakral', 'Profan'], 'placeholder' => 'Pilih sifat', 'required' => true],
                'lokasi_penemuan' => ['label' => 'Lokasi penemuan', 'type' => 'textarea', 'placeholder' => 'Masukkan lokasi penemuan', 'required' => true],
                'koordinat_lokasi' => ['label' => 'Koordinat lokasi penemuan', 'type' => 'text', 'placeholder' => 'Contoh: -8.1234, 115.1234'],
                'elevasi' => ['label' => 'Elevasi (ketinggian)', 'type' => 'text', 'placeholder' => 'Contoh: 500 mdpl'],
                'periode_objek' => ['label' => 'Periode objek', 'type' => 'select', 'options' => ['Prasejarah', 'Klasik', 'Kolonial', 'Pergerakan', 'Modern'], 'placeholder' => 'Pilih periode'],
                
                // Dimensi
                'luas_kawasan' => ['label' => 'Luas kawasan (m2/km2/ha)', 'type' => 'text', 'placeholder' => 'Masukkan luas kawasan'],
                
                // Kondisi
                'keutuhan' => ['label' => 'Keutuhan', 'type' => 'select', 'options' => ['Utuh', 'Tinggal sebagian', 'Musnah/hilang'], 'placeholder' => 'Pilih kondisi keutuhan', 'required' => true],
                'pemeliharaan' => ['label' => 'Pemeliharaan', 'type' => 'select', 'options' => ['Terpelihara', 'Tidak terpelihara'], 'placeholder' => 'Pilih status pemeliharaan', 'required' => true],
                'pemugaran' => ['label' => 'Pemugaran', 'type' => 'select', 'options' => ['Pernah dipugar', 'Belum pernah dipugar'], 'placeholder' => 'Pilih status pemugaran'],
                'riwayat_pemugaran' => [
                    'label' => 'Riwayat pemugaran', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan riwayat pemugaran',
                    'condition' => ['field' => 'pemugaran', 'value' => 'Pernah dipugar']
                ],
                'adaptasi' => ['label' => 'Adaptasi', 'type' => 'select', 'options' => ['Ada adaptasi', 'Tidak ada penambahan'], 'placeholder' => 'Pilih status adaptasi'],
                'riwayat_adaptasi' => [
                    'label' => 'Riwayat adaptasi', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan riwayat adaptasi',
                    'condition' => ['field' => 'adaptasi', 'value' => 'Ada adaptasi']
                ],
                
                // Kepemilikan
                'status_kepemilikan' => ['label' => 'Status kepemilikan', 'type' => 'select', 'options' => ['Pemerintah', 'Non-pemerintah'], 'placeholder' => 'Pilih status kepemilikan', 'required' => true],
                'nama_pemilik' => ['label' => 'Nama orang/instansi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan nama pemilik', 'required' => true],
                'alamat_pemilik' => ['label' => 'Alamat', 'type' => 'textarea', 'placeholder' => 'Masukkan alamat pemilik', 'required' => true],
                'koordinat_pemilik' => ['label' => 'Koordinat lokasi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan koordinat pemilik'],
                'perolehan_bangunan' => ['label' => 'Perolehan bangunan', 'type' => 'select', 'options' => ['Warisan', 'Pembelian', 'Hadiah', 'Hibah', 'Tukar menukar', 'Penemuan', 'Putusan pengadilan'], 'placeholder' => 'Pilih cara perolehan'],
                
                // Pengelolaan
                'status_pengelolaan' => ['label' => 'Status pengelolaan', 'type' => 'select', 'options' => ['Dikelola sendiri', 'Dikelola pemerintah', 'Dikelola non-pemerintah'], 'placeholder' => 'Pilih status pengelolaan', 'required' => true],
                'nama_pengelola' => [
                    'label' => 'Nama orang/instansi pengelola', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan nama pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'alamat_pengelola' => [
                    'label' => 'Alamat', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan alamat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'koordinat_pengelola' => [
                    'label' => 'Koordinat', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan koordinat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                
                // Deskripsi
                'deskripsi_detail' => ['label' => 'Deskripsi', 'type' => 'textarea', 'placeholder' => 'Masukkan deskripsi detail'],
                'batas_zonasi' => ['label' => 'Batas zonasi', 'type' => 'textarea', 'placeholder' => 'Masukkan batas zonasi'],
            ],
            
            'situs' => [
                // Identitas Umum
                'nama_objek' => ['label' => 'Nama ODCB/CB di lapangan', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'kelompok_objek' => [
                    'label' => 'Kelompok objek', 
                    'type' => 'select', 
                    'options' => ['Hunian', 'Perindustrian', 'Perkuburan/pemakaman', 'Peribadatan', 'Pertempuran', 'Bawah air', 'Lainnya'],
                    'placeholder' => 'Pilih kelompok objek',
                    'required' => true
                ],
                'sifat_objek' => ['label' => 'Sifat objek', 'type' => 'select', 'options' => ['Sakral', 'Profan'], 'placeholder' => 'Pilih sifat', 'required' => true],
                'lokasi_penemuan' => ['label' => 'Lokasi penemuan', 'type' => 'textarea', 'placeholder' => 'Masukkan lokasi penemuan', 'required' => true],
                'koordinat_lokasi' => ['label' => 'Koordinat lokasi penemuan', 'type' => 'text', 'placeholder' => 'Contoh: -8.1234, 115.1234'],
                'elevasi' => ['label' => 'Elevasi (ketinggian)', 'type' => 'text', 'placeholder' => 'Contoh: 500 mdpl'],
                'periode_objek' => ['label' => 'Periode objek', 'type' => 'select', 'options' => ['Prasejarah', 'Klasik', 'Kolonial', 'Pergerakan', 'Modern'], 'placeholder' => 'Pilih periode'],
                
                // Dimensi
                'panjang' => ['label' => 'Panjang (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan panjang'],
                'lebar' => ['label' => 'Lebar (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan lebar'],
                'luas_tanah' => ['label' => 'Luas tanah (m2/km2/ha)', 'type' => 'text', 'placeholder' => 'Masukkan luas tanah'],
                
                // Kondisi
                'keutuhan' => ['label' => 'Keutuhan', 'type' => 'select', 'options' => ['Utuh', 'Tinggal sebagian', 'Musnah/hilang'], 'placeholder' => 'Pilih kondisi keutuhan', 'required' => true],
                'pemeliharaan' => ['label' => 'Pemeliharaan', 'type' => 'select', 'options' => ['Terpelihara', 'Tidak terpelihara'], 'placeholder' => 'Pilih status pemeliharaan', 'required' => true],
                'pemugaran' => ['label' => 'Pemugaran', 'type' => 'select', 'options' => ['Pernah dipugar', 'Belum pernah dipugar'], 'placeholder' => 'Pilih status pemugaran'],
                'riwayat_pemugaran' => [
                    'label' => 'Riwayat pemugaran', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan riwayat pemugaran',
                    'condition' => ['field' => 'pemugaran', 'value' => 'Pernah dipugar']
                ],
                'adaptasi' => ['label' => 'Adaptasi', 'type' => 'select', 'options' => ['Ada adaptasi', 'Tidak ada penambahan'], 'placeholder' => 'Pilih status adaptasi'],
                'riwayat_adaptasi' => [
                    'label' => 'Riwayat adaptasi', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan riwayat adaptasi',
                    'condition' => ['field' => 'adaptasi', 'value' => 'Ada adaptasi']
                ],
                
                // Kepemilikan
                'status_kepemilikan' => ['label' => 'Status kepemilikan', 'type' => 'select', 'options' => ['Pemerintah', 'Non-pemerintah'], 'placeholder' => 'Pilih status kepemilikan', 'required' => true],
                'nama_pemilik' => ['label' => 'Nama orang/instansi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan nama pemilik', 'required' => true],
                'alamat_pemilik' => ['label' => 'Alamat', 'type' => 'textarea', 'placeholder' => 'Masukkan alamat pemilik', 'required' => true],
                'koordinat_pemilik' => ['label' => 'Koordinat lokasi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan koordinat pemilik'],
                'perolehan_bangunan' => ['label' => 'Perolehan bangunan', 'type' => 'select', 'options' => ['Warisan', 'Pembelian', 'Hadiah', 'Hibah', 'Tukar menukar', 'Penemuan', 'Putusan pengadilan'], 'placeholder' => 'Pilih cara perolehan'],
                
                // Pengelolaan
                'status_pengelolaan' => ['label' => 'Status pengelolaan', 'type' => 'select', 'options' => ['Dikelola sendiri', 'Dikelola pemerintah', 'Dikelola non-pemerintah'], 'placeholder' => 'Pilih status pengelolaan', 'required' => true],
                'nama_pengelola' => [
                    'label' => 'Nama orang/instansi pengelola', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan nama pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'alamat_pengelola' => [
                    'label' => 'Alamat', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan alamat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'koordinat_pengelola' => [
                    'label' => 'Koordinat', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan koordinat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                
                // Deskripsi
                'deskripsi_detail' => ['label' => 'Deskripsi', 'type' => 'textarea', 'placeholder' => 'Masukkan deskripsi detail'],
                'batas_zonasi' => ['label' => 'Batas zonasi', 'type' => 'textarea', 'placeholder' => 'Masukkan batas zonasi'],
            ],
            
            'struktur' => [
                // Identitas Umum
                'nama_objek' => ['label' => 'Nama ODCB/CB di lapangan', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'fungsi_objek' => [
                    'label' => 'Fungsi objek', 
                    'type' => 'select', 
                    'options' => ['Tembok', 'Sumur', 'Kapal selam', 'Kapal', 'Pesawat', 'Saluran air', 'Dermaga', 'Terowongan', 'Gua buatan', 'Menara', 'Bendung', 'Fondasi', 'Tugu', 'Gapura', 'Monumen', 'Pagar', 'Tiang', 'Lantai', 'Umpak', 'Jembatan', 'Makam', 'Lintasan rel', 'Jalan', 'Lainnya'],
                    'placeholder' => 'Pilih fungsi objek',
                    'required' => true
                ],
                'sifat_objek' => ['label' => 'Sifat objek', 'type' => 'select', 'options' => ['Sakral', 'Profan'], 'placeholder' => 'Pilih sifat', 'required' => true],
                'lokasi_penemuan' => ['label' => 'Lokasi penemuan', 'type' => 'textarea', 'placeholder' => 'Masukkan lokasi penemuan', 'required' => true],
                'koordinat_lokasi' => ['label' => 'Koordinat lokasi penemuan', 'type' => 'text', 'placeholder' => 'Contoh: -8.1234, 115.1234'],
                'elevasi' => ['label' => 'Elevasi (ketinggian)', 'type' => 'text', 'placeholder' => 'Contoh: 500 mdpl'],
                'periode_objek' => ['label' => 'Periode objek', 'type' => 'select', 'options' => ['Prasejarah', 'Klasik', 'Kolonial', 'Pergerakan', 'Modern'], 'placeholder' => 'Pilih periode'],
                
                // Informasi Fisik
                'bahan' => ['label' => 'Bahan', 'type' => 'select', 'options' => ['Kayu', 'Bambu', 'Tanah', 'Bata', 'Beton', 'Batu', 'Lainnya'], 'placeholder' => 'Pilih bahan'],
                'waktu_pembuatan' => ['label' => 'Waktu pembuatan (Tahun/Abad)', 'type' => 'text', 'placeholder' => 'Contoh: Abad 14 atau Tahun 1920'],
                'hiasan_ornamen' => [
                    'label' => 'Hiasan/ornamen', 
                    'type' => 'checkbox_group', 
                    'options' => ['Angka', 'Huruf', 'Inskripsi', 'Manusia', 'Antropomorf', 'Tumbuhan', 'Vegemorf', 'Binatang', 'Zuomorf', 'Geometris', 'Lukisan/relief adegan', 'Abstrak', 'Lainnya']
                ],
                'tanda_struktur' => [
                    'label' => 'Tanda yang dimiliki struktur', 
                    'type' => 'checkbox_group', 
                    'options' => ['Angka', 'Huruf', 'Inskripsi', 'Manusia', 'Antropomorf', 'Tumbuhan', 'Vegemorf', 'Binatang', 'Zuomorf', 'Geometris', 'Abstrak', 'Lainnya']
                ],
                
                // Dimensi
                'panjang' => ['label' => 'Panjang (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan panjang'],
                'lebar' => ['label' => 'Lear (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan lebar'],
                'tinggi' => ['label' => 'Tinggi', 'type' => 'text', 'placeholder' => 'Masukkan tinggi'],
                'diameter_atas' => ['label' => 'Diameter atas (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan diameter atas'],
                'diameter_badan' => ['label' => 'Diameter badan (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan diameter badan'],
                'diameter_kaki' => ['label' => 'Diameter kaki', 'type' => 'text', 'placeholder' => 'Masukkan diameter kaki'],
                'luas_tanah' => ['label' => 'Luas tanah (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan luas tanah'],
                'luas_struktur' => ['label' => 'Luas struktur (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan luas struktur'],
                
                // Kondisi
                'keutuhan' => ['label' => 'Keutuhan', 'type' => 'select', 'options' => ['Utuh', 'Tinggal sebagian', 'Musnah/hilang'], 'placeholder' => 'Pilih kondisi keutuhan', 'required' => true],
                'pemeliharaan' => ['label' => 'Pemeliharaan', 'type' => 'select', 'options' => ['Terpelihara', 'Tidak terpelihara'], 'placeholder' => 'Pilih status pemeliharaan', 'required' => true],
                'pemugaran' => ['label' => 'Pemugaran', 'type' => 'select', 'options' => ['Pernah dipugar', 'Belum pernah dipugar'], 'placeholder' => 'Pilih status pemugaran'],
                'riwayat_pemugaran' => [
                    'label' => 'Riwayat pemugaran', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan riwayat pemugaran',
                    'condition' => ['field' => 'pemugaran', 'value' => 'Pernah dipugar']
                ],
                'adaptasi' => ['label' => 'Adaptasi', 'type' => 'select', 'options' => ['Ada adaptasi', 'Tidak ada penambahan'], 'placeholder' => 'Pilih status adaptasi'],
                
                // Kepemilikan
                'status_kepemilikan' => ['label' => 'Status kepemilikan', 'type' => 'select', 'options' => ['Pemerintah', 'Non-pemerintah'], 'placeholder' => 'Pilih status kepemilikan', 'required' => true],
                'nama_pemilik' => ['label' => 'Nama orang/instansi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan nama pemilik', 'required' => true],
                'alamat_pemilik' => ['label' => 'Alamat', 'type' => 'textarea', 'placeholder' => 'Masukkan alamat pemilik', 'required' => true],
                'koordinat_pemilik' => ['label' => 'Koordinat lokasi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan koordinat pemilik'],
                'perolehan_bangunan' => ['label' => 'Perolehan bangunan', 'type' => 'select', 'options' => ['Warisan', 'Pembelian', 'Hadiah', 'Hibah', 'Tukar menukar', 'Penemuan', 'Putusan pengadilan'], 'placeholder' => 'Pilih cara perolehan'],
                
                // Pengelolaan
                'status_pengelolaan' => ['label' => 'Status pengelolaan', 'type' => 'select', 'options' => ['Dikelola sendiri', 'Dikelola pemerintah', 'Dikelola non-pemerintah'], 'placeholder' => 'Pilih status pengelolaan', 'required' => true],
                'nama_pengelola' => [
                    'label' => 'Nama orang/instansi pengelola', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan nama pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'alamat_pengelola' => [
                    'label' => 'Alamat', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan alamat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'koordinat_pengelola' => [
                    'label' => 'Koordinat', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan koordinat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                
                // Deskripsi
                'deskripsi_detail' => ['label' => 'Deskripsi', 'type' => 'textarea', 'placeholder' => 'Masukkan deskripsi detail'],
                'batas_zonasi' => ['label' => 'Batas zonasi', 'type' => 'textarea', 'placeholder' => 'Masukkan batas zonasi'],
            ],
            
            'bangunan' => [
                // Identitas Umum
                'nama_objek' => ['label' => 'Nama ODCB/CB di lapangan', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'fungsi_objek' => [
                    'label' => 'Fungsi Objek', 
                    'type' => 'select', 
                    'options' => ['Penginapan', 'Rumah', 'Masjid', 'Musholla', 'Katedral', 'Gereja', 'Kapel', 'Wihara', 'Pura', 'Klenteng', 'Warung', 'Toko', 'Rumah toko', 'Pertokoan', 'Balai adat/masyarakat', 'Gedung permuan', 'Museum', 'Galeri', 'Sanggar', 'Teater', 'Rekreasi', 'Stadion', 'Gelanggang', 'Pusat Kebugaran', 'Bangunan Kelas', 'Laboratorium', 'Observatorium', 'Bangunan utama pelabuhan', 'Bangunan utama statsiun', 'Bangunan utama terminal', 'Bangunan utama bandara', 'Bengkel', 'Mercusuar', 'Penjara', 'Industri/pabrik', 'Barak', 'Pertahanan garis depan', 'Klinik', 'Puskesmas', 'Rumah sakit', 'Kantor', 'Musoleum', 'Gudang', 'Lainnya'],
                    'placeholder' => 'Pilih fungsi objek',
                    'required' => true
                ],
                'sifat_objek' => ['label' => 'Sifat Objek', 'type' => 'select', 'options' => ['Sakral', 'Profan'], 'placeholder' => 'Pilih sifat', 'required' => true],
                'lokasi_penemuan' => ['label' => 'Lokasi', 'type' => 'textarea', 'placeholder' => 'Masukkan lokasi', 'required' => true],
                'koordinat_lokasi' => ['label' => 'Koordinat lokasi penemuan', 'type' => 'text', 'placeholder' => 'Contoh: -8.1234, 115.1234'],
                'elevasi' => ['label' => 'Elevasi (ketinggian)', 'type' => 'text', 'placeholder' => 'Contoh: 500 mdpl'],
                'periode_objek' => ['label' => 'Periode objek', 'type' => 'select', 'options' => ['Prasejarah', 'Klasik', 'Kolonial', 'Pergerakan modern'], 'placeholder' => 'Pilih periode'],
                
                // Informasi Fisik
                'bahan' => ['label' => 'Bahan', 'type' => 'checkbox_group', 'options' => ['Kayu', 'Bambu', 'Tanah', 'Bata', 'Beton bertulang', 'Batu', 'Karang', 'Lainnya']],
                'waktu_pembuatan' => ['label' => 'Waktu pembuatan (Tahun/Abad)', 'type' => 'text', 'placeholder' => 'Contoh: Abad 14 atau Tahun 1920'],
                'gaya_arsitektur' => ['label' => 'Gaya arsitektur', 'type' => 'select', 'options' => ['Hindu/Budha', 'Islam', 'Cina', 'Tradisional', 'Kolonial', 'Modern', 'Lainnya'], 'placeholder' => 'Pilih gaya arsitektur'],
                'bentuk_atap' => ['label' => 'Bentuk atap', 'type' => 'select', 'options' => ['Tumpang', 'Kubah', 'Pelana', 'Limas', 'Menara', 'Lainnya'], 'placeholder' => 'Pilih bentuk atap'],
                'hiasan_ornamen' => [
                    'label' => 'Hiasan/ornamen', 
                    'type' => 'checkbox_group', 
                    'options' => ['Angka', 'Huruf', 'Inskripsi', 'Manusia', 'Antropomorf', 'Tumbuhan', 'Vegemorf', 'Binatang', 'Zuomorf', 'Geometris', 'Campuran', 'Lukisan/relief adegan', 'Abstrak', 'Lainnya']
                ],
                'tanda_bangunan' => [
                    'label' => 'Tanda yang dimiliki bangunan', 
                    'type' => 'checkbox_group', 
                    'options' => ['Angka', 'Huruf', 'Inskripsi', 'Manusia', 'Antropomorf', 'Tumbuhan', 'Vegemorf', 'Binatang', 'Zuomorf', 'Geometris', 'Abstrak', 'Lainnya']
                ],
                'warna' => ['label' => 'Warna', 'type' => 'text', 'placeholder' => 'Masukkan warna bangunan'],
                
                // Dimensi
                'panjang' => ['label' => 'Panjang (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan panjang'],
                'lebar' => ['label' => 'Lebar (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan lebar'],
                'tinggi' => ['label' => 'Tinggi (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan tinggi'],
                'luas_bangunan' => ['label' => 'Luas bangunan (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan luas bangunan'],
                'luas_tanah' => ['label' => 'Luas tanah (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan luas tanah'],
                
                // Kondisi
                'keutuhan' => ['label' => 'Keutuhan', 'type' => 'select', 'options' => ['Utuh', 'Tinggal sebagian', 'Musnah/hilang'], 'placeholder' => 'Pilih kondisi keutuhan', 'required' => true],
                'pemeliharaan' => ['label' => 'Pemeliharaan', 'type' => 'select', 'options' => ['Terpelihara', 'Tidak terpelihara'], 'placeholder' => 'Pilih status pemeliharaan', 'required' => true],
                'pemugaran' => ['label' => 'Pemugaran', 'type' => 'select', 'options' => ['Pernah dipugar', 'Belum pernah dipugar'], 'placeholder' => 'Pilih status pemugaran'],
                'riwayat_pemugaran' => [
                    'label' => 'Riwayat pemugaran', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan riwayat pemugaran',
                    'condition' => ['field' => 'pemugaran', 'value' => 'Pernah dipugar']
                ],
                'adaptasi' => ['label' => 'Adaptasi', 'type' => 'select', 'options' => ['Ada adaptasi', 'Tidak ada penambahan'], 'placeholder' => 'Pilih status adaptasi'],
                'riwayat_adaptasi' => [
                    'label' => 'Riwayat adaptasi', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan riwayat adaptasi',
                    'condition' => ['field' => 'adaptasi', 'value' => 'Ada adaptasi']
                ],
                
                // Kepemilikan
                'status_kepemilikan' => ['label' => 'Status kepemilikan', 'type' => 'select', 'options' => ['Pemerintah', 'Non-pemerintah'], 'placeholder' => 'Pilih status kepemilikan', 'required' => true],
                'nama_pemilik' => ['label' => 'Nama orang/instansi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan nama pemilik', 'required' => true],
                'alamat_pemilik' => ['label' => 'Alamat', 'type' => 'textarea', 'placeholder' => 'Masukkan alamat pemilik', 'required' => true],
                'koordinat_pemilik' => ['label' => 'Koordinat lokasi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan koordinat pemilik'],
                'perolehan_bangunan' => ['label' => 'Perolehan bangunan', 'type' => 'select', 'options' => ['Warisan', 'Pembelian', 'Hadiah', 'Hibah', 'Tukar menukar', 'Penemuan', 'Putusan pengadilan'], 'placeholder' => 'Pilih cara perolehan'],
                
                // Pengelolaan
                'status_pengelolaan' => ['label' => 'Status pengelolaan', 'type' => 'select', 'options' => ['Dikelola sendiri', 'Dikelola pemerintah', 'Dikelola non-pemerintah'], 'placeholder' => 'Pilih status pengelolaan', 'required' => true],
                'nama_pengelola' => [
                    'label' => 'Nama orang/instansi pengelola', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan nama pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'alamat_pengelola' => [
                    'label' => 'Alamat', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan alamat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'koordinat_pengelola' => [
                    'label' => 'Koordinat', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan koordinat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                
                // Deskripsi
                'deskripsi_detail' => ['label' => 'Deskripsi', 'type' => 'textarea', 'placeholder' => 'Masukkan deskripsi detail'],
                'batas_zonasi' => ['label' => 'Batas zonasi', 'type' => 'textarea', 'placeholder' => 'Masukkan batas zonasi'],
            ],
            
            'benda' => [
                // Identitas Umum
                'nama_objek' => ['label' => 'Nama ODCB/CB di lapangan', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
                'kelompok_objek_benda' => [
                    'label' => 'Kelompok objek benda', 
                    'type' => 'select', 
                    'options' => ['Prasasti/inkripsi', 'Peralatan masak', 'Peralatan rumah tangga', 'Peralatan musik', 'Senjata', 'Naskah', 'Rekaman', 'Kendaraan', 'Citra', 'Pakaian', 'Aksesori pakaian', 'Perhiasan', 'Peralatan makan', 'Peralatan seni pertunjukan', 'Peralatan komunikasi', 'Peralatan tulis/gambar', 'Peralatan pertanian/perkebunan', 'Peralatan medis', 'Peralatan perekam audio/visual', 'Peralatan spiritual', 'Fosil', 'Dekorasi rumah', 'Jam dinding/jam almari', 'Alat hitung', 'Alat pembayaran', 'Lainnya'],
                    'placeholder' => 'Pilih kelompok objek',
                    'required' => true
                ],
                'sifat_benda' => ['label' => 'Sifat benda', 'type' => 'select', 'options' => ['Sakral', 'Profan'], 'placeholder' => 'Pilih sifat', 'required' => true],
                'lokasi_penemuan' => ['label' => 'Lokasi penemuan (Provinsi s.d Desa)', 'type' => 'textarea', 'placeholder' => 'Masukkan lokasi penemuan', 'required' => true],
                'koordinat_lokasi' => ['label' => 'Koordinat lokasi penemuan (Lintang & Bujur)', 'type' => 'text', 'placeholder' => 'Contoh: -8.1234, 115.1234'],
                'elevasi' => ['label' => 'Elevasi (ketinggian)', 'type' => 'text', 'placeholder' => 'Contoh: 500 mdpl'],
                'periode_benda' => ['label' => 'Periode benda', 'type' => 'select', 'options' => ['Prasejarah', 'Klasik', 'Kolonial', 'Pergerakan', 'Modern'], 'placeholder' => 'Pilih periode'],
                
                // Informasi Fisik
                'bahan' => [
                    'label' => 'Bahan', 
                    'type' => 'select', 
                    'options' => ['Kayu', 'Rotan', 'Bambu', 'Serat', 'Daun', 'Kulit kayu', 'Karet', 'Getah', 'Bunga', 'Kelopak', 'Buah', 'Kulit buah', 'Biji', 'Tepung', 'Gabus', 'Tulang', 'Gigi', 'Gading', 'Kulit', 'Bulu', 'Rambut', 'Daging', 'Otot', 'Tanduk', 'Cula', 'Paruh', 'Kuku', 'Sutra', 'Katun', 'Sabut', 'Tempurung', 'Lidi', 'Karton', 'Duri', 'Sisik', 'Karapas', 'Kerang', 'Siput', 'Mutiara', 'Karang', 'Batu', 'Pre-fosil', 'Fosil', 'Logam', 'Kaca', 'Tanah', 'Kapur', 'Pasir', 'Keramik', 'Terakota', 'Lilin', 'Aspal', 'Plastik', 'Mika', 'Mineral', 'Poliester', 'Sintetis', 'Lainnya'],
                    'placeholder' => 'Pilih bahan utama'
                ],
                'waktu_pembuatan' => ['label' => 'Waktu pembuatan (Tahun/Abad)', 'type' => 'text', 'placeholder' => 'Contoh: Abad 14 atau Tahun 1920'],
                'hiasan_ornamen' => [
                    'label' => 'Hiasan/ornamen', 
                    'type' => 'checkbox_group', 
                    'options' => ['Angka', 'Huruf', 'Inskripsi/tulisan', 'Manusia', 'Antromorf', 'Abstrak', 'Tumbuhan', 'Vegemorf', 'Binatang', 'Zuomorf', 'Geometris', 'Panorama', 'Campuran', 'Lainnya']
                ],
                'tanda' => [
                    'label' => 'Tanda', 
                    'type' => 'checkbox_group', 
                    'options' => ['Angka', 'Huruf', 'Inskripsi/tulisan', 'Manusia', 'Antromorf', 'Abstrak', 'Tumbuhan', 'Vegemorf', 'Binatang', 'Zuomorf', 'Geometris', 'Panorama', 'Campuran', 'Lainnya']
                ],
                'warna' => ['label' => 'Warna', 'type' => 'text', 'placeholder' => 'Masukkan warna benda'],
                
                // Dimensi
                'panjang' => ['label' => 'Panjang (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan panjang'],
                'lebar' => ['label' => 'Lebar (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan lebar'],
                'tinggi' => ['label' => 'Tinggi (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan tinggi'],
                'tebal' => ['label' => 'Tebal', 'type' => 'text', 'placeholder' => 'Masukkan tebal'],
                'berat' => ['label' => 'Berat', 'type' => 'text', 'placeholder' => 'Masukkan berat'],
                'volume' => ['label' => 'Volume', 'type' => 'text', 'placeholder' => 'Masukkan volume'],
                'diameter_atas' => ['label' => 'Diameter atas', 'type' => 'text', 'placeholder' => 'Masukkan diameter atas'],
                'diameter_badan' => ['label' => 'Diameter badan', 'type' => 'text', 'placeholder' => 'Masukkan diameter badan'],
                'diameter_kaki' => ['label' => 'Diameter kaki', 'type' => 'text', 'placeholder' => 'Masukkan diameter kaki'],
                
                // Kondisi
                'keutuhan' => ['label' => 'Keutuhan', 'type' => 'select', 'options' => ['Utuh', 'Tinggal sebagian', 'Musnah/hilang'], 'placeholder' => 'Pilih kondisi keutuhan', 'required' => true],
                'pemeliharaan' => ['label' => 'Pemeliharaan', 'type' => 'select', 'options' => ['Terpelihara', 'Tidak terpelihara'], 'placeholder' => 'Pilih status pemeliharaan', 'required' => true],
                'pemugaran' => ['label' => 'Pemugaran', 'type' => 'select', 'options' => ['Pernah dipugar', 'Belum pernah dipugar'], 'placeholder' => 'Pilih status pemugaran'],
                'riwayat_pemugaran' => [
                    'label' => 'Riwayat pemugaran', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan riwayat pemugaran',
                    'condition' => ['field' => 'pemugaran', 'value' => 'Pernah dipugar']
                ],
                'adaptasi' => ['label' => 'Adaptasi', 'type' => 'select', 'options' => ['Ada adaptasi', 'Tidak ada penambahan'], 'placeholder' => 'Pilih status adaptasi'],
                'riwayat_adaptasi' => [
                    'label' => 'Riwayat adaptasi', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan riwayat adaptasi',
                    'condition' => ['field' => 'adaptasi', 'value' => 'Ada adaptasi']
                ],
                
                // Kepemilikan
                'status_kepemilikan' => ['label' => 'Status kepemilikan', 'type' => 'select', 'options' => ['Pemerintah', 'Non-pemerintah'], 'placeholder' => 'Pilih status kepemilikan', 'required' => true],
                'nama_pemilik' => ['label' => 'Nama orang/instansi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan nama pemilik', 'required' => true],
                'alamat_pemilik' => ['label' => 'Alamat (Provinsi s.d Desa)', 'type' => 'textarea', 'placeholder' => 'Masukkan alamat pemilik', 'required' => true],
                'koordinat_pemilik' => ['label' => 'Koordinat (Lintang & Bujur)', 'type' => 'text', 'placeholder' => 'Masukkan koordinat pemilik'],
                'perolehan_benda' => ['label' => 'Perolehan benda', 'type' => 'select', 'options' => ['Warisan', 'Pembelian', 'Hadiah', 'Hibah', 'Tukar menukar', 'Penemuan', 'Putusan pengadilan'], 'placeholder' => 'Pilih cara perolehan'],
                
                // Pengelolaan
                'status_pengelolaan' => ['label' => 'Status pengelolaan', 'type' => 'select', 'options' => ['Dikelola sendiri', 'Dikelola pemerintah', 'Dikelola non-pemerintah'], 'placeholder' => 'Pilih status pengelolaan', 'required' => true],
                'nama_pengelola' => [
                    'label' => 'Nama orang/instansi pengelola', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan nama pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'alamat_pengelola' => [
                    'label' => 'Alamat', 
                    'type' => 'textarea', 
                    'placeholder' => 'Masukkan alamat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                'koordinat_pengelola' => [
                    'label' => 'Koordinat', 
                    'type' => 'text', 
                    'placeholder' => 'Masukkan koordinat pengelola',
                    'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
                ],
                
                // Deskripsi
                'deskripsi_sejarah' => ['label' => 'Deskripsi Sejarah', 'type' => 'textarea', 'placeholder' => 'Masukkan deskripsi sejarah'],
            ],
        ],
    ],

    // ========================================================================
    // L. LAPORAN KEBUDAYAAN AKTIF (Active Culture Report - Pengusul Form)
    // ========================================================================
    'Laporan Kebudayaan Aktif' => [
        'has_sub' => false,
        'fields' => [
            'kategori_opk' => [
                'label' => 'Kategori Unit Kebudayaan',
                'type' => 'select',
                'options' => [
                    'Tradisi Lisan',
                    'Manuskrip',
                    'Adat Istiadat',
                    'Ritus',
                    'Pengetahuan Tradisional',
                    'Teknologi Tradisional',
                    'Seni',
                    'Bahasa',
                    'Permainan Rakyat',
                    'Olahraga Tradisional',
                    'Cagar Budaya'
                ],
                'placeholder' => 'Pilih kategori kebudayaan yang dilaksanakan'
            ],

            'nama_dan_jenis_kebudayaan' => [
                'label' => 'Nama dan Jenis Kebudayaan',
                'type' => 'text',
                'placeholder' => 'Contoh: Tari Pendet (Tarian Tradisional)'
            ],

            'desa_lokasi' => [
                'label' => 'Nama Desa / Kelurahan',
                'type' => 'datalist',
                'placeholder' => 'Pilih atau cari desa'
            ],
            'detail_lokasi' => [
                'label' => 'Detail Lokasi Pelaksanaan',
                'type' => 'text',
                'placeholder' => 'Contoh: Balai desa, lapangan utama, alamat lengkap'
            ],

            'tanggal_pelaksanaan' => [
                'label' => 'Tanggal Pelaksanaan',
                'type' => 'date',
                'placeholder' => 'Pilih tanggal pelaksanaan'
            ],
        ],
    ],
];
