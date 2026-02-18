<x-guest-layout>
    <!-- Header with Icon -->
    <div class="mb-12 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-[#00B4D8] to-[#0077B6] rounded-3xl mb-6 shadow-2xl shadow-blue-400/20 transition-transform duration-500 hover:scale-110 group">
            <svg class="w-10 h-10 text-white group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
        </div>
        <h2 class="text-4xl font-black text-[#03045E] mb-3 tracking-tight leading-tight">Buat <span class="text-[#00B4D8]">Akun Baru</span></h2>
        <p class="text-slate-500 font-bold text-sm uppercase tracking-widest">Bergabung dengan Ekosistem VeriCult</p>
    </div>

    <!-- Email Verification Notice -->
    <div class="mb-8 p-6 rounded-2xl bg-blue-50 border border-blue-100 flex items-start gap-4">
        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#0077B6] shadow-sm shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <div>
            <p class="text-sm font-black text-[#03045E] uppercase tracking-wider mb-1">Verifikasi Diperlukan</p>
            <p class="text-xs text-slate-500 font-bold leading-relaxed">Anda akan menerima email aktivasi segera setelah proses pendaftaran selesai.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-8">
        @csrf

        <!-- Name -->
        <div class="group">
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1 transition-colors group-focus-within:text-[#0077B6]" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none transition-colors group-focus-within:text-[#0077B6] text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <x-text-input id="name" class="block w-full pl-14 pr-5 py-4 text-sm font-bold placeholder:text-slate-300 placeholder:font-medium" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama lengkap sesuai identitas" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="group">
            <x-input-label for="email" :value="__('Alamat Email')" class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1 transition-colors group-focus-within:text-[#0077B6]" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none transition-colors group-focus-within:text-[#0077B6] text-slate-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
                <x-text-input id="email" class="block w-full pl-14 pr-5 py-4 text-sm font-bold placeholder:text-slate-300 placeholder:font-medium" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="alamat@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Passwords Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Password -->
            <div x-data="{ show: false }" class="group">
                <x-input-label for="password" :value="__('Kata Sandi')" class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1 transition-colors group-focus-within:text-[#0077B6]" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none transition-colors group-focus-within:text-[#0077B6] text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <x-text-input id="password" class="block w-full pl-14 pr-12 py-4 text-sm font-bold placeholder:text-slate-300 placeholder:font-medium"
                                    ::type="show ? 'text' : 'password'"
                                    name="password"
                                    required autocomplete="new-password"
                                    placeholder="Min. 8 char" />
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-400 hover:text-[#0077B6] transition-colors focus:outline-none">
                        <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.056 10.056 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div x-data="{ show: false }" class="group">
                <x-input-label for="password_confirmation" :value="__('Konfirmasi')" class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1 transition-colors group-focus-within:text-[#0077B6]" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none transition-colors group-focus-within:text-[#0077B6] text-slate-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <x-text-input id="password_confirmation" class="block w-full pl-14 pr-12 py-4 text-sm font-bold placeholder:text-slate-300 placeholder:font-medium"
                                    ::type="show ? 'text' : 'password'"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Ulangi sandi" />
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-400 hover:text-[#0077B6] transition-colors focus:outline-none">
                        <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.056 10.056 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <!-- Terms Agreement -->
        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 group transition-all duration-300 hover:bg-slate-100/50">
            <label class="flex items-start cursor-pointer group">
                <input type="checkbox" class="w-5 h-5 rounded-lg border-slate-200 text-[#0077B6] shadow-sm focus:ring-[#00B4D8]/20 mt-0.5 transition-all cursor-pointer" required>
                <span class="ms-4 text-xs font-bold text-slate-500 leading-relaxed uppercase tracking-wider">
                    Saya menyetujui <a href="#" class="text-[#0077B6] hover:text-[#03045E] font-black transition-colors">Syarat & Ketentuan</a> serta <a href="#" class="text-[#0077B6] hover:text-[#03045E] font-black transition-colors">Kebijakan Privasi</a> VeriCult
                </span>
            </label>
        </div>

        <!-- Register Button -->
        <div class="pt-4">
            <button type="submit" class="w-full bg-gradient-to-br from-[#00B4D8] to-[#0077B6] hover:shadow-2xl hover:shadow-blue-400/40 text-white font-black py-5 px-6 rounded-2xl transition-all duration-300 shadow-xl shadow-blue-400/20 flex items-center justify-center group active:scale-[0.98]">
                <div class="flex items-center gap-4">
                    <span class="uppercase tracking-[0.2em] text-xs font-black">{{ __('Daftar Sekarang') }}</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
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
                <span class="px-4 bg-white text-slate-300">Sudah Punya Akun?</span>
            </div>
        </div>

        <!-- Login Link -->
        <div>
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center w-full border-2 border-slate-100 text-[#03045E] hover:bg-slate-50 hover:border-slate-200 font-black py-5 px-6 rounded-2xl transition-all duration-300 shadow-sm group">
                <svg class="w-5 h-5 mr-3 text-[#0077B6] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                <span class="uppercase tracking-[0.2em] text-xs">{{ __('Masuk Portal') }}</span>
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
