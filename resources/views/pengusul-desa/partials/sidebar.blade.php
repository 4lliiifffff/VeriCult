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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
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
                    <span class="text-slate-400 text-[10px] font-bold tracking-wider uppercase leading-none mt-1">Pengusul Desa</span>
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
            <a href="{{ route('pengusul-desa.dashboard') }}" 
               :class="sidebarMinimized ? 'justify-center !px-0' : ''"
               @class([
                   'flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group relative',
                   'bg-[#03045E]/5 text-[#03045E]' => request()->routeIs('pengusul-desa.dashboard'),
                   'text-slate-500 hover:bg-slate-50 hover:text-[#03045E]' => !request()->routeIs('pengusul-desa.dashboard')
               ])>
                <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center relative z-10">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('pengusul-desa.dashboard') ? 'text-[#03045E]' : 'text-slate-400 group-hover:text-[#03045E]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </div>
                <span x-show="!sidebarMinimized" class="ml-3 whitespace-nowrap transition-colors">Dashboard</span>
                <div x-show="sidebarMinimized" class="absolute left-full top-1/2 transform -translate-y-1/2 ml-4 px-3 py-2 bg-[#03045E] text-white text-[10px] font-black uppercase tracking-widest rounded-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-all duration-300 whitespace-nowrap z-50 shadow-2xl">Dashboard</div>
            </a>

            <!-- Usulan Saya -->
            <a href="{{ route('pengusul-desa.submissions.index') }}" 
               :class="sidebarMinimized ? 'justify-center !px-0' : ''"
               @class([
                   'flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group relative',
                   'bg-[#03045E]/5 text-[#03045E]' => request()->routeIs('pengusul-desa.submissions.*'),
                   'text-slate-500 hover:bg-slate-50 hover:text-[#03045E]' => !request()->routeIs('pengusul-desa.submissions.*')
               ])>
                <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center relative z-10">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('pengusul-desa.submissions.*') ? 'text-[#03045E]' : 'text-slate-400 group-hover:text-[#03045E]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span x-show="!sidebarMinimized" class="ml-3 whitespace-nowrap transition-colors">Usulan Saya</span>
                <div x-show="sidebarMinimized" class="absolute left-full top-1/2 transform -translate-y-1/2 ml-4 px-3 py-2 bg-[#03045E] text-white text-[10px] font-black uppercase tracking-widest rounded-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-all duration-300 whitespace-nowrap z-50 shadow-2xl">Usulan Saya</div>
            </a>

            <!-- Section Label -->
            <h3 x-show="!sidebarMinimized" class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 mt-6"
                x-transition:enter="transition ease-out duration-300 delay-100">
                Laporan & Inventarisasi
            </h3>

            <!-- Laporan OPK -->
            <a href="{{ route('pengusul-desa.opk-submissions.index') }}" 
               :class="sidebarMinimized ? 'justify-center !px-0' : ''"
               @class([
                   'flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group relative',
                   'bg-[#03045E]/5 text-[#03045E]' => request()->routeIs('pengusul-desa.opk-submissions.*'),
                   'text-slate-500 hover:bg-slate-50 hover:text-[#03045E]' => !request()->routeIs('pengusul-desa.opk-submissions.*')
               ])>
                <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center relative z-10">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('pengusul-desa.opk-submissions.*') ? 'text-[#03045E]' : 'text-slate-400 group-hover:text-[#03045E]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <span x-show="!sidebarMinimized" class="ml-3 whitespace-nowrap transition-colors">Laporan OPK</span>
                <div x-show="sidebarMinimized" class="absolute left-full top-1/2 transform -translate-y-1/2 ml-4 px-3 py-2 bg-[#03045E] text-white text-[10px] font-black uppercase tracking-widest rounded-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-all duration-300 whitespace-nowrap z-50 shadow-2xl">Laporan OPK</div>
            </a>

            <!-- Cagar Budaya -->
            <a href="{{ route('pengusul-desa.cagar-budaya-submissions.index') }}" 
               :class="sidebarMinimized ? 'justify-center !px-0' : ''"
               @class([
                   'flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group relative',
                   'bg-[#03045E]/5 text-[#03045E]' => request()->routeIs('pengusul-desa.cagar-budaya-submissions.*'),
                   'text-slate-500 hover:bg-slate-50 hover:text-[#03045E]' => !request()->routeIs('pengusul-desa.cagar-budaya-submissions.*')
               ])>
                <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center relative z-10">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('pengusul-desa.cagar-budaya-submissions.*') ? 'text-[#03045E]' : 'text-slate-400 group-hover:text-[#03045E]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <span x-show="!sidebarMinimized" class="ml-3 whitespace-nowrap transition-colors">Cagar Budaya</span>
                <div x-show="sidebarMinimized" class="absolute left-full top-1/2 transform -translate-y-1/2 ml-4 px-3 py-2 bg-[#03045E] text-white text-[10px] font-black uppercase tracking-widest rounded-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-all duration-300 whitespace-nowrap z-50 shadow-2xl">Cagar Budaya</div>
            </a>

            <!-- Potensi Kebudayaan -->
            <a href="{{ route('pengusul-desa.potensi-submissions.index') }}" 
               :class="sidebarMinimized ? 'justify-center !px-0' : ''"
               @class([
                   'flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group relative',
                   'bg-[#03045E]/5 text-[#03045E]' => request()->routeIs('pengusul-desa.potensi-submissions.*'),
                   'text-slate-500 hover:bg-slate-50 hover:text-[#03045E]' => !request()->routeIs('pengusul-desa.potensi-submissions.*')
               ])>
                <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center relative z-10">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('pengusul-desa.potensi-submissions.*') ? 'text-[#03045E]' : 'text-slate-400 group-hover:text-[#03045E]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <span x-show="!sidebarMinimized" class="ml-3 whitespace-nowrap transition-colors">Potensi Kebudayaan</span>
                <div x-show="sidebarMinimized" class="absolute left-full top-1/2 transform -translate-y-1/2 ml-4 px-3 py-2 bg-[#03045E] text-white text-[10px] font-black uppercase tracking-widest rounded-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-all duration-300 whitespace-nowrap z-50 shadow-2xl">Potensi Kebudayaan</div>
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
