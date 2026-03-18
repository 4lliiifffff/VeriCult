<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\User;

class NewPengusulDesaRegistrationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $newUser;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->newUser = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('super-admin.users.pengusul-desa');

        return (new MailMessage)
                    ->subject('Menunggu Persetujuan: Pendaftaran Pengusul Desa Baru')
                    ->greeting('Halo, ' . $notifiable->name . '!')
                    ->line('Terdapat pendaftaran baru sebagai Pengusul Desa yang menunggu disetujui:')
                    ->line('Nama: **' . $this->newUser->name . '**')
                    ->line('Email: **' . $this->newUser->email . '**')
                    ->line('Desa: **' . ($this->newUser->village->name ?? '-') . '**')
                    ->action('Tinjau Pendaftar', $url)
                    ->line('Harap segera tinjau profil dan verifikasi alamat email pendaftar agar mereka dapat mengakses platform VeriCult.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
