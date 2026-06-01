<x-layouts.validator>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('validator.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Pusat Notifikasi</span>
        </nav>

        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-5 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group">
            <!-- Decorative Bubble -->
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6 sm:gap-8">
                <div class="flex items-center gap-4 sm:gap-8">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 rounded-[1.25rem] sm:rounded-[2rem] bg-[#03045E] flex items-center justify-center text-white shadow-xl shadow-blue-900/20 font-black text-xl sm:text-2xl uppercase">
                        <svg class="w-7 h-7 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <div class="space-y-1 sm:space-y-2">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="px-2.5 py-1 rounded-full text-[7px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-blue-50 text-[#0077B6] border border-blue-100">
                                Validator Workspace
                            </div>
                            <div class="h-3 w-[1px] bg-slate-200"></div>
                            <span class="text-slate-400 text-[7px] sm:text-[10px] font-bold uppercase tracking-widest">Update Review</span>
                        </div>
                        <h2 class="text-xl sm:text-4xl font-black text-[#03045E] tracking-tight leading-tight">
                            Pusat <span class="text-[#00B4D8]">Notifikasi</span>
                        </h2>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <form action="{{ route('validator.notifications.mark-all-read') }}" method="POST" class="w-full md:w-auto">
                            @csrf
                            <button type="submit" class="w-full px-6 py-4 bg-[#03045E] text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-[#0077B6] transition-all flex items-center justify-center gap-3 shadow-xl shadow-blue-900/20 active:scale-95 group/btn">
                                <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Tandai Semua Terbaca
                            </button>
                        </form>
                    @endif

                    @if(Auth::user()->notifications->count() > 0)
                        <button type="button" @click="$dispatch('open-modal', 'confirm-delete-all-notifications')" class="w-full px-6 py-4 bg-rose-500 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-rose-600 transition-all flex items-center justify-center gap-3 shadow-xl shadow-rose-900/20 active:scale-95">
                            <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus Semua Notifikasi
                        </button>
                    @endif
                </div>

                @if(Auth::user()->notifications->count() > 0)
                    <x-modal name="confirm-delete-all-notifications" focusable maxWidth="md">
                        <form action="{{ route('validator.notifications.delete-all') }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <div class="bg-white p-8 sm:p-12">
                                <div class="w-20 h-20 rounded-[2rem] bg-rose-50 text-rose-600 flex items-center justify-center mb-8 shadow-xl shadow-rose-900/10 border border-rose-100">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </div>

                                <h3 class="text-3xl font-black text-[#03045E] tracking-tight leading-tight mb-4">Hapus Semua Notifikasi?</h3>
                                <p class="text-slate-500 font-bold text-sm leading-relaxed mb-0 uppercase tracking-tight">
                                    Tindakan ini akan menghapus semua notifikasi Anda dan tidak dapat dikembalikan.
                                </p>
                            </div>

                            <div class="px-8 sm:px-12 py-8 bg-slate-50 flex flex-col sm:flex-row-reverse gap-4">
                                <button type="submit" class="flex-1 px-8 py-5 bg-rose-600 hover:bg-rose-700 text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] transition-all duration-300 shadow-xl shadow-rose-900/40 active:scale-95">
                                    Konfirmasi Hapus
                                </button>
                                <button type="button" @click="$dispatch('close-modal', 'confirm-delete-all-notifications')" class="flex-1 px-8 py-5 bg-white text-slate-500 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] transition-all duration-300 border border-slate-200 active:scale-95">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </x-modal>
                @endif
            </div>
        </div>
    </x-slot>

    <div x-data="{
            loading: false,
            fetchNotifications(url = null) {
                this.loading = true;
                const form = this.$refs.filterForm;
                const formData = new FormData(form);
                const query = new URLSearchParams(formData).toString();
                const currentAction = url || form.action;
                const fetchUrl = currentAction + (currentAction.includes('?') ? '&' : '?') + query;

                fetch(fetchUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    this.$refs.listContainer.innerHTML = html;
                    // Update URL without reloading
                    const cleanUrl = fetchUrl.replace(/([?&])_token=[^&]*(&|$)/, '$1').replace(/[?&]$/, '');
                    window.history.pushState({}, '', cleanUrl);
                })
                .catch(error => console.error('Error:', error))
                .finally(() => {
                    this.loading = false;
                });
            },
            init() {
                // Intercept pagination clicks
                this.$refs.listContainer.addEventListener('click', (e) => {
                    const link = e.target.closest('.pagination a');
                    if (link) {
                        e.preventDefault();
                        this.fetchNotifications(link.href);
                    }
                });
            }
        }" class="relative">

        <!-- Loading Overlay -->
        <div x-show="loading"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0 z-40 bg-white/60 backdrop-blur-[2px] flex items-center justify-center rounded-[2.5rem]" style="display: none;">
            <div class="flex flex-col items-center gap-4">
                <div class="w-12 h-12 border-4 border-slate-100 border-t-[#0077B6] rounded-full animate-spin"></div>
                <span class="text-[10px] font-black text-[#03045E] uppercase tracking-widest animate-pulse">Memperbarui...</span>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="max-w-4xl mx-auto mb-10 bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-8 shadow-xl shadow-slate-200/50 border border-slate-100">
            <form x-ref="filterForm" action="{{ route('validator.notifications.index') }}" method="GET" @submit.prevent="fetchNotifications()" class="auto-submit grid gap-6">
                <div class="flex flex-col">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-2">Cari Pesan</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            @input.debounce.500ms="fetchNotifications()"
                            placeholder="Ketik kata kunci..."
                            class="pl-14 block w-full rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 sm:text-sm transition-all duration-300 h-14 font-bold text-[#03045E]">
                    </div>
                </div>

                <div class="flex flex-col">
                    <x-dropdown-select
                        name="filter"
                        id="filter"
                        label="Status"
                        placeholder="Pilih Status"
                        variant="light"
                        :selected="request('filter', 'all')"
                        :options="['all' => 'Semua', 'unread' => 'Baru', 'read' => 'Dibaca']"
                    />
                </div>

                <div class="grid gap-4 lg:grid-cols-2">
                    <div class="flex flex-col">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-2">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            @change="fetchNotifications()"
                            class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 sm:text-sm transition-all duration-300 h-14 font-bold text-[#03045E] px-5">
                    </div>

                    <div class="flex flex-col">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-2">Hingga</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            @change="fetchNotifications()"
                            class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 sm:text-sm transition-all duration-300 h-14 font-bold text-[#03045E] px-5">
                    </div>
                </div>
            </form>
        </div>

        <div x-ref="listContainer" class="max-w-4xl mx-auto space-y-6 pb-20">
            @include('notifications._list')
        </div>
    </div>

    @push('scripts')
    <script>
        function markAsRead(id, button) {
            event.preventDefault();
            event.stopPropagation();

            fetch(`/validator/notifications/${id}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    const card = button.closest('.group');
                    card.classList.remove('bg-gradient-to-br', 'from-indigo-50/50', 'via-white', 'to-blue-50/30', 'border-indigo-100', 'shadow-indigo-900/10', 'ring-1', 'ring-indigo-500/5');
                    card.classList.add('bg-white', 'border-slate-100', 'shadow-xl', 'shadow-slate-200/50');

                    const indicator = card.querySelector('.absolute.left-0.top-0');
                    if (indicator) indicator.style.opacity = '0';

                    const badge = card.querySelector('.flex.items-center.gap-2.5');
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
            });
        }
    </script>
    @endpush
</x-layouts.validator>

