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
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <!-- Text -->
            <div x-show="!sidebarMinimized"
                 x-transition:enter="transition ease-out duration-300 delay-100"
                 class="whitespace-nowrap overflow-hidden flex flex-col justify-center ml-2">
                 <div class="flex flex-col">
                    <span class="font-bold text-xl text-white tracking-tight leading-none group-hover:text-[#ADE8F4] transition-colors">VeriCult</span>
                    <span class="text-[#48CAE4] text-[10px] font-medium tracking-wider uppercase leading-none mt-0.5">Validator</span>
                 </div>
            </div>
        </div>
    </div>

    <!-- Nav Links -->
    <nav class="mt-5 px-3 space-y-2">
        <!-- Dashboard -->
        <a href="{{ route('validator_dashboard') }}" 
           @click="sidebarOpen = false"
           :class="sidebarMinimized ? 'justify-center !px-0' : ''"
           @class([
               'flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 group relative',
               'bg-[#0077B6] text-white shadow-lg shadow-blue-900/50' => request()->routeIs('validator_dashboard'),
               'text-slate-100 hover:bg-white/5 hover:text-white' => !request()->routeIs('validator_dashboard')
           ])>
            
            <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center">
                <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('validator_dashboard') ? 'text-white' : 'text-slate-300 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
            </div>
            
            <span x-show="!sidebarMinimized"
                  class="ml-3 whitespace-nowrap !text-white">
                Dashboard
            </span>
             <div x-show="sidebarMinimized" class="absolute left-full top-1/2 transform -translate-y-1/2 ml-2 px-2 py-1 bg-slate-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 whitespace-nowrap z-50">
                Dashboard
            </div>
        </a>

        <!-- Validasi (Placeholder) -->
         <a href="#" 
           @click="sidebarOpen = false"
           :class="sidebarMinimized ? 'justify-center !px-0' : ''"
           @class([
               'flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 group relative',
               'text-slate-100 hover:bg-white/5 hover:text-white' => true
           ])>
            
            <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center">
                 <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 text-slate-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            
            <span x-show="!sidebarMinimized"
                  class="ml-3 whitespace-nowrap !text-white">
                Validasi Objek
            </span>
             <div x-show="sidebarMinimized" class="absolute left-full top-1/2 transform -translate-y-1/2 ml-2 px-2 py-1 bg-slate-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 whitespace-nowrap z-50">
                Validasi Objek
            </div>
        </a>
    </nav>
</aside>
