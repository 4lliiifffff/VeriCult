{{--
    Shared markAsRead script untuk halaman notifikasi.
    Bergantung pada request()->segment(1) untuk mendeteksi prefix URL role secara otomatis.
    Dipanggil dari: notifications/_filter.blade.php (melalui @once @push('scripts'))
    Script ini harus di-push setelah Alpine.js agar tersedia di DOM.
--}}

@push('scripts')
<script>
    /**
     * Tandai notifikasi sebagai terbaca secara inline (tanpa reload halaman).
     * URL prefix diambil dari segment pertama URL halaman saat ini
     * sehingga fungsi ini bekerja untuk semua role tanpa modifikasi.
     */
    function markAsRead(id, button) {
        event.preventDefault();
        event.stopPropagation();

        const rolePrefix = window.location.pathname.split('/').filter(Boolean)[0];

        fetch(`/${rolePrefix}/notifications/${id}/mark-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                const card = button.closest('.group');
                card.classList.remove(
                    'bg-gradient-to-br', 'from-indigo-50/50', 'via-white',
                    'to-blue-50/30', 'border-indigo-100', 'shadow-indigo-900/10',
                    'ring-1', 'ring-indigo-500/5'
                );
                card.classList.add('bg-white', 'border-slate-100', 'shadow-xl', 'shadow-slate-200/50');

                const indicator = card.querySelector('.absolute.left-0.top-0');
                if (indicator) indicator.style.opacity = '0';

                const badge = card.querySelector('.flex.items-center.gap-2\\.5');
                if (badge) badge.style.opacity = '0';

                const title = card.querySelector('h3');
                if (title) {
                    title.classList.remove('text-[#0077B6]');
                    title.classList.add('text-[#03045E]');
                }

                button.style.transform = 'scale(0) rotate(90deg)';
                button.style.opacity = '0';

                setTimeout(() => {
                    if (indicator) indicator.remove();
                    if (badge) badge.remove();
                    button.remove();
                }, 500);
            }
        }).catch(error => {
            console.error('Mark as read error:', error);
        });
    }
</script>
@endpush
