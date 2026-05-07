<x-layouts.admin>
    <x-slot name="header">
        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden group">
            <!-- Subtle Background Pattern -->
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full blur-3xl transition-transform duration-1000 group-hover:scale-110"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6 sm:gap-8">
                <div class="space-y-2 sm:space-y-3">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="px-3 sm:px-4 py-1 sm:py-1.5 rounded-full text-[8px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-[#03045E] text-white shadow-lg shadow-blue-900/20">
                            Admin Wilayah
                        </div>
                        <div class="h-3 sm:h-4 w-[1px] bg-slate-200"></div>
                        <span class="text-slate-400 text-[8px] sm:text-[10px] font-bold uppercase tracking-widest">Sistem Verifikasi</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black text-[#03045E] tracking-tight leading-tight">
                        Dashboard <span class="text-[#0077B6]">Verifikasi</span>
                    </h2>
                    <p class="text-slate-500 text-sm sm:text-lg font-medium max-w-2xl leading-relaxed">Pantau aktivitas registrasi wilayah dan validasi laporan objek pemajuan kebudayaan.</p>
                </div>
                
                <!-- <div class="bg-slate-50 px-6 sm:px-8 py-4 sm:py-5 rounded-[1.5rem] sm:rounded-[2rem] border border-slate-100 shadow-inner relative z-20 self-start md:self-auto">
                    <p class="text-[8px] sm:text-[9px] font-black text-[#0077B6] uppercase tracking-[0.2em] mb-1">Periode Aktif</p>
                    <div class="flex items-center gap-2 sm:gap-3">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#03045E]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-[#03045E] font-black text-base sm:text-lg tracking-tight">{{ now()->translatedFormat('d M Y') }}</span>
                    </div>
                </div> -->
            </div>
        </div>
    </x-slot>

    <div class="space-y-6 sm:space-y-10 pb-12">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Persetujuan Akun -->
            <div class="group bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-8 shadow-xl shadow-slate-200/30 border border-white hover:shadow-2xl hover:shadow-blue-900/10 hover:-translate-y-1.5 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-blue-50 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-[#03045E] group-hover:bg-[#03045E] group-hover:text-white transition-all duration-500 shadow-inner mb-4 sm:mb-6">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <p class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Persetujuan Akun</p>
                    <h3 class="text-3xl sm:text-4xl font-black text-[#03045E] tabular-nums tracking-tight">{{ number_format($pendingApprovalsCount) }}</h3>
                </div>
            </div>

            <!-- Siap Publikasi -->
            <div class="group bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-8 shadow-xl shadow-slate-200/30 border border-white hover:shadow-2xl hover:shadow-cyan-900/10 hover:-translate-y-1.5 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-cyan-50 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-[#00B4D8] group-hover:bg-[#00B4D8] group-hover:text-white transition-all duration-500 shadow-inner mb-4 sm:mb-6">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <p class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Siap Publikasi</p>
                    <h3 class="text-3xl sm:text-4xl font-black text-[#03045E] tabular-nums tracking-tight">{{ number_format($pendingPublicationCount) }}</h3>
                </div>
            </div>

            <!-- Total OPK -->
            <div class="group bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-8 shadow-xl shadow-slate-200/30 border border-white hover:shadow-2xl hover:shadow-slate-900/10 hover:-translate-y-1.5 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-slate-50 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-600 group-hover:bg-slate-600 group-hover:text-white transition-all duration-500 shadow-inner mb-4 sm:mb-6">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    </div>
                    <p class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total OPK Wilayah</p>
                    <h3 class="text-3xl sm:text-4xl font-black text-[#03045E] tabular-nums tracking-tight">{{ number_format(array_sum($categoryStats)) }}</h3>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
            <!-- Recent Pending Users -->
            <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white overflow-hidden flex flex-col group">
                <div class="p-6 sm:p-8 border-b border-slate-50 flex items-center justify-between bg-white relative overflow-hidden">
                    <div class="absolute top-0 left-0 -mt-6 -ml-6 w-24 h-24 bg-blue-50/50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-1000"></div>
                    <div class="relative z-10">
                        <h3 class="text-lg sm:text-xl font-black text-[#03045E]">Persetujuan Akun</h3>
                        <p class="text-slate-400 font-medium text-[10px] sm:text-xs mt-1">Antrean registrasi pengusul desa.</p>
                    </div>
                    <a href="{{ route('admin.user-approvals.index') }}" class="relative z-10 px-4 sm:px-6 py-2 sm:py-3 rounded-2xl bg-slate-50 border-2 border-slate-100 text-[#03045E] font-black text-[8px] sm:text-[10px] tracking-widest uppercase hover:bg-white hover:border-[#0077B6] hover:text-[#0077B6] transition-all group/btn">
                        Semua
                    </a>
                </div>
                <div class="flex-1 divide-y divide-slate-50">
                    @forelse($recentPendingUsers as $user)
                        <div class="p-5 sm:p-6 hover:bg-slate-50/50 transition-colors flex items-center justify-between group/row">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-br from-[#03045E] to-[#0077B6] text-white flex items-center justify-center font-black text-xs sm:text-sm shadow-lg shadow-blue-900/10 group-hover/row:scale-110 transition-transform">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                                <div class="max-w-[120px] sm:max-w-[200px]">
                                    <p class="text-xs sm:text-sm font-bold text-[#03045E] leading-none mb-1 truncate group-hover/row:text-[#0077B6] transition-colors">{{ $user->name }}</p>
                                    <p class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest truncate">{{ $user->profile?->village?->name ?? 'Desa' }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.user-approvals.index') }}" class="px-4 sm:px-5 py-2 sm:py-2.5 bg-[#03045E] text-white text-[8px] sm:text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-[#00B4D8] hover:shadow-lg hover:shadow-blue-900/20 active:scale-95 transition-all">
                                Review
                            </a>
                        </div>
                    @empty
                        <div class="p-20 text-center flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 mb-4 shadow-inner">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <p class="text-slate-400 font-black text-[10px] tracking-[0.2em] uppercase">Semua Akun Beres</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Submissions -->
            <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white overflow-hidden flex flex-col group">
                <div class="p-6 sm:p-8 border-b border-slate-50 flex items-center justify-between bg-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-6 -mr-6 w-24 h-24 bg-cyan-50/50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-1000"></div>
                    <div class="relative z-10">
                        <h3 class="text-lg sm:text-xl font-black text-[#03045E]">Laporan OPK</h3>
                        <p class="text-slate-400 font-medium text-[10px] sm:text-xs mt-1">Data wilayah siap publikasi.</p>
                    </div>
                    <a href="{{ route('admin.opk-submissions.index') }}" class="relative z-10 px-4 sm:px-6 py-2 sm:py-3 rounded-2xl bg-slate-50 border-2 border-slate-100 text-[#03045E] font-black text-[8px] sm:text-[10px] tracking-widest uppercase hover:bg-white hover:border-[#0077B6] hover:text-[#0077B6] transition-all group/btn">
                        Semua
                    </a>
                </div>
                <div class="flex-1 divide-y divide-slate-50">
                    @forelse($recentOPKSubmissions as $submission)
                        <div class="p-5 sm:p-6 hover:bg-slate-50/50 transition-colors flex items-center justify-between group/row">
                            <div class="flex items-center gap-3 sm:gap-4 max-w-[60%] sm:max-w-[70%]">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-slate-50 flex items-center justify-center text-[#00B4D8] shrink-0 shadow-inner group-hover/row:bg-[#00B4D8] group-hover/row:text-white transition-all">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div class="truncate">
                                    <p class="text-xs sm:text-sm font-bold text-[#03045E] leading-none mb-1 truncate group-hover/row:text-[#00B4D8] transition-colors">{{ $submission->name }}</p>
                                    <p class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest truncate">{{ $submission->category }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 sm:gap-4">
                                <span @class([
                                    'px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-xl text-[7px] sm:text-[8px] font-black uppercase tracking-widest shadow-sm',
                                    'bg-amber-50 text-amber-600 border border-amber-100' => $submission->status === \App\Models\CulturalSubmission::STATUS_VERIFIED,
                                    'bg-emerald-50 text-emerald-600 border border-emerald-100' => $submission->status === \App\Models\CulturalSubmission::STATUS_PUBLISHED,
                                ])>
                                    {{ $submission->status === \App\Models\CulturalSubmission::STATUS_PUBLISHED ? 'Publik' : 'Valid' }}
                                </span>
                                <a href="{{ route('admin.opk-submissions.show', $submission) }}" class="p-2 sm:p-2.5 bg-slate-50 text-slate-400 rounded-xl hover:bg-[#03045E] hover:text-white active:scale-95 transition-all border border-slate-100 shadow-sm">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-20 text-center flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 mb-4 shadow-inner">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <p class="text-slate-400 font-black text-[10px] tracking-[0.2em] uppercase">Belum ada laporan</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
