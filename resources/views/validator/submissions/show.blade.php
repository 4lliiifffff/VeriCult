<x-layouts.validator>
    <x-slot name="header">
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('validator.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('validator.submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Antrian</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Detail Review</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-8 mt-4 mb-3">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <span @class([
                        'px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.15em] uppercase border shadow-sm',
                        'bg-blue-50 text-blue-600 border-blue-100' => $submission->status === 'submitted',
                        'bg-indigo-50 text-indigo-600 border-indigo-100' => in_array($submission->status, ['administrative_review', 'field_verification']),
                        'bg-amber-50 text-amber-600 border-amber-100' => $submission->status === 'revision',
                        'bg-rose-50 text-rose-600 border-rose-100' => $submission->status === 'rejected',
                    ])>
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

            <div class="flex items-center gap-4" x-data="{ showClaimModal: false, showUnclaimModal: false }">
                @if($submission->status === \App\Models\CulturalSubmission::STATUS_SUBMITTED && $submission->reviewed_by === null)
                    <button @click="showClaimModal = true" class="bg-[#03045E] text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-blue-900/20 hover:bg-[#023E8A] transition-all transform hover:-translate-y-1 active:scale-95">
                        Mulai Review
                    </button>

                    <!-- Claim Confirmation Modal -->
                    <template x-teleport="body">
                        <div x-show="showClaimModal" x-cloak style="display: none;" class="fixed inset-0 flex items-center justify-center z-50"
                             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                            <div class="absolute inset-0 bg-[#03045E]/30 backdrop-blur-sm" @click="showClaimModal = false"></div>
                            <div class="relative bg-white rounded-[2rem] w-full max-w-md mx-4 shadow-2xl shadow-slate-900/20 overflow-hidden"
                                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-8">
                                <div class="p-8">
                                    <div class="flex items-center gap-4 mb-6">
                                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-[#0077B6] flex items-center justify-center shadow-lg shadow-blue-100">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <div>
                                            <h3 class="font-black text-xl text-[#03045E] tracking-tight">Mulai Review?</h3>
                                            <p class="text-xs font-bold text-slate-400 mt-0.5">Klaim pengajuan ini</p>
                                        </div>
                                    </div>
                                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 mb-6">
                                        <p class="text-sm font-black text-[#03045E] mb-1">{{ $submission->name }}</p>
                                        <p class="text-xs text-slate-400 font-bold">SUB-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }} • {{ $submission->category }}</p>
                                    </div>
                                    <p class="text-sm text-slate-500 font-medium leading-relaxed mb-8">
                                        Anda akan mengklaim pengajuan ini dan langsung diarahkan ke <strong class="text-[#03045E]">Ruang Review</strong> untuk memulai proses validasi.
                                    </p>
                                    <div class="flex items-center gap-3">
                                        <button @click="showClaimModal = false"
                                            class="flex-1 py-4 rounded-2xl border-2 border-slate-100 bg-white text-slate-600 font-black text-xs uppercase tracking-widest hover:bg-slate-50 hover:border-slate-200 transition-all duration-300 active:scale-95">
                                            Batal
                                        </button>
                                        <form action="{{ route('validator.submissions.claim', $submission) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" @click="submitting = true" class="w-full py-4 rounded-2xl bg-[#03045E] text-white font-black text-xs uppercase tracking-widest hover:bg-[#023E8A] transition-all duration-300 active:scale-95 flex items-center justify-center gap-2 shadow-lg shadow-blue-900/20">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                Ya, Mulai Review
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                @elseif($submission->reviewed_by === Auth::id() && $submission->status === \App\Models\CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW)
                    <button @click="showUnclaimModal = true" class="bg-white border-2 border-slate-100 text-rose-500 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-rose-50 hover:border-rose-100 transition-all flex items-center gap-2 group">
                        <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Batalkan Klaim
                    </button>

                    <!-- Unclaim Confirmation Modal -->
                    <template x-teleport="body">
                        <div x-show="showUnclaimModal" x-cloak style="display: none;" class="fixed inset-0 flex items-center justify-center z-50"
                             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                            <div class="absolute inset-0 bg-[#03045E]/30 backdrop-blur-sm" @click="showUnclaimModal = false"></div>
                            <div class="relative bg-white rounded-[2rem] w-full max-w-md mx-4 shadow-2xl shadow-slate-900/20 overflow-hidden"
                                 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90 translate-y-8" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-90 translate-y-8">
                                <div class="p-8">
                                    <div class="flex items-center gap-4 mb-6">
                                        <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center shadow-lg shadow-rose-100">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                                        </div>
                                        <div>
                                            <h3 class="font-black text-xl text-[#03045E] tracking-tight">Batalkan Klaim?</h3>
                                            <p class="text-xs font-bold text-slate-400 mt-0.5">Lepaskan pengajuan ini</p>
                                        </div>
                                    </div>
                                    <div class="bg-rose-50/50 rounded-2xl p-5 border border-rose-100 mb-6">
                                        <p class="text-sm font-black text-[#03045E] mb-1">{{ $submission->name }}</p>
                                        <p class="text-xs text-slate-400 font-bold">SUB-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }} • {{ $submission->category }}</p>
                                    </div>
                                    <p class="text-sm text-slate-500 font-medium leading-relaxed mb-8">
                                        Pengajuan ini akan dikembalikan ke antrian dan dapat diklaim oleh <strong class="text-rose-500">validator lain</strong>. Progress review Anda tidak akan disimpan.
                                    </p>
                                    <div class="flex items-center gap-3">
                                        <button @click="showUnclaimModal = false"
                                            class="flex-1 py-4 rounded-2xl border-2 border-slate-100 bg-white text-slate-600 font-black text-xs uppercase tracking-widest hover:bg-slate-50 hover:border-slate-200 transition-all duration-300 active:scale-95">
                                            Tidak, Tetap Klaim
                                        </button>
                                        <form action="{{ route('validator.submissions.unclaim', $submission) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" @click="submitting = true" class="w-full py-4 rounded-2xl bg-rose-500 text-white font-black text-xs uppercase tracking-widest hover:bg-rose-600 transition-all duration-300 active:scale-95 flex items-center justify-center gap-2 shadow-lg shadow-rose-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                Ya, Batalkan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="space-y-10" x-data="{ submitting: false }">
        <!-- Action Loading Overlay -->
        <div x-show="submitting"
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
                <h3 class="text-[#03045E] font-black text-xl mb-2 text-center">Memproses Klaim</h3>
                <p class="text-slate-500 text-xs font-bold tracking-wide uppercase text-center leading-relaxed">Sistem sedang memproses...</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 pb-12">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-12">
            <!-- Review Workspace Call to Action -->
            @if($submission->reviewed_by === Auth::id() && in_array($submission->status, [\App\Models\CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW, \App\Models\CulturalSubmission::STATUS_FIELD_VERIFICATION]))
                <div class="bg-gradient-to-br from-[#03045E] to-[#0077B6] rounded-[2.5rem] p-10 text-white shadow-2xl shadow-blue-900/40 relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="font-black tracking-widest text-xs uppercase opacity-80">Workspace Aktif</span>
                            </div>
                            <h3 class="text-3xl font-black tracking-tight leading-tight">Siap Untuk <br><span class="text-[#00B4D8]">Validasi Data?</span></h3>
                            <p class="mt-4 text-blue-100/70 text-xs font-bold uppercase tracking-widest italic">
                                Masuki ruang kerja terfokus untuk memberikan keputusan atau verifikasi lapangan.
                            </p>
                        </div>
                        <a href="{{ route('validator.submissions.review-form', $submission) }}" class="bg-white text-[#03045E] px-10 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl hover:bg-[#00B4D8] hover:text-white transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3 shrink-0">
                            Masuk Ruang Review
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            @elseif($submission->reviewed_by && $submission->reviewed_by !== Auth::id())
                <div class="bg-amber-50 border-2 border-amber-100 rounded-[2rem] p-8 flex items-start gap-5">
                    <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-amber-500 shadow-sm shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-black text-[#03045E] uppercase tracking-widest text-xs mb-1">Sedang Direview</h4>
                        <p class="text-sm font-bold text-amber-700 leading-relaxed">Submission ini sedang diproses oleh validator <span class="underline decoration-2 underline-offset-4">{{ $submission->reviewedBy->name }}</span> sejak {{ $submission->review_started_at?->diffForHumans() }}.</p>
                    </div>
                </div>
            @endif

            <!-- Detail Cards -->
            <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/40 border border-white p-12 space-y-12">
                <section>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-8 flex items-center gap-4">
                        <span class="shrink-0">Lokasi & Asal Objek</span>
                        <div class="flex-1 h-px bg-slate-100"></div>
                    </h3>
                    <div class="flex items-start gap-6 p-8 rounded-[2rem] bg-slate-50/50 border border-slate-100 group hover:bg-white hover:shadow-xl hover:shadow-slate-200/30 transition-all duration-300">
                        <div class="w-14 h-14 rounded-2xl bg-white shadow-sm flex items-center justify-center text-[#0077B6] shrink-0 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="pt-2">
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Alamat Lengkap</p>
                            <p class="text-slate-700 font-bold text-lg leading-relaxed">{{ $submission->address }}</p>
                            <div class="flex items-center gap-4 mt-4">
                                <div class="px-3 py-1.5 rounded-lg bg-white border border-slate-100 shadow-sm">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Latitude</p>
                                    <p class="text-[11px] font-mono font-bold text-[#03045E]">{{ $submission->latitude }}</p>
                                </div>
                                <div class="px-3 py-1.5 rounded-lg bg-white border border-slate-100 shadow-sm">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Longitude</p>
                                    <p class="text-[11px] font-mono font-bold text-[#03045E]">{{ $submission->longitude }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="h-px bg-slate-50"></div>

                <section>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] mb-8 flex items-center gap-4">
                        <span class="shrink-0">Narasi Kebudayaan</span>
                        <div class="flex-1 h-px bg-slate-100"></div>
                    </h3>
                    <div class="p-10 rounded-[2.5rem] bg-indigo-50/10 border border-indigo-100/30 group hover:bg-white hover:shadow-xl hover:shadow-indigo-100/30 transition-all duration-300">
                        <div class="prose prose-slate max-w-none">
                            <p class="text-slate-700 leading-[2] font-medium text-lg whitespace-pre-wrap italic">
                                "{{ $submission->description }}"
                            </p>
                        </div>
                    </div>
                </section>

                <div class="h-px bg-slate-50"></div>

                <section>
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] flex items-center gap-4 flex-1">
                            <span class="shrink-0">Lampiran Dokumen</span>
                            <div class="flex-1 h-px bg-slate-100"></div>
                        </h3>
                        <span class="ml-4 px-3 py-1 rounded-lg bg-[#03045E] text-white text-[10px] font-black tracking-widest">{{ $submission->files->count() }} BERKAS</span>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach($submission->files as $file)
                            <a href="{{ $file->url }}" target="_blank" 
                               class="group/file flex items-center justify-between p-6 bg-white border border-slate-100 rounded-[2rem] shadow-sm hover:translate-y-[-4px] hover:shadow-xl hover:shadow-slate-200/50 hover:border-[#0077B6]/30 transition-all duration-300">
                                <div class="flex items-center gap-5 min-w-0">
                                    <div class="w-16 h-16 rounded-[1.25rem] flex items-center justify-center shrink-0 border border-slate-50 shadow-sm transition-transform group-hover/file:rotate-6
                                        {{ in_array(strtolower($file->file_type), ['jpg', 'jpeg', 'png', 'webp']) ? 'bg-emerald-50 text-emerald-600' : (in_array(strtolower($file->file_type), ['mp4', 'mov']) ? 'bg-violet-50 text-violet-600' : 'bg-blue-50 text-blue-600') }}">
                                        @if(in_array(strtolower($file->file_type), ['jpg', 'jpeg', 'png', 'webp']))
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        @elseif(in_array(strtolower($file->file_type), ['mp4', 'mov']))
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
                                            <span>{{ round($file->file_size / 1024, 1) }} KB</span>
                                            <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                                            <span class="text-[#00B4D8]">{{ strtoupper($file->file_type) }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="p-2 text-slate-100 group-hover/file:text-[#0077B6] group-hover/file:translate-x-1 transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>

        <!-- Sidebar Details -->
        <div class="space-y-8">
            <!-- Requester Card -->
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/40 border border-white p-10">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Informasi Pengusul</h3>
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-[#03045E] flex items-center justify-center text-xl font-black text-white shadow-xl shadow-blue-900/20">
                        {{ substr($submission->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-base font-black text-[#03045E]">{{ $submission->user->name }}</p>
                        <p class="text-xs font-bold text-slate-400 mt-1">{{ $submission->user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Review Timeline -->
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/40 border border-white p-10 overflow-hidden">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Histori Review</h3>
                
                <div class="space-y-0 relative">
                    <!-- Submit Event -->
                    <div class="relative flex gap-6 group/item">
                        <!-- Line segment -->
                        <div class="absolute left-[15px] top-8 bottom-0 w-0.5 bg-slate-100 group-last/item:hidden"></div>

                        <div class="relative z-10 w-8 h-8 rounded-full bg-blue-50 border-2 border-white flex items-center justify-center text-blue-500 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </div>
                        <div class="pb-8">
                            <p class="text-xs font-black text-[#03045E] uppercase tracking-widest">Dikirim oleh Pengusul</p>
                            <p class="text-[10px] font-bold text-slate-400 mt-1">{{ $submission->submitted_at?->format('d M Y, H:i') ?? $submission->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    @foreach($submission->administrativeReviews as $review)
                        <div class="relative flex gap-6 group/item">
                            <!-- Line segment -->
                            <div class="absolute left-[15px] top-8 bottom-0 w-0.5 bg-slate-100 group-last/item:hidden"></div>

                            <div @class([
                                'relative z-10 w-8 h-8 rounded-full border-2 border-white flex items-center justify-center text-white shadow-lg',
                                'bg-emerald-500 shadow-emerald-200' => $review->action === 'forwarded',
                                'bg-amber-500 shadow-amber-200' => $review->action === 'revision',
                                'bg-rose-500 shadow-rose-200' => $review->action === 'rejected',
                            ])>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($review->action === 'forwarded') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                                    @elseif($review->action === 'revision') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    @else <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path> @endif
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0 pb-8">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-[10px] font-black text-[#03045E] uppercase tracking-wider truncate">
                                        Review Administratif
                                    </p>
                                    <span class="text-[9px] font-bold text-slate-400 shrink-0">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <div @class([
                                    'mt-2 p-3 rounded-xl border italic text-[11px] font-medium leading-relaxed',
                                    'bg-emerald-50/50 border-emerald-100 text-emerald-700' => $review->action === 'forwarded',
                                    'bg-amber-50/50 border-amber-100 text-amber-700' => $review->action === 'revision',
                                    'bg-rose-50/50 border-rose-100 text-rose-700' => $review->action === 'rejected',
                                ])>
                                    "{{ $review->notes }}"
                                </div>
                                <div class="flex items-center gap-2 mt-2">
                                    <div class="w-5 h-5 rounded-md bg-slate-100 flex items-center justify-center text-[9px] font-black text-slate-500">
                                        {{ substr($review->validator->name, 0, 1) }}
                                    </div>
                                    <p class="text-[9px] font-black text-slate-400 border-b border-dotted border-slate-200 pb-0.5 uppercase tracking-tighter">{{ $review->validator->name }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @foreach($submission->fieldVerifications as $fv)
                        <div class="relative flex gap-6 group/item">
                            <!-- Line segment -->
                            <div class="absolute left-[15px] top-8 bottom-0 w-0.5 bg-slate-100 group-last/item:hidden"></div>

                            <div @class([
                                'relative z-10 w-8 h-8 rounded-full border-2 border-white flex items-center justify-center text-white shadow-lg',
                                'bg-emerald-500 shadow-emerald-200' => $fv->recommendation === 'verified',
                                'bg-amber-500 shadow-amber-200' => $fv->recommendation === 'revision',
                                'bg-rose-500 shadow-rose-200' => $fv->recommendation === 'rejected',
                            ])>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($fv->recommendation === 'verified') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                    @elseif($fv->recommendation === 'revision') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    @else <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path> @endif
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0 pb-8 last:pb-0">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-[10px] font-black text-[#03045E] uppercase tracking-wider truncate">
                                        Verifikasi Lapangan
                                    </p>
                                    <span class="text-[9px] font-bold text-slate-400 shrink-0">{{ $fv->created_at->diffForHumans() }}</span>
                                </div>
                                <div @class([
                                    'mt-2 p-3 rounded-xl border italic text-[11px] font-medium leading-relaxed',
                                    'bg-indigo-50/50 border-indigo-100 text-indigo-700' => $fv->recommendation === 'verified',
                                    'bg-amber-50/50 border-amber-100 text-amber-700' => $fv->recommendation === 'revision',
                                    'bg-rose-50/50 border-rose-100 text-rose-700' => $fv->recommendation === 'rejected',
                                ])>
                                    "{{ $fv->notes }}"
                                </div>
                                <div class="flex items-center gap-2 mt-2">
                                    <div class="w-5 h-5 rounded-md bg-slate-100 flex items-center justify-center text-[9px] font-black text-slate-500">
                                        {{ substr($fv->validator->name, 0, 1) }}
                                    </div>
                                    <p class="text-[9px] font-black text-slate-400 border-b border-dotted border-slate-200 pb-0.5 uppercase tracking-tighter">{{ $fv->validator->name }} • {{ $fv->visit_date->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.validator>
