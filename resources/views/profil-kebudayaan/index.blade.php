<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Kebudayaan - VeriCult</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .hero-gradient {
            background: radial-gradient(circle at 70% 30%, rgba(0, 119, 182, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 20% 70%, rgba(3, 4, 94, 0.05) 0%, transparent 50%),
                        #FFFFFF;
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
            transform: translateY(-4px);
        }
        .filter-btn-active {
            background: #03045E;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(3, 4, 94, 0.2);
        }
    </style>
</head>
<body class="antialiased font-sans bg-white text-slate-900">
    
    <!-- Navbar -->
    <x-public-navbar />

    <!-- Header Section -->
    <section class="hero-gradient pt-32 pb-16 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center px-4 py-1.5 bg-slate-50 rounded-full border border-slate-100 text-[#0077B6] text-[10px] font-bold uppercase tracking-[0.2em] mb-8">
                Eksplorasi Budaya Nusantara
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-[#03045E] mb-6 tracking-tight">Profil <span class="text-[#0077B6]">Kebudayaan Indonesia</span></h1>
            <p class="text-lg text-slate-500 max-w-2xl mx-auto font-normal leading-relaxed">
                Temukan kekayaan tradisi, seni, dan warisan budaya yang telah tervalidasi oleh tim ahli VeriCult.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Filters & Search -->
            <div class="mb-16 space-y-8">
                <!-- Category Filter -->
                <div class="flex items-center gap-2 overflow-x-auto pb-4 scrollbar-hide">
                    <a href="{{ route('profil-kebudayaan.index') }}" 
                       class="px-6 py-2.5 rounded-full text-[10px] font-bold uppercase tracking-widest transition-all {{ !$activeCategory ? 'filter-btn-active' : 'bg-slate-50 text-slate-400 hover:bg-slate-100' }}">
                        Semua
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('profil-kebudayaan.index', ['category' => $category]) }}" 
                           class="px-6 py-2.5 rounded-full text-[10px] font-bold uppercase tracking-widest transition-all {{ $activeCategory === $category ? 'filter-btn-active' : 'bg-slate-50 text-slate-400 hover:bg-slate-100' }}">
                            {{ ucfirst(str_replace('_', ' ', $category)) }}
                        </a>
                    @endforeach
                </div>

                <!-- Search & Year -->
                <div class="bg-slate-50 rounded-3xl p-6 md:p-8 border border-slate-100">
                    <form action="{{ route('profil-kebudayaan.index') }}" method="GET" class="grid md:grid-cols-12 gap-4">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        
                        <div class="md:col-span-3">
                            <x-dropdown-select 
                                name="year" 
                                id="year" 
                                placeholder="Pilih Periode"
                                all-label="Semua Periode"
                                variant="light"
                                :selected="$activeYear" 
                                :options="!empty($availableYears) ? collect($availableYears)->mapWithKeys(fn($y) => [$y => 'Periode ' . $y])->toArray() : [date('Y') => 'Periode ' . date('Y')]" 
                            />
                        </div>

                        <div class="md:col-span-7 relative group">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari objek kebudayaan..." 
                                   class="w-full bg-white border border-slate-200 rounded-xl px-6 py-3.5 text-slate-700 font-medium text-sm focus:ring-2 focus:ring-[#0077B6]/20 focus:border-[#0077B6] transition-all outline-none">
                        </div>

                        <div class="md:col-span-2">
                            <button type="submit" class="w-full bg-[#03045E] text-white rounded-xl py-3.5 font-bold text-xs uppercase tracking-widest hover:bg-[#0077B6] transition-all shadow-md">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Gallery Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($submissions as $submission)
                <a href="{{ route('profil-kebudayaan.show', $submission->slug) }}" class="group bg-white rounded-2xl overflow-hidden border border-slate-100 card-shadow flex flex-col h-full reveal reveal-up">
                    <div class="aspect-[4/3] relative overflow-hidden bg-slate-50">
                        @php 
                            $mainImage = $submission->files->first(function($file) {
                                return in_array(strtolower($file->file_type), ['image', 'jpg', 'jpeg', 'png', 'webp']);
                            }); 
                        @endphp
                        @if($mainImage)
                            <img src="{{ $mainImage->url }}" alt="{{ $submission->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-[9px] font-bold text-[#0077B6] uppercase tracking-wider border border-slate-100">
                                {{ ucfirst(str_replace('_', ' ', $submission->category)) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-8 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-[#03045E] mb-3 line-clamp-1 group-hover:text-[#0077B6] transition-colors tracking-tight">{{ $submission->name }}</h3>
                        <p class="text-slate-500 text-sm line-clamp-3 mb-8 leading-relaxed">
                            {{ $submission->description }}
                        </p>
                        
                        <div class="mt-auto pt-6 border-t border-slate-50 flex items-center justify-between">
                            <div class="flex items-center gap-2 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <span class="text-[10px] font-bold uppercase tracking-widest truncate w-32" title="{{ $submission->address }}">{{ $submission->address }}</span>
                            </div>
                            <div class="text-[#0077B6] font-bold text-[10px] uppercase tracking-widest group-hover:translate-x-1 transition-transform flex items-center gap-2">
                                Detail
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-full py-24 text-center bg-slate-50 rounded-[2.5rem] border border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm text-slate-200">
                         <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#03045E] mb-2">Belum Ada Objek Budaya</h3>
                    <p class="text-slate-400 text-sm">Coba ubah kriteria pencarian atau pilih kategori lain.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-20">
                {{ $submissions->links() }}
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
