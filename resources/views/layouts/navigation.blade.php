<nav x-data="{ open: false }" class="bg-[#03045E] border-b border-[#023E8A] shadow-lg sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="group">
                        <div class="flex items-center gap-2">
                             <div class="bg-gradient-to-br from-[#00B4D8] to-[#0077B6] p-1.5 rounded-lg shadow-inner group-hover:scale-105 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <span class="font-bold text-xl text-white tracking-tight group-hover:text-[#ADE8F4] transition-colors">VeriCult</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @role('super-admin')
                        <x-nav-link :href="route('super-admin_dashboard')" :active="request()->routeIs('super-admin_dashboard')" class="text-slate-300 hover:text-white focus:text-white border-transparent hover:border-[#00B4D8] focus:border-[#00B4D8]">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endrole

                    @role('validator')
                        <x-nav-link :href="route('validator_dashboard')" :active="request()->routeIs('validator_dashboard')" class="text-slate-300 hover:text-white focus:text-white border-transparent hover:border-[#00B4D8] focus:border-[#00B4D8]">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endrole

                    @role('pengusul')
                        <x-nav-link :href="route('pengusul_dashboard')" :active="request()->routeIs('pengusul_dashboard')" class="text-slate-300 hover:text-white focus:text-white border-transparent hover:border-[#00B4D8] focus:border-[#00B4D8]">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endrole
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-[#0077B6]/30 text-sm leading-4 font-medium rounded-full text-slate-200 bg-[#023E8A]/50 hover:bg-[#0077B6] hover:text-white focus:outline-none transition ease-in-out duration-150 shadow-sm backdrop-blur-sm">
                            <div class="mr-2">{{ Auth::user()->name }}</div>
                            <div class="h-6 w-6 rounded-full bg-slate-200 text-[#03045E] flex items-center justify-center text-xs font-bold ring-2 ring-[#00B4D8]/50">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="border-t-4 border-[#00B4D8] rounded-t-md"></div>
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-blue-50 text-slate-700">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" class="hover:bg-red-50 text-red-600 hover:text-red-700"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-white hover:bg-[#0077B6] focus:outline-none focus:bg-[#0077B6] focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#023E8A]">
        <div class="pt-2 pb-3 space-y-1">
            @role('super-admin')
            <x-responsive-nav-link :href="route('super-admin_dashboard')" :active="request()->routeIs('super-admin_dashboard')" class="text-slate-200 hover:text-[#00B4D8] hover:bg-[#03045E] border-l-4 border-transparent hover:border-[#00B4D8]">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @endrole

            @role('validator')
            <x-responsive-nav-link :href="route('validator_dashboard')" :active="request()->routeIs('validator_dashboard')" class="text-slate-200 hover:text-[#00B4D8] hover:bg-[#03045E] border-l-4 border-transparent hover:border-[#00B4D8]">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @endrole

            @role('pengusul')
            <x-responsive-nav-link :href="route('pengusul_dashboard')" :active="request()->routeIs('pengusul_dashboard')" class="text-slate-200 hover:text-[#00B4D8] hover:bg-[#03045E] border-l-4 border-transparent hover:border-[#00B4D8]">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @endrole
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-[#0077B6]/30">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-300">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-slate-300 hover:text-white hover:bg-[#03045E]">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" class="text-red-300 hover:text-red-100 hover:bg-red-900/20"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
