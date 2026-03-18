@props([
    'name',
    'id' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Pilih opsi...',
    'allLabel' => null, // Optional: Label for "All" option (e.g., "Semua Status")
    'label' => null,
    'required' => false,
    'variant' => 'dark', // 'dark' (white text on dark bg) or 'light' (dark text on light bg)
])

<div class="space-y-2 group" x-data="{ 
    open: false, 
    selected: '{{ (string) $selected }}',
    options: @js($options),
    placeholder: '{{ $placeholder }}',
    selectOption(key) {
        this.selected = key;
        this.open = false;
        // Trigger form submit if it's a filter
        this.$nextTick(() => {
            const form = this.$refs.hiddenInput.form;
            if (form && (form.getAttribute('onchange') === 'this.submit()' || form.classList.contains('auto-submit'))) {
                if (typeof form.requestSubmit === 'function') {
                    form.requestSubmit();
                } else {
                    form.submit();
                }
            }
        });
    }
}" @click.away="open = false">
    @if($label)
        <label for="{{ $id ?? $name }}" class="block text-[10px] font-black {{ $variant === 'dark' ? 'text-[#00B4D8]' : 'text-slate-400' }} uppercase tracking-[0.2em] px-1">
            {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif

    <div class="relative">
        <input type="hidden" name="{{ $name }}" id="{{ $id ?? $name }}" :value="selected" x-ref="hiddenInput">
        
        <button type="button" 
            @click="open = !open"
            class="w-full flex items-center justify-between px-5 @if($variant === 'light') py-3.5 bg-slate-50 border-2 border-slate-100 text-slate-600 rounded-2xl @else py-2.5 bg-white/20 text-white border border-white/30 rounded-xl @endif text-sm font-bold focus:ring-[#00B4D8] focus:border-[#00B4D8] transition-all outline-none cursor-pointer backdrop-blur-md"
            :class="open ? 'ring-2 ring-[#00B4D8]/50 border-[#00B4D8]' : ''">
            <span x-text="(selected !== '' && options[selected]) ? options[selected] : placeholder"></span>
            <svg class="w-4 h-4 {{ $variant === 'dark' ? 'text-white/70' : 'text-slate-400' }} transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
             class="absolute z-50 w-full mt-2 bg-white border border-slate-100 rounded-xl shadow-2xl overflow-hidden py-1"
             style="display: none;">
            
            @if($allLabel)
                <button type="button" 
                    @click="selectOption('')"
                    class="w-full text-left px-4 py-2 text-sm font-bold transition-all duration-200 flex items-center justify-between"
                    :class="selected == '' ? 'bg-[#0077B6]/5 text-[#0077B6]' : 'text-slate-600 hover:bg-slate-50 hover:text-[#0077B6]'">
                    <span>{{ $allLabel }}</span>
                    <template x-if="selected == ''">
                        <svg class="w-4 h-4 text-[#0077B6]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                    </template>
                </button>
                <div class="h-px bg-slate-50 my-1 mx-2"></div>
            @endif

            <template x-for="(label, key) in options" :key="key">
                <button type="button" 
                    @click="selectOption(key)"
                    class="w-full text-left px-4 py-2 text-sm font-bold transition-all duration-200 flex items-center justify-between"
                    :class="selected == key ? 'bg-[#0077B6]/5 text-[#0077B6]' : 'text-slate-600 hover:bg-slate-50 hover:text-[#0077B6]'">
                    <span x-text="label"></span>
                    <template x-if="selected == key">
                        <svg class="w-4 h-4 text-[#0077B6]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                    </template>
                </button>
            </template>
        </div>
    </div>
</div>
