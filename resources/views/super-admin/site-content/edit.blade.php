<x-layouts.super-admin>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 sm:gap-4 mb-2">
                    <a href="{{ route('super-admin.site-content.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-[#03045E] shadow-sm hover:bg-[#03045E] hover:text-white transition-all shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    </a>
                    <h1 class="text-2xl sm:text-3xl font-black text-[#03045E] tracking-tighter truncate break-words">Edit Konten: {{ $pageLabel }}</h1>
                </div>
                <p class="text-slate-500 font-medium text-[11px] sm:text-sm ml-12 sm:ml-14">Perbarui teks dan pengaturan visual untuk halaman ini.</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-10">

    <!-- Edit Form -->
    <form action="{{ route('super-admin.site-content.update', $page) }}" method="POST" class="space-y-6 sm:space-y-8">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-[1.5rem] sm:rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
            <div class="p-6 sm:p-8 lg:p-10 space-y-8 sm:space-y-10">
                @foreach($contents as $content)
                <div class="space-y-3">
                    <label for="{{ $content->section }}" class="text-[10px] font-black text-[#0077B6] uppercase tracking-[0.2em] flex items-center gap-2">
                        {{ $content->label }}
                        <span class="text-slate-300 font-bold tracking-normal italic normal-case">({{ $content->section }})</span>
                    </label>

                    @if($content->type === 'textarea')
                        <textarea id="{{ $content->section }}" name="{{ $content->section }}" rows="4" 
                                  class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 sm:px-6 py-3.5 sm:py-4 text-[#03045E] font-bold focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all outline-none resize-none leading-relaxed text-sm sm:text-base">{{ $content->value }}</textarea>
                    @elseif($content->type === 'image')
                        <div class="relative group">
                            <input type="text" id="{{ $content->section }}" name="{{ $content->section }}" value="{{ $content->value }}" 
                                   class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 sm:px-6 py-3.5 sm:py-4 text-[#03045E] font-bold focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all outline-none text-sm sm:text-base"
                                   placeholder="URL Gambar atau ID Asset">
                            <div class="mt-4 p-4 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 flex items-center justify-center">
                                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Image Upload Coming Soon (Use URL for now)</p>
                            </div>
                        </div>
                    @else
                        {{-- Default text, url, etc --}}
                        <input type="text" id="{{ $content->section }}" name="{{ $content->section }}" value="{{ $content->value }}" 
                               class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 sm:px-6 py-3.5 sm:py-4 text-[#03045E] font-bold focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all outline-none text-sm sm:text-base">
                    @endif
                </div>
                @endforeach
            </div>

            <!-- Footer Action -->
            <div class="bg-slate-50 p-6 sm:p-8 lg:px-10 border-t border-slate-100 flex justify-end">
                <button type="submit" class="bg-gradient-to-r from-[#0077B6] to-[#00B4D8] text-white px-8 sm:px-10 py-4 sm:py-5 rounded-2xl sm:rounded-[2rem] font-black text-[10px] sm:text-xs uppercase tracking-[0.2em] sm:tracking-[0.3em] shadow-2xl shadow-blue-500/30 hover:shadow-blue-500/50 hover:scale-105 transition-all active:scale-95 w-full sm:w-auto">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
    </div>
</x-layouts.super-admin>
