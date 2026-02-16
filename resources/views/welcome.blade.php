<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VeriCult - Sistem Verifikasi Kebudayaan Digital</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #03045E 0%, #023E8A 50%, #0077B6 100%);
        }
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -10px rgba(0, 119, 182, 0.3);
        }
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: scale(1.05);
        }
        .hero-pattern {
            position: relative;
        }
        .hero-pattern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2300B4D8' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 0;
        }
    </style>
</head>
<body class="antialiased font-sans">
    
    <!-- Navbar -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-[#0077B6] to-[#00B4D8] rounded-lg flex items-center justify-center shadow-lg shadow-[#0077B6]/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-[#03045E]">Veri<span class="text-[#0077B6]">Cult</span></span>
                    </a>
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#tentang" class="text-[#023E8A] hover:text-[#0077B6] font-medium transition">Tentang</a>
                    <a href="#fitur" class="text-[#023E8A] hover:text-[#0077B6] font-medium transition">Fitur</a>
                    <a href="#statistik" class="text-[#023E8A] hover:text-[#0077B6] font-medium transition">Statistik</a>
                </div>
                
                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-[#023E8A] hover:text-[#0077B6] font-medium transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-[#023E8A] hover:text-[#0077B6] font-medium transition">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-gradient-to-r from-[#0077B6] to-[#00B4D8] hover:from-[#023E8A] hover:to-[#0077B6] text-white px-6 py-2 rounded-lg font-medium transition shadow-lg shadow-[#0077B6]/30 hover:shadow-xl hover:shadow-[#0077B6]/40">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg hero-pattern relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-[#00B4D8]/20 to-transparent rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-[#48CAE4]/20 to-transparent rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 relative z-10">
            <div class="text-center">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-white text-sm font-medium mb-8 border border-white/20">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    Sistem Verifikasi Terpercaya
                </div>
                
                <!-- Main Heading -->
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                    VeriCult – Sistem Verifikasi<br>
                    <span class="text-[#90E0EF]">Kebudayaan Digital</span>
                </h1>
                
                <!-- Subtitle -->
                <p class="text-xl md:text-2xl text-[#CAF0F8] mb-12 max-w-3xl mx-auto leading-relaxed">
                    Platform digital terintegrasi untuk pengajuan, validasi, dan sertifikasi objek kebudayaan Indonesia dengan sistem verifikasi berjenjang yang akurat dan terpercaya.
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('register') }}" class="bg-white text-[#0077B6] px-8 py-4 rounded-lg font-bold text-lg hover:bg-[#CAF0F8] transition shadow-xl hover:shadow-2xl transform hover:scale-105 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Ajukan Objek Budaya
                    </a>
                    <a href="#statistik" class="bg-[#0077B6]/50 backdrop-blur-sm text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-[#0077B6]/70 transition border-2 border-white/30 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Lihat Data Tervalidasi
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Wave Divider -->
        <div class="absolute -bottom-1 left-0 right-0 overflow-hidden leading-none">
            <svg class="relative block w-full h-[60px] md:h-[120px]" preserveAspectRatio="none" viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
            </svg>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-[#03045E] mb-6">
                        Tentang <span class="text-[#0077B6]">VeriCult</span>
                    </h2>
                    <p class="text-lg text-gray-700 mb-6 leading-relaxed">
                        VeriCult adalah sistem digital yang dirancang khusus untuk memfasilitasi proses pengajuan, validasi, dan sertifikasi objek kebudayaan Indonesia. Dengan menggabungkan teknologi modern dan prosedur validasi yang ketat, kami memastikan setiap objek budaya terverifikasi dengan akurat.
                    </p>
                    <p class="text-lg text-gray-700 mb-6 leading-relaxed">
                        Sistem kami melibatkan berbagai peran mulai dari pengusul, validator, hingga administrator untuk memastikan proses verifikasi yang transparan dan akuntabel.
                    </p>
                    <div class="flex items-start space-x-4 bg-gradient-to-r from-[#CAF0F8] to-[#ADE8F4] p-6 rounded-lg border-l-4 border-[#0077B6]">
                        <svg class="w-6 h-6 text-[#0077B6] mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="font-bold text-[#03045E] mb-2">Verifikasi Terpercaya</h3>
                            <p class="text-[#023E8A]">Setiap objek budaya melalui proses validasi berjenjang oleh validator terlatih dan bersertifikat.</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-[#ADE8F4] to-[#CAF0F8] rounded-2xl p-8 shadow-xl shadow-[#0077B6]/10">
                        <div class="space-y-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-[#0077B6] to-[#00B4D8] rounded-lg flex items-center justify-center flex-shrink-0 shadow-lg shadow-[#0077B6]/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-[#03045E]">Pengajuan Digital</h4>
                                    <p class="text-[#023E8A] text-sm">Proses pengajuan mudah dan cepat</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-[#00B4D8] to-[#48CAE4] rounded-lg flex items-center justify-center flex-shrink-0 shadow-lg shadow-[#00B4D8]/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-[#03045E]">Validasi Berjenjang</h4>
                                    <p class="text-[#023E8A] text-sm">Sistem verifikasi multi-level</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-[#48CAE4] to-[#90E0EF] rounded-lg flex items-center justify-center flex-shrink-0 shadow-lg shadow-[#48CAE4]/30">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-[#03045E]">Sertifikasi Digital</h4>
                                    <p class="text-[#023E8A] text-sm">Sertifikat terverifikasi otomatis</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-20 bg-gradient-to-br from-[#F8FAFC] to-[#EFF6FF]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-[#03045E] mb-4">
                    Fitur <span class="text-[#0077B6]">Utama</span>
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Sistem lengkap yang dirancang untuk memudahkan proses verifikasi kebudayaan dengan teknologi terkini
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-white rounded-xl p-8 shadow-md border border-[#CAF0F8]">
                    <div class="w-16 h-16 bg-gradient-to-br from-[#0077B6] to-[#00B4D8] rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-[#0077B6]/30">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#03045E] mb-3">Pengajuan Digital</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Ajukan objek kebudayaan secara online dengan formulir digital yang mudah dan terstruktur. Upload dokumentasi lengkap dengan aman.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-white rounded-xl p-8 shadow-md border border-[#CAF0F8]">
                    <div class="w-16 h-16 bg-gradient-to-br from-[#00B4D8] to-[#48CAE4] rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-[#00B4D8]/30">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#03045E] mb-3">Sistem Validasi Berjenjang</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Proses verifikasi multi-level oleh validator ahli dengan status: pending, revisi, valid, dan ditolak untuk akurasi maksimal.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-white rounded-xl p-8 shadow-md border border-[#CAF0F8]">
                    <div class="w-16 h-16 bg-gradient-to-br from-[#48CAE4] to-[#90E0EF] rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-[#48CAE4]/30">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#03045E] mb-3">Dashboard Statistik</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Pantau progress pengajuan, lihat statistik validasi, dan akses laporan komprehensif dalam satu dashboard terintegrasi.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card bg-white rounded-xl p-8 shadow-md border border-[#CAF0F8]">
                    <div class="w-16 h-16 bg-gradient-to-br from-[#90E0EF] to-[#ADE8F4] rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-[#90E0EF]/30">
                        <svg class="w-8 h-8 text-[#03045E]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-[#03045E] mb-3">Sertifikasi Digital</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Dapatkan sertifikat digital terverifikasi secara otomatis untuk setiap objek budaya yang telah lolos validasi lengkap.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section id="statistik" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-[#03045E] mb-4">
                    Statistik <span class="text-[#0077B6]">VeriCult</span>
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Data real-time dari sistem verifikasi kebudayaan digital kami
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Stat 1 -->
                <div class="stat-card bg-gradient-to-br from-[#0077B6] to-[#00B4D8] rounded-2xl p-8 text-white shadow-xl shadow-[#0077B6]/30">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-5xl font-bold mb-2">1,247</div>
                    <div class="text-[#CAF0F8] text-lg font-medium">Total Objek Budaya</div>
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                            </svg>
                            <span>+12% bulan ini</span>
                        </div>
                    </div>
                </div>

                <!-- Stat 2 -->
                <div class="stat-card bg-gradient-to-br from-[#00B4D8] to-[#48CAE4] rounded-2xl p-8 text-white shadow-xl shadow-[#00B4D8]/30">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-5xl font-bold mb-2">892</div>
                    <div class="text-[#CAF0F8] text-lg font-medium">Objek Tervalidasi</div>
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                            </svg>
                            <span>71.5% tingkat validasi</span>
                        </div>
                    </div>
                </div>

                <!-- Stat 3 -->
                <div class="stat-card bg-gradient-to-br from-[#48CAE4] to-[#90E0EF] rounded-2xl p-8 text-white shadow-xl shadow-[#48CAE4]/30">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="text-5xl font-bold mb-2">324</div>
                    <div class="text-[#CAF0F8] text-lg font-medium">Total Pengusul</div>
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <div class="flex items-center text-sm">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                            </svg>
                            <span>+8% pengguna baru</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-12 bg-gradient-to-r from-[#CAF0F8] to-[#ADE8F4] rounded-2xl p-8 border-2 border-[#90E0EF]">
                <div class="grid md:grid-cols-4 gap-6 text-center">
                    <div>
                        <div class="text-3xl font-bold text-[#03045E] mb-1">156</div>
                        <div class="text-[#023E8A] text-sm font-medium">Pending Review</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-[#03045E] mb-1">89</div>
                        <div class="text-[#023E8A] text-sm font-medium">Dalam Revisi</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-[#03045E] mb-1">45</div>
                        <div class="text-[#023E8A] text-sm font-medium">Validator Aktif</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-[#03045E] mb-1">98.2%</div>
                        <div class="text-[#023E8A] text-sm font-medium">Kepuasan Pengguna</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 gradient-bg">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                Siap Memulai Verifikasi Objek Budaya?
            </h2>
            <p class="text-xl text-[#CAF0F8] mb-8">
                Bergabunglah dengan ratusan pengusul yang telah mempercayai VeriCult untuk verifikasi objek kebudayaan mereka
            </p>
            <a href="{{ route('register') }}" class="inline-flex items-center bg-white text-[#0077B6] px-8 py-4 rounded-lg font-bold text-lg hover:bg-[#CAF0F8] transition shadow-xl hover:shadow-2xl transform hover:scale-105">
                <span>Daftar Sekarang</span>
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#03045E] text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <!-- Brand -->
                <div class="col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-[#0077B6] to-[#00B4D8] rounded-lg flex items-center justify-center shadow-lg shadow-[#0077B6]/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-white">Veri<span class="text-[#48CAE4]">Cult</span></span>
                    </div>
                    <p class="text-[#90E0EF] mb-4 max-w-md">
                        Sistem Verifikasi Kebudayaan Digital yang terpercaya untuk melestarikan dan memvalidasi objek kebudayaan Indonesia.
                    </p>
                </div>

                <!-- Links -->
                <div>
                    <h3 class="text-white font-bold mb-4">Navigasi</h3>
                    <ul class="space-y-2">
                        <li><a href="#tentang" class="hover:text-[#48CAE4] transition">Tentang</a></li>
                        <li><a href="#fitur" class="hover:text-[#48CAE4] transition">Fitur</a></li>
                        <li><a href="#statistik" class="hover:text-[#48CAE4] transition">Statistik</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-[#48CAE4] transition">Login</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-white font-bold mb-4">Kontak</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[#48CAE4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            info@vericult.id
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-[#48CAE4]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            +62 21 1234 5678
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-[#023E8A] pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-[#90E0EF] text-sm mb-4 md:mb-0">
                    &copy; {{ date('Y') }} VeriCult. All rights reserved.
                </p>
                <div class="flex space-x-6">
                    <a href="#" class="text-[#90E0EF] hover:text-[#48CAE4] transition">Privacy Policy</a>
                    <a href="#" class="text-[#90E0EF] hover:text-[#48CAE4] transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
