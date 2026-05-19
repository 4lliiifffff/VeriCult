<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send OTP via WhatsApp API (Fonnte)
     */
    public static function sendOTP(string $targetNumber, string $otpToken)
    {
        $token = env('FONNTE_TOKEN');
        
        if (empty($token)) {
            Log::warning('Fonnte token is missing. WhatsApp message simulated: ' . $otpToken);
            return false;
        }

        $message = "*VeriCult - Kode Verifikasi*\n\n";
        $message .= "Kode OTP Anda adalah: *$otpToken*\n\n";
        $message .= "Kode ini berlaku selama 5 menit. Jangan berikan kode ini kepada siapa pun.\n";
        $message .= "Jika Anda tidak meminta kode ini, abaikan pesan ini.";

        try {
            $response = Http::withHeaders([
                'Authorization' => $token
            ])->post('https://api.fonnte.com/send', [
                'target' => $targetNumber,
                'message' => $message,
                'delay' => '1',
                'countryCode' => '62', // Optional if target already has 62
            ]);

            if ($response->successful()) {
                Log::info("Berhasil mengirim WA ke {$targetNumber}");
                return true;
            }

            Log::error("Gagal mengirim WA ke {$targetNumber}. Response: " . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error("Exception saat mengirim WA: " . $e->getMessage());
            return false;
        }
    }
}
