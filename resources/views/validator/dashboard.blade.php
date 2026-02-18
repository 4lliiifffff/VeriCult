<x-layouts.validator>
    <x-slot name="header">
        <!-- Header Section -->
        <div class="relative bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[3rem] p-12 overflow-hidden shadow-2xl shadow-blue-900/20 mb-10 group">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 rounded-full -mr-20 -mt-20 blur-3xl group-hover:bg-white/10 transition-colors duration-700"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-400/10 rounded-full -ml-32 -mb-32 blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div>
                    <div class="inline-flex items-center px-4 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] font-black uppercase tracking-[0.2em] mb-4">
                        <span class="w-2 h-2 rounded-full bg-[#00B4D8] mr-2 animate-pulse"></span>
                        Validator Portal
                    </div>
                    <h2 class="text-4xl font-black text-white tracking-tight leading-tight">
                        Dashboard <span class="text-[#00B4D8]">Validator</span>
                    </h2>
                    <p class="text-blue-100/80 mt-3 font-medium max-w-xl">
                        Selamat datang kembali, {{ explode(' ', Auth::user()->name)[0] }}. Pantau dan verifikasi pengajuan kebudayaan dengan teliti.
                    </p>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('validator.submissions.index') }}" class="bg-white text-[#03045E] px-8 py-4 rounded-[1.5rem] font-black text-xs uppercase tracking-widest hover:bg-blue-50 transition-all duration-300 shadow-xl shadow-blue-900/10 hover:-translate-y-1">
                        Mulai Review
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-10 pb-12">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <!-- Total Submitted -->
            <div class="group bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/50 border border-white hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-500 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Submitted</p>
                <h3 class="text-3xl font-black text-[#03045E] mt-1">{{ $stats['total_submitted'] }}</h3>
            </div>

            <!-- Reviewing By Me -->
            <div class="group bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/50 border border-white hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Reviewing (By Me)</p>
                <h3 class="text-3xl font-black text-[#03045E] mt-1">{{ $stats['my_reviews'] }}</h3>
            </div>

            <!-- Needs Revision -->
            <div class="group bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/50 border border-white hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-500 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Perlu Revisi</p>
                <h3 class="text-3xl font-black text-[#03045E] mt-1">{{ $stats['needs_revision'] }}</h3>
            </div>

            <!-- Forwarded -->
            <div class="group bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/50 border border-white hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Forwarded</p>
                <h3 class="text-3xl font-black text-[#03045E] mt-1">{{ $stats['forwarded'] }}</h3>
            </div>

            <!-- Rejected -->
            <div class="group bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/50 border border-white hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Rejected</p>
                <h3 class="text-3xl font-black text-[#03045E] mt-1">{{ $stats['rejected'] }}</h3>
            </div>
        </div>

        <!-- Recent Submissions Table -->
        <div class="bg-white rounded-[3rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden">
            <div class="p-10 border-b border-slate-50 overflow-x-auto whitespace-nowrap">
                <div class="flex items-center justify-between gap-4">
                    <h3 class="font-black text-xl text-[#03045E] tracking-tight">Antrian Submission Terbaru</h3>
                    <a href="{{ route('validator.submissions.index') }}" class="text-[10px] font-black text-[#0077B6] uppercase tracking-widest hover:underline">Lihat Semua</a>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50">
                            <th class="px-10 py-5">Kebudayaan</th>
                            <th class="px-10 py-5">Pengusul</th>
                            <th class="px-8 py-4 text-center">Tanggal</th>
                            <th class="px-8 py-4 text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        @forelse($recentSubmissions as $submission)
                        <tr class="group hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-5">
                                <div class="font-bold text-[#03045E] line-clamp-1">{{ $submission->name }}</div>
                                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">{{ $submission->category }}</div>
                            </td>
                            <td class="px-10 py-6">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-[10px] font-black text-slate-500 mr-3">
                                        {{ substr($submission->user->name, 0, 1) }}
                                    </div>
                                    <div class="text-xs font-bold text-[#03045E]">{{ $submission->user->name }}</div>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <div class="text-xs font-bold text-[#03045E]">{{ $submission->created_at->format('d M Y') }}</div>
                                <div class="text-[10px] font-black text-slate-400 uppercase mt-0.5">{{ $submission->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-10 py-6 text-right font-medium">
                                <a href="{{ route('validator.submissions.show', $submission) }}" class="inline-flex items-center py-2 px-4 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all group-hover:bg-[#03045E] group-hover:text-white group-hover:shadow-lg group-hover:shadow-blue-900/20 active:scale-95">
                                    Review
                                    <svg class="w-3 h-3 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-200 mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <p class="text-sm font-bold text-slate-400">Belum ada submission menunggu.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.validator>
