<x-layouts.validator>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 overflow-x-auto whitespace-nowrap">
                <a href="{{ route('validator.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('validator.submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Antrian</a>
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('validator.submissions.show', $submission) }}" class="hover:text-[#0077B6] transition-colors">Detail</a>
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-[#03045E]">Review Workspace</span>
            </nav>
            <a href="{{ route('validator.submissions.show', $submission) }}" class="text-xs font-black uppercase tracking-widest text-[#0077B6] hover:text-[#03045E] transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
                Kembali ke Detail
            </a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 pb-12 items-start">
        <!-- Sidebar: Submission Details & Files (Left) -->
        <div class="lg:col-span-7 space-y-10">
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden">
                <div class="p-10 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                    <div>
                        <h3 class="font-black text-xl text-[#03045E] tracking-tight">Informasi Pengajuan</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">SUB-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <span @class([
                        'px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border',
                        'bg-blue-50 text-blue-600 border-blue-100' => $submission->status === 'administrative_review',
                        'bg-indigo-50 text-indigo-600 border-indigo-100' => $submission->status === 'field_verification',
                    ])>
                        {{ $submission->status_label }}
                    </span>
                </div>
                <div class="p-10 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Nama Objek</label>
                            <p class="text-sm font-bold text-[#03045E] leading-relaxed">{{ $submission->name }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Kategori</label>
                            <p class="text-sm font-bold text-[#03045E] leading-relaxed">{{ $submission->category }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Alamat / Lokasi</label>
                        <p class="text-sm font-bold text-slate-600 leading-relaxed">{{ $submission->address }}</p>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Deskripsi</label>
                        <div class="prose prose-slate prose-sm font-medium text-slate-600 leading-relaxed">
                            {{ $submission->description }}
                        </div>
                    </div>

                    <!-- Files Section -->
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 block">Dokumen Pendukung</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($submission->files as $file)
                                <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/50 flex items-center gap-4 group hover:bg-white hover:border-[#0077B6]/20 transition-all cursor-pointer">
                                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#0077B6] shadow-sm border border-slate-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-black text-[#03045E] truncate">{{ $file->original_name }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight mt-0.5">Dokumen Bukti</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form: Review Actions (Right) -->
        <div class="lg:col-span-5 space-y-10">
            <!-- Focused Review Form -->
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-blue-900/10 border-2 border-[#0077B6]/20 overflow-hidden sticky top-8">
                <div class="p-10">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#03045E] to-[#0077B6] flex items-center justify-center text-white shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h2 class="font-black text-2xl text-[#03045E] tracking-tight">Keputusan Validasi</h2>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Tahap: {{ $submission->status === 'administrative_review' ? 'Administratif' : 'Verifikasi Lapangan' }}</p>
                        </div>
                    </div>

                    @if($submission->status === \App\Models\CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW)
                        <!-- Administrative Review Form -->
                        <form action="{{ route('validator.submissions.review', $submission) }}" method="POST" class="space-y-8">
                            @csrf
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 block">Keputusan Review</label>
                                <div class="grid grid-cols-1 gap-3">
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="action" value="forwarded" class="peer sr-only" required>
                                        <div class="p-5 rounded-2xl border-2 border-slate-100 bg-slate-50 transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:bg-white flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-400 peer-checked:text-emerald-500">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                                            </div>
                                            <div>
                                                <span class="block font-black text-xs uppercase tracking-widest text-[#03045E]">Forward Lapangan</span>
                                                <span class="text-[10px] text-slate-400 font-medium">Lanjutkan ke tahap pemeriksaan fisik</span>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="action" value="revision" class="peer sr-only">
                                        <div class="p-5 rounded-2xl border-2 border-slate-100 bg-slate-50 transition-all peer-checked:border-amber-500 peer-checked:bg-amber-50 hover:bg-white flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-400 peer-checked:text-amber-500">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </div>
                                            <div>
                                                <span class="block font-black text-xs uppercase tracking-widest text-[#03045E]">Minta Revisi</span>
                                                <span class="text-[10px] text-slate-400 font-medium">Ada berkas yang perlu diperbaiki</span>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="action" value="rejected" class="peer sr-only">
                                        <div class="p-5 rounded-2xl border-2 border-slate-100 bg-slate-50 transition-all peer-checked:border-rose-500 peer-checked:bg-rose-50 hover:bg-white flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-400 peer-checked:text-rose-500">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </div>
                                            <div>
                                                <span class="block font-black text-xs uppercase tracking-widest text-[#03045E]">Tolak Pengajuan</span>
                                                <span class="text-[10px] text-slate-400 font-medium">Pengajuan tidak sesuai kriteria</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 block">Catatan Review</label>
                                <textarea name="notes" rows="4" class="w-full rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 font-medium text-slate-700 transition-all placeholder:text-slate-300" placeholder="Berikan instruksi atau alasan keputusan..." required></textarea>
                            </div>

                            <button type="submit" class="w-full bg-[#03045E] text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-blue-900/20 hover:bg-[#023E8A] transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3">
                                Simpan Keputusan
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </form>
                    @elseif($submission->status === \App\Models\CulturalSubmission::STATUS_FIELD_VERIFICATION)
                        <!-- Field Verification Form -->
                        <form action="{{ route('validator.submissions.field-verification', $submission) }}" method="POST" class="space-y-8">
                            @csrf
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block">Tanggal Kunjungan</label>
                                    <input type="date" name="visit_date" class="w-full rounded-xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] font-bold text-[#03045E]" required>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block">Latitude (GPS)</label>
                                        <input type="text" name="verified_latitude" value="{{ $submission->latitude }}" class="w-full rounded-xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] font-bold text-[#03045E]" placeholder="-6.xxx">
                                    </div>
                                    <div>
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block">Longitude (GPS)</label>
                                        <input type="text" name="verified_longitude" value="{{ $submission->longitude }}" class="w-full rounded-xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] font-bold text-[#03045E]" placeholder="106.xxx">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block">Temuan di Lapangan</label>
                                <textarea name="notes" rows="4" class="w-full rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] font-medium text-slate-700 transition-all placeholder:text-slate-300" placeholder="Jelaskan kondisi fisik objek di lapangan..." required></textarea>
                            </div>

                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 block">Rekomendasi Akhir</label>
                                <div class="grid grid-cols-1 gap-3">
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="recommendation" value="verified" class="peer sr-only" required>
                                        <div class="p-5 rounded-2xl border-2 border-slate-100 bg-slate-50 transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:bg-white flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-400 peer-checked:text-emerald-500">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div>
                                                <span class="block font-black text-xs uppercase tracking-widest text-[#03045E]">Validkan & Verifikasi</span>
                                                <span class="text-[10px] text-slate-400 font-medium">Data sesuai dengan kondisi lapangan</span>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="recommendation" value="rejected" class="peer sr-only">
                                        <div class="p-5 rounded-2xl border-2 border-slate-100 bg-slate-50 transition-all peer-checked:border-rose-500 peer-checked:bg-rose-50 hover:bg-white flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-400 peer-checked:text-rose-500">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </div>
                                            <div>
                                                <span class="block font-black text-xs uppercase tracking-widest text-[#03045E]">Tolak Permanen</span>
                                                <span class="text-[10px] text-slate-400 font-medium">Data tidak ditemukan atau palsu</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-emerald-900/20 hover:shadow-emerald-900/40 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-3">
                                Selesaikan Verifikasi
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Review History -->
            @if($submission->administrativeReviews->isNotEmpty() || $submission->fieldVerifications->isNotEmpty())
            <div class="bg-slate-50 rounded-[2.5rem] p-10 border border-slate-200/60">
                <h3 class="font-black text-sm text-[#03045E] uppercase tracking-widest mb-8 flex items-center gap-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#0077B6]"></span>
                    Riwayat Review
                </h3>
                <div class="space-y-6">
                    @foreach($submission->administrativeReviews as $review)
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Adm Review • {{ $review->created_at->format('d/m/Y') }}</p>
                            <p class="text-xs font-bold text-slate-700 italic">"{{ $review->notes }}"</p>
                            <div class="mt-2 text-[9px] font-black uppercase tracking-widest {{ $review->action === 'forwarded' ? 'text-emerald-500' : 'text-rose-500' }}">Hasil: {{ $review->action }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-layouts.validator>
