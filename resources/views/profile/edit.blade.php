@php
    $layout = 'app-layout';
    if (auth()->user()->hasRole('super-admin')) {
        $layout = 'layouts.super-admin';
    } elseif (auth()->user()->hasRole('validator')) {
        $layout = 'layouts.validator';
    } elseif (auth()->user()->hasRole('pengusul')) {
        $layout = 'layouts.pengusul';
    }
@endphp

<x-dynamic-component :component="$layout">
    <x-slot name="header">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route(auth()->user()->getDashboardRoute()) }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Pengaturan Profil</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 bg-gradient-to-br from-[#00B4D8] to-[#0077B6] rounded-[1.25rem] flex items-center justify-center text-white shadow-xl shadow-blue-400/20">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-black text-4xl text-[#03045E] leading-tight tracking-tight">
                        Pengaturan <span class="text-[#0077B6]">Profil</span>
                    </h2>
                    <p class="text-slate-500 font-bold text-sm">Kelola informasi akun dan preferensi keamanan Anda</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 pb-24">
        <div class="max-w-4xl mx-auto space-y-12">
            <!-- Profile Info Section -->
            <div class="bg-white rounded-[3rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden transition-all duration-500 hover:shadow-2xl hover:shadow-slate-300/50">
                <div class="p-10 sm:p-14">
                    <div class="max-w-2xl mx-auto">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <!-- Password Update Section -->
            <div class="bg-white rounded-[3rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden transition-all duration-500 hover:shadow-2xl hover:shadow-slate-300/50">
                <div class="p-10 sm:p-14">
                    <div class="max-w-2xl mx-auto">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Delete Account Section -->
            <div class="bg-white rounded-[3rem] shadow-xl shadow-slate-200/50 border border-rose-50 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:shadow-rose-100/50 group">
                <div class="p-10 sm:p-14">
                    <div class="max-w-2xl mx-auto">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>
