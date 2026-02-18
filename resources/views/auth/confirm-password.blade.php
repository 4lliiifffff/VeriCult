<x-guest-layout>
    <!-- Header with Icon -->
    <div class="mb-12 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-[#03045E] to-[#0077B6] rounded-3xl mb-6 shadow-2xl shadow-blue-900/20 transition-transform duration-500 hover:scale-110 group">
            <svg class="w-10 h-10 text-white group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        <h2 class="text-4xl font-black text-[#03045E] mb-3 tracking-tight leading-tight">Konfirmasi <span class="text-[#0077B6]">Sandi</span></h2>
        <p class="text-slate-500 font-bold text-sm uppercase tracking-widest">Verifikasi Identitas Anda</p>
    </div>

    <div class="mb-10 p-6 rounded-2xl bg-blue-50 border border-blue-100/50">
        <p class="text-xs md:text-sm text-slate-600 font-bold leading-relaxed uppercase tracking-wider text-center">
            {{ __('Ini adalah area aman. Harap konfirmasi kata sandi Anda sebelum melanjutkan.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-8">
        @csrf

        <!-- Password -->
        <div x-data="{ show: false }" class="group">
            <x-input-label for="password" :value="__('Kata Sandi')" class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1 transition-colors group-focus-within:text-[#0077B6]" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none transition-colors group-focus-within:text-[#0077B6] text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <x-text-input id="password" class="block w-full pl-14 pr-14 py-4 text-sm font-bold placeholder:text-slate-300 placeholder:font-medium"
                                ::type="show ? 'text' : 'password'"
                                name="password"
                                required autocomplete="current-password" 
                                placeholder="Masukkan kata sandi" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-400 hover:text-[#0077B6] transition-colors focus:outline-none">
                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.056 10.056 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-6">
            <button type="submit" class="w-full bg-gradient-to-br from-[#03045E] to-[#0077B6] hover:shadow-2xl hover:shadow-blue-900/40 text-white font-black py-5 px-6 rounded-2xl transition-all duration-300 shadow-xl shadow-blue-900/20 flex items-center justify-center group active:scale-[0.98]">
                <div class="flex items-center gap-4">
                    <span class="uppercase tracking-[0.2em] text-xs">{{ __('Konfirmasi Akses') }}</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </div>
            </button>
        </div>
    </form>
</x-guest-layout>
