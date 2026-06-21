<footer class="bg-white border-t border-slate-100 pt-12 sm:pt-20 pb-8 sm:pb-12 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 sm:gap-12 pb-12 sm:pb-16">
            <!-- Brand -->
            <div class="sm:col-span-2">
                <a href="{{ route('beranda') }}" class="flex items-center space-x-3 mb-6">
                    <!-- <div class="flex items-center justify-center">
                            <img class="w-8 h-9" src="{{ asset('Logo/Dinas/Logo-Dinas.png') }}" alt="Logo VeriCult">
                        </div> -->

                    <img class="w-8 h-9" src="{{ asset('Logo/Dinas/Logo-Dinas.png') }}?v=1.1" alt="Logo VeriCult"
                        fetchpriority="high">
                    <span class="text-xl font-bold tracking-tight text-brand-dark">Veri<span
                            class="text-brand-primary">Cult</span></span>
                </a>

                <!-- <a href="{{ route('beranda') }}" class="flex items-center space-x-3 mb-6">
                        <div class="w-8 h-8 bg-brand-dark rounded-lg flex items-center justify-center shadow-md">
                            <img class="w-5 h-5" src="{{ asset('Logo/Putih/Logo-Sistem-W.png') }}" alt="Logo VeriCult">
                            </div>
                        <span class="text-xl font-bold tracking-tight text-brand-dark">Veri<span class="text-brand-primary">Cult</span></span>
                    </a> -->
                <p class="text-slate-600 text-sm leading-relaxed max-w-sm mb-6 sm:mb-8">
                    {{ $site_global['footer_description'] ?? 'Platform verifikasi digital terpercaya untuk melestarikan dan mengabsahkan kekayaan budaya Nusantara.' }}
                </p>
                <!-- Social Links -->
                <div class="flex items-center space-x-4">
                    @if(!empty($site_global['social_ig']) && $site_global['social_ig'] !== '#')
                        <a href="{{ $site_global['social_ig'] }}" target="_blank"
                            class="text-slate-600 hover:text-[#E1306C] transition-colors" aria-label="Instagram">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                            </svg>
                        </a>
                    @endif
                    @if(!empty($site_global['social_fb']) && $site_global['social_fb'] !== '#')
                        <a href="{{ $site_global['social_fb'] }}" target="_blank"
                            class="text-slate-600 hover:text-[#1877F2] transition-colors" aria-label="Facebook">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                            </svg>
                        </a>
                    @endif
                    @if(!empty($site_global['social_twitter']) && $site_global['social_twitter'] !== '#')
                        <a href="{{ $site_global['social_twitter'] }}" target="_blank"
                            class="text-slate-600 hover:text-[#03045E] transition-colors" aria-label="Twitter">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Links -->
            <div>
                <h3 class="text-sm font-bold text-[#03045E] mb-6">Navigasi</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('tentang') }}"
                            class="text-sm text-slate-600 hover:text-[#03045E] transition-colors">Tentang Kami</a></li>
                    <li><a href="{{ route('fitur') }}"
                            class="text-sm text-slate-600 hover:text-[#03045E] transition-colors">Fitur Sistem</a></li>
                    <li><a href="{{ route('edukasi') }}"
                            class="text-sm text-slate-600 hover:text-[#03045E] transition-colors">Edukasi</a></li>
                    <li><a href="{{ route('profil-kebudayaan.index') }}"
                            class="text-sm text-slate-600 hover:text-[#03045E] transition-colors">Profil Budaya</a></li>
                    <li><a href="{{ route('kebudayaan-aktif.index') }}"
                            class="text-sm text-slate-600 hover:text-[#03045E] transition-colors">Aktivitas
                            Kebudayaan</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div>
                <h3 class="text-sm font-bold text-[#03045E] mb-6">Bantuan</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('login') }}"
                            class="text-sm text-slate-600 hover:text-[#03045E] transition-colors">Masuk</a></li>
                    <li><a href="{{ route('register') }}"
                            class="text-sm text-slate-600 hover:text-[#03045E] transition-colors">Daftar Akun</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-sm font-bold text-[#03045E] mb-6">Kontak</h3>
                <ul class="space-y-3 text-sm text-slate-600">
                    <li class="flex items-center gap-3 text-slate-600 hover:text-[#03045E] transition-colors">
                        <div class="w-5 h-5 flex-shrink-0">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <span class="truncate">{{ $site_global['contact_email'] ?? 'official@vericult.id' }}</span>
                    </li>
                    <li class="flex items-center gap-3 text-slate-600 hover:text-[#03045E] transition-colors">
                        <div class="w-5 h-5">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <span>{{ $site_global['contact_phone'] ?? '+62 123 4455' }}</span>
                    </li>
                    @if(!empty($site_global['contact_wa']))
                        <li class="flex items-center gap-3 text-slate-600 hover:text-[#03045E] transition-colors">
                            <div class="w-5 h-5 flex-shrink-0">
                                <svg fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z">
                                    </path>
                                </svg>
                            </div>
                            <a href="https://wa.me/{{ $site_global['contact_wa'] }}" target="_blank">WhatsApp Kami</a>
                        </li>
                    @endif
                    @if(!empty($site_global['contact_address']))
                        <li class="flex items-start gap-3 text-slate-600 hover:text-[#03045E] transition-colors">
                            <div class="w-5 h-5 flex-shrink-0 mt-0.5">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                </svg>
                            </div>
                            <span class="leading-relaxed">{{ $site_global['contact_address'] }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div
            class="pt-8 border-t border-slate-50 flex flex-col md:flex-row justify-between items-center text-slate-600 text-[10px] sm:text-xs text-center md:text-left space-y-4 md:space-y-0">
            <p>&copy; {{ date('Y') }} {{ $site_global['site_name'] ?? 'VeriCult' }}.</p>
            <div class="flex space-x-6">
                <!-- <a href="#" class="hover:text-[#0077B6] transition-colors">Privasi</a>
                    <a href="#" class="hover:text-[#0077B6] transition-colors">Ketentuan</a> -->
            </div>
        </div>
    </div>
</footer>
