<header class="bg-white border-b border-slate-100 sticky top-0 z-40 transition-all duration-300 shadow-sm">
    <div class="flex items-center justify-between px-4 sm:px-10 h-20">
        <!-- Sidebar Toggle (Mobile) -->
        <div class="flex items-center gap-4 lg:hidden">
            <button @click="sidebarOpen = !sidebarOpen" class="w-11 h-11 flex items-center justify-center rounded-2xl bg-slate-50 text-[#03045E] hover:bg-blue-50 transition-all border border-slate-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Left Side: Status / Breadcrumbs -->
        <div class="hidden lg:flex items-center gap-4">
            <!-- <div class="flex items-center gap-2 px-3 py-1.5 bg-green-50 text-green-600 rounded-full border border-green-100">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span class="text-[10px] font-black uppercase tracking-widest">Sistem Aktif</span>
            </div>
            <div class="h-6 w-[1px] bg-slate-100"></div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Pusat Kendali VeriCult</span> -->
        </div>

        <!-- Right Side -->
        <div class="flex items-center gap-3 sm:gap-6">
            <!-- Global Search -->
            <!-- <button class="hidden sm:flex items-center gap-4 px-6 py-2.5 bg-slate-50/50 hover:bg-white border border-slate-100 rounded-2xl text-slate-400 transition-all duration-300 group shadow-sm hover:shadow-md active:scale-95">
                <svg class="w-4 h-4 group-hover:text- transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <span class="text-[10px] font-black uppercase tracking-[0.2em] leading-none">Pencarian Global</span>
            </button> -->

            <!-- Notifications -->
            <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                <button @click="open = ! open" class="relative w-11 h-11 flex items-center justify-center rounded-2xl bg-white text-slate-400 hover:text-[#0077B6] transition-all duration-300 border border-slate-100 group shadow-sm hover:shadow-md active:scale-95">
                    <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <span class="absolute top-2.5 right-2.5 h-3.5 min-w-[14px] px-1 bg-rose-500 text-white text-[8px] font-black rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                            {{ Auth::user()->unreadNotifications->count() > 9 ? '9+' : Auth::user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </button>

                <div x-show="open"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                    class="fixed sm:absolute top-20 sm:top-auto inset-x-4 sm:inset-x-auto sm:right-0 z-50 mt-4 sm:w-80 rounded-3xl shadow-2xl border border-slate-50 bg-white overflow-hidden ring-1 ring-slate-900/5">

                    <!-- Header -->
                    <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                        <h3 class="text-[10px] font-black text-[#03045E] uppercase tracking-[0.2em]">Notifikasi</h3>
                        <a href="{{ route('super-admin.notifications.index') }}" class="text-[9px] font-black text-[#0077B6] uppercase tracking-[0.2em] hover:underline">Lihat Semua</a>
                    </div>

                    <div class="max-h-80 overflow-y-auto custom-scrollbar">
                        @php
                            $allNotifications = Auth::user()->notifications;
                            $previewNotifications = Auth::user()->notifications()->latest()->take(5)->get();
                        @endphp

                        @forelse($previewNotifications as $notification)
                            <a href="{{ route('super-admin.notifications.read-and-redirect', $notification->id) }}" class="block p-5 hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0 group/notif {{ !$notification->read_at ? 'bg-indigo-50/30' : '' }}">
                                <p class="text-[11px] font-black {{ $notification->read_at ? 'text-[#03045E]' : 'text-[#0077B6]' }} mb-1 group-hover/notif:text-[#03045E] transition-colors">{{ $notification->data['title'] }}</p>
                                <p class="text-[10px] text-slate-400 line-clamp-2 leading-relaxed font-medium">{{ $notification->data['message'] }}</p>
                                <p class="text-[8px] text-slate-300 mt-2.5 font-bold uppercase tracking-widest">{{ $notification->created_at->diffForHumans() }}</p>
                            </a>
                        @empty
                            <div class="p-12 text-center flex flex-col items-center">
                                <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-200 mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                </div>
                                <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest italic">Belum ada notifikasi</p>
                            </div>
                        @endforelse
                    </div>

                    @if($allNotifications->isNotEmpty())
                        <div class="p-4 bg-slate-50 border-t border-slate-50">
                            <form action="{{ route('super-admin.notifications.mark-all-read') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-2.5 text-[8px] font-black text-white bg-[#03045E] hover:bg-[#0077B6] uppercase tracking-[0.2em] rounded-2xl transition-all shadow-lg shadow-blue-900/10 flex items-center justify-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    Baca Semua
                                </button>
                            </form>
                        </div>
                    @elseif(Auth::user()->unreadNotifications->count() > 0)
                        <div class="p-4 bg-slate-50 border-t border-slate-50">
                            <form action="{{ route('super-admin.notifications.mark-all-read') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-3 text-[9px] font-black text-white bg-[#03045E] hover:bg-[#0077B6] uppercase tracking-[0.2em] rounded-2xl transition-all shadow-lg shadow-blue-900/10">
                                    Tandai Terbaca
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                <button @click="open = ! open" class="flex items-center gap-4 focus:outline-none group">
                    <div class="text-right hidden sm:block">
                        <p class="text-[11px] font-black text-[#03045E] group-hover:text-[#0077B6] transition-colors leading-none mb-1.5">{{ Auth::user()->name }}</p>
                        <span class="inline-block px-2 py-0.5 bg-blue-50 text-[#0077B6] text-[8px] font-black uppercase tracking-widest rounded-md border border-blue-100">Super Admin</span>
                    </div>
                    <div class="relative">
                        <div class="h-11 w-11 rounded-2xl bg-[#03045E] text-white flex items-center justify-center font-black text-xs shadow-xl shadow-blue-900/10 scale-100 group-hover:scale-110 transition-all duration-300 ring-4 ring-white">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </button>

                <div x-show="open"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                    class="absolute right-0 z-[60] mt-4 w-60 rounded-3xl shadow-2xl border border-slate-50 bg-white overflow-hidden p-2 ring-1 ring-slate-900/5">

                    <div class="px-4 py-3 mb-1 border-b border-slate-50">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Sesi Masuk</p>
                        <p class="text-[10px] font-bold text-[#03045E] truncate">{{ Auth::user()->email }}</p>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 w-full px-4 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-600 hover:bg-slate-50 hover:text-[#0077B6] transition-all group/item">
                        <svg class="w-4 h-4 text-slate-400 group-hover/item:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Edit Profil
                    </a>

                    <div class="h-[1px] bg-slate-50 my-1"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest text-rose-500 hover:bg-rose-50 transition-all group/logout">
                            <svg class="w-4 h-4 group-hover/logout:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Keluar Sistem
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
