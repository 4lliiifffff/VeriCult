<x-layouts.super-admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('super-admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('super-admin.users.index') }}" class="hover:text-[#0077B6] transition-colors">Kelola Pengguna</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Tambah Validator</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h2 class="font-black text-3xl text-[#03045E] leading-tight tracking-tight">
                    Tambah <span class="text-[#0077B6]">Validator Baru</span>
                </h2>
                <p class="text-sm text-slate-500 mt-2 font-medium">Daftarkan tenaga ahli penguji baru ke dalam sistem VeriCult.</p>
            </div>
            <div>
                <a href="{{ route('super-admin.users.index') }}" class="inline-flex items-center px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 hover:bg-slate-50 hover:border-slate-300 shadow-sm shadow-slate-200/50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>
    
    <div class="max-w-4xl mx-auto pb-12">
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden relative group">
            <div class="p-8 sm:p-12">
                <form action="{{ route('super-admin.users.store-validator') }}" method="POST" class="space-y-10">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <!-- Basic Info Section -->
                        <div class="space-y-8">
                            <div>
                                <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-[#0077B6]"></span>
                                    Informasi Dasar
                                </h3>
                                <div class="space-y-6">
                                    <div>
                                        <x-input-label for="name" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1" :value="__('Nama Lengkap')" />
                                        <x-text-input id="name" name="name" type="text" 
                                            class="block w-full h-14 rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 transition-all duration-300 font-bold text-[#03045E]" 
                                            :value="old('name')" required autofocus placeholder="Contoh: Dr. Budi Santoso" />
                                        <x-input-error class="mt-2 text-xs" :messages="$errors->get('name')" />
                                    </div>
                                    <div>
                                        <x-input-label for="email" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1" :value="__('Alamat Email')" />
                                        <x-text-input id="email" name="email" type="email" 
                                            class="block w-full h-14 rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 transition-all duration-300 font-bold text-[#03045E]" 
                                            :value="old('email')" required placeholder="email@instansi.ac.id" />
                                        <x-input-error class="mt-2 text-xs" :messages="$errors->get('email')" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Section -->
                        <div class="space-y-8" x-data="{ showPassword: false }">
                            <div>
                                <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                    Keamanan Akun
                                </h3>
                                <div class="space-y-6">
                                    <div>
                                        <x-input-label for="password" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1" :value="__('Kata Sandi (Opsional)')" />
                                        <div class="relative group">
                                            <x-text-input 
                                                id="password" 
                                                name="password" 
                                                ::type="showPassword ? 'text' : 'password'" 
                                                class="block w-full h-14 pr-12 rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 transition-all duration-300 font-bold text-[#03045E]" 
                                                placeholder="Kosongkan untuk otomatis" 
                                            />
                                            <button type="button" 
                                                @click="showPassword = !showPassword" 
                                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-300 hover:text-[#0077B6] transition-colors">
                                                <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg x-show="showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                                        <x-input-error class="mt-2 text-xs" :messages="$errors->get('password')" />
                                    </div>
                                    <div>
                                        <x-input-label for="password_confirmation" class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1" :value="__('Konfirmasi Sandi')" />
                                        <x-text-input 
                                            id="password_confirmation" 
                                            name="password_confirmation" 
                                            ::type="showPassword ? 'text' : 'password'" 
                                            class="block w-full h-14 rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 transition-all duration-300 font-bold text-[#03045E]" 
                                            placeholder="Ulangi kata sandi" 
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 rounded-[2rem] bg-indigo-50/50 border border-indigo-100 flex items-start gap-4">
                        <div class="mt-1">
                            <input id="email_verified" type="checkbox" class="w-5 h-5 rounded-lg border-slate-300 text-[#0077B6] focus:ring-[#0077B6] shadow-none focus:ring-offset-0 transition-all cursor-pointer" name="email_verified" value="1" checked>
                        </div>
                        <div class="flex-1">
                            <label for="email_verified" class="block text-sm font-black text-[#03045E] cursor-pointer">Verifikasi Email Otomatis</label>
                            <p class="text-[11px] text-slate-500 font-medium mt-1">Jika diaktifkan, user tidak perlu melakukan proses aktivasi email dan bisa langsung masuk.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end pt-6">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-10 py-4 bg-[#03045E] hover:bg-[#0077B6] text-white rounded-[1.25rem] font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 shadow-xl shadow-blue-900/20 group">
                            Buat Akun Validator
                            <svg class="w-4 h-4 ml-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.super-admin>
