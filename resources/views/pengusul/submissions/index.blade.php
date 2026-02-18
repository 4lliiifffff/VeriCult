@extends('layouts.pengusul')

@section('content')
<div class="py-10 bg-[#F8FAFC] min-h-screen font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('pengusul.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Pengajuan Saya</span>
        </nav>

        <!-- Premium Header Area -->
        <div class="relative">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 relative z-10">
                <div class="space-y-2">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#03045E]/5 border border-[#03045E]/10 underline-none">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#0077B6] opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-[#0077B6]"></span>
                        </span>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#03045E]">Dashboard Pengusul</span>
                    </div>
                    <h2 class="font-extrabold text-4xl text-[#03045E] leading-tight tracking-tight">
                        Daftar <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#0077B6] to-[#00B4D8]">Pengajuan</span>
                    </h2>
                    <p class="text-slate-500 font-medium max-w-2xl">
                        Pantau dan kelola seluruh inventarisasi data kebudayaan Anda dalam satu dasbor terpadu.
                    </p>
                </div>
                
                <div class="flex items-center gap-3">
                    <a href="{{ route('pengusul.submissions.create') }}" 
                       class="group inline-flex items-center px-6 py-3.5 bg-[#03045E] text-white font-bold rounded-2xl shadow-xl shadow-[#03045E]/20 hover:bg-[#023A8A] hover:-translate-y-0.5 transition-all duration-300">
                        <div class="mr-2.5 p-1 bg-white/10 rounded-lg group-hover:rotate-90 transition-transform duration-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <span class="tracking-wide">Buat Pengajuan Baru</span>
                    </a>
                </div>
            </div>
            <!-- Decorative backdrop element -->
            <div class="absolute -top-10 -left-10 w-64 h-64 bg-[#0077B6]/5 rounded-full blur-3xl -z-0"></div>
        </div>

        <!-- Stats Overview (Optional but adds premium feel) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-blue-50 text-[#0077B6] rounded-2xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pengajuan</p>
                        <p class="text-2xl font-black text-[#03045E]">{{ $submissions->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Draft & Revisi</p>
                        <p class="text-2xl font-black text-[#03045E]">{{ $submissions->filter(fn($s) => $s->isEditable())->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Telah Diverifikasi</p>
                        <p class="text-2xl font-black text-[#03045E]">{{ $submissions->where('status', \App\Models\CulturalSubmission::STATUS_VERIFIED)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submissions Central Card -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden relative group">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                <h3 class="font-bold text-xl text-[#03045E]">Riwayat Pengajuan</h3>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Update Real-time</span>
                </div>
            </div>

            <div class="overflow-x-auto px-4 pb-4">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.15em]">
                            <th class="px-6 py-5">Informasi Pengajuan</th>
                            <th class="px-6 py-5">Kategori</th>
                            <th class="px-6 py-5 text-center">Status</th>
                            <th class="px-6 py-5 text-center">Tgl. Dibuat</th>
                            <th class="px-6 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100/60">
                        @forelse($submissions as $submission)
                        <tr class="hover:bg-slate-50/80 transition-all duration-300 group/row">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-500 group-hover/row:scale-110 transition-transform duration-300 font-bold text-sm">
                                        {{ substr($submission->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-[15px] text-[#03045E] group-hover/row:text-[#0077B6] transition-colors line-clamp-1">{{ $submission->name }}</div>
                                        <div class="text-xs text-slate-400 font-medium flex items-center gap-1 mt-0.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                            <span class="truncate max-w-[180px]">{{ $submission->address }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-3 py-1.5 rounded-xl bg-slate-100 text-[#03045E] text-[11px] font-bold tracking-wide">
                                    {{ $submission->category }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                @php
                                    $colors = [
                                        'gray' => 'bg-slate-100 text-slate-600 border-slate-200',
                                        'blue' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'amber' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'indigo' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                        'emerald' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'green' => 'bg-green-50 text-green-600 border-green-100',
                                        'red' => 'bg-red-50 text-red-600 border-red-100',
                                    ];
                                    $colorClass = $colors[$submission->status_color] ?? $colors['gray'];
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $colorClass }} border shadow-sm">
                                    {{ $submission->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center text-[13px] font-medium text-slate-500">
                                {{ $submission->created_at->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('pengusul.submissions.show', $submission) }}" 
                                       class="group/btn p-2 rounded-xl bg-slate-50 text-slate-400 hover:bg-[#0077B6] hover:text-white transition-all duration-300"
                                       title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    @if($submission->isEditable())
                                    <a href="{{ route('pengusul.submissions.edit', $submission) }}" 
                                       class="group/btn p-2 rounded-xl bg-slate-50 text-slate-400 hover:bg-amber-500 hover:text-white transition-all duration-300"
                                       title="Edit Pengajuan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-32 text-center">
                                <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                    <div class="w-32 h-32 bg-[#0077B6]/5 rounded-[2.5rem] flex items-center justify-center mb-8 relative">
                                        <svg class="w-16 h-16 text-[#0077B6]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <div class="absolute inset-0 border-2 border-dashed border-[#0077B6]/20 rounded-[2.5rem] animate-pulse"></div>
                                    </div>
                                    <h4 class="text-2xl font-black text-[#03045E] mb-2 tracking-tight">Belum Ada Pengajuan</h4>
                                    <p class="text-slate-400 text-sm font-medium mb-10 leading-relaxed">
                                        Sepertinya Anda belum memiliki riwayat pengajuan data kebudayaan. Mari buat pengajuan pertama Anda sekarang!
                                    </p>
                                    <a href="{{ route('pengusul.submissions.create') }}" 
                                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-[#0077B6] to-[#00B4D8] text-white text-sm font-black rounded-2xl shadow-xl shadow-[#0077B6]/20 border-b-4 border-[#023A8A] hover:scale-105 active:scale-95 transition-all">
                                        <svg class="w-5 h-5 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                        Mulai Pengajuan Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($submissions->hasPages())
            <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
                <div class="flex flex-col items-center justify-center">
                    {{ $submissions->links() }}
                </div>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
