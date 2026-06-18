@component('mail::message')
# Verifikasi Alamat Email Anda

Halo!

Terima kasih telah mendaftar di **VeriCult** — platform pelestarian warisan budaya Indonesia.

Klik tombol di bawah untuk memverifikasi alamat email Anda dan mengaktifkan akun.

@component('mail::button', ['url' => $url])
Verifikasi Email Sekarang
@endcomponent

Tautan verifikasi ini hanya berlaku selama **60 menit**.

Jika Anda tidak merasa membuat akun di VeriCult, abaikan email ini.

Terima kasih,<br>
**Tim VeriCult**

@component('mail::subcopy')
Jika tombol di atas tidak dapat diklik, salin dan tempelkan URL berikut ke browser Anda:
[{{ $url }}]({{ $url }})
@endcomponent
@endcomponent
