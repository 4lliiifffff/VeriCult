<header class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40">
    <div class="flex items-center justify-between px-6 py-3">
        <!-- Sidebar Toggle (Mobile) -->
        <div class="flex items-center gap-2">
            <button @click="sidebarOpen = !sidebarOpen" class="!text-[#0077B6] hover:text-[#023E8A] focus:outline-none lg:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Right Side -->
        <div class="flex items-center w-full justify-end gap-4">
            <!-- Notifications (Optional Placeholder) -->
            <button class="relative p-2 !text-[#0077B6] hover:text-[#023E8A] transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                 <span class="absolute top-1.5 right-1.5 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
            </button>

            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                <div @click="open = ! open">
                    <button class="flex items-center gap-3 focus:outline-none group">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold !text-[#0077B6] group-hover:text-[#0096C7] transition-colors">{{ Auth::user()->name }}</p>
                            <p class="text-xs !text-[#0096C7] font-medium">Super Admin</p>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-slate-200/50 !text-[#03045E] flex items-center justify-center font-bold ring-2 ring-slate-100 group-hover:ring-[#00B4D8] transition-all">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </button>
                </div>

                <div x-show="open"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 z-50 mt-2 w-48 rounded-xl shadow-[0_10px_40px_-5px_rgba(0,0,0,0.15)] border border-slate-200 bg-white"
                    style="display: none;"
                    @click="open = false">
                    
                        <div class="px-4 py-3 border-b border-slate-50 mb-1">
                            <p class="text-xs font-bold !text-[#0077B6] uppercase tracking-wider">Account</p>
                        </div>

                    <a href="{{ route('profile.edit') }}" class="block w-full px-4 py-2.5 text-start text-sm leading-5 text-slate-600 hover:bg-blue-50/80 hover:text-[#0077B6] transition duration-150 ease-in-out">
                        {{ __('Profile') }}
                    </a>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="block w-full px-4 py-2.5 text-start text-sm leading-5 text-red-500 hover:bg-red-50/80 hover:text-red-600 transition duration-150 ease-in-out"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
