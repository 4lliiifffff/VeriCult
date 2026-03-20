{{-- Field Renderer Partial --}}
{{-- Renders a single form field based on its type definition --}}

@php
    $fieldValue = $categoryDataValues[$fieldKey] ?? '';
    $hasCondition = !empty($field['condition']);
    $conditionField = $field['condition']['field'] ?? '';
    $conditionValue = $field['condition']['value'] ?? '';

    // Data-driven "Lainnya" pattern detection
    $isLainnyaField = str_ends_with($fieldKey, '_lainnya');
    $parentKey = $isLainnyaField ? str_replace('_lainnya', '', $fieldKey) : null;
    $parentValue = $parentKey ? ($categoryDataValues[$parentKey] ?? '') : null;

    // Intelligent Radio Hiding Logic:
    // If this is a radio field with a dependent field that is already filled, hide it.
    $isRadioWithDependent = false;
    $dependentIsFilled = false;
    if ($field['type'] === 'radio') {
        // Look for a field that depends on this radio being 'Ya'
        foreach ($categoryFields as $otherKey => $otherField) {
            if (isset($otherField['condition']) && 
                ($otherField['condition']['field'] ?? '') === $fieldKey && 
                ($otherField['condition']['value'] ?? '') === 'Ya') {
                $otherValue = $categoryDataValues[$otherKey] ?? '';
                if (!empty($otherValue)) {
                    $isRadioWithDependent = true;
                    $dependentIsFilled = true;
                    break;
                }
            }
        }
    }
@endphp

<div class="space-y-3 group/field"
    @if($hasCondition)
        x-show="getFieldValue('{{ $conditionField }}') === '{{ $conditionValue }}' || 
                ('{{ $conditionValue }}' === 'Ya' && getFieldValue('{{ $fieldKey }}') !== '')"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
    @endif
    @if($isRadioWithDependent && $dependentIsFilled)
        style="display: none;"
    @endif
