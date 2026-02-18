<x-guest-layout>
    <!-- Header with Icon -->
    <div class="mb-12 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-[#00B4D8] to-[#0077B6] rounded-3xl mb-6 shadow-2xl shadow-blue-400/20 transition-transform duration-500 hover:scale-110 group">
            <svg class="w-10 h-10 text-white group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
            </svg>
        </div>
        <h2 class="text-4xl font-black text-[#03045E] mb-3 tracking-tight leading-tight">Lupa <span class="text-[#00B4D8]">Sandi?</span></h2>
        <p class="text-slate-500 font-bold text-sm uppercase tracking-widest">Atur Ulang Akses Portal Anda</p>
    </div>

    <div class="mb-10 p-6 rounded-2xl bg-blue-50 border border-blue-100/50">
        <p class="text-xs md:text-sm text-slate-600 font-bold leading-relaxed uppercase tracking-wider text-center">
            {{ __('Lupa kata sandi? Beritahu kami alamat email Anda dan kami akan mengirimkan tautan reset kata sandi untuk membuat yang baru.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-8">
        @csrf

        <!-- Email Address -->
        <div class="group">
            <x-input-label for="email" :value="__('Email Portal')" class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1 transition-colors group-focus-within:text-[#0077B6]" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none transition-colors group-focus-within:text-[#0077B6] text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <x-text-input id="email" class="block w-full pl-14 pr-5 py-4 text-sm font-bold placeholder:text-slate-300 placeholder:font-medium" type="email" name="email" :value="old('email')" required autofocus placeholder="Masukkan email terdaftar" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit" class="w-full bg-gradient-to-br from-[#00B4D8] to-[#0077B6] hover:shadow-2xl hover:shadow-blue-400/40 text-white font-black py-5 px-6 rounded-2xl transition-all duration-300 shadow-xl shadow-blue-400/20 flex items-center justify-center group active:scale-[0.98]">
                <div class="flex items-center gap-4">
                    <span class="uppercase tracking-[0.2em] text-xs font-black">{{ __('Kirim Tautan Reset') }}</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </button>
        </div>

        <!-- Divider -->
        <div class="relative py-4">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-100"></div>
            </div>
            <div class="relative flex justify-center text-[10px] font-black uppercase tracking-[0.2em]">
                <span class="px-4 bg-white text-slate-300">Ingat Sandi Anda?</span>
            </div>
        </div>

        <!-- Login Link -->
        <div>
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center w-full border-2 border-slate-100 text-[#03045E] hover:bg-slate-50 hover:border-slate-200 font-black py-5 px-6 rounded-2xl transition-all duration-300 shadow-sm group">
                <svg class="w-5 h-5 mr-3 text-[#0077B6] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                <span class="uppercase tracking-[0.2em] text-xs">{{ __('Kembali Masuk') }}</span>
            </a>
        </div>
    </form>

    <!-- Security Badge -->
    <div class="mt-12 pt-8 border-t border-slate-50">
        <div class="flex items-center justify-center text-[10px] font-black uppercase tracking-[0.2em] text-slate-300">
            <svg class="w-4 h-4 mr-3 text-[#0077B6]" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span>High-Level Data Protection</span>
        </div>
    </div>
</x-guest-layout>
