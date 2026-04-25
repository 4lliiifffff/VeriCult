<?php

namespace App\Http\Controllers\Admin;

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

    /**
     * Display a listing of the users for Admin management.
     */
    public function index(Request $request)
    {
        // Admin can only manage Validators, Pengusul, and Pengusul Desa
        $query = User::role(['validator', 'pengusul', 'pengusul-desa'])
            ->with(['roles', 'validatorProfile', 'pengusulProfile', 'pengusulDesaProfile.village']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->role($request->role);
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status == 'suspended') {
                $query->where('is_suspended', true);
            } elseif ($request->status == 'active') {
                $query->where('is_suspended', false)->whereNotNull('email_verified_at');
            }
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        
        // Only roles that Admin can manage
        $roles = Role::whereIn('name', ['validator', 'pengusul', 'pengusul-desa'])->get();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Display the specified user detail.
     */
    public function show(User $user)
    {
        // Safety check: ensure user is manageable by Admin
        if (!$user->hasAnyRole(['validator', 'pengusul', 'pengusul-desa'])) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak memiliki otoritas untuk melihat pengguna ini.');
        }

        $user->load(['roles', 'validatorProfile', 'pengusulProfile', 'pengusulDesaProfile.village']);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Suspend a user.
     */
    public function suspend(User $user)
    {
        // Safety check: ensure user is manageable by Admin
        if (!$user->hasAnyRole(['validator', 'pengusul', 'pengusul-desa'])) {
            return back()->with('error', 'Anda tidak memiliki otoritas untuk menangguhkan pengguna ini.');
        }

        try {
            $this->governanceService->suspendUser($user, auth()->user());
            return back()->with('success', 'Pengguna berhasil ditangguhkan.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Unsuspend a user.
     */
    public function unsuspend(User $user)
    {
        try {
            $this->governanceService->unsuspendUser($user, auth()->user());
            return back()->with('success', 'Penangguhan pengguna berhasil dicabut.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Mark email as verified manually.
     */
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
                'action' => 'admin_verified_email',
                'model_type' => get_class($user),
                'model_id' => $user->id,
                'new_data' => ['email' => $user->email, 'verified_at' => $user->email_verified_at],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return back()->with('success', 'Email pengguna berhasil diverifikasi secara manual.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memverifikasi email: ' . $e->getMessage());
        }
    }
}
