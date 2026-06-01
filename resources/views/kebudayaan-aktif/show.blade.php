<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $post->name }} - Kebudayaan Aktif · VeriCult</title>
    <meta name="description" content="{{ Str::limit($post->description, 160) }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .card-hover { transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -12px rgba(3, 4, 94, 0.12); }
        .gallery-img { cursor: zoom-in; transition: transform 0.4s ease; }
        .gallery-img:hover { transform: scale(1.02); }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-900" x-data="{ 
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

    <x-public-navbar />

    @php
        $images = $post->files->filter(fn($f) => $f->file_type === 'image');
        $docs   = $post->files->filter(fn($f) => $f->file_type === 'document');
        $videos = $post->files->filter(fn($f) => $f->file_type === 'video');
        $coverImage = $images->first();
    @endphp

    {{-- Hero / Cover --}}
    <section class="relative min-h-[40vh] sm:min-h-[50vh] flex items-end overflow-hidden bg-slate-50 pt-24 sm:pt-32 pb-10 sm:pb-16">
        @if($coverImage)
            <img src="{{ $coverImage->url }}" alt="{{ $post->name }}"
                 class="absolute inset-0 w-full h-full object-cover opacity-25 mix-blend-multiply">
        @endif

        {{-- Light gradient overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-white via-white/90 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-white/60 to-transparent"></div>

        {{-- Subtle dot pattern --}}
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMyw0LDk0LDAuMDMpIi8+PC9zdmc+')]"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 sm:gap-2 text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 sm:mb-6 flex-wrap">
                <a href="{{ route('beranda') }}" class="hover:text-[#0077B6] transition-colors">Beranda</a>
                <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('kebudayaan-aktif.index') }}" class="hover:text-[#0077B6] transition-colors">Budaya Aktif</a>
                <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-500 truncate max-w-[150px] sm:max-w-[200px]">{{ $post->name }}</span>
            </nav>

            {{-- Badges --}}
            <div class="flex flex-wrap items-center gap-2 mb-3 sm:mb-4">
                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl px-3 py-1 sm:px-4 sm:py-1.5 text-[9px] sm:text-[10px] font-black uppercase tracking-widest">
                    <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span></span>
                    Aktif Terverifikasi
                </span>
                <span class="bg-blue-50 text-[#0077B6] border border-blue-100 rounded-xl px-3 py-1 sm:px-4 sm:py-1.5 text-[9px] sm:text-[10px] font-black uppercase tracking-widest">
                    Kebudayaan Aktif
                </span>
            </div>

            {{-- Title --}}
            <h1 class="text-2xl sm:text-3xl md:text-5xl font-black text-[#03045E] tracking-tight leading-tight">
                {{ $post->name }}
            </h1>
        </div>
    </section>

    {{-- Main Content --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 -mt-4 relative z-10">

        {{-- Main Post Card --}}
        <div class="bg-white rounded-[1.5rem] sm:rounded-[2.5rem] shadow-2xl shadow-slate-200/80 border border-slate-100 overflow-hidden mb-8">

            {{-- Post Header --}}
            <div class="p-4 sm:p-8 md:p-10 border-b border-slate-100">
                {{-- Author & Meta --}}
                <div class="flex flex-wrap items-center gap-3 sm:gap-6 text-sm text-slate-500 font-medium">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-[#03045E] to-[#0077B6] flex items-center justify-center text-white text-xs font-black shrink-0">
                            {{ strtoupper(substr($post->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-slate-700">{{ $post->user->name ?? 'Pengusul' }}</p>
                            <p class="text-[10px] text-slate-400">Pengusul</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 text-[11px] sm:text-[12px]">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-slate-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $post->published_at?->translatedFormat('d F Y') }}
                    </div>
                    @if($post->village)
                    <div class="flex items-center gap-1.5 text-[11px] sm:text-[12px]">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-slate-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        {{ $post->village->name }}{{ $post->village->kecamatan ? ', ' . $post->village->kecamatan->name : '' }}
                    </div>
                    @elseif($post->address)
                    <div class="flex items-center gap-1.5 text-[11px] sm:text-[12px]">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-slate-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        {{ $post->address }}
                    </div>
                    @endif

                    {{-- Share button --}}
                    <button onclick="copyLink()"
                            class="sm:ml-auto flex items-center gap-1.5 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-[#0077B6] transition-colors group">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                        <span id="share-label">Bagikan</span>
                    </button>
                </div>
            </div>

            {{-- Description --}}
            @if($post->description)
            <div class="p-4 sm:p-8 md:p-10 border-b border-slate-100">
                <h2 class="text-[10px] sm:text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 sm:mb-4">Deskripsi</h2>
                <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed text-sm sm:text-[15px] font-medium">
                    {!! nl2br(e($post->description)) !!}
                </div>
            </div>
            @endif

            {{-- Category Data Fields --}}
            @if(!empty($post->category_data) && count($categoryFields) > 0)
            <div class="p-4 sm:p-8 md:p-10 border-b border-slate-100">
                <h2 class="text-[10px] sm:text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 sm:mb-6">Informasi Detail</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-5">
                    @foreach($categoryFields as $key => $field)
                    @php
                        $value = $post->category_data[$key] ?? null;
                        if (is_array($value)) $value = implode(', ', array_filter($value));
                        $label = $field['label'] ?? ucwords(str_replace('_', ' ', $key));
                    @endphp
                    @if(!empty($value))
                    <div class="bg-slate-50 rounded-xl sm:rounded-[1.25rem] p-3 sm:p-5 border border-slate-100">
                        <p class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] mb-1.5 sm:mb-2">{{ $label }}</p>
                        <p class="text-xs sm:text-sm font-semibold text-slate-700 leading-relaxed">{{ $value }}</p>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Image Gallery --}}
            @if($images->count() > 0)
            <div class="p-4 sm:p-8 md:p-10 border-b border-slate-100">
                <h2 class="text-[10px] sm:text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 sm:mb-6">
                    Galeri Foto <span class="text-[#0077B6]">({{ $images->count() }})</span>
                </h2>
                <div class="grid grid-cols-2 {{ $images->count() > 2 ? 'sm:grid-cols-3' : '' }} gap-2 sm:gap-4">
                    @foreach($images as $img)
                    <a href="{{ $img->url }}" @click.prevent="openPreview('{{ $img->url }}', 'image', '{{ addslashes($img->original_name) }}', '{{ $img->file_size_human }}')" class="relative overflow-hidden rounded-xl sm:rounded-2xl aspect-square bg-slate-100 block">
                        <img src="{{ $img->url }}" alt="{{ $img->original_name }}"
                             class="w-full h-full object-cover gallery-img">
                        <div class="absolute inset-0 bg-black/0 hover:bg-black/20 transition-colors flex items-center justify-center">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white opacity-0 hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Video Files --}}
            @if($videos->count() > 0)
            <div class="p-4 sm:p-8 md:p-10 border-b border-slate-100">
                <h2 class="text-[10px] sm:text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 sm:mb-6">
                    Video <span class="text-[#0077B6]">({{ $videos->count() }})</span>
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 {{ $videos->count() > 2 ? 'sm:grid-cols-3' : '' }} gap-3 sm:gap-4">
                    @foreach($videos as $vid)
                    <button type="button"
                        @click="openPreview('{{ $vid->url }}', 'video', '{{ addslashes($vid->original_name) }}', '{{ $vid->file_size_human }}')"
                        class="group relative overflow-hidden rounded-xl sm:rounded-2xl aspect-video bg-slate-900 block w-full focus:outline-none">
                        <video src="{{ $vid->url }}" class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-500" muted playsinline preload="metadata"></video>
                        <div class="absolute inset-0 bg-black/30 group-hover:bg-black/50 transition-colors flex flex-col items-center justify-center gap-1.5 sm:gap-2">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white translate-x-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                            </div>
                            <p class="text-white text-[9px] sm:text-[10px] font-black uppercase tracking-widest truncate max-w-[90%] px-2">{{ $vid->original_name }}</p>
                        </div>
                    </button>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Document Files --}}
            @if($docs->count() > 0)
            <div class="p-4 sm:p-8 md:p-10 border-b border-slate-100">
                <h2 class="text-[10px] sm:text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 sm:mb-6">
                    Dokumen Pendukung <span class="text-[#0077B6]">({{ $docs->count() }})</span>
                </h2>
                <div class="space-y-2 sm:space-y-3">
                    @foreach($docs as $doc)
                    <div class="flex items-center gap-3 sm:gap-4 bg-slate-50 rounded-xl sm:rounded-2xl p-3 sm:p-4 border border-slate-100">
                        <div class="w-9 h-9 sm:w-11 sm:h-11 bg-blue-50 rounded-lg sm:rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-bold text-slate-700 truncate">{{ $doc->original_name }}</p>
                            <p class="text-[9px] sm:text-[10px] text-slate-400 font-medium">{{ $doc->file_size_human }}</p>
                        </div>
                        <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                            @if(strtolower(pathinfo($doc->original_name, PATHINFO_EXTENSION)) === 'pdf')
                            <button type="button" @click="openPreview('{{ $doc->url }}', 'pdf', '{{ addslashes($doc->original_name) }}', '{{ $doc->file_size_human }}')"
                                    class="text-[9px] sm:text-[10px] font-black text-[#0077B6] uppercase tracking-widest hover:text-[#03045E] transition-colors flex items-center gap-1 sm:gap-1.5 bg-blue-50 hover:bg-blue-100/80 px-2.5 py-1.5 sm:px-3.5 sm:py-2 rounded-lg sm:rounded-xl border border-blue-200/50">
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Lihat
                            </button>
                            @endif
                            <a href="{{ $doc->url }}" target="_blank"
                               class="text-[9px] sm:text-[10px] font-black text-slate-500 uppercase tracking-widest hover:text-slate-700 transition-colors flex items-center gap-1 sm:gap-1.5 bg-slate-100 hover:bg-slate-200/80 px-2.5 py-1.5 sm:px-3.5 sm:py-2 rounded-lg sm:rounded-xl border border-slate-200/50">
                                Unduh
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Post Footer --}}
            <div class="p-4 sm:p-8 md:p-10 bg-slate-50/50 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 sm:gap-4">
                <a href="{{ route('kebudayaan-aktif.index') }}"
                   class="inline-flex items-center justify-center sm:justify-start gap-2 text-[10px] sm:text-[11px] font-black text-slate-500 uppercase tracking-widest hover:text-[#03045E] transition-colors py-2 sm:py-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    Kembali ke Feed
                </a>
                <a href="{{ route('profil-kebudayaan.show', $post->slug) }}"
                   class="inline-flex items-center justify-center gap-2 bg-[#03045E] text-white rounded-xl px-5 py-3 sm:px-6 text-[10px] sm:text-[11px] font-black uppercase tracking-widest hover:bg-[#0077B6] transition-all active:scale-95">
                    Lihat Profil Lengkap
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        {{-- Related Posts --}}
        @if($related->count() > 0)
        <div class="mt-8 sm:mt-0">
            <h2 class="text-lg sm:text-xl font-black text-[#03045E] tracking-tight mb-4 sm:mb-6">Kebudayaan Aktif Lainnya</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                @foreach($related as $rel)
                @php 
                    $relImage = $rel->files->first(fn($f) => $f->file_type === 'image');
                    $relVideo = $rel->files->first(fn($f) => $f->file_type === 'video');
                @endphp
                <a href="{{ route('kebudayaan-aktif.show', $rel->slug) }}"
                   class="group bg-white rounded-[1.5rem] overflow-hidden border border-slate-100 shadow-md card-hover flex flex-col">
                    <div class="aspect-video relative overflow-hidden bg-gradient-to-br from-[#03045E] to-[#0077B6]">
                        @if($relImage)
                            <img src="{{ $relImage->url }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-black/20"></div>
                        @elseif($relVideo)
                            <video src="{{ $relVideo->url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" muted playsinline preload="metadata"></video>
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white border border-white/30 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            </div>
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="text-[13px] font-black text-[#03045E] leading-tight line-clamp-2 group-hover:text-[#0077B6] transition-colors mb-2">{{ $rel->name }}</h3>
                        <p class="text-[11px] text-slate-400 font-medium mt-auto">{{ $rel->published_at?->translatedFormat('d M Y') }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Fullscreen Preview Modal -->
    <template x-teleport="body">
        <div class="fixed inset-0 z-[110] flex items-center justify-center p-4 sm:p-6" x-show="showPreviewModal" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <div class="absolute inset-0 bg-slate-900/80" @click="closePreview()"></div>
            <div class="relative w-full max-w-6xl max-h-full bg-slate-900 rounded-[1.5rem] sm:rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/10 flex flex-col">
                <!-- Modal Header -->
                <div class="p-4 sm:p-6 md:p-8 flex items-center justify-between border-b border-white/5 bg-slate-900/50 backdrop-blur-md">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-white/5 flex items-center justify-center text-[#00B4D8] shrink-0">
                            <template x-if="previewFile?.type === 'image'">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </template>
                            <template x-if="previewFile?.type === 'video'">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </template>
                            <template x-if="previewFile?.type === 'pdf'">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </template>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-white font-black text-sm sm:text-base md:text-lg tracking-tight truncate max-w-[200px] sm:max-w-xs md:max-w-md" x-text="previewFile?.name"></h3>
                            <p class="text-white/40 text-[9px] sm:text-[10px] font-black uppercase tracking-[0.2em]" x-text="previewFile?.size"></p>
                        </div>
                    </div>
                    <button type="button" @click="closePreview()" class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-white/5 text-white/50 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all group shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Content Container -->
                <div class="w-full bg-black/20 rounded-[1.5rem] sm:rounded-[2.5rem] border border-white/10 overflow-hidden shadow-2xl flex items-center justify-center relative group/inner min-h-[300px]">
                    <template x-if="previewFile?.type === 'image'">
                        <img :src="previewFile?.url" class="max-w-full max-h-[70vh] object-contain select-none">
                    </template>
                    <template x-if="previewFile?.type === 'video'">
                        <video :src="previewFile?.url" controls autoplay class="max-w-full max-h-[70vh]"></video>
                    </template>
                    <template x-if="previewFile?.type === 'pdf'">
                        <iframe :src="previewFile?.url" class="w-full h-[70vh] border-0 bg-white"></iframe>
                    </template>
                    
                    <!-- Floating Download Link -->
                    <a :href="previewFile?.url" target="_blank" class="absolute bottom-4 right-4 sm:bottom-8 sm:right-8 px-4 py-2.5 sm:px-6 sm:py-3 bg-white text-[#03045E] rounded-xl font-black text-[9px] sm:text-[10px] uppercase tracking-widest shadow-xl hover:bg-[#00B4D8] hover:text-white transition-all opacity-0 group-hover/inner:opacity-100 translate-y-4 group-hover/inner:translate-y-0 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Unduh Berkas
                    </a>
                </div>
            </div>
        </div>
    </template>

    @include('partials.footer')

    <script>
        function copyLink() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                const label = document.getElementById('share-label');
                label.textContent = 'Tersalin!';
                setTimeout(() => label.textContent = 'Bagikan', 2000);
            });
        }
    </script>
</body>
</html>
