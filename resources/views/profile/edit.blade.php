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
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route($user->getDashboardRoute()) }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Pengaturan Profil</span>
        </nav>

        <div class="relative mb-8 bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-8 overflow-hidden shadow-2xl shadow-blue-900/20">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.2em] uppercase bg-white/10 text-white border border-white/20 backdrop-blur-xl">
                            E-Profil {{ $roleLabel }}
                        </span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight">
                        Pengaturan <span class="text-[#00B4D8]">Profil</span>
                    </h2>
                    <p class="text-blue-100/70 text-base sm:text-lg font-medium break-words">Kelola informasi identitas dan kredensial keamanan akun {{ strtolower($roleLabel) }} Anda.</p>
                </div>

                <div class="flex items-center gap-4 bg-white/10 backdrop-blur-xl p-3 sm:p-4 rounded-2xl border border-white/20 shadow-inner w-full md:w-auto mt-4 md:mt-0">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-white backdrop-blur-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div x-data="{ tab: 'profile' }" class="flex flex-col lg:flex-row gap-8 py-8 md:py-12 pb-24">
        <!-- Tab Sidebar -->
        <div class="w-full lg:w-80 shrink-0 space-y-3">
            <button @click="tab = 'profile'" 
                    :class="tab === 'profile' ? 'bg-white shadow-xl shadow-blue-900/10 text-[#0077B6] border-blue-100' : 'text-slate-500 hover:bg-white/50 border-transparent'"
                    class="w-full flex items-center gap-4 px-6 py-5 rounded-[2rem] border transition-all duration-300 group">
                <div :class="tab === 'profile' ? 'bg-[#0077B6] text-white shadow-lg shadow-blue-900/20' : 'bg-slate-100 text-slate-400 group-hover:bg-blue-50 group-hover:text-[#0077B6]'"
                     class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div class="text-left leading-tight">
                    <p class="text-base font-black tracking-tight">Informasi Profil</p>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">Identitas Publik</p>
                </div>
            </button>

            <button @click="tab = 'security'" 
                    :class="tab === 'security' ? 'bg-white shadow-xl shadow-blue-900/10 text-indigo-600 border-indigo-100' : 'text-slate-500 hover:bg-white/50 border-transparent'"
                    class="w-full flex items-center gap-4 px-6 py-5 rounded-[2rem] border transition-all duration-300 group">
                <div :class="tab === 'security' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'bg-slate-100 text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-600'"
                     class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <div class="text-left leading-tight">
                    <p class="text-base font-black tracking-tight">Keamanan Akun</p>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">Kata Sandi</p>
                </div>
            </button>

            <button @click="tab = 'delete'" 
                    :class="tab === 'delete' ? 'bg-white shadow-xl shadow-rose-900/10 text-rose-600 border-rose-100' : 'text-slate-500 hover:bg-rose-50/50 border-transparent'"
                    class="w-full flex items-center gap-4 px-6 py-5 rounded-[2rem] border transition-all duration-300 group">
                <div :class="tab === 'delete' ? 'bg-rose-600 text-white shadow-lg shadow-rose-900/20' : 'bg-slate-100 text-slate-400 group-hover:bg-rose-100 group-hover:text-rose-600'"
                     class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </div>
                <div class="text-left leading-tight">
                    <p class="text-base font-black tracking-tight">Hapus Akun</p>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mt-1">Zona Berbahaya</p>
                </div>
            </button>
        </div>

        <!-- Tab Content -->
        <div class="flex-1 space-y-8 min-w-0">
            <div x-show="tab === 'profile'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="bg-white rounded-[3rem] p-8 sm:p-14 shadow-xl shadow-slate-200/40 border border-white">
                <div class="max-w-3xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div x-show="tab === 'security'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="bg-white rounded-[3rem] p-8 sm:p-14 shadow-xl shadow-slate-200/40 border border-white"
                 style="display: none;">
                <div class="max-w-3xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div x-show="tab === 'delete'" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="bg-white rounded-[3rem] p-8 sm:p-14 shadow-xl shadow-slate-200/40 border border-rose-50"
                 style="display: none;">
                <div class="max-w-3xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>
