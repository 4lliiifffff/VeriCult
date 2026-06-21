<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kecamatan;
use App\Models\Village;
use App\Models\CulturalSubmission;
use App\Models\SubmissionFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SubmissionWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private User $pengusul;
    private User $pengusulDesa;
    private User $validator;
    private User $superAdmin;
    private Kecamatan $kecamatan;
    private Village $village;

    protected function setUp(): void
    {
        parent::setUp();

        $this->kecamatan = Kecamatan::create(['name' => 'Kecamatan Test']);
        $this->village = Village::create(['name' => 'Desa Test', 'kecamatan_id' => $this->kecamatan->id]);

        // Proposer (pengusul) with verified phone
        $this->pengusul = User::factory()->create();
        $this->pengusul->assignRole('pengusul');
        $this->pengusul->pengusulProfile()->create([
            'no_hp' => '081234567890',
            'proposer_type' => 'perorangan',
        ]);

        // Village Proposer (pengusul-desa) with verified phone & approved by admin
        $this->pengusulDesa = User::factory()->create();
        $this->pengusulDesa->assignRole('pengusul-desa');
        $this->pengusulDesa->pengusulDesaProfile()->create([
            'village_id' => $this->village->id,
            'is_approved_by_admin' => true,
            'no_hp' => '089876543210',
            'jabatan_desa' => 'Kasi Pelayanan',
        ]);

        // Validator
        $this->validator = User::factory()->create();
        $this->validator->assignRole('validator');
        $this->validator->validatorProfile()->create();

        // Super Admin
        $this->superAdmin = User::factory()->create();
        $this->superAdmin->assignRole('super-admin');
        $this->superAdmin->superAdminProfile()->create();

        // Refresh all user instances to ensure role relationships are fully synchronized in memory
        $this->pengusul->refresh();
        $this->pengusulDesa->refresh();
        $this->validator->refresh();
        $this->superAdmin->refresh();
    }

    public function test_proposer_can_create_and_submit_active_culture_submission(): void
    {
        Storage::fake('public');

        // Create draft
        $response = $this->actingAs($this->pengusul)
            ->post(route('pengusul.submissions.store'), [
                'name' => 'Tari Piring Rakyat',
                'category' => CulturalSubmission::CATEGORY_LAPORAN_AKTIF,
                'address' => 'Balai Desa',
                'description' => 'Tari piring tradisional.',
                'period_year' => '2026',
                'category_data' => [
                    'kategori_opk' => 'Seni',
                    'nama_dan_jenis_kebudayaan' => 'Tari Piring Rakyat',
                    'desa_lokasi' => 'Desa Test',
                    'detail_lokasi' => 'Balai Desa',
                    'tanggal_pelaksanaan' => '2026-06-01',
                    'estimasi_penonton' => '50 – 100 orang', // Required field
                ],
                'files' => [
                    UploadedFile::fake()->create('document.pdf', 100, 'application/pdf'),
                ],
            ]);

        $submission = CulturalSubmission::where('name', 'Tari Piring Rakyat')->first();
        $this->assertNotNull($submission);
        $response->assertRedirect(route('pengusul.submissions.show', $submission));

        $this->assertEquals(CulturalSubmission::STATUS_DRAFT, $submission->status);
        $this->assertCount(1, $submission->files);

        // Submit draft
        $responseSubmit = $this->actingAs($this->pengusul)
            ->post(route('pengusul.submissions.submit', $submission));

        $responseSubmit->assertRedirect(route('pengusul.submissions.show', $submission));
        $submission->refresh();
        $this->assertEquals(CulturalSubmission::STATUS_SUBMITTED, $submission->status);
    }

    public function test_proposer_can_create_opk_submission(): void
    {
        // Proposer is allowed by the controller middleware to create OPK submissions
        $response = $this->actingAs($this->pengusul)
            ->post(route('pengusul.opk-submissions.store'), [
                'name' => 'Keris Pusaka',
                'category' => CulturalSubmission::CATEGORY_MANUSKRIP,
                'address' => 'Museum',
                'description' => 'Keris kuno.',
                'period_year' => '2026',
                'category_data' => [
                    'nama_objek' => 'Keris Pusaka',
                    'judul' => 'Keris Majapahit',
                    'bahan' => 'Kayu',
                ],
            ]);

        $response->assertRedirect();
        
        $submission = CulturalSubmission::where('name', 'Keris Pusaka')->first();
        $this->assertNotNull($submission);
    }

    public function test_village_proposer_can_create_opk_and_cagar_budaya_and_potensi_submissions(): void
    {
        Storage::fake('public');

        // 1. OPK Submission
        $responseOPK = $this->actingAs($this->pengusulDesa)
            ->post(route('pengusul-desa.opk-submissions.store'), [
                'name' => 'Bahasa Gayo Lues',
                'category' => CulturalSubmission::CATEGORY_BAHASA,
                'address' => 'Gayo Lues',
                'description' => 'Bahasa daerah Gayo.',
                'period_year' => '2026',
                'category_data' => [
                    'nama_objek' => 'Bahasa Gayo Lues',
                    'jenis_aksara' => 'Latin',
                    'etnis' => 'Gayo',
                ],
            ]);

        $submissionOPK = CulturalSubmission::where('name', 'Bahasa Gayo Lues')->first();
        $this->assertNotNull($submissionOPK);
        $this->assertEquals('opk', $submissionOPK->submission_type);

        // 2. Cagar Budaya Submission
        $responseCagar = $this->actingAs($this->pengusulDesa)
            ->post(route('pengusul-desa.cagar-budaya-submissions.store'), [
                'name' => 'Situs Candi Indah',
                'category' => CulturalSubmission::CATEGORY_CAGAR_BUDAYA,
                'address' => 'Desa Test',
                'description' => 'Situs candi kuno.',
                'period_year' => '2026',
                'category_data' => [
                    'jenis_cagar_budaya' => 'situs', // Required selector
                    'nama_objek' => 'Situs Candi Indah',
                ],
                'files' => [
                    UploadedFile::fake()->create('cagar.pdf', 100, 'application/pdf'), // Required files
                ],
            ]);

        $submissionCagar = CulturalSubmission::where('name', 'Situs Candi Indah')->first();
        $this->assertNotNull($submissionCagar);
        $this->assertEquals('cagar-budaya', $submissionCagar->submission_type);

        // 3. Potensi Kebudayaan Submission
        $responsePotensi = $this->actingAs($this->pengusulDesa)
            ->post(route('pengusul-desa.potensi-submissions.store'), [
                'name' => 'Sanggar Seni Desa',
                'category' => CulturalSubmission::CATEGORY_POTENSI_KEBUDAYAAN,
                'address' => 'Desa Test',
                'description' => 'Potensi sanggar seni.',
                'period_year' => '2026',
                'category_data' => [
                    'sub_kategori_potensi_kebudayaan' => 'lembaga_kebudayaan', // Required selector
                    'nama_objek' => 'Sanggar Seni Desa',
                ],
            ]);

        $submissionPotensi = CulturalSubmission::where('name', 'Sanggar Seni Desa')->first();
        $this->assertNotNull($submissionPotensi);
        $this->assertEquals('potensi-kebudayaan', $submissionPotensi->submission_type);
    }

    public function test_village_proposer_can_delete_draft_submission(): void
    {
        $submission = CulturalSubmission::create([
            'user_id' => $this->pengusulDesa->id,
            'village_id' => $this->village->id,
            'name' => 'Draft Budaya',
            'category' => CulturalSubmission::CATEGORY_BAHASA,
            'status' => CulturalSubmission::STATUS_DRAFT,
            'submission_type' => 'opk',
            'period_year' => 2026,
            'category_data' => [
                'nama_objek' => 'Draft Budaya',
            ],
        ]);

        $response = $this->actingAs($this->pengusulDesa)
            ->delete(route('pengusul-desa.opk-submissions.destroy', $submission));

        $response->assertRedirect();
        $this->assertDatabaseMissing('cultural_submissions', ['id' => $submission->id]);
    }

    public function test_validator_cannot_publish_private_potensi_kebudayaan(): void
    {
        // private sub-category: lembaga_kebudayaan (from PRIVATE_POTENSI_SUB_CATEGORIES)
        $submission = CulturalSubmission::create([
            'user_id' => $this->pengusulDesa->id,
            'village_id' => $this->village->id,
            'name' => 'Lembaga Tari Swara',
            'category' => CulturalSubmission::CATEGORY_POTENSI_KEBUDAYAAN,
            'status' => CulturalSubmission::STATUS_VERIFIED, // Verified status, ready for publishing normally
            'submission_type' => 'potensi-kebudayaan',
            'period_year' => 2026,
            'category_data' => [
                'sub_kategori_potensi_kebudayaan' => 'lembaga_kebudayaan', // Correct selector key
                'nama_objek' => 'Lembaga Tari Swara',
            ],
        ]);

        // Attempting to publish
        $response = $this->actingAs($this->validator)
            ->post(route('validator.submissions.publish', $submission));

        // Should return 403 Forbidden because it is private
        $response->assertStatus(403);
    }

    public function test_reports_pages_render_and_print_properly(): void
    {
        // Create a published submission to populate the report list
        CulturalSubmission::create([
            'user_id' => $this->pengusulDesa->id,
            'village_id' => $this->village->id,
            'name' => 'Adat Perkawinan Gayo',
            'category' => CulturalSubmission::CATEGORY_ADAT_ISTIADAT,
            'status' => CulturalSubmission::STATUS_PUBLISHED,
            'submission_type' => 'opk',
            'period_year' => 2026,
            'category_data' => [
                'nama_objek' => 'Adat Perkawinan Gayo',
            ],
        ]);

        // Validator accesses reports index
        $response = $this->actingAs($this->validator)
            ->get(route('reports.index'));
        $response->assertStatus(200);
        $response->assertSee('Adat Perkawinan Gayo');

        // Validator accesses reports print summary
        $responsePrint = $this->actingAs($this->validator)
            ->get(route('reports.print', ['category' => CulturalSubmission::CATEGORY_ADAT_ISTIADAT]));
        $responsePrint->assertStatus(200);
        $responsePrint->assertSee('Adat Perkawinan Gayo');

        // Validator accesses comprehensive report print
        $responseComprehensive = $this->actingAs($this->validator)
            ->get(route('reports.print-comprehensive', ['year' => '2026']));
        $responseComprehensive->assertStatus(200);
        // The comprehensive view shows category, kecamatan, and desa statistics tables/charts, not submission names.
        $responseComprehensive->assertSee('Adat Istiadat');
        $responseComprehensive->assertSee('Kecamatan Test');
        $responseComprehensive->assertSee('Desa Test');
    }
}
