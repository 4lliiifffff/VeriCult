<nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 pointer-events-none" 
     x-data="{ scrolled: false, mobileMenu: false, profileOpen: false }" 
     @scroll.window="scrolled = window.pageYOffset > 20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 pointer-events-auto">
         <div class="rounded-[2rem] transition-all duration-300 px-6 py-4 flex justify-between items-center relative"
              :class="scrolled || mobileMenu ? 'bg-[#03045E]/90 backdrop-blur-xl shadow-2xl py-3 mt-0 mb-4 border border-white/10' : 'bg-transparent border border-transparent'">
            
            <!-- Logo Section -->
            <div class="flex items-center">
                <a href="{{ route('beranda') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-[#0077B6] to-[#00B4D8] rounded-xl flex items-center justify-center shadow-lg shadow-[#0077B6]/30 group-hover:shadow-xl group-hover:scale-105 transition-all duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-black tracking-tighter text-white">Veri<span class="text-[#00B4D8]">Cult</span></span>
                </a>
            </div>
            
            <!-- Desktop Navigation (Centered) -->
            <div class="hidden md:flex items-center space-x-8 lg:space-x-10 absolute left-1/2 -translate-x-1/2">
                <a href="{{ route('beranda') }}" class="text-[10px] lg:text-xs font-black uppercase tracking-[0.2em] transition-all duration-300 hover:scale-110 text-white/90 hover:text-white"
                   :class="request()->routeIs('beranda') ? 'text-[#00B4D8]' : 'text-white/80 hover:text-white'">Beranda</a>
                <a href="{{ route('tentang') }}" class="text-[10px] lg:text-xs font-black uppercase tracking-[0.2em] transition-all duration-300 hover:scale-110 text-white/90 hover:text-white"
                   :class="request()->routeIs('tentang') ? 'text-[#00B4D8]' : 'text-white/80 hover:text-white'">Tentang</a>
                <a href="{{ route('fitur') }}" class="text-[10px] lg:text-xs font-black uppercase tracking-[0.2em] transition-all duration-300 hover:scale-110 text-white/90 hover:text-white"
                   :class="request()->routeIs('fitur') ? 'text-[#00B4D8]' : 'text-white/80 hover:text-white'">Fitur</a>
                <a href="{{ route('profil-kebudayaan.index') }}" class="text-[10px] lg:text-xs font-black uppercase tracking-[0.2em] transition-all duration-300 hover:scale-110 text-white/90 hover:text-white"
                   :class="request()->routeIs('profil-kebudayaan.*') ? 'text-[#00B4D8]' : 'text-white/80 hover:text-white'">Profil Budaya</a>
                
                @auth
                    <div class="h-6 w-[1px] bg-white/20"></div>
                    <a href="{{ url('/dashboard') }}" 
                       class="text-[10px] lg:text-xs font-black uppercase tracking-[0.25em] transition-all duration-300 hover:scale-110 group/dash flex items-center gap-2 text-white/90 hover:text-white">
                        <div class="p-1 rounded-lg bg-gradient-to-br from-[#0077B6] to-[#00B4D8] shadow-lg shadow-blue-500/20 group-hover/dash:scale-110 transition-transform">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        </div>
                        Dashboard
                    </a>
                @endauth
            </div>
            
            <!-- Right Actions Section -->
            <div class="flex items-center gap-4 md:gap-6 ml-auto">
                @auth
                    <!-- Profile Dropdown (Dashboard Style Sync) -->
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open" class="flex items-center gap-3 focus:outline-none group">
                            <div class="text-right hidden lg:block text-white">
                                <p class="text-[11px] font-black group-hover:text-[#00B4D8] transition-colors leading-none mb-1">{{ Auth::user()->name }}</p>
                                <p class="text-[9px] font-black text-[#00B4D8] uppercase tracking-[0.2em] leading-none opacity-80">Sesi Aktif</p>
                            </div>
                            <div class="h-10 w-10 rounded-xl flex items-center justify-center font-black text-xs shadow-lg ring-2 ring-white/10 scale-100 group-hover:scale-110 transition-all duration-300 bg-white text-[#03045E]">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </button>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                             class="absolute right-0 z-[60] mt-4 w-56 rounded-2xl shadow-2xl border border-slate-100 bg-white overflow-hidden p-2"
                             style="display: none;">
                            
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-start text-xs font-black uppercase tracking-widest text-slate-500 hover:bg-blue-50/80 hover:text-[#0077B6] transition-all duration-200 group/item">
                                <svg class="w-4 h-4 group-hover/item:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Pengaturan Profil
                            </a>

                            <div class="h-[1px] bg-slate-50 my-2"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-start text-xs font-black uppercase tracking-widest text-rose-400 hover:bg-rose-50 hover:text-rose-500 transition-all duration-200 group/logout">
                                    <svg class="w-4 h-4 group-hover/logout:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Keluar Sistem
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="hidden sm:flex items-center gap-4 md:gap-6">
                        <a href="{{ route('login') }}" 
                           class="text-sm font-black uppercase tracking-widest transition-all duration-300 hover:scale-110 text-white hover:text-[#ADE8F4]">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" 
                           class="px-8 py-2.5 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 transform active:scale-95 bg-white text-[#03045E] shadow-white/10">
                            Daftar
                        </a>
                    </div>
                @endauth

                <!-- Mobile Menu Button -->
                <button class="md:hidden transition-colors duration-300 p-2 rounded-xl text-white hover:bg-white/10"
                        @click="mobileMenu = !mobileMenu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileMenu">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileMenu" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Navigation Dropdown -->
            <div class="absolute top-full left-0 right-0 mt-2 p-4 bg-[#03045E]/95 backdrop-blur-xl rounded-[2rem] shadow-2xl md:hidden origin-top transition-all duration-300"
                 x-show="mobileMenu"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 x-cloak>
                <div class="flex flex-col space-y-4 p-4 text-center">
                    <a href="{{ route('beranda') }}" class="text-xs font-black uppercase tracking-widest text-white/80 hover:text-white" @click="mobileMenu = false">Beranda</a>
                    <a href="{{ route('tentang') }}" class="text-xs font-black uppercase tracking-widest text-white/80 hover:text-white" @click="mobileMenu = false">Tentang</a>
                    <a href="{{ route('fitur') }}" class="text-xs font-black uppercase tracking-widest text-white/80 hover:text-white" @click="mobileMenu = false">Fitur</a>
                    <a href="{{ route('profil-kebudayaan.index') }}" class="text-xs font-black uppercase tracking-widest text-white/80 hover:text-white" @click="mobileMenu = false">Profil Budaya</a>
                    
                    <div class="pt-4 border-t border-white/10 flex flex-col space-y-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-[#0077B6] to-[#00B4D8] text-white py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em]">Dashboard</a>
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('profile.edit') }}" class="text-[10px] font-black uppercase tracking-widest text-white/60 py-2">Pengaturan Profil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-[10px] font-black uppercase tracking-widest text-rose-400 py-2 w-full">Keluar Sistem</button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-xs font-black uppercase tracking-widest text-white">Masuk</a>
                            <a href="{{ route('register') }}" class="bg-white text-[#03045E] py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] shadow-lg">Daftar Akun</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
