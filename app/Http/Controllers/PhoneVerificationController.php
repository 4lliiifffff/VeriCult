<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhoneVerification;
use App\Rules\UniquePhoneNumber;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PhoneVerificationMail;
use Illuminate\Support\Str;

class PhoneVerificationController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'phone_number' => ['required', 'string', 'min:10', 'max:15', new UniquePhoneNumber],
        ]);

        $user = $request->user();
        
        // Generate a 6-digit OTP
        $token = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Remove existing verification codes for this user
        PhoneVerification::where('user_id', $user->id)->delete();
        
        // Save new verification code
        PhoneVerification::create([
            'user_id' => $user->id,
            'phone_number' => $request->phone_number,
            'token' => $token,
            'expires_at' => now()->addMinutes(5),
        ]);

        // Send WA message
        \App\Services\WhatsAppService::sendOTP($request->phone_number, $token);

        // Send Email
        if ($user->email) {
            Mail::to($user->email)->send(new PhoneVerificationMail($token));
        }

        return response()->json(['message' => 'Kode verifikasi telah dikirim ke WhatsApp dan Email Anda.']);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string', 'size:6'],
        ]);

        $user = $request->user();
        $verification = PhoneVerification::where('user_id', $user->id)->first();

        if (!$verification) {
            return response()->json(['message' => 'Tidak ada permintaan verifikasi yang aktif.'], 400);
        }

        if ($verification->expires_at < now()) {
            $verification->delete();
            return response()->json(['message' => 'Kode verifikasi telah kedaluwarsa. Silakan minta kode baru.'], 400);
        }

        if ($verification->token !== $request->token) {
            return response()->json(['message' => 'Kode verifikasi salah.'], 400);
        }

        // Update the phone number in the user's profile
        if ($user->hasRole('pengusul')) {
            $user->pengusulProfile()->updateOrCreate(
                ['user_id' => $user->id],
                ['no_hp' => $verification->phone_number]
            );
        } elseif ($user->hasRole('pengusul-desa')) {
            $user->pengusulDesaProfile()->updateOrCreate(
                ['user_id' => $user->id],
                ['no_hp' => $verification->phone_number]
            );
        }

        // Delete verification record
        $verification->delete();

        return response()->json(['message' => 'Nomor telepon berhasil diverifikasi dan disimpan.']);
    }
}
