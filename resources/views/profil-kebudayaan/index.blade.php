<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Kebudayaan - VeriCult</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

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
<body class="antialiased font-sans bg-white text-slate-900 overflow-x-hidden w-full">

    <!-- Navbar -->
    <x-public-navbar />

    <!-- Header Section -->
    <section class="hero-gradient pt-40 pb-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMyw0LDk0LDAuMDMpIi8+PC9zdmc+')]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-xl border border-blue-100 text-[#0077B6] text-[10px] font-black uppercase tracking-[0.2em] mb-8 shadow-sm shadow-blue-500/5 reveal reveal-up">
                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                Terverifikasi Kurator Resmi
            </div>
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-black text-[#03045E] mb-6 tracking-tight leading-[1.1] reveal reveal-up" style="transition-delay: 100ms;">
                Profil <span class="text-[#0077B6] relative inline-block">Kebudayaan </span> Nusantara
            </h1>
            <p class="text-lg md:text-xl text-slate-500 max-w-2xl mx-auto font-medium leading-relaxed reveal reveal-up" style="transition-delay: 200ms;">
                Temukan kekayaan tradisi, seni, dan warisan budaya yang telah tervalidasi dan dijamin keasliannya oleh tim ahli VeriCult.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-white min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Filters & Search -->
            <div class="mb-16 space-y-8">
                <!-- Kategori Kebudayaan Panel -->
                <div x-data="{
                    categorySearch: '',
                    showAll: {{ $activeCategory ? 'true' : 'false' }},
                    categories: [
                        { name: 'Semua Kategori', url: '{{ route('profil-kebudayaan.index', array_merge(request()->except('category', 'page'), [])) }}', active: {{ !$activeCategory ? 'true' : 'false' }}, desc: 'Lihat semua data kebudayaan tanpa batasan kategori.' },
                        @foreach($categories as $category)
                        {
                            name: '{{ $category }}',
                            url: '{{ route('profil-kebudayaan.index', array_merge(request()->except('page'), ['category' => $category])) }}',
                            active: {{ $activeCategory === $category ? 'true' : 'false' }},
                            desc: '{{ \App\Models\CulturalSubmission::CATEGORY_DESCRIPTIONS[$category] ?? '' }}'
                        },
                        @endforeach
                    ],
                    get filteredCategories() {
                        if (!this.categorySearch) return this.categories;
                        return this.categories.filter(c =>
                            c.name.toLowerCase().includes(this.categorySearch.toLowerCase()) ||
                            c.desc.toLowerCase().includes(this.categorySearch.toLowerCase())
                        );
                    }
                }" class="bg-white rounded-[2.5rem] p-6 sm:p-8 border border-slate-100 shadow-xl shadow-slate-200/50 relative overflow-hidden group reveal reveal-up">
                    <!-- Glassy backgrounds -->
                    <div class="absolute -right-24 -top-24 w-64 h-64 bg-blue-50/40 rounded-full blur-3xl transition-transform duration-700 pointer-events-none"></div>
                    <div class="absolute -left-24 -bottom-24 w-64 h-64 bg-indigo-50/40 rounded-full blur-3xl transition-transform duration-700 pointer-events-none"></div>

                    <!-- Panel Header -->
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-6 border-b border-slate-100 relative z-10">
                        <div>
                            <h2 class="text-lg font-black text-[#03045E] flex items-center gap-2">
                                Jelajahi Kategori Budaya
                            </h2>
                            <p class="text-xs text-slate-400 font-medium mt-1">Saring objek kebudayaan nusantara berdasarkan pengelompokan resmi</p>
                        </div>

                        <!-- Search & Action buttons -->
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full lg:w-auto">
                            <!-- Search inside category -->
                            <div class="relative w-full sm:w-64">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                </div>
                                <input
                                    type="text"
                                    x-model="categorySearch"
                                    placeholder="Cari kategori budaya..."
                                    class="w-full bg-slate-50/80 border border-slate-200 rounded-2xl pl-10 pr-10 py-2.5 text-xs font-semibold text-slate-700 placeholder-slate-400 focus:bg-white focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all outline-none"
                                >
                                <!-- Clear Button -->
                                <button
                                    x-show="categorySearch"
                                    @click="categorySearch = ''"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600"
                                    style="display: none;"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>

                            <!-- Unduh Laporan Button -->
                            <a href="{{ route('public.reports.print', ['year' => $activeYear]) }}" class="shrink-0 inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-[#03045E] hover:bg-[#0077B6] text-white rounded-2xl font-bold text-[10px] uppercase tracking-widest shadow-lg shadow-blue-900/10 transition-all duration-300 hover:-translate-y-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Unduh Rekap
                            </a>
                        </div>
                    </div>

                    <!-- Category Cards Grid -->
                    <div class="relative z-10 pt-6">
                        <!-- Desktop & Mobile Adaptive Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 transition-all duration-300">
                            <template x-for="(cat, idx) in filteredCategories" :key="cat.name">
                                <a
                                    :href="cat.url"
                                    x-show="showAll || idx < 4 || categorySearch || cat.active"
                                    class="group/item flex flex-col p-5 rounded-2xl border transition-all duration-300 hover:-translate-y-0.5"
                                    :class="cat.active
                                        ? 'bg-[#03045E] border-[#03045E] text-white shadow-lg shadow-blue-900/20 border-l-4 border-l-emerald-400'
                                        : 'bg-slate-50/50 border-slate-100 text-slate-700 hover:bg-white hover:border-[#0077B6]/30 hover:shadow-md hover:shadow-slate-100 hover:border-l-4 hover:border-l-[#0077B6]/50'"
                                >
                                    <!-- Content -->
                                    <div class="space-y-1.5 w-full">
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="text-xs font-bold tracking-tight" :class="cat.active ? 'text-white' : 'text-slate-800 group-hover/item:text-[#0077B6]'" x-text="cat.name"></span>
                                            <span
                                                x-show="cat.active"
                                                class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse shrink-0"
                                            ></span>
                                        </div>
                                        <p
                                            class="text-[10px] leading-relaxed font-medium line-clamp-2"
                                            :class="cat.active ? 'text-blue-100' : 'text-slate-400'"
                                            x-text="cat.desc"
                                        ></p>
                                    </div>
                                </a>
                            </template>
                        </div>

                        <!-- No Categories Found -->
                        <div
                            x-show="filteredCategories.length === 0"
                            class="py-8 text-center"
                            style="display: none;"
                        >
                            <p class="text-xs font-bold text-slate-400">Kategori &ldquo;<span x-text="categorySearch" class="text-slate-600"></span>&rdquo; tidak ditemukan</p>
                        </div>

                        <!-- Expand / Collapse Button -->
                        <div
                            x-show="!categorySearch && filteredCategories.length > 4"
                            class="flex justify-center mt-6 pt-4 border-t border-slate-100/50"
                        >
                            <button
                                @click="showAll = !showAll"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-slate-200 bg-white hover:border-[#0077B6]/30 text-[10px] font-black text-slate-500 hover:text-[#0077B6] uppercase tracking-widest transition-all duration-300"
                            >
                                <span x-text="showAll ? 'Sembunyikan Kategori' : 'Lihat Semua Kategori'"></span>
                                <svg
                                    class="w-3.5 h-3.5 transition-transform duration-300"
                                    :class="showAll ? 'rotate-180' : ''"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    stroke-width="2.5"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Search & Year -->
                <div class="bg-white rounded-[2.5rem] sm:rounded-[3rem] p-8 sm:p-10 border border-slate-100 shadow-xl shadow-slate-200/50 relative group z-10">
                    <div class="absolute -right-24 -top-24 w-64 h-64 bg-blue-50/50 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-700"></div>
                    <div class="absolute -left-24 -bottom-24 w-64 h-64 bg-indigo-50/50 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-700"></div>

                    <form action="{{ route('profil-kebudayaan.index') }}" method="GET" class="grid md:grid-cols-12 gap-6 relative z-10 auto-submit">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif

                        <div class="md:col-span-3">
                            <x-dropdown-select
                                name="year"
                                id="year"
                                placeholder="Semua Periode"
                                variant="light"
                                :selected="$activeYear"
                                :options="['all' => 'Semua Periode'] + (!empty($availableYears) ? collect($availableYears)->mapWithKeys(fn($y) => [$y => 'Periode ' . $y])->toArray() : [date('Y') => 'Periode ' . date('Y')])"
                            />
                        </div>

                        <div class="md:col-span-7 relative group/search">
                            <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-slate-400 group-focus-within/search:text-[#0077B6] transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari objek kebudayaan..."
                                   class="w-full bg-slate-50/50 border border-slate-200 rounded-2xl pl-14 pr-6 py-4 text-slate-700 font-medium text-sm focus:bg-white focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all outline-none shadow-inner">
                        </div>

                        <div class="md:col-span-2">
                            <button type="submit" class="w-full bg-[#03045E] hover:bg-[#023E8A] text-white rounded-2xl py-4 font-black text-[11px] uppercase tracking-[0.2em] hover:shadow-2xl hover:shadow-blue-900/40 transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                                Cari Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Gallery Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($submissions as $submission)
                <a href="{{ route('profil-kebudayaan.show', $submission->slug) }}" class="group bg-white rounded-[2rem] overflow-hidden border border-slate-100 shadow-xl shadow-slate-200/50 hover:-translate-y-2 hover:shadow-2xl hover:shadow-blue-900/10 transition-all duration-500 flex flex-col h-full reveal reveal-up">
                    <div class="aspect-[4/3] relative overflow-hidden bg-slate-50">
                        @php
                            $mainImage = $submission->files->first(function($file) {
                                return in_array(strtolower($file->file_type), ['image', 'jpg', 'jpeg', 'png', 'webp']);
                            });
                            $mainVideo = !$mainImage ? $submission->files->first(function($file) {
                                return strtolower($file->file_type) === 'video';
                            }) : null;
                        @endphp
                        @if($mainImage)
                            <img src="{{ $mainImage->url }}" alt="{{ $submission->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @elseif($mainVideo)
                            <video src="{{ $mainVideo->url }}" autoplay loop muted playsinline class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"></video>
                            <div class="absolute inset-0 flex items-center justify-center z-20 pointer-events-none">
                                <div class="w-10 h-10 bg-black/40 rounded-full flex items-center justify-center backdrop-blur-sm border border-white/20">
                                    <svg class="w-4 h-4 text-white ml-1" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4l12 6-12 6z"></path></svg>
                                </div>
                            </div>
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-10"></div>
                        <div class="absolute top-4 left-4">
                            <span class="px-4 py-1.5 bg-white/90 backdrop-blur-md rounded-xl text-[9px] font-black text-[#0077B6] uppercase tracking-[0.2em] border border-white/50 shadow-sm">
                                {{ ucfirst(str_replace('_', ' ', $submission->category)) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-8 flex flex-col flex-grow relative z-10 bg-white">
                        <h3 class="text-xl font-black text-[#03045E] mb-3 line-clamp-1 group-hover:text-[#0077B6] transition-colors tracking-tight">{{ $submission->name }}</h3>
                        <p class="text-slate-500 text-sm line-clamp-3 mb-8 font-medium leading-relaxed">
                            {{ $submission->description }}
                        </p>

                        <div class="mt-auto pt-6 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] truncate w-32" title="{{ $submission->address }}">{{ $submission->address }}</span>
                            </div>
                            <div class="text-[#0077B6] font-black text-[10px] uppercase tracking-[0.2em] group-hover:translate-x-1 transition-transform flex items-center gap-2">
                                Lihat Profil
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
