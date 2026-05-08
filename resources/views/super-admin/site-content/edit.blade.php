<x-layouts.super-admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('super-admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('super-admin.site-content.index') }}" class="hover:text-[#0077B6] transition-colors">Kelola Konten</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Edit Halaman</span>
        </nav>

        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6 sm:gap-8">
                <div class="space-y-2 sm:space-y-3">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="px-3 sm:px-4 py-1 sm:py-1.5 rounded-full text-[8px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-[#03045E] text-white shadow-lg shadow-blue-900/20">
                            CMS Editor
                        </div>
                        <div class="h-3 sm:h-4 w-[1px] bg-slate-200"></div>
                        <span class="text-slate-400 text-[8px] sm:text-[10px] font-bold uppercase tracking-widest">Penyuntingan Konten Dinamis</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black text-[#03045E] tracking-tight leading-tight">
                        Edit Halaman <span class="text-[#0077B6]">{{ $pageLabel }}</span>
                    </h2>
                    <p class="text-slate-500 text-sm sm:text-lg font-medium max-w-2xl leading-relaxed">Perbarui teks dan pengaturan visual untuk halaman ini secara real-time.</p>
                </div>
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
