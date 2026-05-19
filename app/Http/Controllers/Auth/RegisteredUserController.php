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
use App\Models\Kecamatan;

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
            'proposer_type' => ['nullable', 'string', 'in:individu,kelompok'],
        ]);

        $role = $request->role;
        $isApprovedByAdmin = ($role === 'pengusul-desa') ? false : true;

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($role);

        // Create appropriate profile
        $profileRelation = ($role === 'pengusul-desa') ? 'pengusulDesaProfile' : 'pengusulProfile';
        
        $profileData = [
            'is_approved_by_admin' => $isApprovedByAdmin,
            'approved_by_admin_at' => $isApprovedByAdmin ? now() : null,
        ];

        if ($role === 'pengusul') {
            $profileData['proposer_type'] = $request->proposer_type ?? 'individu';
        }

        $user->{$profileRelation}()->create($profileData);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    /**
     * Display the registration view for pengusul-desa.
     */
    public function createDesa(): View
    {
        $villages    = Village::with('kecamatan')->orderBy('name')->get();
        $kecamatans  = Kecamatan::orderBy('name')->get();
        return view('auth.register-desa', compact('villages', 'kecamatans'));
    }

    /**
     * Handle an incoming registration request from pengusul-desa.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storeDesa(Request $request): RedirectResponse
    {
        $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'         => ['required', 'confirmed', 'min:8', Rules\Password::defaults()],
            'kecamatan_name'   => ['required', 'string', 'max:255'],
            'village_name'     => ['required', 'string', 'max:255'],
            'surat_pengajuan'  => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        // Find or create kecamatan, then find or create village linked to that kecamatan
        $kecamatan = Kecamatan::firstOrCreate(
            ['name' => trim($request->kecamatan_name)]
        );

        $village = Village::firstOrCreate(
            ['name' => trim($request->village_name)],
            ['kecamatan_id' => $kecamatan->id]
        );

        // Jika desa sudah ada tapi belum punya kecamatan, isi kecamatan_id-nya
        if (is_null($village->kecamatan_id)) {
            $village->update(['kecamatan_id' => $kecamatan->id]);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('pengusul-desa');

        // Handle file upload
        $path = $request->file('surat_pengajuan')->store('surat_pengajuan', 'public');

        // Create profile with village and approval info
        $user->pengusulDesaProfile()->create([
            'is_approved_by_admin' => false,
            'approved_by_admin_at' => null,
            'village_id'           => $village->id,
            'surat_pengajuan_path'   => $path,
        ]);

        $superAdmins = User::role('super-admin')->get();
        if ($superAdmins->isNotEmpty()) {
            \Illuminate\Support\Facades\Notification::send($superAdmins, new \App\Notifications\NewPengusulDesaRegistrationNotification($user));
        }

        return redirect()->route('register-desa.success');
    }
}
