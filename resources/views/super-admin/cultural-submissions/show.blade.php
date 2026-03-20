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
                <div x-data class="w-full">
                    <button @click="$dispatch('open-modal', 'confirm-delete')" class="w-full px-6 py-3 sm:py-2.5 bg-red-50 text-red-600 rounded-xl font-black text-xs uppercase tracking-widest border border-red-100 hover:bg-red-600 hover:text-white transition-all active:scale-95">
                        Hapus Permanen
                    </button>
                    
                    <x-modal name="confirm-delete" focusable maxWidth="md">
                        <form action="{{ route('super-admin.cultural-submissions.destroy', $submission) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="bg-white px-8 pt-10 pb-4 sm:p-10 sm:pb-4 text-center sm:text-left">
                                <div class="mx-auto sm:mx-0 flex items-center justify-center h-16 w-16 rounded-3xl bg-red-50 text-red-600 mb-6 font-black text-2xl">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <h3 class="text-2xl font-black text-[#03045E]">Hapus Permanen?</h3>
                                <p class="mt-3 text-slate-500 font-medium leading-relaxed">
                                    Apakah Anda yakin ingin menghapus data <strong class="text-red-600">{{ $submission->name }}</strong> secara permanen?
                                </p>
                            </div>
                            <div class="px-8 py-8 sm:px-10 flex flex-col sm:flex-row-reverse gap-3 bg-slate-50/50">
                                <button type="submit" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 shadow-lg shadow-red-900/20">
                                    Hapus Permanen
                                </button>
                                <button type="button" @click="$dispatch('close-modal', 'confirm-delete')" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </x-modal>
                </div>
            </div>
        </div>
    </x-slot>

    <div x-data="{ 
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6 sm:space-y-8">
            <div class="bg-white p-6 sm:p-8 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white">
                <div class="flex items-center justify-between mb-8">
                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.15em] uppercase border shadow-sm bg-{{ $submission->status_color }}-50 text-{{ $submission->status_color }}-600 border-{{ $submission->status_color }}-100">
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
                        <p class="text-slate-600 leading-relaxed font-medium break-words">{{ $submission->description }}</p>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-slate-50">
                    <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-8 flex items-center gap-4">
                        <span class="shrink-0">Data Spesifik Kategori</span>
                        <div class="flex-1 h-px bg-slate-100"></div>
                    </h2>
                    
                    <div class="bg-gradient-to-br from-slate-50/50 to-blue-50/30 rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 border border-slate-100 group hover:bg-white hover:shadow-xl hover:shadow-slate-200/30 transition-all duration-300">
                        @php
                            $subCat = $submission->category_data[array_keys(array_filter($submission->category_data, fn($k) => str_starts_with($k, 'sub_kategori'), ARRAY_FILTER_USE_KEY))[0] ?? ''] ?? null;
                            $flatFields = \App\Models\CulturalSubmission::getFlatCategoryFields($submission->category, $subCat);
                            $processedKeys = [];
                        @endphp
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-8">
                            @foreach($submission->category_data as $dataKey => $dataValue)
                                @if(!empty($dataValue) && $dataKey !== 'unesco_categories' && !str_starts_with($dataKey, 'sub_kategori') && !in_array($dataKey, $processedKeys))
                                    @php
                                        $fieldDef = $flatFields[$dataKey] ?? null;
                                        if (!$fieldDef) continue;

                                        // Skip conditional check fields (Ya/Tidak) if the actual data field exists and is filled
                                        if (($fieldDef['type'] ?? '') === 'radio' && in_array($dataValue, ['Ya', 'Tidak'])) {
                                            $hasDependentFilled = false;
                                            foreach($flatFields as $k => $f) {
                                                if (isset($f['condition']) && $f['condition']['field'] === $dataKey && !empty($submission->category_data[$k])) {
                                                    $hasDependentFilled = true;
                                                    break;
                                                }
                                            }
                                            if ($hasDependentFilled) continue;
                                        }

                                        $displayValue = $dataValue;
                                        $displayLabel = $fieldDef['label'] ?? str_replace('_', ' ', ucfirst($dataKey));

                                        // Handle "Lainnya" merging
                                        if ($dataValue === 'Lainnya') {
                                            $otherKey = $dataKey . '_lainnya';
                                            if (!empty($submission->category_data[$otherKey])) {
                                                $displayValue = $submission->category_data[$otherKey];
                                                $processedKeys[] = $otherKey;
                                            }
                                        }

                                        // Clean up specific labels for consistency
                                        if (str_contains(strtolower($displayLabel), 'nama pencipta')) {
                                            $displayLabel = 'Penulis / Pencipta';
                                        }

                                        $isWide = ($fieldDef['type'] ?? '') === 'textarea' || is_array($dataValue);
                                    @endphp
                                    <div class="space-y-1 {{ $isWide ? 'sm:col-span-2' : '' }}">
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $displayLabel }}</p>
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
                                                        <div class="grid gap-0 border-b border-slate-50 hover:bg-slate-50 transition-colors" style="grid-template-columns: repeat({{ count(array_keys($row)) }}, 1fr);">
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
                                                        <span class="px-3 py-1.5 bg-[#0077B6]/10 text-[#0077B6] rounded-lg text-xs font-bold border border-[#0077B6]/10">{{ $item }}</span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @else
                                            <p class="text-slate-700 font-{{ ($fieldDef['type'] ?? '') === 'textarea' ? 'medium text-base leading-relaxed whitespace-pre-wrap italic' : 'bold text-lg' }} break-words">{{ $displayValue ?: '-' }}</p>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        {{-- UNESCO Categories --}}
                        @if(!empty($submission->category_data['unesco_categories']))
                            <div class="mt-8 pt-8 border-t border-slate-100">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Kategori UNESCO</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($submission->category_data['unesco_categories'] as $unescoCat)
                                        <span class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl text-xs font-black border border-indigo-100 shadow-sm">{{ $unescoCat }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Data Dukung URLs --}}
                        @if(!empty($submission->category_data['video_url']) || !empty($submission->category_data['dokumen_kajian_url']) || !empty($submission->category_data['dokumen_lainnya_url']))
                            <div class="mt-8 pt-8 border-t border-slate-100 space-y-4">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Data Dukung Eksternal</p>
                                <div class="grid grid-cols-1 gap-3">
                                    @foreach(['video_url' => 'Video / Media', 'dokumen_kajian_url' => 'Dokumen Kajian', 'dokumen_lainnya_url' => 'Referensi Tambahan'] as $urlKey => $urlLabel)
                                        @if(!empty($submission->category_data[$urlKey]))
                                            <div class="flex flex-col sm:flex-row sm:items-center p-3 rounded-xl bg-white border border-slate-100 gap-3">
                                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest sm:w-40 shrink-0">{{ $urlLabel }}</span>
                                                <a href="{{ $submission->category_data[$urlKey] }}" target="_blank" class="text-xs text-[#0077B6] font-bold hover:underline truncate">{{ $submission->category_data[$urlKey] }}</a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
            </div>

            <!-- Documents -->
            <div class="bg-white p-6 sm:p-8 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white mt-6 sm:mt-8">
                <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6">Dokumen Lampiran</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($submission->files as $file)
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
                        @empty
                            <div class="col-span-full py-12 text-center bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                                <p class="text-slate-400 font-bold text-sm">Belum ada dokumen lampiran.</p>
                            </div>
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
    </div>
</x-layouts.super-admin>
