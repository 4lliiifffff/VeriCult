<aside class="fixed inset-y-0 left-0 z-50 bg-[#03045E] shadow-2xl transition-all duration-300 transform" 
       :class="[
           sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
           sidebarMinimized ? 'w-20' : 'w-64'
       ]">
    <!-- Logo/Toggle Area -->
    <div @click="toggleMinimize()" 
         class="flex items-center h-16 bg-[#023E8A] border-b border-[#0077B6]/30 transition-all duration-300 cursor-pointer hover:bg-[#0077B6]/20 group overflow-hidden relative"
         :class="sidebarMinimized ? 'justify-center px-0' : 'justify-start px-6'">
        
        <div class="flex items-center gap-3 transition-all duration-300 transform"
             :class="sidebarMinimized ? 'scale-110' : 'scale-100'">
            <!-- Icon -->
            <div class="bg-gradient-to-br from-[#00B4D8] to-[#0077B6] p-1.5 rounded-lg shadow-inner flex-shrink-0 transition-all duration-300 group-hover:shadow-lg group-hover:from-[#48CAE4] group-hover:to-[#0096C7]">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            
            <!-- Text -->
            <div x-show="!sidebarMinimized"
                 x-transition:enter="transition ease-out duration-300 delay-100"
                 x-transition:enter-start="opacity-0 translate-x-2"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 translate-x-2"
                 class="whitespace-nowrap overflow-hidden flex flex-col justify-center ml-2">
                 <div class="flex flex-col">
                    <span class="font-bold text-xl text-white tracking-tight leading-none group-hover:text-[#ADE8F4] transition-colors">VeriCult</span>
                    <span class="text-[#48CAE4] text-[10px] font-medium tracking-wider uppercase leading-none mt-0.5">Super Admin</span>
                 </div>
            </div>
        </div>

        <!-- Hint Icon (Optional, appears on hover to suggest clickable) -->
        <div class="absolute right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-show="!sidebarMinimized">
             <svg class="w-4 h-4 text-[#48CAE4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
        </div>
    </div>

    <!-- Nav Links -->
    <nav class="mt-8 px-4 space-y-3">
        <!-- Section Label -->
        <h3 x-show="!sidebarMinimized" class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4"
            x-transition:enter="transition ease-out duration-300 delay-100"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            Menu Utama
        </h3>

        <!-- Dashboard -->
        <a href="{{ route('super-admin.dashboard') }}" 
           @click="sidebarOpen = false"
           :class="sidebarMinimized ? 'justify-center !px-0' : ''"
           @class([
               'flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group relative overflow-hidden',
               'bg-gradient-to-r from-[#0077B6] to-[#00B4D8] text-white shadow-lg shadow-blue-500/20' => request()->routeIs('super-admin.dashboard'),
               'text-slate-300 hover:bg-white/5 hover:text-white' => !request()->routeIs('super-admin.dashboard')
           ])>
            
            <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center relative z-10">
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('super-admin.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
            </div>
            
            <span x-show="!sidebarMinimized"
                  x-transition:enter="transition ease-out duration-300 delay-100"
                  x-transition:enter-start="opacity-0 translate-x-2"
                  x-transition:enter-end="opacity-100 translate-x-0"
                  class="ml-3 whitespace-nowrap relative z-10 transition-colors">
                Dashboard 
            </span>

            @if(request()->routeIs('super-admin.dashboard'))
                <div class="absolute right-0 top-0 bottom-0 w-1 bg-white rounded-l-full"></div>
            @endif
            
            <!-- Tooltip for minimized state -->
            <div x-show="sidebarMinimized" class="absolute left-full top-1/2 transform -translate-y-1/2 ml-4 px-3 py-2 bg-[#03045E] border border-[#0077B6]/30 text-white text-[10px] font-black uppercase tracking-widest rounded-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-all duration-300 whitespace-nowrap z-50 shadow-2xl">
                Dashboard
            </div>
        </a>

        <!-- User Management -->
        <a href="{{ route('super-admin.users.index') }}" 
           @click="sidebarOpen = false"
           :class="sidebarMinimized ? 'justify-center !px-0' : ''"
           @class([
               'flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group relative overflow-hidden',
               'bg-gradient-to-r from-[#0077B6] to-[#00B4D8] text-white shadow-lg shadow-blue-500/20' => request()->routeIs('super-admin.users.*'),
               'text-slate-300 hover:bg-white/5 hover:text-white' => !request()->routeIs('super-admin.users.*')
           ])>
            
            <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center relative z-10">
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('super-admin.users.*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>

            <span x-show="!sidebarMinimized"
                  x-transition:enter="transition ease-out duration-300 delay-100"
                  x-transition:enter-start="opacity-0 translate-x-2"
                  x-transition:enter-end="opacity-100 translate-x-0"
                  class="ml-3 whitespace-nowrap relative z-10 transition-colors">
                Kelola Pengguna
            </span>

            @if(request()->routeIs('super-admin.users.*'))
                <div class="absolute right-0 top-0 bottom-0 w-1 bg-white rounded-l-full"></div>
            @endif

             <div x-show="sidebarMinimized" class="absolute left-full top-1/2 transform -translate-y-1/2 ml-4 px-3 py-2 bg-[#03045E] border border-[#0077B6]/30 text-white text-[10px] font-black uppercase tracking-widest rounded-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-all duration-300 whitespace-nowrap z-50 shadow-2xl">
                Kelola Pengguna
            </div>
        </a>

        <!-- Audit Logs -->
        <a href="{{ route('super-admin.audit-logs.index') }}" 
           @click="sidebarOpen = false"
           :class="sidebarMinimized ? 'justify-center !px-0' : ''"
           @class([
               'flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group relative overflow-hidden',
               'bg-gradient-to-r from-[#0077B6] to-[#00B4D8] text-white shadow-lg shadow-blue-500/20' => request()->routeIs('super-admin.audit-logs.*'),
               'text-slate-300 hover:bg-white/5 hover:text-white' => !request()->routeIs('super-admin.audit-logs.*')
           ])>
            
            <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center relative z-10">
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('super-admin.audit-logs.*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>

            <span x-show="!sidebarMinimized"
                  x-transition:enter="transition ease-out duration-300 delay-100"
                  x-transition:enter-start="opacity-0 translate-x-2"
                  x-transition:enter-end="opacity-100 translate-x-0"
                  class="ml-3 whitespace-nowrap relative z-10 transition-colors">
                Log Audit
            </span>

            @if(request()->routeIs('super-admin.audit-logs.*'))
                <div class="absolute right-0 top-0 bottom-0 w-1 bg-white rounded-l-full"></div>
            @endif

             <div x-show="sidebarMinimized" class="absolute left-full top-1/2 transform -translate-y-1/2 ml-4 px-3 py-2 bg-[#03045E] border border-[#0077B6]/30 text-white text-[10px] font-black uppercase tracking-widest rounded-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-all duration-300 whitespace-nowrap z-50 shadow-2xl">
                Log Audit
            </div>
        </a>
    </nav>
</aside>
