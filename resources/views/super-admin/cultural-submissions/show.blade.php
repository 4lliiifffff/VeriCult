<x-layouts.super-admin>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-3 sm:gap-4">
                <a href="{{ route('super-admin.cultural-submissions.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-[#03045E] shadow-sm hover:bg-[#03045E] hover:text-white transition-all shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div class="min-w-0">
                    <h1 class="text-xl sm:text-2xl font-black text-[#03045E] tracking-tighter truncate break-words">{{ $submission->name }}</h1>
                    <p class="text-slate-500 font-medium text-[11px] sm:text-sm">Detail obyek kebudayaan terdaftar.</p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <a href="{{ route('super-admin.cultural-submissions.edit', $submission) }}" class="flex items-center justify-center px-6 py-3 sm:py-2.5 bg-blue-50 text-[#0077B6] rounded-xl font-black text-xs uppercase tracking-widest border border-blue-100 hover:bg-[#0077B6] hover:text-white transition-all active:scale-95 text-center">
                    Edit Data
                </a>
                <form action="{{ route('super-admin.cultural-submissions.destroy', $submission) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini secara permanen?')" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-6 py-3 sm:py-2.5 bg-red-50 text-red-600 rounded-xl font-black text-xs uppercase tracking-widest border border-red-100 hover:bg-red-600 hover:text-white transition-all active:scale-95">
                        Hapus Permanen
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6 sm:space-y-8">
            <div class="bg-white p-6 sm:p-8 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white">
                <div class="flex items-center justify-between mb-8">
                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em] {{ $submission->status_color }}">
                        {{ $submission->status_label }}
                    </span>
                    <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Diterima: {{ $submission->created_at->translatedFormat('d M Y') }}</span>
                </div>

                <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4">Informasi Dasar</h2>
                <div class="space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Nama Objek</label>
                        <p class="text-lg font-black text-[#03045E]">{{ $submission->name }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Kategori</label>
                        <p class="font-bold text-slate-700">{{ $submission->category }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Deskripsi Singkat</label>
                        <p class="text-slate-600 leading-relaxed font-medium">{{ $submission->description }}</p>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-slate-50">
                    <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6">Data Spesifik Kategori</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @php
                            $subCat = $submission->category_data[array_keys(array_filter($submission->category_data, fn($k) => str_starts_with($k, 'sub_kategori'), ARRAY_FILTER_USE_KEY))[0] ?? ''] ?? null;
                            $flatFields = \App\Models\CulturalSubmission::getFlatCategoryFields($submission->category, $subCat);
                        @endphp
                        @foreach($submission->category_data as $dataKey => $dataValue)
                            @if(!empty($dataValue) && $dataKey !== 'unesco_categories' && !str_starts_with($dataKey, 'sub_kategori'))
                                @php
                                    $fieldDef = $flatFields[$dataKey] ?? null;
                                    $fieldLabel = $fieldDef['label'] ?? str_replace('_', ' ', ucfirst($dataKey));
                                    $isWide = ($fieldDef['type'] ?? '') === 'textarea' || is_array($dataValue);
                                @endphp
                                <div class="bg-slate-50/50 p-5 rounded-2xl border border-slate-100 {{ $isWide ? 'md:col-span-2' : '' }}">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 block">
                                        {{ $fieldLabel }}
                                    </label>
                                    @if(is_array($dataValue))
                                        @if(isset($dataValue[0]) && is_array($dataValue[0]))
                                            {{-- Dynamic table data --}}
                                            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                                                <div class="grid gap-0 bg-slate-100 border-b border-slate-200" style="grid-template-columns: repeat({{ count(array_keys($dataValue[0])) }}, 1fr);">
                                                    @foreach(array_keys($dataValue[0]) as $colKey)
                                                        <div class="px-4 py-2 text-[10px] font-black text-slate-500 uppercase">{{ str_replace('_', ' ', $colKey) }}</div>
                                                    @endforeach
                                                </div>
                                                @foreach($dataValue as $row)
                                                    <div class="grid gap-0 border-b border-slate-50 last:border-0" style="grid-template-columns: repeat({{ count(array_keys($row)) }}, 1fr);">
                                                        @foreach($row as $cellValue)
                                                            <div class="px-4 py-2 text-sm font-medium text-slate-700">{{ $cellValue }}</div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            {{-- Checkbox array --}}
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($dataValue as $item)
                                                    <span class="px-3 py-1.5 bg-blue-50 text-[#0077B6] rounded-lg text-xs font-bold border border-blue-100">{{ $item }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    @else
                                        <p class="font-{{ ($fieldDef['type'] ?? '') === 'textarea' ? 'medium text-sm leading-relaxed whitespace-pre-wrap italic text-slate-600' : 'bold text-sm text-slate-700' }}">{{ $dataValue ?: '-' }}</p>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                    
                    {{-- UNESCO Categories --}}
                    @if(!empty($submission->category_data['unesco_categories']))
                        <div class="mt-6 pt-6 border-t border-slate-100">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3">Kategori UNESCO</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($submission->category_data['unesco_categories'] as $unescoCat)
                                    <span class="px-3 py-1.5 bg-blue-50 text-[#0077B6] rounded-lg text-xs font-bold border border-blue-100">{{ $unescoCat }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Data Dukung URLs --}}
                    @if(!empty($submission->category_data['video_url']) || !empty($submission->category_data['dokumen_kajian_url']) || !empty($submission->category_data['dokumen_lainnya_url']))
                        <div class="mt-6 pt-6 border-t border-slate-100 space-y-3">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Data Dukung (URL)</p>
                            @foreach(['video_url' => 'Video', 'dokumen_kajian_url' => 'Dokumen Kajian', 'dokumen_lainnya_url' => 'Dokumen Lainnya'] as $urlKey => $urlLabel)
                                @if(!empty($submission->category_data[$urlKey]))
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3">
                                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest w-full sm:w-32 shrink-0">{{ $urlLabel }}:</span>
                                        <a href="{{ $submission->category_data[$urlKey] }}" target="_blank" class="text-xs text-[#0077B6] font-bold hover:underline break-all">{{ $submission->category_data[$urlKey] }}</a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Documents -->
            <div class="bg-white p-6 sm:p-8 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white mt-6 sm:mt-8">
                <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6">Dokumen Lampiran</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($submission->files as $file)
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:border-[#0077B6] transition-all group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-[#0077B6] shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-black text-[#03045E] truncate w-32 md:w-48">{{ $file->original_name }}</p>
                                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">{{ number_format($file->file_size / 1024, 1) }} KB</p>
                                </div>
                            </div>
                            <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="p-2 text-slate-400 hover:text-[#0077B6] transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </a>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic">Tidak ada dokumen lampiran.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6 sm:space-y-8">
            <div class="bg-[#03045E] p-6 sm:p-8 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-blue-900/20 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-white/10 rounded-full blur-3xl"></div>
                <h3 class="text-xs font-black uppercase tracking-[0.3em] text-white/40 mb-6 relative z-10">Data Pengusul</h3>
                <div class="flex items-center gap-4 relative z-10">
                    <div class="w-14 h-14 bg-white/10 rounded-[1.2rem] flex items-center justify-center font-black text-xl border border-white/20">
                        {{ substr($submission->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-black text-lg leading-tight">{{ $submission->user->name }}</p>
                        <p class="text-xs font-medium text-white/50">{{ $submission->user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Validator Info -->
            @if($submission->reviewed_by)
            <div class="bg-white p-6 sm:p-8 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6">Divalidasi Oleh</h3>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center font-black text-[#03045E] border border-indigo-100">
                        {{ substr($submission->reviewedBy->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-black text-[#03045E] leading-tight">{{ $submission->reviewedBy->name }}</p>
                        <p class="text-[10px] font-bold text-[#0077B6] uppercase tracking-widest mt-1">Validator Resmi</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-layouts.super-admin>
