{{-- ============================================================ --}}
{{-- PWA Install Banner + Button                                 --}}
{{-- Muncul otomatis saat browser mendeteksi app bisa diinstall --}}
{{-- ============================================================ --}}
<div
    x-data="{
        show: false,
        installed: false,
        bannerDismissed: localStorage.getItem('pwa-banner-dismissed') === 'true',
        init() {
            // Cek apakah sudah diinstall (standalone mode)
            if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
                this.installed = true;
                return;
            }

            // Listen untuk event install prompt
            document.addEventListener('pwa-installable', () => {
                if (!this.bannerDismissed && !this.installed) {
                    setTimeout(() => { this.show = true; }, 3000);
                }
            });

            document.addEventListener('pwa-installed', () => {
                this.installed = true;
                this.show = false;
            });

            // Jika prompt sudah tersedia saat komponen init
            if (window.__pwaInstallPrompt && !this.bannerDismissed) {
                setTimeout(() => { this.show = true; }, 3000);
            }
        },
        async install() {
            if (!window.__pwaInstallPrompt) return;
            try {
                await window.__pwaInstallPrompt.prompt();
                const { outcome } = await window.__pwaInstallPrompt.userChoice;
                if (outcome === 'accepted') {
                    this.installed = true;
                    this.show = false;
                    console.log('[VeriCult PWA] User accepted install.');
                } else {
                    console.log('[VeriCult PWA] User dismissed install.');
                }
            } catch (err) {
                console.error('[PWA] Prompt error:', err);
                alert('Prompt instalasi tidak dapat dimunculkan. Silakan klik ikon install di address bar browser Anda.');
            }
            window.__pwaInstallPrompt = null;
        },
        dismiss() {
            this.show = false;
            this.bannerDismissed = true;
            localStorage.setItem('pwa-banner-dismissed', 'true');
        }
    }"
    x-cloak
>
    {{-- ── INSTALL BANNER (muncul di bawah layar) ─────────────────── --}}
    <div
        x-show="show && !installed"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 translate-y-full"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-full"
        class="fixed bottom-4 left-4 right-4 sm:left-auto sm:right-6 sm:bottom-6 sm:w-96 z-[9999]"
        role="dialog"
        aria-label="Install VeriCult App"
    >
        <div class="bg-[#03045E] rounded-2xl shadow-2xl shadow-blue-950/50 border border-[#0077B6]/30 overflow-hidden">
            {{-- Glow accent --}}
            <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-[#00B4D8]/60 to-transparent"></div>

            <div class="p-4 flex items-start gap-3">
                {{-- App Icon --}}
                <div class="flex-shrink-0 w-12 h-12 rounded-xl overflow-hidden border border-white/10 shadow-lg">
                    <img src="{{ asset('icons/icon-96x96.png') }}" alt="VeriCult" class="w-full h-full object-cover">
                </div>

                {{-- Text --}}
                <div class="flex-1 min-w-0">
                    <p class="text-white font-bold text-sm leading-tight mb-0.5">Install VeriCult</p>
                    <p class="text-[#ADE8F4] text-xs leading-relaxed opacity-80">Tambah ke layar utama untuk akses lebih cepat</p>
                </div>

                {{-- Close --}}
                <button
                    @click="dismiss()"
                    class="flex-shrink-0 w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-white hover:bg-white/10 transition-colors"
                    aria-label="Tutup"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Action Buttons --}}
            <div class="px-4 pb-4 flex gap-2">
                <button
                    @click="install()"
                    class="flex-1 bg-[#0077B6] hover:bg-[#00B4D8] text-white text-xs font-bold py-2.5 px-4 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-lg shadow-blue-800/30 hover:shadow-cyan-500/30 active:scale-95"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Install Sekarang
                </button>
                <button
                    @click="dismiss()"
                    class="text-slate-400 hover:text-white text-xs font-medium py-2.5 px-3 rounded-xl hover:bg-white/5 transition-colors"
                >
                    Nanti
                </button>
            </div>
        </div>
    </div>

    {{-- ── SUDAH TERINSTALL (standalone mode) ──────────────────────── --}}
    {{-- Tidak tampil apapun, app berjalan normal --}}
</div>
