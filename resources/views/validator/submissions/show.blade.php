<x-layouts.validator>
    <x-slot name="header">
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('validator.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('validator.submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Antrian</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Detail Review</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h2 class="font-black text-3xl text-[#03045E] leading-tight tracking-tight">
                    {{ $submission->name }}
                </h2>
                <div class="flex items-center gap-3 mt-2">
                    <span class="inline-flex items-center px-4 py-1 rounded-xl bg-blue-50 text-[#0077B6] text-[10px] font-black uppercase tracking-widest border border-blue-100">
                        {{ $submission->category }}
                    </span>
                    <span class="text-sm font-bold text-slate-400">#{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                @if($submission->status === \App\Models\CulturalSubmission::STATUS_SUBMITTED && $submission->reviewed_by === null)
                    <form action="{{ route('validator.submissions.claim', $submission) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-[#03045E] text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-blue-900/20 hover:bg-[#023E8A] transition-all transform hover:-translate-y-1 active:scale-95">
                            Mulai Review
                        </button>
                    </form>
                @elseif($submission->reviewed_by === Auth::id() && $submission->status === \App\Models\CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW)
                    <form action="{{ route('validator.submissions.unclaim', $submission) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-white border-2 border-slate-100 text-rose-500 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-rose-50 hover:border-rose-100 transition-all flex items-center gap-2 group">
                            <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Batalkan Klaim
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 pb-12">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-10">
            <!-- Review Form / Status Alert -->
            @if($submission->reviewed_by === Auth::id() && $submission->status === \App\Models\CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW)
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border-2 border-[#0077B6]/20 overflow-hidden relative group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-500"></div>
                    <div class="p-10 relative">
                        <h3 class="font-black text-xl text-[#03045E] tracking-tight mb-8">Formulir Review Administratif</h3>
                        
                        <form action="{{ route('validator.submissions.review', $submission) }}" method="POST" class="space-y-8">
                            @csrf
                            <div>
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 block">Keputusan Review</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="action" value="forwarded" class="peer sr-only" required>
                                        <div class="p-6 rounded-2xl border-2 border-slate-100 bg-slate-50 text-center transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:bg-white group-hover:shadow-lg">
                                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-400 mx-auto mb-3 peer-checked:text-emerald-500">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                                            </div>
                                            <span class="block font-black text-[10px] uppercase tracking-widest text-[#03045E]">Forward Lapangan</span>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="action" value="revision" class="peer sr-only">
                                        <div class="p-6 rounded-2xl border-2 border-slate-100 bg-slate-50 text-center transition-all peer-checked:border-amber-500 peer-checked:bg-amber-50 hover:bg-white group-hover:shadow-lg">
                                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-400 mx-auto mb-3 peer-checked:text-amber-500">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </div>
                                            <span class="block font-black text-[10px] uppercase tracking-widest text-[#03045E]">Minta Revisi</span>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="action" value="rejected" class="peer sr-only">
                                        <div class="p-6 rounded-2xl border-2 border-slate-100 bg-slate-50 text-center transition-all peer-checked:border-rose-500 peer-checked:bg-rose-50 hover:bg-white group-hover:shadow-lg">
                                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-400 mx-auto mb-3 peer-checked:text-rose-500">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </div>
                                            <span class="block font-black text-[10px] uppercase tracking-widest text-[#03045E]">Tolak Pengajuan</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 block">Catatan Review (Wajib)</label>
                                <textarea name="notes" rows="5" class="w-full rounded-[2rem] border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 font-medium text-slate-700 transition-all placeholder:text-slate-300" placeholder="Berikan alasan atau instruksi revisi secara mendetail..." required></textarea>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-gradient-to-r from-[#03045E] to-[#0077B6] text-white px-10 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-blue-900/20 hover:shadow-blue-900/40 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center gap-3">
                                    Simpan Review Selesai
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif($submission->reviewed_by === Auth::id() && $submission->status === \App\Models\CulturalSubmission::STATUS_FIELD_VERIFICATION)
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border-2 border-indigo-500/20 overflow-hidden relative group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-500"></div>
                    <div class="p-10 relative">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-sm shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-black text-xl text-[#03045E] tracking-tight">Formulir Verifikasi Lapangan</h3>
                                <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest">Lengkapi data setelah kunjungan lapangan</p>
                            </div>
                        </div>
                        
                        <form action="{{ route('validator.submissions.field-verification', $submission) }}" method="POST" class="space-y-8">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 block">Tanggal Kunjungan</label>
                                    <input type="date" name="visit_date" class="w-full rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 font-bold text-[#03045E] transition-all" required>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 block">Lat Terverifikasi</label>
                                        <input type="number" step="any" name="verified_latitude" value="{{ $submission->latitude }}" class="w-full rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 font-mono text-xs text-slate-600 transition-all">
                                    </div>
                                    <div>
                                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 block">Long Terverifikasi</label>
                                        <input type="number" step="any" name="verified_longitude" value="{{ $submission->longitude }}" class="w-full rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 font-mono text-xs text-slate-600 transition-all">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 block">Hasil Verifikasi & Rekomendasi</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="recommendation" value="verified" class="peer sr-only" required>
                                        <div class="p-6 rounded-2xl border-2 border-slate-100 bg-slate-50 text-center transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:bg-white group-hover:shadow-lg">
                                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-400 mx-auto mb-3 peer-checked:text-emerald-500">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <span class="block font-black text-[10px] uppercase tracking-widest text-[#03045E]">Layak / Terverifikasi</span>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="recommendation" value="revision" class="peer sr-only">
                                        <div class="p-6 rounded-2xl border-2 border-slate-100 bg-slate-50 text-center transition-all peer-checked:border-amber-500 peer-checked:bg-amber-50 hover:bg-white group-hover:shadow-lg">
                                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-400 mx-auto mb-3 peer-checked:text-amber-500">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </div>
                                            <span class="block font-black text-[10px] uppercase tracking-widest text-[#03045E]">Perlu Revisi</span>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="recommendation" value="rejected" class="peer sr-only">
                                        <div class="p-6 rounded-2xl border-2 border-slate-100 bg-slate-50 text-center transition-all peer-checked:border-rose-500 peer-checked:bg-rose-50 hover:bg-white group-hover:shadow-lg">
                                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-400 mx-auto mb-3 peer-checked:text-rose-500">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </div>
                                            <span class="block font-black text-[10px] uppercase tracking-widest text-[#03045E]">Tidak Layak</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 block">Catatan Verifikasi (Wajib)</label>
                                <textarea name="notes" rows="5" class="w-full rounded-[2rem] border-slate-100 bg-slate-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 font-medium text-slate-700 transition-all placeholder:text-slate-300" placeholder="Jelaskan temuan di lapangan..." required></textarea>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-gradient-to-r from-indigo-700 to-blue-600 text-white px-10 py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-indigo-900/20 hover:shadow-indigo-900/40 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center gap-3">
                                    Simpan Verifikasi Lapangan
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                            </div>
                        </form>
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
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-10 space-y-10">
                <section>
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Informasi Kebudayaan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm">
                        <div class="space-y-1">
                            <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Deskripsi</p>
                            <p class="text-slate-600 font-medium leading-relaxed">{{ $submission->description }}</p>
                        </div>
                        <div class="space-y-4">
                            <div class="space-y-1">
                                <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Alamat Lokasi</p>
                                <p class="text-slate-600 font-medium">{{ $submission->address }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Koordinat Pengajuan</p>
                                <p class="text-slate-600 font-mono text-xs">{{ $submission->latitude }}, {{ $submission->longitude }}</p>
                            </div>
                            @if($submission->fieldVerifications->isNotEmpty())
                                @php $latestFv = $submission->fieldVerifications->last(); @endphp
                                @if($latestFv->verified_latitude && $latestFv->verified_longitude)
                                    <div class="space-y-1 p-3 rounded-xl bg-indigo-50 border border-indigo-100">
                                        <p class="text-indigo-400 font-bold uppercase text-[10px] tracking-widest">Koordinat Terverifikasi</p>
                                        <p class="text-indigo-600 font-mono text-xs">{{ $latestFv->verified_latitude }}, {{ $latestFv->verified_longitude }}</p>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </section>

                <div class="h-px bg-slate-50"></div>

                <section>
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        Lampiran Berkas ({{ $submission->files->count() }})
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($submission->files as $file)
                            <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="flex items-center p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-white hover:border-[#00B4D8] hover:shadow-lg hover:shadow-blue-500/5 transition-all group">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#00B4D8] shadow-sm mr-4 group-hover:bg-[#00B4D8] group-hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="overflow-hidden">
                                     <p class="text-sm font-bold text-[#03045E] truncate">{{ $file->original_name }}</p>
                                     <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-0.5">{{ strtoupper($file->file_type) }} • {{ round($file->file_size / 1024, 2) }} KB</p>
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
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white p-8">
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
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white p-8 overflow-hidden">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Histori Review</h3>
                
                <div class="space-y-8 relative">
                    <!-- Vertical Line -->
                    <div class="absolute left-[15px] top-2 bottom-2 w-0.5 bg-slate-100"></div>

                    <!-- Submit Event -->
                    <div class="relative flex gap-6">
                        <div class="relative z-10 w-8 h-8 rounded-full bg-blue-50 border-2 border-white flex items-center justify-center text-blue-500 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-[#03045E] uppercase tracking-widest">Dikirim oleh Pengusul</p>
                            <p class="text-[10px] font-bold text-slate-400 mt-1">{{ $submission->submitted_at?->format('d M Y, H:i') ?? $submission->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    @foreach($submission->administrativeReviews as $review)
                        <div class="relative flex gap-6">
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
                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-xs font-black text-[#03045E] uppercase tracking-widest">
                                        Administratif: 
                                        @if($review->action === 'forwarded') Forwarded
                                        @elseif($review->action === 'revision') Revision Required
                                        @else Rejected @endif
                                    </p>
                                    <span class="text-[9px] font-black text-slate-400">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-[11px] font-bold text-slate-500 line-clamp-2 mt-2 leading-relaxed italic bg-slate-50 p-3 rounded-xl border border-slate-100">"{{ $review->notes }}"</p>
                                <p class="text-[9px] font-black text-slate-400 mt-2 uppercase tracking-tighter">Oleh: {{ $review->validator->name }}</p>
                            </div>
                        </div>
                    @endforeach

                    @foreach($submission->fieldVerifications as $fv)
                        <div class="relative flex gap-6">
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
                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-xs font-black text-[#03045E] uppercase tracking-widest">
                                        Lapangan: 
                                        @if($fv->recommendation === 'verified') Terverifikasi
                                        @elseif($fv->recommendation === 'revision') Revision Required
                                        @else Rejected @endif
                                    </p>
                                    <span class="text-[9px] font-black text-slate-400">{{ $fv->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-[11px] font-bold text-slate-500 line-clamp-2 mt-2 leading-relaxed italic bg-indigo-50/50 p-3 rounded-xl border border-indigo-100">"{{ $fv->notes }}"</p>
                                <p class="text-[9px] font-black text-slate-400 mt-2 uppercase tracking-tighter">Oleh: {{ $fv->validator->name }} • Kunjungan: {{ $fv->visit_date->format('d M Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.validator>
