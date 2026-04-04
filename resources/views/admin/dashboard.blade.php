<x-layouts.admin>
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-black text-[#03045E] tracking-tight">Dashboard Admin</h1>
                <p class="text-slate-500 text-sm font-medium">Selamat datang kembali! Berikut ringkasan aktivitas verifikasi hari ini.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-white rounded-2xl border border-slate-200 text-xs font-bold text-[#03045E] shadow-sm">
                    {{ now()->format('d F Y') }}
                </span>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Pending Users -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm overflow-hidden relative group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-[#0077B6] mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div class="text-3xl font-black text-[#03045E] mb-1">{{ $pendingApprovalsCount }}</div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Menunggu Persetujuan Akun</div>
                </div>
            </div>

            <!-- Pending Publication -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm overflow-hidden relative group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-cyan-100 rounded-2xl flex items-center justify-center text-[#00B4D8] mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div class="text-3xl font-black text-[#03045E] mb-1">{{ $pendingPublicationCount }}</div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Laporan Siap Publikasi</div>
                </div>
            </div>

            <!-- Total Statistik -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm lg:col-span-1 overflow-hidden relative group">
                 <div class="absolute top-0 right-0 w-32 h-32 bg-slate-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                 <div class="relative z-10">
                    <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-600 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    </div>
                    <div class="text-3xl font-black text-[#03045E] mb-1">{{ array_sum($categoryStats) }}</div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Data Statistik</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Pending Users -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="text-xs font-black text-[#03045E] uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        Persetujuan Akun Terbaru
                    </h3>
                    <a href="{{ route('admin.user-approvals.index') }}" class="text-[10px] font-black text-[#0077B6] uppercase tracking-widest hover:underline">Lihat Semua</a>
                </div>
                <div class="flex-1">
                    @forelse($recentPendingUsers as $user)
                        <div class="p-4 border-b border-slate-50 last:border-0 hover:bg-slate-50 transition-colors flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-[#0077B6] font-black text-xs">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-[#03045E] leading-none mb-1">{{ $user->name }}</p>
                                    <p class="text-[10px] text-slate-500 font-medium">{{ $user->profile?->village?->name ?? 'Desa Tidak Diketahui' }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.user-approvals.index') }}" class="px-3 py-1.5 bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest rounded-lg hover:bg-blue-700 transition-colors">
                                Review
                            </a>
                        </div>
                    @empty
                        <div class="p-12 text-center text-slate-400 italic text-sm">
                            Tidak ada antrean persetujuan.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Submissions -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="text-xs font-black text-[#03045E] uppercase tracking-widest flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                        Pengajuan Statistik Terbaru
                    </h3>
                    <a href="{{ route('admin.statistic-submissions.index') }}" class="text-[10px] font-black text-[#0077B6] uppercase tracking-widest hover:underline">Lihat Semua</a>
                </div>
                <div class="flex-1">
                    @forelse($recentStatistikalSubmissions as $submission)
                        <div class="p-4 border-b border-slate-50 last:border-0 hover:bg-slate-50 transition-colors flex items-center justify-between">
                            <div class="flex items-center gap-3 max-w-[70%]">
                                <div class="w-10 h-10 rounded-xl bg-cyan-50 flex items-center justify-center text-[#00B4D8] font-black text-xs shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div class="truncate">
                                    <p class="text-sm font-bold text-[#03045E] leading-none mb-1 truncate">{{ $submission->name }}</p>
                                    <p class="text-[10px] text-slate-500 font-medium">{{ $submission->category }} · {{ $submission->village?->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span @class([
                                    'px-2 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest',
                                    'bg-amber-100 text-amber-700' => $submission->status === \App\Models\CulturalSubmission::STATUS_VERIFIED,
                                    'bg-green-100 text-green-700' => $submission->status === \App\Models\CulturalSubmission::STATUS_PUBLISHED,
                                ])>
                                    {{ $submission->status === \App\Models\CulturalSubmission::STATUS_PUBLISHED ? 'Publik' : 'Terverifikasi' }}
                                </span>
                                <a href="{{ route('admin.statistic-submissions.show', $submission) }}" class="p-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center text-slate-400 italic text-sm">
                            Belum ada laporan statistik.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
