@extends('layouts.pengusul')

@section('content')
<div class="py-6 bg-[#F8FAFC] min-h-screen font-sans">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-[#03045E] leading-tight tracking-tight">
                    Daftar Pengajuan
                </h2>
                <p class="text-sm text-slate-500 mt-1">Kelola semua pengajuan data kebudayaan Anda.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('pengusul.submissions.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#0077B6] to-[#00B4D8] text-white font-semibold rounded-lg shadow-lg shadow-[#0077B6]/30 hover:from-[#023E8A] hover:to-[#0077B6] transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Pengajuan Baru
                </a>
            </div>
        </div>

        <!-- Submissions Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100/60 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[11px] font-bold text-slate-400 uppercase bg-slate-50/30 border-b border-slate-100">
                            <th class="px-5 py-3 tracking-wider">Nama</th>
                            <th class="px-5 py-3 tracking-wider">Kategori</th>
                            <th class="px-5 py-3 tracking-wider">Alamat</th>
                            <th class="px-5 py-3 tracking-wider text-center">Status</th>
                            <th class="px-5 py-3 tracking-wider text-center">Tanggal</th>
                            <th class="px-5 py-3 tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($submissions as $submission)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-5 py-3.5">
                                <div class="font-bold text-sm text-[#03045E]">{{ $submission->name }}</div>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="text-xs text-slate-600">{{ $submission->category }}</span>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="text-xs text-slate-500 truncate max-w-[200px] block">{{ $submission->address }}</span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-{{ $submission->status_color }}-50 text-{{ $submission->status_color }}-600 border border-{{ $submission->status_color }}-100">
                                    {{ $submission->status_label }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center text-xs text-slate-500">
                                {{ $submission->created_at->format('d M Y') }}
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('pengusul.submissions.show', $submission) }}" class="text-[10px] font-bold text-[#0077B6] hover:text-[#0096C7] bg-blue-50 hover:bg-blue-100 px-2.5 py-1 rounded-md transition-colors">
                                        Detail
                                    </a>
                                    @if($submission->isEditable())
                                    <a href="{{ route('pengusul.submissions.edit', $submission) }}" class="text-[10px] font-bold text-amber-600 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 px-2.5 py-1 rounded-md transition-colors">
                                        Edit
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-slate-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p class="text-slate-400 text-sm mb-3">Belum ada pengajuan.</p>
                                    <a href="{{ route('pengusul.submissions.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#0077B6] to-[#00B4D8] text-white text-xs font-semibold rounded-lg hover:from-[#023E8A] hover:to-[#0077B6] transition-all">
                                        Buat Pengajuan Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($submissions->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $submissions->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
