<aside class="fixed inset-y-0 left-0 z-50 bg-[#03045E] shadow-2xl transition-all duration-300 transform flex flex-col" 
       :class="[
           sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
           sidebarMinimized ? 'w-20' : 'w-64'
       ]">
    <!-- Logo/Toggle Area -->
    <div @click="toggleMinimize()" 
         class="flex items-center h-16 bg-[#023E8A] border-b border-[#0077B6]/30 transition-all duration-300 cursor-pointer hover:bg-[#0077B6]/20 group overflow-hidden relative shrink-0"
         :class="sidebarMinimized ? 'justify-center px-0' : 'justify-start px-6'">
        
        <div class="flex items-center gap-3 transition-all duration-300 transform"
             :class="sidebarMinimized ? 'scale-110' : 'scale-100'">
            <!-- Icon -->
            <div class="bg-gradient-to-br from-[#00B4D8] to-[#0077B6] p-1.5 rounded-lg shadow-inner flex-shrink-0 transition-all duration-300 group-hover:shadow-lg group-hover:from-[#48CAE4] group-hover:to-[#0096C7]">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </div>
            
            <!-- Text -->
            <div x-show="!sidebarMinimized"
                 x-transition:enter="transition ease-out duration-300 delay-100"
                 class="whitespace-nowrap overflow-hidden flex flex-col justify-center ml-2">
                 <div class="flex flex-col">
                    <span class="font-bold text-xl text-white tracking-tight leading-none group-hover:text-[#ADE8F4] transition-colors">VeriCult</span>
                    <span class="text-[#48CAE4] text-[10px] font-medium tracking-wider uppercase leading-none mt-0.5">Pengusul</span>
                 </div>
            </div>
        </div>
    </div>

    <!-- Scrollable Nav Area -->
    <div class="flex-1 overflow-y-auto custom-scrollbar overflow-x-hidden py-8">
        <!-- Nav Links -->
        <nav class="px-4 space-y-3">
            <!-- Section Label -->
            <h3 x-show="!sidebarMinimized" class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4"
                x-transition:enter="transition ease-out duration-300 delay-100"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100">
                Main Navigation
            </h3>

            <!-- Dashboard -->
            <a href="{{ route('pengusul.dashboard') }}" 
               @click="sidebarOpen = false"
               :class="sidebarMinimized ? 'justify-center !px-0' : ''"
               @class([
                   'flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group relative',
                   'bg-gradient-to-r from-[#03045E] to-[#0077B6] text-white shadow-lg shadow-blue-500/20' => request()->routeIs('pengusul.dashboard'),
                   'text-slate-300 hover:bg-white/5 hover:text-white' => !request()->routeIs('pengusul.dashboard')
               ])>
                
                <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center relative z-10">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('pengusul.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </div>
                
                <span x-show="!sidebarMinimized"
                      x-transition:enter="transition ease-out duration-300 delay-100"
                      x-transition:enter-start="opacity-0 translate-x-2"
                      x-transition:enter-end="opacity-100 translate-x-0"
                      class="ml-3 whitespace-nowrap relative z-10">
                    Dashboard
                </span>

                @if(request()->routeIs('pengusul.dashboard'))
                    <div class="absolute right-0 top-0 bottom-0 w-1 bg-white rounded-l-full"></div>
                @endif
                
                <!-- Tooltip -->
                <div x-show="sidebarMinimized" class="absolute left-full top-1/2 transform -translate-y-1/2 ml-4 px-3 py-2 bg-[#03045E] border border-[#0077B6]/30 text-white text-[10px] font-black uppercase tracking-widest rounded-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-all duration-300 whitespace-nowrap z-50 shadow-2xl">
                    Dashboard
                </div>
            </a>

            <!-- Usulan Saya -->
            <a href="{{ route('pengusul.submissions.index') }}" 
               @click="sidebarOpen = false"
               :class="sidebarMinimized ? 'justify-center !px-0' : ''"
               @class([
                   'flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 group relative',
                   'bg-gradient-to-r from-[#03045E] to-[#0077B6] text-white shadow-lg shadow-blue-500/20' => request()->routeIs('pengusul.submissions.*'),
                   'text-slate-300 hover:bg-white/5 hover:text-white' => !request()->routeIs('pengusul.submissions.*')
               ])>
                
                <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center relative z-10">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('pengusul.submissions.*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                
                <span x-show="!sidebarMinimized"
                      x-transition:enter="transition ease-out duration-300 delay-100"
                      x-transition:enter-start="opacity-0 translate-x-2"
                      x-transition:enter-end="opacity-100 translate-x-0"
                      class="ml-3 whitespace-nowrap relative z-10">
                    Usulan Saya
                </span>

                @if(request()->routeIs('pengusul.submissions.*'))
                    <div class="absolute right-0 top-0 bottom-0 w-1 bg-white rounded-l-full"></div>
                @endif

                <!-- Tooltip -->
                <div x-show="sidebarMinimized" class="absolute left-full top-1/2 transform -translate-y-1/2 ml-4 px-3 py-2 bg-[#03045E] border border-[#0077B6]/30 text-white text-[10px] font-black uppercase tracking-widest rounded-xl opacity-0 group-hover:opacity-100 pointer-events-none transition-all duration-300 whitespace-nowrap z-50 shadow-2xl">
                    Usulan Saya
                </div>
            </a>
        </nav>
    </div>
</aside>
