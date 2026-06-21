<?php

namespace Tests\Feature;

use App\Models\Kecamatan;
use App\Models\Village;
use App\Models\User;
use App\Models\CulturalSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Kecamatan $kecamatan;
    private Village $village;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->kecamatan = Kecamatan::create(['name' => 'Kecamatan Test']);
        $this->village = Village::create(['name' => 'Desa Test', 'kecamatan_id' => $this->kecamatan->id]);
    }

    public function test_landing_page_renders_successfully(): void
    {
        $response = $this->get(route('beranda'));
        $response->assertStatus(200);
    }

    public function test_offline_page_renders_successfully(): void
    {
        $response = $this->get(route('offline'));
        $response->assertStatus(200);
    }

    public function test_tentang_page_renders_successfully(): void
    {
        $response = $this->get(route('tentang'));
        $response->assertStatus(200);
    }

    public function test_fitur_page_renders_successfully(): void
    {
        $response = $this->get(route('fitur'));
        $response->assertStatus(200);
    }

    public function test_edukasi_page_renders_successfully(): void
    {
        $response = $this->get(route('edukasi'));
        $response->assertStatus(200);
    }

    public function test_public_cultural_profile_index(): void
    {
        $submission = CulturalSubmission::create([
            'user_id' => $this->user->id,
            'village_id' => $this->village->id,
            'name' => 'Tari Piring Adat',
            'category' => CulturalSubmission::CATEGORY_TRADISI_LISAN,
            'status' => CulturalSubmission::STATUS_PUBLISHED,
            'submission_type' => 'opk',
            'period_year' => 2026,
            'category_data' => [
                'nama_dan_jenis_kebudayaan' => 'Tari Piring Adat',
                'desa_lokasi' => 'Desa Test',
                'detail_lokasi' => 'Balai Desa',
            ],
        ]);

        $response = $this->get(route('profil-kebudayaan.index'));
        $response->assertStatus(200);
        $response->assertSee('Tari Piring Adat');
    }

    public function test_public_cultural_profile_show(): void
    {
        $submission = CulturalSubmission::create([
            'user_id' => $this->user->id,
            'village_id' => $this->village->id,
            'name' => 'Naskah Kuno Gayo',
            'category' => CulturalSubmission::CATEGORY_MANUSKRIP,
            'status' => CulturalSubmission::STATUS_PUBLISHED,
            'submission_type' => 'opk',
            'period_year' => 2026,
            'category_data' => [
                'nama_dan_jenis_kebudayaan' => 'Naskah Kuno Gayo',
                'desa_lokasi' => 'Desa Test',
                'detail_lokasi' => 'Balai Desa',
            ],
        ]);

        $response = $this->get(route('profil-kebudayaan.show', $submission->slug));
        $response->assertStatus(200);
        $response->assertSee('Naskah Kuno Gayo');
    }

    public function test_public_active_culture_index(): void
    {
        $submission = CulturalSubmission::create([
            'user_id' => $this->user->id,
            'village_id' => $this->village->id,
            'name' => 'Festival Budaya Gayo',
            'category' => CulturalSubmission::CATEGORY_LAPORAN_AKTIF,
            'status' => CulturalSubmission::STATUS_PUBLISHED,
            'submission_type' => 'aktif',
            'period_year' => 2026,
            'category_data' => [
                'kategori_opk' => 'Seni',
                'nama_dan_jenis_kebudayaan' => 'Festival Budaya Gayo',
                'desa_lokasi' => 'Desa Test',
                'detail_lokasi' => 'Lapangan Desa',
                'tanggal_pelaksanaan' => '2026-06-01',
            ],
        ]);

        $response = $this->get(route('kebudayaan-aktif.index'));
        $response->assertStatus(200);
        $response->assertSee('Festival Budaya Gayo');
    }

    public function test_public_active_culture_show(): void
    {
        $submission = CulturalSubmission::create([
            'user_id' => $this->user->id,
            'village_id' => $this->village->id,
            'name' => 'Upacara Adat Melayu',
            'category' => CulturalSubmission::CATEGORY_LAPORAN_AKTIF,
            'status' => CulturalSubmission::STATUS_PUBLISHED,
            'submission_type' => 'aktif',
            'period_year' => 2026,
            'category_data' => [
                'kategori_opk' => 'Ritus',
                'nama_dan_jenis_kebudayaan' => 'Upacara Adat Melayu',
                'desa_lokasi' => 'Desa Test',
                'detail_lokasi' => 'Balai Desa',
                'tanggal_pelaksanaan' => '2026-06-01',
            ],
        ]);

        $response = $this->get(route('kebudayaan-aktif.show', $submission->slug));
        $response->assertStatus(200);
        $response->assertSee('Upacara Adat Melayu');
    }

    public function test_public_reports_print(): void
    {
        $submission = CulturalSubmission::create([
            'user_id' => $this->user->id,
            'village_id' => $this->village->id,
            'name' => 'Candi Test',
            'category' => CulturalSubmission::CATEGORY_CAGAR_BUDAYA,
            'status' => CulturalSubmission::STATUS_PUBLISHED,
            'submission_type' => 'cagar-budaya',
            'period_year' => 2026,
            'category_data' => [
                'nama_dan_jenis_kebudayaan' => 'Candi Test',
                'desa_lokasi' => 'Desa Test',
                'detail_lokasi' => 'Balai Desa',
            ],
        ]);

        $response = $this->get(route('public.reports.print', ['year' => 2026]));
        $response->assertStatus(200);
        $response->assertSee('Candi Test');
    }
}
