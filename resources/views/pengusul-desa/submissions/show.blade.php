<x-layouts.pengusul-desa>
    <x-slot name="header">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('pengusul-desa.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('pengusul-desa.submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Pengajuan Saya</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E] truncate max-w-[150px] sm:max-w-none">{{ $submission->name }}</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
            <div class="space-y-3 w-full md:w-auto">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.15em] uppercase bg-{{ $submission->status_color }}-50 text-{{ $submission->status_color }}-600 border border-{{ $submission->status_color }}-100 shadow-sm">
                        {{ $submission->status_label }}
                    </span>
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">SUB-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <h2 class="font-black text-3xl sm:text-4xl text-[#03045E] leading-tight tracking-tight break-words">
                    {{ $submission->name }}
                </h2>
                <div class="flex items-center gap-2 text-slate-500 font-bold text-sm">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-[#0077B6] shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                    <span>{{ $submission->category }}</span>
                </div>
            </div>
            <div class="flex items-center gap-4 w-full md:w-auto mt-2 md:mt-0">
                <a href="{{ route('pengusul-desa.submissions.index') }}" class="w-full md:w-auto justify-center inline-flex items-center px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 hover:bg-slate-50 hover:border-slate-300 shadow-sm shadow-slate-200/50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10" x-data="{ 
        submitting: false, 
        deleting: false,
        showPreviewModal: false,
        previewFile: null,
        openPreview(url, type, name) {
            this.previewFile = { url, type, name };
            this.showPreviewModal = true;
        },
        closePreview() {
            this.showPreviewModal = false;
            setTimeout(() => { this.previewFile = null; }, 300);
        }
    }">
        <!-- Action Loading Overlay -->
        <div x-show="submitting || deleting"
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
                <h3 class="text-[#03045E] font-black text-xl mb-2 text-center" x-text="submitting ? 'Mengirim Data' : 'Menghapus Data'"></h3>
                <p class="text-slate-500 text-xs font-bold tracking-wide uppercase text-center leading-relaxed">Sistem sedang memproses...</p>
            </div>
        </div>

        <!-- Fullscreen Preview Modal -->
        <template x-teleport="body">
            <div x-show="showPreviewModal" 
                 x-cloak
                 class="fixed inset-0 z-[200] flex items-center justify-center p-4 sm:p-10"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100">
                <div class="absolute inset-0 bg-slate-900/80" @click="closePreview()"></div>
                
                <div class="relative w-full max-w-6xl max-h-full flex flex-col items-center"
                     x-transition:enter="transition ease-out duration-300 delay-100"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-10"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                    
                    <!-- Modal Header -->
                    <div class="absolute -top-16 left-0 right-0 flex items-center justify-between text-white px-2">
                        <div class="flex flex-col">
                            <h4 class="text-sm font-black uppercase tracking-widest text-white/60 mb-1" x-text="previewFile?.type"></h4>
                            <p class="text-lg font-black tracking-tight truncate max-w-[200px] sm:max-w-md" x-text="previewFile?.name"></p>
                        </div>
                        <button @click="closePreview()" class="w-12 h-12 rounded-2xl bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all group active:scale-90">
                            <svg class="w-6 h-6 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
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
                
                <!-- Main Details Card -->
                <div class="bg-white rounded-[2rem] sm:rounded-[3rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden relative">
                    <div class="p-6 sm:p-14">
                        <!-- Location & Details Section -->
                        <div class="space-y-12">


                            <!-- Description -->
                            <div class="space-y-6">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] flex items-center gap-4">
                                    <span class="shrink-0">Narasi Kebudayaan</span>
                                    <div class="flex-1 h-px bg-slate-100"></div>
                                </h3>
                                <div class="p-6 sm:p-10 rounded-[2rem] sm:rounded-[2.5rem] bg-indigo-50/10 border border-indigo-100/30 overflow-hidden">
                                    <div class="prose prose-slate max-w-none w-full break-words">
                                        <p class="text-slate-700 leading-[1.8] sm:leading-[2] font-medium text-base sm:text-lg italic">
                                            "{{ $submission->description }}"
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Category-Specific Data --}}
                            @if(!empty($submission->category_data))
                            <div class="space-y-6">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] flex items-center gap-4">
                                    <span class="shrink-0">Detail {{ $submission->category }}</span>
                                    <div class="flex-1 h-px bg-slate-100"></div>
                                </h3>
                                <div class="bg-gradient-to-br from-slate-50/50 to-blue-50/30 rounded-[2rem] p-8 border border-slate-100">
                                    @php
                                        $subCat = $submission->category_data[array_keys(array_filter($submission->category_data, fn($k) => str_starts_with($k, 'sub_kategori'), ARRAY_FILTER_USE_KEY))[0] ?? ''] ?? null;
                                        $flatFields = \App\Models\CulturalSubmission::getFlatCategoryFields($submission->category, $subCat);
                                    @endphp
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        @foreach($submission->category_data as $dataKey => $dataValue)
                                            @if(!empty($dataValue) && $dataKey !== 'unesco_categories' && !str_starts_with($dataKey, 'sub_kategori'))
                                                @php
                                                    $fieldDef = $flatFields[$dataKey] ?? null;
                                                    $fieldLabel = $fieldDef['label'] ?? str_replace('_', ' ', ucfirst($dataKey));
                                                    $isWide = ($fieldDef['type'] ?? '') === 'textarea' || is_array($dataValue);
                                                @endphp
                                                <div class="space-y-1 {{ $isWide ? 'sm:col-span-2' : '' }}">
                                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $fieldLabel }}</p>
                                                    @if(is_array($dataValue))
                                                        @if(isset($dataValue[0]) && is_array($dataValue[0]))
                                                            {{-- Dynamic table data --}}
                                                            <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
                                                                <div class="grid gap-0 bg-slate-50 border-b border-slate-100" style="grid-template-columns: repeat({{ count(array_keys($dataValue[0])) }}, 1fr);">
                                                                    @foreach(array_keys($dataValue[0]) as $colKey)
                                                                        <div class="px-4 py-2 text-xs font-bold text-slate-500 uppercase">{{ str_replace('_', ' ', $colKey) }}</div>
                                                                    @endforeach
                                                                </div>
                                                                @foreach($dataValue as $row)
                                                                    <div class="grid gap-0 border-b border-slate-50" style="grid-template-columns: repeat({{ count(array_keys($row)) }}, 1fr);">
                                                                        @foreach($row as $cellValue)
                                                                            <div class="px-4 py-2 text-sm font-medium text-slate-700 break-words">{{ $cellValue }}</div>
                                                                        @endforeach
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            {{-- Checkbox array --}}
                                                            <div class="flex flex-wrap gap-2 mt-2">
                                                                @foreach($dataValue as $item)
                                                                    <span class="px-3 py-1.5 bg-[#0077B6]/10 text-[#0077B6] rounded-lg text-xs sm:text-sm font-bold">{{ $item }}</span>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    @else
                                                        <p class="text-slate-700 font-{{ ($fieldDef['type'] ?? '') === 'textarea' ? 'medium text-sm leading-relaxed whitespace-pre-wrap' : 'bold text-base' }} break-all sm:break-words">{{ $dataValue }}</p>
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
                                                            <button @click="openPreview('{{ Storage::url($file->path) }}', 'image', '{{ $file->original_name }}')" class="p-4 bg-white/20 backdrop-blur-md text-white rounded-full hover:bg-[#0077B6] transition-all transform hover:scale-110 active:scale-90">
                                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                            </button>
                                                        </div>
                                                    @elseif($file->file_icon == 'video')
                                                        <div class="relative w-full h-full bg-slate-900 flex items-center justify-center">
                                                            <video src="{{ Storage::url($file->path) }}" class="w-full h-full object-cover opacity-60" preload="metadata"></video>
                                                            <div class="absolute inset-0 flex items-center justify-center">
                                                                <button @click="openPreview('{{ Storage::url($file->path) }}', 'video', '{{ $file->original_name }}')" class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white border border-white/30 hover:bg-[#0077B6] hover:border-[#0077B6] hover:scale-110 transition-all group/play active:scale-95 shadow-2xl">
                                                                    <svg class="w-8 h-8 translate-x-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="flex flex-col items-center justify-center text-slate-300 group-hover/file:text-[#0077B6] transition-colors">
                                                            <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                            <span class="text-[10px] font-black uppercase tracking-widest">{{ strtoupper($file->file_type) }}</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Content Area -->
                                                <div class="px-1 min-w-0 flex-1">
                                                    <p class="text-[14px] font-black text-slate-700 truncate group-hover/file:text-[#0077B6] transition-colors mb-1" title="{{ $file->original_name }}">
                                                        {{ $file->original_name }}
                                                    </p>
                                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-2">
                                                        <span>{{ $file->file_size_human }}</span>
                                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-100"></span>
                                                        <span class="text-[#00B4D8]">{{ strtoupper($file->file_type) }}</span>
                                                    </p>
                                                </div>

                                                <!-- Footer Actions -->
                                                <div class="flex items-center gap-2 mt-5 pt-4 border-t border-slate-50">
                                                    <a href="{{ Storage::url($file->path) }}" target="_blank" class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-slate-50 text-slate-500 hover:bg-[#0077B6] hover:text-white rounded-xl font-black text-[10px] uppercase tracking-widest transition-all active:scale-95">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                        Unduh Berkas
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-16 rounded-[2.5rem] bg-slate-50 border-2 border-dashed border-slate-200 text-center group">
                                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-300 group-hover:scale-110 transition-transform shadow-sm">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="text-slate-400 font-bold text-sm tracking-wide">Belum ada dokumen pendukung.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Submission Meta -->
                        <div class="mt-12 sm:mt-16 pt-8 sm:pt-10 border-t border-slate-50 grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-10">
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

                <!-- Admin Remarks Section (If exists) -->
                @php
                    $latestReview = $submission->administrativeReviews->first();
                @endphp
                @if($latestReview && in_array($submission->status, [\App\Models\CulturalSubmission::STATUS_REVISION, \App\Models\CulturalSubmission::STATUS_REJECTED]))
                <div class="bg-amber-50/50 rounded-[2.5rem] p-10 border border-amber-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-amber-100/40 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <h3 class="text-[11px] font-black text-amber-600 uppercase tracking-[0.25em] mb-6 flex items-center gap-4">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                            Catatan {{ $submission->status === \App\Models\CulturalSubmission::STATUS_REVISION ? 'Revisi' : 'Penolakan' }} ({{ $latestReview->created_at->translatedFormat('d M Y') }})
                        </h3>
                        <div class="p-8 rounded-[1.5rem] bg-white border border-amber-200/50 text-slate-700 leading-relaxed font-bold italic text-base shadow-sm break-words">
                            "{{ $latestReview->notes }}"
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right: Action & Sidebar -->
            <div class="lg:col-span-4 space-y-10">
                
                <!-- Main Action Card -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-10 space-y-10 relative overflow-hidden group">
                    <div class="relative z-10 space-y-8">
                        <div>
                            <h3 class="text-[#03045E] font-black text-2xl tracking-tight mb-2">Tindakan Cepat</h3>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Workflow Pengajuan</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            @if($submission->isEditable())
                                <a href="{{ route('pengusul-desa.submissions.edit', $submission) }}" 
                                   class="flex items-center justify-center gap-3 w-full px-8 py-5 rounded-[1.25rem] bg-slate-50 border-2 border-slate-100 text-[#03045E] font-black text-xs tracking-[0.2em] uppercase hover:bg-white hover:border-[#0077B6] hover:text-[#0077B6] hover:shadow-xl hover:shadow-blue-500/10 transition-all active:scale-[0.98]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Ubah Konten
                                </a>
                            @endif

                            @if($submission->canBeSubmitted())
                                <button type="button" 
                                        @click="$dispatch('open-modal', 'confirm-final-submission')" 
                                        class="flex items-center justify-center gap-4 w-full px-8 py-6 rounded-[1.25rem] bg-gradient-to-br from-[#03045E] to-[#0077B6] text-white font-black text-xs tracking-[0.25em] uppercase shadow-2xl shadow-blue-900/40 hover:shadow-blue-900/50 hover:-translate-y-1 transition-all active:scale-95 group/submit">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                    Kirim Final
                                </button>
                            @endif

                            @if($submission->status == \App\Models\CulturalSubmission::STATUS_DRAFT)
                                <button type="button" 
                                        @click="$dispatch('open-modal', 'confirm-submission-deletion')" 
                                        class="flex items-center justify-center gap-3 w-full px-8 py-4 rounded-[1.25rem] bg-rose-50 text-rose-600 font-black text-[10px] tracking-[0.2em] uppercase hover:bg-rose-600 hover:text-white transition-all active:scale-[0.98] mt-4">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Batalkan Pengajuan
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Timeline / Log Sidebar -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden overflow-y-auto max-h-[600px] scrollbar-hide">
                    <div class="p-10 pb-4 sticky top-0 bg-white/95 backdrop-blur-sm z-10 flex items-center justify-between border-b border-slate-50">
                        <h3 class="text-[#03045E] font-black text-lg tracking-tight flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-[#00B4D8] rounded-full"></span>
                            Jejak Aktivitas
                        </h3>
                    </div>
                    <div class="p-10 pt-8">
                        @include('pengusul-desa.submissions.partials.timeline')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Final Submission Confirmation -->
    <x-modal name="confirm-final-submission" :show="false" focusable>
        <div class="p-10 sm:p-14">
            <div class="flex flex-col items-center text-center mb-10">
                <div class="w-24 h-24 bg-blue-50 rounded-[2rem] flex items-center justify-center text-[#0077B6] mb-8 shadow-inner relative group/icon">
                    <div class="absolute inset-0 bg-[#00B4D8]/20 rounded-[2rem] animate-ping opacity-0 group-hover/icon:opacity-100 transition-opacity"></div>
                    <svg class="w-12 h-12 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </div>
                <h2 class="text-3xl font-black text-[#03045E] mb-3 leading-tight tracking-tight">Kirim Sekarang?</h2>
                <p class="text-slate-500 max-w-sm leading-relaxed font-bold text-sm">Data akan dikunci dan dikirim ke tim Reviewer. Anda tidak dapat mengubah data ini hingga proses selesai.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-10 border-t border-slate-50">
                <button type="button" 
                        @click="$dispatch('close')" 
                        class="px-8 py-5 rounded-2xl border-2 border-slate-100 text-slate-500 font-black text-[11px] tracking-[0.2em] uppercase hover:bg-slate-50 transition-all active:scale-[0.98]">
                    Batal
                </button>
                <form action="{{ route('pengusul-desa.submissions.submit', $submission) }}" method="POST">
                    @csrf
                    <button type="submit" 
                            @click="submitting = true; $dispatch('close')" 
                            class="w-full px-8 py-5 rounded-2xl bg-[#03045E] text-white font-black text-[11px] tracking-[0.2em] uppercase shadow-2xl shadow-blue-900/20 hover:bg-[#0077B6] transition-all active:scale-[0.98]">
                        Ya, Kirim
                    </button>
                </form>
            </div>
        </div>
    </x-modal>

    <!-- Deletion Confirmation -->
    <x-modal name="confirm-submission-deletion" :show="false" focusable>
        <div class="p-10 sm:p-14 text-center">
            <div class="w-24 h-24 bg-rose-50 rounded-[2rem] flex items-center justify-center text-rose-600 mx-auto mb-8 shadow-inner">
                <svg class="w-12 h-12 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <h2 class="text-3xl font-black text-[#03045E] mb-3 tracking-tight leading-tight">Batalkan Pengajuan?</h2>
            <p class="text-slate-500 max-w-sm mx-auto leading-relaxed font-bold text-sm mb-10">Tindakan ini permanen. Seluruh data dan file yang telah Anda unggah akan dihapus sepenuhnya.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-10 border-t border-slate-50">
                <button type="button" 
                        @click="$dispatch('close')" 
                        class="px-8 py-5 rounded-2xl border-2 border-slate-100 text-slate-500 font-black text-[11px] tracking-[0.2em] uppercase hover:bg-slate-50 transition-all active:scale-[0.98]">
                    Kembali
                </button>
                <form action="{{ route('pengusul-desa.submissions.destroy', $submission) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            @click="deleting = true; $dispatch('close')" 
                            class="w-full px-8 py-5 rounded-2xl bg-rose-600 text-white font-black text-[11px] tracking-[0.2em] uppercase shadow-2xl shadow-rose-900/20 hover:bg-rose-700 transition-all active:scale-[0.98]">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </x-modal>
</x-layouts.pengusul-desa>
