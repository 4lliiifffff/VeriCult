<x-layouts.pengusul>
    <x-slot name="header">
        <div class="relative bg-white rounded-[2.5rem] p-10 shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden group">
            <!-- Subtle Background Pattern -->
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full blur-3xl transition-transform duration-1000 group-hover:scale-110"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.2em] uppercase bg-[#03045E] text-white shadow-lg shadow-blue-900/20">
                            Pengusul Umum
                        </div>
                        <div class="h-4 w-[1px] bg-slate-200"></div>
                        <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Portal Partisipasi</span>
                    </div>
                    <h2 class="text-4xl sm:text-5xl font-black text-[#03045E] tracking-tight leading-tight">
                        Dashboard <span class="text-[#0077B6]">Pengusul</span>
                    </h2>
                    <p class="text-slate-500 text-lg font-medium max-w-2xl leading-relaxed">
                        Selamat datang, {{ explode(' ', Auth::user()->name)[0] }}. Sampaikan laporan kebudayaan aktif dan berkontribusi dalam pemajuan kebudayaan daerah.
                    </p>
                </div>
                
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 bg-slate-50 p-6 rounded-[2rem] border border-slate-100 shadow-inner relative z-20">
                    <a href="{{ route('pengusul.submissions.create-form', 'laporan-kebudayaan-aktif') }}" class="inline-flex items-center justify-center px-8 py-4 bg-[#03045E] text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-[#0077B6] transition-all shadow-lg shadow-blue-900/20 active:scale-95 gap-2 group/btn">
                        <svg class="w-4 h-4 group-hover/btn:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        Buat Laporan Baru
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-10 pb-12">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            @php
                $statItems = [
                    ['key' => 'totalSubmissions', 'label' => 'Total Usulan', 'color' => 'blue', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>'],
                    ['key' => 'draftCount', 'label' => 'Draft', 'color' => 'slate', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>'],
                    ['key' => 'inReviewCount', 'label' => 'In Review', 'color' => 'amber', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>'],
                    ['key' => 'publishedCount', 'label' => 'Published', 'color' => 'emerald', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'],
                    ['key' => 'rejectedCount', 'label' => 'Ditolak', 'color' => 'rose', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'],
                ];
            @endphp

            @foreach($statItems as $item)
            <div class="group bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/30 border border-white hover:shadow-2xl hover:-translate-y-1 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-24 h-24 bg-slate-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10">
                    <div @class([
                        'w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-500 mb-4',
                        'bg-blue-50 text-[#0077B6]' => $item['color'] == 'blue',
                        'bg-slate-50 text-slate-400' => $item['color'] == 'slate',
                        'bg-amber-50 text-amber-500' => $item['color'] == 'amber',
                        'bg-emerald-50 text-emerald-500' => $item['color'] == 'emerald',
                        'bg-rose-50 text-rose-500' => $item['color'] == 'rose',
                    ])>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $item['icon'] !!}</svg>
                    </div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $item['label'] }}</p>
                    <h3 class="text-3xl font-black text-[#03045E] mt-1 tabular-nums tracking-tight">{{ number_format(${ $item['key'] }) }}</h3>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Recent Submissions Table -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white overflow-hidden group">
            <div class="p-8 sm:p-10 border-b border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-xl sm:text-2xl font-black text-[#03045E]">Riwayat Usulan</h3>
                    <p class="text-slate-400 font-medium text-xs mt-1">Status 5 pengajuan terbaru yang Anda sampaikan.</p>
                </div>
                <a href="{{ route('pengusul.submissions.index') }}" class="px-6 py-3 rounded-2xl bg-slate-50 border-2 border-slate-100 text-[#03045E] font-black text-[10px] tracking-widest uppercase hover:bg-white hover:border-[#0077B6] hover:text-[#0077B6] transition-all">
                    Lihat Semua &rarr;
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-max">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                            <th class="px-10 py-6">Nama Pengajuan</th>
                            <th class="px-10 py-6">Kategori</th>
                            <th class="px-10 py-6 text-center">Status</th>
                            <th class="px-10 py-6 text-right">Tanggal Diajukan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentSubmissions as $submission)
                        <tr class="hover:bg-slate-50/50 transition-colors group/row">
                            <td class="px-10 py-6">
                                <a href="{{ route('pengusul.submissions.show', $submission) }}" class="font-bold text-sm text-[#03045E] group-hover/row:text-[#0077B6] transition-colors block">{{ $submission->name }}</a>
                            </td>
                            <td class="px-10 py-6">
                                <div class="inline-flex px-3 py-1 bg-slate-50 text-slate-500 text-[10px] font-black uppercase tracking-widest rounded-lg border border-slate-100">{{ $submission->category }}</div>
                            </td>
                            <td class="px-10 py-6 text-center">
                                <span @class([
                                    'inline-flex items-center px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest shadow-sm border',
                                    'bg-slate-50 text-slate-500 border-slate-100' => $submission->status === \App\Models\CulturalSubmission::STATUS_DRAFT,
                                    'bg-blue-50 text-[#0077B6] border-blue-100' => $submission->status === \App\Models\CulturalSubmission::STATUS_SUBMITTED,
                                    'bg-amber-50 text-amber-600 border-amber-100' => $submission->status === \App\Models\CulturalSubmission::STATUS_VERIFIED,
                                    'bg-emerald-50 text-emerald-600 border-emerald-100' => $submission->status === \App\Models\CulturalSubmission::STATUS_PUBLISHED,
                                    'bg-rose-50 text-rose-500 border-rose-100' => in_array($submission->status, [\App\Models\CulturalSubmission::STATUS_REJECTED, \App\Models\CulturalSubmission::STATUS_REVISION]),
                                ])>
                                    {{ $submission->status_label }}
                                </span>
                            </td>
                            <td class="px-10 py-6 text-right">
                                <div class="text-xs font-bold text-[#03045E]">{{ $submission->created_at->translatedFormat('d M Y') }}</div>
                                <div class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">{{ $submission->created_at->diffForHumans() }}</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-10 py-20 text-center flex flex-col items-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-200 mb-4 shadow-inner">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </div>
                                <p class="text-slate-400 font-black text-[10px] tracking-[0.2em] uppercase">Belum ada aktivitas pengajuan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.pengusul>
