<x-layouts.admin>
    <x-slot name="header">
        <div class="relative bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-8 shadow-2xl shadow-blue-900/20 mb-8">
            <div class="absolute inset-0 overflow-hidden rounded-[2rem] pointer-events-none">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            </div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-1">
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.2em] uppercase bg-white/10 text-white border border-white/20 backdrop-blur-xl">
                            Admin Wilayah
                        </span>
                    </div>
                    <h2 class="text-3xl font-black text-white tracking-tight leading-tight">
                        Dashboard <span class="text-[#00B4D8]">Verifikasi</span>
                    </h2>
                    <p class="text-blue-100/70 text-sm font-medium">Selamat datang kembali! Pantau dan validasi data kebudayaan wilayah Anda.</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-6 py-3 bg-white/10 backdrop-blur-xl rounded-2xl border border-white/20 text-xs font-black text-white shadow-inner uppercase tracking-widest">
                        {{ now()->format('d F Y') }}
                    </span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-10 pb-12">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Pending Users -->
            <div class="group bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/40 border border-white hover:shadow-2xl hover:shadow-blue-900/10 hover:-translate-y-1.5 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-gradient-to-br from-[#0077B6]/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-[#0077B6] group-hover:bg-[#0077B6] group-hover:text-white transition-all duration-500 shadow-inner mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Persetujuan Akun</p>
                        <h3 class="text-4xl font-black text-[#03045E] tabular-nums tracking-tight">{{ number_format($pendingApprovalsCount) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Pending Publication -->
            <div class="group bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/40 border border-white hover:shadow-2xl hover:shadow-cyan-900/10 hover:-translate-y-1.5 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-gradient-to-br from-[#00B4D8]/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <div class="w-14 h-14 rounded-2xl bg-cyan-50 flex items-center justify-center text-[#00B4D8] group-hover:bg-[#00B4D8] group-hover:text-white transition-all duration-500 shadow-inner mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Siap Publikasi</p>
                        <h3 class="text-4xl font-black text-[#03045E] tabular-nums tracking-tight">{{ number_format($pendingPublicationCount) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Total Statistik -->
            <div class="group bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/40 border border-white hover:shadow-2xl hover:shadow-slate-900/10 hover:-translate-y-1.5 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-gradient-to-br from-slate-500/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-600 group-hover:bg-slate-600 group-hover:text-white transition-all duration-500 shadow-inner mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Statistik</p>
                        <h3 class="text-4xl font-black text-[#03045E] tabular-nums tracking-tight">{{ number_format(array_sum($categoryStats)) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Pending Users -->
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-white overflow-hidden flex flex-col group">
                <div class="p-8 border-b border-slate-50 flex items-center justify-between bg-white relative overflow-hidden">
                    <div class="absolute top-0 left-0 -mt-6 -ml-6 w-24 h-24 bg-blue-50/50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-1000"></div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-black text-[#03045E]">Persetujuan Akun</h3>
                        <p class="text-slate-400 font-medium text-xs mt-1">Antrean registrasi pengusul desa terbaru.</p>
                    </div>
                    <a href="{{ route('admin.user-approvals.index') }}" class="relative z-10 px-6 py-3 rounded-2xl bg-slate-50 border-2 border-slate-100 text-[#03045E] font-black text-[10px] tracking-widest uppercase hover:bg-white hover:border-[#0077B6] hover:text-[#0077B6] transition-all group/btn">
                        Semua
                        <svg class="w-4 h-4 inline ml-1 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                </div>
                <div class="flex-1">
                    @forelse($recentPendingUsers as $user)
                        <div class="p-6 border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition-colors flex items-center justify-between group/row">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#0077B6] to-[#00B4D8] text-white flex items-center justify-center font-black text-sm shadow-lg shadow-blue-900/10 group-hover/row:scale-110 transition-transform">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-[#03045E] leading-none mb-1 group-hover/row:text-[#0077B6] transition-colors">{{ $user->name }}</p>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $user->profile?->village?->name ?? 'Desa Tidak Diketahui' }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.user-approvals.index') }}" class="px-5 py-2.5 bg-[#03045E] text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-[#023E8A] hover:shadow-lg hover:shadow-blue-900/20 active:scale-95 transition-all">
                                Review
                            </a>
                        </div>
                    @empty
                        <div class="p-20 text-center flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-200 mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <p class="text-slate-400 font-bold italic text-sm tracking-widest uppercase">Sistem sedang tenang</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Submissions -->
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-white overflow-hidden flex flex-col group">
                <div class="p-8 border-b border-slate-50 flex items-center justify-between bg-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-6 -mr-6 w-24 h-24 bg-cyan-50/50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-1000"></div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-black text-[#03045E]">Laporan Statistik</h3>
                        <p class="text-slate-400 font-medium text-xs mt-1">Data statistik terbaru yang siap diverifikasi.</p>
                    </div>
                    <a href="{{ route('admin.statistic-submissions.index') }}" class="relative z-10 px-6 py-3 rounded-2xl bg-slate-50 border-2 border-slate-100 text-[#03045E] font-black text-[10px] tracking-widest uppercase hover:bg-white hover:border-[#0077B6] hover:text-[#0077B6] transition-all group/btn">
                        Semua
                        <svg class="w-4 h-4 inline ml-1 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                </div>
                <div class="flex-1">
                    @forelse($recentStatistikalSubmissions as $submission)
                        <div class="p-6 border-b border-slate-50 last:border-0 hover:bg-slate-50/50 transition-colors flex items-center justify-between group/row">
                            <div class="flex items-center gap-4 max-w-[70%]">
                                <div class="w-12 h-12 rounded-2xl bg-cyan-50 flex items-center justify-center text-[#00B4D8] shrink-0 shadow-inner group-hover/row:bg-[#00B4D8] group-hover/row:text-white transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div class="truncate">
                                    <p class="text-sm font-bold text-[#03045E] leading-none mb-1 truncate group-hover/row:text-[#00B4D8] transition-colors">{{ $submission->name }}</p>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $submission->category }} · {{ $submission->village?->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <span @class([
                                    'px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest shadow-sm',
                                    'bg-amber-100 text-amber-700 border border-amber-200' => $submission->status === \App\Models\CulturalSubmission::STATUS_VERIFIED,
                                    'bg-green-100 text-green-700 border border-green-200' => $submission->status === \App\Models\CulturalSubmission::STATUS_PUBLISHED,
                                ])>
                                    {{ $submission->status === \App\Models\CulturalSubmission::STATUS_PUBLISHED ? 'Publik' : 'Valid' }}
                                </span>
                                <a href="{{ route('admin.statistic-submissions.show', $submission) }}" class="p-3 bg-slate-100 text-slate-600 rounded-xl hover:bg-[#03045E] hover:text-white active:scale-95 transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-20 text-center flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-200 mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <p class="text-slate-400 font-bold italic text-sm tracking-widest uppercase">Belum ada laporan</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
