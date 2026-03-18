<x-layouts.validator>
    <x-slot name="header">
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('validator.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Antrian Validasi</span>
        </nav>

        <div class="relative bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-8 overflow-hidden shadow-2xl shadow-blue-900/20 mb-8">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.2em] uppercase bg-white/10 text-white border border-white/20 backdrop-blur-xl">
                            Antrian Validasi
                        </span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight break-words">
                        Antrian <span class="text-[#00B4D8]">Validasi</span>
                    </h2>
                    <p class="text-blue-100/70 text-base sm:text-lg font-medium break-words">Kelola dan review seluruh pengajuan kebudayaan yang masuk.</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8 pb-12">
        <!-- Filter Card -->
        <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-6 sm:p-10 relative z-30">
            <form action="{{ route('validator.submissions.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 auto-submit">
                <div>
                    <x-dropdown-select 
                        name="status" 
                        id="status" 
                        label="Status" 
                        placeholder="Semua Status"
                        all-label="Semua Status"
                        variant="light"
                        :selected="request('status')" 
                        :options="[
                            \App\Models\CulturalSubmission::STATUS_SUBMITTED => 'Diajukan',
                            \App\Models\CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW => 'Tinjauan Administratif',
                            \App\Models\CulturalSubmission::STATUS_FIELD_VERIFICATION => 'Verifikasi Lapangan',
                            \App\Models\CulturalSubmission::STATUS_VERIFIED => 'Diverifikasi'
                        ]" 
                    />
                </div>
                <div>
                    <x-dropdown-select 
                        name="claimed" 
                        id="claimed" 
                        label="Klaim" 
                        placeholder="Semua"
                        all-label="Semua Klaim"
                        variant="light"
                        :selected="request('claimed')" 
                        :options="[
                            'yes' => 'Sudah Diklaim',
                            'no' => 'Belum Diklaim'
                        ]" 
                    />
                </div>
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block">Filter Saya</label>
                    <div class="flex items-center h-10 px-4 rounded-xl bg-slate-50 border border-slate-100">
                        <input type="checkbox" name="by_me" value="1" {{ request('by_me') ? 'checked' : '' }} class="rounded text-[#0077B6] focus:ring-[#00B4D8]/20">
                        <span class="ml-3 text-xs font-bold text-[#03045E]">Di-review oleh Saya</span>
                    </div>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-[#03045E] text-white py-3 rounded-xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-blue-900/20 hover:bg-[#023E8A] transition-all">
                        Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- List Table -->
        <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-max">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                            <th class="px-10 py-6">Kebudayaan</th>
                            <th class="px-10 py-6">Pengusul</th>
                            <th class="px-10 py-6">Status</th>
                            <th class="px-10 py-6">Reviewer</th>
                            <th class="px-10 py-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        @forelse($submissions as $submission)
                        <tr class="group hover:bg-slate-50/30 transition-all duration-200">
                            <td class="px-10 py-8">
                                <div class="font-black text-[#03045E] text-base group-hover:text-[#0077B6] transition-colors">{{ $submission->name }}</div>
                                <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.1em] mt-1">{{ $submission->category }}</div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="text-xs font-bold text-slate-600">{{ $submission->user->name }}</div>
                                <div class="text-[10px] font-medium text-slate-400 mt-1">{{ $submission->created_at->format('d M Y') }}</div>
                            </td>
                            <td class="px-10 py-8">
                                <span @class([
                                    'inline-flex items-center px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border',
                                    'bg-blue-50 text-blue-600 border-blue-100' => $submission->status === \App\Models\CulturalSubmission::STATUS_SUBMITTED,
                                    'bg-indigo-50 text-indigo-600 border-indigo-100' => in_array($submission->status, [\App\Models\CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW, \App\Models\CulturalSubmission::STATUS_FIELD_VERIFICATION]),
                                    'bg-amber-50 text-amber-600 border-amber-100' => $submission->status === \App\Models\CulturalSubmission::STATUS_REVISION,
                                    'bg-rose-50 text-rose-600 border-rose-100' => $submission->status === \App\Models\CulturalSubmission::STATUS_REJECTED,
                                ])>
                                    {{ $submission->status_label }}
                                </span>
                            </td>
                            <td class="px-10 py-8">
                                @if($submission->reviewed_by)
                                    <div class="flex items-center">
                                        <div @class([
                                            'w-7 h-7 rounded-lg flex items-center justify-center text-[10px] font-black mr-2',
                                            'bg-[#03045E] text-white shadow-lg shadow-blue-900/10' => $submission->reviewed_by === Auth::id(),
                                            'bg-slate-100 text-slate-500' => $submission->reviewed_by !== Auth::id(),
                                        ])>
                                            {{ substr($submission->reviewedBy->name, 0, 1) }}
                                        </div>
                                        <div class="text-xs font-bold {{ $submission->reviewed_by === Auth::id() ? 'text-[#03045E]' : 'text-slate-400' }}">
                                            {{ $submission->reviewed_by === Auth::id() ? 'Saya' : $submission->reviewedBy->name }}
                                        </div>
                                    </div>
                                @else
                                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Belum Diklaim</span>
                                @endif
                            </td>
                            <td class="px-10 py-8 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    @if(!$submission->reviewed_by && $submission->status === \App\Models\CulturalSubmission::STATUS_SUBMITTED)
                                        <form action="{{ route('validator.submissions.claim', $submission) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-[#03045E] text-white hover:bg-[#0077B6] rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 group/btn shadow-md">
                                                Klaim & Review
                                                <svg class="w-3 h-3 ml-2 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                                            </button>
                                        </form>
                                    @endif

                                    @if($submission->reviewed_by === Auth::id() && in_array($submission->status, [\App\Models\CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW, \App\Models\CulturalSubmission::STATUS_FIELD_VERIFICATION, \App\Models\CulturalSubmission::STATUS_SUBMITTED]))
                                        <a href="{{ route('validator.submissions.review-form', $submission) }}" class="inline-flex items-center px-4 py-2.5 bg-emerald-600 text-white hover:bg-emerald-700 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 group/btn shadow-md">
                                            Lanjutkan Review {{ $submission->status === \App\Models\CulturalSubmission::STATUS_SUBMITTED ? '(Revisi)' : '' }}
                                            <svg class="w-3 h-3 ml-2 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                                        </a>
                                    @endif
                                    <a href="{{ route('validator.submissions.show', $submission) }}" class="inline-flex items-center px-4 py-2.5 bg-slate-50 border border-slate-100 text-[#03045E] hover:bg-slate-100 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 group/btn shadow-sm">
                                        Details
                                        <svg class="w-3 h-3 ml-2 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-200 mb-4">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    </div>
                                    <p class="text-slate-400 font-bold tracking-wide uppercase text-xs">Tidak ada data ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($submissions->hasPages())
                <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
                    {{ $submissions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.validator>
