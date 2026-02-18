<div class="space-y-8">
    <!-- Main Info Section -->
    <div class="space-y-6">
        <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-3">
            <span>Informasi Utama</span>
            <div class="flex-1 h-px bg-slate-100"></div>
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div class="space-y-2 group">
                <label for="name" class="block text-sm font-bold text-slate-700 transition-colors group-focus-within:text-[#0077B6]">Nama Kebudayaan <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="text" name="name" id="name" value="{{ old('name', $submission->name ?? '') }}" 
                        class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-[1.25rem] focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/5 hover:bg-slate-100/50 transition-all duration-300 font-medium placeholder:text-slate-400 outline-none"
                        placeholder="Masukkan nama kebudayaan..."
                        required>
                </div>
                @error('name')
                    <p class="flex items-center gap-2 mt-1 text-xs text-red-600 font-medium animate-shake">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Category -->
            <div class="space-y-2 group" 
                 x-data="{ 
                    open: false, 
                    selected: '{{ old('category', $submission->category ?? '') }}',
                    options: [
                        'Tradisi Lisan',
                        'Seni Pertunjukan',
                        'Adat Istiadat',
                        'Pengetahuan Tradisional',
                        'Keterampilan Tradisional',
                        'Lainnya'
                    ],
                    selectOption(option) {
                        this.selected = option;
                        this.open = false;
                        // For form compatibility
                        $refs.nativeSelect.value = option;
                        $refs.nativeSelect.dispatchEvent(new Event('change'));
                    }
                 }"
                 @click.away="open = false">
                <label class="block text-sm font-bold text-slate-700 transition-colors group-focus-within:text-[#0077B6]">Kategori <span class="text-red-500">*</span></label>
                
                <div class="relative">
                    <!-- Hidden Native Select (for form submission) -->
                    <select name="category" x-ref="nativeSelect" class="hidden" required>
                        <option value="">Pilih Kategori</option>
                        <template x-for="option in options">
                            <option :value="option" x-text="option" :selected="selected === option"></option>
                        </template>
                    </select>

                    <!-- Custom Dropdown Trigger -->
                    <button type="button" 
                        @click="open = !open"
                        class="w-full flex items-center justify-between px-5 py-4 bg-slate-50 border-2 border-transparent rounded-[1.25rem] focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/5 hover:bg-slate-100/50 transition-all duration-300 outline-none group/trigger"
                        :class="open ? 'bg-white border-[#0077B6] ring-4 ring-[#0077B6]/5' : ''">
                        <span class="font-medium" :class="selected ? 'text-slate-700' : 'text-slate-400'" x-text="selected || 'Pilih Kategori'"></span>
                        <svg class="w-5 h-5 text-slate-400 group-hover/trigger:text-[#0077B6] transition-all duration-300" 
                             :class="open ? 'rotate-180 text-[#0077B6]' : ''" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                         class="absolute z-50 w-full mt-3 bg-white border border-slate-100 rounded-[1.5rem] shadow-2xl shadow-[#03045E]/10 overflow-hidden py-2"
                         style="display: none;">
                        <template x-for="option in options">
                            <button type="button" 
                                @click="selectOption(option)"
                                class="w-full text-left px-5 py-3.5 text-sm font-bold transition-all duration-200 flex items-center justify-between group/opt"
                                :class="selected === option ? 'bg-[#0077B6]/5 text-[#0077B6]' : 'text-slate-600 hover:bg-slate-50 hover:text-[#0077B6]'">
                                <span x-text="option"></span>
                                <template x-if="selected === option">
                                    <svg class="w-4 h-4 text-[#0077B6]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                </template>
                            </button>
                        </template>
                    </div>
                </div>

                @error('category')
                    <p class="flex items-center gap-2 mt-1 text-xs text-red-600 font-medium animate-shake">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <!-- Address -->
        <div class="space-y-2 group">
            <label for="address" class="block text-sm font-bold text-slate-700 transition-colors group-focus-within:text-[#0077B6]">Alamat Lokasi <span class="text-red-500">*</span></label>
            <div class="relative">
                <input type="text" name="address" id="address" value="{{ old('address', $submission->address ?? '') }}" 
                    class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-[1.25rem] focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/5 hover:bg-slate-100/50 transition-all duration-300 font-medium placeholder:text-slate-400 outline-none"
                    placeholder="Masukkan lokasi asal kebudayaan..."
                    required>
                <div class="absolute inset-y-0 right-0 flex items-center pr-5 text-slate-300 group-focus-within:text-[#0077B6] transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
            </div>
            @error('address')
                <p class="flex items-center gap-2 mt-1 text-xs text-red-600 font-medium animate-shake">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>

    <!-- Description Section -->
    <div class="space-y-6">
        <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-3">
            <span>Narasi & Deskripsi</span>
            <div class="flex-1 h-px bg-slate-100"></div>
        </h3>

        <div class="space-y-2 group">
            <label for="description" class="block text-sm font-bold text-slate-700 transition-colors group-focus-within:text-[#0077B6]">Deskripsi Kebudayaan <span class="text-red-500">*</span></label>
            <div class="relative">
                <textarea name="description" id="description" rows="8" 
                    class="w-full px-5 py-5 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/5 hover:bg-slate-100/50 transition-all duration-300 font-medium placeholder:text-slate-400 outline-none resize-none leading-relaxed"
                    placeholder="Ceritakan sejarah, filosofi, dan karakteristik kebudayaan ini secara mendalam (Minimal 50 karakter)..."
                    required>{{ old('description', $submission->description ?? '') }}</textarea>
                <div class="absolute bottom-4 right-4 text-[10px] font-bold text-slate-300 tracking-widest uppercase">
                    Markdown Terintegrasi
                </div>
            </div>
            @error('description')
                <p class="flex items-center gap-2 mt-1 text-xs text-red-600 font-medium animate-shake">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>

    <!-- Media Upload Section -->
    <div class="space-y-6">
        <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-3">
            <span>Bukti Digital</span>
            <div class="flex-1 h-px bg-slate-100"></div>
        </h3>

        <div class="space-y-4">
            <!-- New Dropzone Design -->
            <div 
                @click="$refs.fileInput.click()"
                :class="dragover ? 'border-[#0077B6] bg-[#0077B6]/5 scale-[1.01] shadow-2xl shadow-[#0077B6]/10' : 'border-slate-200 hover:border-[#0077B6] hover:shadow-xl hover:shadow-slate-200/50'"
                class="group relative border-2 border-dashed rounded-[2rem] p-12 text-center transition-all duration-500 cursor-pointer bg-slate-50/30 overflow-hidden"
            >
                <!-- Animated Background Decorative Elements -->
                <div class="absolute -right-16 -top-16 w-48 h-48 bg-blue-50 rounded-full blur-3xl group-hover:bg-blue-100/50 transition-colors"></div>
                <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-cyan-50 rounded-full blur-3xl group-hover:bg-cyan-100/50 transition-colors"></div>

                <input type="file" name="files[]" id="files" multiple class="hidden" x-ref="fileInput" @change="handleFileSelect" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp,.mp4,.avi,.mov">
                
                <div class="relative z-10 space-y-5">
                    <div class="mx-auto w-24 h-24 rounded-3xl bg-white shadow-lg flex items-center justify-center text-[#0077B6] group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 border border-slate-50">
                        <div class="relative">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            <div class="absolute -right-1 -top-1 w-4 h-4 bg-[#00B4D8] rounded-full animate-ping opacity-75"></div>
                            <div class="absolute -right-1 -top-1 w-4 h-4 bg-[#00B4D8] rounded-full"></div>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-xl font-black text-[#03045E] mb-1 group-hover:text-[#0077B6] transition-colors">Pilih atau Seret Dokumen</h4>
                        <p class="text-sm text-slate-500 font-medium">Unggah hingga 5 file pendukung (Foto, Video, atau PDF)</p>
                    </div>
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-slate-100 text-[10px] font-black tracking-widest text-slate-400 uppercase">
                        Maksimal 10MB per file
                    </div>
                </div>
            </div>

            @error('files')
                <p class="text-center text-xs text-red-600 font-bold animate-shake">{{ $message }}</p>
            @enderror

            <!-- Modern File Chip List -->
            <div x-show="files.length > 0" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8">
                <template x-for="(file, index) in files" :key="index">
                    <div class="group/file flex items-center justify-between p-4 bg-white border border-slate-100 rounded-[1.25rem] shadow-sm hover:shadow-xl hover:shadow-slate-200/50 hover:border-[#0077B6]/30 transition-all duration-300">
                        <div class="flex items-center gap-4 min-w-0">
                            <!-- Type Specific Icon -->
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 border border-slate-50 shadow-sm"
                                 :class="{
                                    'bg-green-50 text-green-600': file.type.startsWith('image/'),
                                    'bg-purple-50 text-purple-600': file.type.startsWith('video/'),
                                    'bg-blue-50 text-blue-600': !file.type.startsWith('image/') && !file.type.startsWith('video/')
                                 }">
                                <template x-if="file.type.startsWith('image/')">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </template>
                                <template x-if="file.type.startsWith('video/')">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10z"></path></svg>
                                </template>
                                <template x-if="!file.type.startsWith('image/') && !file.type.startsWith('video/')">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </template>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-black text-slate-700 truncate group-hover/file:text-[#0077B6] transition-colors" x-text="file.name"></p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider" x-text="formatSize(file.size)"></p>
                            </div>
                        </div>
                        <button type="button" @click.stop="removeFile(index)" class="p-2 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all active:scale-90">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-4px); }
        75% { transform: translateX(4px); }
    }
    .animate-shake {
        animation: shake 0.4s ease-in-out infinite;
        animation-iteration-count: 2;
    }
</style>
