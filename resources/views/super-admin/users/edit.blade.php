<x-layouts.super-admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('super-admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('super-admin.users.index') }}" class="hover:text-[#0077B6] transition-colors">Kelola Pengguna</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('super-admin.users.show', $user) }}" class="hover:text-[#0077B6] transition-colors">{{ $user->name }}</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Edit Profil</span>
        </nav>

        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6 sm:gap-8">
                <div class="flex items-center gap-5 sm:gap-8">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-[1.5rem] sm:rounded-[2rem] bg-[#03045E] flex items-center justify-center text-white shadow-xl shadow-blue-900/20 font-black text-xl sm:text-2xl uppercase">
                        {{ substr($user->name, 0, 2) }}
                    </div>
                    <div class="space-y-1.5 sm:space-y-2">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="px-3 sm:px-4 py-1 sm:py-1.5 rounded-full text-[8px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-slate-100 text-slate-500 border border-slate-200">
                                User Management
                            </div>
                            <div class="h-3 sm:h-4 w-[1px] bg-slate-200"></div>
                            <span class="text-slate-400 text-[8px] sm:text-[10px] font-bold uppercase tracking-widest">ID #{{ $user->id }}</span>
                        </div>
                        <h2 class="text-2xl sm:text-4xl font-black text-[#03045E] tracking-tight leading-tight">
                            Edit <span class="text-[#0077B6]">Pengguna</span>
                        </h2>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('super-admin.users.show', $user) }}" class="px-6 py-4 bg-slate-50 text-slate-500 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-[#03045E] hover:text-white transition-all flex items-center gap-3 border border-slate-100 active:scale-95 group/btn">
                        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </x-slot>
    
    <div class="max-w-5xl mx-auto pb-20">
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white relative" 
             x-data="{ 
                role: '{{ old('role', $user->roles->first()?->name) }}',
                showPassword: false,
                showConfirmPassword: false 
             }">
            <form method="post" action="{{ route('super-admin.users.update', $user) }}" class="p-8 sm:p-12 lg:p-16">
                @csrf
                @method('patch')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 sm:gap-24">
                    <!-- Identity Section -->
                    <div class="space-y-12">
                        <div>
                            <h3 class="text-[10px] font-black text-[#0077B6] uppercase tracking-[0.3em] mb-10 flex items-center gap-4">
                                <span class="shrink-0 text-[#03045E]">Identitas & Peran</span>
                                <div class="flex-1 h-px bg-slate-100"></div>
                            </h3>
                            <div class="space-y-8">
                                <div class="space-y-2">
                                    <x-input-label for="name" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" :value="__('Nama Lengkap')" />
                                    <div class="relative group/input">
                                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within/input:text-[#0077B6] transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        </div>
                                        <x-text-input id="name" name="name" type="text" 
                                            class="block w-full h-14 pl-14 rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 transition-all duration-300 font-bold text-[#03045E] shadow-inner" 
                                            :value="old('name', $user->name)" required autofocus />
                                    </div>
                                    <x-input-error class="mt-2 text-[10px] font-bold" :messages="$errors->get('name')" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="email" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" :value="__('Alamat Email')" />
                                    <div class="relative group/input">
                                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within/input:text-[#0077B6] transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <x-text-input id="email" name="email" type="email" 
                                            class="block w-full h-14 pl-14 rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 transition-all duration-300 font-bold text-[#03045E] shadow-inner" 
                                            :value="old('email', $user->email)" required />
                                    </div>
                                    <x-input-error class="mt-2 text-[10px] font-bold" :messages="$errors->get('email')" />
                                </div>

                                <div class="space-y-2">
                                    <x-input-label for="role_search" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" :value="__('Peran Pengguna')" />
                                    @if($user->id === 1)
                                        <div class="px-5 h-14 bg-slate-50 border border-slate-100 rounded-2xl text-[11px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-3">
                                            <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            Super Admin (Tidak dapat diubah)
                                        </div>
                                        <input type="hidden" name="role" value="super-admin">
                                    @else
                                        <div class="relative group" x-data="{ 
                                                open: false, 
                                                search: '{{ ucfirst(str_replace('-', ' ', old('role', $user->roles->first()?->name))) }}',
                                                allOptions: @js($roles->map(fn($r) => ['value' => $r->name, 'label' => ucfirst(str_replace('-', ' ', $r->name))])),
                                                get filteredOptions() {
                                                    if (!this.search) return this.allOptions;
                                                    return this.allOptions.filter(i => i.label.toLowerCase().includes(this.search.toLowerCase()));
                                                },
                                                selectOption(option) {
                                                    this.search = option.label;
                                                    this.role = option.value;
                                                    this.open = false;
                                                }
                                             }" @click.away="open = false">
                                            <div class="relative group/input">
                                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within/input:text-[#0077B6] transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-5.618 2.04c-1.28.143-2.52.41-3.693.791V11c0 5.022 3.363 9.423 8 11.314 4.637-1.891 8-6.292 8-11.314V5.771c-1.174-.381-2.413-.648-3.693-.791z"></path></svg>
                                                </div>
                                                <input type="hidden" name="role" :value="role">
                                                <input type="text"
                                                    x-model="search"
                                                    @focus="open = true"
                                                    @input="open = true"
                                                    autocomplete="off"
                                                    placeholder="Cari peran..."
                                                    class="block w-full h-14 pl-14 pr-10 rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 transition-all duration-300 font-bold text-[#03045E] shadow-inner cursor-pointer" />
                                                
                                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                                    <svg class="w-4 h-4 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                                </div>
                                            </div>

                                            <div x-show="open && filteredOptions.length > 0" 
                                                 x-transition:enter="transition ease-out duration-200"
                                                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                 class="absolute z-50 w-full mt-2 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 max-h-48 overflow-y-auto">
                                                <template x-for="option in filteredOptions" :key="option.value">
                                                    <button type="button" @click="selectOption(option)" 
                                                        class="w-full text-left px-5 py-3 text-[11px] font-black uppercase tracking-widest transition-colors"
                                                        :class="role === option.value ? 'bg-blue-50 text-[#0077B6]' : 'text-slate-600 hover:bg-slate-50 hover:text-[#0077B6]'"
                                                        x-text="option.label"></button>
                                                </template>
                                            </div>
                                        </div>
                                        <x-input-error class="mt-2 text-[10px] font-bold" :messages="$errors->get('role')" />
                                    @endif
                                </div>
                                
                                <!-- Dynamic Profile Fields -->
                                <div x-show="role === 'pengusul-desa' || role === 'pengusul' || role === 'validator'" 
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 -translate-y-4"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     class="space-y-8 pt-8 border-t border-slate-100" style="display: none;">
                                    
                                    <!-- Fields for Pengusul Desa -->
                                    <template x-if="role === 'pengusul-desa'">
                                        <div class="space-y-8">
                                            <div class="space-y-2">
                                                <x-input-label for="village_search" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" :value="__('Desa / Kelurahan')" />
                                                <div class="relative group" x-data="{ 
                                                        open: false, 
                                                        selectedId: '{{ old('village_id', $user->pengusulDesaProfile?->village_id) }}',
                                                        search: '{{ optional($villages->find(old('village_id', $user->pengusulDesaProfile?->village_id)))->name }}',
                                                        allOptions: @js($villages->map(fn($v) => ['id' => $v->id, 'name' => $v->name])),
                                                        get filteredOptions() {
                                                            if (!this.search) return this.allOptions;
                                                            return this.allOptions.filter(i => i.name.toLowerCase().includes(this.search.toLowerCase()));
                                                        },
                                                        selectOption(option) {
                                                            this.search = option.name;
                                                            this.selectedId = option.id;
                                                            this.open = false;
                                                        }
                                                     }" @click.away="open = false">
                                                    <div class="relative group/input">
                                                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within/input:text-[#0077B6] transition-colors">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                        </div>
                                                        <input type="hidden" name="village_id" :value="selectedId">
                                                        <input type="text"
                                                            x-model="search"
                                                            @focus="open = true"
                                                            @input="open = true"
                                                            autocomplete="off"
                                                            placeholder="Cari desa..."
                                                            class="block w-full h-14 pl-14 pr-10 rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] transition-all duration-300 font-bold text-[#03045E] shadow-inner cursor-pointer" />
                                                        
                                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                                            <svg class="w-4 h-4 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                                                        </div>
                                                    </div>

                                                    <div x-show="open && filteredOptions.length > 0" 
                                                         x-transition:enter="transition ease-out duration-200"
                                                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                                         class="absolute z-50 w-full mt-2 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 max-h-48 overflow-y-auto">
                                                        <template x-for="option in filteredOptions" :key="option.id">
                                                            <button type="button" @click="selectOption(option)" 
                                                                class="w-full text-left px-5 py-3 text-[11px] font-black uppercase tracking-widest transition-colors"
                                                                :class="selectedId == option.id ? 'bg-blue-50 text-[#0077B6]' : 'text-slate-600 hover:bg-slate-50 hover:text-[#0077B6]'"
                                                                x-text="option.name"></button>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <x-input-label for="jabatan_desa" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" :value="__('Jabatan di Desa')" />
                                                <x-text-input id="jabatan_desa" name="jabatan_desa" type="text" class="block w-full h-14 px-6 rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] font-bold text-[#03045E] shadow-inner" :value="old('jabatan_desa', $user->pengusulDesaProfile?->jabatan_desa)" placeholder="Contoh: Kepala Desa" />
                                            </div>
                                            <div class="space-y-2">
                                                <x-input-label for="nip" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" :value="__('NIP (Opsional)')" />
                                                <x-text-input id="nip" name="nip" type="text" class="block w-full h-14 px-6 rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] font-bold text-[#03045E] shadow-inner" :value="old('nip', $user->pengusulDesaProfile?->nip)" placeholder="Masukkan NIP jika ada" />
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Fields for Pengusul / Validator -->
                                    <template x-if="role === 'pengusul' || role === 'validator'">
                                        <div class="space-y-8">
                                            <div class="space-y-2">
                                                <x-input-label for="instansi" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" :value="__('Instansi asal')" />
                                                <x-text-input id="instansi" name="instansi" type="text" class="block w-full h-14 px-6 rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] font-bold text-[#03045E] shadow-inner" :value="old('instansi', $user->profile?->instansi)" placeholder="Contoh: Dinas Kebudayaan" />
                                            </div>
                                        </div>
                                    </template>

                                    <!-- Common Fields -->
                                    <div class="space-y-2">
                                        <x-input-label for="no_hp" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" :value="__('Nomor Handphone')" />
                                        <x-text-input id="no_hp" name="no_hp" type="text" class="block w-full h-14 px-6 rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] font-bold text-[#03045E] shadow-inner" :value="old('no_hp', $user->profile?->no_hp)" placeholder="0812xxxxxx" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div class="space-y-12">
                        <div>
                            <h3 class="text-[10px] font-black text-[#0077B6] uppercase tracking-[0.3em] mb-10 flex items-center gap-4">
                                <span class="shrink-0 text-[#03045E]">Keamanan & Kredensial</span>
                                <div class="flex-1 h-px bg-slate-100"></div>
                            </h3>
                            <div class="p-8 rounded-[2rem] bg-amber-50 border border-amber-100 mb-10">
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-amber-500 shrink-0 shadow-sm">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-black text-amber-800 uppercase tracking-widest mb-1">Pembaruan Kata Sandi</h4>
                                        <p class="text-[11px] text-amber-700/70 font-medium leading-relaxed">Biarkan kosong jika Anda tidak ingin mengubah kata sandi pengguna ini.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-8">
                                <div class="space-y-2">
                                    <x-input-label for="password" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" :value="__('Kata Sandi Baru')" />
                                    <div class="relative group/input">
                                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within/input:text-[#0077B6] transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        </div>
                                        <x-text-input 
                                            id="password" 
                                            name="password" 
                                            ::type="showPassword ? 'text' : 'password'" 
                                            class="block w-full h-14 pl-14 pr-12 rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] font-bold text-[#03045E] shadow-inner" 
                                            autocomplete="new-password" 
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
                                    <x-input-label for="password_confirmation" class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1" :value="__('Konfirmasi Kata Sandi')" />
                                    <div class="relative group/input">
                                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-300 group-focus-within/input:text-[#0077B6] transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-5.618 2.04c-1.28.143-2.52.41-3.693.791V11c0 5.022 3.363 9.423 8 11.314 4.637-1.891 8-6.292 8-11.314V5.771c-1.174-.381-2.413-.648-3.693-.791z"></path></svg>
                                        </div>
                                        <x-text-input 
                                            id="password_confirmation" 
                                            name="password_confirmation" 
                                            ::type="showConfirmPassword ? 'text' : 'password'" 
                                            class="block w-full h-14 pl-14 pr-12 rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] font-bold text-[#03045E] shadow-inner" 
                                            autocomplete="new-password" 
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
                                    <x-input-error class="mt-2 text-[10px] font-bold" :messages="$errors->get('password_confirmation')" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-20 pt-10 border-t border-slate-50 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-4 text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-xs font-medium italic text-slate-400">Pastikan seluruh data yang diinput sudah sesuai sebelum menyimpan.</p>
                    </div>
                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        <button type="submit" class="flex-1 sm:flex-none px-12 py-5 bg-[#03045E] text-white rounded-2xl font-black text-xs uppercase tracking-[0.3em] hover:bg-[#0077B6] transition-all shadow-2xl shadow-blue-900/40 active:scale-95 flex items-center justify-center gap-3 group">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.super-admin>
