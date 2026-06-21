<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kecamatan;
use App\Models\Village;
use App\Models\SiteContent;
use App\Models\AuditLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UserWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;
    private User $admin;
    private User $validator;
    private User $pengusulDesa;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Super Admin
        $this->superAdmin = User::factory()->create();
        $this->superAdmin->assignRole('super-admin');
        $this->superAdmin->superAdminProfile()->create();
        $this->superAdmin->refresh();

        // Create Admin
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
        $this->admin->adminProfile()->create();
        $this->admin->refresh();

        // Create Validator
        $this->validator = User::factory()->create();
        $this->validator->assignRole('validator');
        $this->validator->validatorProfile()->create();
        $this->validator->refresh();

        // Create a Village Proposer (not approved yet by default)
        $this->pengusulDesa = User::factory()->create();
        $this->pengusulDesa->assignRole('pengusul-desa');
        $this->pengusulDesa->pengusulDesaProfile()->create([
            'is_approved_by_admin' => false,
            'no_hp' => '081234567890',
        ]);
        $this->pengusulDesa->refresh();
    }

    public function test_unapproved_village_proposer_cannot_access_dashboard_directly(): void
    {
        // Direct access to pengusul-desa dashboard should be blocked with 403 by RoleMiddleware
        $response = $this->actingAs($this->pengusulDesa)
            ->get(route('pengusul-desa.dashboard'));

        $response->assertStatus(403);

        // General dashboard route redirects them to pending approval page
        $response2 = $this->actingAs($this->pengusulDesa)
            ->get(route('dashboard'));

        $response2->assertRedirect(route('pending-approval'));

        // Can access the pending approval page
        $response3 = $this->actingAs($this->pengusulDesa)
            ->get(route('pending-approval'));
        $response3->assertOk();
    }

    public function test_approved_village_proposer_can_access_dashboard(): void
    {
        // Approve user
        $this->pengusulDesa->pengusulDesaProfile->update([
            'is_approved_by_admin' => true,
            'approved_by_admin_at' => now(),
        ]);
        $this->pengusulDesa->refresh();

        $response = $this->actingAs($this->pengusulDesa)
            ->get(route('pengusul-desa.dashboard'));

        $response->assertOk();
    }

    public function test_super_admin_can_approve_village_proposer(): void
    {
        Mail::fake();

        $response = $this->actingAs($this->superAdmin)
            ->post(route('super-admin.pengusul-desa.approve', $this->pengusulDesa));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->pengusulDesa->refresh();
        $this->assertTrue($this->pengusulDesa->is_approved_by_admin);
        $this->assertNotNull($this->pengusulDesa->email_verified_at);

        // Audit Log check
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $this->superAdmin->id,
            'action' => 'approved_pengusul_desa',
            'model_id' => $this->pengusulDesa->id,
        ]);
    }

    public function test_super_admin_can_reject_village_proposer(): void
    {
        Mail::fake();

        $response = $this->actingAs($this->superAdmin)
            ->post(route('super-admin.pengusul-desa.reject', $this->pengusulDesa), [
                'rejection_reason' => 'Surat pengantar palsu.',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->pengusulDesa->refresh();
        // Rejected pengusul-desa by super admin is suspended
        $this->assertTrue($this->pengusulDesa->is_suspended);

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $this->superAdmin->id,
            'action' => 'rejected_pengusul_desa',
        ]);
    }

    public function test_admin_can_approve_village_proposer(): void
    {
        Mail::fake();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.user-approvals.approve', $this->pengusulDesa));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->pengusulDesa->refresh();
        $this->assertTrue($this->pengusulDesa->is_approved_by_admin);
    }

    public function test_admin_can_reject_and_delete_village_proposer(): void
    {
        Mail::fake();

        $userId = $this->pengusulDesa->id;

        $response = $this->actingAs($this->admin)
            ->post(route('admin.user-approvals.reject', $this->pengusulDesa), [
                'rejection_reason' => 'Dokumen tidak valid.',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        // Admin rejection deletes the user record entirely
        $this->assertDatabaseMissing('users', [
            'id' => $userId,
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $this->admin->id,
            'action' => 'rejected_and_deleted_pengusul_desa',
        ]);
    }

    public function test_admin_can_suspend_and_unsuspend_user(): void
    {
        $targetUser = User::factory()->create();
        $targetUser->assignRole('pengusul');
        $targetUser->pengusulProfile()->create(['no_hp' => '081234567890']);
        $targetUser->refresh();

        // Suspend
        $response = $this->actingAs($this->admin)
            ->post(route('admin.users.suspend', $targetUser));

        $response->assertRedirect();
        $targetUser->refresh();
        $this->assertTrue($targetUser->is_suspended);

        // Unsuspend
        $response2 = $this->actingAs($this->admin)
            ->post(route('admin.users.unsuspend', $targetUser));

        $response2->assertRedirect();
        $targetUser->refresh();
        $this->assertFalse($targetUser->is_suspended);
    }

    public function test_admin_can_verify_user_email_manually(): void
    {
        $targetUser = User::factory()->unverified()->create();
        $targetUser->refresh();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.users.verify-email', $targetUser));

        $response->assertRedirect();
        $targetUser->refresh();
        $this->assertNotNull($targetUser->email_verified_at);
    }

    public function test_admin_wilayah_crud_actions(): void
    {
        // 1. Create Kecamatan
        $response = $this->actingAs($this->admin)
            ->post(route('admin.kecamatans.store'), [
                'name' => 'Kecamatan Baru',
            ]);

        $response->assertRedirect();
        $kecamatan = Kecamatan::where('name', 'Kecamatan Baru')->first();
        $this->assertNotNull($kecamatan);

        // 2. Create Village
        $response2 = $this->actingAs($this->admin)
            ->post(route('admin.villages.store'), [
                'name' => 'Desa Baru',
                'kecamatan_id' => $kecamatan->id,
            ]);

        $response2->assertRedirect();
        $village = Village::where('name', 'Desa Baru')->first();
        $this->assertNotNull($village);

        // 3. Update Village
        $response3 = $this->actingAs($this->admin)
            ->put(route('admin.villages.update', $village), [
                'name' => 'Desa Terupdate',
                'kecamatan_name' => 'Kecamatan Baru', // VillageController expects kecamatan_name
            ]);

        $response3->assertRedirect();
        $village->refresh();
        $this->assertEquals('Desa Terupdate', $village->name);

        // 4. Delete Village
        $response4 = $this->actingAs($this->admin)
            ->delete(route('admin.villages.destroy', $village));

        $response4->assertRedirect();
        $this->assertDatabaseMissing('villages', ['id' => $village->id]);
    }

    public function test_super_admin_can_update_site_content(): void
    {
        // Create initial content
        SiteContent::create([
            'page' => 'beranda',
            'section' => 'hero_title',
            'type' => 'text',
            'value' => 'VeriCult Awal',
            'label' => 'Hero Title',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($this->superAdmin)
            ->put(route('super-admin.site-content.update', 'beranda'), [
                'hero_title' => 'VeriCult Terupdate',
            ]);

        $response->assertRedirect();
        $this->assertEquals('VeriCult Terupdate', SiteContent::getValue('beranda', 'hero_title'));
    }
}
