@php
    $categorySlug = $categorySlug ?? (\App\Models\CulturalSubmission::getCategorySlug($submission->category ?? '') ?? '');
@endphp

<div class="space-y-12" x-data="categoryForm()" x-init="initData()">
    {{-- ================================================================== --}}
    {{-- SECTION A: UNESCO Category Table --}}
    {{-- ================================================================== --}}
    <!-- @if($categorySlug !== 'laporan-kebudayaan-aktif' && (!isset($hideUnesco) || !$hideUnesco))
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#0077B6] to-[#03045E] flex items-center justify-center text-white shadow-xl shadow-blue-500/20">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 4.5L2 9.5V11H22V9.5L12 4.5M4 12V18H7V12H4M9 12V18H12V12H9M14 12V18H17V12H14M19 12V18H22V12H19M2 19V21H22V19H2Z"/>
                </svg>
            </div>
            <h3 class="text-sm font-black text-[#03045E] uppercase tracking-[0.2em]">A. Kategori Objek Takbenda (UNESCO)</h3>
            <div class="flex-1 h-px bg-slate-100"></div>
        </div>

        <div class="bg-gradient-to-br from-white to-slate-50/50 rounded-[2.5rem] p-8 sm:p-10 border border-slate-100 shadow-xl shadow-slate-200/40 relative">
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-blue-50/50 rounded-full blur-3xl"></div>
            
            <p class="relative z-10 text-sm font-bold text-slate-500 mb-8 leading-relaxed">Berikan tanda centang pada salah satu pilihan domain dan kategori yang sesuai dengan objek yang akan diisi.</p>
            
            <div class="relative z-10 grid grid-cols-1 gap-4">
                @php
                    $unescoCategories = [
                        'Tradisi dan Ekspresi Lisan' => ['Bahasa Daerah', 'Naskah Kuno', 'Tradisi Lisan'],
                        'Adat Istiadat Masyarakat, Ritus, dan Perayaan' => ['Upacara atau Ritus'],
                        'Keterampilan dan Kemahiran Kerajinan Tradisional' => ['Arsitektur Tradisional', 'Kain Tradisional', 'Kerajinan Tradisional', 'Kuliner Tradisional', 'Pakaian Adat'],
                        'Pengetahuan dan Kebiasaan Perilaku Mengenai Alam Semesta' => ['Kearifan Lokal', 'Teknologi Tradisional'],
                        'Seni Pertunjukan' => ['Seni Tradisi'],
                    ];
                @endphp

                @foreach($unescoCategories as $domain => $items)
                    <div class="group/domain bg-white rounded-3xl border border-slate-100 p-2 hover:border-[#0077B6]/30 hover:shadow-lg transition-all duration-500">
                        <div class="px-5 py-3 bg-slate-50/50 rounded-2xl mb-2 group-hover/domain:bg-[#0077B6]/5 transition-colors">
                            <span class="text-xs font-black text-[#03045E] uppercase tracking-wider">{{ $domain }}</span>
                        </div>
                        <div class="p-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($items as $item)
                                <label class="flex items-center gap-4 cursor-pointer group/cb p-3 rounded-2xl border-2 border-transparent hover:bg-slate-50 transition-all">
                                    <input type="checkbox" name="category_data[unesco_categories][]" value="{{ $item }}"
                                        class="w-6 h-6 rounded-lg border-2 border-slate-200 text-[#0077B6] focus:ring-[#0077B6]/20 focus:ring-offset-0 transition-all group-hover/cb:border-[#0077B6]/50"
                                        @if(is_array(old('category_data.unesco_categories', $submission->category_data['unesco_categories'] ?? [])) && in_array($item, old('category_data.unesco_categories', $submission->category_data['unesco_categories'] ?? []))) checked @endif
                                        data-category-field>
                                    <span class="text-sm font-bold text-slate-600 group-hover/cb:text-[#03045E] transition-colors leading-tight">{{ $item }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif -->

    {{-- ================================================================== --}}
    {{-- SECTION B: Identitas Umum (Category-Specific Fields) --}}
    {{-- ================================================================== --}}
    @php
        $categoryConfig = $categoryFields;
        $hasSub = !empty($categoryConfig['has_sub']);
        $categoryDataValues = old('category_data', $submission->category_data ?? []);
        if (!is_array($categoryDataValues)) $categoryDataValues = [];
    @endphp

    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#0077B6] to-[#03045E] flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-xs sm:text-sm font-black text-[#03045E] uppercase tracking-[0.1em] sm:tracking-[0.2em]">Identitas Umum — {{ $categoryName ?? ($submission->category ?? 'Kategori') }}</h3>
            <div class="flex-1 h-px bg-slate-100"></div>
        </div>

        <div class="bg-gradient-to-br from-white to-slate-50/50 rounded-2xl sm:rounded-[2.5rem] p-5 sm:p-8 md:p-10 border border-slate-100 shadow-xl shadow-slate-200/40 space-y-6 sm:space-y-8 relative">
            <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-blue-50/50 rounded-full blur-3xl"></div>

            {{-- Sub-category selector --}}
            @if($hasSub)
                <div class="space-y-4 group relative transition-all duration-300" :class="openField === 'sub_category' ? 'z-[100]' : 'z-10'">
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.15em]">{{ $categoryConfig['sub_label'] ?? 'Pilih Sub-Kategori' }} <span class="text-red-500">*</span></label>
                    <div x-data="{ 
                            open: false, 
                            selectedKey: '{{ $categoryDataValues[$categoryConfig['sub_field']] ?? '' }}',
                            options: @js($categoryConfig['sub_options'] ?? []),
                            selectOption(key) {
                                this.selectedKey = key;
                                this.open = false;
                                setFieldValue('{{ $categoryConfig['sub_field'] }}', key);
                                this.activeSubCategory = key;
                            }
                         }"
                         x-init="$watch('open', val => { if(val) openField = 'sub_category'; else if(openField === 'sub_category') openField = null; })"
                         @click.away="open = false"
                         class="relative">
                        
                        <input type="hidden" name="category_data[{{ $categoryConfig['sub_field'] }}]" :value="selectedKey" data-category-field>
                        
                        <button type="button" 
                            @click="open = !open"
                            class="w-full flex items-center justify-between px-6 py-5 bg-white border-2 border-slate-100 rounded-2xl focus:border-[#0077B6] focus:ring-[6px] focus:ring-[#0077B6]/5 hover:border-slate-200 transition-all duration-300 outline-none shadow-sm"
                            :class="open ? 'border-[#0077B6] ring-[6px] ring-[#0077B6]/5 shadow-lg' : ''">
                            <span class="font-black" :class="selectedKey ? 'text-[#03045E]' : 'text-slate-400'" x-text="selectedKey ? options[selectedKey] : '{{ $categoryConfig['sub_label'] ?? 'Pilih sub-kategori...' }}'"></span>
                            <svg class="w-5 h-5 text-slate-400 transition-all duration-300" :class="open ? 'rotate-180 text-[#0077B6]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             class="absolute z-50 w-full mt-3 bg-white border border-slate-100 rounded-3xl shadow-2xl overflow-hidden py-3"
                             style="display: none;">
                            <template x-for="(label, key) in options" :key="key">
                                <button type="button" 
                                    @click="selectOption(key)"
                                    class="w-full text-left px-6 py-3.5 text-sm font-black transition-all duration-200 flex items-center justify-between group/opt"
                                    :class="selectedKey === key ? 'bg-[#0077B6]/5 text-[#0077B6]' : 'text-slate-600 hover:bg-slate-50 hover:text-[#0077B6]'">
                                    <span x-text="label"></span>
                                    <template x-if="selectedKey === key">
                                        <div class="w-6 h-6 rounded-full bg-[#0077B6] flex items-center justify-center shadow-lg shadow-blue-500/20">
                                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    </template>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Render fields for each sub-category --}}
                @foreach($categoryConfig['fields'] as $subKey => $subFields)
                    <div x-show="activeSubCategory === '{{ $subKey }}'" 
                         x-transition:enter="transition ease-out duration-500 delay-100"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="space-y-8 relative z-10">
                        @foreach($subFields as $fieldKey => $field)
                            @include('pengusul-desa.submissions.partials.field-renderer', [
                                'fieldKey' => $fieldKey,
                                'field' => $field,
                                'categoryDataValues' => $categoryDataValues,
                                'categoryFields' => $subFields,
                                'subKey' => $subKey
                            ])
                        @endforeach
                    </div>
                @endforeach
            @else
                {{-- Categories without sub-categories --}}
                <div class="space-y-8 relative z-10">
                    @foreach($categoryConfig as $fieldKey => $field)
                        @if(is_array($field) && isset($field['type']))
                            @include('pengusul-desa.submissions.partials.field-renderer', [
                                'fieldKey' => $fieldKey,
                                'field' => $field,
                                'categoryDataValues' => $categoryDataValues,
                                'categoryFields' => $categoryConfig
                            ])
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Hidden fields for main form --}}
    <input type="hidden" name="name" id="name" x-model="submissionName">

    {{-- ================================================================== --}}
    {{-- SECTION C: Deskripsi --}}
    {{-- ================================================================== --}}
    @if($categorySlug !== 'laporan-kebudayaan-aktif')
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#0077B6] to-[#03045E] flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
            </div>
            <h3 class="text-sm font-black text-[#03045E] uppercase tracking-[0.2em]">Deskripsi</h3>
            <div class="flex-1 h-px bg-slate-100"></div>
        </div>

        <div class="bg-gradient-to-br from-white to-slate-50/50 rounded-[2.5rem] p-8 sm:p-10 border border-slate-100 shadow-xl shadow-slate-200/40 relative" x-data="{ descCount: {{ strlen(old('description', $submission->description ?? '')) }} }">
            <label for="description" class="block text-xs font-black text-slate-500 uppercase tracking-[0.15em] mb-4">Deskripsi Kebudayaan <span class="text-red-500">*</span></label>
            <div class="relative group">
                <textarea name="description" id="description" rows="10" 
                    class="w-full px-8 py-8 bg-white border-2 border-slate-100 rounded-[2.5rem] focus:border-[#0077B6] focus:ring-[8px] focus:ring-[#0077B6]/5 hover:border-slate-200 transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300 outline-none resize-none leading-relaxed shadow-sm group-hover:shadow-md"
                    placeholder="Ceritakan sejarah, filosofi, dan karakteristik kebudayaan ini secara mendalam (Minimal 50 karakter)..."
                    required
                    @input="descCount = $el.value.length"
                    data-category-field>{{ old('description', $submission->description ?? '') }}</textarea>
                
                <div class="absolute bottom-6 right-8 flex items-center gap-2 px-4 py-2 bg-slate-50 rounded-2xl text-[10px] font-black text-slate-400 uppercase tracking-widest border border-slate-100">
                    <span x-text="descCount"></span>/50 Karakter
                </div>
            </div>
            @error('description')
                <p class="flex items-center gap-2 mt-4 px-2 text-[10px] text-red-600 font-black uppercase tracking-wider animate-shake">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
    @endif

    {{-- ================================================================== --}}
    {{-- SECTION D: Data Dukung --}}
    {{-- ================================================================== --}}
    @if(!isset($hideFiles) || !$hideFiles)
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#0077B6] to-[#03045E] flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
            </div>
            <h3 class="text-sm font-black text-[#03045E] uppercase tracking-[0.2em]">Data Dukung</h3>
            <div class="flex-1 h-px bg-slate-100"></div>
        </div>

        <div class="bg-gradient-to-br from-white to-slate-50/50 rounded-2xl sm:rounded-[2.5rem] p-5 sm:p-8 md:p-10 border border-slate-100 shadow-xl shadow-slate-200/40 space-y-6 sm:space-y-8">
            {{-- 1. Foto atau Gambar --}}
            <div class="space-y-4">
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.15em] flex items-center gap-3">
                    <span class="w-6 h-6 rounded-lg bg-[#0077B6]/10 text-[#0077B6] flex items-center justify-center text-[10px] font-black">01</span>
                    Foto & Video Dokumentasi
                </h4>

                {{-- Existing Files (from DB) --}}
                @if(isset($submission) && $submission instanceof \App\Models\CulturalSubmission && $submission->files->count() > 0)
                <div class="mb-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 flex items-center gap-2">
                        <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Lampiran yang Sudah Diunggah
                    </p>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($submission->files as $existingFile)
                        <div class="group/file relative flex flex-col p-3 bg-white border-2 border-emerald-50 rounded-3xl shadow-sm hover:shadow-xl hover:shadow-slate-200/50 hover:border-emerald-200/60 transition-all duration-300 overflow-hidden">
                            <!-- Preview Area -->
                            <div class="relative w-full h-32 sm:h-40 rounded-[1.5rem] overflow-hidden bg-slate-50 flex items-center justify-center shrink-0 mb-3 border border-slate-50/50 shadow-inner">
                                @if($existingFile->file_icon === 'image')
                                    <img src="{{ Storage::url($existingFile->path) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover/file:scale-110" alt="{{ $existingFile->original_name }}">
                                    <div class="absolute inset-0 bg-black/0 group-hover/file:bg-black/20 transition-colors flex items-center justify-center opacity-0 group-hover/file:opacity-100">
                                        <button type="button" @click="openPreview({ previewUrl: '{{ Storage::url($existingFile->path) }}', isImage: true, isVideo: false, isExisting: true, name: '{{ addslashes($existingFile->original_name) }}', size: {{ $existingFile->file_size ?? 0 }} })" class="w-12 h-12 rounded-2xl bg-white text-[#03045E] shadow-xl flex items-center justify-center hover:scale-110 transition-transform active:scale-95">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                    </div>
                                @elseif($existingFile->file_icon === 'video')
                                    <div class="w-full h-full bg-slate-200 flex items-center justify-center relative">
                                        <video src="{{ Storage::url($existingFile->path) }}" class="w-full h-full object-cover" preload="metadata"></video>
                                        <div class="absolute inset-0 bg-black/0 group-hover/file:bg-black/20 transition-colors flex items-center justify-center opacity-0 group-hover/file:opacity-100">
                                            <button type="button" @click="openPreview({ previewUrl: '{{ Storage::url($existingFile->path) }}', isImage: false, isVideo: true, isExisting: true, name: '{{ addslashes($existingFile->original_name) }}', size: {{ $existingFile->file_size ?? 0 }} })" class="w-12 h-12 rounded-2xl bg-white text-[#03045E] shadow-xl flex items-center justify-center hover:scale-110 transition-transform active:scale-95">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center text-slate-300 gap-1">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <span class="text-[10px] font-black uppercase tracking-widest text-[#0077B6]">{{ strtoupper($existingFile->extension ?? pathinfo($existingFile->original_name, PATHINFO_EXTENSION)) }}</span>
                                    </div>
                                @endif
                                <!-- Existing badge -->
                                <div class="absolute top-2 left-2">
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-500 text-white text-[8px] font-black uppercase tracking-wider shadow">Tersimpan</span>
                                </div>
                            </div>

                            <!-- File Info -->
                            <div class="flex items-center justify-between min-w-0 px-1">
                                <div class="min-w-0 pr-2">
                                    <p class="text-sm font-black text-slate-700 truncate group-hover/file:text-[#0077B6] transition-colors" title="{{ $existingFile->original_name }}">{{ $existingFile->original_name }}</p>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ $existingFile->file_size_human }}</p>
                                </div>
                                {{-- Delete via JS to avoid nested form inside parent form --}}
                                <button type="button"
                                    onclick="deleteExistingFile('{{ route('pengusul-desa.submissions.files.destroy', [$submission, $existingFile]) }}')"
                                    class="w-8 h-8 shrink-0 flex items-center justify-center text-rose-300 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-all active:scale-90" title="Hapus File">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- File List (Previews) --}}
                <div x-show="files.length > 0" x-transition class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 mb-6">
                    <template x-for="(item, index) in files" :key="index">
                        <div class="group/file relative flex flex-col p-3 bg-white border-2 border-slate-50 rounded-3xl shadow-sm hover:shadow-xl hover:shadow-slate-200/50 hover:border-[#0077B6]/30 transition-all duration-300 overflow-hidden">
                            <!-- Preview Area -->
                            <div class="relative w-full h-32 sm:h-40 rounded-[1.5rem] overflow-hidden bg-slate-50 flex items-center justify-center shrink-0 mb-3 border border-slate-50/50 shadow-inner group-hover/file:border-[#0077B6]/20 transition-colors">
                                <template x-if="item.isImage">
                                    <div class="w-full h-full relative">
                                        <img :src="item.previewUrl" class="w-full h-full object-cover transition-transform duration-700 group-hover/file:scale-110">
                                        <div class="absolute inset-0 bg-black/0 group-hover/file:bg-black/20 transition-colors flex items-center justify-center opacity-0 group-hover/file:opacity-100">
                                            <button type="button" @click="openPreview(item)" class="w-12 h-12 rounded-2xl bg-white text-[#03045E] shadow-xl flex items-center justify-center hover:scale-110 transition-transform active:scale-95">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="item.isVideo">
                                    <div class="w-full h-full bg-slate-200 flex items-center justify-center relative">
                                        <video :src="item.previewUrl" class="w-full h-full object-cover transition-transform duration-700 group-hover/file:scale-110" preload="metadata"></video>
                                        <div class="absolute inset-0 bg-black/0 group-hover/file:bg-black/20 transition-colors flex items-center justify-center opacity-0 group-hover/file:opacity-100">
                                            <button type="button" @click="openPreview(item)" class="w-12 h-12 rounded-2xl bg-white text-[#03045E] shadow-xl flex items-center justify-center hover:scale-110 transition-transform active:scale-95">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                                <template x-if="!item.isImage && !item.isVideo">
                                    <div class="text-slate-300">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <span class="text-[10px] font-black uppercase tracking-widest text-[#0077B6] absolute bottom-2 left-1/2 -translate-x-1/2" x-text="item.name.split('.').pop()"></span>
                                    </div>
                                </template>
                            </div>
                            
                            <!-- File Info -->
                            <div class="flex items-center justify-between min-w-0 px-1">
                                <div class="min-w-0 pr-2">
                                    <p class="text-sm font-black text-slate-700 truncate group-hover/file:text-[#0077B6] transition-colors" x-text="item.name" :title="item.name"></p>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]" x-text="formatSize(item.size)"></p>
                                </div>
                                <button type="button" @click.stop="removeFile(index)" class="w-8 h-8 shrink-0 flex items-center justify-center text-rose-300 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-all active:scale-90" title="Hapus File">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Dropzone --}}
                <div 
                    x-show="files.length < 5"
                    @click="$refs.fileInput.click()"
                    :class="dragover ? 'border-[#0077B6] bg-[#0077B6]/5 scale-[1.01] shadow-2xl shadow-[#0077B6]/10' : 'border-slate-100 hover:border-[#0077B6] hover:bg-white hover:shadow-2xl hover:shadow-slate-200/50'"
                    class="group relative border-2 border-dashed rounded-2xl sm:rounded-[2.5rem] p-6 sm:p-12 text-center transition-all duration-500 cursor-pointer bg-slate-50/30 overflow-hidden"
                >
                    <div class="absolute -right-20 -top-20 w-56 h-56 bg-blue-50/50 rounded-full blur-3xl group-hover:bg-blue-100/30 transition-colors"></div>
                    <input type="file" name="files[]" id="files" multiple class="hidden" x-ref="fileInput" @change="handleFileSelect" accept=".jpg,.jpeg,.png,.gif,.webp,.mp4,.mov,.webm">
                    
                    <div class="relative z-10 space-y-4">
                        <div class="mx-auto w-14 h-14 sm:w-20 sm:h-20 rounded-2xl sm:rounded-3xl bg-white shadow-xl flex items-center justify-center text-[#0077B6] group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 border border-slate-50">
                            <svg class="w-7 h-7 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-base sm:text-lg font-black text-[#03045E] mb-1 sm:mb-2 group-hover:text-[#0077B6] transition-colors">Tarik Foto/Video ke Sini</h4>
                            <p class="text-xs sm:text-sm text-slate-500 font-bold">Atau klik untuk memilih file dari perangkat Anda</p>
                            <div class="mt-3 sm:mt-4 flex flex-wrap justify-center gap-2">
                                <span class="px-3 py-1 bg-white border border-slate-100 rounded-lg text-[9px] font-black text-slate-400 uppercase tracking-widest shadow-sm">JPG/PNG</span>
                                <span class="px-3 py-1 bg-white border border-slate-100 rounded-lg text-[9px] font-black text-slate-400 uppercase tracking-widest shadow-sm">MP4</span>
                                <span class="px-3 py-1 bg-white border border-slate-100 rounded-lg text-[9px] font-black text-slate-400 uppercase tracking-widest shadow-sm">WEBP/MOV</span>
                            </div>
                        </div>
                    </div>
                </div>
                @error('files')
                    <p class="flex items-center gap-2 mt-4 px-2 text-[10px] text-red-600 font-black uppercase tracking-wider animate-shake">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Links Section --}}
            @if($categorySlug !== 'laporan-kebudayaan-aktif')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- 2. Video URL --}}
                <div class="space-y-4 group/input">
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.15em] flex items-center gap-3">
                        <span class="w-6 h-6 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-[10px] font-black">02</span>
                        Tautan Video
                    </h4>
                    <div class="relative">
                        <input type="text" name="category_data[video_url]" id="video_url" 
                            value="{{ $categoryDataValues['video_url'] ?? '' }}"
                            data-category-field
                            class="w-full pl-6 pr-14 py-4.5 bg-white border-2 border-slate-100 rounded-2xl focus:border-[#0077B6] focus:ring-[6px] focus:ring-[#0077B6]/5 hover:border-slate-200 transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300 outline-none shadow-sm"
                            placeholder="Alamat tautan Video (YouTube/Lainnya)">
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within/input:text-[#0077B6] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                </div>

                {{-- 3. Dokumen Kajian --}}
                <div class="space-y-4 group/input">
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.15em] flex items-center gap-3">
                        <span class="w-6 h-6 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-[10px] font-black">03</span>
                        Kajian Objek
                    </h4>
                    <div class="relative">
                        <input type="text" name="category_data[dokumen_kajian_url]" id="dokumen_kajian_url" 
                            value="{{ $categoryDataValues['dokumen_kajian_url'] ?? '' }}"
                            data-category-field
                            class="w-full pl-6 pr-14 py-4.5 bg-white border-2 border-slate-100 rounded-2xl focus:border-[#0077B6] focus:ring-[6px] focus:ring-[#0077B6]/5 hover:border-slate-200 transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300 outline-none shadow-sm"
                            placeholder="Alamat tautan Dokumen Kajian">
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within/input:text-[#0077B6] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                    </div>
                </div>

                {{-- 4. Dokumen Lainnya --}}
                <div class="space-y-4 group/input md:col-span-2">
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.15em] flex items-center gap-3">
                        <span class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-[10px] font-black">04</span>
                        Dokumen Pendukung Lainnya
                    </h4>
                    <div class="relative">
                        <input type="text" name="category_data[dokumen_lainnya_url]" id="dokumen_lainnya_url" 
                            value="{{ $categoryDataValues['dokumen_lainnya_url'] ?? '' }}"
                            data-category-field
                            class="w-full pl-6 pr-14 py-4.5 bg-white border-2 border-slate-100 rounded-2xl focus:border-[#0077B6] focus:ring-[6px] focus:ring-[#0077B6]/5 hover:border-slate-200 transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300 outline-none shadow-sm"
                            placeholder="Alamat tautan dokumen lainnya (Drive/DropBox/Lainnya)">
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within/input:text-[#0077B6] transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.826a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Fullscreen Preview Modal --}}
    <template x-teleport="body">
        <div class="fixed inset-0 z-[110] flex items-center justify-center p-4 sm:p-6" x-show="showPreviewModal" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <div class="absolute inset-0 bg-slate-900/80" @click="closePreview()"></div>
            <div class="relative w-full max-w-6xl max-h-full bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/10 flex flex-col">
                <!-- Modal Header -->
                <div class="p-6 sm:p-8 flex items-center justify-between border-b border-white/5 bg-slate-900/50 backdrop-blur-md">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-[#00B4D8]">
                            <template x-if="previewFile?.isImage">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </template>
                            <template x-if="previewFile?.isVideo">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </template>
                        </div>
                        <div>
                            <h3 class="text-white font-black text-lg tracking-tight" x-text="previewFile?.name"></h3>
                            <p class="text-white/40 text-[10px] font-black uppercase tracking-[0.2em]" x-text="formatSize(previewFile?.size || 0)"></p>
                        </div>
                    </div>
                    <button type="button" @click="closePreview()" class="w-12 h-12 rounded-2xl bg-white/5 text-white/50 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all group">
                        <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Content Container -->
                <div class="w-full bg-black/20 rounded-[2.5rem] border border-white/10 overflow-hidden shadow-2xl flex items-center justify-center relative group/inner min-h-[300px]">
                    <template x-if="previewFile?.isImage">
                        <img :src="previewFile?.previewUrl" class="max-w-full max-h-[70vh] object-contain select-none">
                    </template>
                    <template x-if="previewFile?.isVideo">
                        <video :src="previewFile?.previewUrl" controls autoplay class="max-w-full max-h-[70vh]"></video>
                    </template>
                    
                    <!-- Floating Download Link -->
                    <template x-if="previewFile">
                        <a :href="previewFile?.previewUrl" download x-bind:download="previewFile?.name" class="absolute bottom-8 right-8 px-6 py-3 bg-white text-[#03045E] rounded-xl font-black text-[10px] uppercase tracking-widest shadow-xl hover:bg-[#00B4D8] hover:text-white transition-all opacity-0 group-hover/inner:opacity-100 translate-y-4 group-hover/inner:translate-y-0 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Unduh Berkas
                        </a>
                    </template>
                </div>
            </div>
        </div>
    </template>
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

<script>
function categoryForm() {
    return {
        activeSubCategory: @json($categoryDataValues[$categoryConfig['sub_field'] ?? ''] ?? ''),
        categoryData: @json($categoryDataValues),
        submissionName: @js(old('name', $submission->name ?? '')),
        dragover: false,
        files: [],
        showPreviewModal: false,
        previewFile: null,
        openField: null,

        openPreview(item) {
            this.previewFile = item;
            this.showPreviewModal = true;
            document.body.style.overflow = 'hidden';
        },

        closePreview() {
            this.showPreviewModal = false;
            document.querySelectorAll('video').forEach(v => v.pause());
            document.body.style.overflow = '';
            setTimeout(() => {
                this.previewFile = null;
            }, 300);
        },
        
        initData() {
            // Listen to any changes in specific fields that should populate name
            this.$watch('categoryData', (value) => {
                const isLaporanAktif = '{{ $categorySlug }}' === 'laporan-kebudayaan-aktif';
                const nameField = isLaporanAktif ? 'nama_dan_jenis_kebudayaan' : 'nama_objek';
                if (value[nameField]) {
                    this.submissionName = value[nameField];
                }
            }, { deep: true });
        },

        getFieldValue(key) {
            return this.categoryData[key] || '';
        },
        
        setFieldValue(key, value) {
            this.categoryData[key] = value;
            // Update submissionName if it's the name field
            const isLaporanAktif = '{{ $categorySlug }}' === 'laporan-kebudayaan-aktif';
            const nameField = isLaporanAktif ? 'nama_dan_jenis_kebudayaan' : 'nama_objek';
            if (key === nameField) {
                this.submissionName = value;
            }
        },

        // Dynamic table management
        dynamicTables: {},
        
        initDynamicTable(key, columns) {
            let existing = this.categoryData[key];
            if (existing && Array.isArray(existing) && existing.length > 0) {
                this.dynamicTables[key] = existing;
            } else {
                let row = {};
                columns.forEach(c => row[c] = '');
                this.dynamicTables[key] = [row];
                this.categoryData[key] = this.dynamicTables[key];
            }
        },
        
        addTableRow(key, columns) {
            if (!this.dynamicTables[key]) this.dynamicTables[key] = [];
            let row = {};
            columns.forEach(c => row[c] = '');
            this.dynamicTables[key].push(row);
        },
        
        removeTableRow(key, index) {
            if (this.dynamicTables[key] && this.dynamicTables[key].length > 1) {
                this.dynamicTables[key].splice(index, 1);
            }
        },

        handleFileSelect(e) {
            Array.from(e.target.files).forEach(file => {
                this.files.push({
                    file: file,
                    name: file.name,
                    size: file.size,
                    type: file.type,
                    previewUrl: URL.createObjectURL(file),
                    isImage: file.type.startsWith('image/'),
                    isVideo: file.type.startsWith('video/')
                });
            });
            this.files = this.files.slice(0, 5);
            this.syncFileInput();
        },

        removeFile(index) {
            if (this.files[index].previewUrl) {
                URL.revokeObjectURL(this.files[index].previewUrl);
            }
            this.files.splice(index, 1);
            this.syncFileInput();
        },

        syncFileInput() {
            const dt = new DataTransfer();
            this.files.forEach(item => dt.items.add(item.file));
            this.$refs.fileInput.files = dt.files;
        },

        formatSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    }
}
</script>