>
    {{-- Field Header --}}
    @if($field['type'] !== 'dynamic_table')
        <div class="flex items-center justify-between gap-4">
            <label for="category_data_{{ $fieldKey }}" class="block text-xs font-black text-slate-500 uppercase tracking-[0.15em] transition-colors group-focus-within/field:text-[#0077B6]">
                {{ $field['label'] }}
            </label>
            
            @if($isLainnyaField)
                <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-amber-100">Detail Tambahan</span>
            @endif
        </div>
    @endif

    <div class="relative">
        @switch($field['type'])
            {{-- TEXT INPUT --}}
            @case('text')
                <div class="relative group/input">
                    <input type="text" name="category_data[{{ $fieldKey }}]" id="category_data_{{ $fieldKey }}" 
                        value="{{ $fieldValue }}"
                        data-category-field
                        x-on:input="setFieldValue('{{ $fieldKey }}', $event.target.value)"
                        class="w-full pl-6 pr-14 py-4.5 bg-white border-2 border-slate-100 rounded-2xl focus:border-[#0077B6] focus:ring-[6px] focus:ring-[#0077B6]/5 hover:border-slate-200 transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300 outline-none shadow-sm group-hover/input:shadow-md"
                        placeholder="{{ $field['placeholder'] ?? '' }}">
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within/input:text-[#0077B6] transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                </div>
                @break

            {{-- SEARCHABLE DATALIST INPUT --}}
            @case('datalist')
                @php
                    $datalistOptions = [];
                    if(isset($villages)) {
                        foreach($villages as $village) {
                            $datalistOptions[] = $village->name;
                        }
                    }
                @endphp
                <div x-data="{ 
                        open: false, 
                        search: '{{ addslashes($fieldValue) }}',
                        allOptions: @js($datalistOptions),
                        get filteredOptions() {
                            if (!this.search) return this.allOptions;
                            return this.allOptions.filter(i => i.toLowerCase().includes(this.search.toLowerCase()));
                        },
                        selectOption(option) {
                            this.search = option;
                            this.open = false;
                            setFieldValue('{{ $fieldKey }}', option);
                        }
                     }"
                     @click.away="open = false"
                     class="relative group/input">
                    
                    <input type="hidden" name="category_data[{{ $fieldKey }}]" :value="search" data-category-field>
                    
                    <div class="relative">
                        <input type="text"
                            x-model="search"
                            @click="open = true"
                            @focus="open = true"
                            @input="open = true; setFieldValue('{{ $fieldKey }}', search)"
                            class="w-full pl-6 pr-14 py-4.5 bg-white border-2 border-slate-100 rounded-2xl focus:border-[#0077B6] focus:ring-[6px] focus:ring-[#0077B6]/5 hover:border-slate-200 transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300 outline-none shadow-sm group-hover/input:shadow-md"
                            placeholder="{{ $field['placeholder'] ?? 'Cari atau ketik nama desa...' }}"
                            autocomplete="off">
                            
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within/input:text-[#0077B6] transition-colors pointer-events-none">
                            <svg class="w-5 h-5 transition-transform duration-300" :class="open ? 'rotate-180 text-[#0077B6]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         class="absolute z-[60] w-full mt-3 bg-white border border-slate-100 rounded-3xl shadow-2xl overflow-hidden py-3 max-h-64 overflow-y-auto"
                         style="display: none;">
                        
                        <template x-if="filteredOptions.length > 0">
                            <template x-for="option in filteredOptions" :key="option">
                                <button type="button" 
                                    @click="selectOption(option)"
                                    class="w-full text-left px-6 py-3.5 text-sm font-black transition-all duration-200 flex items-center justify-between group/opt"
                                    :class="search === option ? 'bg-[#0077B6]/5 text-[#0077B6]' : 'text-slate-600 hover:bg-slate-50 hover:text-[#0077B6]'">
                                    <span x-text="option"></span>
                                    <template x-if="search === option">
                                        <div class="w-6 h-6 rounded-full bg-[#0077B6] flex items-center justify-center shadow-lg shadow-blue-500/20">
                                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    </template>
                                </button>
                            </template>
                        </template>

                        <template x-if="filteredOptions.length === 0">
                            <div class="px-6 py-6 flex flex-col items-center justify-center text-center">
                                <div class="w-12 h-12 rounded-full bg-rose-50 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <p class="text-[11px] font-black text-rose-600 uppercase tracking-widest">Desa Tidak Ditemukan</p>
                                <p class="text-[10px] font-bold text-slate-400 mt-1 max-w-[80%]">Pastikan ejaan benar, tapi tidak apa-apa jika melanjutkan dengan nama desa tersebut</p>
                            </div>
                        </template>
                    </div>
                </div>
                @break

            {{-- DATE INPUT (Flatpickr) --}}
            @case('date')
                <div class="relative group/input" x-data x-init="
                    flatpickr($refs.datepicker_{{ $fieldKey }}, {
                        locale: 'id',
                        dateFormat: 'Y-m-d',
                        altInput: true,
                        altFormat: 'j F Y',
                        allowInput: true,
                        disableMobile: true,
                        onChange: function(selectedDates, dateStr) {
                            setFieldValue('{{ $fieldKey }}', dateStr);
                        }
                    })
                ">
                    <input type="text" x-ref="datepicker_{{ $fieldKey }}" name="category_data[{{ $fieldKey }}]" id="category_data_{{ $fieldKey }}" 
                        value="{{ $fieldValue }}"
                        data-category-field
                        readonly
                        class="w-full pl-6 pr-14 py-4.5 bg-white border-2 border-slate-100 rounded-2xl focus:border-[#0077B6] focus:ring-[6px] focus:ring-[#0077B6]/5 hover:border-slate-200 transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300 outline-none shadow-sm group-hover/input:shadow-md cursor-pointer"
                        placeholder="{{ $field['placeholder'] ?? 'Pilih tanggal' }}">
                    <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within/input:text-[#0077B6] transition-colors pointer-events-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                @break

            {{-- TEXTAREA --}}
            @case('textarea')
                <textarea name="category_data[{{ $fieldKey }}]" id="category_data_{{ $fieldKey }}" rows="4" 
                    data-category-field
                    x-on:input="setFieldValue('{{ $fieldKey }}', $event.target.value)"
                    class="w-full px-6 py-5 bg-white border-2 border-slate-100 rounded-3xl focus:border-[#0077B6] focus:ring-[6px] focus:ring-[#0077B6]/5 hover:border-slate-200 transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300 outline-none resize-none leading-relaxed shadow-sm group-hover/field:shadow-md"
                    placeholder="{{ $field['placeholder'] ?? '' }}">{{ $fieldValue }}</textarea>
                @break

            {{-- SELECT DROPDOWN --}}
            @case('select')
                <div x-data="{ 
                        open: false, 
                        selected: '{{ $fieldValue }}',
                        options: @js($field['options'] ?? []),
                        selectOption(option) {
                            this.selected = option;
                            this.open = false;
                            setFieldValue('{{ $fieldKey }}', option);
                        }
                     }"
                     @click.away="open = false"
                     class="relative">
                    
                    <input type="hidden" name="category_data[{{ $fieldKey }}]" :value="selected" data-category-field>
                    
                    <button type="button" 
                        @click="open = !open"
                        class="w-full flex items-center justify-between px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:border-[#0077B6] focus:ring-[6px] focus:ring-[#0077B6]/5 hover:border-slate-200 transition-all duration-300 outline-none shadow-sm group-hover/field:shadow-md"
                        :class="open ? 'border-[#0077B6] ring-[6px] ring-[#0077B6]/5' : ''">
                        <span class="font-bold shrink-0 truncate max-w-[85%]" :class="selected ? 'text-slate-700' : 'text-slate-400'" x-text="selected || '{{ $field['placeholder'] ?? 'Pilih opsi...' }}'"></span>
                        <svg class="w-5 h-5 text-slate-400 transition-all duration-300 shrink-0" :class="open ? 'rotate-180 text-[#0077B6]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         class="absolute z-[60] w-full mt-3 bg-white border border-slate-100 rounded-3xl shadow-2xl overflow-hidden py-3 max-h-64 overflow-y-auto"
                         style="display: none;">
                        <template x-for="option in options">
                            <button type="button" 
                                @click="selectOption(option)"
                                class="w-full text-left px-6 py-3.5 text-sm font-black transition-all duration-200 flex items-center justify-between group/opt"
                                :class="selected === option ? 'bg-[#0077B6]/5 text-[#0077B6]' : 'text-slate-600 hover:bg-slate-50 hover:text-[#0077B6]'">
                                <span x-text="option"></span>
                                <template x-if="selected === option">
                                    <div class="w-6 h-6 rounded-full bg-[#0077B6] flex items-center justify-center shadow-lg shadow-blue-500/20">
                                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </template>
                            </button>
                        </template>
                    </div>
                </div>
                @break

            {{-- RADIO BUTTONS --}}
            @case('radio')
                <div class="flex flex-wrap gap-3">
                    @foreach($field['options'] as $option)
                        <label class="relative cursor-pointer group/radio">
                            <input type="radio" name="category_data[{{ $fieldKey }}]" value="{{ $option }}"
                                class="peer sr-only"
                                data-category-field
                                x-on:change="setFieldValue('{{ $fieldKey }}', '{{ $option }}')"
                                @if($fieldValue === $option) checked @endif>
                            <div class="px-6 py-3 rounded-2xl border-2 border-slate-100 bg-white text-sm font-black text-slate-500 
                                peer-checked:border-[#0077B6] peer-checked:bg-[#0077B6]/5 peer-checked:text-[#0077B6] peer-checked:shadow-lg peer-checked:shadow-blue-500/5
                                hover:border-slate-200 transition-all duration-300 active:scale-95">
                                {{ $option }}
                            </div>
                        </label>
                    @endforeach
                </div>
                @break

            {{-- CHECKBOX GROUP --}}
            @case('checkbox_group')
                @php
                    $checkedValues = is_array($fieldValue) ? $fieldValue : (is_string($fieldValue) && $fieldValue ? explode(',', $fieldValue) : []);
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($field['options'] as $option)
                        <label class="flex items-center gap-4 cursor-pointer group/cb p-3 rounded-2xl border-2 border-transparent hover:bg-slate-50 hover:border-slate-100 transition-all">
                            <input type="checkbox" name="category_data[{{ $fieldKey }}][]" value="{{ $option }}"
                                class="w-6 h-6 rounded-lg border-2 border-slate-200 text-[#0077B6] focus:ring-[#0077B6]/20 focus:ring-offset-0 transition-all group-hover/cb:border-[#0077B6]/50"
                                data-category-field
                                @if(in_array($option, $checkedValues)) checked @endif>
                            <span class="text-sm font-black text-slate-600 group-hover/cb:text-[#03045E] transition-colors leading-tight">{{ $option }}</span>
                        </label>
                    @endforeach
                </div>
                @break

            {{-- DYNAMIC TABLE --}}
            @case('dynamic_table')
                @php
                    $columns = $field['columns'] ?? [];
                    $columnKeys = $field['column_keys'] ?? [];
                    $tableData = is_array($fieldValue) ? $fieldValue : [];
                @endphp
                <div class="space-y-4" x-init="initDynamicTable('{{ $fieldKey }}', @js($columnKeys))">
                    <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm group-hover/field:shadow-md transition-shadow">
                        <div class="overflow-x-auto">
                            <div class="min-w-max">
                                {{-- Table Header --}}
                                <div class="grid gap-0 bg-slate-50/80 border-b border-slate-100" style="grid-template-columns: repeat({{ count($columns) }}, minmax(180px, 1fr)) 60px;">
                                    @foreach($columns as $col)
                                        <div class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ $col }}</div>
                                    @endforeach
                                    <div class="px-2 py-4"></div>
                                </div>

                                {{-- Table Rows --}}
                                <template x-for="(row, rowIndex) in dynamicTables['{{ $fieldKey }}']" :key="rowIndex">
                                    <div class="grid gap-0 border-b border-slate-50 last:border-0 hover:bg-slate-50/30 transition-colors" style="grid-template-columns: repeat({{ count($columns) }}, minmax(180px, 1fr)) 60px;">
                                        @foreach($columnKeys as $colIdx => $colKey)
                                            <div class="px-2 py-2 border-r border-slate-50/50">
                                                <input type="text" 
                                                    :name="'category_data[{{ $fieldKey }}][' + rowIndex + '][{{ $colKey }}]'"
                                                    x-model="row.{{ $colKey }}"
                                                    data-category-field
                                                    class="w-full px-4 py-3 bg-transparent border-2 border-transparent rounded-xl focus:border-[#0077B6] focus:bg-white focus:ring-[6px] focus:ring-[#0077B6]/5 text-sm font-bold text-slate-700 placeholder:text-slate-300 outline-none hover:bg-white/50 transition-all"
                                                    placeholder="{{ $columns[$colIdx] ?? '' }}">
                                            </div>
                                        @endforeach
                                        <div class="flex items-center justify-center p-2 bg-slate-50/30">
                                            <button type="button" @click="removeTableRow('{{ $fieldKey }}', rowIndex)"
                                                class="w-10 h-10 flex items-center justify-center text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all active:scale-90"
                                                x-show="dynamicTables['{{ $fieldKey }}'].length > 1"
                                                title="Hapus Baris">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <button type="button" @click="addTableRow('{{ $fieldKey }}', @js($columnKeys))"
                        class="inline-flex items-center gap-3 px-6 py-3.5 bg-white border-2 border-slate-100 text-[#0077B6] rounded-[1.25rem] text-xs font-black uppercase tracking-widest hover:border-[#0077B6] hover:bg-blue-50/50 transition-all active:scale-95 shadow-sm">
                        <div class="w-6 h-6 rounded-lg bg-[#0077B6] text-white flex items-center justify-center shadow-lg shadow-blue-500/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        Tambah Baris
                    </button>
                </div>
                @break
        @endswitch
    </div>

    @error('category_data.' . $fieldKey)
        <p class="flex items-center gap-2 mt-2 px-2 text-[10px] text-red-600 font-black uppercase tracking-wider animate-shake">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            {{ $message }}
        </p>
    @enderror
</div>
