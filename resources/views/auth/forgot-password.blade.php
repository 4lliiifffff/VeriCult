<x-guest-layout>
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-[#03045E] mb-3 tracking-tight">Lupa Sandi?</h2>
        <p class="text-slate-500 text-sm font-medium">Atur ulang akses portal Anda</p>
    </div>

    <div class="mb-8 p-6 rounded-2xl bg-[#90E0EF]/10 border border-[#90E0EF]/20">
        <p class="text-xs text-slate-600 font-medium leading-relaxed text-center">
            {{ __('Beritahu kami alamat email Anda dan kami akan mengirimkan tautan reset kata sandi untuk membuat yang baru.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email')" class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1" />
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#0077B6] transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <input id="email" 
                       type="email" 
                       name="email" 
                       :value="old('email')" 
                       required 
                       autofocus 
                       placeholder="Masukkan email terdaftar"
                       class="block w-full pl-12 pr-4 py-4 bg-slate-50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all placeholder:text-slate-300" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit" class="w-full bg-[#03045E] hover:bg-[#0077B6] text-white font-bold py-4 px-6 rounded-2xl transition-all duration-300 shadow-xl shadow-blue-900/10 flex items-center justify-center gap-3 group">
                <span class="uppercase tracking-widest text-xs font-bold">{{ __('Kirim Tautan Reset') }}</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </button>
        </div>

        <!-- Login Link -->
        <div class="text-center pt-6">
            <a href="{{ route('login') }}" class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                Ingat sandi anda? <span class="text-[#0077B6] hover:underline ml-1">Masuk</span>
            </a>
        </div>
    </form>
</x-guest-layout>
