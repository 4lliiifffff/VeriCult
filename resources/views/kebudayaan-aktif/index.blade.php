<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Feed Kebudayaan Aktif - VeriCult</title>
    <meta name="description" content="Temukan laporan kebudayaan yang sedang aktif berlangsung di masyarakat, telah diverifikasi oleh tim ahli VeriCult.">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .hero-gradient {
            background: radial-gradient(circle at 70% 30%, rgba(0, 119, 182, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 20% 70%, rgba(3, 4, 94, 0.05) 0%, transparent 50%),
                        #FFFFFF;
        }
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 50px -12px rgba(3, 4, 94, 0.15);
        }
        .reveal { opacity: 0; transform: translateY(24px); transition: opacity 0.7s ease, transform 0.7s ease; }
        .reveal-up { transform: translateY(30px); }
        .reveal-visible { opacity: 1; transform: translateY(0); }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
        .float-anim { animation: float 4s ease-in-out infinite; }
    </style>
</head>
<body class="antialiased bg-white text-slate-900">

    <x-public-navbar />

    {{-- Hero / Header Section --}}
    <section class="hero-gradient pt-40 pb-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMyw0LDk0LDAuMDMpIi8+PC9zdmc+')]"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-xl border border-blue-100 text-[#0077B6] text-[10px] font-black uppercase tracking-[0.2em] mb-8 shadow-sm shadow-blue-500/5 reveal reveal-up">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                Aktif Terverifikasi Langsung
            </div>

            <h1 class="text-4xl sm:text-5xl md:text-7xl font-black text-[#03045E] mb-6 tracking-tight leading-[1.1] reveal reveal-up" style="transition-delay: 100ms;">
                Feed <span class="text-[#0077B6] relative inline-block">Kebudayaan </span> Aktif
            </h1>
            <p class="text-lg md:text-xl text-slate-500 max-w-2xl mx-auto font-medium leading-relaxed reveal reveal-up" style="transition-delay: 200ms;">
                Kebudayaan yang sedang hidup dan aktif di tengah masyarakat, telah diverifikasi langsung oleh validator lapangan VeriCult.
            </p>

            {{-- Stats --}}
            <div class="mt-10 flex flex-wrap items-center justify-center gap-4 reveal reveal-up" style="transition-delay: 300ms;">
                <div class="bg-white rounded-2xl border border-blue-100 px-8 py-4 shadow-sm shadow-blue-500/5 text-center">
                    <div class="text-3xl font-black text-[#03045E]">{{ $totalCount }}</div>
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Total Kebudayaan Aktif</div>
                </div>
                <div class="bg-white rounded-2xl border border-blue-100 px-8 py-4 shadow-sm shadow-blue-500/5 text-center">
                    <div class="text-3xl font-black text-[#03045E]">{{ $kecamatans->count() }}</div>
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Kecamatan Terlibat</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Filter & Search --}}
    <section class="bg-white border-b border-slate-100 sticky top-16 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <form action="{{ route('kebudayaan-aktif.index') }}" method="GET" class="flex flex-col md:flex-row gap-2.5 md:gap-3 auto-submit">
                {{-- Left side: Search Input & Compact Mobile Button --}}
                <div class="flex flex-1 gap-2">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari nama kebudayaan, lokasi..."
                               class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl pl-10 pr-4 py-3.5 text-sm font-bold text-slate-600 focus:bg-white focus:ring-2 focus:ring-[#0077B6]/20 focus:border-[#00B4D8] transition-all outline-none">
                    </div>
                    <button type="submit" class="bg-[#03045E] text-white rounded-2xl px-5 py-3.5 text-[11px] font-black uppercase tracking-widest hover:bg-[#0077B6] transition-all active:scale-95 whitespace-nowrap md:hidden flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </div>

                {{-- Right side: Dropdowns & Buttons --}}
                <div class="grid grid-cols-2 md:flex md:items-center gap-2 md:gap-3">
                    {{-- Kecamatan filter --}}
                    <div class="min-w-0 md:min-w-[200px]">
                        <x-dropdown-select
                            name="kecamatan"
                            id="kecamatan"
                            placeholder="Semua Kecamatan"
                            all-label="Semua Kecamatan"
                            variant="light"
                            :selected="request('kecamatan', '')"
                            :options="$kecamatans->mapWithKeys(fn($k) => [(string) $k->id => $k->name])->toArray()"
                        />
                    </div>

                    {{-- Sort --}}
                    <div class="min-w-0 md:min-w-[170px]">
                        <x-dropdown-select
                            name="sort"
                            id="sort"
                            placeholder="Urutkan"
                            variant="light"
                            :selected="request('sort', 'newest')"
                            :options="['newest' => 'Terbaru Diterbitkan', 'oldest' => 'Terlama Diterbitkan']"
                        />
                    </div>

                    <button type="submit"
                            class="hidden md:inline-flex bg-[#03045E] text-white rounded-2xl px-6 py-3.5 text-[11px] font-black uppercase tracking-widest hover:bg-[#0077B6] transition-all active:scale-95 whitespace-nowrap justify-center items-center">
                        Cari
                    </button>

                    @if(request('search') || request('kecamatan') || (request('sort') && request('sort') !== 'newest'))
                    <a href="{{ route('kebudayaan-aktif.index') }}"
                       class="col-span-2 md:col-span-1 bg-slate-100 text-slate-500 rounded-2xl px-4 py-3 md:py-3.5 text-[11px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all active:scale-95 flex items-center justify-center gap-1 whitespace-nowrap">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </section>

    {{-- Feed Grid --}}
    <section class="py-16 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Result counter --}}
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h2 class="text-2xl font-black text-[#03045E] tracking-tight">
                        @if(request('search') || request('kecamatan'))
                            Hasil Pencarian
                        @else
                            Semua Kebudayaan Aktif
                        @endif
                    </h2>
                    <p class="text-sm text-slate-500 mt-1 font-medium">
                        Menampilkan <strong class="text-[#0077B6]">{{ $posts->total() }}</strong> kebudayaan aktif terverifikasi
                    </p>
                </div>
            </div>

            {{-- Cards Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                @forelse($posts as $post)
                @php
                    $coverImage = $post->files->first(fn($f) => $f->file_type === 'image');
                    $coverVideo = $post->files->first(fn($f) => $f->file_type === 'video');
                    $publishedAgo = $post->published_at?->diffForHumans();
                @endphp
                <article class="group bg-white rounded-[1.5rem] sm:rounded-[2rem] overflow-hidden border border-slate-100 shadow-lg card-hover flex flex-col reveal">
                    {{-- Cover Image / Video --}}
                    <a href="{{ route('kebudayaan-aktif.show', $post->slug) }}" class="block relative overflow-hidden aspect-[16/9] bg-gradient-to-br from-[#03045E] to-[#0077B6]">
                        @if($coverImage)
                            <img src="{{ $coverImage->url }}" alt="{{ $post->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                        @elseif($coverVideo)
                            <video src="{{ $coverVideo->url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" muted playsinline preload="metadata"></video>
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center group-hover:bg-black/35 transition-colors">
                                <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white border border-white/30 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            </div>
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-20 h-20 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Live badge --}}
                        <div class="absolute top-4 left-4 flex items-center gap-1.5 bg-white/90 backdrop-blur-sm rounded-full px-3 py-1.5 shadow-sm">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <span class="text-[9px] font-black text-emerald-700 uppercase tracking-widest">Aktif</span>
                        </div>
                    </a>

                    {{-- Card Body --}}
                    <div class="p-5 sm:p-6 flex flex-col flex-grow">
                        {{-- Meta: who & when --}}
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#03045E] to-[#0077B6] flex items-center justify-center text-white text-[10px] font-black shrink-0">
                                {{ strtoupper(substr($post->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] font-black text-slate-700 truncate">{{ $post->user->name ?? 'Pengusul' }}</p>
                                <p class="text-[10px] text-slate-400 font-medium">{{ $publishedAgo }}</p>
                            </div>
                            @if($post->village)
                            <div class="ml-auto shrink-0">
                                <span class="text-[9px] font-black text-[#0077B6] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100 uppercase tracking-widest">
                                    {{ $post->village->kecamatan->name ?? $post->village->name }}
                                </span>
                            </div>
                            @endif
                        </div>

                        {{-- Title --}}
                        <a href="{{ route('kebudayaan-aktif.show', $post->slug) }}" class="block mb-3">
                            <h3 class="text-lg font-black text-[#03045E] leading-snug group-hover:text-[#0077B6] transition-colors line-clamp-2 tracking-tight">
                                {{ $post->name }}
                            </h3>
                        </a>

                        {{-- Description --}}
                        <p class="text-sm text-slate-500 leading-relaxed line-clamp-3 font-medium mb-6 flex-grow">
                            {{ $post->description ?? 'Tidak ada deskripsi.' }}
                        </p>

                        {{-- Footer --}}
                        <div class="pt-5 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-1.5 text-slate-400">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                <span class="text-[10px] font-bold uppercase tracking-wider truncate max-w-[130px]" title="{{ $post->address }}">{{ $post->address }}</span>
                            </div>
                            <a href="{{ route('kebudayaan-aktif.show', $post->slug) }}"
                               class="inline-flex items-center gap-1.5 text-[10px] font-black text-[#0077B6] uppercase tracking-widest hover:gap-2.5 transition-all">
                                Baca Selengkapnya
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </article>
                @empty
                <div class="col-span-full py-32 text-center">
                    <div class="w-24 h-24 bg-white rounded-[2rem] flex items-center justify-center mx-auto mb-8 shadow-sm border border-slate-100">
                        <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-2xl font-black text-[#03045E] mb-3 tracking-tight">Belum Ada Data</h3>
                    <p class="text-slate-400 text-sm font-medium mb-6">Belum ada laporan kebudayaan aktif yang terverifikasi saat ini.<br>Coba ubah kata kunci pencarian atau hapus filter.</p>
                    @if(request('search') || request('kecamatan'))
                    <a href="{{ route('kebudayaan-aktif.index') }}"
                       class="inline-flex items-center gap-2 bg-[#03045E] text-white rounded-xl px-6 py-3 text-[11px] font-black uppercase tracking-widest hover:bg-[#0077B6] transition-all">
                        Lihat Semua Feed
                    </a>
                    @endif
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($posts->hasPages())
            <div class="mt-16">
                {{ $posts->links() }}
            </div>
            @endif
        </div>
    </section>

    @include('partials.footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('reveal-visible');
                        obs.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
            document.querySelectorAll('.reveal').forEach((el, i) => {
                el.style.transitionDelay = `${(i % 3) * 80}ms`;
                observer.observe(el);
            });


        });
    </script>
</body>
</html>
