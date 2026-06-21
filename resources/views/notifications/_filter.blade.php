{{--
    Shared Notification Filter + Alpine.js Component
    Props:
      $routeName  — e.g. 'admin.notifications.index'
      $markReadJs — JS snippet for the role-specific markAsRead URL prefix, e.g. '/admin'
--}}

<div x-data="notificationFilter('{{ route($routeName) }}')" class="relative">

    {{-- Loading Overlay --}}
    <div x-show="loading"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute inset-0 z-40 bg-white/60 backdrop-blur-[2px] flex items-center justify-center rounded-[2.5rem]"
        style="display: none;">
        <div class="flex flex-col items-center gap-4">
            <div class="w-12 h-12 border-4 border-slate-100 border-t-[#0077B6] rounded-full animate-spin"></div>
            <span class="text-[10px] font-black text-[#03045E] uppercase tracking-widest animate-pulse">Memperbarui...</span>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="max-w-4xl mx-auto mb-10 bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-8 shadow-xl shadow-slate-200/50 border border-slate-100">
        <form x-ref="filterForm" action="{{ route($routeName) }}" method="GET"
            @submit.prevent="fetch()" class="auto-submit grid gap-6">
            <div class="flex flex-col">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-2">Cari Pesan</label>
                <div class="relative group flex items-center">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400 group-focus-within:text-[#0077B6] transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        @input.debounce.700ms="searchInput($event.target.value)"
                        placeholder="Ketik kata kunci (min. 2 karakter)..."
                        class="pl-14 pr-24 block w-full rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 sm:text-sm transition-all duration-300 h-14 font-bold text-[#03045E]">
                    <button type="submit"
                        class="absolute right-2 top-2 bottom-2 px-5 bg-[#03045E] hover:bg-[#0077B6] text-white rounded-xl font-bold text-xs uppercase tracking-wider transition-all">
                        Cari
                    </button>
                </div>
                {{-- Hint minimum karakter --}}
                <p x-show="searchTooShort" x-transition class="text-[10px] text-amber-500 font-bold mt-2 ml-2 uppercase tracking-wide">
                    ⚠ Masukkan minimal 2 karakter untuk mencari
                </p>
            </div>

            <div class="flex flex-col">
                <x-dropdown-select name="filter" id="filter" label="Status" placeholder="Pilih Status"
                    variant="light" :selected="request('filter', 'all')"
                    :options="['all' => 'Semua', 'unread' => 'Baru', 'read' => 'Dibaca']" />
            </div>

            <div class="grid gap-4 lg:grid-cols-2">
                <div class="flex flex-col">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-2">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        @change="fetch()"
                        class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 sm:text-sm transition-all duration-300 h-14 font-bold text-[#03045E] px-5">
                </div>

                <div class="flex flex-col">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-2">Hingga</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        @change="fetch()"
                        class="block w-full rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 sm:text-sm transition-all duration-300 h-14 font-bold text-[#03045E] px-5">
                </div>
            </div>
        </form>
    </div>

    <div x-ref="listContainer" class="max-w-4xl mx-auto space-y-6 pb-20">
        @include('notifications._list')
    </div>
</div>

@once
@push('scripts')
<script>
    /**
     * Alpine.js component untuk filter notifikasi.
     * - AbortController: mencegah race condition antar request
     * - Minimum 2 karakter untuk field search
     * - Debounce sudah ditangani Alpine di template (@input.debounce.700ms)
     */
    function notificationFilter(baseUrl) {
        return {
            loading: false,
            searchTooShort: false,
            _abortController: null,

            init() {
                // Intercept pagination clicks
                this.$refs.listContainer.addEventListener('click', (e) => {
                    const link = e.target.closest('.pagination a');
                    if (link) {
                        e.preventDefault();
                        this.fetch(link.href);
                    }
                });
            },

            searchInput(value) {
                // Jika kosong, langsung reset (tampilkan semua)
                if (value === '') {
                    this.searchTooShort = false;
                    this.fetch();
                    return;
                }
                // Jika terlalu pendek, tunjukkan hint dan batalkan fetch
                if (value.length < 2) {
                    this.searchTooShort = true;
                    return;
                }
                this.searchTooShort = false;
                this.fetch();
            },

            fetch(url = null) {
                // Batalkan request sebelumnya jika masih berjalan (race condition prevention)
                if (this._abortController) {
                    this._abortController.abort();
                }
                this._abortController = new AbortController();

                this.loading = true;
                const form = this.$refs.filterForm;
                const formData = new FormData(form);
                const query = new URLSearchParams(formData).toString();
                const currentAction = url || form.action;
                const fetchUrl = currentAction + (currentAction.includes('?') ? '&' : '?') + query;

                window.fetch(fetchUrl, {
                    signal: this._abortController.signal,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.text())
                .then(html => {
                    this.$refs.listContainer.innerHTML = html;
                    // Update URL tanpa reload halaman
                    const cleanUrl = fetchUrl
                        .replace(/([?&])_token=[^&]*(&|$)/, '$1')
                        .replace(/[?&]$/, '');
                    window.history.pushState({}, '', cleanUrl);
                })
                .catch(error => {
                    // AbortError adalah normal (request dibatalkan), abaikan
                    if (error.name !== 'AbortError') {
                        console.error('Notification fetch error:', error);
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
            }
        };
    }
</script>
@endpush
@endonce
