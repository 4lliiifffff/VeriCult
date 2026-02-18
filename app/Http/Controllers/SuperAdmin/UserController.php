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
        $query = User::with('roles');

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
                $query->where('is_suspended', false);
            }
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        $roles = Role::all();

        return view('super-admin.users.index', compact('users', 'roles'));
    }

    public function suspend(User $user)
    {
        try {
            $this->governanceService->suspendUser($user, auth()->user());
            return back()->with('success', 'User suspended successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function unsuspend(User $user)
    {
        try {
            $this->governanceService->unsuspendUser($user, auth()->user());
            return back()->with('success', 'User unsuspended successfully.');
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

            return back()->with('success', 'Email pengguna berhasil diverifikasi secara manual.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memverifikasi email: ' . $e->getMessage());
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
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($password),
                'role' => 'validator', // Explicitly set role column
                'email_verified_at' => $request->has('email_verified') ? now() : null,
            ]);

            $user->assignRole('validator');

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
            $message = 'Validator created successfully.';
            $message .= ' <strong>Password: ' . $password . '</strong>';
            $message .= ' (Please copy this password immediately)';

            return redirect()->route('super-admin.users.index')->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create validator: ' . $e->getMessage())->withInput();
        }
    }

    // ...

    public function edit(User $user)
    {
        // Protect Master Admin from being edited
        if ($user->id === 1 && $user->id !== auth()->id()) {
            return redirect()->route('super-admin.users.index')->with('error', 'The Master Administrator account cannot be edited.');
        }

        $roles = Role::all();
        return view('super-admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // Protect Master Admin from modifications
        if ($user->id === 1 && $user->id !== auth()->id()) {
             // Allow Master Admin to update their own profile, but maybe restrict role changes?
             // Actually, usually Master Admin updates via Profile Controller, not User Management.
             // But if another admin tries to edit ID 1, block it.
             return back()->with('error', 'The Master Administrator account cannot be modified by others.');
        }
        
        // If it is ID 1 updating themselves here (rare), ensure they don't lose super-admin role.
        if ($user->id === 1 && $request->role !== 'super-admin') {
             return back()->with('error', 'The Master Administrator cannot change their own role.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'exists:roles,name'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            $oldData = $user->toArray();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role; // Explicitly update role column
            
            if ($request->filled('password')) {
                $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            }

            $user->save();

            // Sync roles - ensure we pass an array of strings
            $user->syncRoles([$request->role]);
            
            // Explicitly forget cached permissions to ensure immediate effect
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

            \App\Models\AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'updated_user',
                'model_type' => get_class($user),
                'model_id' => $user->id,
                'old_data' => $oldData,
                'new_data' => $user->fresh()->toArray(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            return redirect()->route('super-admin.users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        // Protect Master Admin (ID 1)
        if ($user->id === 1) {
            return back()->with('error', 'The Master Administrator account cannot be deleted.');
        }

        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
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

            return redirect()->route('super-admin.users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}
