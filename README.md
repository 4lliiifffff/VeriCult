# VeriCult - Sistem Verifikasi Kebudayaan Digital

<p align="center">
    <img src="public/Logo/Putih/Logo-Sistem-W-Bg.png" width="400" alt="VeriCult Logo">
</p>

**VeriCult** adalah platform digital untuk mengelola pengajuan, verifikasi, dan publikasi objek kebudayaan di Indonesia. Sistem ini mendukung alur kerja berjenjang, mulai dari pengajuan data oleh masyarakat hingga verifikasi lapangan oleh validator ahli.

---

## Fitur Utama

- **Pengajuan Objek Budaya**: Formulir pengusulan lengkap untuk Cagar Budaya, Potensi Kebudayaan, dan OPK Kebudayaan.
- **Verifikasi Berjenjang**: Proses review administratif, review teknis, dan verifikasi lapangan.
- **Manajemen Peran (RBAC)**: Role-based access control untuk Super Admin, Admin, Validator, Pengusul, dan Pengusul Desa.
- **Notifikasi**: Filter notifikasi, status unread/read, dan tombol hapus semua notifikasi.
- **CMS Dinamis**: Pengelolaan konten landing page secara langsung melalui dashboard.
- **Audit Log**: Catatan aktivitas pengguna untuk transparansi dan pemantauan.
- **Portal Publik**: Publikasi data kebudayaan yang terverifikasi untuk akses masyarakat umum.

---

## Stack Teknologi

- **PHP 8.2+**
- **Laravel 12**
- **Laravel Breeze**
- **Spatie Laravel Permission**
- **Tailwind CSS**
- **Vite**
- **MySQL / SQLite**
- **NPM**

---

## Peran dan Akses

| Peran             | Fungsi Utama                                                                      |
| ----------------- | --------------------------------------------------------------------------------- |
| **Super Admin**   | Kelola semua pengguna, role, CMS, audit log, dan konfigurasi sistem.              |
| **Admin**         | Menyetujui registrasi Pengusul Desa, memantau pengajuan, dan mengelola publikasi. |
| **Validator**     | Meninjau pengajuan, meminta revisi, dan melakukan verifikasi teknis/lapangan.     |
| **Pengusul**      | Mengajukan data kebudayaan dan melihat status pengajuan.                          |
| **Pengusul Desa** | Mengajukan data kebudayaan desa dan mengikuti alur approval Admin.                |

---

## Instalasi Lengkap

### Prasyarat

- PHP 8.2 atau lebih baru
- Composer
- Node.js dan NPM
- MySQL / MariaDB atau SQLite
- Ekstensi PHP: `pdo`, `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`

### Langkah Instalasi

1. **Clone repositori**

    ```bash
    git clone https://github.com/4lliiiffff/vericult.git
    cd vericult
    ```

2. **Instal dependensi PHP**

    ```bash
    composer install
    ```

3. **Instal dependensi JavaScript**

    ```bash
    npm install
    ```

4. **Salin file environment**

    ```bash
    cp .env.example .env
    ```

5. **Sesuaikan konfigurasi `.env`**
    - `APP_URL`
    - `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
    - opsional: `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME`

6. **Konfigurasi SMTP (opsional)**

    Untuk mengaktifkan email, gunakan konfigurasi SMTP di file `.env`:

    ```dotenv
    MAIL_MAILER=smtp
    MAIL_HOST=smtp.gmail.com
    MAIL_PORT=587
    MAIL_ENCRYPTION=tls
    MAIL_USERNAME=alamat_email_anda@example.com
    MAIL_PASSWORD=password_email_anda
    MAIL_FROM_ADDRESS=alamat_email_anda@example.com
    MAIL_FROM_NAME="VeriCult"
    ```

    Atau untuk testing lokal tanpa SMTP, gunakan driver log:

    ```dotenv
    MAIL_MAILER=log
    ```

7. **Generate key aplikasi**

    ```bash
    php artisan key:generate
    ```

8. **Migrasi dan seeder database**

    ```bash
    php artisan migrate --seed
    ```

9. **Buat symbolic link storage**

    ```bash
    php artisan storage:link
    ```

10. **Jalankan aplikasi**
    ```bash
    php artisan serve
    npm run dev
    ```

> Untuk menjalankan semua service sekaligus, gunakan:
>
> ```bash
> composer run dev
> ```

---

## Setup Otomatis

Jika ingin instalasi penuh dengan satu perintah:

```bash
composer run setup
```

Perintah ini akan:

- menginstal dependensi PHP
- menyalin file `.env`
- generate app key
- menjalankan migrasi
- menginstal dependensi JS
- membangun aset Vite

---

## Akun Default Seeded

Setelah `php artisan migrate --seed`, akun berikut tersedia:

| Peran         | Email                         | Password   |
| ------------- | ----------------------------- | ---------- |
| Super Admin   | `superadmin@vericult.co.id`   | `password` |
| Admin         | `admin@vericult.co.id`        | `password` |
| Validator     | `validator@vericult.co.id`    | `password` |
| Pengusul      | `pengusul@vericult.co.id`     | `password` |
| Pengusul Desa | `pengusuldesa@vericult.co.id` | `password` |

> Jika akun Pengusul Desa tidak muncul, pastikan data desa sudah terseed sebelum menjalankan seeder.

---

## Fitur Lengkap

- Registrasi dan login user
- Dashboard role-spesifik
- Pengajuan objek kebudayaan dengan metadata dan dokumen pendukung
- Review administratif dan teknis
- Verifikasi lapangan dan status validasi
- Sistem notifikasi untuk setiap pengguna
- Filter notifikasi, status, dan tanggal
- Tombol hapus semua notifikasi di header admin
- CMS halaman landing dan konten dinamis
- Audit log dan history aktivitas pengguna
- Manajemen role dan hak akses

---

## Pengujian

Jalankan test suite:

```bash
php artisan test
```

---

## Catatan Tambahan

- Untuk opsi cepat, Anda bisa gunakan SQLite dengan `DB_CONNECTION=sqlite` dan membuat file `database/database.sqlite`.
- Pastikan `APP_URL` di `.env` sesuai dengan URL lokal Anda.
- Jika ingin menguji email, atur `MAIL_*` dengan benar atau gunakan mail driver `log` untuk pengembangan.
- Periksa `storage/logs/laravel.log` jika ada masalah saat migrasi atau seed.

---

## Developer Team

VeriCult dikembangkan oleh:

| Nama | Peran |
|------|--------|
| **Muhamad Alif Nur Rohman** | Full Stack Developer |
| **Layang Puspa Hanifa** | Quality Assurance |

## Lisensi

Proyek ini dilisensikan di bawah [Lisensi MIT](https://opensource.org/licenses/MIT).
