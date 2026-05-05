<?php

$cagarBudayaConfig = [
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
            'nama_objek' => ['label' => 'A1. Nama ODCB/CB di lapangan', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
            'fungsi_kawasan' => [
                'label' => 'A2. Fungsi kawasan', 
                'type' => 'select', 
                'options' => ['Pemukiman', 'Perindustrian', 'Peribadatan', 'Kota lama', 'Militer', 'Lingkungan purba', 'Pemerintah', 'Lainnya'],
                'placeholder' => 'Pilih fungsi kawasan'
            ],
            'sifat_objek' => ['label' => 'A3. Sifat objek', 'type' => 'select', 'options' => ['Sakral', 'Profan'], 'placeholder' => 'Pilih sifat'],
            'lokasi_penemuan' => ['label' => 'A4. Lokasi penemuan', 'type' => 'textarea', 'placeholder' => 'Masukkan lokasi penemuan'],
            'koordinat_lokasi' => ['label' => 'A5. Koordinat lokasi penemuan', 'type' => 'text', 'placeholder' => 'Contoh: -8.1234, 115.1234'],
            'elevasi' => ['label' => 'A6. Elevasi (ketinggian)', 'type' => 'text', 'placeholder' => 'Contoh: 500 mdpl'],
            'periode_objek' => ['label' => 'A7. Periode objek', 'type' => 'select', 'options' => ['Prasejarah', 'Klasik', 'Kolonial', 'Pergerakan', 'Modern'], 'placeholder' => 'Pilih periode'],
            
            // Dimensi
            'luas_kawasan' => ['label' => 'B1. Luas kawasan (m2/km2/ha)', 'type' => 'text', 'placeholder' => 'Masukkan luas kawasan'],
            
            // Kondisi
            'keutuhan' => ['label' => 'C1. Keutuhan', 'type' => 'select', 'options' => ['Utuh', 'Tinggal sebagian', 'Musnah/hilang'], 'placeholder' => 'Pilih kondisi keutuhan'],
            'pemeliharaan' => ['label' => 'C2. Pemeliharaan', 'type' => 'select', 'options' => ['Terpelihara', 'Tidak terpelihara'], 'placeholder' => 'Pilih status pemeliharaan'],
            'pemugaran' => ['label' => 'C3. Pemugaran', 'type' => 'select', 'options' => ['Pernah dipugar', 'Belum pernah dipugar'], 'placeholder' => 'Pilih status pemugaran'],
            'riwayat_pemugaran' => [
                'label' => 'C4. Riwayat pemugaran', 
                'type' => 'textarea', 
                'placeholder' => 'Masukkan riwayat pemugaran',
                'condition' => ['field' => 'pemugaran', 'value' => 'Pernah dipugar']
            ],
            'adaptasi' => ['label' => 'C5. Adaptasi', 'type' => 'select', 'options' => ['Ada adaptasi', 'Tidak ada penambahan'], 'placeholder' => 'Pilih status adaptasi'],
            'riwayat_adaptasi' => [
                'label' => 'C6. Riwayat adaptasi', 
                'type' => 'textarea', 
                'placeholder' => 'Masukkan riwayat adaptasi',
                'condition' => ['field' => 'adaptasi', 'value' => 'Ada adaptasi']
            ],
            
            // Kepemilikan
            'status_kepemilikan' => ['label' => 'D1. Status kepemilikan', 'type' => 'select', 'options' => ['Pemerintah', 'Non-pemerintah'], 'placeholder' => 'Pilih status kepemilikan'],
            'nama_pemilik' => ['label' => 'D2. Nama orang/instansi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan nama pemilik'],
            'alamat_pemilik' => ['label' => 'D3. Alamat', 'type' => 'textarea', 'placeholder' => 'Masukkan alamat pemilik'],
            'koordinat_pemilik' => ['label' => 'D4. Koordinat lokasi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan koordinat pemilik'],
            'perolehan_bangunan' => ['label' => 'D5. Perolehan bangunan', 'type' => 'select', 'options' => ['Warisan', 'Pembelian', 'Hadiah', 'Hibah', 'Tukar menukar', 'Penemuan', 'Putusan pengadilan'], 'placeholder' => 'Pilih cara perolehan'],
            
            // Pengelolaan
            'status_pengelolaan' => ['label' => 'E1. Status pengelolaan', 'type' => 'select', 'options' => ['Dikelola sendiri', 'Dikelola pemerintah', 'Dikelola non-pemerintah'], 'placeholder' => 'Pilih status pengelolaan'],
            'nama_pengelola' => [
                'label' => 'E2. Nama orang/instansi pengelola', 
                'type' => 'text', 
                'placeholder' => 'Masukkan nama pengelola',
                'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
            ],
            'alamat_pengelola' => [
                'label' => 'E3. Alamat', 
                'type' => 'textarea', 
                'placeholder' => 'Masukkan alamat pengelola',
                'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
            ],
            'koordinat_pengelola' => [
                'label' => 'E4. Koordinat', 
                'type' => 'text', 
                'placeholder' => 'Masukkan koordinat pengelola',
                'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
            ],
            
            // Deskripsi
            'deskripsi_detail' => ['label' => 'a. Deskripsi', 'type' => 'textarea', 'placeholder' => 'Masukkan deskripsi detail'],
            'batas_zonasi' => ['label' => 'b. Batas zonasi', 'type' => 'textarea', 'placeholder' => 'Masukkan batas zonasi'],
        ],
        
        'situs' => [
            // Identitas Umum
            'nama_objek' => ['label' => 'A8. Nama ODCB/CB di lapangan', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
            'kelompok_objek' => [
                'label' => 'A9. Kelompok objek', 
                'type' => 'select', 
                'options' => ['Hunian', 'Perindustrian', 'Perkuburan/pemakaman', 'Peribadatan', 'Pertempuran', 'Bawah air', 'Lainnya'],
                'placeholder' => 'Pilih kelompok objek'
            ],
            'sifat_objek' => ['label' => 'A10. Sifat objek', 'type' => 'select', 'options' => ['Sakral', 'Profan'], 'placeholder' => 'Pilih sifat'],
            'lokasi_penemuan' => ['label' => 'A11. Lokasi penemuan', 'type' => 'textarea', 'placeholder' => 'Masukkan lokasi penemuan'],
            'koordinat_lokasi' => ['label' => 'A12. Koordinat lokasi penemuan', 'type' => 'text', 'placeholder' => 'Contoh: -8.1234, 115.1234'],
            'elevasi' => ['label' => 'A13. Elevasi (ketinggian)', 'type' => 'text', 'placeholder' => 'Contoh: 500 mdpl'],
            'periode_objek' => ['label' => 'A14. Periode objek', 'type' => 'select', 'options' => ['Prasejarah', 'Klasik', 'Kolonial', 'Pergerakan', 'Modern'], 'placeholder' => 'Pilih periode'],
            
            // Dimensi
            'panjang' => ['label' => 'B2. Panjang (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan panjang'],
            'lebar' => ['label' => 'B3. Lebar (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan lebar'],
            'luas_tanah' => ['label' => 'B4. Luas tanah (m2/km2/ha)', 'type' => 'text', 'placeholder' => 'Masukkan luas tanah'],
            
            // Kondisi
            'keutuhan' => ['label' => 'C7. Keutuhan', 'type' => 'select', 'options' => ['Utuh', 'Tinggal sebagian', 'Musnah/hilang'], 'placeholder' => 'Pilih kondisi keutuhan'],
            'pemeliharaan' => ['label' => 'C8. Pemeliharaan', 'type' => 'select', 'options' => ['Terpelihara', 'Tidak terpelihara'], 'placeholder' => 'Pilih status pemeliharaan'],
            'pemugaran' => ['label' => 'C9. Pemugaran', 'type' => 'select', 'options' => ['Pernah dipugar', 'Belum pernah dipugar'], 'placeholder' => 'Pilih status pemugaran'],
            'riwayat_pemugaran' => [
                'label' => 'C10. Riwayat pemugaran', 
                'type' => 'textarea', 
                'placeholder' => 'Masukkan riwayat pemugaran',
                'condition' => ['field' => 'pemugaran', 'value' => 'Pernah dipugar']
            ],
            'adaptasi' => ['label' => 'C11. Adaptasi', 'type' => 'select', 'options' => ['Ada adaptasi', 'Tidak ada penambahan'], 'placeholder' => 'Pilih status adaptasi'],
            'riwayat_adaptasi' => [
                'label' => 'C12. Riwayat adaptasi', 
                'type' => 'textarea', 
                'placeholder' => 'Masukkan riwayat adaptasi',
                'condition' => ['field' => 'adaptasi', 'value' => 'Ada adaptasi']
            ],
            
            // Kepemilikan
            'status_kepemilikan' => ['label' => 'D6. Status kepemilikan', 'type' => 'select', 'options' => ['Pemerintah', 'Non-pemerintah'], 'placeholder' => 'Pilih status kepemilikan'],
            'nama_pemilik' => ['label' => 'D7. Nama orang/instansi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan nama pemilik'],
            'alamat_pemilik' => ['label' => 'D8. Alamat', 'type' => 'textarea', 'placeholder' => 'Masukkan alamat pemilik'],
            'koordinat_pemilik' => ['label' => 'D9. Koordinat lokasi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan koordinat pemilik'],
            'perolehan_bangunan' => ['label' => 'D10. Perolehan bangunan', 'type' => 'select', 'options' => ['Warisan', 'Pembelian', 'Hadiah', 'Hibah', 'Tukar menukar', 'Penemuan', 'Putusan pengadilan'], 'placeholder' => 'Pilih cara perolehan'],
            
            // Pengelolaan
            'status_pengelolaan' => ['label' => 'E5. Status pengelolaan', 'type' => 'select', 'options' => ['Dikelola sendiri', 'Dikelola pemerintah', 'Dikelola non-pemerintah'], 'placeholder' => 'Pilih status pengelolaan'],
            'nama_pengelola' => [
                'label' => 'E6. Nama orang/instansi pengelola', 
                'type' => 'text', 
                'placeholder' => 'Masukkan nama pengelola',
                'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
            ],
            'alamat_pengelola' => [
                'label' => 'E7. Alamat', 
                'type' => 'textarea', 
                'placeholder' => 'Masukkan alamat pengelola',
                'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
            ],
            'koordinat_pengelola' => [
                'label' => 'E8. Koordinat', 
                'type' => 'text', 
                'placeholder' => 'Masukkan koordinat pengelola',
                'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
            ],
            
            // Deskripsi
            'deskripsi_detail' => ['label' => 'a. Deskripsi', 'type' => 'textarea', 'placeholder' => 'Masukkan deskripsi detail'],
            'batas_zonasi' => ['label' => 'b. Batas zonasi', 'type' => 'textarea', 'placeholder' => 'Masukkan batas zonasi'],
        ],
        
        'struktur' => [
            // Identitas Umum
            'nama_objek' => ['label' => 'A15. Nama ODCB/CB di lapangan', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
            'fungsi_objek' => [
                'label' => 'A16. Fungsi objek', 
                'type' => 'select', 
                'options' => ['Tembok', 'Sumur', 'Kapal selam', 'Kapal', 'Pesawat', 'Saluran air', 'Dermaga', 'Terowongan', 'Gua buatan', 'Menara', 'Bendung', 'Fondasi', 'Tugu', 'Gapura', 'Monumen', 'Pagar', 'Tiang', 'Lantai', 'Umpak', 'Jembatan', 'Makam', 'Lintasan rel', 'Jalan', 'Lainnya'],
                'placeholder' => 'Pilih fungsi objek'
            ],
            'sifat_objek' => ['label' => 'A17. Sifat objek', 'type' => 'select', 'options' => ['Sakral', 'Profan'], 'placeholder' => 'Pilih sifat'],
            'lokasi_penemuan' => ['label' => 'A18. Lokasi penemuan', 'type' => 'textarea', 'placeholder' => 'Masukkan lokasi penemuan'],
            'koordinat_lokasi' => ['label' => 'A19. Koordinat lokasi penemuan', 'type' => 'text', 'placeholder' => 'Contoh: -8.1234, 115.1234'],
            'elevasi' => ['label' => 'A20. Elevasi (ketinggian)', 'type' => 'text', 'placeholder' => 'Contoh: 500 mdpl'],
            'periode_objek' => ['label' => 'A21. Periode objek', 'type' => 'select', 'options' => ['Prasejarah', 'Klasik', 'Kolonial', 'Pergerakan', 'Modern'], 'placeholder' => 'Pilih periode'],
            
            // Informasi Fisik
            'bahan' => ['label' => 'B1. Bahan', 'type' => 'select', 'options' => ['Kayu', 'Bambu', 'Tanah', 'Bata', 'Beton', 'Batu', 'Lainnya'], 'placeholder' => 'Pilih bahan'],
            'waktu_pembuatan' => ['label' => 'B2. Waktu pembuatan (Tahun/Abad)', 'type' => 'text', 'placeholder' => 'Contoh: Abad 14 atau Tahun 1920'],
            'hiasan_ornamen' => [
                'label' => 'B3. Hiasan/ornamen', 
                'type' => 'checkbox_group', 
                'options' => ['Angka', 'Huruf', 'Inskripsi', 'Manusia', 'Antropomorf', 'Tumbuhan', 'Vegemorf', 'Binatang', 'Zuomorf', 'Geometris', 'Lukisan/relief adegan', 'Abstrak', 'Lainnya']
            ],
            'tanda_struktur' => [
                'label' => 'B4. Tanda yang dimiliki struktur', 
                'type' => 'checkbox_group', 
                'options' => ['Angka', 'Huruf', 'Inskripsi', 'Manusia', 'Antropomorf', 'Tumbuhan', 'Vegemorf', 'Binatang', 'Zuomorf', 'Geometris', 'Abstrak', 'Lainnya']
            ],
            
            // Dimensi
            'panjang' => ['label' => 'B5. Panjang (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan panjang'],
            'lebar' => ['label' => 'B6. Lebar (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan lebar'],
            'tinggi' => ['label' => 'B7. Tinggi', 'type' => 'text', 'placeholder' => 'Masukkan tinggi'],
            'diameter_atas' => ['label' => 'B8. Diameter atas (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan diameter atas'],
            'diameter_badan' => ['label' => 'B9. Diameter badan (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan diameter badan'],
            'diameter_kaki' => ['label' => 'B10. Diameter kaki', 'type' => 'text', 'placeholder' => 'Masukkan diameter kaki'],
            'luas_tanah' => ['label' => 'B11. Luas tanah (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan luas tanah'],
            'luas_struktur' => ['label' => 'B12. Luas struktur (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan luas struktur'],
            
            // Kondisi
            'keutuhan' => ['label' => 'C13. Keutuhan', 'type' => 'select', 'options' => ['Utuh', 'Tinggal sebagian', 'Musnah/hilang'], 'placeholder' => 'Pilih kondisi keutuhan'],
            'pemeliharaan' => ['label' => 'C14. Pemeliharaan', 'type' => 'select', 'options' => ['Terpelihara', 'Tidak terpelihara'], 'placeholder' => 'Pilih status pemeliharaan'],
            'pemugaran' => ['label' => 'C15. Pemugaran', 'type' => 'select', 'options' => ['Pernah dipugar', 'Belum pernah dipugar'], 'placeholder' => 'Pilih status pemugaran'],
            'riwayat_pemugaran' => [
                'label' => 'C16. Riwayat pemugaran', 
                'type' => 'textarea', 
                'placeholder' => 'Masukkan riwayat pemugaran',
                'condition' => ['field' => 'pemugaran', 'value' => 'Pernah dipugar']
            ],
            'adaptasi' => ['label' => 'C17. Adaptasi', 'type' => 'select', 'options' => ['Ada adaptasi', 'Tidak ada penambahan'], 'placeholder' => 'Pilih status adaptasi'],
            
            // Kepemilikan
            'status_kepemilikan' => ['label' => 'D11. Status kepemilikan', 'type' => 'select', 'options' => ['Pemerintah', 'Non-pemerintah'], 'placeholder' => 'Pilih status kepemilikan'],
            'nama_pemilik' => ['label' => 'D12. Nama orang/instansi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan nama pemilik'],
            'alamat_pemilik' => ['label' => 'D13. Alamat', 'type' => 'textarea', 'placeholder' => 'Masukkan alamat pemilik'],
            'koordinat_pemilik' => ['label' => 'D14. Koordinat lokasi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan koordinat pemilik'],
            'perolehan_bangunan' => ['label' => 'D15. Perolehan bangunan', 'type' => 'select', 'options' => ['Warisan', 'Pembelian', 'Hadiah', 'Hibah', 'Tukar menukar', 'Penemuan', 'Putusan pengadilan'], 'placeholder' => 'Pilih cara perolehan'],
            
            // Pengelolaan
            'status_pengelolaan' => ['label' => 'E9. Status pengelolaan', 'type' => 'select', 'options' => ['Dikelola sendiri', 'Dikelola pemerintah', 'Dikelola non-pemerintah'], 'placeholder' => 'Pilih status pengelolaan'],
            'nama_pengelola' => [
                'label' => 'E10. Nama orang/instansi pengelola', 
                'type' => 'text', 
                'placeholder' => 'Masukkan nama pengelola',
                'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
            ],
            'alamat_pengelola' => [
                'label' => 'E11. Alamat', 
                'type' => 'textarea', 
                'placeholder' => 'Masukkan alamat pengelola',
                'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
            ],
            'koordinat_pengelola' => [
                'label' => 'E12. Koordinat', 
                'type' => 'text', 
                'placeholder' => 'Masukkan koordinat pengelola',
                'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
            ],
            
            // Deskripsi
            'deskripsi_detail' => ['label' => 'a. Deskripsi', 'type' => 'textarea', 'placeholder' => 'Masukkan deskripsi detail'],
            'batas_zonasi' => ['label' => 'b. Batas zonasi', 'type' => 'textarea', 'placeholder' => 'Masukkan batas zonasi'],
        ],
        
        'bangunan' => [
            // Identitas Umum
            'nama_objek' => ['label' => 'A1. Nama ODCB/CB di lapangan', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
            'fungsi_objek' => [
                'label' => 'A2. Fungsi Objek', 
                'type' => 'select', 
                'options' => ['Penginapan', 'Rumah', 'Masjid', 'Musholla', 'Katedral', 'Gereja', 'Kapel', 'Wihara', 'Pura', 'Klenteng', 'Warung', 'Toko', 'Rumah toko', 'Pertokoan', 'Balai adat/masyarakat', 'Gedung permuan', 'Museum', 'Galeri', 'Sanggar', 'Teater', 'Rekreasi', 'Stadion', 'Gelanggang', 'Pusat Kebugaran', 'Bangunan Kelas', 'Laboratorium', 'Observatorium', 'Bangunan utama pelabuhan', 'Bangunan utama statsiun', 'Bangunan utama terminal', 'Bangunan utama bandara', 'Bengkel', 'Mercusuar', 'Penjara', 'Industri/pabrik', 'Barak', 'Pertahanan garis depan', 'Klinik', 'Puskesmas', 'Rumah sakit', 'Kantor', 'Musoleum', 'Gudang', 'Lainnya'],
                'placeholder' => 'Pilih fungsi objek'
            ],
            'sifat_objek' => ['label' => 'A3. Sifat Objek', 'type' => 'select', 'options' => ['Sakral', 'Profan'], 'placeholder' => 'Pilih sifat'],
            'lokasi_penemuan' => ['label' => 'A4. Lokasi', 'type' => 'textarea', 'placeholder' => 'Masukkan lokasi'],
            'koordinat_lokasi' => ['label' => 'A5. Koordinat lokasi penemuan', 'type' => 'text', 'placeholder' => 'Contoh: -8.1234, 115.1234'],
            'elevasi' => ['label' => 'A6. Elevasi (ketinggian)', 'type' => 'text', 'placeholder' => 'Contoh: 500 mdpl'],
            'periode_objek' => ['label' => 'A7. Periode objek', 'type' => 'select', 'options' => ['Prasejarah', 'Klasik', 'Kolonial', 'Pergerakan modern'], 'placeholder' => 'Pilih periode'],
            
            // Informasi Fisik
            'bahan' => ['label' => 'B1. Bahan', 'type' => 'checkbox_group', 'options' => ['Kayu', 'Bambu', 'Tanah', 'Bata', 'Beton bertulang', 'Batu', 'Karang', 'Lainnya']],
            'waktu_pembuatan' => ['label' => 'B2. Waktu pembuatan (Tahun/Abad)', 'type' => 'text', 'placeholder' => 'Contoh: Abad 14 atau Tahun 1920'],
            'gaya_arsitektur' => ['label' => 'B3. Gaya arsitektur', 'type' => 'select', 'options' => ['Hindu/Budha', 'Islam', 'Cina', 'Tradisional', 'Kolonial', 'Modern', 'Lainnya'], 'placeholder' => 'Pilih gaya arsitektur'],
            'bentuk_atap' => ['label' => 'B4. Bentuk atap', 'type' => 'select', 'options' => ['Tumpang', 'Kubah', 'Pelana', 'Limas', 'Menara', 'Lainnya'], 'placeholder' => 'Pilih bentuk atap'],
            'hiasan_ornamen' => [
                'label' => 'B5. Hiasan/ornamen', 
                'type' => 'checkbox_group', 
                'options' => ['Angka', 'Huruf', 'Inskripsi', 'Manusia', 'Antropomorf', 'Tumbuhan', 'Vegemorf', 'Binatang', 'Zuomorf', 'Geometris', 'Campuran', 'Lukisan/relief adegan', 'Abstrak', 'Lainnya']
            ],
            'tanda_bangunan' => [
                'label' => 'B6. Tanda yang dimiliki bangunan', 
                'type' => 'checkbox_group', 
                'options' => ['Angka', 'Huruf', 'Inskripsi', 'Manusia', 'Antropomorf', 'Tumbuhan', 'Vegemorf', 'Binatang', 'Zuomorf', 'Geometris', 'Abstrak', 'Lainnya']
            ],
            'warna' => ['label' => 'B7. Warna', 'type' => 'text', 'placeholder' => 'Masukkan warna bangunan'],
            
            // Dimensi
            'panjang' => ['label' => 'C1. Panjang (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan panjang'],
            'lebar' => ['label' => 'C2. Lebar (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan lebar'],
            'tinggi' => ['label' => 'C3. Tinggi (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan tinggi'],
            'luas_bangunan' => ['label' => 'C4. Luas bangunan (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan luas bangunan'],
            'luas_tanah' => ['label' => 'C5. Luas tanah (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan luas tanah'],
            
            // Kondisi
            'keutuhan' => ['label' => 'C18. Keutuhan', 'type' => 'select', 'options' => ['Utuh', 'Tinggal sebagian', 'Musnah/hilang'], 'placeholder' => 'Pilih kondisi keutuhan'],
            'pemeliharaan' => ['label' => 'C19. Pemeliharaan', 'type' => 'select', 'options' => ['Terpelihara', 'Tidak terpelihara'], 'placeholder' => 'Pilih status pemeliharaan'],
            'pemugaran' => ['label' => 'C20. Pemugaran', 'type' => 'select', 'options' => ['Pernah dipugar', 'Belum pernah dipugar'], 'placeholder' => 'Pilih status pemugaran'],
            'riwayat_pemugaran' => [
                'label' => 'C21. Riwayat pemugaran', 
                'type' => 'textarea', 
                'placeholder' => 'Masukkan riwayat pemugaran',
                'condition' => ['field' => 'pemugaran', 'value' => 'Pernah dipugar']
            ],
            'adaptasi' => ['label' => 'C22. Adaptasi', 'type' => 'select', 'options' => ['Ada adaptasi', 'Tidak ada penambahan'], 'placeholder' => 'Pilih status adaptasi'],
            'riwayat_adaptasi' => [
                'label' => 'C23. Riwayat adaptasi', 
                'type' => 'textarea', 
                'placeholder' => 'Masukkan riwayat adaptasi',
                'condition' => ['field' => 'adaptasi', 'value' => 'Ada adaptasi']
            ],
            
            // Kepemilikan
            'status_kepemilikan' => ['label' => 'D16. Status kepemilikan', 'type' => 'select', 'options' => ['Pemerintah', 'Non-pemerintah'], 'placeholder' => 'Pilih status kepemilikan'],
            'nama_pemilik' => ['label' => 'D17. Nama orang/instansi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan nama pemilik'],
            'alamat_pemilik' => ['label' => 'D18. Alamat', 'type' => 'textarea', 'placeholder' => 'Masukkan alamat pemilik'],
            'koordinat_pemilik' => ['label' => 'D19. Koordinat lokasi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan koordinat pemilik'],
            'perolehan_bangunan' => ['label' => 'D20. Perolehan bangunan', 'type' => 'select', 'options' => ['Warisan', 'Pembelian', 'Hadiah', 'Hibah', 'Tukar menukar', 'Penemuan', 'Putusan pengadilan'], 'placeholder' => 'Pilih cara perolehan'],
            
            // Pengelolaan
            'status_pengelolaan' => ['label' => 'E13. Status pengelolaan', 'type' => 'select', 'options' => ['Dikelola sendiri', 'Dikelola pemerintah', 'Dikelola non-pemerintah'], 'placeholder' => 'Pilih status pengelolaan'],
            'nama_pengelola' => [
                'label' => 'E14. Nama orang/instansi pengelola', 
                'type' => 'text', 
                'placeholder' => 'Masukkan nama pengelola',
                'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
            ],
            'alamat_pengelola' => [
                'label' => 'E15. Alamat', 
                'type' => 'textarea', 
                'placeholder' => 'Masukkan alamat pengelola',
                'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
            ],
            'koordinat_pengelola' => [
                'label' => 'E16. Koordinat', 
                'type' => 'text', 
                'placeholder' => 'Masukkan koordinat pengelola',
                'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
            ],
            
            // Deskripsi
            'deskripsi_detail' => ['label' => 'a. Deskripsi', 'type' => 'textarea', 'placeholder' => 'Masukkan deskripsi detail'],
            'batas_zonasi' => ['label' => 'b. Batas zonasi', 'type' => 'textarea', 'placeholder' => 'Masukkan batas zonasi'],
        ],
        
        'benda' => [
            // Identitas Umum
            'nama_objek' => ['label' => 'A1. Nama ODCB/CB di lapangan', 'type' => 'text', 'placeholder' => 'Masukkan nama objek', 'required' => true],
            'kelompok_objek_benda' => [
                'label' => 'A2. Kelompok objek benda', 
                'type' => 'select', 
                'options' => ['Prasasti/inkripsi', 'Peralatan masak', 'Peralatan rumah tangga', 'Peralatan musik', 'Senjata', 'Naskah', 'Rekaman', 'Kendaraan', 'Citra', 'Pakaian', 'Aksesori pakaian', 'Perhiasan', 'Peralatan makan', 'Peralatan seni pertunjukan', 'Peralatan komunikasi', 'Peralatan tulis/gambar', 'Peralatan pertanian/perkebunan', 'Peralatan medis', 'Peralatan perekam audio/visual', 'Peralatan spiritual', 'Fosil', 'Dekorasi rumah', 'Jam dinding/jam almari', 'Alat hitung', 'Alat pembayaran', 'Lainnya'],
                'placeholder' => 'Pilih kelompok objek'
            ],
            'sifat_benda' => ['label' => 'A3. Sifat benda', 'type' => 'select', 'options' => ['Sakral', 'Profan'], 'placeholder' => 'Pilih sifat'],
            'lokasi_penemuan' => ['label' => 'A4. Lokasi penemuan (Provinsi s.d Desa)', 'type' => 'textarea', 'placeholder' => 'Masukkan lokasi penemuan'],
            'koordinat_lokasi' => ['label' => 'A5. Koordinat lokasi penemuan (Lintang & Bujur)', 'type' => 'text', 'placeholder' => 'Contoh: -8.1234, 115.1234'],
            'elevasi' => ['label' => 'A6. Elevasi (ketinggian)', 'type' => 'text', 'placeholder' => 'Contoh: 500 mdpl'],
            'periode_benda' => ['label' => 'A7. Periode benda', 'type' => 'select', 'options' => ['Prasejarah', 'Klasik', 'Kolonial', 'Pergerakan', 'Modern'], 'placeholder' => 'Pilih periode'],
            
            // Informasi Fisik
            'bahan' => [
                'label' => 'B1. Bahan', 
                'type' => 'select', 
                'options' => ['Kayu', 'Rotan', 'Bambu', 'Serat', 'Daun', 'Kulit kayu', 'Karet', 'Getah', 'Bunga', 'Kelopak', 'Buah', 'Kulit buah', 'Biji', 'Tepung', 'Gabus', 'Tulang', 'Gigi', 'Gading', 'Kulit', 'Bulu', 'Rambut', 'Daging', 'Otot', 'Tanduk', 'Cula', 'Paruh', 'Kuku', 'Sutra', 'Katun', 'Sabut', 'Tempurung', 'Lidi', 'Karton', 'Duri', 'Sisik', 'Karapas', 'Kerang', 'Siput', 'Mutiara', 'Karang', 'Batu', 'Pre-fosil', 'Fosil', 'Logam', 'Kaca', 'Tanah', 'Kapur', 'Pasir', 'Keramik', 'Terakota', 'Lilin', 'Aspal', 'Plastik', 'Mika', 'Mineral', 'Poliester', 'Sintetis', 'Lainnya'],
                'placeholder' => 'Pilih bahan utama'
            ],
            'waktu_pembuatan' => ['label' => 'B2. Waktu pembuatan (Tahun/Abad)', 'type' => 'text', 'placeholder' => 'Contoh: Abad 14 atau Tahun 1920'],
            'hiasan_ornamen' => [
                'label' => 'B3. Hiasan/ornamen', 
                'type' => 'checkbox_group', 
                'options' => ['Angka', 'Huruf', 'Inskripsi/tulisan', 'Manusia', 'Antromorf', 'Abstrak', 'Tumbuhan', 'Vegemorf', 'Binatang', 'Zuomorf', 'Geometris', 'Panorama', 'Campuran', 'Lainnya']
            ],
            'tanda' => [
                'label' => 'B4. Tanda', 
                'type' => 'checkbox_group', 
                'options' => ['Angka', 'Huruf', 'Inskripsi/tulisan', 'Manusia', 'Antromorf', 'Abstrak', 'Tumbuhan', 'Vegemorf', 'Binatang', 'Zuomorf', 'Geometris', 'Panorama', 'Campuran', 'Lainnya']
            ],
            'warna' => ['label' => 'B5. Warna', 'type' => 'text', 'placeholder' => 'Masukkan warna benda'],
            
            // Dimensi
            'panjang' => ['label' => 'C1. Panjang (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan panjang'],
            'lebar' => ['label' => 'C2. Lebar (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan lebar'],
            'tinggi' => ['label' => 'C3. Tinggi (mm/cm/m)', 'type' => 'text', 'placeholder' => 'Masukkan tinggi'],
            'tebal' => ['label' => 'C4. Tebal', 'type' => 'text', 'placeholder' => 'Masukkan tebal'],
            'berat' => ['label' => 'C5. Berat', 'type' => 'text', 'placeholder' => 'Masukkan berat'],
            'volume' => ['label' => 'C6. Volume', 'type' => 'text', 'placeholder' => 'Masukkan volume'],
            'diameter_atas' => ['label' => 'C7. Diameter atas', 'type' => 'text', 'placeholder' => 'Masukkan diameter atas'],
            'diameter_badan' => ['label' => 'C8. Diameter badan', 'type' => 'text', 'placeholder' => 'Masukkan diameter badan'],
            'diameter_kaki' => ['label' => 'C9. Diameter kaki', 'type' => 'text', 'placeholder' => 'Masukkan diameter kaki'],
            
            // Kondisi
            'keutuhan' => ['label' => 'D1. Keutuhan', 'type' => 'select', 'options' => ['Utuh', 'Tinggal sebagian', 'Musnah/hilang'], 'placeholder' => 'Pilih kondisi keutuhan'],
            'pemeliharaan' => ['label' => 'D2. Pemeliharaan', 'type' => 'select', 'options' => ['Terpelihara', 'Tidak terpelihara'], 'placeholder' => 'Pilih status pemeliharaan'],
            'pemugaran' => ['label' => 'D3. Pemugaran', 'type' => 'select', 'options' => ['Pernah dipugar', 'Belum pernah dipugar'], 'placeholder' => 'Pilih status pemugaran'],
            'riwayat_pemugaran' => [
                'label' => 'D4. Riwayat pemugaran', 
                'type' => 'textarea', 
                'placeholder' => 'Masukkan riwayat pemugaran',
                'condition' => ['field' => 'pemugaran', 'value' => 'Pernah dipugar']
            ],
            'adaptasi' => ['label' => 'D5. Adaptasi', 'type' => 'select', 'options' => ['Ada adaptasi', 'Tidak ada penambahan'], 'placeholder' => 'Pilih status adaptasi'],
            'riwayat_adaptasi' => [
                'label' => 'D6. Riwayat adaptasi', 
                'type' => 'textarea', 
                'placeholder' => 'Masukkan riwayat adaptasi',
                'condition' => ['field' => 'adaptasi', 'value' => 'Ada adaptasi']
            ],
            
            // Kepemilikan
            'status_kepemilikan' => ['label' => 'E1. Status kepemilikan', 'type' => 'select', 'options' => ['Pemerintah', 'Non-pemerintah'], 'placeholder' => 'Pilih status kepemilikan'],
            'nama_pemilik' => ['label' => 'E2. Nama orang/instansi pemilik', 'type' => 'text', 'placeholder' => 'Masukkan nama pemilik'],
            'alamat_pemilik' => ['label' => 'E3. Alamat (Provinsi s.d Desa)', 'type' => 'textarea', 'placeholder' => 'Masukkan alamat pemilik'],
            'koordinat_pemilik' => ['label' => 'E4. Koordinat (Lintang & Bujur)', 'type' => 'text', 'placeholder' => 'Masukkan koordinat pemilik'],
            'perolehan_benda' => ['label' => 'E5. Perolehan benda', 'type' => 'select', 'options' => ['Warisan', 'Pembelian', 'Hadiah', 'Hibah', 'Tukar menukar', 'Penemuan', 'Putusan pengadilan'], 'placeholder' => 'Pilih cara perolehan'],
            
            // Pengelolaan
            'status_pengelolaan' => ['label' => 'F1. Status pengelolaan', 'type' => 'select', 'options' => ['Dikelola sendiri', 'Dikelola pemerintah', 'Dikelola non-pemerintah'], 'placeholder' => 'Pilih status pengelolaan'],
            'nama_pengelola' => [
                'label' => 'F2. Nama orang/instansi pengelola', 
                'type' => 'text', 
                'placeholder' => 'Masukkan nama pengelola',
                'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
            ],
            'alamat_pengelola' => [
                'label' => 'F3. Alamat', 
                'type' => 'textarea', 
                'placeholder' => 'Masukkan alamat pengelola',
                'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
            ],
            'koordinat_pengelola' => [
                'label' => 'F4. Koordinat', 
                'type' => 'text', 
                'placeholder' => 'Masukkan koordinat pengelola',
                'condition' => ['field' => 'status_pengelolaan', 'value' => ['Dikelola pemerintah', 'Dikelola non-pemerintah']]
            ],
            
            // Deskripsi
            'deskripsi_sejarah' => ['label' => '7. Deskripsi Sejarah', 'type' => 'textarea', 'placeholder' => 'Masukkan deskripsi sejarah'],
        ],
    ],
];
