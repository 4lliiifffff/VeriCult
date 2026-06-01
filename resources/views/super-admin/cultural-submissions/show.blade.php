<x-layouts.super-admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('super-admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('super-admin.cultural-submissions.index') }}" class="hover:text-[#0077B6] transition-colors text-slate-400">Pengajuan Kebudayaan</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Detail Obyek</span>
        </nav>

        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-5 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6 sm:gap-8">
                <div class="flex items-center gap-4 sm:gap-8">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 rounded-[1.25rem] sm:rounded-[2rem] bg-[#03045E] flex items-center justify-center text-white shadow-xl shadow-blue-900/20 font-black text-xl sm:text-2xl uppercase">
                        {{ substr($submission->name, 0, 2) }}
                    </div>
                    <div class="space-y-1 sm:space-y-2">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="px-2.5 py-1 rounded-full text-[7px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-slate-100 text-slate-500 border border-slate-200">
                                Cultural Asset
                            </div>
                            <div class="h-3 w-[1px] bg-slate-200"></div>
                            <span class="text-slate-400 text-[7px] sm:text-[10px] font-bold uppercase tracking-widest">Detail View</span>
                        </div>
                        <h2 class="text-xl sm:text-4xl font-black text-[#03045E] tracking-tight leading-tight">
                            Detail <span class="text-[#0077B6]">Kebudayaan</span>
                        </h2>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('super-admin.cultural-submissions.edit', $submission) }}" class="flex-1 sm:flex-none px-5 py-3 sm:px-6 sm:py-4 bg-blue-50 text-[#0077B6] rounded-xl sm:rounded-2xl font-black text-[9px] sm:text-[10px] uppercase tracking-widest hover:bg-[#0077B6] hover:text-white transition-all flex items-center justify-center gap-3 border border-blue-100 active:scale-95 group/btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit
                    </a>
                    <div x-data class="flex-1 sm:flex-none">
                        <button @click="$dispatch('open-modal', 'confirm-delete')" class="w-full px-5 py-3 sm:px-6 sm:py-4 bg-red-50 text-red-600 rounded-xl sm:rounded-2xl font-black text-[9px] sm:text-[10px] uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all flex items-center justify-center gap-3 border border-red-100 active:scale-95 group/btn">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus
                        </button>

                        <x-modal name="confirm-delete" focusable maxWidth="md">
                            <form action="{{ route('super-admin.cultural-submissions.destroy', $submission) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="bg-white p-8 sm:p-12">
                                    <div class="w-20 h-20 rounded-[2rem] bg-red-50 text-red-600 flex items-center justify-center mb-8 shadow-xl shadow-red-900/10 border border-red-100">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </div>
                                    <h3 class="text-3xl font-black text-[#03045E] tracking-tight leading-tight mb-4">Hapus Permanen?</h3>
                                    <p class="text-slate-500 font-bold text-sm leading-relaxed mb-0 uppercase tracking-tight">
                                        Apakah Anda yakin ingin menghapus data <strong class="text-red-600 underline">{{ $submission->name }}</strong> secara permanen? Tindakan ini tidak dapat dibatalkan.
                                    </p>
                                </div>
                                <div class="px-8 sm:px-12 py-8 bg-slate-50 flex flex-col sm:flex-row-reverse gap-4">
                                    <button type="submit" class="flex-1 px-8 py-5 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] transition-all duration-300 shadow-xl shadow-red-900/40 active:scale-95">
                                        Konfirmasi Hapus
                                    </button>
                                    <button type="button" @click="$dispatch('close-modal', 'confirm-delete')" class="flex-1 px-8 py-5 bg-white text-slate-500 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] transition-all duration-300 border border-slate-200 active:scale-95">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </x-modal>
                    </div>
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
            document.querySelectorAll('video').forEach(v => v.pause());
            setTimeout(() => { this.previewFile = null; }, 300);
        }
    }">
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-10">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6 sm:space-y-10">
            <div class="bg-white p-6 sm:p-12 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-10">
                    <span class="px-4 py-2 rounded-xl text-[9px] font-black tracking-[0.2em] uppercase border shadow-sm bg-{{ $submission->status_color }}-50 text-{{ $submission->status_color }}-600 border-{{ $submission->status_color }}-100">
                        {{ $submission->status_label }}
                    </span>
                    <span class="text-slate-400 text-[10px] font-black uppercase tracking-widest bg-slate-50 px-4 py-2 rounded-lg">ID Pengajuan: #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>

                <div class="space-y-8 sm:space-y-10">
                    <div class="space-y-6">
                        <h2 class="text-[10px] font-black text-[#0077B6] uppercase tracking-[0.3em] flex items-center gap-4">
                            <span class="shrink-0 text-[#03045E]">Informasi Dasar</span>
                            <div class="flex-1 h-px bg-slate-100"></div>
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                            <div class="sm:col-span-2">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Nama Objek Budaya</label>
                                <p class="text-2xl sm:text-3xl font-black text-[#03045E] leading-tight">{{ $submission->name }}</p>
                            </div>
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Kategori</label>
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-[#0077B6]"></div>
                                    <p class="font-black text-[#03045E] uppercase tracking-tighter">{{ $submission->category }}</p>
                                </div>
                            </div>
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Tanggal Diterima</label>
                                <p class="font-bold text-slate-600">{{ $submission->created_at->translatedFormat('d F Y') }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 block">Deskripsi Singkat</label>
                                <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 italic text-slate-600 leading-relaxed font-medium break-words">
                                    {{ $submission->description }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <h2 class="text-[10px] font-black text-[#0077B6] uppercase tracking-[0.3em] flex items-center gap-4">
                            <span class="shrink-0 text-[#03045E]">Data Spesifik Kategori</span>
                            <div class="flex-1 h-px bg-slate-100"></div>
                        </h2>

                        <div class="bg-gradient-to-br from-slate-50/50 to-blue-50/30 rounded-[2rem] p-6 sm:p-10 border border-slate-100 group hover:bg-white hover:shadow-xl hover:shadow-slate-200/30 transition-all duration-500">
                            @php
                                $subCat = $submission->category_data[array_keys(array_filter($submission->category_data, fn($k) => str_starts_with($k, 'sub_kategori'), ARRAY_FILTER_USE_KEY))[0] ?? ''] ?? null;
                                $flatFields = \App\Models\CulturalSubmission::getFlatCategoryFields($submission->category, $subCat);
                                $processedKeys = [];
                            @endphp

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 sm:gap-10">
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

                                            $isWide = ($fieldDef['type'] ?? '') === 'textarea' || is_array($dataValue);
                                        @endphp
                                        <div class="space-y-2 {{ $isWide ? 'sm:col-span-2' : '' }}">
                                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $displayLabel }}</p>
                                                @if(is_array($dataValue))
                                                    @if(isset($dataValue[0]) && is_array($dataValue[0]))
                                                        {{-- Dynamic table data --}}
                                                        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
                                                            <div class="overflow-x-auto">
                                                                <table class="w-full text-left border-collapse min-w-max responsive-table">
                                                                    <thead class="bg-slate-50/50 border-b border-slate-100">
                                                                        <tr>
                                                                            @foreach(array_keys($dataValue[0]) as $colKey)
                                                                                <th class="px-5 py-3 text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ str_replace('_', ' ', $colKey) }}</th>
                                                                            @endforeach
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="divide-y divide-slate-50">
                                                                        @foreach($dataValue as $row)
                                                                            <tr class="hover:bg-slate-50/50 transition-colors">
                                                                                @foreach($row as $cellValue)
                                                                                    <td class="px-5 py-4 text-sm font-bold text-[#03045E]">{{ is_array($cellValue) ? implode(', ', $cellValue) : ($cellValue ?: '-') }}</td>
                                                                                @endforeach
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @else
                                                        {{-- Checkbox array --}}
                                                        <div class="flex flex-wrap gap-2">
                                                            @foreach($dataValue as $item)
                                                                <span class="px-4 py-2 bg-[#0077B6]/10 text-[#0077B6] rounded-xl text-xs font-black border border-[#0077B6]/10 shadow-sm">{{ is_array($item) ? implode(', ', $item) : $item }}</span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @else
                                                <div class="{{ ($fieldDef['type'] ?? '') === 'textarea' ? 'p-5 bg-white/50 rounded-2xl border border-slate-100 text-slate-600 font-medium leading-relaxed italic text-base' : 'text-lg font-black text-[#03045E] tracking-tight' }}">
                                                    {{ $displayValue ?: '-' }}
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            {{-- UNESCO Categories --}}
                            @if(!empty($submission->category_data['unesco_categories']))
                                <div class="mt-10 pt-10 border-t border-slate-200/50">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-5">Kategori UNESCO Terkait</p>
                                    <div class="flex flex-wrap gap-3">
                                        @foreach($submission->category_data['unesco_categories'] as $unescoCat)
                                            <span class="px-5 py-2.5 bg-[#03045E] text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-blue-900/10 border border-blue-900/20">{{ $unescoCat }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Data Dukung URLs --}}
                            @if(!empty($submission->category_data['video_url']) || !empty($submission->category_data['dokumen_kajian_url']) || !empty($submission->category_data['dokumen_lainnya_url']))
                                <div class="mt-10 pt-10 border-t border-slate-200/50 space-y-4">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Tautan Data Pendukung</p>
                                    <div class="grid grid-cols-1 gap-4">
                                        @foreach(['video_url' => 'Video Dokumentasi', 'dokumen_kajian_url' => 'Dokumen Kajian Teknis', 'dokumen_lainnya_url' => 'Referensi Tambahan'] as $urlKey => $urlLabel)
                                            @if(!empty($submission->category_data[$urlKey]))
                                                <a href="{{ $submission->category_data[$urlKey] }}" target="_blank" class="flex items-center justify-between p-4 bg-white rounded-2xl border border-slate-100 hover:border-[#0077B6] hover:shadow-xl transition-all duration-300 group/link">
                                                    <div class="flex items-center gap-4">
                                                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0077B6] flex items-center justify-center group-hover/link:bg-[#0077B6] group-hover/link:text-white transition-colors">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.826a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                                        </div>
                                                        <div>
                                                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">{{ $urlLabel }}</p>
                                                            <p class="text-xs font-bold text-[#0077B6] truncate max-w-xs">{{ $submission->category_data[$urlKey] }}</p>
                                                        </div>
                                                    </div>
                                                    <svg class="w-5 h-5 text-slate-300 group-hover/link:text-[#0077B6] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="bg-white p-6 sm:p-12 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white">
                <h2 class="text-[10px] font-black text-[#0077B6] uppercase tracking-[0.3em] mb-8 flex items-center gap-4">
                    <span class="shrink-0 text-[#03045E]">Berkas Pendukung</span>
                    <div class="flex-1 h-px bg-slate-100"></div>
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @forelse($submission->files as $file)
                        <div class="group/file relative flex flex-col p-4 bg-white border border-slate-100 rounded-[2rem] shadow-sm hover:translate-y-[-4px] hover:shadow-2xl hover:shadow-slate-200/50 hover:border-[#0077B6]/30 transition-all duration-300 overflow-hidden">
                            <!-- Preview Area -->
                            <div class="relative w-full h-44 rounded-[1.5rem] overflow-hidden bg-slate-50 flex items-center justify-center shrink-0 mb-4 border border-slate-50/50 shadow-inner group-hover/file:border-[#0077B6]/20 transition-colors">
                                @if($file->file_icon == 'image')
                                    <img src="{{ Storage::url($file->path) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover/file:scale-110">
                                    <div class="absolute inset-0 bg-black/0 group-hover/file:bg-black/20 transition-colors flex items-center justify-center opacity-0 group-hover/file:opacity-100">
                                        <button type="button" @click="openPreview('{{ Storage::url($file->path) }}', 'image', '{{ $file->original_name }}')" class="w-12 h-12 rounded-2xl bg-white text-[#03045E] shadow-xl flex items-center justify-center hover:scale-110 transition-transform active:scale-95">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </button>
                                    </div>
                                @elseif($file->file_icon == 'video')
                                    <div class="w-full h-full bg-slate-200 flex items-center justify-center relative">
                                        <video src="{{ Storage::url($file->path) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover/file:scale-110" preload="metadata"></video>
                                        <div class="absolute inset-0 bg-black/0 group-hover/file:bg-black/20 transition-colors flex items-center justify-center opacity-0 group-hover/file:opacity-100">
                                            <button type="button" @click="openPreview('{{ Storage::url($file->path) }}', 'video', '{{ $file->original_name }}')" class="w-12 h-12 rounded-2xl bg-white text-[#03045E] shadow-xl flex items-center justify-center hover:scale-110 transition-transform active:scale-95">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-slate-300">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Content Area -->
                            <div class="px-1 min-w-0 flex-1">
                                <p class="text-[14px] font-black text-[#03045E] truncate group-hover/file:text-[#0077B6] transition-colors mb-1" title="{{ $file->original_name }}">
                                    {{ $file->original_name }}
                                </p>
                                <div class="flex items-center gap-3">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $file->file_size_human }}</span>
                                    <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                                    <span class="text-[9px] font-black text-[#00B4D8] uppercase tracking-widest">{{ strtoupper($file->file_type) }}</span>
                                </div>
                            </div>

                            <!-- Footer Actions -->
                            <div class="mt-5 pt-4 border-t border-slate-50">
                                <a href="{{ Storage::url($file->path) }}" target="_blank" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-slate-50 text-slate-500 hover:bg-[#03045E] hover:text-white rounded-xl font-black text-[9px] uppercase tracking-[0.2em] transition-all active:scale-95 group/btn-dl">
                                    <svg class="w-4 h-4 group-hover/btn-dl:translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Unduh File
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 text-center bg-slate-50 rounded-[2.5rem] border-2 border-dashed border-slate-200">
                            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-4 shadow-sm">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <p class="text-slate-400 font-black text-[10px] uppercase tracking-widest">Belum ada dokumen lampiran.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6 sm:space-y-10">
            {{-- Proposer Card --}}
            <div class="bg-[#03045E] p-6 sm:p-10 rounded-[2rem] sm:rounded-[2.5rem] shadow-2xl shadow-blue-900/40 text-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 -mr-12 -mt-12 w-48 h-48 bg-white/5 rounded-full blur-3xl transition-transform duration-1000 group-hover:scale-150"></div>

                <h3 class="text-[9px] font-black uppercase tracking-[0.3em] text-white/40 mb-8 relative z-10">Profil Pengusul</h3>

                <div class="flex items-center gap-5 relative z-10 mb-8">
                    <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center font-black text-2xl border border-white/20 shadow-xl">
                        {{ substr($submission->user->name, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-black text-xl leading-tight truncate">{{ $submission->user->name }}</p>
                        <p class="text-[11px] font-medium text-white/40 truncate">{{ $submission->user->email }}</p>
                        @if($submission->user->no_hp)
                            <p class="text-[11px] font-medium text-white/40 truncate mt-0.5">+62{{ $submission->user->no_hp }}</p>
                        @endif
                    </div>
                </div>

                <div class="space-y-4 relative z-10">
                    <div class="p-4 bg-white/5 rounded-xl border border-white/10">
                        <p class="text-[8px] font-black text-white/30 uppercase tracking-widest mb-1">Peran User</p>
                        <p class="text-xs font-black uppercase tracking-tighter">{{ $submission->user->roles->first()?->name ?: 'Umum' }}</p>
                    </div>
                    <a href="{{ route('super-admin.users.show', $submission->user) }}" class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-white text-[#03045E] rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#00B4D8] hover:text-white transition-all duration-300">
                        Lihat Profil Lengkap
                    </a>
                </div>
            </div>

            <!-- Validator Info -->
            @if($submission->reviewed_by)
            <div class="bg-white p-6 sm:p-10 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white group">
                <h3 class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] mb-8">Divalidasi Oleh</h3>
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center font-black text-2xl text-[#0077B6] border border-blue-100 shadow-inner group-hover:bg-[#0077B6] group-hover:text-white transition-all duration-500">
                        {{ substr($submission->reviewedBy->name, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-black text-[#03045E] text-lg leading-tight truncate">{{ $submission->reviewedBy->name }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest">Validator Terverifikasi</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Tip Box --}}
            <div class="p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100">
                <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-[#03045E] mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Informasi Sistem</p>
                <p class="text-xs font-bold text-slate-500 leading-relaxed uppercase tracking-tight opacity-75">
                    Data ini merupakan arsip digital resmi kebudayaan. Pastikan data teknis sesuai dengan hasil verifikasi lapangan sebelum melakukan publikasi massal.
                </p>
            </div>
        </div>
    </div>
    </div>
</x-layouts.super-admin>
