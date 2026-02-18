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
                <span class="text-[#03045E] font-bold">Review Workspace</span>
            </nav>
            <a href="{{ route('validator.submissions.show', $submission) }}" class="text-xs font-black uppercase tracking-widest text-[#0077B6] hover:text-[#03045E] transition-colors flex items-center gap-2 group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
                Kembali ke Detail
            </a>
        </div>
    </x-slot>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4"
             class="mb-8 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-lg shadow-emerald-100/50">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-8 bg-rose-50 border border-rose-200 text-rose-700 px-6 py-4 rounded-2xl shadow-lg shadow-rose-100/50">
            <div class="flex items-center gap-3 mb-2">
                <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                <span class="font-black text-xs uppercase tracking-widest">Terjadi Kesalahan</span>
            </div>
            <ul class="list-disc list-inside text-sm font-medium space-y-1 ml-8">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 pb-12 items-start"
         x-data="reviewWorkspace()">

        <!-- Left: Submission Details & Files -->
        <div class="lg:col-span-7 space-y-10">
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden hover:shadow-2xl transition-shadow duration-500">
                <div class="p-10 border-b border-slate-50 flex items-center justify-between bg-gradient-to-r from-slate-50/80 to-white">
                    <div>
                        <h3 class="font-black text-xl text-[#03045E] tracking-tight">Informasi Pengajuan</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">SUB-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <span @class([
                        'px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border animate-pulse',
                        'bg-blue-50 text-blue-600 border-blue-100' => $submission->status === 'administrative_review',
                        'bg-indigo-50 text-indigo-600 border-indigo-100' => $submission->status === 'field_verification',
                    ])>
                        {{ $submission->status_label }}
                    </span>
                </div>
                <div class="p-10 space-y-8">
                    <!-- Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="group p-5 rounded-2xl hover:bg-slate-50/80 transition-colors duration-300">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block group-hover:text-[#0077B6] transition-colors">Nama Objek</label>
                            <p class="text-sm font-bold text-[#03045E] leading-relaxed">{{ $submission->name }}</p>
                        </div>
                        <div class="group p-5 rounded-2xl hover:bg-slate-50/80 transition-colors duration-300">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block group-hover:text-[#0077B6] transition-colors">Kategori</label>
                            <p class="text-sm font-bold text-[#03045E] leading-relaxed">{{ $submission->category }}</p>
                        </div>
                    </div>

                    <div class="group p-5 rounded-2xl hover:bg-slate-50/80 transition-colors duration-300">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block group-hover:text-[#0077B6] transition-colors">Alamat / Lokasi</label>
                        <p class="text-sm font-bold text-slate-600 leading-relaxed">{{ $submission->address }}</p>
                    </div>

                    <div class="group p-5 rounded-2xl hover:bg-slate-50/80 transition-colors duration-300">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block group-hover:text-[#0077B6] transition-colors">Koordinat GPS</label>
                        <div class="flex items-center gap-4">
                            <span class="px-3 py-1.5 bg-slate-100 rounded-lg text-xs font-mono font-bold text-slate-600">{{ $submission->latitude }}, {{ $submission->longitude }}</span>
                        </div>
                    </div>

                    <div class="group p-5 rounded-2xl hover:bg-slate-50/80 transition-colors duration-300">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block group-hover:text-[#0077B6] transition-colors">Deskripsi</label>
                        <div class="prose prose-slate prose-sm font-medium text-slate-600 leading-relaxed max-w-none">
                            {{ $submission->description }}
                        </div>
                    </div>

                    <!-- Files Section -->
                    <div class="p-5 rounded-2xl bg-slate-50/50 border border-slate-100">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 block flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                            Dokumen Pendukung ({{ $submission->files->count() }})
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse($submission->files as $file)
                                <a href="{{ $file->url }}" target="_blank" class="p-4 rounded-2xl border border-slate-100 bg-white flex items-center gap-4 group hover:border-[#0077B6]/30 hover:shadow-lg hover:shadow-blue-500/5 hover:-translate-y-0.5 transition-all duration-300">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[#0077B6] shadow-sm border border-slate-100 group-hover:bg-[#0077B6] group-hover:text-white group-hover:shadow-lg group-hover:shadow-blue-500/20 transition-all duration-300">
                                        @if($file->file_type === 'image')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        @elseif($file->file_type === 'video')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-black text-[#03045E] truncate group-hover:text-[#0077B6] transition-colors">{{ $file->original_name }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight mt-0.5">{{ strtoupper($file->file_type) }} • {{ $file->file_size_human }}</p>
                                    </div>
                                    <svg class="w-4 h-4 text-slate-300 group-hover:text-[#0077B6] group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            @empty
                                <div class="col-span-2 text-center py-8 text-slate-400">
                                    <svg class="w-10 h-10 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    <p class="text-xs font-bold uppercase tracking-widest">Tidak Ada Dokumen</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengusul Info Card -->
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white p-8 hover:shadow-2xl transition-shadow duration-500">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Informasi Pengusul
                </h3>
                <div class="flex items-center gap-4 group">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#03045E] to-[#0077B6] flex items-center justify-center text-lg font-black text-white shadow-xl shadow-blue-900/20 group-hover:scale-105 transition-transform duration-300">
                        {{ substr($submission->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-base font-black text-[#03045E]">{{ $submission->user->name }}</p>
                        <p class="text-xs font-bold text-slate-400 mt-1">{{ $submission->user->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Review Actions -->
        <div class="lg:col-span-5 space-y-10">
            <!-- Focused Review Form -->
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-blue-900/10 border-2 border-[#0077B6]/20 overflow-hidden sticky top-8 hover:border-[#0077B6]/40 transition-colors duration-500">
                <div class="bg-gradient-to-r from-[#03045E] to-[#0077B6] p-8 text-white relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
                    <div class="absolute -left-4 -bottom-4 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>
                    <div class="relative z-10 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-sm flex items-center justify-center border border-white/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h2 class="font-black text-xl tracking-tight">Keputusan Validasi</h2>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-blue-200 mt-0.5">
                                Tahap: {{ $submission->status === 'administrative_review' ? 'Review Administratif' : 'Verifikasi Lapangan' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-10">
                    @if($submission->status === \App\Models\CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW)
                        <!-- Administrative Review Form -->
                        <form id="reviewForm" action="{{ route('validator.submissions.review', $submission) }}" method="POST" class="space-y-8" @submit.prevent="confirmSubmit">
                            @csrf
                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 block">Keputusan Review</label>
                                <div class="grid grid-cols-1 gap-3">
                                    <!-- Forward -->
                                    <label class="relative cursor-pointer group" @click="selectAction('forwarded')">
                                        <input type="radio" name="action" value="forwarded" class="peer sr-only" required x-model="selectedAction">
                                        <div class="p-5 rounded-2xl border-2 border-slate-100 bg-slate-50/50 transition-all duration-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:shadow-lg peer-checked:shadow-emerald-100/50 hover:bg-white hover:border-slate-200 hover:shadow-md flex items-center gap-4 group-active:scale-[0.98]">
                                            <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-slate-300 shadow-sm border border-slate-100 peer-checked:text-emerald-500 peer-checked:bg-emerald-50 peer-checked:border-emerald-200 transition-all duration-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                                            </div>
                                            <div class="flex-1">
                                                <span class="block font-black text-xs uppercase tracking-widest text-[#03045E]">Forward Lapangan</span>
                                                <span class="text-[10px] text-slate-400 font-medium leading-relaxed">Lanjutkan ke tahap pemeriksaan fisik di lokasi</span>
                                            </div>
                                            <div class="w-5 h-5 rounded-full border-2 border-slate-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center transition-all duration-300 shrink-0">
                                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                        </div>
                                    </label>
                                    <!-- Revision -->
                                    <label class="relative cursor-pointer group" @click="selectAction('revision')">
                                        <input type="radio" name="action" value="revision" class="peer sr-only" x-model="selectedAction">
                                        <div class="p-5 rounded-2xl border-2 border-slate-100 bg-slate-50/50 transition-all duration-300 peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:shadow-lg peer-checked:shadow-amber-100/50 hover:bg-white hover:border-slate-200 hover:shadow-md flex items-center gap-4 group-active:scale-[0.98]">
                                            <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-slate-300 shadow-sm border border-slate-100 peer-checked:text-amber-500 peer-checked:bg-amber-50 peer-checked:border-amber-200 transition-all duration-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </div>
                                            <div class="flex-1">
                                                <span class="block font-black text-xs uppercase tracking-widest text-[#03045E]">Minta Revisi</span>
                                                <span class="text-[10px] text-slate-400 font-medium leading-relaxed">Ada berkas yang perlu diperbaiki / dilengkapi</span>
                                            </div>
                                            <div class="w-5 h-5 rounded-full border-2 border-slate-200 peer-checked:border-amber-500 peer-checked:bg-amber-500 flex items-center justify-center transition-all duration-300 shrink-0">
                                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                        </div>
                                    </label>
                                    <!-- Reject -->
                                    <label class="relative cursor-pointer group" @click="selectAction('rejected')">
                                        <input type="radio" name="action" value="rejected" class="peer sr-only" x-model="selectedAction">
                                        <div class="p-5 rounded-2xl border-2 border-slate-100 bg-slate-50/50 transition-all duration-300 peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:shadow-lg peer-checked:shadow-rose-100/50 hover:bg-white hover:border-slate-200 hover:shadow-md flex items-center gap-4 group-active:scale-[0.98]">
                                            <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-slate-300 shadow-sm border border-slate-100 peer-checked:text-rose-500 peer-checked:bg-rose-50 peer-checked:border-rose-200 transition-all duration-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </div>
                                            <div class="flex-1">
                                                <span class="block font-black text-xs uppercase tracking-widest text-[#03045E]">Tolak Pengajuan</span>
                                                <span class="text-[10px] text-slate-400 font-medium leading-relaxed">Pengajuan tidak memenuhi persyaratan</span>
                                            </div>
                                            <div class="w-5 h-5 rounded-full border-2 border-slate-200 peer-checked:border-rose-500 peer-checked:bg-rose-500 flex items-center justify-center transition-all duration-300 shrink-0">
                                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 block">
                                    Catatan Review
                                    <span class="text-rose-400 ml-1">*Wajib diisi</span>
                                </label>
                                <textarea name="notes" rows="4" x-model="notes"
                                    class="w-full rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 font-medium text-slate-700 transition-all duration-300 placeholder:text-slate-300 hover:border-slate-200"
                                    placeholder="Berikan instruksi atau alasan keputusan secara mendetail..." required></textarea>
                                <p class="text-right text-[10px] font-bold mt-2 transition-colors"
                                   :class="notes.length < 10 ? 'text-slate-300' : 'text-emerald-500'">
                                    <span x-text="notes.length"></span> / min 10 karakter
                                </p>
                            </div>

                            <button type="submit"
                                :disabled="!selectedAction || notes.length < 10"
                                :class="selectedAction && notes.length >= 10
                                    ? 'bg-gradient-to-r from-[#03045E] to-[#0077B6] hover:shadow-blue-900/40 hover:-translate-y-1 cursor-pointer'
                                    : 'bg-slate-200 text-slate-400 cursor-not-allowed shadow-none'"
                                class="w-full text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-blue-900/20 transition-all duration-300 active:scale-95 flex items-center justify-center gap-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Simpan Keputusan
                            </button>
                        </form>

                    @elseif($submission->status === \App\Models\CulturalSubmission::STATUS_FIELD_VERIFICATION)
                        <!-- Field Verification Form -->
                        <form id="reviewForm" action="{{ route('validator.submissions.field-verification', $submission) }}" method="POST" class="space-y-8" @submit.prevent="confirmSubmit">
                            @csrf
                            <div class="grid grid-cols-1 gap-6">
                                <div class="group">
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block group-hover:text-[#0077B6] transition-colors">Tanggal Kunjungan</label>
                                    <input type="date" name="visit_date" class="w-full rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 font-bold text-[#03045E] transition-all duration-300 hover:border-slate-200" required>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="group">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block group-hover:text-[#0077B6] transition-colors">Latitude (GPS)</label>
                                        <input type="text" name="verified_latitude" value="{{ $submission->latitude }}" class="w-full rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 font-mono text-xs text-[#03045E] transition-all duration-300 hover:border-slate-200" placeholder="-6.xxx">
                                    </div>
                                    <div class="group">
                                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block group-hover:text-[#0077B6] transition-colors">Longitude (GPS)</label>
                                        <input type="text" name="verified_longitude" value="{{ $submission->longitude }}" class="w-full rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 font-mono text-xs text-[#03045E] transition-all duration-300 hover:border-slate-200" placeholder="106.xxx">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block">
                                    Temuan di Lapangan
                                    <span class="text-rose-400 ml-1">*Wajib diisi</span>
                                </label>
                                <textarea name="notes" rows="4" x-model="notes"
                                    class="w-full rounded-2xl border-slate-100 bg-slate-50 focus:bg-white focus:border-[#0077B6] focus:ring-4 focus:ring-[#0077B6]/10 font-medium text-slate-700 transition-all duration-300 placeholder:text-slate-300 hover:border-slate-200"
                                    placeholder="Jelaskan kondisi fisik objek di lapangan secara mendetail..." required></textarea>
                                <p class="text-right text-[10px] font-bold mt-2 transition-colors"
                                   :class="notes.length < 10 ? 'text-slate-300' : 'text-emerald-500'">
                                    <span x-text="notes.length"></span> / min 10 karakter
                                </p>
                            </div>

                            <div>
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 block">Rekomendasi Akhir</label>
                                <div class="grid grid-cols-1 gap-3">
                                    <!-- Verified -->
                                    <label class="relative cursor-pointer group" @click="selectAction('verified')">
                                        <input type="radio" name="recommendation" value="verified" class="peer sr-only" required x-model="selectedAction">
                                        <div class="p-5 rounded-2xl border-2 border-slate-100 bg-slate-50/50 transition-all duration-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:shadow-lg peer-checked:shadow-emerald-100/50 hover:bg-white hover:border-slate-200 hover:shadow-md flex items-center gap-4 group-active:scale-[0.98]">
                                            <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-slate-300 shadow-sm border border-slate-100 peer-checked:text-emerald-500 peer-checked:bg-emerald-50 peer-checked:border-emerald-200 transition-all duration-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div class="flex-1">
                                                <span class="block font-black text-xs uppercase tracking-widest text-[#03045E]">Validkan & Verifikasi</span>
                                                <span class="text-[10px] text-slate-400 font-medium leading-relaxed">Data sesuai dengan kondisi di lapangan</span>
                                            </div>
                                            <div class="w-5 h-5 rounded-full border-2 border-slate-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 flex items-center justify-center transition-all duration-300 shrink-0">
                                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                        </div>
                                    </label>
                                    <!-- Reject -->
                                    <label class="relative cursor-pointer group" @click="selectAction('rejected')">
                                        <input type="radio" name="recommendation" value="rejected" class="peer sr-only" x-model="selectedAction">
                                        <div class="p-5 rounded-2xl border-2 border-slate-100 bg-slate-50/50 transition-all duration-300 peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:shadow-lg peer-checked:shadow-rose-100/50 hover:bg-white hover:border-slate-200 hover:shadow-md flex items-center gap-4 group-active:scale-[0.98]">
                                            <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-slate-300 shadow-sm border border-slate-100 peer-checked:text-rose-500 peer-checked:bg-rose-50 peer-checked:border-rose-200 transition-all duration-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </div>
                                            <div class="flex-1">
                                                <span class="block font-black text-xs uppercase tracking-widest text-[#03045E]">Tolak Permanen</span>
                                                <span class="text-[10px] text-slate-400 font-medium leading-relaxed">Data tidak ditemukan atau palsu di lapangan</span>
                                            </div>
                                            <div class="w-5 h-5 rounded-full border-2 border-slate-200 peer-checked:border-rose-500 peer-checked:bg-rose-500 flex items-center justify-center transition-all duration-300 shrink-0">
                                                <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <button type="submit"
                                :disabled="!selectedAction || notes.length < 10"
                                :class="selectedAction && notes.length >= 10
                                    ? 'bg-gradient-to-r from-emerald-600 to-teal-600 hover:shadow-emerald-900/40 hover:-translate-y-1 cursor-pointer'
                                    : 'bg-slate-200 text-slate-400 cursor-not-allowed shadow-none'"
                                class="w-full text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-emerald-900/20 transition-all duration-300 active:scale-95 flex items-center justify-center gap-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Selesaikan Verifikasi
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Review History -->
            @if($submission->administrativeReviews->isNotEmpty() || $submission->fieldVerifications->isNotEmpty())
            <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-xl shadow-slate-200/50 hover:shadow-2xl transition-shadow duration-500">
                <h3 class="font-black text-sm text-[#03045E] uppercase tracking-widest mb-8 flex items-center gap-3">
                    <div class="w-6 h-6 rounded-lg bg-[#0077B6]/10 flex items-center justify-center">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#0077B6]"></span>
                    </div>
                    Riwayat Review
                </h3>
                <div class="space-y-6">
                    @foreach($submission->administrativeReviews as $review)
                    <div class="flex gap-4 group p-4 rounded-2xl hover:bg-slate-50/80 transition-all duration-300">
                        <div @class([
                            'w-8 h-8 rounded-lg flex items-center justify-center shrink-0 shadow-sm transition-transform duration-300 group-hover:scale-110',
                            'bg-emerald-50 border border-emerald-100 text-emerald-500' => $review->action === 'forwarded',
                            'bg-amber-50 border border-amber-100 text-amber-500' => $review->action === 'revision',
                            'bg-rose-50 border border-rose-100 text-rose-500' => $review->action === 'rejected',
                        ])>
                            @if($review->action === 'forwarded')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                            @elseif($review->action === 'revision')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">
                                    Adm Review •
                                    <span @class([
                                        'text-emerald-500' => $review->action === 'forwarded',
                                        'text-amber-500' => $review->action === 'revision',
                                        'text-rose-500' => $review->action === 'rejected',
                                    ])>{{ ucfirst($review->action) }}</span>
                                </p>
                                <span class="text-[9px] font-bold text-slate-300">{{ $review->created_at->format('d/m/Y') }}</span>
                            </div>
                            <p class="text-xs font-bold text-slate-600 italic leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-100">"{{ $review->notes }}"</p>
                            <p class="text-[9px] font-black text-slate-400 mt-2 uppercase tracking-tighter">Oleh: {{ $review->validator->name }}</p>
                        </div>
                    </div>
                    @endforeach

                    @foreach($submission->fieldVerifications as $fv)
                    <div class="flex gap-4 group p-4 rounded-2xl hover:bg-slate-50/80 transition-all duration-300">
                        <div @class([
                            'w-8 h-8 rounded-lg flex items-center justify-center shrink-0 shadow-sm transition-transform duration-300 group-hover:scale-110',
                            'bg-emerald-50 border border-emerald-100 text-emerald-500' => $fv->recommendation === 'verified',
                            'bg-rose-50 border border-rose-100 text-rose-500' => $fv->recommendation === 'rejected',
                        ])>
                            @if($fv->recommendation === 'verified')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">
                                    Lapangan •
                                    <span @class([
                                        'text-emerald-500' => $fv->recommendation === 'verified',
                                        'text-rose-500' => $fv->recommendation === 'rejected',
                                    ])>{{ $fv->recommendation === 'verified' ? 'Terverifikasi' : 'Ditolak' }}</span>
                                </p>
                                <span class="text-[9px] font-bold text-slate-300">{{ $fv->visit_date->format('d/m/Y') }}</span>
                            </div>
                            <p class="text-xs font-bold text-slate-600 italic leading-relaxed bg-indigo-50/50 p-3 rounded-xl border border-indigo-100">"{{ $fv->notes }}"</p>
                            <p class="text-[9px] font-black text-slate-400 mt-2 uppercase tracking-tighter">Oleh: {{ $fv->validator->name }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div x-show="showModal" x-cloak style="display: none;"
         class="fixed inset-0 flex items-center justify-center z-50"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-[#03045E]/30 backdrop-blur-sm" @click="showModal = false"></div>

        <!-- Modal Panel -->
        <div class="relative bg-white rounded-[2rem] w-full max-w-md mx-4 shadow-2xl shadow-slate-900/20 overflow-hidden"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90 translate-y-8"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-90 translate-y-8">

            <!-- Modal Header -->
            <div class="p-8 pb-0">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg transition-colors"
                         :class="{
                             'bg-emerald-50 text-emerald-500 shadow-emerald-100': selectedAction === 'forwarded' || selectedAction === 'verified',
                             'bg-amber-50 text-amber-500 shadow-amber-100': selectedAction === 'revision',
                             'bg-rose-50 text-rose-500 shadow-rose-100': selectedAction === 'rejected',
                         }">
                        <svg x-show="selectedAction === 'forwarded'" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                        <svg x-show="selectedAction === 'verified'" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <svg x-show="selectedAction === 'revision'" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <svg x-show="selectedAction === 'rejected'" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-xl text-[#03045E] tracking-tight">Konfirmasi Keputusan</h3>
                        <p class="text-xs font-bold text-slate-400 mt-0.5">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="px-8 pb-6">
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 mb-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pengajuan</span>
                        <span class="text-[10px] font-black uppercase tracking-widest"
                              :class="{
                                  'text-emerald-500': selectedAction === 'forwarded' || selectedAction === 'verified',
                                  'text-amber-500': selectedAction === 'revision',
                                  'text-rose-500': selectedAction === 'rejected',
                              }"
                              x-text="actionLabel"></span>
                    </div>
                    <p class="text-sm font-black text-[#03045E] mb-1">{{ $submission->name }}</p>
                    <p class="text-xs text-slate-400 font-bold">SUB-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>

                <p class="text-sm text-slate-500 font-medium leading-relaxed">
                    Apakah Anda yakin ingin <strong class="text-[#03045E]" x-text="actionLabel.toLowerCase()"></strong> pengajuan ini?
                    Keputusan Anda akan langsung mempengaruhi status pengajuan.
                </p>
            </div>

            <!-- Modal Footer -->
            <div class="px-8 pb-8 flex items-center gap-3">
                <button @click="showModal = false"
                    class="flex-1 py-4 rounded-2xl border-2 border-slate-100 bg-white text-slate-600 font-black text-xs uppercase tracking-widest hover:bg-slate-50 hover:border-slate-200 transition-all duration-300 active:scale-95">
                    Batal
                </button>
                <button @click="submitForm()"
                    class="flex-1 py-4 rounded-2xl font-black text-xs uppercase tracking-widest text-white transition-all duration-300 active:scale-95 flex items-center justify-center gap-2 shadow-lg"
                    :class="{
                        'bg-emerald-500 hover:bg-emerald-600 shadow-emerald-200': selectedAction === 'forwarded' || selectedAction === 'verified',
                        'bg-amber-500 hover:bg-amber-600 shadow-amber-200': selectedAction === 'revision',
                        'bg-rose-500 hover:bg-rose-600 shadow-rose-200': selectedAction === 'rejected',
                    }">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    Ya, Konfirmasi
                </button>
            </div>
        </div>
    </div>

    <script>
        function reviewWorkspace() {
            return {
                selectedAction: '',
                notes: '',
                showModal: false,
                submitting: false,

                selectAction(action) {
                    this.selectedAction = action;
                },

                get actionLabel() {
                    const labels = {
                        'forwarded': 'Forward ke Lapangan',
                        'revision': 'Minta Revisi',
                        'rejected': 'Tolak Pengajuan',
                        'verified': 'Verifikasi & Validkan',
                    };
                    return labels[this.selectedAction] || 'Belum dipilih';
                },

                confirmSubmit() {
                    if (!this.selectedAction || this.notes.length < 10) return;
                    this.showModal = true;
                },

                submitForm() {
                    if (this.submitting) return;
                    this.submitting = true;
                    this.showModal = false;
                    document.getElementById('reviewForm').removeEventListener('submit', () => {});
                    document.getElementById('reviewForm').submit();
                }
            }
        }
    </script>
</x-layouts.validator>
