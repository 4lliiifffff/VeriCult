<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Services\GovernanceService;

class UserController extends Controller
{
    protected $governanceService;

    public function __construct(GovernanceService $governanceService)
    {
        $this->governanceService = $governanceService;
    }

    public function index(Request $request)
    {
        $query = User::with(['roles', 'superAdminProfile', 'adminProfile', 'validatorProfile', 'pengusulProfile', 'pengusulDesaProfile']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('role') && $request->role != '') {
            $query->role($request->role);
        }

        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'suspended') {
                $query->where('is_suspended', true);
            } elseif ($request->status == 'active') {
                $query->where('is_suspended', false)
                      ->where(function($q) {
                          $q->whereNotNull('email_verified_at')
                            ->where(function($q2) {
                                $q2->whereDoesntHave('roles', fn($r) => $r->where('name', 'pengusul-desa'))
                                   ->orWhereHas('pengusulDesaProfile', fn($p) => $p->where('is_approved_by_admin', true));
                            });
                      });
            } elseif ($request->status == 'pending') {
                $query->role('pengusul-desa')
                      ->whereHas('pengusulDesaProfile', fn($q) => $q->where('is_approved_by_admin', false));
            }
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        $roles = Role::all();

        if ($request->ajax()) {
            return view('super-admin.users._table', compact('users', 'roles'))->render();
        }

