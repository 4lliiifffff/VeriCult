<nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-500"
     x-data="{ scrolled: false, mobileMenu: false, profileOpen: false }"
     @scroll.window="scrolled = window.pageYOffset > 50"
     :class="scrolled || mobileMenu ? 'bg-white shadow-sm border-b border-slate-100 py-3' : 'bg-white/25 py-5 md:py-8'">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">

            <!-- Logo Section -->
            <div class="flex items-center">
                <a href="{{ route('beranda') }}" class="flex items-center space-x-3 group">
                    <div class="flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                        <img class="w-8 h-9" src="{{ asset('Logo/Dinas/Logo-Dinas.png') }}" alt="Logo VeriCult">
                    </div>

                    <!-- <div class="w-9 h-9 bg-brand-dark rounded-lg flex items-center justify-center shadow-md shadow-brand-primary/20 group-hover:scale-105 transition-transform duration-300">
                        <img class="w-5 h-5" src="{{ asset('Logo/Putih/Logo-Sistem-W.png') }}" alt="Logo VeriCult">
                    </div> -->
                    <span class="text-xl font-bold tracking-tight transition-colors duration-300"
                        :class="scrolled || mobileMenu ? 'text-brand-dark' : 'text-brand-dark'">
                    </span>
                </a>
            </div>

            <!-- Desktop Navigation (Centered) -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('beranda') }}" class="text-xs font-semibold tracking-wide transition-all duration-300 hover:opacity-100 relative after:absolute after:bottom-[-4px] after:left-0 after:w-0 after:h-[2px] after:bg-current after:transition-all hover:after:w-full {{ request()->routeIs('beranda') ? 'after:w-full' : '' }}"
                    :class="scrolled ? '{{ request()->routeIs('beranda') ? 'text-[#03045E]' : 'text-slate-600 hover:text-[#03045E]' }}' : '{{ request()->routeIs('beranda') ? 'text-[#03045E]' : 'text-[#03045E]/80 hover:text-[#03045E]' }}'">Beranda</a>
                <a href="{{ route('tentang') }}" class="text-xs font-semibold tracking-wide transition-all duration-300 hover:opacity-100 relative after:absolute after:bottom-[-4px] after:left-0 after:w-0 after:h-[2px] after:bg-current after:transition-all hover:after:w-full {{ request()->routeIs('tentang') ? 'after:w-full' : '' }}"
                    :class="scrolled ? '{{ request()->routeIs('tentang') ? 'text-[#03045E]' : 'text-slate-600 hover:text-[#03045E]' }}' : '{{ request()->routeIs('tentang') ? 'text-[#03045E]' : 'text-[#03045E]/80 hover:text-[#03045E]' }}'">Tentang</a>
                <a href="{{ route('fitur') }}" class="text-xs font-semibold tracking-wide transition-all duration-300 hover:opacity-100 relative after:absolute after:bottom-[-4px] after:left-0 after:w-0 after:h-[2px] after:bg-current after:transition-all hover:after:w-full {{ request()->routeIs('fitur') ? 'after:w-full' : '' }}"
                    :class="scrolled ? '{{ request()->routeIs('fitur') ? 'text-[#03045E]' : 'text-slate-600 hover:text-[#03045E]' }}' : '{{ request()->routeIs('fitur') ? 'text-[#03045E]' : 'text-[#03045E]/80 hover:text-[#03045E]' }}'">Fitur</a>
                <a href="{{ route('edukasi') }}" class="text-xs font-semibold tracking-wide transition-all duration-300 hover:opacity-100 relative after:absolute after:bottom-[-4px] after:left-0 after:w-0 after:h-[2px] after:bg-current after:transition-all hover:after:w-full {{ request()->routeIs('edukasi') ? 'after:w-full' : '' }}"
                    :class="scrolled ? '{{ request()->routeIs('edukasi') ? 'text-[#03045E]' : 'text-slate-600 hover:text-[#03045E]' }}' : '{{ request()->routeIs('edukasi') ? 'text-[#03045E]' : 'text-[#03045E]/80 hover:text-[#03045E]' }}'">Edukasi</a>
                <a href="{{ route('profil-kebudayaan.index') }}" class="text-xs font-semibold tracking-wide transition-all duration-300 hover:opacity-100 relative after:absolute after:bottom-[-4px] after:left-0 after:w-0 after:h-[2px] after:bg-current after:transition-all hover:after:w-full {{ request()->routeIs('profil-kebudayaan.*') ? 'after:w-full' : '' }}"
                    :class="scrolled ? '{{ request()->routeIs('profil-kebudayaan.*') ? 'text-[#03045E]' : 'text-slate-600 hover:text-[#03045E]' }}' : '{{ request()->routeIs('profil-kebudayaan.*') ? 'text-[#03045E]' : 'text-[#03045E]/80 hover:text-[#03045E]' }}'">Profil Budaya</a>
                <a href="{{ route('kebudayaan-aktif.index') }}" class="text-xs font-semibold tracking-wide transition-all duration-300 hover:opacity-100 relative after:absolute after:bottom-[-4px] after:left-0 after:w-0 after:h-[2px] after:bg-current after:transition-all hover:after:w-full {{ request()->routeIs('kebudayaan-aktif.*') ? 'after:w-full' : '' }} flex items-center gap-1.5"
                    :class="scrolled ? '{{ request()->routeIs('kebudayaan-aktif.*') ? 'text-[#03045E]' : 'text-slate-600 hover:text-[#03045E]' }}' : '{{ request()->routeIs('kebudayaan-aktif.*') ? 'text-[#03045E]' : 'text-[#03045E]/80 hover:text-[#03045E]' }}'">Budaya Aktif</a>

            </div>

            <!-- Right Actions Section -->
            <div class="flex items-center gap-4">
                <!-- PWA Install Button (Desktop) -->
                <div
                    x-data="{
                        showInstallBtn: false,
                        init() {
                            if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
                                return;
                            }
                            document.addEventListener('pwa-installable', () => { this.showInstallBtn = true; });
                            if (window.__pwaInstallPrompt) { this.showInstallBtn = true; }
                            document.addEventListener('pwa-installed', () => { this.showInstallBtn = false; });
                        },
                        installApp() {
                            if (window.__pwaInstallPrompt) {
                                window.__pwaInstallPrompt.prompt().catch(err => {
                                    console.error('[PWA] Prompt error:', err);
                                    alert('Prompt instalasi tidak dapat dimunculkan. Silakan klik ikon install (⊕) di address bar browser Anda.');
                                });
                                window.__pwaInstallPrompt.userChoice.then(choice => {
                                    if (choice.outcome === 'accepted') {
                                        this.showInstallBtn = false;
                                    }
                                    window.__pwaInstallPrompt = null;
                                }).catch(err => console.error(err));
                            } else {
                                alert('Aplikasi siap diinstal. Silakan klik ikon install (⊕) di ujung kanan address bar browser Anda.');
                            }
                        }
                    }"
                    x-show="showInstallBtn"
                    x-cloak
                    class="hidden sm:flex items-center"
                >
                    <button
                        @click="installApp()"
                        class="inline-flex items-center px-4 py-2 border border-[#00B4D8]/50 text-xs font-bold rounded-full text-white bg-[#03045E] hover:bg-[#023E8A] hover:text-white focus:outline-none transition ease-in-out duration-300 shadow-md gap-1.5 active:scale-95 cursor-pointer"
                    >
                        <svg class="w-4 h-4 text-[#FFFFFF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span>Pasang Aplikasi</span>
                    </button>
                </div>

                @auth
                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open" class="flex items-center gap-2 focus:outline-none group">
                            <p class="text-[11px] font-black text-[#0F172A] group-hover:text-[#0F172A] transition-colors leading-none">{{ Auth::user()->name }}</p>

                            <div class="h-8 w-8 rounded-lg flex items-center justify-center font-bold text-xs ring-1 ring-slate-200 transition-all duration-300"
                                :class="scrolled ? 'bg-slate-50 text-[#0F172A]' : 'bg-slate-50 text-[#0F172A]'">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <svg class="w-4 h-4 transition-transform duration-300" :class="open ? 'rotate-180' : ''"
                                :style="scrolled ? 'color: #0F172A' : 'color: #0F172A'"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                            class="absolute right-0 z-[60] mt-3 w-56 rounded-xl shadow-xl border border-slate-100 bg-white overflow-hidden p-1.5"
                            style="display: none;">

                            <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 w-full px-4 py-2.5 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-[#0077B6] transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                Dashboard
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 w-full px-4 py-2.5 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-50 hover:text-[#0077B6] transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profil
                            </a>

                            <div class="h-[1px] bg-slate-100 my-1.5"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 rounded-lg text-xs font-semibold text-rose-500 hover:bg-rose-50 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="hidden sm:flex items-center gap-5">
                        <a href="{{ route('login') }}"
                           class="text-xs font-bold transition-all duration-300"
                           :class="scrolled ? 'text-slate-600 hover:text-[#03045E]' : 'text-[#64748B] hover:text-[#03045E]'">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                           class="px-6 py-2 rounded-lg font-bold text-[11px] uppercase tracking-wider transition-all duration-300 transform active:scale-95"
                           :class="scrolled ? 'bg-[#03045E] text-white shadow-lg shadow-blue-500/20 hover:bg-[#023E8A]' : 'bg-[#03045E] text-white hover:bg-[#023E8A]'">
                            Daftar
                        </a>
                    </div>
                @endauth

                <button class="md:hidden p-2 rounded-lg transition-colors duration-300"
                        @click="mobileMenu = !mobileMenu"
                        :class="scrolled || mobileMenu ? 'text-[#0F172A] hover:bg-slate-100' : 'text-[#0F172A]'"
                        aria-label="Menu Mobile">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileMenu">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileMenu" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Dropdown -->
    <div :class="{'block': mobileMenu, 'hidden': !mobileMenu}" class="hidden md:hidden bg-white border-b border-slate-100 shadow-xl transition-all duration-300">
        <div class="flex flex-col space-y-1 p-4">
            <a href="{{ route('beranda') }}" class="px-4 py-3 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-[#0077B6]" @click="mobileMenu = false">Beranda</a>
            <a href="{{ route('tentang') }}" class="px-4 py-3 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-[#0077B6]" @click="mobileMenu = false">Tentang</a>
            <a href="{{ route('fitur') }}" class="px-4 py-3 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-[#0077B6]" @click="mobileMenu = false">Fitur</a>
            <a href="{{ route('edukasi') }}" class="px-4 py-3 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-[#0077B6]" @click="mobileMenu = false">Edukasi</a>
            <a href="{{ route('profil-kebudayaan.index') }}" class="px-4 py-3 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-[#0077B6]" @click="mobileMenu = false">Profil Budaya</a>
            <a href="{{ route('kebudayaan-aktif.index') }}" class="px-4 py-3 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-[#0077B6] flex items-center gap-2" @click="mobileMenu = false">Budaya Aktif</a>


            <div class="pt-4 mt-2 border-t border-slate-100 flex flex-col space-y-3">
                <!-- PWA Install Link (Mobile) -->
                <div
                    x-data="{
                        showInstallLink: false,
                        init() {
                            if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
                                return;
                            }
                            document.addEventListener('pwa-installable', () => { this.showInstallLink = true; });
                            if (window.__pwaInstallPrompt) { this.showInstallLink = true; }
                            document.addEventListener('pwa-installed', () => { this.showInstallLink = false; });
                        },
                        installApp() {
                            if (window.__pwaInstallPrompt) {
                                window.__pwaInstallPrompt.prompt().catch(err => {
                                    console.error('[PWA] Prompt error:', err);
                                    alert('Prompt instalasi tidak dapat dimunculkan. Silakan klik ikon install (⊕) di address bar browser Anda.');
                                });
                                window.__pwaInstallPrompt.userChoice.then(choice => {
                                    if (choice.outcome === 'accepted') {
                                        this.showInstallLink = false;
                                    }
                                    window.__pwaInstallPrompt = null;
                                }).catch(err => console.error(err));
                            } else {
                                alert('Aplikasi siap diinstal. Silakan buka menu browser dan pilih \'Add to Home Screen\' atau \'Install App\'.');
                            }
                        }
                    }"
                    x-show="showInstallLink"
                    x-cloak
                >
                    <button
                        @click="installApp()"
                        class="w-full bg-[#0077B6] hover:bg-[#00B4D8] text-white py-3 rounded-lg font-bold text-sm text-center shadow-md flex items-center justify-center gap-2"
                    >
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span>Pasang Aplikasi</span>
                    </button>
                </div>

                @auth
                    <a href="{{ url('/dashboard') }}" class="bg-[#03045E] text-white py-3 rounded-lg font-bold text-sm text-center shadow-md">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-rose-500 font-semibold py-2 text-sm">Keluar Sistem</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-slate-600 font-bold py-2 text-center text-sm">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-[#03045E] text-white py-3 rounded-lg font-bold text-sm text-center shadow-md">Daftar Akun</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
