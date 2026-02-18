<x-layouts.pengusul>
    <x-slot name="header">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('pengusul.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('pengusul.submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Pengajuan Saya</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E] truncate max-w-[150px] sm:max-w-none">{{ $submission->name }}</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.15em] uppercase bg-{{ $submission->status_color }}-50 text-{{ $submission->status_color }}-600 border border-{{ $submission->status_color }}-100 shadow-sm">
                        {{ $submission->status_label }}
                    </span>
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">SUB-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
                <h2 class="font-black text-4xl text-[#03045E] leading-tight tracking-tight">
                    {{ $submission->name }}
                </h2>
                <div class="flex items-center gap-2 text-slate-500 font-bold text-sm">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-[#0077B6] shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                    <span>{{ $submission->category }}</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('pengusul.submissions.index') }}" class="inline-flex items-center px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 hover:bg-slate-50 hover:border-slate-300 shadow-sm shadow-slate-200/50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10" x-data="{ submitting: false, deleting: false }">
        <!-- Action Loading Overlay -->
        <div x-show="submitting || deleting"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             class="fixed inset-0 bg-[#03045E]/10 backdrop-blur-md flex items-center justify-center z-[100]"
             style="display: none;">
            <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl flex flex-col items-center max-w-xs w-full mx-4 border border-white">
                <div class="relative w-20 h-20 mb-8">
                    <div class="absolute inset-0 border-4 border-[#0077B6]/10 rounded-full"></div>
                    <div class="absolute inset-0 border-4 border-t-[#0077B6] rounded-full animate-spin"></div>
                </div>
                <h3 class="text-[#03045E] font-black text-xl mb-2 text-center" x-text="submitting ? 'Mengirim Data' : 'Menghapus Data'"></h3>
                <p class="text-slate-500 text-xs font-bold tracking-wide uppercase text-center leading-relaxed">Sistem sedang memproses...</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            <!-- Left Info Column -->
            <div class="lg:col-span-8 space-y-10">
                
                <!-- Main Details Card -->
                <div class="bg-white rounded-[3rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden relative">
                    <div class="p-10 sm:p-14">
                        <!-- Location & Details Section -->
                        <div class="space-y-12">
                            <!-- Location -->
                            <div class="space-y-6">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] flex items-center gap-4">
                                    <span class="shrink-0">Lokasi & Asal Objek</span>
                                    <div class="flex-1 h-px bg-slate-100"></div>
                                </h3>
                                <div class="flex items-start gap-6 p-8 rounded-[2rem] bg-slate-50/50 border border-slate-100 group">
                                    <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center text-[#0077B6] shrink-0 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <div class="pt-2">
                                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Alamat Lengkap</p>
                                        <p class="text-slate-700 font-bold text-lg leading-relaxed">{{ $submission->address }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="space-y-6">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] flex items-center gap-4">
                                    <span class="shrink-0">Narasi Kebudayaan</span>
                                    <div class="flex-1 h-px bg-slate-100"></div>
                                </h3>
                                <div class="p-10 rounded-[2.5rem] bg-indigo-50/10 border border-indigo-100/30">
                                    <div class="prose prose-slate max-w-none">
                                        <p class="text-slate-700 leading-[2] font-medium text-lg whitespace-pre-wrap italic">
                                            "{{ $submission->description }}"
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Files Section -->
                            <div class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] flex items-center gap-4 flex-1">
                                        <span class="shrink-0">Lampiran Dokumen</span>
                                        <div class="flex-1 h-px bg-slate-100"></div>
                                    </h3>
                                    <span class="ml-4 px-3 py-1 rounded-lg bg-[#03045E] text-white text-[10px] font-black tracking-widest">{{ $submission->files->count() }} BERKAS</span>
                                </div>
                                
                                @if($submission->files->count() > 0)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        @foreach($submission->files as $file)
                                            <a href="{{ $file->url }}" target="_blank" 
                                               class="group/file flex items-center justify-between p-6 bg-white border border-slate-100 rounded-[2rem] shadow-sm hover:translate-y-[-4px] hover:shadow-xl hover:shadow-slate-200/50 hover:border-[#0077B6]/30 transition-all duration-300">
                                                <div class="flex items-center gap-5 min-w-0">
                                                    <div class="w-16 h-16 rounded-[1.25rem] flex items-center justify-center shrink-0 border border-slate-50 shadow-sm transition-transform group-hover/file:rotate-6
                                                        {{ $file->file_icon == 'image' ? 'bg-emerald-50 text-emerald-600' : ($file->file_icon == 'video' ? 'bg-violet-50 text-violet-600' : 'bg-blue-50 text-blue-600') }}">
                                                        @if($file->file_icon == 'image')
                                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        @elseif($file->file_icon == 'video')
                                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10z"></path></svg>
                                                        @else
                                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                        @endif
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="text-[13px] font-black text-slate-700 truncate group-hover/file:text-[#0077B6] transition-colors mb-1" title="{{ $file->original_name }}">
                                                            {{ $file->original_name }}
                                                        </p>
                                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-2">
                                                            <span>{{ $file->file_size_human }}</span>
                                                            <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                                                            <span class="text-[#00B4D8]">{{ strtoupper($file->file_type) }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="p-2 text-slate-200 group-hover/file:text-[#0077B6] group-hover/file:translate-x-1 transition-all">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-16 rounded-[2.5rem] bg-slate-50 border-2 border-dashed border-slate-200 text-center group">
                                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 text-slate-300 group-hover:scale-110 transition-transform shadow-sm">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="text-slate-400 font-bold text-sm tracking-wide">Belum ada dokumen pendukung.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Submission Meta -->
                        <div class="mt-16 pt-10 border-t border-slate-50 flex flex-wrap gap-10">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#0077B6] border border-slate-100 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-0.5">Didaftarkan Pada</p>
                                    <p class="text-sm font-black text-slate-600 tracking-tight">{{ $submission->created_at->translatedFormat('d F Y') }} <span class="text-slate-300 font-medium">pukul</span> {{ $submission->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#0077B6] border border-slate-100 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-0.5">Terakhir Diperbarui</p>
                                    <p class="text-sm font-black text-slate-600 tracking-tight">{{ $submission->updated_at->translatedFormat('d F Y') }} <span class="text-slate-300 font-medium">pukul</span> {{ $submission->updated_at->format('H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Remarks Section (If exists) -->
                @if($submission->remarks)
                <div class="bg-amber-50/50 rounded-[2.5rem] p-10 border border-amber-100 shadow-sm relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-amber-100/40 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <h3 class="text-[11px] font-black text-amber-600 uppercase tracking-[0.25em] mb-6 flex items-center gap-4">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                            Evaluasi Reviewer
                        </h3>
                        <div class="p-8 rounded-[1.5rem] bg-white border border-amber-200/50 text-slate-700 leading-relaxed font-bold italic text-lg shadow-sm">
                            "{{ $submission->remarks }}"
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right: Action & Sidebar -->
            <div class="lg:col-span-4 space-y-10">
                
                <!-- Main Action Card -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-10 space-y-10 relative overflow-hidden group">
                    <div class="relative z-10 space-y-8">
                        <div>
                            <h3 class="text-[#03045E] font-black text-2xl tracking-tight mb-2">Tindakan Cepat</h3>
                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Workflow Pengajuan</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            @if($submission->isEditable())
                                <a href="{{ route('pengusul.submissions.edit', $submission) }}" 
                                   class="flex items-center justify-center gap-3 w-full px-8 py-5 rounded-[1.25rem] bg-slate-50 border-2 border-slate-100 text-[#03045E] font-black text-xs tracking-[0.2em] uppercase hover:bg-white hover:border-[#0077B6] hover:text-[#0077B6] hover:shadow-xl hover:shadow-blue-500/10 transition-all active:scale-[0.98]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Ubah Konten
                                </a>
                            @endif

                            @if($submission->canBeSubmitted())
                                <button type="button" 
                                        @click="$dispatch('open-modal', 'confirm-final-submission')" 
                                        class="flex items-center justify-center gap-4 w-full px-8 py-6 rounded-[1.25rem] bg-gradient-to-br from-[#03045E] to-[#0077B6] text-white font-black text-xs tracking-[0.25em] uppercase shadow-2xl shadow-blue-900/40 hover:shadow-blue-900/50 hover:-translate-y-1 transition-all active:scale-95 group/submit">
                                    <svg class="w-6 h-6 group-hover/submit:translate-x-1 group-hover/submit:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                    Kirim Final
                                </button>
                            @endif

                            @if($submission->status == 'draft')
                                <button type="button" 
                                        @click="$dispatch('open-modal', 'confirm-submission-deletion')" 
                                        class="flex items-center justify-center gap-3 w-full px-8 py-4 rounded-[1.25rem] bg-rose-50 text-rose-600 font-black text-[10px] tracking-[0.2em] uppercase hover:bg-rose-600 hover:text-white transition-all active:scale-[0.98] mt-4">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Batalkan Pengajuan
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Timeline / Log Sidebar -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden overflow-y-auto max-h-[600px] scrollbar-hide">
                    <div class="p-10 pb-4 sticky top-0 bg-white/95 backdrop-blur-sm z-10 flex items-center justify-between border-b border-slate-50">
                        <h3 class="text-[#03045E] font-black text-lg tracking-tight flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-[#00B4D8] rounded-full"></span>
                            Jejak Aktivitas
                        </h3>
                    </div>
                    <div class="p-10 pt-8">
                        @include('pengusul.submissions.partials.timeline')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Final Submission Confirmation -->
    <x-modal name="confirm-final-submission" :show="false" focusable>
        <div class="p-10 sm:p-14">
            <div class="flex flex-col items-center text-center mb-10">
                <div class="w-24 h-24 bg-blue-50 rounded-[2rem] flex items-center justify-center text-[#0077B6] mb-8 shadow-inner relative group/icon">
                    <div class="absolute inset-0 bg-[#00B4D8]/20 rounded-[2rem] animate-ping opacity-0 group-hover/icon:opacity-100 transition-opacity"></div>
                    <svg class="w-12 h-12 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </div>
                <h2 class="text-3xl font-black text-[#03045E] mb-3 leading-tight tracking-tight">Kirim Sekarang?</h2>
                <p class="text-slate-500 max-w-sm leading-relaxed font-bold text-sm">Data akan dikunci dan dikirim ke tim Reviewer. Anda tidak dapat mengubah data ini hingga proses selesai.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-10 border-t border-slate-50">
                <button type="button" 
                        @click="$dispatch('close')" 
                        class="px-8 py-5 rounded-2xl border-2 border-slate-100 text-slate-500 font-black text-[11px] tracking-[0.2em] uppercase hover:bg-slate-50 transition-all active:scale-[0.98]">
                    Batal
                </button>
                <form action="{{ route('pengusul.submissions.submit', $submission) }}" method="POST">
                    @csrf
                    <button type="submit" 
                            @click="submitting = true; $dispatch('close')" 
                            class="w-full px-8 py-5 rounded-2xl bg-[#03045E] text-white font-black text-[11px] tracking-[0.2em] uppercase shadow-2xl shadow-blue-900/20 hover:bg-[#0077B6] transition-all active:scale-[0.98]">
                        Ya, Kirim
                    </button>
                </form>
            </div>
        </div>
    </x-modal>

    <!-- Deletion Confirmation -->
    <x-modal name="confirm-submission-deletion" :show="false" focusable>
        <div class="p-10 sm:p-14 text-center">
            <div class="w-24 h-24 bg-rose-50 rounded-[2rem] flex items-center justify-center text-rose-600 mx-auto mb-8 shadow-inner">
                <svg class="w-12 h-12 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <h2 class="text-3xl font-black text-[#03045E] mb-3 tracking-tight leading-tight">Batalkan Pengajuan?</h2>
            <p class="text-slate-500 max-w-sm mx-auto leading-relaxed font-bold text-sm mb-10">Tindakan ini permanen. Seluruh data dan file yang telah Anda unggah akan dihapus sepenuhnya.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-10 border-t border-slate-50">
                <button type="button" 
                        @click="$dispatch('close')" 
                        class="px-8 py-5 rounded-2xl border-2 border-slate-100 text-slate-500 font-black text-[11px] tracking-[0.2em] uppercase hover:bg-slate-50 transition-all active:scale-[0.98]">
                    Kembali
                </button>
                <form action="{{ route('pengusul.submissions.destroy', $submission) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            @click="deleting = true; $dispatch('close')" 
                            class="w-full px-8 py-5 rounded-2xl bg-rose-600 text-white font-black text-[11px] tracking-[0.2em] uppercase shadow-2xl shadow-rose-900/20 hover:bg-rose-700 transition-all active:scale-[0.98]">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </x-modal>
</x-layouts.pengusul>
