<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-clip">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $submission->name }} - VeriCult</title>
    
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
<body class="antialiased font-sans bg-white text-slate-900 overflow-x-hidden" 
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
    <section class="relative h-[70vh] min-h-[500px] flex items-end overflow-hidden bg-slate-900">
        @php 
            $mainImage = $submission->files->first(function($file) {
                return in_array(strtolower($file->file_type), ['image', 'jpg', 'jpeg', 'png', 'webp']);
            }); 
        @endphp
        
        @if($mainImage)
            <img src="{{ $mainImage->url }}" alt="{{ $submission->name }}" class="absolute inset-0 w-full h-full object-cover opacity-60">
        @endif
        <div class="absolute inset-0 hero-gradient-overlay"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10 pb-16">
            <div class="max-w-4xl reveal reveal-up">
                <div class="flex items-center gap-3 mb-6">
                    <span class="px-4 py-1 bg-[#0077B6] text-white text-[10px] font-bold uppercase tracking-wider rounded-lg">
                        {{ ucfirst(str_replace('_', ' ', $submission->category)) }}
                    </span>
                    <span class="px-4 py-1 bg-white/10 backdrop-blur text-white text-[10px] font-bold uppercase tracking-wider rounded-lg border border-white/20">
                        VeriCult Certified
                    </span>
                </div>
                
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-8 tracking-tight leading-tight">
                    {{ $submission->name }}
                </h1>

                <div class="flex flex-wrap items-center gap-8 text-white/80">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center border border-white/10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-white/40">Lokasi</p>
                            <p class="text-sm font-semibold">{{ $submission->address }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center border border-white/10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-white/40">Publikasi</p>
                            <p class="text-sm font-semibold">{{ ($submission->published_at ?? $submission->created_at)->translatedFormat('d M Y') }}</p>
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
                <div class="lg:col-span-8 space-y-16">
                    <div class="reveal reveal-up">
                        <h2 class="text-2xl font-bold text-[#03045E] mb-6 flex items-center gap-4">
                            Deskripsi Objek
                            <div class="h-px flex-1 bg-slate-100"></div>
                        </h2>
                        <p class="text-lg text-slate-500 leading-relaxed font-normal italic">
                            "{{ $submission->description }}"
                        </p>
                    </div>

                    @if(!empty($submission->category_data))
                    <div class="bg-slate-50 rounded-[2.5rem] p-10 border border-slate-100 reveal reveal-up">
                        <h3 class="text-sm font-bold text-[#0077B6] uppercase tracking-[0.2em] mb-10">Data Teknis DetaiL</h3>
                        
                        <div class="grid gap-12">
                            @php
                                $subCat = $submission->category_data[array_keys(array_filter($submission->category_data, fn($k) => str_starts_with($k, 'sub_kategori'), ARRAY_FILTER_USE_KEY))[0] ?? ''] ?? null;
                                $flatFields = \App\Models\CulturalSubmission::getFlatCategoryFields($submission->category, $subCat);
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
                                    @endphp

                                    <div class="space-y-3">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $displayLabel }}</p>
                                        
                                        @if(is_array($displayValue))
                                            @if(isset($displayValue[0]) && is_array($displayValue[0]))
                                                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
                                                    <div class="overflow-x-auto">
                                                        <table class="w-full text-left text-sm">
                                                            <thead class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                                                <tr>
                                                                    @foreach(array_keys($displayValue[0]) as $colKey)
                                                                        <th class="px-6 py-4">{{ str_replace('_', ' ', $colKey) }}</th>
                                                                    @endforeach
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                                                                @foreach($displayValue as $row)
                                                                    <tr>
                                                                        @foreach($row as $cell)
                                                                            <td class="px-6 py-4">{{ $cell }}</td>
                                                                        @endforeach
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($displayValue as $item)
                                                        <span class="px-4 py-2 bg-white border border-slate-100 rounded-xl text-xs font-semibold text-[#03045E]">
                                                            {{ $item }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @else
                                            <p class="text-[#03045E] font-semibold text-lg tracking-tight">
                                                {{ $displayValue }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-4 space-y-12">
                    <!-- Media Gallery -->
                    <div class="reveal reveal-up" style="transition-delay: 100ms;">
                        <h3 class="text-sm font-bold text-[#03045E] uppercase tracking-widest mb-6">Galeri Media</h3>
                        <div class="grid grid-cols-2 lg:grid-cols-1 gap-4">
                            @forelse($submission->files as $file)
                                @if(in_array(strtolower($file->file_type), ['image', 'jpg', 'jpeg', 'png', 'webp']))
                                    <button @click="openPreview('{{ $file->url }}', 'image', '{{ $file->original_name }}')" 
                                            class="group relative aspect-[4/3] rounded-2xl overflow-hidden bg-slate-100 border border-slate-100 card-shadow">
                                        <img src="{{ $file->url }}" alt="{{ $file->original_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                        </div>
                                    </button>
                                @elseif(in_array(strtolower($file->file_type), ['video', 'mp4', 'mov', 'webm']))
                                    <button @click="openPreview('{{ $file->url }}', 'video', '{{ $file->original_name }}')" 
                                            class="group relative aspect-video rounded-2xl overflow-hidden bg-slate-900 border border-slate-100 card-shadow">
                                        <div class="absolute inset-0 flex items-center justify-center text-white">
                                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                        </div>
                                    </button>
                                @endif
                            @empty
                                <div class="col-span-full py-12 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tidak ada media</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Verification Badge -->
                    <div class="bg-[#03045E] rounded-[2.5rem] p-10 text-white relative overflow-hidden reveal reveal-up" style="transition-delay: 200ms;">
                        <div class="relative z-10">
                            <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center mb-6 border border-white/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <h4 class="text-xl font-bold mb-4 tracking-tight">Terverifikasi Resmi</h4>
                            <p class="text-white/60 text-sm leading-relaxed mb-8 italic">
                                "Sistem VeriCult menjamin keaslian dan validitas data warisan budaya ini melalui proses verifikasi berjenjang."
                            </p>
                            <div class="flex items-center gap-4 pt-8 border-t border-white/10">
                                <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center text-[10px] font-bold">VC</div>
                                <div>
                                    <p class="text-[10px] font-bold text-white/40 uppercase tracking-widest">Otoritas</p>
                                    <p class="text-xs font-bold">Tim Kurator VeriCult</p>
                                </div>
                            </div>
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
