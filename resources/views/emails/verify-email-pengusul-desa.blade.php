@component('mail::message')
# Verifikasi Email — Pendaftaran Pengusul Desa

Halo, **Pengusul Desa**!

Pendaftaran Anda sebagai **Pengusul Desa** di VeriCult telah berhasil diterima.

Klik tombol di bawah untuk memverifikasi alamat email Anda agar pendaftaran dapat segera ditinjau oleh Administrator.

@component('mail::button', ['url' => $url])
Verifikasi Alamat Email
@endcomponent

@component('mail::panel')
**Apa yang terjadi selanjutnya?**

Setelah Anda berhasil memverifikasi email, akun Anda akan masuk ke antrian untuk divalidasi dan **disetujui oleh Administrator**. Anda akan menerima email pemberitahuan ketika akun Anda telah disetujui.
@endcomponent

Tautan verifikasi ini hanya berlaku selama **60 menit**.

Jika Anda tidak merasa mendaftar di VeriCult, abaikan email ini.

Terima kasih,<br>
**Tim VeriCult**

@component('mail::subcopy')
Jika tombol di atas tidak dapat diklik, salin dan tempelkan URL berikut ke browser Anda:
[{{ $url }}]({{ $url }})
@endcomponent
@endcomponent
