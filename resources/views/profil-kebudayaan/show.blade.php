<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $submission->name }} - VeriCult</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .premium-gradient {
            background: linear-gradient(135deg, #03045E 0%, #023E8A 50%, #0077B6 100%);
        }
        .premium-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body class="antialiased font-sans bg-[#F8FAFC]">
    
    <!-- Navbar (Same as index) -->
    <nav class="fixed top-0 left-0 right-0 z-50 mt-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="premium-glass rounded-[2rem] shadow-2xl py-3 px-6 flex justify-between items-center">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-[#0077B6] to-[#00B4D8] rounded-xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-all">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <span class="text-2xl font-black text-[#03045E]">Veri<span class="text-[#00B4D8]">Cult</span></span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-10 px-8">
                    <a href="/" class="text-[11px] font-black uppercase tracking-[0.2em] text-[#03045E]/60 hover:text-[#03045E]">Home</a>
                    <a href="{{ route('profil-kebudayaan.index') }}" class="text-[11px] font-black uppercase tracking-[0.2em] text-[#03045E]">Profil Budaya</a>
                </div>
                <div>
                    <a href="{{ route('profil-kebudayaan.index') }}" class="bg-[#03045E] text-white px-6 py-2.5 rounded-2xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Content -->
    <div class="lg:h-[70vh] relative overflow-hidden pt-32 lg:pt-0">
        @php $mainImage = $submission->files->first(); @endphp
        @if($mainImage)
            <img src="{{ Storage::url($mainImage->file_path) }}" alt="{{ $submission->name }}" class="hidden lg:block absolute inset-0 w-full h-full object-cover">
            <div class="hidden lg:block absolute inset-0 bg-gradient-to-r from-[#03045E] via-[#03045E]/80 to-transparent"></div>
        @else
            <div class="hidden lg:block absolute inset-0 premium-gradient"></div>
        @endif

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full relative z-10 flex flex-col justify-center">
            <div class="lg:max-w-3xl space-y-6 lg:space-y-8">
                <div class="inline-flex items-center px-4 py-1.5 bg-white/10 backdrop-blur-md rounded-full text-white text-[10px] font-black uppercase tracking-[0.3em] border border-white/20">
                    {{ $submission->category }}
                </div>
                <h1 class="text-4xl lg:text-7xl font-black text-white leading-tight tracking-tighter capitalize">
                    {{ $submission->name }}
                </h1>
                <div class="flex flex-wrap items-center gap-6 md:gap-10 text-white/70">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/10 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg></div>
                        <span class="text-sm font-bold uppercase tracking-widest">{{ $submission->address }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-white/10 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                        <span class="text-sm font-bold uppercase tracking-widest">Dipublikasi: {{ $submission->published_at->translatedFormat('d F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:-mt-20 relative z-20">
        <div class="grid lg:grid-cols-3 gap-12">
            <!-- Left Info -->
            <div class="lg:col-span-2 space-y-12">
                <!-- Narasi Section -->
                <div class="bg-white rounded-[3rem] p-8 lg:p-12 shadow-2xl shadow-slate-200/50 border border-slate-100">
                    <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] mb-10 flex items-center gap-4">
                        <span class="shrink-0">Narasi Warisan Budaya</span>
                        <div class="flex-1 h-px bg-slate-100 font-bold"></div>
                    </h2>
                    <div class="prose prose-slate max-w-none">
                        <p class="text-slate-700 text-lg lg:text-xl leading-[2] font-medium whitespace-pre-wrap">
                            {{ $submission->description }}
                        </p>
                    </div>
                </div>

                <!-- Detail Kategori Section -->
                @if(!empty($categoryFields) && !empty($submission->category_data))
                <div class="bg-white rounded-[3rem] p-8 lg:p-12 shadow-2xl shadow-slate-200/50 border border-slate-100">
                    <h2 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] mb-10 flex items-center gap-4">
                        <span class="shrink-0">Informasi Teknis {{ $submission->category }}</span>
                        <div class="flex-1 h-px bg-slate-100"></div>
                    </h2>
                    <div class="grid md:grid-cols-2 gap-10">
                        @foreach($categoryFields as $fieldKey => $field)
                            @if(!empty($submission->category_data[$fieldKey]))
                            <div class="space-y-3 {{ $field['type'] === 'textarea' ? 'md:col-span-2' : '' }}">
                                <p class="text-[10px] font-black text-[#0077B6] uppercase tracking-[0.2em]">{{ $field['label'] }}</p>
                                @if($field['type'] === 'textarea')
                                    <p class="text-slate-700 font-bold text-lg leading-relaxed italic border-l-4 border-slate-100 pl-6">"{{ $submission->category_data[$fieldKey] }}"</p>
                                @else
                                    <p class="text-[#03045E] font-black text-xl lg:text-2xl tracking-tight">{{ $submission->category_data[$fieldKey] }}</p>
                                @endif
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar / Gallery Info -->
            <div class="space-y-10">
                <!-- Gallery Sidebar -->
                <div class="bg-white rounded-[3rem] p-8 lg:p-10 shadow-2xl shadow-slate-200/50 border border-slate-100">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-8">Dokumentasi Visual</h3>
                    <div class="space-y-6">
                        @foreach($submission->files as $file)
                        <div class="group relative rounded-3xl overflow-hidden aspect-[4/3] border border-slate-100 hover:scale-[1.02] transition-transform duration-500">
                            <img src="{{ Storage::url($file->file_path) }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-[#03045E]/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="px-6 py-2 bg-white text-[#03045E] rounded-full text-[10px] font-black uppercase tracking-widest">Zoom</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Verification Info -->
                <div class="bg-gradient-to-br from-[#03045E] to-[#0077B6] rounded-[3rem] p-10 text-white shadow-2xl shadow-blue-900/30 overflow-hidden relative">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h4 class="text-xl font-black mb-2 uppercase tracking-tight">Terverifikasi Resmi</h4>
                        <p class="text-white/70 text-sm font-medium leading-relaxed">Objek budaya ini telah melalui proses verifikasi lapangan dan verifikasi administratif oleh VeriCult.</p>
                        <div class="mt-8 pt-8 border-t border-white/10">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center font-black text-xs">SA</div>
                                <div>
                                    <p class="text-[10px] font-bold text-white/50 uppercase tracking-widest">Sertifikasi Oleh</p>
                                    <p class="text-xs font-black uppercase tracking-widest">VeriCult Validator Team</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer (Simplified) -->
    <footer class="bg-[#03045E] text-white py-12 text-center">
        <p class="text-slate-400 text-xs font-black uppercase tracking-[0.3em]">&copy; {{ date('Y') }} VeriCult Platform. Melestarikan Budaya Digital.</p>
    </footer>

</body>
</html>
