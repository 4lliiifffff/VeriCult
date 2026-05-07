<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edukasi Kebudayaan - VeriCult</title>
    <meta name="description" content="Pelajari lebih dalam mengenai Objek Pemajuan Kebudayaan, Cagar Budaya, dan pentingnya pelestarian budaya Indonesia melalui VeriCult.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
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
        
        .card-glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="antialiased font-sans bg-white text-slate-900">
    
    <!-- Navbar -->
    <x-public-navbar />

    <!-- Hero Section -->
    <section class="hero-gradient pt-32 pb-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center px-4 py-1.5 bg-slate-50 rounded-full border border-slate-100 text-[#0077B6] text-[10px] font-bold uppercase tracking-[0.2em] mb-8">
                Pusat Edukasi Budaya
            </div>
            <h1 class="text-4xl md:text-6xl font-bold text-[#03045E] mb-6 tracking-tight leading-[1.1]">
                Kenali & Lindungi<br><span class="text-[#0077B6]">Warisan Budaya Kita</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-500 max-w-2xl mx-auto font-normal leading-relaxed">
                Pahami landasan hukum dan kategori kebudayaan Indonesia untuk berkontribusi dalam pelestarian kekayaan bangsa.
            </p>
        </div>
    </section>

    <!-- OPK Section -->
    <section class="py-24 bg-white border-b border-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center mb-20">
                <div class="reveal reveal-up">
                    <h2 class="text-3xl md:text-4xl font-bold text-[#03045E] mb-6 tracking-tight">
                        Apa itu <span class="text-[#0077B6]">OPK?</span>
                    </h2>
                    <p class="text-lg text-slate-500 leading-relaxed mb-6">
                        Objek Pemajuan Kebudayaan (OPK) adalah unsur-unsur kebudayaan yang menjadi sasaran utama dalam upaya pemajuan kebudayaan sebagaimana diamanatkan dalam Undang-Undang Nomor 5 Tahun 2017.
                    </p>
                    <div class="p-6 bg-blue-50 rounded-[2rem] border border-blue-100">
                        <p class="text-sm font-medium text-[#03045E] leading-relaxed">
                            "Pemajuan Kebudayaan adalah upaya meningkatkan ketahanan budaya dan kontribusi budaya Indonesia di tengah peradaban dunia melalui Pelindungan, Pengembangan, Pemanfaatan, dan Pembinaan Kebudayaan."
                        </p>
                    </div>
                </div>
                <div class="reveal reveal-up" style="transition-delay: 200ms;">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 shadow-sm">
                            <h4 class="text-2xl font-bold text-[#0077B6] mb-1">10</h4>
                            <p class="text-xs font-bold text-[#03045E] uppercase tracking-widest">Kategori Utama</p>
                        </div>
                        <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 shadow-sm">
                            <h4 class="text-2xl font-bold text-[#0077B6] mb-1">UU No.5</h4>
                            <p class="text-xs font-bold text-[#03045E] uppercase tracking-widest">Tahun 2017</p>
                        </div>
                        <div class="col-span-2 p-6 bg-[#03045E] rounded-3xl shadow-xl shadow-blue-900/20">
                            <p class="text-white/80 text-xs font-medium leading-relaxed">
                                Fokus pada pelestarian tradisi hidup yang terus berkembang di masyarakat Indonesia.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 10 Categories -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $categories = [
                        ['title' => 'Tradisi Lisan', 'desc' => 'Tuturan yang diwariskan secara turun-temurun seperti pantun, cerita rakyat, dan doa.'],
                        ['title' => 'Manuskrip', 'desc' => 'Naskah tangan yang menyimpan informasi sejarah, sastra, atau pengetahuan kuno.'],
                        ['title' => 'Adat Istiadat', 'desc' => 'Tata kelakuan yang menjadi pedoman dalam kehidupan bermasyarakat.'],
                        ['title' => 'Ritus', 'desc' => 'Tata cara pelaksanaan ibadah atau upacara yang didasarkan pada kepercayaan.'],
                        ['title' => 'Pengetahuan Tradisional', 'desc' => 'Seluruh ide dan gagasan dalam masyarakat yang mengandung nilai etika, estetika, dan manfaat.'],
                        ['title' => 'Teknologi Tradisional', 'desc' => 'Keterampilan atau kemahiran masyarakat dalam membuat peralatan atau infrastruktur.'],
                        ['title' => 'Seni', 'desc' => 'Ekspresi artistik dalam berbagai bentuk seperti gerak, suara, rupa, dan sastra.'],
                        ['title' => 'Bahasa', 'desc' => 'Sarana komunikasi dan identitas budaya yang unik di setiap daerah.'],
                        ['title' => 'Permainan Rakyat', 'desc' => 'Aktivitas permainan yang tumbuh dan berkembang di masyarakat.'],
                        ['title' => 'Olahraga Tradisional', 'desc' => 'Aktivitas fisik yang mengandung nilai budaya dan dilakukan secara turun-temurun.'],
                    ];
                @endphp

                @foreach($categories as $idx => $cat)
                <div class="reveal reveal-up group" style="transition-delay: {{ $idx * 50 }}ms;">
                    <div class="h-full p-8 bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:border-[#0077B6]/20 transition-all duration-500">
                        <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-[#0077B6] mb-6 group-hover:bg-[#03045E] group-hover:text-white transition-all">
                            <span class="text-sm font-black">{{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <h4 class="text-lg font-bold text-[#03045E] mb-3">{{ $cat['title'] }}</h4>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium">
                            {{ $cat['desc'] }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Cagar Budaya & Potensi -->
    <section class="py-24 bg-slate-50 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-100/30 rounded-full blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Cagar Budaya -->
                <div class="reveal reveal-up bg-white p-10 rounded-[2.5rem] border border-white shadow-xl shadow-slate-200/50">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-[#0077B6] mb-8">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[#03045E] mb-4">Cagar Budaya</h3>
                    <p class="text-slate-500 leading-relaxed font-medium mb-6">
                        Warisan budaya bersifat kebendaan berupa Benda, Bangunan, Struktur, Situs, dan Kawasan Cagar Budaya di darat dan/atau di air yang perlu dilestarikan keberadaannya karena memiliki nilai penting bagi sejarah, ilmu pengetahuan, pendidikan, agama, dan/atau kebudayaan.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-sm font-bold text-[#0077B6]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            Bersifat Tangible (Kebendaan)
                        </li>
                        <li class="flex items-center gap-3 text-sm font-bold text-[#0077B6]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            Berusia 50 Tahun atau Lebih
                        </li>
                    </ul>
                </div>

                <!-- Potensi Kebudayaan -->
                <div class="reveal reveal-up bg-white p-10 rounded-[2.5rem] border border-white shadow-xl shadow-slate-200/50" style="transition-delay: 200ms;">
                    <div class="w-16 h-16 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 mb-8">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[#03045E] mb-4">Potensi Kebudayaan</h3>
                    <p class="text-slate-500 leading-relaxed font-medium mb-6">
                        Meliputi sumber daya manusia dan sarana prasarana yang mendukung ekosistem kebudayaan. Ini termasuk Tenaga Kebudayaan (ahli, pelestari, pengelola) dan Lembaga Kebudayaan yang aktif bergerak di bidang seni, adat, dan tradisi.
                    </p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="px-4 py-2 bg-slate-50 rounded-xl text-xs font-bold text-slate-600 border border-slate-100">Tenaga Kebudayaan</div>
                        <div class="px-4 py-2 bg-slate-50 rounded-xl text-xs font-bold text-slate-600 border border-slate-100">Lembaga Budaya</div>
                        <div class="px-4 py-2 bg-slate-50 rounded-xl text-xs font-bold text-slate-600 border border-slate-100">Sarana Prasarana</div>
                        <div class="px-4 py-2 bg-slate-50 rounded-xl text-xs font-bold text-slate-600 border border-slate-100">Ruang Publik</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Report Section -->
    <section class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="reveal reveal-up">
                <h2 class="text-3xl md:text-5xl font-bold text-[#03045E] mb-10 tracking-tight leading-tight">
                    Mengapa Harus <span class="text-[#0077B6]">Dilaporkan?</span>
                </h2>
                <div class="grid md:grid-cols-3 gap-8 text-left mt-16">
                    <div class="space-y-4">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-[#0077B6]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h5 class="font-bold text-[#03045E]">Pelindungan Hukum</h5>
                        <p class="text-sm text-slate-500 leading-relaxed">Menjamin legalitas dan pengakuan resmi negara terhadap aset budaya daerah.</p>
                    </div>
                    <div class="space-y-4">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-[#0077B6]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h5 class="font-bold text-[#03045E]">Pendataan Digital</h5>
                        <p class="text-sm text-slate-500 leading-relaxed">Membangun database kebudayaan yang akurat untuk perencanaan pembangunan berbasis budaya.</p>
                    </div>
                    <div class="space-y-4">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-[#0077B6]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <h5 class="font-bold text-[#03045E]">Warisan Generasi</h5>
                        <p class="text-sm text-slate-500 leading-relaxed">Memastikan pengetahuan dan nilai luhur tetap terjaga untuk dipelajari generasi mendatang.</p>
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
