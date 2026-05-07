<x-guest-layout>
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-[#03045E] mb-3 tracking-tight">Buat Akun</h2>
        <p class="text-slate-500 text-sm font-medium">Bergabung dengan Ekosistem VeriCult</p>
    </div>

    <!-- Info Box -->
    <div class="mb-8 p-6 rounded-2xl bg-[#90E0EF]/10 border border-[#90E0EF]/20 flex items-start gap-4">
        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#0077B6] shadow-sm shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-xs font-bold text-[#03045E] uppercase tracking-wider mb-1">Verifikasi Email</p>
            <p class="text-[11px] text-slate-500 font-medium leading-relaxed">Anda akan menerima email aktivasi segera setelah proses pendaftaran selesai.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div class="space-y-2">
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1" />
            <div class="relative group">
                <input id="name" 
                       type="text" 
                       name="name" 
                       :value="old('name')" 
                       required 
                       autofocus 
                       autocomplete="name" 
                       placeholder="Nama sesuai identitas"
                       class="block w-full px-4 pr-12 py-4 bg-slate-50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all placeholder:text-slate-300" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email')" class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1" />
            <div class="relative group">
                <input id="email" 
                       type="email" 
                       name="email" 
                       :value="old('email')" 
                       required 
                       autocomplete="username" 
                       placeholder="nama@email.com"
                       class="block w-full px-4 pr-12 py-4 bg-slate-50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all placeholder:text-slate-300" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="grid sm:grid-cols-2 gap-6" x-data="{ showPass: false, showConfirm: false }">
            <!-- Password -->
            <div class="space-y-2">
                <x-input-label for="password" :value="__('Sandi')" class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1" />
                <div class="relative group">
                    <input id="password" 
                           :type="showPass ? 'text' : 'password'"
                           name="password"
                           required 
                           autocomplete="new-password" 
                           placeholder="Minimal 8 karakter"
                           class="block w-full px-4 pr-12 py-4 bg-slate-50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all placeholder:text-slate-300" />
                    <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-[#0077B6] transition-colors focus:outline-none">
                        <svg x-show="!showPass" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg x-show="showPass" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.056 10.056 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <x-input-label for="password_confirmation" :value="__('Ulangi Sandi')" class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1" />
                <div class="relative group">
                    <input id="password_confirmation" 
                           :type="showConfirm ? 'text' : 'password'"
                           name="password_confirmation"
                           required 
                           autocomplete="new-password" 
                           placeholder="Konfirmasi password"
                           class="block w-full px-4 pr-12 py-4 bg-slate-50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all placeholder:text-slate-300" />
                    <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-[#0077B6] transition-colors focus:outline-none">
                        <svg x-show="!showConfirm" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <svg x-show="showConfirm" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.056 10.056 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <!-- Hidden Role -->
        <input type="hidden" name="role" value="pengusul">

        <!-- Terms -->
        <!-- <div class="flex items-start pt-2">
            <label class="flex items-start cursor-pointer group">
                <input type="checkbox" required class="mt-1 w-5 h-5 rounded-lg border-slate-200 text-[#0077B6] focus:ring-[#0077B6]/20 transition-all cursor-pointer">
                <span class="ms-3 text-xs font-medium text-slate-400 leading-relaxed">
                    Saya menyetujui <a href="#" class="text-[#0077B6] font-bold">Syarat & Ketentuan</a> serta <a href="#" class="text-[#0077B6] font-bold">Kebijakan Privasi</a> VeriCult
                </span>
            </label>
        </div> -->

        <!-- Action Button -->
        <div class="pt-4">
            <button type="submit" class="w-full bg-[#03045E] hover:bg-[#0077B6] text-white font-bold py-4 px-6 rounded-2xl transition-all duration-300 shadow-xl shadow-blue-900/10 flex items-center justify-center gap-3 group">
                <span class="uppercase tracking-widest text-xs">{{ __('Daftar Sekarang') }}</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </button>
        </div>

        <!-- Links -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-6 text-center">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                Daftar sebagai pihak Desa? 
                <a href="{{ route('register.desa') }}" class="text-[#0077B6] hover:underline ml-1">Klik Disini</a>
            </p>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-[#03045E] hover:underline ml-1">Masuk</a>
            </p>
        </div>
    </form>
</x-guest-layout>
