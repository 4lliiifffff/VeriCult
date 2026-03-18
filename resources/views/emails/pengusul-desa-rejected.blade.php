@component('mail::message')
# Pengajuan Akun Pengusul Desa Ditolak

Halo {{ $userName }},

Kami berterima kasih atas pengajuan akun Pengusul Desa Anda. Namun, sayangnya pengajuan Anda **ditolak** oleh Super Admin.

**Alasan Penolakan:**

{{ $rejectionReason }}

---

Jika Anda merasa bahwa ini adalah kesalahan atau ingin mengetahui informasi lebih lanjut, silahkan hubungi Tim VeriCult melalui kontak yang tersedia di website kami.

Kami menghargai dukungan Anda dalam upaya pelestarian warisan budaya Indonesia.

Salam,
**Tim VeriCult**
@endcomponent
