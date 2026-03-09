<div class="space-y-8" x-data="categoryForm()">
    {{-- ================================================================== --}}
    {{-- SECTION A: UNESCO Category Table --}}
    {{-- ================================================================== --}}
    <div class="space-y-6">
        <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-3">
            <span>A. Kategori Objek Takbenda (UNESCO)</span>
            <div class="flex-1 h-px bg-slate-100"></div>
        </h3>

        <div class="bg-gradient-to-br from-slate-50/50 to-blue-50/30 rounded-[1.5rem] p-6 sm:p-8 border border-slate-100">
            <p class="text-sm text-slate-500 mb-6">Berikan tanda centang pada salah satu pilihan domain dan kategori yang sesuai dengan objek yang akan diisi.</p>
            
            <div class="space-y-4">
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
                    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
                        <div class="px-5 py-3 bg-slate-50 border-b border-slate-100">
                            <span class="text-sm font-bold text-[#03045E]">{{ $domain }}</span>
                        </div>
                        <div class="p-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($items as $item)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" name="category_data[unesco_categories][]" value="{{ $item }}"
                                        class="w-5 h-5 rounded-lg border-2 border-slate-200 text-[#0077B6] focus:ring-[#0077B6]/20 focus:ring-offset-0 transition-colors"
                                        @if(is_array(old('category_data.unesco_categories', $submission->category_data['unesco_categories'] ?? [])) && in_array($item, old('category_data.unesco_categories', $submission->category_data['unesco_categories'] ?? []))) checked @endif
                                        data-category-field>
                                    <span class="text-sm font-medium text-slate-600 group-hover:text-[#0077B6] transition-colors">{{ $item }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

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
        <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-3">
            <span>B. Identitas Umum — {{ $categoryName ?? ($submission->category ?? 'Kategori') }}</span>
            <div class="flex-1 h-px bg-slate-100"></div>
        </h3>

        <div class="bg-gradient-to-br from-slate-50/50 to-blue-50/30 rounded-[1.5rem] p-6 sm:p-8 border border-slate-100 space-y-6">

            {{-- Sub-category selector for categories with sub-types --}}
            @if($hasSub)
                <div class="space-y-2 group">
                    <label class="block text-sm font-bold text-slate-700">{{ $categoryConfig['sub_label'] ?? 'Pilih Sub-Kategori' }} <span class="text-red-500">*</span></label>
                    <div x-data="{ 
                            open: false, 
                            selected: categoryData['{{ $categoryConfig['sub_field'] }}'] || '',
                            options: @js($categoryConfig['sub_options'] ?? []),
                            selectOption(key, label) {
                                this.selected = key;
                                this.open = false;
                                this.categoryData['{{ $categoryConfig['sub_field'] }}'] = key;
                                this.activeSubCategory = key;
                            }
                         }"
                         @click.away="open = false"
                         class="relative">
                        
                        <input type="hidden" name="category_data[{{ $categoryConfig['sub_field'] }}]" :value="selected" data-category-field>
                        
                        <button type="button" 
                            @click="open = !open"
                            class="w-full flex items-center justify-between px-5 py-4 bg-white border-2 border-transparent rounded-[1.25rem] focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/5 hover:bg-slate-50 transition-all duration-300 outline-none"
                            :class="open ? 'border-[#0077B6] ring-4 ring-[#0077B6]/5' : ''">
                            <span class="font-medium" :class="selected ? 'text-slate-700' : 'text-slate-400'" x-text="selected ? options[selected] : '{{ $categoryConfig['sub_label'] ?? 'Pilih sub-kategori...' }}'"></span>
                            <svg class="w-5 h-5 text-slate-400 transition-all duration-300" :class="open ? 'rotate-180 text-[#0077B6]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                             class="absolute z-50 w-full mt-3 bg-white border border-slate-100 rounded-[1.5rem] shadow-2xl shadow-[#03045E]/10 overflow-hidden py-2"
                             style="display: none;">
                            <template x-for="(label, key) in options" :key="key">
                                <button type="button" 
                                    @click="selectOption(key, label)"
                                    class="w-full text-left px-5 py-3.5 text-sm font-bold transition-all duration-200 flex items-center justify-between"
                                    :class="selected === key ? 'bg-[#0077B6]/5 text-[#0077B6]' : 'text-slate-600 hover:bg-slate-50 hover:text-[#0077B6]'">
                                    <span x-text="label"></span>
                                    <template x-if="selected === key">
                                        <svg class="w-4 h-4 text-[#0077B6]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    </template>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Render fields for each sub-category --}}
                @foreach($categoryConfig['fields'] as $subKey => $subFields)
                    <div x-show="activeSubCategory === '{{ $subKey }}'" x-transition class="space-y-6">
                        @foreach($subFields as $fieldKey => $field)
                            @include('pengusul.submissions.partials.field-renderer', [
                                'fieldKey' => $fieldKey,
                                'field' => $field,
                                'categoryDataValues' => $categoryDataValues,
                            ])
                        @endforeach
                    </div>
                @endforeach
            @else
                {{-- Categories without sub-categories --}}
                @foreach($categoryConfig as $fieldKey => $field)
                    @if(is_array($field) && isset($field['type']))
                        @include('pengusul.submissions.partials.field-renderer', [
                            'fieldKey' => $fieldKey,
                            'field' => $field,
                            'categoryDataValues' => $categoryDataValues,
                        ])
                    @endif
                @endforeach
            @endif
        </div>
    </div>

    {{-- ================================================================== --}}
    {{-- Hidden fields for main form (name, category, address) --}}
    {{-- ================================================================== --}}
    <input type="hidden" name="name" id="name" value="{{ old('name', $submission->name ?? ($categoryDataValues['b1_nama_objek'] ?? '')) }}">

    {{-- ================================================================== --}}
    {{-- SECTION C: Deskripsi --}}
    {{-- ================================================================== --}}
    <div class="space-y-6">
        <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-3">
            <span>C. Deskripsi</span>
            <div class="flex-1 h-px bg-slate-100"></div>
        </h3>

        <div class="space-y-2 group">
            <label for="description" class="block text-sm font-bold text-slate-700 transition-colors group-focus-within:text-[#0077B6]">Deskripsi Kebudayaan <span class="text-red-500">*</span></label>
            <div class="relative">
                <textarea name="description" id="description" rows="8" 
                    class="w-full px-5 py-5 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/5 hover:bg-slate-100/50 transition-all duration-300 font-medium placeholder:text-slate-400 outline-none resize-none leading-relaxed"
                    placeholder="Ceritakan sejarah, filosofi, dan karakteristik kebudayaan ini secara mendalam (Minimal 50 karakter)..."
                    required
                    data-category-field>{{ old('description', $submission->description ?? '') }}</textarea>
            </div>
            @error('description')
                <p class="flex items-center gap-2 mt-1 text-xs text-red-600 font-medium animate-shake">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>

    {{-- ================================================================== --}}
    {{-- SECTION D: Data Dukung --}}
    {{-- ================================================================== --}}
    <div class="space-y-6">
        <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-3">
            <span>D. Data Dukung</span>
            <div class="flex-1 h-px bg-slate-100"></div>
        </h3>

        {{-- 1. Foto atau Gambar --}}
        <div class="space-y-4">
            <h4 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-blue-50 text-[#0077B6] flex items-center justify-center text-xs font-black">1</span>
                Foto atau Gambar
            </h4>
            <div 
                @click="$refs.fileInput.click()"
                :class="dragover ? 'border-[#0077B6] bg-[#0077B6]/5 scale-[1.01] shadow-2xl shadow-[#0077B6]/10' : 'border-slate-200 hover:border-[#0077B6] hover:shadow-xl hover:shadow-slate-200/50'"
                class="group relative border-2 border-dashed rounded-[2rem] p-8 text-center transition-all duration-500 cursor-pointer bg-slate-50/30 overflow-hidden"
            >
                <div class="absolute -right-16 -top-16 w-48 h-48 bg-blue-50 rounded-full blur-3xl group-hover:bg-blue-100/50 transition-colors"></div>
                <input type="file" name="files[]" id="files" multiple class="hidden" x-ref="fileInput" @change="handleFileSelect" accept=".jpg,.jpeg,.png,.gif,.webp">
                
                <div class="relative z-10 space-y-3">
                    <div class="mx-auto w-16 h-16 rounded-2xl bg-white shadow-lg flex items-center justify-center text-[#0077B6] group-hover:scale-110 transition-all duration-500 border border-slate-50">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-base font-black text-[#03045E] mb-1 group-hover:text-[#0077B6] transition-colors">Unggah Foto/Gambar</h4>
                        <p class="text-sm text-slate-500 font-medium">Maksimal 5 file (JPG, PNG, GIF, WebP)</p>
                    </div>
                </div>
            </div>

            @error('files')
                <p class="text-center text-xs text-red-600 font-bold animate-shake">{{ $message }}</p>
            @enderror

            {{-- File List --}}
            <div x-show="files.length > 0" x-transition class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                <template x-for="(file, index) in files" :key="index">
                    <div class="group/file flex items-center justify-between p-4 bg-white border border-slate-100 rounded-[1.25rem] shadow-sm hover:shadow-xl hover:shadow-slate-200/50 hover:border-[#0077B6]/30 transition-all duration-300">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 border border-slate-50 shadow-sm bg-green-50 text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
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

        {{-- 2. Video URL --}}
        <div class="space-y-2 group">
            <h4 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-xs font-black">2</span>
                Video
            </h4>
            <input type="text" name="category_data[video_url]" id="video_url" 
                value="{{ $categoryDataValues['video_url'] ?? '' }}"
                data-category-field
                class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-[1.25rem] focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/5 hover:bg-slate-100/50 transition-all duration-300 font-medium placeholder:text-slate-400 outline-none"
                placeholder="Tuliskan alamat tautan/Link URL video yang diunggah">
        </div>

        {{-- 3. Dokumen Kajian Objek --}}
        <div class="space-y-2 group">
            <h4 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xs font-black">3</span>
                Dokumen Kajian Objek
            </h4>
            <input type="text" name="category_data[dokumen_kajian_url]" id="dokumen_kajian_url" 
                value="{{ $categoryDataValues['dokumen_kajian_url'] ?? '' }}"
                data-category-field
                class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-[1.25rem] focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/5 hover:bg-slate-100/50 transition-all duration-300 font-medium placeholder:text-slate-400 outline-none"
                placeholder="Tuliskan alamat tautan/Link URL dokumen yang diunggah">
        </div>

        {{-- 4. Dokumen Lainnya --}}
        <div class="space-y-2 group">
            <h4 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs font-black">4</span>
                Dokumen Lainnya
            </h4>
            <input type="text" name="category_data[dokumen_lainnya_url]" id="dokumen_lainnya_url" 
                value="{{ $categoryDataValues['dokumen_lainnya_url'] ?? '' }}"
                data-category-field
                class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent rounded-[1.25rem] focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/5 hover:bg-slate-100/50 transition-all duration-300 font-medium placeholder:text-slate-400 outline-none"
                placeholder="Tuliskan alamat tautan/Link URL dokumen yang diunggah">
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
        
        getFieldValue(key) {
            return this.categoryData[key] || '';
        },
        
        setFieldValue(key, value) {
            this.categoryData[key] = value;
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
        }
    }
}
</script>
