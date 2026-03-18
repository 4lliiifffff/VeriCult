<x-layouts.super-admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-sm font-medium text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('super-admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('super-admin.users.index') }}" class="hover:text-[#0077B6] transition-colors">Kelola Pengguna</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Tambah Validator</span>
        </nav>

        <div class="relative bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2.5rem] p-8 sm:p-12 overflow-hidden shadow-2xl shadow-blue-900/20 mb-10">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-[1.5rem] bg-white/10 border border-white/20 flex items-center justify-center text-white shadow-inner backdrop-blur-md">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <div class="space-y-1">
                        <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-none">Registrasi Validator</h2>
                        <p class="text-blue-100/70 text-sm sm:text-base font-medium">Daftarkan tenaga ahli penguji baru ke sistem VeriCult.</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('super-admin.users.index') }}" class="px-6 py-4 bg-white/10 border border-white/20 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-white hover:text-[#03045E] transition-all flex items-center gap-3 backdrop-blur-sm group/btn">
                        <svg class="w-5 h-5 group-hover: -translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Batal & Kembali
                    </a>
                </div>
            </div>
        </div>
    </x-slot>
    
    <div class="max-w-5xl mx-auto pb-20">
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-white overflow-hidden relative group">
            <div class="p-8 sm:p-14">
                <form action="{{ route('super-admin.users.store-validator') }}" method="POST" class="space-y-12">
                    @csrf
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 sm:gap-16">
                        <!-- Basic Info Section -->
                        <div class="space-y-10">
                            <div>
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-8 flex items-center gap-4">
                                    <span class="shrink-0">Informasi Identitas</span>
                                    <div class="flex-1 h-px bg-slate-100"></div>
                                </h3>
                                <div class="space-y-8">
                                    <div class="space-y-2">
                                        <x-input-label for="name" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" :value="__('Nama Lengkap')" />
                                        <div class="relative group/input">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300 group-focus-within/input:text-[#0077B6] transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            </div>
                                            <x-text-input id="name" name="name" type="text" 
                                                class="block w-full h-14 pl-12 rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 transition-all duration-300 font-bold text-[#03045E] placeholder:text-slate-300" 
                                                :value="old('name')" required autofocus placeholder="Masukkan nama lengkap..." />
                                        </div>
                                        <x-input-error class="mt-2 text-[10px] font-bold" :messages="$errors->get('name')" />
                                    </div>
                                    <div class="space-y-2">
                                        <x-input-label for="email" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" :value="__('Alamat Email')" />
                                        <div class="relative group/input">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300 group-focus-within/input:text-[#0077B6] transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <x-text-input id="email" name="email" type="email" 
                                                class="block w-full h-14 pl-12 rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 transition-all duration-300 font-bold text-[#03045E] placeholder:text-slate-300" 
                                                :value="old('email')" required placeholder="email@instansi.ac.id" />
                                        </div>
                                        <x-input-error class="mt-2 text-[10px] font-bold" :messages="$errors->get('email')" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Section -->
                        <div class="space-y-10" x-data="{ showPassword: false, showConfirmPassword: false }">
                            <div>
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-8 flex items-center gap-4">
                                    <span class="shrink-0">Keamanan Akun</span>
                                    <div class="flex-1 h-px bg-slate-100"></div>
                                </h3>
                                <div class="space-y-8">
                                    <div class="space-y-2">
                                        <x-input-label for="password" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" :value="__('Kata Sandi (Opsional)')" />
                                        <div class="relative group/input">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300 group-focus-within/input:text-[#0077B6] transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            </div>
                                            <x-text-input 
                                                id="password" 
                                                name="password" 
                                                ::type="showPassword ? 'text' : 'password'" 
                                                class="block w-full h-14 pl-12 pr-12 rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 transition-all duration-300 font-bold text-[#03045E] placeholder:text-slate-300" 
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
                                        <x-input-error class="mt-2 text-[10px] font-bold" :messages="$errors->get('password')" />
                                    </div>
                                    <div class="space-y-2">
                                        <x-input-label for="password_confirmation" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" :value="__('Konfirmasi Sandi')" />
                                        <div class="relative group/input">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300 group-focus-within/input:text-[#0077B6] transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                            </div>
                                            <x-text-input 
                                                id="password_confirmation" 
                                                name="password_confirmation" 
                                                ::type="showConfirmPassword ? 'text' : 'password'" 
                                                class="block w-full h-14 pl-12 pr-12 rounded-2xl border-slate-200 bg-slate-50/50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 transition-all duration-300 font-bold text-[#03045E] placeholder:text-slate-300" 
                                                placeholder="Ulangi kata sandi" 
                                            />
                                            <button type="button" 
                                                @click="showConfirmPassword = !showConfirmPassword" 
                                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-300 hover:text-[#0077B6] transition-colors">
                                                <svg x-show="!showConfirmPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg x-show="showConfirmPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 rounded-[2.5rem] bg-blue-50/50 border border-blue-100 flex items-start gap-6 group/box hover:bg-white hover:shadow-xl hover:shadow-blue-900/5 transition-all duration-500">
                        <div class="mt-1">
                            <input id="email_verified" type="checkbox" class="w-6 h-6 rounded-lg border-slate-300 text-[#0077B6] focus:ring-[#0077B6] shadow-none focus:ring-offset-0 transition-all cursor-pointer" name="email_verified" value="1" checked>
                        </div>
                        <div class="flex-1">
                            <label for="email_verified" class="block text-base font-black text-[#03045E] cursor-pointer group-hover/box:text-[#0077B6] transition-colors">Aktivasi Email Otomatis</label>
                            <p class="text-xs text-slate-500 font-medium mt-1 leading-relaxed">Jika diaktifkan, validator tidak perlu melakukan proses verifikasi email manual dan dapat langsung mengakses dashboard setelah pendaftaran.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end pt-8">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-12 py-5 bg-[#03045E] hover:bg-[#0077B6] text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.25em] transition-all duration-300 shadow-2xl shadow-blue-900/40 group active:scale-95">
                            Konfirmasi Registrasi
                            <svg class="w-5 h-5 ml-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.super-admin>
