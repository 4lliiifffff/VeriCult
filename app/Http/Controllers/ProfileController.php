<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update specialized profile data
        $role = $user->roles->first()?->name;
        $profileData = $request->only(['instansi', 'jabatan_desa', 'nip']);

        switch ($role) {
            case 'validator':
                $user->validatorProfile()->update($request->only(['instansi']));
                break;
            case 'pengusul':
                $user->pengusulProfile()->update($request->only(['instansi']));
                break;
            case 'pengusul-desa':
                $user->pengusulDesaProfile()->update($request->only(['jabatan_desa', 'nip']));
                break;
        }

        return Redirect::route('profile.edit')->with('success', 'Profil Anda berhasil diperbarui.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
