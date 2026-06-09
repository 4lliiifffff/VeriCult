<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $submission->name }} - VeriCult</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        .hero-gradient-overlay {
            background: linear-gradient(to bottom, transparent 0%, rgba(15, 23, 42, 0.4) 60%, rgba(15, 23, 42, 0.8) 100%);
        }
        .reveal {
            opacity: 0;
            transition: opacity 0.8s cubic-bezier(0.2, 0, 0.2, 1), transform 0.8s cubic-bezier(0.2, 0, 0.2, 1);
            will-change: transform, opacity;
        }
        .reveal-up { transform: translateY(30px); }
        .reveal-visible { opacity: 1; transform: translate(0, 0); }
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-shadow:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        }
    </style>
</head>
<body class="antialiased font-sans bg-white text-slate-900 overflow-x-hidden w-full" 
      x-data="{ 
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
        <div x-show="showPreviewModal" 
             x-cloak
             class="fixed inset-0 z-[200] flex items-center justify-center p-4 sm:p-10"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            <div class="absolute inset-0 bg-slate-900/95 backdrop-blur-md" @click="closePreview()"></div>
            
            <div class="relative w-full max-w-5xl max-h-full flex flex-col items-center"
                 x-transition:enter="transition ease-out duration-300 delay-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                
                <div class="absolute -top-12 left-0 right-0 flex items-center justify-between text-white">
                    <p class="text-sm font-bold truncate max-w-xs" x-text="previewFile?.name"></p>
                    <button @click="closePreview()" class="p-2 hover:bg-white/10 rounded-full transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="w-full bg-black rounded-2xl overflow-hidden shadow-2xl flex items-center justify-center">
                    <template x-if="previewFile?.type === 'image'">
                        <img :src="previewFile?.url" class="max-w-full max-h-[80vh] object-contain">
                    </template>
                    <template x-if="previewFile?.type === 'video'">
                        <video :src="previewFile?.url" controls class="max-w-full max-h-[80vh]"></video>
                    </template>
                </div>
            </div>
        </div>
    </template>
    
    <!-- Navbar -->
    <x-public-navbar />

    <!-- Hero Section -->
    <section class="relative min-h-[70vh] flex items-end overflow-hidden bg-slate-50 pt-32 pb-16">
        @php 
            $mainImage = $submission->files->first(function($file) {
                return in_array(strtolower($file->file_type), ['image', 'jpg', 'jpeg', 'png', 'webp']);
            }); 
            $mainVideo = !$mainImage ? $submission->files->first(function($file) {
                return strtolower($file->file_type) === 'video';
            }) : null;
        @endphp
        
        @if($mainImage)
            <img src="{{ $mainImage->url }}" alt="{{ $submission->name }}" class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-multiply">
        @elseif($mainVideo)
            <video src="{{ $mainVideo->url }}" autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover opacity-30 mix-blend-multiply"></video>
        @endif
        
        <!-- Light Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-white via-white/90 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-white/60 to-transparent"></div>
        
        <!-- Decorative subtle pattern -->
        <div class="absolute top-0 left-0 w-full h-full bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMyw0LDk0LDAuMDMpIi8+PC9zdmc+')]"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10">
            <div class="max-w-4xl reveal reveal-up">
                <div class="flex flex-wrap items-center gap-3 mb-6">
                    <span class="px-4 py-1.5 bg-[#00B4D8]/10 text-[#0077B6] border border-[#00B4D8]/20 text-[10px] font-black uppercase tracking-widest rounded-xl backdrop-blur-md shadow-sm">
                        {{ $submission->category }}
                    </span>
                    <span class="px-4 py-1.5 bg-[#03045E] text-white border border-[#03045E]/20 text-[10px] font-black uppercase tracking-widest rounded-xl shadow-md shadow-blue-900/20 flex items-center gap-2">
                        <svg class="w-3 h-3 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        Terverifikasi
                    </span>
                    <span class="px-4 py-1.5 bg-white border border-slate-200 text-slate-500 text-[10px] font-black uppercase tracking-widest rounded-xl shadow-sm">
                        SUB-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
                
                <h1 class="text-3xl sm:text-4xl md:text-6xl lg:text-7xl font-black text-[#03045E] mb-8 tracking-tight leading-[1.1] drop-shadow-sm break-words">
                    {{ $submission->name }}
                </h1>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 bg-white/80 backdrop-blur-xl border border-white shadow-xl shadow-slate-200/50 p-4 sm:p-6 rounded-3xl sm:rounded-[2rem] w-full sm:w-auto sm:inline-flex">
                    <div class="flex items-center gap-4 flex-1 min-w-0">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-[#0077B6]/10 flex items-center justify-center text-[#0077B6] shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[8px] sm:text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-0.5">Lokasi</p>
                            <p class="text-xs sm:text-sm font-bold text-slate-700 truncate" title="{{ $submission->address }}">{{ $submission->address }}</p>
                        </div>
                    </div>
                    <div class="hidden sm:block w-px h-10 bg-slate-200"></div>
                    <div class="flex items-center gap-4 shrink-0">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-[#0077B6]/10 flex items-center justify-center text-[#0077B6] shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[8px] sm:text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-0.5">Tanggal Publikasi</p>
                            <p class="text-xs sm:text-sm font-bold text-slate-700">{{ ($submission->published_at ?? $submission->created_at)->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-16">
                
                <!-- Main Content -->
                <div class="lg:col-span-8 space-y-10 min-w-0">
                    
                    <div class="bg-white rounded-[2rem] sm:rounded-[3rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-6 sm:p-14 reveal reveal-up">
                        <!-- Description -->
                        <div class="space-y-6">
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] flex items-center gap-4">
                                <span class="shrink-0">Narasi Kebudayaan</span>
                                <div class="flex-1 h-px bg-slate-100"></div>
                            </h3>
                            <div class="p-5 sm:p-10 rounded-[1.5rem] sm:rounded-[2.5rem] bg-indigo-50/10 border border-indigo-100/30 overflow-hidden">
                                <div class="prose prose-slate max-w-none w-full break-words">
                                    <p class="text-slate-700 leading-relaxed sm:leading-[2] font-medium text-sm sm:text-lg italic">
                                        "{{ $submission->description }}"
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if(!empty($submission->category_data))
                        <div class="space-y-6 mt-14">
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] flex items-center gap-4">
                                <span class="shrink-0">Detail {{ $submission->category }}</span>
                                <div class="flex-1 h-px bg-slate-100"></div>
                            </h3>
                            <div class="bg-gradient-to-br from-slate-50/50 to-blue-50/30 rounded-[1.5rem] sm:rounded-[2.5rem] p-6 sm:p-10 border border-slate-100">
                                @php
                                    $subCat = $submission->category_data[array_keys(array_filter($submission->category_data, fn($k) => str_starts_with($k, 'sub_kategori'), ARRAY_FILTER_USE_KEY))[0] ?? ''] ?? null;
                                    $flatFields = \App\Models\CulturalSubmission::getFlatCategoryFields($submission->category, $subCat);
                                @endphp
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 sm:gap-10">
                                    @php
                                        $processedKeys = [];
                                    @endphp
                                    @foreach($submission->category_data as $dataKey => $dataValue)
                                        @if(!empty($dataValue) && $dataKey !== 'unesco_categories' && !str_starts_with($dataKey, 'sub_kategori') && !in_array($dataKey, $processedKeys))
                                            @php
                                                $fieldDef = $flatFields[$dataKey] ?? null;
                                                if (!$fieldDef) continue;

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

                                                if ($dataValue === 'Lainnya') {
                                                    $otherKey = $dataKey . '_lainnya';
                                                    if (!empty($submission->category_data[$otherKey])) {
                                                        $displayValue = $submission->category_data[$otherKey];
                                                        $processedKeys[] = $otherKey;
                                                    }
                                                }

                                                if (str_contains(strtolower($displayLabel), 'nama pencipta')) {
                                                    $displayLabel = 'Penulis / Pencipta';
                                                }

                                                $isWide = ($fieldDef['type'] ?? '') === 'textarea' || is_array($dataValue);
                                            @endphp

                                            <div class="space-y-2 {{ $isWide ? 'sm:col-span-2' : '' }} min-w-0">
                                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ $displayLabel }}</p>
                                                
                                                @if(is_array($displayValue))
                                                    @if(isset($displayValue[0]) && is_array($displayValue[0]))
                                                        <div class="bg-white rounded-[1.5rem] border border-slate-100 overflow-hidden shadow-sm mt-3">
                                                            <div class="overflow-x-auto">
                                                                <table class="w-full text-left text-sm min-w-max responsive-table">
                                                                    <thead class="bg-slate-50 border-b border-slate-100 text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                                                        <tr>
                                                                            @foreach(array_keys($displayValue[0]) as $colKey)
                                                                                <th class="px-4 sm:px-6 py-3 sm:py-4">{{ str_replace('_', ' ', $colKey) }}</th>
                                                                            @endforeach
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="divide-y divide-slate-50 text-slate-600 font-medium text-xs sm:text-sm">
                                                                        @foreach($displayValue as $row)
                                                                            <tr class="hover:bg-slate-50/50 transition-colors">
                                                                                @foreach($row as $cell)
                                                                                    <td class="px-4 sm:px-6 py-3 sm:py-4">{{ is_array($cell) ? implode(', ', $cell) : $cell }}</td>
                                                                                @endforeach
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="flex flex-wrap gap-2 mt-2">
                                                            @foreach($displayValue as $item)
                                                                <span class="px-4 py-2 bg-white border border-blue-100 shadow-sm shadow-blue-500/5 rounded-xl text-xs font-bold text-[#0077B6]">
                                                                    {{ is_array($item) ? implode(', ', $item) : $item }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @else
                                                    <p class="text-slate-700 break-words font-{{ ($fieldDef['type'] ?? '') === 'textarea' ? 'medium text-base leading-relaxed whitespace-pre-wrap' : 'black text-lg' }}">
                                                        {{ is_array($displayValue) ? implode(', ', $displayValue) : $displayValue }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- UNESCO Categories --}}
                                @if(!empty($submission->category_data['unesco_categories']))
                                    <div class="mt-10 pt-8 border-t border-slate-100">
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Kategori UNESCO</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($submission->category_data['unesco_categories'] as $unescoCat)
                                                <span class="px-4 py-2 bg-[#03045E]/5 text-[#03045E] rounded-xl text-xs font-bold border border-[#03045E]/10">{{ $unescoCat }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Data Dukung URLs --}}
                                @if(!empty($submission->category_data['video_url']) || !empty($submission->category_data['dokumen_kajian_url']) || !empty($submission->category_data['dokumen_lainnya_url']))
                                    <div class="mt-8 pt-8 border-t border-slate-100 space-y-4">
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tautan Pendukung Eksternal</p>
                                        @foreach(['video_url' => 'Video', 'dokumen_kajian_url' => 'Dokumen Kajian', 'dokumen_lainnya_url' => 'Dokumen Lainnya'] as $urlKey => $urlLabel)
                                            @if(!empty($submission->category_data[$urlKey]))
                                                <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 w-full min-w-0">
                                                    <span class="text-[11px] font-black uppercase tracking-widest text-slate-500 w-full sm:w-36 shrink-0">{{ $urlLabel }}:</span>
                                                    <div class="flex-1 min-w-0 w-full">
                                                        <a href="{{ $submission->category_data[$urlKey] }}" target="_blank" class="text-sm text-[#0077B6] font-medium hover:underline truncate block">{{ $submission->category_data[$urlKey] }}</a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-4 space-y-8 min-w-0">
                    <!-- Verification Badge -->
                    <div class="bg-gradient-to-br from-[#03045E] to-[#0077B6] rounded-[2rem] sm:rounded-[2.5rem] p-8 sm:p-10 text-white relative overflow-hidden shadow-2xl shadow-blue-900/20 group reveal reveal-up">
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4xKSIvPjwvc3ZnPg==')] opacity-50"></div>
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-[#00B4D8]/30 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <div class="relative z-10">
                            <div class="w-14 h-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center mb-8 border border-white/20 shadow-inner">
                                <svg class="w-7 h-7 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </div>
                            <h4 class="text-2xl font-black mb-3 tracking-tight">Terverifikasi Resmi</h4>
                            <p class="text-blue-100 text-sm leading-relaxed mb-8 font-medium">
                                Data warisan budaya ini telah melalui proses verifikasi berjenjang dan dijamin keasliannya oleh sistem VeriCult.
                            </p>
                            <div class="flex items-center gap-4 pt-6 border-t border-white/10">
                                <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center text-xs font-black border border-white/20 shadow-sm">VC</div>
                                <div>
                                    <p class="text-[10px] font-black text-blue-200 uppercase tracking-widest mb-0.5">Otoritas Validasi</p>
                                    <p class="text-sm font-bold">Tim Kurator VeriCult</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Media Gallery -->
                    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-8 reveal reveal-up" style="transition-delay: 100ms;">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] flex items-center gap-4">
                                <span class="shrink-0">Galeri Media</span>
                            </h3>
                            <span class="px-3 py-1 rounded-lg bg-[#03045E] text-white text-[10px] font-black tracking-widest">{{ $submission->files->count() }} BERKAS</span>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-4">
                            @forelse($submission->files as $file)
                                @php
                                    $isImage = in_array(strtolower($file->file_type), ['image', 'jpg', 'jpeg', 'png', 'webp']);
                                    $isVideo = in_array(strtolower($file->file_type), ['video', 'mp4', 'mov', 'webm']);
                                @endphp
                                <div class="group/file relative flex flex-col p-4 bg-white border border-slate-100 rounded-[2rem] shadow-sm hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/50 hover:border-[#0077B6]/30 transition-all duration-300 overflow-hidden">
                                    <!-- Preview Area -->
                                    <div class="relative w-full h-44 rounded-[1.5rem] overflow-hidden bg-slate-50 flex items-center justify-center shrink-0 mb-4 border border-slate-50/50 shadow-inner">
                                        @if($isImage)
                                            <img src="{{ $file->url }}" alt="{{ $file->original_name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover/file:scale-110">
                                            <div class="absolute inset-0 bg-black/0 group-hover/file:bg-black/20 transition-colors flex items-center justify-center opacity-0 group-hover/file:opacity-100">
                                                <button type="button" @click="openPreview('{{ $file->url }}', 'image', '{{ $file->original_name }}')"
                                                    class="w-12 h-12 rounded-2xl bg-white text-[#03045E] shadow-xl flex items-center justify-center hover:scale-110 transition-transform active:scale-95">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </button>
                                            </div>
                                        @elseif($isVideo)
                                            <video src="{{ $file->url }}" @loadedmetadata="$el.currentTime = 0.1;" class="w-full h-full object-cover transition-transform duration-700 group-hover/file:scale-110" preload="metadata" muted playsinline></video>
                                            <div class="absolute inset-0 bg-black/20 group-hover/file:bg-black/40 transition-colors flex items-center justify-center">
                                                <button type="button" @click="openPreview('{{ $file->url }}', 'video', '{{ $file->original_name }}')"
                                                    class="w-14 h-14 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center group-hover/file:scale-110 transition-transform border border-white/30">
                                                    <svg class="w-6 h-6 text-white translate-x-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                                </button>
                                            </div>
                                        @else
                                            <div class="flex flex-col items-center gap-2 text-slate-300">
                                                <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <span class="text-[10px] font-black uppercase tracking-widest">{{ strtoupper($file->file_type) }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- File Info -->
                                    <div class="flex flex-col mb-4">
                                        <h4 class="text-sm font-black text-[#03045E] truncate mb-1">{{ $file->original_name }}</h4>
                                        <span class="text-[10px] font-black text-[#00B4D8] uppercase tracking-widest">{{ strtoupper($file->file_type) }}</span>
                                    </div>

                                    <!-- Actions -->
                                    <a href="{{ $file->url }}" target="_blank"
                                        class="flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-50 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#03045E] hover:text-white transition-all border border-slate-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Unduh
                                    </a>
                                </div>
                            @empty
                                <div class="py-16 text-center bg-slate-50 rounded-[1.5rem] border-2 border-dashed border-slate-200 group">
                                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-300 shadow-sm group-hover:scale-110 transition-transform">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Belum ada media</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('partials.footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('reveal-visible'); obs.unobserve(entry.target); } });
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
