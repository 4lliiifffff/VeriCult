<div class="space-y-12" x-data="categoryForm()" x-init="initData()">
    {{-- ================================================================== --}}
    {{-- SECTION A: UNESCO Category Table --}}
    {{-- ================================================================== --}}
    @if($categorySlug !== 'laporan-kebudayaan-aktif')
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
    @endif

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
            <h3 class="text-xs sm:text-sm font-black text-[#03045E] uppercase tracking-[0.1em] sm:tracking-[0.2em]">B. Identitas Umum — {{ $categoryName ?? ($submission->category ?? 'Kategori') }}</h3>
            <div class="flex-1 h-px bg-slate-100"></div>
        </div>

        <div class="bg-gradient-to-br from-white to-slate-50/50 rounded-2xl sm:rounded-[2.5rem] p-5 sm:p-8 md:p-10 border border-slate-100 shadow-xl shadow-slate-200/40 space-y-6 sm:space-y-8 relative">
            <div class="absolute -left-20 -bottom-20 w-64 h-64 bg-blue-50/50 rounded-full blur-3xl"></div>

            {{-- Periode Pelaporan (for Statistik and Aktif) --}}
            @if(in_array($categorySlug, ['laporan-kebudayaan-aktif', 'statistik', 'aktif']) || (isset($submission->submission_type) && in_array($submission->submission_type, ['statistik', 'aktif'])))
            <div class="space-y-4 group/input">
                <label for="period_year" class="block text-xs font-black text-slate-500 uppercase tracking-[0.15em]">Periode Tahun / Tanggal Laporan <span class="text-red-500">*</span></label>
                <div class="relative" x-data x-init="
                    flatpickr($refs.periodPicker, {
                        locale: 'id',
                        dateFormat: 'Y-m-d',
                        altInput: true,
                        altFormat: 'j F Y',
                        allowInput: true,
                        disableMobile: true,
                        defaultDate: '{{ old('period_year', $submission->period_year ?? date('Y-m-d')) }}',
                        onChange: function(selectedDates, dateStr) {
                            // We can store a full date or just extract the year later
                        }
                    })
                ">
                    <input type="text" x-ref="periodPicker" name="period_year" id="period_year" 
                        value="{{ old('period_year', $submission->period_year ?? '') }}"
                        required
                        readonly
                        class="w-full pl-6 pr-14 py-4.5 bg-white border-2 border-slate-100 rounded-2xl focus:border-[#0077B6] focus:ring-[6px] focus:ring-[#0077B6]/5 hover:border-slate-200 transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300 outline-none shadow-sm group-hover/input:shadow-md cursor-pointer"
                        placeholder="Pilih periode tahun atau tanggal...">
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within/input:text-[#0077B6] transition-colors pointer-events-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                @error('period_year')
                    <p class="text-[10px] text-red-600 font-black uppercase tracking-wider mt-1">{{ $message }}</p>
                @enderror
            </div>
            @endif

            {{-- Sub-category selector --}}
            @if($hasSub)
                <div class="space-y-4 group relative z-10">
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
                                'categoryFields' => $subFields
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
    @if(!in_array($categorySlug, ['laporan-kebudayaan-aktif', 'statistik', 'aktif']))
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#0077B6] to-[#03045E] flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
            </div>
            <h3 class="text-sm font-black text-[#03045E] uppercase tracking-[0.2em]">C. Deskripsi</h3>
            <div class="flex-1 h-px bg-slate-100"></div>
        </div>

        <div class="bg-gradient-to-br from-white to-slate-50/50 rounded-[2.5rem] p-8 sm:p-10 border border-slate-100 shadow-xl shadow-slate-200/40 relative">
            <label for="description" class="block text-xs font-black text-slate-500 uppercase tracking-[0.15em] mb-4">Deskripsi Kebudayaan <span class="text-red-500">*</span></label>
            <div class="relative group/field">
                <textarea name="description" id="description" rows="10" 
                    class="w-full px-8 py-8 bg-white border-2 border-slate-100 rounded-[2.5rem] focus:border-[#0077B6] focus:ring-[8px] focus:ring-[#0077B6]/5 hover:border-slate-200 transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300 outline-none resize-none leading-relaxed shadow-sm group-hover/field:shadow-md"
                    placeholder="Ceritakan sejarah, filosofi, dan karakteristik kebudayaan ini secara mendalam (Minimal 50 karakter)..."
                    required
                    data-category-field>{{ old('description', $submission->description ?? '') }}</textarea>
                
                <div class="absolute bottom-6 right-8 flex items-center gap-2 px-4 py-2 bg-slate-50 rounded-2xl text-[10px] font-black text-slate-400 uppercase tracking-widest border border-slate-100">
                    <span x-text="$el.closest('.group\\/field').querySelector('textarea').value.length"></span>/50 Karakter
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
    <div class="space-y-6">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#0077B6] to-[#03045E] flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
            </div>
            <h3 class="text-sm font-black text-[#03045E] uppercase tracking-[0.2em]">D. Data Dukung</h3>
            <div class="flex-1 h-px bg-slate-100"></div>
        </div>

        <div class="bg-gradient-to-br from-white to-slate-50/50 rounded-2xl sm:rounded-[2.5rem] p-5 sm:p-8 md:p-10 border border-slate-100 shadow-xl shadow-slate-200/40 space-y-6 sm:space-y-8">
            {{-- 1. Foto atau Gambar --}}
            <div class="space-y-4">
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.15em] flex items-center gap-3">
                    <span class="w-6 h-6 rounded-lg bg-[#0077B6]/10 text-[#0077B6] flex items-center justify-center text-[10px] font-black">01</span>
                    Foto & Video Dokumentasi
                </h4>
                <div 
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

                {{-- File List --}}
                <div x-show="files.length > 0" x-transition class="grid grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4 mt-4 sm:mt-6">
                    <template x-for="(file, index) in files" :key="index">
                        <div class="group/file flex items-center justify-between p-5 bg-white border-2 border-slate-50 rounded-3xl shadow-sm hover:shadow-xl hover:shadow-slate-200/50 hover:border-[#0077B6]/30 transition-all duration-300">
                            <div class="flex items-center gap-5 min-w-0">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 border border-slate-50 shadow-sm bg-blue-50 text-[#0077B6] font-black text-xs uppercase group-hover/file:bg-[#0077B6] group-hover/file:text-white transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-black text-slate-700 truncate group-hover/file:text-[#0077B6] transition-colors" x-text="file.name"></p>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]" x-text="formatSize(file.size)"></p>
                                </div>
                            </div>
                            <button type="button" @click.stop="removeFile(index)" class="w-10 h-10 flex items-center justify-center text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all active:scale-90">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Links Section --}}
            @if(!in_array($categorySlug, ['laporan-kebudayaan-aktif', 'statistik', 'aktif']))
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
        submissionName: '{{ old('name', $submission->name ?? '') }}',
        dragover: false,
        files: [],
        
        initData() {
            // Listen to any changes in specific fields that should populate name
            this.$watch('categoryData', (value) => {
                const nameField = 'b1_nama_objek';
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
            if (key === 'b1_nama_objek') {
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
            const newFiles = Array.from(e.target.files);
            this.files = [...this.files, ...newFiles].slice(0, 5);
        },

        removeFile(index) {
            this.files.splice(index, 1);
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
