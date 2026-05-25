<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\CulturalSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuditLogTest extends TestCase
{
    use RefreshDatabase;

    private User $pengusul;
    private User $validator;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create proposer and assign role
        $this->pengusul = User::factory()->create();
        $this->pengusul->assignRole('pengusul');

        // 2. Create the associated profile so that no_hp accessor resolves successfully
        $this->pengusul->pengusulProfile()->create([
            'no_hp' => '081234567890',
            'proposer_type' => 'perorangan',
        ]);

        // 3. Create validator and assign role
        $this->validator = User::factory()->create();
        $this->validator->assignRole('validator');
    }

    /**
     * Test that creating a draft creates a 'submission_created' audit log.
     */
    public function test_creation_of_draft_logs_activity(): void
    {
        $response = $this->actingAs($this->pengusul)
            ->post(route('pengusul.submissions.store'), [
                'name' => 'Tari Tradisional Gayo',
                'category' => CulturalSubmission::CATEGORY_LAPORAN_AKTIF,
                'address' => 'Gayo Lues, Aceh',
                'description' => 'Tari tradisi lisan asal dataran tinggi Gayo.',
                'period_year' => '2026',
                'category_data' => [
                    'kategori_opk' => 'Tradisi Lisan',
                    'nama_dan_jenis_kebudayaan' => 'Tari Tradisional Gayo',
                    'desa_lokasi' => 'Gayo Lues',
                    'detail_lokasi' => 'Balai Desa Gayo',
                    'tanggal_pelaksanaan' => '2026-05-25',
                ],
            ]);

        $response->assertSessionHasNoErrors();
        $submission = CulturalSubmission::first();
        $this->assertNotNull($submission);

        $response->assertRedirect(route('pengusul.submissions.show', $submission));

        // Assert that the 'submission_created' log was written
        $log = AuditLog::where('action', 'submission_created')->first();
        $this->assertNotNull($log);
        $this->assertEquals($this->pengusul->id, $log->user_id);
        $this->assertEquals(CulturalSubmission::class, $log->model_type);
        $this->assertEquals($submission->id, $log->model_id);
        $this->assertEquals('Tari Tradisional Gayo', $log->new_data['name']);
        $this->assertEquals('draf', $log->new_data['status']);
    }

    /**
     * Test that submitting a draft for review creates a 'submission_submitted' audit log.
     */
    public function test_submitting_draft_logs_activity(): void
    {
        // 1. Create a draft submission directly
        $submission = CulturalSubmission::create([
            'user_id' => $this->pengusul->id,
            'name' => 'Alat Musik Tradisional Gayo',
            'category' => CulturalSubmission::CATEGORY_LAPORAN_AKTIF,
            'status' => CulturalSubmission::STATUS_DRAFT,
            'submission_type' => 'aktif',
            'period_year' => 2026,
            'category_data' => [
                'kategori_opk' => 'Teknologi Tradisional',
                'nama_dan_jenis_kebudayaan' => 'Alat Musik Tradisional Gayo',
                'desa_lokasi' => 'Gayo Lues',
                'detail_lokasi' => 'Balai Desa Gayo',
                'tanggal_pelaksanaan' => '2026-05-25',
            ],
        ]);

        // 2. Submit it
        $response = $this->actingAs($this->pengusul)
            ->post(route('pengusul.submissions.submit', $submission));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('pengusul.submissions.show', $submission));

        $submission->refresh();
        $this->assertEquals(CulturalSubmission::STATUS_SUBMITTED, $submission->status);

        // Assert that 'submission_submitted' log was written
        $log = AuditLog::where('action', 'submission_submitted')->first();
        $this->assertNotNull($log);
        $this->assertEquals($this->pengusul->id, $log->user_id);
        $this->assertEquals($submission->id, $log->model_id);
        $this->assertEquals(CulturalSubmission::STATUS_SUBMITTED, $log->new_data['status']);
    }

    /**
     * Test validator claiming and unclaiming a submission logs activities.
     */
    public function test_validator_claiming_and_unclaiming_logs_activities(): void
    {
        // 1. Create a submitted submission
        $submission = CulturalSubmission::create([
            'user_id' => $this->pengusul->id,
            'name' => 'Seni Ukir Gayo',
            'category' => CulturalSubmission::CATEGORY_LAPORAN_AKTIF,
            'status' => CulturalSubmission::STATUS_SUBMITTED,
            'submission_type' => 'aktif',
            'period_year' => 2026,
            'category_data' => [
                'kategori_opk' => 'Seni',
                'nama_dan_jenis_kebudayaan' => 'Seni Ukir Gayo',
                'desa_lokasi' => 'Gayo Lues',
                'detail_lokasi' => 'Balai Desa Gayo',
                'tanggal_pelaksanaan' => '2026-05-25',
            ],
        ]);

        // 2. Validator claims it
        $response = $this->actingAs($this->validator)
            ->post(route('validator.submissions.claim', $submission));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('validator.submissions.review-form', $submission));

        $submission->refresh();
        $this->assertEquals(CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW, $submission->status);
        $this->assertEquals($this->validator->id, $submission->reviewed_by);

        // Assert 'validator_claimed_submission' log exists
        $claimLog = AuditLog::where('action', 'validator_claimed_submission')->first();
        $this->assertNotNull($claimLog);
        $this->assertEquals($this->validator->id, $claimLog->user_id);
        $this->assertEquals($submission->id, $claimLog->model_id);

        // 3. Validator unclaims it
        $response = $this->actingAs($this->validator)
            ->post(route('validator.submissions.unclaim', $submission));

        $response->assertSessionHasNoErrors();
        $submission->refresh();
        $this->assertEquals(CulturalSubmission::STATUS_SUBMITTED, $submission->status);
        $this->assertNull($submission->reviewed_by);

        // Assert 'validator_unclaimed_submission' log exists
        $unclaimLog = AuditLog::where('action', 'validator_unclaimed_submission')->first();
        $this->assertNotNull($unclaimLog);
        $this->assertEquals($this->validator->id, $unclaimLog->user_id);
        $this->assertEquals($submission->id, $unclaimLog->model_id);
    }

    /**
     * Test validator administrative review logs decision correctly.
     */
    public function test_validator_review_decision_logs_activity(): void
    {
        // 1. Create a submission under tinjauan_administratif status
        $submission = CulturalSubmission::create([
            'user_id' => $this->pengusul->id,
            'name' => 'Tradisi Maulid Gayo',
            'category' => CulturalSubmission::CATEGORY_LAPORAN_AKTIF,
            'status' => CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW,
            'reviewed_by' => $this->validator->id,
            'submission_type' => 'aktif',
            'period_year' => 2026,
            'category_data' => [
                'kategori_opk' => 'Adat Istiadat',
                'nama_dan_jenis_kebudayaan' => 'Tradisi Maulid Gayo',
                'desa_lokasi' => 'Gayo Lues',
                'detail_lokasi' => 'Balai Desa Gayo',
                'tanggal_pelaksanaan' => '2026-05-25',
            ],
        ]);

        // 2. Validator reviews and forwards to field verification
        $response = $this->actingAs($this->validator)
            ->post(route('validator.submissions.review', $submission), [
                'action' => 'forwarded',
                'notes' => 'Dokumen administratif lengkap dan terverifikasi. Teruskan ke verifikasi lapangan.',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('validator.submissions.index'));

        $submission->refresh();
        $this->assertEquals(CulturalSubmission::STATUS_FIELD_VERIFICATION, $submission->status);

        // Assert 'validator_administrative_review_forwarded' log exists
        $log = AuditLog::where('action', 'validator_administrative_review_forwarded')->first();
        $this->assertNotNull($log);
        $this->assertEquals($this->validator->id, $log->user_id);
        $this->assertEquals('forwarded', $log->new_data['decision']);
        $this->assertEquals(CulturalSubmission::STATUS_FIELD_VERIFICATION, $log->new_data['new_status']);
    }

    /**
     * Test validator field verification logs decision correctly.
     */
    public function test_validator_field_verification_decision_logs_activity(): void
    {
        // 1. Create a submission in verifikasi_lapangan status
        $submission = CulturalSubmission::create([
            'user_id' => $this->pengusul->id,
            'name' => 'Seni Tari Gayo',
            'category' => CulturalSubmission::CATEGORY_LAPORAN_AKTIF,
            'status' => CulturalSubmission::STATUS_FIELD_VERIFICATION,
            'reviewed_by' => $this->validator->id,
            'submission_type' => 'aktif',
            'period_year' => 2026,
            'category_data' => [
                'kategori_opk' => 'Seni',
                'nama_dan_jenis_kebudayaan' => 'Seni Tari Gayo',
                'desa_lokasi' => 'Gayo Lues',
                'detail_lokasi' => 'Balai Desa Gayo',
                'tanggal_pelaksanaan' => '2026-05-25',
            ],
        ]);

        // 2. Validator performs field verification, recommending 'verified'
        $response = $this->actingAs($this->validator)
            ->post(route('validator.submissions.field-verification', $submission), [
                'visit_date' => '2026-05-25',
                'notes' => 'Kunjungan lapangan selesai. Semua data kebudayaan valid sesuai kondisi rill.',
                'recommendation' => 'verified',
                'description' => 'Deskripsi yang sangat lengkap tentang seni tari khas dataran tinggi Gayo yang indah dan sarat nilai.',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('validator.submissions.index'));

        $submission->refresh();
        $this->assertEquals(CulturalSubmission::STATUS_VERIFIED, $submission->status);

        // Assert 'validator_field_verification_verified' log exists
        $log = AuditLog::where('action', 'validator_field_verification_verified')->first();
        $this->assertNotNull($log);
        $this->assertEquals($this->validator->id, $log->user_id);
        $this->assertEquals('verified', $log->new_data['recommendation']);
        $this->assertEquals(CulturalSubmission::STATUS_VERIFIED, $log->new_data['new_status']);
    }

    /**
     * Test validator publishing and unpublishing logs activities.
     */
    public function test_validator_publishing_and_unpublishing_logs_activities(): void
    {
        // 1. Create a verified submission
        $submission = CulturalSubmission::create([
            'user_id' => $this->pengusul->id,
            'name' => 'Ritus Adat Gayo',
            'category' => CulturalSubmission::CATEGORY_LAPORAN_AKTIF,
            'status' => CulturalSubmission::STATUS_VERIFIED,
            'submission_type' => 'aktif',
            'period_year' => 2026,
            'category_data' => [
                'kategori_opk' => 'Ritus',
                'nama_dan_jenis_kebudayaan' => 'Ritus Adat Gayo',
                'desa_lokasi' => 'Gayo Lues',
                'detail_lokasi' => 'Balai Desa Gayo',
                'tanggal_pelaksanaan' => '2026-05-25',
            ],
        ]);

        // 2. Validator publishes it
        $response = $this->actingAs($this->validator)
            ->post(route('validator.submissions.publish', $submission));

        $response->assertSessionHasNoErrors();
        $submission->refresh();
        $this->assertEquals(CulturalSubmission::STATUS_PUBLISHED, $submission->status);

        // Assert 'validator_published_submission' log exists
        $publishLog = AuditLog::where('action', 'validator_published_submission')->first();
        $this->assertNotNull($publishLog);
        $this->assertEquals($this->validator->id, $publishLog->user_id);

        // 3. Validator unpublishes it
        $response = $this->actingAs($this->validator)
            ->post(route('validator.submissions.unpublish', $submission));

        $response->assertSessionHasNoErrors();
        $submission->refresh();
        $this->assertEquals(CulturalSubmission::STATUS_VERIFIED, $submission->status);

        // Assert 'validator_unpublished_submission' log exists
        $unpublishLog = AuditLog::where('action', 'validator_unpublished_submission')->first();
        $this->assertNotNull($unpublishLog);
        $this->assertEquals($this->validator->id, $unpublishLog->user_id);
    }
}
