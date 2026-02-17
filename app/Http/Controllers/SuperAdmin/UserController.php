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

    public function createValidator()
    {
        return view('super-admin.users.create-validator');
    }

    public function storeValidator(\App\Http\Requests\StoreValidatorRequest $request)
    {
        try {
            $password = $request->password ?? \Illuminate\Support\Str::random(10);
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($password),
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

            return redirect()->route('super-admin.users.index')->with('success', 'Validator created successfully. Password: ' . ($request->password ? 'Set manually' : $password));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create validator: ' . $e->getMessage());
        }
    }

    public function verifyEmail(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'User email is already verified.');
        }

        $user->markEmailAsVerified();

        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'manually_verified_email',
            'model_type' => get_class($user),
            'model_id' => $user->id,
            'new_data' => ['email_verified_at' => now()],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'User email verified successfully.');
    }

    public function resendVerificationEmail(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'User email is already verified.');
        }

        $user->sendEmailVerificationNotification();

        \App\Models\AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'resent_verification_email',
            'model_type' => get_class($user),
            'model_id' => $user->id,
            'new_data' => [],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', 'Verification email resent successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('super-admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
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
            
            if ($request->filled('password')) {
                $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            }

            $user->save();

            // Sync roles
            $user->syncRoles([$request->role]);

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
        if ($user->hasRole('super-admin')) {
            return back()->with('error', 'Cannot delete a Super Admin user.');
        }

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
