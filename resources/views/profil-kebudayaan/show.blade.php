<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-clip">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $submission->name }} - VeriCult</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * { box-sizing: border-box; }
        [x-cloak] { display: none !important; }
        
        .premium-gradient {
            background: linear-gradient(135deg, #03045E 0%, #023E8A 50%, #0077B6 100%);
        }
        
        .premium-glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .hero-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        @keyframes revealUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .reveal {
            animation: revealUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #F1F5F9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #0077B6; border-radius: 10px; }
    </style>
</head>
<body class="antialiased font-sans custom-scrollbar bg-[#F8FAFC] text-slate-900 overflow-x-hidden">
    
    <!-- Navbar -->
    <x-public-navbar />

    <!-- Hero Content -->
    <div class="relative h-[60vh] lg:h-[85vh] flex items-end overflow-hidden">
        @php 
            $mainImage = $submission->files->first(function($file) {
                return in_array(strtolower($file->file_type), ['image', 'jpg', 'jpeg', 'png', 'webp']);
            }); 
        @endphp
        
        <div class="absolute inset-0 z-0">
            @if($mainImage)
                <img src="{{ $mainImage->url }}" alt="{{ $submission->name }}" class="w-full h-full object-cover scale-105" x-ref="heroImg">
            @else
                <div class="w-full h-full premium-gradient"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-[#F1F5F9] via-[#03045E]/60 to-[#03045E]/30 lg:via-[#03045E]/40 lg:to-transparent"></div>
            <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-[#F1F5F9] to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10 pb-8 lg:pb-24">
            <div class="max-w-4xl reveal">
                <div class="flex flex-wrap items-center gap-3 mb-6">
                    <span class="px-5 py-2 bg-[#00B4D8] text-white text-[9px] font-bold uppercase tracking-[0.2em] rounded-full shadow-lg shadow-blue-500/20">
                        {{ $submission->category }}
                    </span>
                    <span class="px-5 py-2 bg-white/10 backdrop-blur-md text-white text-[9px] font-bold uppercase tracking-[0.2em] rounded-full border border-white/20">
                        VeriCult Certified
                    </span>
                </div>
                
                <h1 class="text-2xl sm:text-6xl lg:text-7xl font-bold text-white leading-[1.2] lg:leading-[1.1] tracking-tight mb-10 lg:mb-8 capitalize break-all sm:break-words max-w-full">
                    {{ $submission->name }}
                </h1>

                <div class="grid grid-cols-1 sm:flex sm:flex-wrap items-center gap-6 lg:gap-12 min-w-0">
                    <div class="flex items-center gap-4 group min-w-0">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/10 group-hover:bg-[#00B4D8] transition-all duration-300">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold text-white/50 uppercase tracking-widest mb-0.5">Lokasi</p>
                            <p class="text-xs sm:text-sm font-semibold text-white uppercase tracking-wider break-all sm:break-words">{{ $submission->address }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 group min-w-0">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/10 group-hover:bg-[#00B4D8] transition-all duration-300">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold text-white/50 uppercase tracking-widest mb-0.5">Tgl Publikasi</p>
                            <p class="text-xs sm:text-sm font-semibold text-white uppercase tracking-wider truncate">{{ ($submission->published_at ?? $submission->created_at)->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-10 hidden lg:block animate-bounce opacity-50">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7-7-7"></path></svg>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-10 lg:py-24 relative z-20 overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 items-start">
            
            <!-- Left Info Column -->
            <div class="lg:col-span-2 space-y-12 sm:space-y-20">
                
                <!-- Narasi Section -->
                <div class="reveal">
                    <div class="flex items-center gap-6 mb-10 sm:mb-16">
                        <div class="flex-1 h-px bg-slate-200"></div>
                        <h2 class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-widest sm:tracking-[0.4em] text-center">Deskripsi Warisan</h2>
                        <div class="flex-1 h-px bg-slate-200"></div>
                    </div>
                    
                    <div class="relative">
                        <div class="absolute left-4 sm:-left-12 top-0 text-7xl sm:text-8xl font-bold text-slate-100 leading-none pointer-events-none opacity-50 sm:opacity-100">"</div>
                        <p class="text-slate-500 text-sm sm:text-lg lg:text-xl leading-[1.8] font-medium italic break-all sm:break-words relative z-10 px-4 sm:px-2 w-full">
                            {{ $submission->description }}.
                        </p>
                    </div>
                </div>

                <!-- Detail Kategori Section -->
                @if(!empty($submission->category_data))
                <div class="bg-white rounded-[2rem] sm:rounded-[3rem] p-6 sm:p-10 lg:p-16 shadow-[0_30px_60px_-15px_rgba(0,0,0,0.05)] border border-slate-100 relative overflow-hidden reveal delay-100">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-[#00B4D8]/5 rounded-full blur-3xl -mr-32 -mt-32"></div>
                    
                    <div class="relative z-10">
                        <h2 class="text-[9px] sm:text-[10px] font-semibold text-[#0077B6] uppercase tracking-wider sm:tracking-[0.2em] mb-10 flex items-center gap-2 sm:gap-4">
                            Data Teknis {{ $submission->category }}
                            <div class="flex-1 max-w-[40px] h-0.5 bg-[#00B4D8]/30"></div>
                        </h2>
                        
                        @php
                            $subCat = $submission->category_data[array_keys(array_filter($submission->category_data, fn($k) => str_starts_with($k, 'sub_kategori'), ARRAY_FILTER_USE_KEY))[0] ?? ''] ?? null;
                            $flatFields = \App\Models\CulturalSubmission::getFlatCategoryFields($submission->category, $subCat);
                        @endphp
                        
                        <div class="grid grid-cols-1 gap-y-10 sm:gap-y-16">
                            @php
                                $processedKeys = [];
                            @endphp
                            @foreach($submission->category_data as $dataKey => $dataValue)
                                @if(!empty($dataValue) && $dataKey !== 'unesco_categories' && !str_starts_with($dataKey, 'sub_kategori') && !in_array($dataKey, $processedKeys))
                                    @php
                                        $fieldDef = $flatFields[$dataKey] ?? null;
                                        if (!$fieldDef) continue;

                                        // Skip conditional check fields (Ya/Tidak) if the actual data field exists and is filled
                                        if (($fieldDef['type'] ?? '') === 'radio' && in_array($dataValue, ['Ya', 'Tidak'])) {
                                            // Look ahead to see if there's a dependent field that is filled
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

                                        // Special cleanup for Pencipta labels
                                        if (str_contains(strtolower($displayLabel), 'pencipta manuskrip')) {
                                            $displayLabel = 'Penulis / Pencipta Manuskrip';
                                        }

                                        $isWide = ($fieldDef['type'] ?? '') === 'textarea' || is_array($dataValue);
                                    @endphp
                                    <div class="space-y-4">
                                        <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-[0.2em] mb-1">{{ $displayLabel }}</p>
                                        
                                        @if(is_array($displayValue))
                                            @if(isset($displayValue[0]) && is_array($displayValue[0]))
                                                {{-- Dynamic table data --}}
                                                <div class="bg-slate-50 rounded-[2rem] border border-slate-100 overflow-hidden">
                                                    <div class="overflow-x-auto custom-scrollbar">
                                                        <table class="w-full text-left">
                                                            <thead>
                                                                     <tr class="bg-slate-100/50">
                                                                    @foreach(array_keys($displayValue[0]) as $colKey)
                                                                        <th class="px-3 sm:px-6 py-4 text-[9px] font-bold text-slate-500 uppercase tracking-widest">{{ str_replace('_', ' ', $colKey) }}</th>
                                                                    @endforeach
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-slate-100">
                                                                @foreach($displayValue as $row)
                                                                    <tr class="hover:bg-white transition-colors">
                                                                        @foreach($row as $cellValue)
                                                                            <td class="px-3 sm:px-6 py-4 text-xs sm:text-sm font-semibold text-slate-600 break-words">{{ $cellValue }}</td>
                                                                        @endforeach
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @else
                                                {{-- Checkbox/List array --}}
                                                <div class="flex flex-wrap gap-3">
                                                    @foreach($displayValue as $item)
                                                        <span class="px-5 py-3 bg-slate-50 text-[#03045E] rounded-2xl text-xs font-semibold border border-slate-200/40 hover:bg-white hover:shadow-md transition-all cursor-default">
                                                            {{ $item }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @else
                                            @php $isLongText = strlen($displayValue) > 50 || ($fieldDef['type'] ?? '') === 'textarea'; @endphp
                                            <p class="text-{{ $isLongText ? 'slate-500 font-medium italic text-sm leading-relaxed' : '[#03045E] font-semibold text-base lg:text-xl tracking-tight' }} break-all sm:break-words">
                                                {{ $displayValue }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        {{-- UNESCO & Special Metadata --}}
                        @if(!empty($submission->category_data['unesco_categories']))
                            <div class="mt-16 pt-12 border-t border-slate-100">
                                <div class="flex flex-wrap items-center gap-8">
                                    <div>
                                        <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest mb-4">UNESCO Classification</p>
                                        <div class="flex flex-wrap gap-3">
                                            @foreach($submission->category_data['unesco_categories'] as $unescoCat)
                                                <span class="px-5 py-3 bg-[#03045E] text-white rounded-2xl text-[9px] font-semibold uppercase tracking-widest">
                                                    {{ $unescoCat }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- External URLs --}}
                        @php $hasExternals = !empty($submission->category_data['video_url']) || !empty($submission->category_data['dokumen_kajian_url']) || !empty($submission->category_data['dokumen_lainnya_url']); @endphp
                        @if($hasExternals)
                            <div class="mt-16 pt-12 border-t border-slate-100">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-8">Data Dukung Eksternal</p>
                                <div class="grid grid-cols-1 gap-6">
                                    @foreach(['video_url' => 'Dokumentasi Video', 'dokumen_kajian_url' => 'Naskah Kajian', 'dokumen_lainnya_url' => 'Arsip Pendukung'] as $urlKey => $urlLabel)
                                        @if(!empty($submission->category_data[$urlKey]))
                                            <div class="group/url">
                                                <a href="{{ $submission->category_data[$urlKey] }}" target="_blank" 
                                                   class="flex items-center gap-4 sm:gap-6 p-4 sm:p-6 rounded-[1.5rem] sm:rounded-[2rem] bg-slate-50 border border-slate-100 hover:bg-white hover:border-[#00B4D8] hover:shadow-2xl hover:shadow-blue-900/10 transition-all duration-500 overflow-hidden">
                                                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-white flex items-center justify-center text-[#0077B6] shadow-sm group-hover/url:bg-[#0077B6] group-hover/url:text-white transition-all duration-500 shrink-0">
                                                        <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-widest mb-1">{{ $urlLabel }}</p>
                                                        <p class="text-xs sm:text-sm font-medium text-[#03045E] truncate w-full group-hover/url:text-[#0077B6] transition-colors">{{ $submission->category_data[$urlKey] }}</p>
                                                    </div>
                                                </a>
                                                
                                                @if($urlKey === 'video_url')
                                                    @php
                                                        $url = $submission->category_data[$urlKey]; $embedUrl = null;
                                                        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $matches)) { $embedUrl = "https://www.youtube.com/embed/" . $matches[1]; }
                                                        elseif (preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)/i', $url, $matches)) { $embedUrl = "https://player.vimeo.com/video/" . $matches[3]; }
                                                    @endphp
                                                    @if($embedUrl)
                                                        <div class="mt-6 rounded-[2.5rem] overflow-hidden border-4 border-white shadow-2xl aspect-video bg-black reveal delay-200">
                                                            <iframe src="{{ $embedUrl }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Sidebar Column -->
            <div class="lg:col-span-1 space-y-8 lg:space-y-12 reveal delay-200 lg:sticky lg:top-32 self-start">
                <!-- Gallery Section -->
                <div class="bg-white rounded-[2rem] lg:rounded-[3rem] p-6 lg:p-10 shadow-[0_30px_60px_-15px_rgba(0,0,0,0.05)] border border-slate-100">
                    <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-8">Arsip Dokumentasi</h3>
                    
                    <div class="grid grid-cols-2 lg:grid-cols-1 gap-4 sm:gap-6">
                        @forelse($submission->files as $file)
                            @if(in_array(strtolower($file->file_type), ['image', 'jpg', 'jpeg', 'png', 'webp']))
                                <a href="{{ $file->url }}" target="_blank" class="group relative rounded-[2rem] overflow-hidden aspect-[4/3] border border-slate-100 hover:shadow-2xl transition-all duration-500">
                                    <img src="{{ $file->url }}" alt="{{ $file->original_name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#03045E]/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                                        <span class="text-[10px] font-bold text-white uppercase tracking-widest flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Perbesar
                                        </span>
                                    </div>
                                </a>
                            @elseif(in_array(strtolower($file->file_type), ['video', 'mp4', 'mov', 'webm']))
                                <div class="bg-slate-900 rounded-[2rem] overflow-hidden aspect-video relative group border-4 border-slate-100 shadow-xl">
                                    <video controls class="w-full h-full object-contain">
                                        <source src="{{ $file->url }}" type="video/{{ strtolower($file->file_type) === 'video' ? 'mp4' : strtolower($file->file_type) }}">
                                    </video>
                                </div>
                            @elseif(in_array(strtolower($file->file_type), ['audio', 'mp3', 'wav']))
                                <div class="p-6 sm:p-8 bg-slate-50 rounded-[2rem] sm:rounded-[2.5rem] border border-slate-100 group hover:bg-white hover:shadow-xl transition-all duration-500">
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white rounded-xl sm:rounded-2xl flex items-center justify-center text-[#0077B6] mx-auto shadow-sm mb-6 border border-slate-100 group-hover:bg-[#0077B6] group-hover:text-white transition-all">
                                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                                    </div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center mb-6 truncate px-2">{{ $file->original_name }}</p>
                                    <audio controls class="w-full h-10 border-0">
                                        <source src="{{ $file->url }}" type="audio/mpeg">
                                    </audio>
                                </div>
                            @else
                                <a href="{{ $file->url }}" target="_blank" class="flex items-center gap-4 sm:gap-6 p-4 sm:p-6 bg-slate-50 border border-slate-100 rounded-[1.5rem] sm:rounded-[2rem] hover:bg-white hover:shadow-xl hover:border-[#00B4D8] group/doc transition-all duration-500 overflow-hidden">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white rounded-xl sm:rounded-2xl flex items-center justify-center text-[#0077B6] group-hover/doc:bg-[#0077B6] group-hover/doc:text-white transition-all duration-500 shrink-0">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-[10px] font-bold text-[#03045E] truncate mb-0.5">{{ $file->original_name }}</p>
                                        <p class="text-[9px] font-medium text-slate-400 uppercase tracking-widest opacity-70">{{ strtoupper($file->file_type) }} • {{ $file->file_size_human }}</p>
                                    </div>
                                </a>
                            @endif
                        @empty
                            <p class="text-center text-xs font-black text-slate-300 uppercase tracking-widest py-10">Belum ada lampiran arsip</p>
                        @endforelse
                    </div>
                </div>

                <!-- Verification Seal -->
                <div class="premium-gradient rounded-[3rem] p-6 sm:p-10 text-white shadow-2xl shadow-blue-900/40 relative overflow-hidden group w-full">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/10 rounded-full blur-[80px] group-hover:scale-150 transition-transform duration-1000"></div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-xl rounded-2xl flex items-center justify-center mb-8 border border-white/20">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h4 class="text-2xl font-bold mb-4 uppercase tracking-tighter leading-tight">Terverifikasi<br>Resmi VeriCult</h4>
                        <p class="text-white/70 text-sm font-medium leading-relaxed mb-10 italic">"Memastikan setiap data warisan budaya terdokumentasi dengan akurat dan sah."</p>
                        
                        <div class="pt-8 border-t border-white/10 flex items-center gap-5">
                            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center font-black text-xs border border-white/20">VC</div>
                            <div>
                                <p class="text-[9px] font-bold text-white/50 uppercase tracking-[0.2em] mb-1">Otoritas Verifikasi</p>
                                <p class="text-[11px] font-black uppercase tracking-widest">Tim Kurator Lapangan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#03045E] pt-24 pb-12 relative overflow-hidden">
        <div class="absolute inset-0 bg-hero-pattern opacity-5"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="flex items-center justify-center gap-3 sm:gap-4 mb-10">
                <div class="flex-1 max-w-[48px] h-px bg-white/20"></div>
                <span class="text-2xl sm:text-3xl font-black text-white">Veri<span class="text-[#00B4D8]">Cult</span></span>
                <div class="flex-1 max-w-[48px] h-px bg-white/20"></div>
            </div>
            
            <p class="text-white/40 text-[10px] font-black uppercase tracking-widest sm:tracking-[0.5em] mb-12">
                Melestarikan Budaya Digital Untuk Generasi Mendatang
            </p>
            
            <div class="flex justify-center flex-wrap gap-8 sm:gap-16 mb-16">
                @foreach(['Beranda' => 'beranda', 'Tentang' => 'tentang', 'Fitur' => 'fitur', 'Profil Budaya' => 'profil-kebudayaan.index'] as $label => $route)
                    <a href="{{ route($route) }}" class="text-[9px] sm:text-[10px] font-black uppercase tracking-widest sm:tracking-[0.3em] text-white/60 hover:text-[#00B4D8] transition-colors">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <p class="text-white/20 text-[9px] font-bold uppercase tracking-widest pt-12 border-t border-white/10">
                &copy; {{ date('Y') }} VeriCult Platform • Hak Cipta Dilindungi Undang-Undang
            </p>
        </div>
    </footer>

    <!-- Mobile Menu Modal Removed (Replaced by dropdown) -->

</body>
</html>
