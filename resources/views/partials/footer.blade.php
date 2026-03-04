    <footer class="bg-[#03045E] text-white pt-16 md:pt-24 pb-12 relative overflow-hidden">
        <div class="absolute inset-0" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E&quot;); opacity: 0.05;"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-16 pb-16 md:pb-20 border-b border-white/5">
                <!-- Brand -->
                <div class="lg:col-span-2">
                    <a href="{{ route('beranda') }}" class="flex items-center space-x-3 mb-8">
                        <div class="w-10 h-10 bg-gradient-to-br from-[#0077B6] to-[#00B4D8] rounded-xl flex items-center justify-center shadow-lg shadow-[#0077B6]/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-black tracking-tighter text-white">Veri<span class="text-[#48CAE4]">Cult</span></span>
                    </a>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-sm font-medium mb-8">
                        {{ $site_global['footer_description'] ?? 'Platform verifikasi digital terpercaya untuk melestarikan dan mengabsahkan kekayaan budaya Nusantara.' }}
                    </p>
                    <!-- Social Links -->
                    <div class="flex items-center space-x-4">
                        @if(!empty($site_global['social_ig']) && $site_global['social_ig'] !== '#')
                        <a href="{{ $site_global['social_ig'] }}" target="_blank" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center text-slate-400 hover:bg-[#E1306C] hover:text-white transition-all shadow-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.12 4.85.178 1.17.053 1.805.249 2.227.412.56.216.96.474 1.38.894.42.42.678.82 1.38.894.162.42.358 1.058.412 2.227.058 1.266.077 1.646.077 4.85s-.019 3.584-.077 4.85c-.053 1.17-.249 1.805-.412 2.227-.216.56-.474.96-.894 1.38-.42.42-.82.678-1.38.894-.42.162-1.058.358-2.227.412-1.266.058-1.646.077-4.85.077s-3.584-.019-4.85-.077c-1.17-.053-1.805-.249-2.227-.412-.56-.216-.96-.474-1.38-.894-.42-.42-.678-.82-.894-1.38-.162-.42-.358-1.058-.412-2.227-.058-1.266-.077-1.646-.077-4.85s.019-3.584.077-4.85c.053-1.17.249-1.805.412-2.227.216-.56.474-.96.894-1.38.42-.42.82-.678 1.38-.894.42-.162 1.058-.358 2.227-.412 1.266-.058 1.646-.077 4.85-.077zm0-2.163c-3.259 0-3.667.014-4.947.072-1.277.057-2.148.26-2.911.557-.788.306-1.457.715-2.122 1.38-.665.665-1.074 1.334-1.38 2.122-.296.763-.499 1.634-.557 2.911-.059 1.281-.073 1.689-.073 4.948s.014 3.667.072 4.947c.057 1.277.26 2.148.557 2.911.306.788.715 1.457 1.38 2.122.665.665 1.334 1.074 2.122 1.38.763.296 1.634.499 2.911.557 1.281.059 1.689.073 4.948.073s3.667-.014 4.947-.072c1.277-.057 2.148-.26 2.911-.557.788-.306 1.457-.715 2.122-1.38.665-.665 1.074-1.334 1.38-2.122.296-.763.499-1.634.557-2.911.059-1.281.073-1.689.073-4.948s-.014-3.667-.072-4.947c-.057-1.277-.26-2.148-.557-2.911-.306-.788-.715-1.457-1.38-2.122-.665-.665-1.334-1.074-2.122-1.38-.763-.296-1.634-.499-2.911-.557-1.281-.059-1.689-.073-4.948-.073z"/></svg>
                        </a>
                        @endif
                        @if(!empty($site_global['social_fb']) && $site_global['social_fb'] !== '#')
                        <a href="{{ $site_global['social_fb'] }}" target="_blank" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center text-slate-400 hover:bg-[#1877F2] hover:text-white transition-all shadow-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        @endif
                        @if(!empty($site_global['social_twitter']) && $site_global['social_twitter'] !== '#')
                        <a href="{{ $site_global['social_twitter'] }}" target="_blank" class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center text-slate-400 hover:bg-black hover:text-white transition-all shadow-lg border border-white/5">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Links -->
                <div>
                    <h3 class="text-[10px] md:text-xs font-black uppercase tracking-[0.3em] text-white mb-6 md:mb-8">Menu Cepat</h3>
                    <ul class="space-y-3 md:space-y-4">
                        <li><a href="{{ route('tentang') }}" class="text-xs md:text-sm font-bold text-slate-400 hover:text-[#00B4D8] transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('fitur') }}" class="text-xs md:text-sm font-bold text-slate-400 hover:text-[#00B4D8] transition-colors">Fitur Teknis</a></li>
                        <li><a href="{{ route('profil-kebudayaan.index') }}" class="text-xs md:text-sm font-bold text-slate-400 hover:text-[#00B4D8] transition-colors">Profil Budaya</a></li>
                        <li><a href="{{ route('login') }}" class="text-xs md:text-sm font-bold text-slate-400 hover:text-[#00B4D8] transition-colors">Masuk Sistem</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-[10px] md:text-xs font-black uppercase tracking-[0.3em] text-white mb-6 md:mb-8">Kontak Resmi</h3>
                    <ul class="space-y-3 md:space-y-4">
                        <li class="flex items-center text-xs md:text-sm font-bold text-slate-400 group">
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-white/5 rounded-lg md:rounded-xl flex items-center justify-center mr-3 md:mr-4 group-hover:bg-[#00B4D8]/20 group-hover:text-white transition-all">
                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            {{ $site_global['contact_email'] ?? 'official@vericult.id' }}
                        </li>
                        <li class="flex items-center text-xs md:text-sm font-bold text-slate-400 group">
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-white/5 rounded-lg md:rounded-xl flex items-center justify-center mr-3 md:mr-4 group-hover:bg-[#00B4D8]/20 group-hover:text-white transition-all shadow-lg border border-white/5">
                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            {{ $site_global['contact_phone'] ?? '+62 123 4455 6677' }}
                        </li>
                        @if(!empty($site_global['contact_wa']))
                        <li class="flex items-center text-xs md:text-sm font-bold text-slate-400 group">
                            <a href="https://wa.me/{{ $site_global['contact_wa'] }}" target="_blank" class="flex items-center">
                                <div class="w-8 h-8 md:w-10 md:h-10 bg-white/5 rounded-lg md:rounded-xl flex items-center justify-center mr-3 md:mr-4 group-hover:bg-[#25D366]/20 group-hover:text-[#25D366] transition-all shadow-lg border border-white/5">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                </div>
                                <span class="group-hover:text-white transition-colors">WhatsApp Kami</span>
                            </a>
                        </li>
                        @endif
                        @if(!empty($site_global['contact_address']))
                        <li class="flex items-start text-xs font-bold text-slate-400 group mt-2 pt-2 border-t border-white/5">
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-white/5 rounded-lg md:rounded-xl flex items-center justify-center mr-3 md:mr-4 group-hover:bg-[#0077B6]/20 group-hover:text-white transition-all shadow-lg border border-white/5 flex-shrink-0">
                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <span class="leading-relaxed">{{ $site_global['contact_address'] }}</span>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="pt-12 flex flex-col md:flex-row justify-between items-center text-slate-500 font-black text-[9px] md:text-[10px] uppercase tracking-[0.2em]">
                <p class="mb-4 md:mb-0">&copy; {{ date('Y') }} {{ $site_global['site_name'] ?? 'VeriCult' }} Platform. All rights reserved.</p>
                <div class="flex space-x-6 md:space-x-10 mt-2 md:mt-0">
                    <a href="#" class="hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="hover:text-white transition-colors">Terms</a>
                    <a href="#" class="hover:text-white transition-colors">Security</a>
                </div>
            </div>
        </div>
    </footer>
