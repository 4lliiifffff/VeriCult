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

## Panduan Developer: Mengelola Field Formulir Pengajuan

Semua field/pertanyaan pada formulir pengajuan kebudayaan didefinisikan secara terpusat di **satu file konfigurasi**:

```
config/category_fields.php
```

Mengubah file ini cukup untuk menambah, mengubah, atau menghapus field di semua formulir pengajuan (Pengusul, Pengusul Desa, tampilan Validator, dan Super Admin).

---

### Struktur File Konfigurasi

File ini adalah array PHP dengan kunci berupa nama kategori (sesuai `CulturalSubmission::CATEGORIES`). Ada dua pola struktur:

**Pola 1 — Kategori tanpa sub-kategori** (misal: Bahasa, Ritus):

```php
'Bahasa' => [
    'has_sub' => false,
    'fields' => [
        'nama_objek' => [
            'label'       => 'Nama Objek Bahasa',   // teks label yang tampil di form
            'type'        => 'text',                 // tipe input (lihat daftar di bawah)
            'placeholder' => 'Masukkan nama objek bahasa',
            'required'    => true,                   // wajib diisi atau tidak
        ],
        // field berikutnya...
    ],
],
```

**Pola 2 — Kategori dengan sub-kategori** (misal: Seni, Pengetahuan Tradisional):

```php
'Seni' => [
    'has_sub'     => true,
    'sub_field'   => 'sub_kategori_seni',       // key hidden input untuk menyimpan pilihan sub
    'sub_label'   => 'Pilih Jenis Seni',        // label dropdown pemilih sub-kategori
    'sub_options' => [
        'seni_rupa' => 'Seni Rupa',             // key => label pilihan sub
        'lagu'      => 'Lagu',
        // ...
    ],
    'fields' => [
        'seni_rupa' => [                        // field milik sub-kategori 'seni_rupa'
            'nama_objek' => ['label' => '...', 'type' => 'text', 'required' => true],
        ],
        'lagu' => [
            'nama_objek' => ['label' => '...', 'type' => 'text', 'required' => true],
        ],
    ],
],
```

---

### Tipe Field yang Tersedia

| Tipe             | Deskripsi                                          | Properti tambahan                          |
|------------------|----------------------------------------------------|--------------------------------------------|
| `text`           | Input teks satu baris                              | `placeholder`                              |
| `textarea`       | Input teks multi-baris                             | `placeholder`                              |
| `select`         | Dropdown pilihan tunggal                           | `options` (array), `placeholder`           |
| `radio`          | Pilihan radio button                               | `options` (array)                          |
| `checkbox_group` | Pilihan centang (multi-select)                     | `options` (array)                          |
| `date`           | Date picker                                        | `placeholder`                              |
| `datalist`       | Input teks dengan autocomplete dari daftar desa    | `placeholder`                              |
| `dynamic_table`  | Tabel dengan baris yang bisa ditambah/dihapus      | `columns` (array label), `column_keys` (array key) |

---

### Cara Menambah Field Baru

Tambahkan entri baru di dalam array `fields` kategori/sub-kategori yang sesuai. Key field harus menggunakan `snake_case`.

```php
// Contoh: menambah field 'sumber_dana' pada sub-kategori 'seni_pertunjukan'
'seni_pertunjukan' => [
    // ...field yang sudah ada...
    'sumber_dana' => [
        'label'       => 'Sumber Dana Pertunjukan',
        'type'        => 'select',
        'options'     => ['Mandiri', 'Sponsor', 'Pemerintah', 'Hibah'],
        'placeholder' => 'Pilih sumber dana',
        'required'    => false,
    ],
],
```

---

### Cara Mengubah Label atau Placeholder

Langsung ubah nilai `'label'` atau `'placeholder'` pada field yang bersangkutan:

```php
// Sebelum
'etnis' => ['label' => 'Etnis yang melaksanakan', 'type' => 'text', ...],

// Sesudah
'etnis' => ['label' => 'Suku Bangsa Pelaksana', 'type' => 'text', ...],
```

---

### Cara Mengubah Status Wajib (Required)

Tambah atau hapus properti `'required' => true` pada field:

```php
// Menjadikan field wajib
'lokasi' => ['label' => 'Lokasi', 'type' => 'text', 'required' => true],

// Menjadikan field opsional (hapus 'required' atau set ke false)
'lokasi' => ['label' => 'Lokasi', 'type' => 'text'],
```

> **Catatan:** Properti `required` hanya mengontrol validasi sisi server dan tampilan tanda `*` di form. Validasi frontend (client-side) juga menggunakan atribut ini melalui `data-required="true"` yang di-render otomatis.

---

### Cara Menghapus Field

Hapus seluruh entri field dari array. Pastikan tidak ada submission data lama yang bergantung pada field tersebut jika ingin menjaga konsistensi tampilan data historis.

```php
// Hapus field ini dari array fields kategori
// 'nama_field_lama' => [...],
```

---

### Field dengan Kondisi Tampil (Conditional)

Field bisa dikonfigurasi agar hanya muncul ketika field lain bernilai tertentu:

```php
'nama_pencipta' => [
    'label'     => 'Nama pencipta manuskrip',
    'type'      => 'text',
    'condition' => [
        'field' => 'mengetahui_pencipta',  // key field pemicu
        'value' => 'Ya',                   // nilai yang memicu tampilnya field ini
    ],
],
```

---

### File Terkait Lainnya

| File | Fungsi |
|------|--------|
| `app/Models/CulturalSubmission.php` | Method `getCategoryFields()` dan `getFlatCategoryFields()` — digunakan controller untuk memuat config |
| `resources/views/pengusul/submissions/partials/field-renderer.blade.php` | Merender field untuk Pengusul Umum |
| `resources/views/pengusul-desa/submissions/partials/field-renderer.blade.php` | Merender field untuk Pengusul Desa |

> **Penting:** Jangan mengubah key field (misal `nama_objek`) yang sudah dipakai di data submission yang tersimpan di database, karena data historis akan kehilangan nilai field tersebut saat ditampilkan.

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
