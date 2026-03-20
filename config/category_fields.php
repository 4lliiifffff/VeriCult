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
                'teknik' => ['label' => 'Teknik pembuatan', 'type' => 'textarea', 'placeholder' => 'Jelaskan teknik pembuatan', 'required' => true],
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
        'has_sub' => false,
        'fields' => [
            'jenis_objek' => ['label' => 'Jenis Objek', 'type' => 'select', 'options' => ['Candi', 'Benteng', 'Istana/Keraton', 'Makam', 'Situs Arkeologi', 'Benda Bersejarah', 'Keris', 'Prasasti', 'Lainnya'], 'placeholder' => 'Pilih jenis objek', 'required' => true],
            'periode_sejarah' => ['label' => 'Periode Sejarah', 'type' => 'text', 'placeholder' => 'Periode atau era sejarah', 'required' => true],
            'kondisi' => ['label' => 'Kondisi', 'type' => 'select', 'options' => ['Baik', 'Cukup Baik', 'Rusak Ringan', 'Rusak Berat', 'Reruntuhan'], 'placeholder' => 'Pilih kondisi'],
            'dimensi_ukuran' => ['label' => 'Dimensi / Ukuran', 'type' => 'text', 'placeholder' => 'Ukuran atau dimensi objek'],
            'bahan_material' => ['label' => 'Bahan Material', 'type' => 'text', 'placeholder' => 'Material utama objek'],
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
