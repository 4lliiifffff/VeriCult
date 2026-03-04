<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            // PAGE: BERANDA
            ['page' => 'beranda', 'section' => 'hero_badge', 'type' => 'text', 'label' => 'Badge Hero', 'value' => 'Sistem Verifikasi Kebudayaan Terpercaya', 'sort_order' => 1],
            ['page' => 'beranda', 'section' => 'hero_title', 'type' => 'text', 'label' => 'Judul Hero', 'value' => 'Lestarikan Budaya Melalui Verifikasi Digital', 'sort_order' => 2],
            ['page' => 'beranda', 'section' => 'hero_subtitle', 'type' => 'textarea', 'label' => 'Subjudul Hero', 'value' => 'Platform digital terintegrasi untuk pengajuan, validasi, dan sertifikasi objek kebudayaan Indonesia dengan sistem verifikasi berjenjang yang akurat.', 'sort_order' => 3],
            ['page' => 'beranda', 'section' => 'cta_primary', 'type' => 'text', 'label' => 'Teks Tombol Utama', 'value' => 'Ajukan Objek', 'sort_order' => 4],
            ['page' => 'beranda', 'section' => 'cta_secondary', 'type' => 'text', 'label' => 'Teks Tombol Kedua', 'value' => 'Jelajahi Profil Budaya', 'sort_order' => 5],
            ['page' => 'beranda', 'section' => 'gallery_title', 'type' => 'text', 'label' => 'Judul Seksi Galeri', 'value' => 'Warisan Budaya Terverifikasi', 'sort_order' => 6],
            ['page' => 'beranda', 'section' => 'gallery_subtitle', 'type' => 'textarea', 'label' => 'Subjudul Seksi Galeri', 'value' => 'Jelajahi kekayaan budaya Nusantara yang telah melewati proses verifikasi berjenjang dan diakui keabsahannya.', 'sort_order' => 7],
            ['page' => 'beranda', 'section' => 'cta_bottom_title', 'type' => 'text', 'label' => 'Judul CTA Bawah', 'value' => 'Siap Melestarikan Warisan Budaya Melalui VeriCult?', 'sort_order' => 8],
            ['page' => 'beranda', 'section' => 'cta_bottom_subtitle', 'type' => 'textarea', 'label' => 'Subjudul CTA Bawah', 'value' => 'Bergabunglah dengan komunitas pengusul lainnya dan pastikan setiap warisan budaya tervalidasi dengan standar tertinggi.', 'sort_order' => 9],
            
            // PAGE: TENTANG
            ['page' => 'tentang', 'section' => 'hero_title', 'type' => 'text', 'label' => 'Judul Hero Tentang', 'value' => 'Misi Kami Untuk Pelestarian Budaya Indonesia', 'sort_order' => 1],
            ['page' => 'tentang', 'section' => 'hero_subtitle', 'type' => 'textarea', 'label' => 'Subjudul Hero Tentang', 'value' => 'VeriCult adalah sistem digital inovatif yang dirancang untuk memfasilitasi proses pengajuan, validasi, dan sertifikasi objek kebudayaan Indonesia.', 'sort_order' => 2],
            ['page' => 'tentang', 'section' => 'about_title', 'type' => 'text', 'label' => 'Judul Mengapa VeriCult', 'value' => 'Mengapa VeriCult?', 'sort_order' => 3],
            ['page' => 'tentang', 'section' => 'about_description', 'type' => 'textarea', 'label' => 'Deskripsi Mengapa VeriCult', 'value' => 'VeriCult adalah platform digital terintegrasi yang dirancang khusus untuk memfasilitasi proses pengajuan, validasi, dan sertifikasi objek kebudayaan Indonesia. Kami berkomitmen menjaga otentisitas data melalui teknologi mutakhir dan sistem verifikasi berjenjang.', 'sort_order' => 4],
            
            // PAGE: FITUR
            ['page' => 'fitur', 'section' => 'hero_title', 'type' => 'text', 'label' => 'Judul Hero Fitur', 'value' => 'Ekosistem Digital Budaya', 'sort_order' => 1],
            ['page' => 'fitur', 'section' => 'hero_subtitle', 'type' => 'textarea', 'label' => 'Subjudul Hero Fitur', 'value' => 'Kami menghadirkan fitur-fitur berstandar industri untuk memastikan integritas dan kemudahan dalam pendataan kebudayaan.', 'sort_order' => 2],
            
            // PAGE: GLOBAL
            ['page' => 'global', 'section' => 'site_name', 'type' => 'text', 'label' => 'Nama Situs', 'value' => 'VeriCult', 'sort_order' => 1],
            ['page' => 'global', 'section' => 'footer_description', 'type' => 'textarea', 'label' => 'Deskripsi Footer', 'value' => 'Platform verifikasi digital terpercaya untuk melestarikan dan mengabsahkan kekayaan budaya Nusantara.', 'sort_order' => 2],
            ['page' => 'global', 'section' => 'contact_email', 'type' => 'text', 'label' => 'Email Kontak', 'value' => 'official@vericult.id', 'sort_order' => 3],
            ['page' => 'global', 'section' => 'contact_phone', 'type' => 'text', 'label' => 'Nomor Telepon', 'value' => '+62 123 4455 6677', 'sort_order' => 4],
            ['page' => 'global', 'section' => 'contact_wa', 'type' => 'text', 'label' => 'WhatsApp (62...)', 'value' => '62812344556677', 'sort_order' => 5],
            ['page' => 'global', 'section' => 'contact_address', 'type' => 'textarea', 'label' => 'Alamat Kantor', 'value' => 'Jl. Kebudayaan No. 123, Jakarta Selatan, DKI Jakarta 12345', 'sort_order' => 6],
            ['page' => 'global', 'section' => 'social_ig', 'type' => 'url', 'label' => 'URL Instagram', 'value' => 'https://instagram.com/vericult', 'sort_order' => 7],
            ['page' => 'global', 'section' => 'social_fb', 'type' => 'url', 'label' => 'URL Facebook', 'value' => 'https://facebook.com/vericult', 'sort_order' => 8],
            ['page' => 'global', 'section' => 'social_twitter', 'type' => 'url', 'label' => 'URL Twitter/X', 'value' => 'https://twitter.com/vericult', 'sort_order' => 9],
            
            // PAGE: SEO
            ['page' => 'seo', 'section' => 'title_beranda', 'type' => 'text', 'label' => 'Meta Title Beranda', 'value' => 'VeriCult - Sistem Verifikasi Kebudayaan Digital', 'sort_order' => 1],
            ['page' => 'seo', 'section' => 'desc_beranda', 'type' => 'textarea', 'label' => 'Meta Desc Beranda', 'value' => 'Platform digital terintegrasi untuk pengajuan, validasi, dan sertifikasi objek kebudayaan Indonesia.', 'sort_order' => 2],
            ['page' => 'seo', 'section' => 'title_tentang', 'type' => 'text', 'label' => 'Meta Title Tentang', 'value' => 'Tentang - VeriCult', 'sort_order' => 3],
            ['page' => 'seo', 'section' => 'title_fitur', 'type' => 'text', 'label' => 'Meta Title Fitur', 'value' => 'Fitur - VeriCult', 'sort_order' => 4],
        ];

        foreach ($contents as $content) {
            \App\Models\SiteContent::updateOrCreate(
                ['page' => $content['page'], 'section' => $content['section']],
                [
                    'type' => $content['type'],
                    'label' => $content['label'],
                    'value' => $content['value'],
                    'sort_order' => $content['sort_order'],
                ]
            );
        }
    }
}
