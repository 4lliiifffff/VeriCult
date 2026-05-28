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
        // Always use database for in-app notifications.
        // Only send mail if the notifiable has a mail address (always true for User).
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Route approval URL based on the notifiable's role
        if ($notifiable->hasRole('admin')) {
            $url = route('admin.user-approvals.index');
        } else {
            $url = route('super-admin.users.pengusul-desa');
        }

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
     * Get the array representation of the notification (stored in database).
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        // Build a role-aware approval URL for the in-app redirect
        if ($notifiable->hasRole('admin')) {
            $url = route('admin.user-approvals.index');
        } else {
            $url = route('super-admin.users.pengusul-desa');
        }

        return [
            'title'           => 'Pendaftaran Pengusul Desa Baru',
            'message'         => 'Pendaftar baru "' . $this->newUser->name . '" dari desa "' . ($this->newUser->village->name ?? '-') . '" menunggu persetujuan akun.',
            'url'             => $url,
            'type'            => 'info',
            'new_user_id'     => $this->newUser->id,
            'new_user_name'   => $this->newUser->name,
            'new_user_email'  => $this->newUser->email,
            'village_name'    => $this->newUser->village->name ?? '-',
        ];
    }
}
