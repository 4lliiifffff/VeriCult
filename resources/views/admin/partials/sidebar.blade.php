<aside class="fixed inset-y-0 left-0 z-50 bg-white border-r border-slate-100 transition-all duration-300 transform flex flex-col" 
       :class="[
           sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
           sidebarMinimized ? 'w-20' : 'w-64'
       ]">
    <!-- Logo/Toggle Area -->
    <div @click="toggleMinimize()" 
         class="flex items-center h-20 bg-white border-b border-slate-50 transition-all duration-300 cursor-pointer hover:bg-slate-50 group overflow-hidden relative shrink-0"
         :class="sidebarMinimized ? 'justify-center px-0' : 'justify-start px-6'">
        
        <div class="flex items-center gap-3 transition-all duration-300 transform"
             :class="sidebarMinimized ? 'scale-110' : 'scale-100'">
            <!-- Icon -->
            <div class="bg-gradient-to-br from-[#03045E] to-[#0077B6] p-2 rounded-xl shadow-lg shadow-blue-900/20 flex-shrink-0 transition-all duration-300 group-hover:scale-105">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            
            <!-- Text -->
            <div x-show="!sidebarMinimized"
                 x-transition:enter="transition ease-out duration-300 delay-100"
                 x-transition:enter-start="opacity-0 translate-x-2"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 class="whitespace-nowrap overflow-hidden flex flex-col justify-center">
                 <div class="flex flex-col">
                    <span class="font-black text-xl text-[#03045E] tracking-tight leading-none group-hover:text-[#0077B6] transition-colors">VeriCult</span>
                    <span class="text-slate-400 text-[10px] font-bold tracking-wider uppercase leading-none mt-1">Admin Wilayah</span>
                 </div>
            </div>
        </div>

        <!-- Hint Icon -->
        <div class="absolute right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-show="!sidebarMinimized">
             <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
        </div>
    </div>

    <!-- Scrollable Nav Area -->
    <div class="flex-1 overflow-y-auto custom-scrollbar overflow-x-hidden py-6">
        <nav class="px-4 space-y-2">
            <!-- Section Label -->
            <h3 x-show="!sidebarMinimized" class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 mt-2"
                x-transition:enter="transition ease-out duration-300 delay-100">
                Menu Utama
            </h3>

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               :class="sidebarMinimized ? 'justify-center !px-0' : ''"
               @class([
                   'flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group relative',
                   'bg-[#03045E]/5 text-[#03045E]' => request()->routeIs('admin.dashboard'),
                   'text-slate-500 hover:bg-slate-50 hover:text-[#03045E]' => !request()->routeIs('admin.dashboard')
               ])>
                <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center relative z-10">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('admin.dashboard') ? 'text-[#03045E]' : 'text-slate-400 group-hover:text-[#03045E]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </div>
                <span x-show="!sidebarMinimized" class="ml-3 whitespace-nowrap transition-colors">Dashboard</span>
                <div x-show="sidebarMinimized" class="absolute left-full top-1/2 transform -translate-y-1/2 ml-4 px-3 py-2 bg-[#03045E] text-white text-[10px] font-black uppercase tracking-widest rounded-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-all duration-300 whitespace-nowrap z-50 shadow-2xl">Dashboard</div>
            </a>

            <!-- User Management -->
            <a href="{{ route('admin.users.index') }}" 
               :class="sidebarMinimized ? 'justify-center !px-0' : ''"
               @class([
                   'flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group relative',
                   'bg-[#03045E]/5 text-[#03045E]' => request()->routeIs('admin.users.*'),
                   'text-slate-500 hover:bg-slate-50 hover:text-[#03045E]' => !request()->routeIs('admin.users.*')
               ])>
                <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center relative z-10">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('admin.users.*') ? 'text-[#03045E]' : 'text-slate-400 group-hover:text-[#03045E]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <span x-show="!sidebarMinimized" class="ml-3 whitespace-nowrap transition-colors">Kelola Pengguna</span>
                <div x-show="sidebarMinimized" class="absolute left-full top-1/2 transform -translate-y-1/2 ml-4 px-3 py-2 bg-[#03045E] text-white text-[10px] font-black uppercase tracking-widest rounded-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-all duration-300 whitespace-nowrap z-50 shadow-2xl">Kelola Pengguna</div>
            </a>

            <!-- Data Section -->
            <h3 x-show="!sidebarMinimized" class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 mt-6"
                x-transition:enter="transition ease-out duration-300 delay-100">
                Manajemen Data
            </h3>

            <!-- Data OPK -->
            <a href="{{ route('admin.opk-submissions.index') }}" 
               :class="sidebarMinimized ? 'justify-center !px-0' : ''"
               @class([
                   'flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group relative',
                   'bg-[#03045E]/5 text-[#03045E]' => request()->routeIs('admin.opk-submissions.*'),
                   'text-slate-500 hover:bg-slate-50 hover:text-[#03045E]' => !request()->routeIs('admin.opk-submissions.*')
               ])>
                <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center relative z-10">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('admin.opk-submissions.*') ? 'text-[#03045E]' : 'text-slate-400 group-hover:text-[#03045E]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <span x-show="!sidebarMinimized" class="ml-3 whitespace-nowrap transition-colors">Data OPK</span>
                <div x-show="sidebarMinimized" class="absolute left-full top-1/2 transform -translate-y-1/2 ml-4 px-3 py-2 bg-[#03045E] text-white text-[10px] font-black uppercase tracking-widest rounded-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-all duration-300 whitespace-nowrap z-50 shadow-2xl">Data OPK</div>
            </a>
        </nav>
    </div>

    <!-- Bottom Actions -->
    <div class="p-4 border-t border-slate-50 bg-white shrink-0">
        <a href="{{ route('beranda') }}" class="flex items-center gap-3 px-4 py-3 text-xs font-black text-slate-400 uppercase tracking-widest hover:text-[#0077B6] transition-colors group">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span x-show="!sidebarMinimized">Kembali Ke Beranda</span>
        </a>
    </div>
</aside>
