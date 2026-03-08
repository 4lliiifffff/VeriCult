{{-- Field Renderer Partial --}}
{{-- Renders a single form field based on its type definition --}}

@php
    $fieldValue = $categoryDataValues[$fieldKey] ?? '';
    $hasCondition = !empty($field['condition']);
    $conditionField = $field['condition']['field'] ?? '';
    $conditionValue = $field['condition']['value'] ?? '';
@endphp

<div class="space-y-2 group"
    @if($hasCondition)
        x-show="getFieldValue('{{ $conditionField }}') === '{{ $conditionValue }}'"
        x-transition
    @endif
>
    @if($field['type'] !== 'dynamic_table')
        <label for="category_data_{{ $fieldKey }}" class="block text-sm font-bold text-slate-700 transition-colors group-focus-within:text-[#0077B6]">
            {{ $field['label'] }}
        </label>
    @endif

    @switch($field['type'])
        {{-- TEXT INPUT --}}
        @case('text')
            <input type="text" name="category_data[{{ $fieldKey }}]" id="category_data_{{ $fieldKey }}" 
                value="{{ $fieldValue }}"
                data-category-field
                x-on:input="setFieldValue('{{ $fieldKey }}', $event.target.value)"
                class="w-full px-5 py-4 bg-white border-2 border-transparent rounded-[1.25rem] focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/5 hover:bg-slate-50 transition-all duration-300 font-medium placeholder:text-slate-400 outline-none"
                placeholder="{{ $field['placeholder'] ?? '' }}">
            @break

        {{-- TEXTAREA --}}
        @case('textarea')
            <textarea name="category_data[{{ $fieldKey }}]" id="category_data_{{ $fieldKey }}" rows="4" 
                data-category-field
                x-on:input="setFieldValue('{{ $fieldKey }}', $event.target.value)"
                class="w-full px-5 py-4 bg-white border-2 border-transparent rounded-[1.25rem] focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/5 hover:bg-slate-50 transition-all duration-300 font-medium placeholder:text-slate-400 outline-none resize-none leading-relaxed"
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
                    class="w-full flex items-center justify-between px-5 py-4 bg-white border-2 border-transparent rounded-[1.25rem] focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/5 hover:bg-slate-50 transition-all duration-300 outline-none"
                    :class="open ? 'border-[#0077B6] ring-4 ring-[#0077B6]/5' : ''">
                    <span class="font-medium" :class="selected ? 'text-slate-700' : 'text-slate-400'" x-text="selected || '{{ $field['placeholder'] ?? 'Pilih opsi...' }}'"></span>
                    <svg class="w-5 h-5 text-slate-400 transition-all duration-300" :class="open ? 'rotate-180 text-[#0077B6]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     class="absolute z-50 w-full mt-3 bg-white border border-slate-100 rounded-[1.5rem] shadow-2xl overflow-hidden py-2 max-h-64 overflow-y-auto"
                     style="display: none;">
                    <template x-for="option in options">
                        <button type="button" 
                            @click="selectOption(option)"
                            class="w-full text-left px-5 py-3.5 text-sm font-bold transition-all duration-200 flex items-center justify-between"
                            :class="selected === option ? 'bg-[#0077B6]/5 text-[#0077B6]' : 'text-slate-600 hover:bg-slate-50 hover:text-[#0077B6]'">
                            <span x-text="option"></span>
                            <template x-if="selected === option">
                                <svg class="w-4 h-4 text-[#0077B6]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
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
                    <label class="relative cursor-pointer">
                        <input type="radio" name="category_data[{{ $fieldKey }}]" value="{{ $option }}"
                            class="peer sr-only"
                            data-category-field
                            x-on:change="setFieldValue('{{ $fieldKey }}', '{{ $option }}')"
                            @if($fieldValue === $option) checked @endif>
                        <div class="px-5 py-3 rounded-xl border-2 border-slate-200 bg-white text-sm font-bold text-slate-600 
                            peer-checked:border-[#0077B6] peer-checked:bg-[#0077B6]/5 peer-checked:text-[#0077B6] 
                            hover:border-[#0077B6]/50 transition-all duration-200">
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
                    <label class="flex items-center gap-3 cursor-pointer group/cb">
                        <input type="checkbox" name="category_data[{{ $fieldKey }}][]" value="{{ $option }}"
                            class="w-5 h-5 rounded-lg border-2 border-slate-200 text-[#0077B6] focus:ring-[#0077B6]/20 focus:ring-offset-0 transition-colors"
                            data-category-field
                            @if(in_array($option, $checkedValues)) checked @endif>
                        <span class="text-sm font-medium text-slate-600 group-hover/cb:text-[#0077B6] transition-colors">{{ $option }}</span>
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
            <div class="space-y-3" x-init="initDynamicTable('{{ $fieldKey }}', @js($columnKeys))">
                <label class="block text-sm font-bold text-slate-700">{{ $field['label'] }}</label>

                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
                    {{-- Table Header --}}
                    <div class="grid gap-0 bg-slate-50 border-b border-slate-100" style="grid-template-columns: repeat({{ count($columns) }}, 1fr) 50px;">
                        @foreach($columns as $col)
                            <div class="px-4 py-3 text-xs font-black text-slate-500 uppercase tracking-wider">{{ $col }}</div>
                        @endforeach
                        <div class="px-2 py-3"></div>
                    </div>

                    {{-- Table Rows --}}
                    <template x-for="(row, rowIndex) in dynamicTables['{{ $fieldKey }}']" :key="rowIndex">
                        <div class="grid gap-0 border-b border-slate-50" style="grid-template-columns: repeat({{ count($columns) }}, 1fr) 50px;">
                            @foreach($columnKeys as $colIdx => $colKey)
                                <div class="px-2 py-2">
                                    <input type="text" 
                                        :name="'category_data[{{ $fieldKey }}][' + rowIndex + '][{{ $colKey }}]'"
                                        x-model="row.{{ $colKey }}"
                                        data-category-field
                                        class="w-full px-3 py-2 bg-transparent border border-transparent rounded-lg focus:border-[#0077B6] focus:ring-2 focus:ring-[#0077B6]/5 text-sm font-medium placeholder:text-slate-300 outline-none hover:bg-slate-50 transition-all"
                                        placeholder="{{ $columns[$colIdx] ?? '' }}">
                                </div>
                            @endforeach
                            <div class="flex items-center justify-center">
                                <button type="button" @click="removeTableRow('{{ $fieldKey }}', rowIndex)"
                                    class="p-1.5 text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all"
                                    x-show="dynamicTables['{{ $fieldKey }}'].length > 1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <button type="button" @click="addTableRow('{{ $fieldKey }}', @js($columnKeys))"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-[#0077B6]/5 text-[#0077B6] rounded-xl text-sm font-bold hover:bg-[#0077B6]/10 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Baris
                </button>
            </div>
            @break
    @endswitch

    @error('category_data.' . $fieldKey)
        <p class="flex items-center gap-2 mt-1 text-xs text-red-600 font-medium animate-shake">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            {{ $message }}
        </p>
    @enderror
</div>
