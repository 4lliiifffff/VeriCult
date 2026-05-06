# VeriCult - Sistem Verifikasi Kebudayaan Digital

<p align="center">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

**VeriCult** adalah platform digital terintegrasi yang dirancang untuk proses pengajuan, validasi, dan sertifikasi objek kebudayaan di Indonesia. Sistem ini memastikan setiap data kebudayaan yang masuk melewati proses verifikasi berjenjang yang akurat untuk menjaga keaslian dan kualitas data warisan budaya Nusantara.

---

## 🚀 Fitur Utama

- **Pengajuan Objek Budaya**: Mendukung berbagai kategori seperti *Cagar Budaya*, *Potensi Kebudayaan*, dan *OPK Kebudayaan*.
- **Verifikasi Berjenjang**: Alur kerja sistematis mulai dari peninjauan administratif hingga verifikasi lapangan oleh tenaga ahli.
- **Manajemen Peran (RBAC)**: Hak akses spesifik untuk Super Admin, Admin, Validator, dan Pengusul (Individu & Desa).
- **Portal Publik**: Galeri profil kebudayaan yang telah terverifikasi dan dapat diakses oleh masyarakat umum.
- **Sistem Notifikasi**: Pembaruan status pengajuan secara real-time untuk setiap pengguna.
- **Manajemen Konten (CMS)**: Pengelolaan konten halaman landing secara dinamis oleh administrator.
- **Pelaporan & Audit**: Pembuatan laporan dalam format cetak/PDF dan pencatatan log audit untuk transparansi data.

---

## 🛠️ Tumpukan Teknologi

- **Framework**: [Laravel 12](https://laravel.com)
- **Autentikasi**: [Laravel Breeze](https://laravel.com/docs/breeze)
- **Otorisasi**: [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- **Frontend**: [Tailwind CSS](https://tailwindcss.com) & [Vite](https://vitejs.dev)
- **Database**: MySQL / SQLite
- **Asset Manager**: NPM

---

## 👥 Peran & Tanggung Jawab

| Peran | Deskripsi |
|-------|-----------|
| **Super Admin** | Kontrol penuh sistem, manajemen user (Admin/Validator), audit log, dan CMS. |
| **Admin** | Menyetujui pendaftaran Pengusul Desa dan mengelola publikasi OPK. |
| **Validator** | Tenaga ahli yang meninjau teknis, melakukan verifikasi lapangan, dan menerbitkan data. |
| **Pengusul** | Pengguna umum yang mengajukan data kebudayaan dasar. |
| **Pengusul Desa** | Perwakilan desa yang mengajukan data kebudayaan detail (memerlukan persetujuan admin). |

---

## 🔄 Alur Kerja Pengajuan

1. **Draft**: Pengusul mengisi formulir data kebudayaan.
2. **Submitted**: Data dikirimkan untuk ditinjau oleh Validator.
3. **Review**: Validator melakukan tinjauan administratif dan teknis (bisa diminta revisi).
4. **Field Verification**: Proses verifikasi langsung di lokasi oleh tim ahli.
5. **Verified/Published**: Data yang valid diterbitkan ke profil publik dan mendapatkan status terverifikasi.

---

## 💻 Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di lingkungan lokal:

1. **Clone repositori**:
   ```bash
   git clone https://github.com/4lliiiffff/vericult.git
   cd vericult
   ```

2. **Instal dependensi PHP**:
   ```bash
   composer install
   ```

3. **Instal dependensi JavaScript**:
   ```bash
   npm install
   ```

4. **Siapkan file environment**:
   ```bash
   cp .env.example .env
   # Sesuaikan konfigurasi database di file .env
   ```

5. **Generate App Key**:
   ```bash
   php artisan key:generate
   ```

6. **Jalankan migrasi dan seeder**:
   ```bash
   php artisan migrate --seed
   ```

7. **Jalankan server pengembangan**:
   ```bash
   npm run dev
   # Di terminal terpisah
   php artisan serve
   ```

---

## 📄 Lisensi

Proyek ini adalah perangkat lunak sumber terbuka yang dilisensikan di bawah [Lisensi MIT](https://opensource.org/licenses/MIT).