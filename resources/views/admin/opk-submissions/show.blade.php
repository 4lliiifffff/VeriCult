<x-layouts.admin>
    <x-slot name="header">
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('admin.opk-submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Data opk</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Detail Publikasi</span>
        </nav>

        <div class="relative mb-8 bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-8 overflow-hidden shadow-2xl shadow-blue-900/20">
            <div class="absolute inset-0 overflow-hidden rounded-[2rem] pointer-events-none">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            </div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <span @class([
                            'px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.15em] uppercase border backdrop-blur-md shadow-sm',
                            'bg-amber-100/20 text-amber-100 border-amber-100/30' => $submission->status === \App\Models\CulturalSubmission::STATUS_VERIFIED,
                            'bg-emerald-100/20 text-emerald-100 border-emerald-100/30' => $submission->status === \App\Models\CulturalSubmission::STATUS_PUBLISHED,
                        ])>
                            {{ $submission->status_label }}
                        </span>
                        <span class="text-[10px] font-black text-blue-100/60 uppercase tracking-[0.2em] bg-white/5 backdrop-blur-md px-3 py-1.5 rounded-lg border border-white/10">STAT-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight max-w-4xl">
                        {{ $submission->name }}
                    </h2>
                </div>

                <div class="flex items-center gap-4 w-full md:w-auto">
                    @if($submission->status === \App\Models\CulturalSubmission::STATUS_VERIFIED)
                        <form action="{{ route('admin.opk-submissions.update-status', $submission) }}" method="POST" class="w-full">
                            @csrf
                            <input type="hidden" name="status" value="{{ \App\Models\CulturalSubmission::STATUS_PUBLISHED }}">
                            <button type="submit" class="w-full bg-emerald-500 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-emerald-600 transition-all shadow-xl shadow-emerald-900/20 active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Publikasikan
                            </button>
                        </form>
                    @elseif($submission->status === \App\Models\CulturalSubmission::STATUS_PUBLISHED)
                        <form action="{{ route('admin.opk-submissions.update-status', $submission) }}" method="POST" class="w-full">
                            @csrf
                            <input type="hidden" name="status" value="{{ \App\Models\CulturalSubmission::STATUS_VERIFIED }}">
                            <button type="submit" class="w-full bg-rose-500 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-rose-600 transition-all shadow-xl shadow-rose-900/20 active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Tarik Publikasi
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Details Column -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white">
                <h3 class="text-xs font-black text-[#03045E] uppercase tracking-widest mb-6 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    Informasi Laporan
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kategori</p>
                        <p class="text-sm font-bold text-[#03045E]">{{ $submission->category }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tahun Laporan</p>
                        <p class="text-sm font-bold text-[#03045E]">{{ $submission->period_year }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Desa</p>
                        <p class="text-sm font-bold text-[#03045E]">{{ $submission->village?->name }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pengusul</p>
                        <p class="text-sm font-bold text-[#03045E]">{{ $submission->user?->name }}</p>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-slate-50">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Deskripsi / Ringkasan</p>
                    <div class="text-slate-600 text-sm leading-relaxed prose prose-slate max-w-none break-words">
                        {!! nl2br(e($submission->description ?? 'Tidak ada deskripsi.')) !!}
                    </div>
                </div>
            </div>

            <!-- Category Data -->
            @if(!empty($submission->category_data))
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white">
                    <h3 class="text-xs font-black text-[#03045E] uppercase tracking-widest mb-6 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                        Data Atribut opk
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                        @foreach($submission->category_data as $key => $value)
                            <div class="space-y-1 pb-4 border-b border-slate-50 last:border-0 md:last:border-b">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ str_replace('_', ' ', $key) }}</p>
                                <p class="text-xs font-bold text-[#03045E]">
                                    @if(is_array($value))
                                        {{ implode(', ', $value) }}
                                    @else
                                        {{ $value ?: '-' }}
                                    @endif
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Column -->
        <div class="space-y-8">
             <!-- Files Section -->
             <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white">
                <h3 class="text-xs font-black text-[#03045E] uppercase tracking-widest mb-6">Dokumen Pendukung</h3>
                <div class="space-y-3">
                    @forelse($submission->files as $file)
                        <a href="{{ Storage::url($file->path) }}" target="_blank" class="flex items-center gap-4 p-4 bg-slate-50 hover:bg-blue-50 rounded-2xl border border-slate-100 transition-all group">
                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#0077B6] shadow-sm shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold text-[#03045E] truncate">{{ $file->original_name }}</p>
                                <p class="text-[9px] text-slate-400 uppercase font-black tracking-widest">{{ number_format($file->file_size / 1024, 1) }} KB</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-center text-xs text-slate-400 italic py-4">Tidak ada file yang diunggah.</p>
                    @endforelse
                </div>
            </div>

            <!-- Reviewer Info -->
            @if($submission->reviewedBy)
                 <div class="bg-[#03045E] p-8 rounded-[2.5rem] shadow-xl shadow-blue-900/20 text-white relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16 group-hover:scale-110 transition-transform"></div>
                    <div class="relative z-10">
                        <h3 class="text-xs font-black text-blue-300 uppercase tracking-widest mb-6">Validator Terakhir</h3>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-[#00B4D8] font-black">
                                {{ substr($submission->reviewedBy->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-sm">{{ $submission->reviewedBy->name }}</p>
                                <p class="text-[10px] text-blue-300/70 font-medium">Verified At: {{ $submission->updated_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
