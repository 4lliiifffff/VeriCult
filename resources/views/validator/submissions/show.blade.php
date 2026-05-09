<x-layouts.validator>
    <x-slot name="header">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('validator.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('validator.submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Antrian</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E] truncate max-w-[150px] sm:max-w-none">Detail Review</span>
        </nav>

        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-5 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group">
            <!-- Decorative Bubbles -->
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/5 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6 sm:gap-8">
                <div class="flex items-center gap-4 sm:gap-8">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 rounded-[1.25rem] sm:rounded-[2rem] bg-[#0077B6] flex items-center justify-center text-white shadow-xl shadow-blue-900/20 font-black text-xl sm:text-2xl uppercase">
                        <svg class="w-7 h-7 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="space-y-2 sm:space-y-3">
                        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                            <span class="px-2.5 py-1 rounded-full text-[8px] sm:text-[10px] font-black tracking-[0.15em] uppercase bg-blue-50 text-[#0077B6] border border-blue-100 shadow-sm">
                                {{ $submission->status_label }}
                            </span>
                            <div class="h-3 w-[1px] bg-slate-200"></div>
                            <span class="text-slate-400 text-[8px] sm:text-[10px] font-bold uppercase tracking-[0.2em]">SUB-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        
                        <h2 class="text-xl sm:text-4xl font-black text-[#03045E] tracking-tight leading-tight break-words max-w-2xl">
                            {{ $submission->name }}
                        </h2>
                        
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="flex items-center gap-2 text-slate-500 font-bold text-[10px] sm:text-xs bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100 uppercase tracking-widest">
                                <svg class="w-3.5 h-3.5 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                <span>{{ $submission->category }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                    
                <div class="flex items-center gap-4">
                    <a href="{{ route('validator.submissions.index') }}" class="inline-flex items-center justify-center px-8 py-4 sm:py-5 bg-slate-50 text-slate-400 rounded-2xl font-black text-[10px] sm:text-[11px] uppercase tracking-[0.2em] hover:bg-[#03045E] hover:text-white hover:-translate-x-1 transition-all duration-300 shadow-sm active:scale-95 gap-3">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="{ 
        submitting: false,
        showClaimModal: false, 
        showUnclaimModal: false,
        showPreviewModal: false,
        previewFile: null,
        openPreview(url, type, name, size) {
            this.previewFile = { url, type, name, size };
            this.showPreviewModal = true;
        },
        closePreview() {
            this.showPreviewModal = false;
            document.querySelectorAll('video').forEach(v => v.pause());
            setTimeout(() => { this.previewFile = null; }, 300);
        }
    }">
        <!-- Action Loading Overlay -->
        <div x-show="submitting"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="fixed inset-0 bg-slate-900/75 flex items-center justify-center z-[100]"
             style="display: none;">
            <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl flex flex-col items-center max-w-xs w-full mx-4 border border-white">
                <div class="relative w-20 h-20 mb-8">
                    <div class="absolute inset-0 border-4 border-[#0077B6]/10 rounded-full"></div>
                    <div class="absolute inset-0 border-4 border-t-[#0077B6] rounded-full animate-spin"></div>
                </div>
                <h3 class="text-[#03045E] font-black text-xl mb-2 text-center">Memproses Aksi</h3>
                <p class="text-slate-500 text-xs font-bold tracking-wide uppercase text-center leading-relaxed">Sistem sedang memproses...</p>
            </div>
        </div>

        <!-- Fullscreen Preview Modal -->
        <template x-teleport="body">
            <div class="fixed inset-0 z-[110] flex items-center justify-center p-4 sm:p-6" x-show="showPreviewModal" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                <div class="absolute inset-0 bg-slate-900/80" @click="closePreview()"></div>
                <div class="relative w-full max-w-6xl max-h-full bg-slate-900 rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/10 flex flex-col">
                    <!-- Modal Header -->
                    <div class="p-6 sm:p-8 flex items-center justify-between border-b border-white/5 bg-slate-900/50 backdrop-blur-md">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center text-[#00B4D8]">
                                <template x-if="previewFile?.type === 'image'">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </template>
                                <template x-if="previewFile?.type === 'video'">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </template>
                            </div>
                            <div>
                                <h3 class="text-white font-black text-lg tracking-tight" x-text="previewFile?.name"></h3>
                                <p class="text-white/40 text-[10px] font-black uppercase tracking-[0.2em]" x-text="previewFile?.size"></p>
                            </div>
                        </div>
                        <button type="button" @click="closePreview()" class="w-12 h-12 rounded-2xl bg-white/5 text-white/50 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all group">
                            <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Content Container -->
                    <div class="w-full bg-black/20 rounded-[2.5rem] border border-white/10 overflow-hidden shadow-2xl flex items-center justify-center relative group/inner min-h-[300px]">
                        <template x-if="previewFile?.type === 'image'">
                            <img :src="previewFile?.url" class="max-w-full max-h-[70vh] object-contain select-none">
                        </template>
                        <template x-if="previewFile?.type === 'video'">
                            <video :src="previewFile?.url" controls autoplay class="max-w-full max-h-[70vh]"></video>
                        </template>
                        
                        <!-- Floating Download Link -->
                        <a :href="previewFile?.url" target="_blank" class="absolute bottom-8 right-8 px-6 py-3 bg-white text-[#03045E] rounded-xl font-black text-[10px] uppercase tracking-widest shadow-xl hover:bg-[#00B4D8] hover:text-white transition-all opacity-0 group-hover/inner:opacity-100 translate-y-4 group-hover/inner:translate-y-0 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Unduh Berkas
                        </a>
                    </div>
                </div>
            </div>
        </template>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            <!-- Left Info Column -->
            <div class="lg:col-span-8 space-y-10">
                
                @if($submission->reviewed_by && $submission->reviewed_by !== Auth::id())
                    <div class="bg-amber-50 border-2 border-amber-100 rounded-[2rem] p-8 flex items-start gap-5">
                        <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-amber-500 shadow-sm shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-black text-[#03045E] uppercase tracking-widest text-xs mb-1">Sedang Direview</h4>
                            <p class="text-sm font-bold text-amber-700 leading-relaxed">Submission ini sedang diproses oleh validator <span class="underline decoration-2 underline-offset-4">{{ $submission->reviewedBy->name }}</span> sejak {{ $submission->review_started_at?->diffForHumans() }}.</p>
                        </div>
                    </div>
                @endif
                
                <!-- Main Details Card -->
                <div class="bg-white rounded-[2rem] sm:rounded-[3rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden relative">
                    <div class="p-6 sm:p-10">
                        <!-- Location & Details Section -->
                        <div class="space-y-10">

                            <!-- Active Culture Summary (The 3 Ws) -->
                            @if($submission->isActiveCulture())
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                    <div class="bg-indigo-50/50 rounded-[2.5rem] p-10 border border-indigo-100/30 group hover:bg-indigo-50/80 transition-all duration-300 shadow-sm hover:shadow-indigo-100/50">
                                        <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-6">Apa (Aktivitas)</p>
                                        <div class="flex items-start gap-5">
                                            <div class="w-12 h-12 rounded-2xl bg-white shadow-xl shadow-indigo-100 flex items-center justify-center text-indigo-600 shrink-0 border border-indigo-50">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </div>
                                            <p class="text-[#03045E] font-black text-xl leading-tight tracking-tight">{{ $submission->category_data['nama_dan_jenis_kebudayaan'] ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="bg-emerald-50/50 rounded-[2.5rem] p-10 border border-emerald-100/30 group hover:bg-emerald-50/80 transition-all duration-300 shadow-sm hover:shadow-emerald-100/50">
                                        <p class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] mb-6">Di Mana (Lokasi)</p>
                                        <div class="flex items-start gap-5">
                                            <div class="w-12 h-12 rounded-2xl bg-white shadow-xl shadow-emerald-100 flex items-center justify-center text-emerald-600 shrink-0 border border-emerald-50">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            </div>
                                            <div class="space-y-1">
                                                <p class="text-[#03045E] font-black text-xl leading-tight tracking-tight">{{ $submission->category_data['desa_lokasi'] ?? '-' }}</p>
                                                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">{{ $submission->category_data['detail_lokasi'] ?? '' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-amber-50/50 rounded-[2.5rem] p-10 border border-amber-100/30 group hover:bg-amber-50/80 transition-all duration-300 shadow-sm hover:shadow-amber-100/50">
                                        <p class="text-[10px] font-black text-amber-400 uppercase tracking-[0.2em] mb-6">Kapan (Pelaksanaan)</p>
                                        <div class="flex items-start gap-5">
                                            <div class="w-12 h-12 rounded-2xl bg-white shadow-xl shadow-amber-100 flex items-center justify-center text-amber-600 shrink-0 border border-amber-50">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <p class="text-[#03045E] font-black text-xl leading-tight tracking-tight">
                                                {{ !empty($submission->category_data['tanggal_pelaksanaan']) ? \Carbon\Carbon::parse($submission->category_data['tanggal_pelaksanaan'])->translatedFormat('d F Y') : '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Description -->
                            @if(!empty($submission->description))
                                <div class="space-y-6">
                                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] flex items-center gap-4">
                                        <span class="shrink-0 text-[#03045E]">{{ $submission->isActiveCulture() ? 'Keterangan Tambahan' : 'Narasi Kebudayaan' }}</span>
                                        <div class="flex-1 h-px bg-slate-100"></div>
                                    </h3>
                                    <div class="p-8 sm:p-10 rounded-[2.5rem] bg-blue-50/10 border border-blue-100/30 overflow-hidden">
                                        <div class="prose prose-slate max-w-none w-full break-words">
                                            <p class="text-slate-700 leading-[1.8] sm:leading-[2] font-medium text-base sm:text-lg italic">
                                                "{{ $submission->description }}"
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Category-Specific Data --}}
                            @php
                                $subCat = $submission->category_data[array_keys(array_filter($submission->category_data, fn($k) => str_starts_with($k, 'sub_kategori'), ARRAY_FILTER_USE_KEY))[0] ?? ''] ?? null;
                                $flatFields = \App\Models\CulturalSubmission::getFlatCategoryFields($submission->category, $subCat);
                                $excludedFields = $submission->isActiveCulture() ? ['nama_dan_jenis_kebudayaan', 'desa_lokasi', 'detail_lokasi', 'tanggal_pelaksanaan', 'kategori_opk'] : [];
                                
                                $hasVisibleFields = false;
                                foreach($submission->category_data as $dataKey => $dataValue) {
                                    if(!empty($dataValue) && $dataKey !== 'unesco_categories' && !str_starts_with($dataKey, 'sub_kategori') && !in_array($dataKey, $excludedFields)) {
                                        $hasVisibleFields = true;
                                        break;
                                    }
                                }
                            @endphp

                            @if($hasVisibleFields || !empty($submission->category_data['unesco_categories']) || (!empty($submission->category_data['video_url']) || !empty($submission->category_data['dokumen_kajian_url']) || !empty($submission->category_data['dokumen_lainnya_url'])))
                                <div class="space-y-6">
                                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] flex items-center gap-4">
                                        <span class="shrink-0 text-[#03045E]">Detail {{ $submission->category }}</span>
                                        <div class="flex-1 h-px bg-slate-100"></div>
                                    </h3>
                                    <div class="bg-gradient-to-br from-slate-50/50 to-blue-50/30 rounded-[2rem] p-8 sm:p-12 border border-slate-100 shadow-inner overflow-hidden">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-10">
                                            @foreach($submission->category_data as $dataKey => $dataValue)
                                                @if(!empty($dataValue) && $dataKey !== 'unesco_categories' && !str_starts_with($dataKey, 'sub_kategori') && !in_array($dataKey, $excludedFields))
                                                    @php
                                                        $fieldDef = $flatFields[$dataKey] ?? null;
                                                        $fieldLabel = $fieldDef['label'] ?? str_replace('_', ' ', ucfirst($dataKey));
                                                        $isWide = ($fieldDef['type'] ?? '') === 'textarea' || is_array($dataValue);
                                                    @endphp
                                                    <div class="space-y-2 min-w-0 flex-1 overflow-hidden {{ $isWide ? 'sm:col-span-2' : '' }}">
                                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-relaxed">{{ $fieldLabel }}</p>
                                                        @if(is_array($dataValue))
                                                            @if(isset($dataValue[0]) && is_array($dataValue[0]))
                                                                {{-- Dynamic table data --}}
                                                                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
                                                                    <div class="grid gap-0 bg-slate-50 border-b border-slate-100" style="grid-template-columns: repeat({{ count(array_keys($dataValue[0])) }}, 1fr);">
                                                                        @foreach(array_keys($dataValue[0]) as $colKey)
                                                                            <div class="px-5 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ str_replace('_', ' ', $colKey) }}</div>
                                                                        @endforeach
                                                                    </div>
                                                                    @foreach($dataValue as $row)
                                                                        <div class="grid gap-0 border-b border-slate-50 last:border-0" style="grid-template-columns: repeat({{ count(array_keys($row)) }}, 1fr);">
                                                                            @foreach($row as $cellValue)
                                                                                <div class="px-5 py-4 text-sm font-bold text-[#03045E] break-words">{{ $cellValue }}</div>
                                                                            @endforeach
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @else
                                                                {{-- Checkbox array --}}
                                                                <div class="flex flex-wrap gap-2 mt-2">
                                                                    @foreach($dataValue as $item)
                                                                        <span class="px-3 py-1.5 bg-blue-50 text-[#0077B6] rounded-lg text-xs sm:text-sm font-bold border border-blue-100/50">{{ $item }}</span>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        @else
                                                            <p class="text-[#03045E] font-{{ ($fieldDef['type'] ?? '') === 'textarea' ? 'bold text-base leading-relaxed whitespace-pre-wrap italic' : 'black text-base sm:text-lg tracking-tight' }} break-all sm:break-words">{{ $dataValue }}</p>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        {{-- UNESCO Categories --}}
                                        @if(!empty($submission->category_data['unesco_categories']))
                                            <div class="mt-6 pt-6 border-t border-slate-100">
                                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Kategori UNESCO</p>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($submission->category_data['unesco_categories'] as $unescoCat)
                                                        <span class="px-3 py-1 bg-blue-50 text-[#03045E] rounded-lg text-sm font-bold border border-blue-100">{{ $unescoCat }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Data Dukung URLs --}}
                                        @if(!empty($submission->category_data['video_url']) || !empty($submission->category_data['dokumen_kajian_url']) || !empty($submission->category_data['dokumen_lainnya_url']))
                                            <div class="mt-6 pt-6 border-t border-slate-100 space-y-3">
                                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Data Dukung (URL)</p>
                                                @foreach(['video_url' => 'Video', 'dokumen_kajian_url' => 'Dokumen Kajian', 'dokumen_lainnya_url' => 'Dokumen Lainnya'] as $urlKey => $urlLabel)
                                                    @if(!empty($submission->category_data[$urlKey]))
                                                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3">
                                                            <span class="text-[11px] sm:text-xs font-bold text-slate-500 w-full sm:w-32 shrink-0">{{ $urlLabel }}:</span>
                                                            <a href="{{ $submission->category_data[$urlKey] }}" target="_blank" class="text-xs sm:text-sm text-[#0077B6] font-medium hover:underline break-all">{{ $submission->category_data[$urlKey] }}</a>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Files Section -->
                            <div class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] flex items-center gap-4 flex-1">
                                        <span class="shrink-0">Lampiran Dokumen</span>
                                        <div class="flex-1 h-px bg-slate-100"></div>
                                    </h3>
                                    <span class="ml-4 px-3 py-1 rounded-lg bg-[#03045E] text-white text-[10px] font-black tracking-widest">{{ $submission->files->count() }} BERKAS</span>
                                </div>
                                
                                @if($submission->files->count() > 0)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                        @foreach($submission->files as $file)
                                            <div class="group/file relative flex flex-col p-4 bg-white border border-slate-100 rounded-[2rem] shadow-sm hover:translate-y-[-4px] hover:shadow-2xl hover:shadow-slate-200/50 hover:border-[#0077B6]/30 transition-all duration-300 overflow-hidden">
                                                <!-- Preview Area -->
                                                <div class="relative w-full h-44 rounded-[1.5rem] overflow-hidden bg-slate-50 flex items-center justify-center shrink-0 mb-4 border border-slate-50/50 shadow-inner group-hover/file:border-[#0077B6]/20 transition-colors">
                                                    @if($file->file_icon == 'image')
                                                        <img src="{{ Storage::url($file->path) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover/file:scale-110">
                                                        <div class="absolute inset-0 bg-black/0 group-hover/file:bg-black/20 transition-colors flex items-center justify-center opacity-0 group-hover/file:opacity-100">
                                                            <button type="button" @click="openPreview('{{ Storage::url($file->path) }}', 'image', '{{ $file->original_name }}', '{{ $file->file_size_human }}')" class="w-12 h-12 rounded-2xl bg-white text-[#03045E] shadow-xl flex items-center justify-center hover:scale-110 transition-transform active:scale-95">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                            </button>
                                                        </div>
                                                    @elseif($file->file_icon == 'video')
                                                        <div class="w-full h-full bg-slate-200 flex items-center justify-center relative">
                                                            <video src="{{ Storage::url($file->path) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover/file:scale-110" preload="metadata"></video>
                                                            <div class="absolute inset-0 bg-black/0 group-hover/file:bg-black/20 transition-colors flex items-center justify-center opacity-0 group-hover/file:opacity-100">
                                                                <button type="button" @click="openPreview('{{ Storage::url($file->path) }}', 'video', '{{ $file->original_name }}', '{{ $file->file_size_human }}')" class="w-12 h-12 rounded-2xl bg-white text-[#03045E] shadow-xl flex items-center justify-center hover:scale-110 transition-transform active:scale-95">
                                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="text-slate-300">
                                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- File Info -->
                                                <div class="flex flex-col">
                                                    <h4 class="text-sm font-black text-[#03045E] truncate mb-1">{{ $file->original_name }}</h4>
                                                    <div class="flex items-center gap-3">
                                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $file->file_size_human }}</span>
                                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                                        <span class="text-[10px] font-black text-[#00B4D8] uppercase tracking-widest">{{ $file->extension }}</span>
                                                    </div>
                                                </div>

                                                <!-- Simple Hover Actions -->
                                                <div class="flex items-center gap-2 mt-5 pt-4 border-t border-slate-50">
                                                    <a href="{{ Storage::url($file->path) }}" target="_blank" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-slate-50 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#03045E] hover:text-white transition-all">
                                                        Unduh
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-12 rounded-[2.5rem] bg-slate-50 border-2 border-dashed border-slate-200 text-center group">
                                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-300 group-hover:scale-110 transition-transform shadow-sm">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="text-slate-400 font-bold text-sm tracking-wide">Belum ada dokumen pendukung.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Submission Meta -->
                        <div class="mt-10 sm:mt-12 pt-6 sm:pt-8 border-t border-slate-50 grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-10">
                            <div class="flex items-start sm:items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#0077B6] border border-slate-100 shadow-sm shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-0.5">Didaftarkan Pada</p>
                                    <p class="text-xs sm:text-sm font-black text-slate-600 tracking-tight break-words">{{ $submission->created_at->translatedFormat('d F Y') }} <span class="text-slate-300 font-medium">pukul</span> {{ $submission->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                            <div class="flex items-start sm:items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#0077B6] border border-slate-100 shadow-sm shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-0.5">Terakhir Diperbarui</p>
                                    <p class="text-xs sm:text-sm font-black text-slate-600 tracking-tight break-words">{{ $submission->updated_at->translatedFormat('d F Y') }} <span class="text-slate-300 font-medium">pukul</span> {{ $submission->updated_at->format('H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Action & Sidebar -->
            <div class="lg:col-span-4 space-y-8">

                <!-- Requester Card -->
                <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-2xl shadow-slate-200/40 border border-white p-6 sm:p-10">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Informasi Pengusul</h3>
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-[#03045E] flex items-center justify-center text-xl font-black text-white shadow-xl shadow-blue-900/20">
                            {{ substr($submission->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-base font-black text-[#03045E]">{{ $submission->user->name }}</p>
                            <p class="text-xs font-bold text-slate-400 mt-1">{{ $submission->user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Main Action Card -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-8 space-y-8 relative overflow-hidden group">
                    <div class="relative z-10 space-y-8">
                        <div>
                            <h3 class="text-[#03045E] font-black text-2xl tracking-tight mb-2">Tindakan Cepat</h3>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Workflow Validasi</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            @if($submission->status === \App\Models\CulturalSubmission::STATUS_VERIFIED)
                                <form action="{{ route('validator.submissions.publish', $submission) }}" method="POST" class="inline w-full">
                                    @csrf
                                    <button type="submit" @click="submitting = true" class="w-full justify-center bg-gradient-to-r from-emerald-500 to-teal-500 text-white px-8 py-5 rounded-[1.25rem] font-black text-xs uppercase tracking-widest hover:from-emerald-600 hover:to-teal-600 transition-all duration-300 shadow-xl shadow-emerald-500/20 hover:-translate-y-1 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z"></path></svg>
                                        Publish ke Publik
                                    </button>
                                </form>
                            @endif
                            
                            @if($submission->reviewed_by === Auth::id() && in_array($submission->status, [\App\Models\CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW, \App\Models\CulturalSubmission::STATUS_FIELD_VERIFICATION, \App\Models\CulturalSubmission::STATUS_SUBMITTED]))
                                <a href="{{ route('validator.submissions.review-form', $submission) }}" class="flex items-center justify-center gap-3 w-full px-8 py-5 rounded-[1.25rem] bg-gradient-to-br from-[#03045E] to-[#0077B6] text-white font-black text-xs tracking-[0.2em] uppercase shadow-2xl shadow-blue-900/40 hover:-translate-y-1 hover:shadow-blue-900/50 transition-all active:scale-95 group/review">
                                    <svg class="w-5 h-5 group-hover/review:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    Masuk Ruang Review
                                </a>
                            @endif

                            @if($submission->status === \App\Models\CulturalSubmission::STATUS_SUBMITTED && $submission->reviewed_by === null)
                                <button type="button" @click="showClaimModal = true" class="flex items-center justify-center gap-3 w-full px-8 py-5 rounded-[1.25rem] bg-gradient-to-br from-[#03045E] to-[#0077B6] text-white font-black text-xs tracking-[0.2em] uppercase shadow-2xl shadow-blue-900/40 hover:-translate-y-1 hover:shadow-blue-900/50 transition-all active:scale-95 group/claim">
                                    <svg class="w-5 h-5 group-hover/claim:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Mulai Review
                                </button>
                            @endif

                            @if($submission->reviewed_by === Auth::id() && $submission->status === \App\Models\CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW)
                                <button type="button" @click="showUnclaimModal = true" class="flex items-center justify-center gap-3 w-full px-8 py-4 rounded-[1.25rem] bg-rose-50 text-rose-600 font-black text-[10px] tracking-[0.2em] uppercase hover:bg-rose-600 hover:text-white transition-all active:scale-[0.98] mt-2 group/unclaim">
                                    <svg class="w-4 h-4 group-hover/unclaim:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Batalkan Klaim
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Timeline / Log Sidebar -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden overflow-y-auto max-h-[600px] scrollbar-hide">
                    <div class="p-8 pb-4 sticky top-0 bg-white/95 backdrop-blur-sm z-10 flex items-center justify-between border-b border-slate-50">
                        <h3 class="text-[#03045E] font-black text-lg tracking-tight flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-[#00B4D8] rounded-full"></span>
                            Jejak Aktivitas
                        </h3>
                    </div>
                    <div class="p-8 pt-6">
                        <div class="space-y-0 relative">
                            <!-- Submit Event -->
                            <div class="relative flex gap-6 group/item">
                                <!-- Line segment -->
                                <div class="absolute left-[15px] top-8 bottom-0 w-0.5 bg-slate-100 group-last/item:hidden"></div>

                                <div class="relative z-10 w-8 h-8 rounded-full bg-blue-50 border-2 border-white flex items-center justify-center text-blue-500 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                </div>
                                <div class="pb-8">
                                    <p class="text-xs font-black text-[#03045E] uppercase tracking-widest">Dikirim oleh Pengusul</p>
                                    <p class="text-[10px] font-bold text-slate-400 mt-1">{{ $submission->submitted_at?->format('d M Y, H:i') ?? $submission->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>

                            @foreach($submission->administrativeReviews as $review)
                                <div class="relative flex gap-6 group/item">
                                    <!-- Line segment -->
                                    <div class="absolute left-[15px] top-8 bottom-0 w-0.5 bg-slate-100 group-last/item:hidden"></div>

                                    <div @class([
                                        'relative z-10 w-8 h-8 rounded-full border-2 border-white flex items-center justify-center text-white shadow-lg',
                                        'bg-emerald-500 shadow-emerald-200' => $review->action === 'forwarded',
                                        'bg-amber-500 shadow-amber-200' => $review->action === 'revision',
                                        'bg-rose-500 shadow-rose-200' => $review->action === 'rejected',
                                    ])>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($review->action === 'forwarded') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                                            @elseif($review->action === 'revision') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            @else <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path> @endif
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0 pb-8">
                                        <div class="flex items-center justify-between gap-2">
                                            <p class="text-[10px] font-black text-[#03045E] uppercase tracking-wider truncate">
                                                Review Administratif
                                            </p>
                                            <span class="text-[9px] font-bold text-slate-400 shrink-0">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div @class([
                                            'mt-2 p-3 rounded-xl border italic text-[11px] font-medium leading-relaxed',
                                            'bg-emerald-50/50 border-emerald-100 text-emerald-700' => $review->action === 'forwarded',
                                            'bg-amber-50/50 border-amber-100 text-amber-700' => $review->action === 'revision',
                                            'bg-rose-50/50 border-rose-100 text-rose-700' => $review->action === 'rejected',
                                        ])>
                                            "{{ $review->notes }}"
                                        </div>
                                        <div class="flex items-center gap-2 mt-2">
                                            <div class="w-5 h-5 rounded-md bg-slate-100 flex items-center justify-center text-[9px] font-black text-slate-500">
                                                {{ substr($review->validator->name, 0, 1) }}
                                            </div>
                                            <p class="text-[9px] font-black text-slate-400 border-b border-dotted border-slate-200 pb-0.5 uppercase tracking-tighter">{{ $review->validator->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @foreach($submission->fieldVerifications as $fv)
                                <div class="relative flex gap-6 group/item">
                                    <!-- Line segment -->
                                    <div class="absolute left-[15px] top-8 bottom-0 w-0.5 bg-slate-100 group-last/item:hidden"></div>

                                    <div @class([
                                        'relative z-10 w-8 h-8 rounded-full border-2 border-white flex items-center justify-center text-white shadow-lg',
                                        'bg-emerald-500 shadow-emerald-200' => $fv->recommendation === 'verified',
                                        'bg-amber-500 shadow-amber-200' => $fv->recommendation === 'revision',
                                        'bg-rose-500 shadow-rose-200' => $fv->recommendation === 'rejected',
                                    ])>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($fv->recommendation === 'verified') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                            @elseif($fv->recommendation === 'revision') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            @else <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path> @endif
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0 pb-8 last:pb-0">
                                        <div class="flex items-center justify-between gap-2">
                                            <p class="text-[10px] font-black text-[#03045E] uppercase tracking-wider truncate">
                                                Verifikasi Lapangan
                                            </p>
                                            <span class="text-[9px] font-bold text-slate-400 shrink-0">{{ $fv->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div @class([
                                            'mt-2 p-3 rounded-xl border italic text-[11px] font-medium leading-relaxed',
                                            'bg-indigo-50/50 border-indigo-100 text-indigo-700' => $fv->recommendation === 'verified',
                                            'bg-amber-50/50 border-amber-100 text-amber-700' => $fv->recommendation === 'revision',
                                            'bg-rose-50/50 border-rose-100 text-rose-700' => $fv->recommendation === 'rejected',
                                        ])>
                                            "{{ $fv->notes }}"
                                        </div>
                                        <div class="flex items-center gap-2 mt-2">
                                            <div class="w-5 h-5 rounded-md bg-slate-100 flex items-center justify-center text-[9px] font-black text-slate-500">
                                                {{ substr($fv->validator->name, 0, 1) }}
                                            </div>
                                            <p class="text-[9px] font-black text-slate-400 border-b border-dotted border-slate-200 pb-0.5 uppercase tracking-tighter">{{ $fv->validator->name }} • {{ $fv->visit_date->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Claim Confirmation Modal -->
    <template x-teleport="body">
        <div x-show="showClaimModal" x-cloak style="display: none;" class="fixed inset-0 flex items-center justify-center z-50"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-slate-900/75" @click="showClaimModal = false"></div>
            <div class="relative bg-white rounded-[2rem] w-full max-w-md mx-4 shadow-2xl shadow-slate-900/20 overflow-hidden"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-8">
                <div class="p-8">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-[#0077B6] flex items-center justify-center shadow-lg shadow-blue-100">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-black text-xl text-[#03045E] tracking-tight">Mulai Review?</h3>
                            <p class="text-xs font-bold text-slate-400 mt-0.5">Klaim pengajuan ini</p>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 mb-6">
                        <p class="text-sm font-black text-[#03045E] mb-1">{{ $submission->name }}</p>
                        <p class="text-xs text-slate-400 font-bold">SUB-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }} • {{ $submission->category }}</p>
                    </div>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed mb-8">
                        Anda akan mengklaim pengajuan ini dan langsung diarahkan ke <strong class="text-[#03045E]">Ruang Review</strong> untuk memulai proses validasi.
                    </p>
                    <div class="flex items-center gap-3">
                        <button @click="showClaimModal = false"
                            class="flex-1 py-4 rounded-2xl border-2 border-slate-100 bg-white text-slate-600 font-black text-xs uppercase tracking-widest hover:bg-slate-50 hover:border-slate-200 transition-all duration-300 active:scale-95">
                            Batal
                        </button>
                        <form action="{{ route('validator.submissions.claim', $submission) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" @click="submitting = true" class="w-full py-4 rounded-2xl bg-[#03045E] text-white font-black text-xs uppercase tracking-widest hover:bg-[#023E8A] transition-all duration-300 active:scale-95 flex items-center justify-center gap-2 shadow-lg shadow-blue-900/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Ya, Mulai Review
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Unclaim Confirmation Modal -->
    <template x-teleport="body">
        <div x-show="showUnclaimModal" x-cloak style="display: none;" class="fixed inset-0 flex items-center justify-center z-50"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-slate-900/75" @click="showUnclaimModal = false"></div>
            <div class="relative bg-white rounded-[2rem] w-full max-w-md mx-4 shadow-2xl shadow-slate-900/20 overflow-hidden"
                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-8">
                <div class="p-8">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center shadow-lg shadow-rose-100">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-black text-xl text-[#03045E] tracking-tight">Batalkan Klaim?</h3>
                            <p class="text-xs font-bold text-slate-400 mt-0.5">Lepaskan pengajuan ini</p>
                        </div>
                    </div>
                    <div class="bg-rose-50/50 rounded-2xl p-5 border border-rose-100 mb-6">
                        <p class="text-sm font-black text-[#03045E] mb-1">{{ $submission->name }}</p>
                        <p class="text-xs text-slate-400 font-bold">SUB-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }} • {{ $submission->category }}</p>
                    </div>
                    <p class="text-sm text-slate-500 font-medium leading-relaxed mb-8">
                        Pengajuan ini akan dikembalikan ke antrian dan dapat diklaim oleh <strong class="text-rose-500">validator lain</strong>. Progress review Anda tidak akan disimpan.
                    </p>
                    <div class="flex items-center gap-3">
                        <button @click="showUnclaimModal = false"
                            class="flex-1 py-4 rounded-2xl border-2 border-slate-100 bg-white text-slate-600 font-black text-xs uppercase tracking-widest hover:bg-slate-50 hover:border-slate-200 transition-all duration-300 active:scale-95">
                            Tidak, Tetap Klaim
                        </button>
                        <form action="{{ route('validator.submissions.unclaim', $submission) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" @click="submitting = true" class="w-full py-4 rounded-2xl bg-rose-500 text-white font-black text-xs uppercase tracking-widest hover:bg-rose-600 transition-all duration-300 active:scale-95 flex items-center justify-center gap-2 shadow-lg shadow-rose-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Ya, Batalkan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </template>
</x-layouts.validator>
