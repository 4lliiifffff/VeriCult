<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class PengusulDesaVerifyEmailNotification extends VerifyEmail
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject('Verifikasi Email & Status Pendaftaran Pengusul Desa')
            ->greeting('Halo Pengusul Desa!')
            ->line('Pendaftaran Anda sebagai Pengusul Desa telah berhasil diterima.')
            ->line('Anda perlu memverifikasi alamat email ini agar pendaftaran Anda dapat ditinjau.')
            ->action('Verifikasi Alamat Email', $url)
            ->line('Setelah Anda melakukan verifikasi email, akun Anda akan masuk ke antrian untuk divalidasi dan disetujui oleh Administrator.')
            ->line('Harap menunggu pemberitahuan selanjutnya melalui email saat akun Anda telah disetujui.');
    }
}
