<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Village;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:8', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:pengusul,pengusul-desa'],
        ]);

        $role = $request->role;
        $isApprovedByAdmin = ($role === 'pengusul-desa') ? false : true;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'is_approved_by_admin' => $isApprovedByAdmin,
            'approved_by_admin_at' => $isApprovedByAdmin ? now() : null,
        ]);

        $user->assignRole($role);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Display the registration view for pengusul-desa.
     */
    public function createDesa(): View
    {
        return view('auth.register-desa');
    }

    /**
     * Handle an incoming registration request from pengusul-desa.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeDesa(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:8', Rules\Password::defaults()],
            'village_name' => ['required', 'string', 'max:255'],
        ]);

        // Find or create the village
        $village = Village::firstOrCreate(['name' => $request->village_name]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pengusul-desa',
            'is_approved_by_admin' => false,
            'approved_by_admin_at' => null,
            'village_id' => $village->id,
        ]);

        $user->assignRole('pengusul-desa');

        $superAdmins = User::role('super-admin')->get();
        if ($superAdmins->isNotEmpty()) {
            \Illuminate\Support\Facades\Notification::send($superAdmins, new \App\Notifications\NewPengusulDesaRegistrationNotification($user));
        }

        return redirect()->route('register-desa.success');
    }
}
