@extends('layouts.pengusul')

@section('content')
<div class="py-10 bg-[#F8FAFC] min-h-screen font-sans" x-data="{ submitting: false, deleting: false }">
    
    <!-- Action Loading Overlay -->
    <div x-show="submitting || deleting"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 bg-[#03045E]/10 backdrop-blur-md flex items-center justify-center z-[100]"
         style="display: none;">
        <div class="bg-white p-8 rounded-3xl shadow-2xl flex flex-col items-center max-w-xs w-full mx-4 border border-white/20">
            <div class="relative w-20 h-20 mb-6">
                <div class="absolute inset-0 border-4 border-[#0077B6]/20 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-t-[#0077B6] rounded-full animate-spin"></div>
            </div>
            <h3 class="text-[#03045E] font-bold text-xl mb-2 text-center" x-text="submitting ? 'Mengirim Pengajuan' : 'Menghapus Draft'"></h3>
            <p class="text-slate-500 text-sm text-center">Mohon tunggu sebentar, sistem sedang memproses permintaan Anda.</p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Navigation -->
        <div class="flex items-center justify-between mb-8 overflow-x-auto whitespace-nowrap pb-2 gap-4">
            <nav class="flex items-center gap-2 text-sm font-medium text-slate-400">
                <a href="{{ route('pengusul.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('pengusul.submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Pengajuan Saya</a>
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-[#03045E] font-black truncate max-w-[150px] sm:max-w-none">{{ $submission->name }}</span>
            </nav>

            <a href="{{ route('pengusul.submissions.index') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-100 text-slate-600 font-bold text-xs tracking-widest uppercase hover:shadow-md transition-all active:scale-95 shadow-sm shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>

        <!-- Page Content -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Info Column -->
            <div class="lg:col-span-8 space-y-8">
                
                <!-- Main Details Card -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden relative">
                    <!-- Status Header Decoration -->
                    <div class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-transparent via-{{ $submission->status_color }}-500/20 to-transparent"></div>
                    
                    <div class="p-8 sm:p-12">
                        <!-- Identity Section -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-12">
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.15em] uppercase bg-{{ $submission->status_color }}-50 text-{{ $submission->status_color }}-600 border border-{{ $submission->status_color }}-100 shadow-sm">
                                        {{ $submission->status_label }}
                                    </span>
                                    <span class="text-xs font-black text-slate-300 uppercase tracking-widest">SUB-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <h1 class="text-4xl font-black text-[#03045E] tracking-tight leading-tight">
                                    {{ $submission->name }}
                                </h1>
                                <div class="flex items-center gap-2 text-slate-500 font-medium">
                                    <svg class="w-5 h-5 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                    <span>{{ $submission->category }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Info Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
                            <!-- Left: Details -->
                            <div class="md:col-span-12 space-y-10">
                                
                                <!-- Location -->
                                <div class="space-y-4">
                                    <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-3">
                                        <span>Lokasi & Asal</span>
                                        <div class="flex-1 h-px bg-slate-50"></div>
                                    </h3>
                                    <div class="flex items-start gap-4 p-6 rounded-3xl bg-slate-50/50 border border-slate-100 group">
                                        <div class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center text-[#0077B6] shrink-0 group-hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <p class="text-slate-600 font-medium leading-relaxed pt-2">{{ $submission->address }}</p>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="space-y-4">
                                    <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-3">
                                        <span>Narasi Kebudayaan</span>
                                        <div class="flex-1 h-px bg-slate-50"></div>
                                    </h3>
                                    <div class="prose prose-slate max-w-none">
                                        <div class="p-8 rounded-[2rem] bg-slate-50/30 border border-slate-100/50 text-slate-700 leading-[1.8] font-medium text-lg whitespace-pre-wrap">
                                            {{ $submission->description }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Files -->
                                <div class="space-y-6 pt-4">
                                    <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-3">
                                        <span>Dokumen Pendukung ({{ $submission->files->count() }})</span>
                                        <div class="flex-1 h-px bg-slate-50"></div>
                                    </h3>
                                    
                                    @if($submission->files->count() > 0)
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            @foreach($submission->files as $file)
                                                <a href="{{ $file->url }}" target="_blank" 
                                                   class="group/file flex items-center justify-between p-5 bg-white border border-slate-100 rounded-[1.5rem] shadow-sm hover:translate-x-1 hover:shadow-xl hover:shadow-slate-200/50 hover:border-[#0077B6]/30 transition-all duration-300">
                                                    <div class="flex items-center gap-4 min-w-0">
                                                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 border border-slate-50 shadow-sm transition-transform group-hover/file:rotate-6
                                                            {{ $file->file_icon == 'image' ? 'bg-green-50 text-green-600' : ($file->file_icon == 'video' ? 'bg-purple-50 text-purple-600' : 'bg-blue-50 text-blue-600') }}">
                                                            @if($file->file_icon == 'image')
                                                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                            @elseif($file->file_icon == 'video')
                                                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10z"></path></svg>
                                                            @else
                                                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                            @endif
                                                        </div>
                                                        <div class="min-w-0">
                                                            <p class="text-sm font-black text-slate-700 truncate group-hover/file:text-[#0077B6] transition-colors" title="{{ $file->original_name }}">
                                                                {{ $file->original_name }}
                                                            </p>
                                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] mt-1">{{ $file->file_size_human }} • {{ strtoupper($file->file_type) }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="p-2 text-slate-300 group-hover/file:text-[#0077B6] group-hover/file:translate-x-1 transition-all">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="p-10 rounded-[1.5rem] bg-slate-50 border-2 border-dashed border-slate-200 text-center">
                                            <p class="text-slate-400 font-bold text-sm tracking-wide">Belum ada dokumen yang dilampirkan.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Submission Footer -->
                        <div class="mt-12 pt-10 border-t border-slate-50 flex flex-wrap gap-8 text-slate-400">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-[#0077B6]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-0.5">Dibuat Pada</p>
                                    <p class="text-sm font-bold text-slate-600">{{ $submission->created_at->format('d F Y, H:i') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-[#0077B6]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-0.5">Pembaruan Terakhir</p>
                                    <p class="text-sm font-bold text-slate-600">{{ $submission->updated_at->format('d F Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Remarks Section (If exists) -->
                @if($submission->remarks)
                <div class="bg-amber-50 rounded-[2rem] p-8 border border-amber-100/50 shadow-sm relative overflow-hidden group">
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-amber-100/30 rounded-full blur-2xl group-hover:scale-125 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <h3 class="text-amber-800 font-black text-sm uppercase tracking-[0.2em] mb-6 flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            Catatan dari Reviewer
                        </h3>
                        <div class="p-6 rounded-2xl bg-white/60 backdrop-blur-sm border border-amber-200/50 text-amber-900 leading-relaxed font-semibold italic">
                            "{{ $submission->remarks }}"
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right: Action & Sidebar -->
            <div class="lg:col-span-4 space-y-8">
                
                <!-- Main Action Card -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-8 space-y-8 relative overflow-hidden group">
                    <div class="relative z-10 space-y-8">
                        <div>
                            <h3 class="text-[#03045E] font-black text-xl mb-2">Tindakan Cepat</h3>
                            <p class="text-slate-500 text-xs font-medium tracking-wide">Kelola status pengajuan Anda melalui opsi di bawah ini.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            @if($submission->isEditable())
                                <a href="{{ route('pengusul.submissions.edit', $submission) }}" 
                                   class="flex items-center justify-center gap-3 w-full px-6 py-4 rounded-2xl bg-slate-50 border-2 border-slate-100 text-[#03045E] font-black text-[13px] tracking-widest uppercase hover:bg-white hover:border-[#0077B6] hover:text-[#0077B6] hover:shadow-lg hover:shadow-[#0077B6]/10 transition-all active:scale-[0.98]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit Konten
                                </a>
                            @endif

                            @if($submission->canBeSubmitted())
                                <button type="button" 
                                        @click="$dispatch('open-modal', 'confirm-final-submission')" 
                                        class="flex items-center justify-center gap-3 w-full px-6 py-5 rounded-2xl bg-gradient-to-br from-[#0077B6] via-[#023E8A] to-[#03045E] text-white font-black text-[13px] tracking-widest uppercase shadow-xl shadow-[#03045E]/20 hover:shadow-2xl hover:shadow-[#03045E]/30 hover:-translate-y-1 transition-all active:scale-95 group/submit">
                                    <svg class="w-5 h-5 group-hover/submit:translate-x-1 group-hover/submit:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                    Kirim untuk Review
                                </button>
                            @endif

                            @if($submission->status == 'draft')
                                <button type="button" 
                                        @click="$dispatch('open-modal', 'confirm-submission-deletion')" 
                                        class="flex items-center justify-center gap-3 w-full px-6 py-4 rounded-2xl bg-red-50 text-red-600 font-black text-[11px] tracking-widest uppercase hover:bg-red-600 hover:text-white transition-all active:scale-[0.98]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus Draft Permanen
                                </button>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Decorative Background for Sidebar Card -->
                    <div class="absolute -right-12 -bottom-12 w-32 h-32 bg-slate-50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                </div>

                <!-- Timeline / Log Sidebar -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-8 pb-4">
                        <h3 class="text-[#03045E] font-black text-lg flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-[#0077B6] rounded-full"></span>
                            Timeline
                        </h3>
                    </div>
                    <div class="p-8 pt-0">
                        @include('pengusul.submissions.partials.timeline')
                    </div>
                </div>

                <!-- Guidance for New Submissions -->
                @if($submission->status == 'draft')
                    <div class="bg-[#03045E] rounded-[2rem] p-8 text-white shadow-2xl shadow-[#03045E]/30 relative overflow-hidden group">
                        <div class="relative z-10 space-y-4">
                            <h4 class="font-black text-sm tracking-widest pb-3 border-b border-white/10">Catatan Draft</h4>
                            <p class="text-xs text-white/70 leading-relaxed font-medium">
                                Pengajuan dalam status draft dapat diedit sepuasnya. Tim reviewer hanya akan dapat melihat data Anda setelah Anda menekan tombol <span class="text-[#00B4D8] font-black underline underline-offset-4 decoration-2">Kirim untuk Review</span>.
                            </p>
                        </div>
                        <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modals -->
    
    <!-- Final Submission Confirmation -->
    <x-modal name="confirm-final-submission" :show="false" focusable>
        <div class="p-10">
            <div class="flex flex-col items-center text-center mb-10">
                <div class="w-24 h-24 bg-blue-50 rounded-3xl flex items-center justify-center text-[#0077B6] mb-8 shadow-inner animate-pulse">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </div>
                <h2 class="text-3xl font-black text-[#03045E] mb-3 leading-tight tracking-tight">Kirim Sekarang?</h2>
                <p class="text-slate-500 max-w-sm leading-relaxed font-medium">Pengajuan akan dikunci dan dikirim ke tim Reviewer. Anda tidak dapat mengubah data ini hingga proses review selesai.</p>
            </div>

            <div class="bg-blue-50/50 rounded-3xl p-6 mb-10 border border-blue-100 flex items-start gap-5">
                <div class="w-10 h-10 rounded-xl bg-[#0077B6] text-white flex items-center justify-center shrink-0 shadow-lg shadow-[#0077B6]/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-[13px] text-blue-900 leading-relaxed font-bold italic pt-1">Pastikan seluruh dokumen harian & narasi telah diperiksa dengan seksama.</p>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-6 border-t border-slate-100">
                <button type="button" 
                        @click="$dispatch('close')" 
                        class="px-6 py-5 rounded-2xl border-2 border-slate-100 text-slate-600 font-bold text-sm tracking-widest uppercase hover:bg-slate-50 transition-all active:scale-[0.98]">
                    Batal
                </button>
                <form action="{{ route('pengusul.submissions.submit', $submission) }}" method="POST">
                    @csrf
                    <button type="submit" 
                            @click="submitting = true; $dispatch('close')" 
                            class="w-full px-6 py-5 rounded-2xl bg-gradient-to-r from-[#03045E] to-[#023E8A] text-white font-black text-sm tracking-widest uppercase shadow-xl shadow-[#03045E]/20 hover:shadow-2xl hover:shadow-[#03045E]/30 transition-all active:scale-[0.98]">
                        Kirim
                    </button>
                </form>
            </div>
        </div>
    </x-modal>

    <!-- Deletion Confirmation -->
    <x-modal name="confirm-submission-deletion" :show="false" focusable>
        <div class="p-10">
            <div class="flex flex-col items-center text-center mb-10">
                <div class="w-24 h-24 bg-red-50 rounded-3xl flex items-center justify-center text-red-600 mb-8 shadow-inner">
                    <svg class="w-12 h-12 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </div>
                <h2 class="text-3xl font-black text-[#03045E] mb-3 tracking-tight">Hapus Draft?</h2>
                <p class="text-slate-500 max-w-xs leading-relaxed font-medium">Tindakan ini permanen dan tidak dapat dibatalkan. Seluruh data dan file akan dihapus dari server.</p>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-6 border-t border-slate-100">
                <button type="button" 
                        @click="$dispatch('close')" 
                        class="px-6 py-5 rounded-2xl border-2 border-slate-100 text-slate-600 font-bold text-sm tracking-widest uppercase hover:bg-slate-50 transition-all active:scale-[0.98]">
                    Batal
                </button>
                <form action="{{ route('pengusul.submissions.destroy', $submission) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            @click="deleting = true; $dispatch('close')" 
                            class="w-full px-6 py-5 rounded-2xl bg-red-600 text-white font-black text-sm tracking-widest uppercase shadow-xl shadow-red-900/20 hover:bg-red-700 transition-all active:scale-[0.98]">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </x-modal>

</div>
@endsection
