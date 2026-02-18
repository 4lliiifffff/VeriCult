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
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-br from-[#00B4D8] to-[#0077B6] p-2 rounded-xl shadow-lg shadow-blue-200">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h2 class="font-bold text-2xl text-[#03045E] leading-tight">
                {{ __('Pengaturan Profil') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Profile Info Section -->
            <div class="bg-white overflow-hidden shadow-sm border border-slate-100 rounded-3xl transition-all duration-300 hover:shadow-md">
                <div class="p-6 sm:p-10">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <!-- Password Update Section -->
            <div class="bg-white overflow-hidden shadow-sm border border-slate-100 rounded-3xl transition-all duration-300 hover:shadow-md">
                <div class="p-6 sm:p-10">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Delete Account Section -->
            <div class="bg-white overflow-hidden shadow-sm border border-red-50 rounded-3xl transition-all duration-300 hover:shadow-md">
                <div class="p-6 sm:p-10">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dynamic-component>
