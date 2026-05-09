<x-guest-layout>
    <div class="text-center mb-10">
        <h2 class="text-3xl font-bold text-[#03045E] mb-3 tracking-tight">Pendaftaran Akun Desa</h2>
        <p class="text-slate-500 text-sm font-medium">Lengkapi data untuk mendaftarkan perwakilan desa</p>
    </div>

    <!-- Info Box -->
    <div class="mb-8 p-6 rounded-2xl bg-amber-50 border border-amber-100 flex items-start gap-4">
        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-amber-500 shadow-sm shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <div>
            <p class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-1">Verifikasi Desa Diperlukan</p>
            <p class="text-[11px] text-amber-600 font-medium leading-relaxed">Proses pendaftaran desa memerlukan lampiran surat pengajuan resmi untuk verifikasi admin.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('register.desa') }}" class="space-y-6" enctype="multipart/form-data" x-data="{ showPass: false, showConfirm: false }">
        @csrf

        <div class="grid sm:grid-cols-2 gap-6">
            <!-- Kecamatan Name -->
            <div class="space-y-2" x-data="{ 
                    open: false, 
                    search: '{{ addslashes(old('kecamatan_name', '')) }}',
                    allOptions: @js($kecamatans->pluck('name')),
                    get filteredOptions() {
                        if (!this.search) return this.allOptions;
                        return this.allOptions.filter(i => i.toLowerCase().includes(this.search.toLowerCase()));
                    },
                    selectOption(option) {
                        this.search = option;
                        this.open = false;
                    }
                 }" @click.away="open = false">
                <x-input-label for="kecamatan_name" :value="__('Kecamatan')" class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1" />
                <div class="relative group">
                    <input type="text"
                        name="kecamatan_name"
                        id="kecamatan_name"
                        x-model="search"
                        @focus="open = true"
                        @input="open = true"
                        required
                        autocomplete="off"
                        placeholder="Cari kecamatan..."
                        class="block w-full px-4 py-4 bg-slate-50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all placeholder:text-slate-300" />
                    
                    <div x-show="open && filteredOptions.length > 0" class="absolute z-[60] w-full mt-2 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 max-h-48 overflow-y-auto overflow-x-hidden">
                        <template x-for="option in filteredOptions" :key="option">
                            <button type="button" @click="selectOption(option)" class="w-full text-left px-5 py-3 text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-[#0077B6] transition-colors" x-text="option"></button>
                        </template>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('kecamatan_name')" class="mt-2" />
            </div>

            <!-- Village Name -->
            <div class="space-y-2" x-data="{ 
                    open: false, 
                    search: '{{ addslashes(old('village_name', '')) }}',
                    allOptions: @js($villages->pluck('name')),
                    get filteredOptions() {
                        if (!this.search) return this.allOptions;
                        return this.allOptions.filter(i => i.toLowerCase().includes(this.search.toLowerCase()));
                    },
                    selectOption(option) {
                        this.search = option;
                        this.open = false;
                    }
                 }" @click.away="open = false">
                <x-input-label for="village_name" :value="__('Nama Desa')" class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1" />
                <div class="relative group">
                    <input type="text"
                        name="village_name"
                        id="village_name"
                        x-model="search"
                        @focus="open = true"
                        @input="open = true"
                        required
                        autocomplete="off"
                        placeholder="Cari desa anda..."
                        class="block w-full px-4 py-4 bg-slate-50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all placeholder:text-slate-300" />
                    
                    <div x-show="open && filteredOptions.length > 0" class="absolute z-[60] w-full mt-2 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 max-h-48 overflow-y-auto overflow-x-hidden">
                        <template x-for="option in filteredOptions" :key="option">
                            <button type="button" @click="selectOption(option)" class="w-full text-left px-5 py-3 text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-[#0077B6] transition-colors" x-text="option"></button>
                        </template>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('village_name')" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="space-y-2">
                <x-input-label for="name" :value="__('Nama Perwakilan')" class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1" />
                <div class="relative group">
                    <input id="name" 
                        type="text" 
                        name="name" 
                        :value="old('name')" 
                        required 
                        autocomplete="name" 
                        placeholder="Nama sesuai identitas"
                        class="block w-full px-4 py-4 bg-slate-50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all placeholder:text-slate-300" />
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
                        class="block w-full px-4 py-4 bg-slate-50 border-slate-100 rounded-2xl text-sm font-medium focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all placeholder:text-slate-300" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

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

        <!-- File Upload -->
        <div class="space-y-2 col-span-full" x-data="{ fileName: '' }">
            <x-input-label for="surat_pengajuan" :value="__('Surat Pengajuan Resmi')" class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1" />
            <div class="relative group">
                <input type="file" name="surat_pengajuan" id="surat_pengajuan" @change="fileName = $event.target.files[0].name" class="hidden" required accept=".pdf,.jpg,.jpeg,.png">
                <label for="surat_pengajuan" class="flex flex-col items-center justify-center border-2 border-dashed border-slate-200 rounded-[2rem] p-8 text-center cursor-pointer hover:border-[#0077B6] hover:bg-[#90E0EF]/5 transition-all group/label">
                    <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover/label:text-[#0077B6] group-hover/label:scale-110 transition-all duration-300 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    </div>
                    <span x-show="!fileName" class="text-xs font-bold text-slate-500">Klik atau tarik file untuk unggah</span>
                    <span x-show="fileName" class="text-xs font-bold text-[#0077B6]" x-text="fileName"></span>
                    <span class="text-[10px] text-slate-400 mt-1 uppercase tracking-widest font-bold">PDF, JPG, PNG (Max 2MB)</span>
                </label>
            </div>
            <x-input-error :messages="$errors->get('surat_pengajuan')" class="mt-2" />
        </div>

        <!-- Action Button -->
        <div class="pt-4">
            <button type="submit" class="w-full bg-[#03045E] hover:bg-[#0077B6] text-white font-bold py-4 px-6 rounded-2xl transition-all duration-300 shadow-xl shadow-blue-900/10 flex items-center justify-center gap-3 group">
                <span class="uppercase tracking-widest text-xs">Kirim Pengajuan Desa</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </button>
        </div>

        <!-- Links -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-6 text-center">
            <a href="{{ route('register') }}" class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                Bukan Perwakilan Desa? <span class="text-[#0077B6] hover:underline ml-1">Daftar Biasa</span>
            </a>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-[#03045E] hover:underline ml-1">Masuk</a>
            </p>
        </div>
    </form>
</x-guest-layout>
