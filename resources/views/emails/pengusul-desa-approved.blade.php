@component('mail::message')
# Selamat! Akun Anda Telah Disetujui

Halo **{{ $userName }}**,

Kami dengan senang hati memberitahukan bahwa akun **Pengusul Desa** Anda di VeriCult telah resmi **disetujui** oleh Administrator.

@component('mail::panel')
**Email Login:** {{ $userEmail }}
@endcomponent

Anda sekarang dapat mengakses seluruh fitur platform VeriCult, termasuk:

- Akses dashboard Pengusul Desa
- Melaporkan Kebudayaan dengan form OPK (10+1 kategori)
- Melaporkan Kebudayaan Aktif (5W+1H form)
- Mengajukan data Cagar Budaya
- Melacak status dan riwayat laporan Anda

@component('mail::button', ['url' => route('dashboard')])
Masuk ke Dashboard Sekarang
@endcomponent

Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi Tim VeriCult.

Terima kasih atas dedikasi Anda dalam pelestarian warisan budaya Indonesia. 🇮🇩

Salam hangat,<br>
**Tim VeriCult**
@endcomponent
