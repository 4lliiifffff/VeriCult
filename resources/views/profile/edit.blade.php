@php
    $layout = 'layouts.app';
    $user = auth()->user();
    
    if ($user->hasRole('super-admin')) {
        $layout = 'layouts.super-admin';
    } elseif ($user->hasRole('admin')) {
        $layout = 'layouts.admin';
    } elseif ($user->hasRole('validator')) {
        $layout = 'layouts.validator';
    } elseif ($user->hasRole('pengusul')) {
        $layout = 'layouts.pengusul';
    } elseif ($user->hasRole('pengusul-desa')) {
        $layout = 'layouts.pengusul-desa';
    }

    $roleLabel = match(true) {
        $user->hasRole('super-admin') => 'Super Admin',
        $user->hasRole('admin') => 'Admin Wilayah',
        $user->hasRole('validator') => 'Validator',
        $user->hasRole('pengusul-desa') => 'Pengusul Desa',
        default => 'Pengusul'
    };
@endphp

<x-dynamic-component :component="$layout">
    <x-slot name="header">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-black text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-[0.2em]">
            <a href="{{ route($user->getDashboardRoute()) }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Pengaturan Profil</span>
        </nav>

        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-5 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group">
            <!-- Decorative Bubble -->
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6 sm:gap-8">
                <div class="flex items-center gap-4 sm:gap-8">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 rounded-[1.25rem] sm:rounded-[2rem] bg-[#03045E] flex items-center justify-center text-white shadow-xl shadow-blue-900/20 font-black text-xl sm:text-2xl uppercase">
                        <svg class="w-7 h-7 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <div class="space-y-1 sm:space-y-2">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="px-2.5 py-1 rounded-full text-[7px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-blue-50 text-[#0077B6] border border-blue-100">
                                {{ $roleLabel }} Portal
                            </div>
                            <div class="h-3 w-[1px] bg-slate-200"></div>
                            <span class="text-slate-400 text-[7px] sm:text-[10px] font-bold uppercase tracking-widest">Akun & Keamanan</span>
                        </div>
                        <h2 class="text-xl sm:text-4xl font-black text-[#03045E] tracking-tight leading-tight">
                            Pengaturan <span class="text-[#00B4D8]">Profil</span>
                        </h2>
                    </div>
                </div>
                
                <div class="hidden md:flex items-center gap-4 bg-slate-50 p-3 rounded-2xl border border-slate-100 shadow-inner group/status transition-all hover:bg-white hover:shadow-xl">
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#0077B6] shadow-sm transition-transform group-hover/status:rotate-12">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div class="pr-4">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Status Keamanan</p>
                        <p class="text-[11px] font-black text-[#03045E] uppercase tracking-wider leading-none">Terlindungi</p>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div x-data="{ tab: 'profile' }" class="flex flex-col lg:flex-row gap-8 py-8 md:py-12 pb-24">
        <!-- Tab Sidebar -->
        <div class="w-full lg:w-80 shrink-0 space-y-4">
            <button @click="tab = 'profile'" 
                    :class="tab === 'profile' ? 'bg-white shadow-xl shadow-blue-900/10 text-[#0077B6] border-blue-100' : 'text-slate-500 hover:bg-white hover:shadow-lg border-transparent opacity-60 hover:opacity-100'"
                    class="w-full flex items-center gap-5 px-6 py-5 rounded-[2rem] border transition-all duration-500 group relative overflow-hidden">
                <div x-show="tab === 'profile'" class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#0077B6]"></div>
                <div :class="tab === 'profile' ? 'bg-[#0077B6] text-white shadow-lg shadow-blue-900/20' : 'bg-slate-100 text-slate-400 group-hover:bg-blue-50 group-hover:text-[#0077B6]'"
                     class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all duration-500 group-hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div class="text-left leading-tight">
                    <p class="text-base font-black tracking-tight">Informasi Profil</p>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">Identitas Publik</p>
                </div>
            </button>

            <button @click="tab = 'security'" 
                    :class="tab === 'security' ? 'bg-white shadow-xl shadow-indigo-900/10 text-indigo-600 border-indigo-100' : 'text-slate-500 hover:bg-white hover:shadow-lg border-transparent opacity-60 hover:opacity-100'"
                    class="w-full flex items-center gap-5 px-6 py-5 rounded-[2rem] border transition-all duration-500 group relative overflow-hidden">
                <div x-show="tab === 'security'" class="absolute left-0 top-0 bottom-0 w-1.5 bg-indigo-600"></div>
                <div :class="tab === 'security' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'bg-slate-100 text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-600'"
                     class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all duration-500 group-hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <div class="text-left leading-tight">
                    <p class="text-base font-black tracking-tight">Keamanan Akun</p>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">Kata Sandi</p>
                </div>
            </button>

            <button @click="tab = 'delete'" 
                    :class="tab === 'delete' ? 'bg-white shadow-xl shadow-rose-900/10 text-rose-600 border-rose-100' : 'text-slate-500 hover:bg-white hover:shadow-lg border-transparent opacity-60 hover:opacity-100'"
                    class="w-full flex items-center gap-5 px-6 py-5 rounded-[2rem] border transition-all duration-500 group relative overflow-hidden">
                <div x-show="tab === 'delete'" class="absolute left-0 top-0 bottom-0 w-1.5 bg-rose-600"></div>
                <div :class="tab === 'delete' ? 'bg-rose-600 text-white shadow-lg shadow-rose-900/20' : 'bg-slate-100 text-slate-400 group-hover:bg-rose-50 group-hover:text-rose-600'"
                     class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all duration-500 group-hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </div>
                <div class="text-left leading-tight">
                    <p class="text-base font-black tracking-tight">Hapus Akun</p>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">Zona Berbahaya</p>
                </div>
            </button>
        </div>

        <!-- Tab Content -->
        <div class="flex-1 min-w-0">
            <div x-show="tab === 'profile'" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-8"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="bg-white rounded-[2.5rem] sm:rounded-[3rem] p-6 sm:p-14 shadow-xl shadow-slate-200/40 border border-slate-100 relative overflow-hidden">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-blue-50/50 rounded-full blur-3xl"></div>
                <div class="max-w-3xl relative z-10">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div x-show="tab === 'security'" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-8"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="bg-white rounded-[2.5rem] sm:rounded-[3rem] p-6 sm:p-14 shadow-xl shadow-slate-200/40 border border-slate-100 relative overflow-hidden"
                 style="display: none;">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-50/50 rounded-full blur-3xl"></div>
                <div class="max-w-3xl relative z-10">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div x-show="tab === 'delete'" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-8"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="bg-white rounded-[2.5rem] sm:rounded-[3rem] p-6 sm:p-14 shadow-xl shadow-slate-200/40 border border-rose-50 relative overflow-hidden"
                 style="display: none;">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-rose-50/50 rounded-full blur-3xl"></div>
                <div class="max-w-3xl relative z-10">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>
