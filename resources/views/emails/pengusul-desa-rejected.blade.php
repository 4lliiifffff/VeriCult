@component('mail::message')
# Pengajuan Akun Pengusul Desa Ditolak

Halo **{{ $userName }}**,

Terima kasih atas pengajuan pendaftaran akun Pengusul Desa Anda di VeriCult. Setelah melalui proses peninjauan, kami mohon menyampaikan bahwa pengajuan Anda **belum dapat kami setujui** pada saat ini.

**Alasan Penolakan:**

@component('mail::panel')
{{ $rejectionReason }}
@endcomponent

---

Jika Anda memiliki pertanyaan lebih lanjut atau membutuhkan klarifikasi mengenai keputusan ini, silakan hubungi Tim VeriCult melalui kontak yang tersedia di website kami.

Kami menghargai dukungan Anda dalam upaya pelestarian warisan budaya Indonesia dan berharap dapat bekerja sama di masa mendatang.

Salam hormat,<br>
**Tim VeriCult**
@endcomponent
