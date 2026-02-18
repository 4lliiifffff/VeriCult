<header class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40">
    <div class="flex items-center justify-between px-8 h-16">
        <!-- Sidebar Toggle (Mobile) -->
        <div class="flex items-center gap-4 lg:hidden">
            <button @click="sidebarOpen = !sidebarOpen" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-[#0077B6] hover:bg-blue-50 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Desktop Search Placeholder / Breadcrumb Info -->
        <div class="hidden lg:flex items-center gap-3">
            <div class="h-8 w-[1px] bg-slate-200 mx-2"></div>
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Sistem Monitoring Aktif</span>
        </div>

        <!-- Right Side -->
        <div class="flex items-center gap-6">
            <!-- Global Search (Visual Only) -->
            <button class="hidden sm:flex items-center gap-3 px-4 py-2 bg-slate-50/50 hover:bg-slate-50 border border-slate-100/50 rounded-2xl text-slate-400 transition-all duration-300 group">
                <svg class="w-4 h-4 group-hover:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <span class="text-xs font-bold uppercase tracking-widest leading-none">Cari...</span>
            </button>

            <!-- Notifications -->
            <button class="relative w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:text-[#0077B6] hover:bg-blue-50 transition-all duration-300 border border-slate-100 group">
                <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <span class="absolute top-2 right-2 h-2 w-2 rounded-full bg-[#00B4D8] ring-2 ring-white"></span>
            </button>

            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                <button @click="open = ! open" class="flex items-center gap-3 focus:outline-none group">
                    <div class="text-right hidden sm:block">
                        <p class="text-[11px] font-black !text-[#03045E] group-hover:text-[#0077B6] transition-colors leading-none mb-1">{{ Auth::user()->name }}</p>
                        <p class="text-[9px] font-black !text-[#00B4D8] uppercase tracking-widest leading-none">{{ Auth::user()->roles->first()->name ?? 'Administrator' }}</p>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-[#03045E] !text-white flex items-center justify-center font-black text-xs shadow-lg shadow-blue-900/10 ring-2 ring-[#03045E]/5 scale-100 group-hover:scale-110 transition-all duration-300">
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
                    class="absolute right-0 z-50 mt-4 w-56 rounded-2xl shadow-2xl shadow-blue-900/10 border border-slate-100 bg-white overflow-hidden p-2"
                    style="display: none;"
                    @click="open = false">
                    
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-start text-xs font-black uppercase tracking-widest text-slate-500 hover:bg-blue-50/80 hover:text-[#0077B6] transition-all duration-200 group/item">
                        <svg class="w-4 h-4 group-hover/item:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Pengaturan Profil
                    </a>

                    <div class="h-[1px] bg-slate-50 my-2"></div>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-start text-xs font-black uppercase tracking-widest text-rose-400 hover:bg-rose-50 hover:text-rose-500 transition-all duration-200 group/logout"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            <svg class="w-4 h-4 group-hover/logout:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Keluar Sistem
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
