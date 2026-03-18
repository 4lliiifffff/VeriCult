@component('mail::message')
# Akun Pengusul Desa Disetujui

Halo {{ $userName }},

Kami dengan senang hati memberitahu bahwa akun Pengusul Desa Anda telah **disetujui** oleh Super Admin.

Anda sekarang dapat:
✓ Akses dashboard Pengusul Desa
✓ Melaporkan Kebudayaan dengan form OPK (10+1 kategori)
✓ Melaporkan Kebudayaan Aktif (5W+1H form)
✓ Melacak status laporan Anda

**Email Login:** {{ $userEmail }}

@component('mail::button', ['url' => route('dashboard')])
Masuk ke Dashboard
@endcomponent

Jika Anda memiliki pertanyaan, silahkan hubungi Tim VeriCult.

Terima kasih,
**Tim VeriCult**
@endcomponent
