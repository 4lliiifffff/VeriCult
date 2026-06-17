@component('mail::message')
# Verifikasi Nomor Telepon

Anda menerima email ini karena ada permintaan untuk mengubah atau menambahkan nomor telepon pada akun VeriCult Anda.

Kode Verifikasi (OTP) Anda:

@component('mail::panel')
<div style="text-align: center;">
<span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #0077B6;">{{ $token }}</span>
</div>
@endcomponent

Kode ini hanya berlaku selama **5 menit**. Jangan bagikan kode ini kepada siapapun.

Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini.

Terima kasih,<br>
**Tim VeriCult**
@endcomponent
