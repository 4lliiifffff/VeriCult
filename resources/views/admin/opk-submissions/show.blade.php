<x-layouts.admin>
    <x-slot name="header">
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('admin.opk-submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Data Kebudayaan</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Detail Kebudayaan</span>
        </nav>

        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-5 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6 sm:gap-8">
                <div class="flex items-center gap-4 sm:gap-8">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 rounded-[1.25rem] sm:rounded-[2rem] bg-[#03045E] flex items-center justify-center text-white shadow-xl shadow-blue-900/20 font-black text-xl sm:text-2xl uppercase">{{ substr($submission->name, 0, 2) }}</div>
                    <div class="space-y-1 sm:space-y-2">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="px-2.5 py-1 rounded-full text-[7px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-slate-100 text-slate-500 border border-slate-200">Detail Kebudayaan</div>
                            <div class="h-3 w-[1px] bg-slate-200"></div>
                            <span class="text-slate-400 text-[7px] sm:text-[10px] font-bold uppercase tracking-widest">Publikasi & Review</span>
                        </div>
                        <h2 class="text-xl sm:text-4xl font-black text-[#03045E] tracking-tight leading-tight">Detail <span class="text-[#0077B6]">Kebudayaan</span></h2>
                    </div>
                </div>
                <div class="flex items-center gap-3 w-full md:w-auto">
                    @if($submission->status === \App\Models\CulturalSubmission::STATUS_VERIFIED)
                        <form action="{{ route('admin.opk-submissions.update-status', $submission) }}" method="POST" class="w-full md:w-auto">
                            @csrf
                            <input type="hidden" name="status" value="{{ \App\Models\CulturalSubmission::STATUS_PUBLISHED }}">
                            <button type="submit" class="w-full md:w-auto px-6 py-4 bg-emerald-500 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-xl shadow-emerald-900/20 active:scale-95">Publikasikan</button>
                        </form>
                    @elseif($submission->status === \App\Models\CulturalSubmission::STATUS_PUBLISHED)
                        <form action="{{ route('admin.opk-submissions.update-status', $submission) }}" method="POST" class="w-full md:w-auto">
                            @csrf
                            <input type="hidden" name="status" value="{{ \App\Models\CulturalSubmission::STATUS_VERIFIED }}">
                            <button type="submit" class="w-full md:w-auto px-6 py-4 bg-rose-500 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-rose-600 transition-all shadow-xl shadow-rose-900/20 active:scale-95">Tarik Publikasi</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-10">
        <div class="lg:col-span-2 space-y-6 sm:space-y-10">
            <div class="bg-white p-6 sm:p-12 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-10">
                    <span class="px-4 py-2 rounded-xl text-[9px] font-black tracking-[0.2em] uppercase border shadow-sm {{ $submission->status_color }}">{{ $submission->status_label }}</span>
                    <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest bg-slate-50 px-4 py-2 rounded-lg">ID Kebudayaan: #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>

                <div class="space-y-8 sm:space-y-10">
                    <div class="space-y-6">
                        <h2 class="text-[10px] font-black text-[#0077B6] uppercase tracking-[0.3em] flex items-center gap-4"><span class="shrink-0 text-[#03045E]">Informasi Dasar</span><div class="flex-1 h-px bg-slate-100"></div></h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                            <div class="sm:col-span-2"><label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Nama Objek Kebudayaan</label><p class="text-2xl sm:text-3xl font-black text-[#03045E] leading-tight">{{ $submission->name }}</p></div>
                            <div><label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Kategori</label><div class="flex items-center gap-3"><div class="w-2 h-2 rounded-full bg-[#0077B6]"></div><p class="font-black text-[#03045E] uppercase tracking-tighter">{{ $submission->category }}</p></div></div>
                            <div><label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Tahun Laporan</label><p class="font-bold text-slate-600">{{ $submission->period_year }}</p></div>
                            <div><label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Desa</label><p class="font-bold text-slate-600">{{ $submission->village?->name }}</p></div>
                            <div><label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Pengusul</label><p class="font-bold text-slate-600">{{ $submission->user?->name }}</p></div>
                            <div class="sm:col-span-2"><label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Deskripsi Singkat</label><div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 italic text-slate-600 leading-relaxed font-medium break-words">{{ $submission->description ?: 'Tidak ada deskripsi.' }}</div></div>
                        </div>
                    </div>

                    @if(!empty($submission->category_data))
                        <div class="space-y-8">
                            <h2 class="text-[10px] font-black text-[#0077B6] uppercase tracking-[0.3em] flex items-center gap-4"><span class="shrink-0 text-[#03045E]">Data Spesifik Kategori</span><div class="flex-1 h-px bg-slate-100"></div></h2>
                            <div class="bg-gradient-to-br from-slate-50/50 to-blue-50/30 rounded-[2rem] p-6 sm:p-10 border border-slate-100 hover:bg-white hover:shadow-xl hover:shadow-slate-200/30 transition-all duration-500">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 sm:gap-10">
                                    @foreach($submission->category_data as $key => $value)
                                        @if(!empty($value))
                                            <div class="space-y-2">
                                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ str_replace('_', ' ', $key) }}</p>
                                                <p class="text-sm font-bold text-[#03045E] break-words">{{ is_array($value) ? implode(', ', $value) : $value }}</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white p-6 sm:p-12 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white">
                <h2 class="text-[10px] font-black text-[#0077B6] uppercase tracking-[0.3em] mb-8 flex items-center gap-4"><span class="shrink-0 text-[#03045E]">Berkas Pendukung</span><div class="flex-1 h-px bg-slate-100"></div></h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @forelse($submission->files as $file)
                        <div class="group/file relative flex flex-col p-4 bg-white border border-slate-100 rounded-[2rem] shadow-sm hover:translate-y-[-4px] hover:shadow-2xl hover:shadow-slate-200/50 hover:border-[#0077B6]/30 transition-all duration-300 overflow-hidden">
                            <div class="relative w-full h-44 rounded-[1.5rem] overflow-hidden bg-slate-50 flex items-center justify-center shrink-0 mb-4 border border-slate-50/50 shadow-inner">
                                @if($file->file_icon == 'image')
                                    <img src="{{ Storage::url($file->path) }}" class="w-full h-full object-cover">
                                @elseif($file->file_icon == 'video')
                                    <video src="{{ Storage::url($file->path) }}" class="w-full h-full object-cover" preload="metadata"></video>
                                @else
                                    <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                @endif
                            </div>
                            <div class="px-1 min-w-0 flex-1">
                                <p class="text-[14px] font-black text-[#03045E] truncate mb-1" title="{{ $file->original_name }}">{{ $file->original_name }}</p>
                                <div class="flex items-center gap-3">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $file->file_size_human }}</span>
                                    <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                                    <span class="text-[9px] font-black text-[#00B4D8] uppercase tracking-widest">{{ strtoupper($file->file_type) }}</span>
                                </div>
                            </div>
                            <div class="mt-5 pt-4 border-t border-slate-50">
                                <a href="{{ Storage::url($file->path) }}" target="_blank" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-slate-50 text-slate-500 hover:bg-[#03045E] hover:text-white rounded-xl font-black text-[9px] uppercase tracking-[0.2em] transition-all active:scale-95">Unduh File</a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-slate-200"><p class="text-slate-400 font-black text-[10px] uppercase tracking-widest">Belum ada dokumen lampiran.</p></div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="space-y-6 sm:space-y-10">
            <div class="bg-[#03045E] p-6 sm:p-10 rounded-[2rem] sm:rounded-[2.5rem] shadow-2xl shadow-blue-900/40 text-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 -mr-12 -mt-12 w-48 h-48 bg-white/5 rounded-full blur-3xl transition-transform duration-1000 group-hover:scale-150"></div>
                <h3 class="text-[9px] font-black uppercase tracking-[0.3em] text-white/40 mb-8 relative z-10">Profil Pengusul</h3>
                <div class="flex items-center gap-5 relative z-10 mb-8">
                    <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center font-black text-2xl border border-white/20 shadow-xl">{{ substr($submission->user?->name ?? 'U', 0, 1) }}</div>
                    <div class="min-w-0"><p class="font-black text-xl leading-tight truncate">{{ $submission->user?->name }}</p><p class="text-[11px] font-medium text-white/40 truncate">{{ $submission->user?->email }}</p></div>
                </div>
            </div>

            @if($submission->reviewedBy)
                <div class="bg-white p-6 sm:p-10 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white group">
                    <h3 class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] mb-8">Divalidasi Oleh</h3>
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center font-black text-2xl text-[#0077B6] border border-blue-100 shadow-inner">{{ substr($submission->reviewedBy->name, 0, 1) }}</div>
                        <div class="min-w-0"><p class="font-black text-[#03045E] text-lg leading-tight truncate">{{ $submission->reviewedBy->name }}</p><p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest">Validator Terverifikasi</p></div>
                    </div>
                </div>
            @endif

            <div class="p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100">
                <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-[#03045E] mb-6"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Informasi Sistem</p>
                <p class="text-xs font-bold text-slate-500 leading-relaxed uppercase tracking-tight opacity-75">Data kebudayaan ini merupakan arsip digital resmi yang sedang dikelola oleh admin untuk publikasi dan validasi.</p>
            </div>
        </div>
    </div>
</x-layouts.admin>
