@component('mail::message')
# Notifikasi dari Admin VeriCult

Halo **{{ $user->name }}**,

Anda menerima notifikasi baru dari administrator:

@component('mail::panel')
"{{ $messageContent }}"
@endcomponent

Harap tidak membalas email ini karena email ini dikirim secara otomatis.

Terima kasih,<br>
**Tim VeriCult**
@endcomponent
