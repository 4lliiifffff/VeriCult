<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\PhoneVerification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\PhoneVerificationMail;
use Tests\TestCase;

class PhoneVerificationTest extends TestCase
{
    use RefreshDatabase;

    private User $pengusul;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pengusul = User::factory()->create();
        $this->pengusul->assignRole('pengusul');
    }

    public function test_proposer_can_request_otp(): void
    {
        Mail::fake();

        $response = $this->actingAs($this->pengusul)
            ->postJson(route('phone.verification.send'), [
                'phone_number' => '081234567890',
            ]);

        $response->assertOk();
        $response->assertJsonPath('message', 'Kode verifikasi telah dikirim ke Email Anda.');

        $this->assertDatabaseHas('phone_verifications', [
            'user_id' => $this->pengusul->id,
            'phone_number' => '081234567890',
        ]);

        Mail::assertSent(PhoneVerificationMail::class);
    }

    public function test_proposer_can_verify_otp(): void
    {
        // Setup existing verification record
        $verification = PhoneVerification::create([
            'user_id' => $this->pengusul->id,
            'phone_number' => '089876543210',
            'token' => '123456',
            'expires_at' => now()->addMinutes(5),
        ]);

        $response = $this->actingAs($this->pengusul)
            ->postJson(route('phone.verification.verify'), [
                'token' => '123456',
            ]);

        $response->assertOk();
        $response->assertJsonPath('message', 'Nomor telepon berhasil diverifikasi dan disimpan.');

        $this->assertDatabaseMissing('phone_verifications', [
            'id' => $verification->id,
        ]);

        // Proposer profile should be updated with new phone number
        $this->pengusul->refresh();
        $this->assertEquals('089876543210', $this->pengusul->no_hp);
    }

    public function test_proposer_cannot_verify_wrong_otp(): void
    {
        PhoneVerification::create([
            'user_id' => $this->pengusul->id,
            'phone_number' => '089876543210',
            'token' => '123456',
            'expires_at' => now()->addMinutes(5),
        ]);

        $response = $this->actingAs($this->pengusul)
            ->postJson(route('phone.verification.verify'), [
                'token' => '654321', // Wrong token
            ]);

        $response->assertStatus(400);
        $response->assertJsonPath('message', 'Kode verifikasi salah.');
    }

    public function test_require_phone_middleware_redirects_when_phone_is_missing(): void
    {
        // Clear phone number profile (already empty by default for fresh user)
        $response = $this->actingAs($this->pengusul)
            ->get(route('pengusul.submissions.index'));

        // Proposer without phone should be redirected to dashboard with force verification trigger
        $response->assertRedirect(route('pengusul.dashboard'));
        $response->assertSessionHas('force_phone_verification', true);
    }

    public function test_require_phone_middleware_allows_access_when_phone_exists(): void
    {
        // Add phone number to profile
        $this->pengusul->pengusulProfile()->create([
            'no_hp' => '081234567890',
            'proposer_type' => 'perorangan',
        ]);

        $response = $this->actingAs($this->pengusul)
            ->get(route('pengusul.submissions.index'));

        // Proposer with phone should be allowed to view
        $response->assertOk();
    }
}