        return view('super-admin.users.index', compact('users', 'roles'));
    }

    public function suspend(User $user)
    {
        try {
            $this->governanceService->suspendUser($user, auth()->user());
            return back()->with('success', 'User berhasil diblokir.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function unsuspend(User $user)
    {
        try {
            $this->governanceService->unsuspendUser($user, auth()->user());
            return back()->with('success', 'User berhasil diaktifkan.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function verifyEmail(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'Email pengguna sudah terverifikasi.');
        }

        try {
            $user->email_verified_at = now();
            $user->save();

            \App\Models\AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'verified_email',
                'model_type' => get_class($user),
                'model_id' => $user->id,
                'new_data' => ['email' => $user->email, 'verified_at' => $user->email_verified_at],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return back()->with('success', 'Email user berhasil diverifikasi.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memverifikasi email: ' . $e->getMessage());
        }
    }

    public function createAdmin()
    {
        return view('super-admin.users.create-admin');
    }

    public function storeAdmin(\App\Http\Requests\StoreValidatorRequest $request)
    {
        try {
            // Generate a secure password if not provided
            $password = $request->password ?? \Illuminate\Support\Str::password(12);

            $user = User::create([
                'name'              => $request->name,
                'email'             => $request->email,
                'password'          => \Illuminate\Support\Facades\Hash::make($password),
                'email_verified_at' => $request->has('email_verified') ? now() : null,
            ]);

            $user->assignRole('admin');

            // Create specialized profile
            $user->adminProfile()->create([]);

            // Log action
            \App\Models\AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'created_admin',
                'model_type' => get_class($user),
                'model_id' => $user->id,
                'new_data' => ['email' => $user->email, 'role' => 'admin'],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Create a clear success message with the password
            $message = 'Admin berhasil dibuat.';
            $message .= ' <strong>Password: ' . $password . '</strong>';
            $message .= ' (Silahkan simpan password ini)';

            return redirect()->route('super-admin.users.index')->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat admin: ' . $e->getMessage())->withInput();
        }
    }

    public function createValidator()
    {
        return view('super-admin.users.create-validator');
    }

    public function storeValidator(\App\Http\Requests\StoreValidatorRequest $request)
    {
        try {
            // Generate a secure password if not provided
            $password = $request->password ?? \Illuminate\Support\Str::password(12);

            $user = User::create([
                'name'              => $request->name,
                'email'             => $request->email,
                'password'          => \Illuminate\Support\Facades\Hash::make($password),
                'email_verified_at' => $request->has('email_verified') ? now() : null,
            ]);

            $user->assignRole('validator');

            // Create specialized profile
            $user->validatorProfile()->create([]);

            // Log action
            \App\Models\AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'created_validator',
                'model_type' => get_class($user),
                'model_id' => $user->id,
                'new_data' => ['email' => $user->email, 'role' => 'validator'],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Create a clear success message with the password
            $message = 'Validator berhasil dibuat.';
            $message .= ' <strong>Password: ' . $password . '</strong>';
            $message .= ' (Silahkan simpan password ini)';

            return redirect()->route('super-admin.users.index')->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat validator: ' . $e->getMessage())->withInput();
        }
    }

    // ...

    public function show(User $user)
    {
        $user->load(['roles', 'pengusulDesaProfile.village', 'superAdminProfile', 'adminProfile', 'validatorProfile', 'pengusulProfile']);
        return view('super-admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        // Protect Master Admin from being edited
        if ($user->id === 1 && $user->id !== auth()->id()) {
            return redirect()->route('super-admin.users.index')->with('error', 'Akun Super Admin tidak dapat diubah oleh orang lain.');
        }

        $roles = Role::all();
        $villages = class_exists(\App\Models\Village::class) ? \App\Models\Village::all() : [];
        return view('super-admin.users.edit', compact('user', 'roles', 'villages'));
    }

    public function update(Request $request, User $user)
    {
        // Protect Master Admin from modifications
        if ($user->id === 1 && $user->id !== auth()->id()) {
             // Allow Master Admin to update their own profile, but maybe restrict role changes?
             // Actually, usually Master Admin updates via Profile Controller, not User Management.
             // But if another admin tries to edit ID 1, block it.
             return back()->with('error', 'Akun Super Admin tidak dapat diubah oleh orang lain.');
        }

        // If it is ID 1 updating themselves here (rare), ensure they don't lose super-admin role.
        if ($user->id === 1 && $request->role !== 'super-admin') {
             return back()->with('error', 'Akun Super Admin tidak dapat mengubah role mereka sendiri.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'exists:roles,name'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            $user->load(['roles', 'superAdminProfile', 'adminProfile', 'validatorProfile', 'pengusulProfile', 'pengusulDesaProfile']);
            $oldData = $user->toArray();

            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            }

            $user->save();

            // Sync roles - ensure we pass an array of strings
            $user->syncRoles([$request->role]);
            
            $newRole = $request->role;

            // Delete old profiles so the user truly 'moves' to the new role
            if ($newRole !== 'super-admin') $user->superAdminProfile()->delete();
            if ($newRole !== 'admin') $user->adminProfile()->delete();
            if ($newRole !== 'validator') $user->validatorProfile()->delete();
            if ($newRole !== 'pengusul') $user->pengusulProfile()->delete();
            if ($newRole !== 'pengusul-desa') $user->pengusulDesaProfile()->delete();

            // Ensure the specific profile exists for the new role to prevent relationship errors
            if ($newRole === 'super-admin') {
                $user->superAdminProfile()->firstOrCreate([]);
            } elseif ($newRole === 'admin') {
                $user->adminProfile()->firstOrCreate([]);
            } elseif ($newRole === 'validator') {
                $profile = $user->validatorProfile()->firstOrCreate([]);
                $profile->update([
                    'instansi' => $request->has('instansi') ? $request->instansi : $profile->instansi,
                    'no_hp' => $request->has('no_hp') ? $request->no_hp : $profile->no_hp,
                ]);
            } elseif ($newRole === 'pengusul') {
                $profile = $user->pengusulProfile()->firstOrCreate([]);
                $profile->update([
                    'instansi' => $request->has('instansi') ? $request->instansi : $profile->instansi,
                    'no_hp' => $request->has('no_hp') ? $request->no_hp : $profile->no_hp,
                ]);
            } elseif ($newRole === 'pengusul-desa') {
                $profile = $user->pengusulDesaProfile()->firstOrCreate([], [
                    'is_approved_by_admin' => false // default for new pengusul-desa via edit
                ]);
                $profile->update([
                    'village_id' => $request->has('village_id') ? $request->village_id : $profile->village_id,
                    'jabatan_desa' => $request->has('jabatan_desa') ? $request->jabatan_desa : $profile->jabatan_desa,
                    'nip' => $request->has('nip') ? $request->nip : $profile->nip,
                    'no_hp' => $request->has('no_hp') ? $request->no_hp : $profile->no_hp,
                ]);
            }

            // Explicitly forget cached permissions to ensure immediate effect
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

            $user->refresh();
            $user->load(['roles', 'superAdminProfile', 'adminProfile', 'validatorProfile', 'pengusulProfile', 'pengusulDesaProfile']);
            $newData = $user->toArray();

            \App\Models\AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'updated_user',
                'model_type' => get_class($user),
                'model_id' => $user->id,
                'old_data' => $oldData,
                'new_data' => $newData,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return redirect()->route('super-admin.users.index')->with('success', 'Data user berhasil diubah.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengubah data user: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        // Protect Master Admin (ID 1)
        if ($user->id === 1) {
            return back()->with('error', 'Super Admin tidak dapat dihapus.');
        }

        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Removed generic Super Admin restriction to allow managing other admins

        try {
            $user->delete();

            \App\Models\AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted_user',
                'model_type' => get_class($user),
                'model_id' => $user->id,
                'new_data' => [], // Deleted
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return redirect()->route('super-admin.users.index')->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }

    /**
     * Show pending pengusul-desa approvals
     */
    public function pendingPenguslDesaApprovals(Request $request)
    {
        $query = User::role('pengusul-desa')
            ->with('pengusulDesaProfile')
            ->whereHas('pengusulDesaProfile', fn($q) => $q->where('is_approved_by_admin', false));

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $pendingUsers = $query->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            return view('super-admin.users._pending_table', compact('pendingUsers'))->render();
        }

        return view('super-admin.users.pending-pengusul-desa', compact('pendingUsers'));
    }

    /**
     * Approve a pengusul-desa user
     */
    public function approvePenguslDesa(User $user)
    {
        if (!$user->hasRole('pengusul-desa')) {
            return back()->with('error', 'User ini bukan pengusul desa.');
        }

        if ($user->profile?->is_approved_by_admin) {
            return back()->with('info', 'User ini sudah disetujui sebelumnya.');
        }

        try {
            // Approve via specialized profile
            $user->pengusulDesaProfile()->updateOrCreate(
                ['user_id' => $user->id],
                ['is_approved_by_admin' => true, 'approved_at' => now()]
            );
            if (!$user->hasVerifiedEmail()) {
                $user->email_verified_at = now();
                $user->save();
            }

            // Log approval action
            \App\Models\AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'approved_pengusul_desa',
                'model_type' => get_class($user),
                'model_id' => $user->id,
                'new_data' => [
                    'email' => $user->email,
                    'approval_status' => 'approved',
                    'approved_at' => $user->profile?->approved_by_admin_at
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Send approval notification email to user
            \Illuminate\Support\Facades\Mail::to($user->email)->send(
                new \App\Mail\PenguslDesaApprovedNotification($user)
            );

            return back()->with('success', 'Pengusul desa berhasil disetujui dan email terverifikasi. Email konfirmasi telah dikirim.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyetujui pengusul desa: ' . $e->getMessage());
        }
    }

    /**
     * Reject a pengusul-desa user
     */
    public function rejectPenguslDesa(Request $request, User $user)
    {
        if (!$user->hasRole('pengusul-desa')) {
            return back()->with('error', 'User ini bukan pengusul desa.');
        }

        if ($user->profile?->is_approved_by_admin) {
            return back()->with('info', 'User yang sudah disetujui tidak dapat ditolak.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        try {
            // Suspend the user directly on the user model
            $user->update([
                'is_suspended' => true,
                'suspended_at' => now(),
            ]);

            // Log rejection action
            \App\Models\AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'rejected_pengusul_desa',
                'model_type' => get_class($user),
                'model_id' => $user->id,
                'new_data' => [
                    'email' => $user->email,
                    'approval_status' => 'rejected',
                    'rejection_reason' => $request->rejection_reason
                ],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            // Send rejection notification email to user
            \Illuminate\Support\Facades\Mail::to($user->email)->send(
                new \App\Mail\PenguslDesaRejectedNotification($user, $request->rejection_reason)
            );

            return back()->with('success', 'Pengusul desa ditolak dan akun disuspend. Email notifikasi telah dikirim.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menolak pengusul desa: ' . $e->getMessage());
        }
    }
}
