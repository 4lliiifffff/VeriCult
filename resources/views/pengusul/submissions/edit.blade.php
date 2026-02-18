@extends('layouts.pengusul')

@section('content')
<div class="py-10 bg-[#F8FAFC] min-h-screen font-sans" 
     x-data="submissionForm()"
     @dragover.prevent="dragover = true"
     @dragleave.prevent="dragover = false"
     @drop.prevent="dragover = false; handleDrop($event)">

    <!-- Loading Overlay -->
    <div x-show="loading"
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
            <h3 class="text-[#03045E] font-bold text-xl mb-2 text-center">Memperbarui Draft</h3>
            <p class="text-slate-500 text-sm text-center">Mohon tunggu sebentar, kami sedang menyimpan perubahan Anda.</p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-sm font-medium text-slate-400 mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('pengusul.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('pengusul.submissions.index') }}" class="hover:text-[#0077B6] transition-colors">Pengajuan Saya</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('pengusul.submissions.show', $submission) }}" class="hover:text-[#0077B6] transition-colors">Detail</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Edit Pengajuan</span>
        </nav>

        <!-- Page Header -->
        <div class="relative mb-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase bg-{{ $submission->status_color }}-50 text-{{ $submission->status_color }}-600 border border-{{ $submission->status_color }}-100 shadow-sm">
                            {{ $submission->status_label }}
                        </span>
                        <span class="text-slate-300">|</span>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">ID: #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <h1 class="text-4xl font-black text-[#03045E] tracking-tight mb-3">
                        Edit <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#0077B6] to-[#00B4D8]">Pengajuan</span>
                    </h1>
                    <p class="text-slate-500 text-lg max-w-2xl leading-relaxed">
                        Anda sedang memperbarui data untuk <span class="font-bold text-[#03045E]">{{ $submission->name }}</span>.
                    </p>
                </div>
                <div class="flex items-center gap-4 shrink-0">
                    <a href="{{ route('pengusul.submissions.show', $submission) }}" 
                       class="px-5 py-2.5 rounded-xl border-2 border-slate-200 text-slate-600 font-bold text-sm tracking-wide hover:bg-white hover:border-slate-300 hover:shadow-sm transition-all active:scale-[0.98]">
                        Batal
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- Form Section -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden">
                    <div class="p-8 sm:p-10">
                        <form action="{{ route('pengusul.submissions.update', $submission) }}" 
                              method="POST" 
                              enctype="multipart/form-data" 
                              x-ref="editForm" 
                              @submit.prevent="openConfirm()">
                            @csrf
                            @method('PUT')
                            
                            @include('pengusul.submissions.partials.form')

                            <!-- Footer Actions -->
                            <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-6">
                                <div class="flex items-center gap-3 text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="text-sm font-medium italic">Terakhir diperbarui: {{ $submission->updated_at->diffForHumans() }}</span>
                                </div>
                                
                                <button type="submit" 
                                        class="w-full sm:w-auto px-10 py-4 bg-gradient-to-br from-[#03045E] via-[#023E8A] to-[#0077B6] text-white font-bold rounded-2xl shadow-xl shadow-[#03045E]/20 hover:shadow-2xl hover:shadow-[#03045E]/30 hover:-translate-y-0.5 transition-all duration-300 active:scale-95 group"
                                        :disabled="loading">
                                    <div class="flex items-center justify-center gap-3">
                                        <span class="tracking-wider uppercase text-sm">Simpan Perubahan</span>
                                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </div>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6">
                <!-- Progress Card -->
                <div class="bg-gradient-to-br from-[#03045E] to-[#023E8A] rounded-[2rem] p-8 text-white shadow-2xl shadow-[#03045E]/40 relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <span class="font-bold tracking-tight text-xl">Kelengkapan</span>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between text-white/70 text-sm">
                                <span>Kesiapan Data</span>
                                <span x-text="calculateProgress() + '%'">0%</span>
                            </div>
                            <div class="h-2 bg-white/10 rounded-full overflow-hidden border border-white/5">
                                <div class="h-full bg-gradient-to-r from-[#00B4D8] to-[#0077B6] rounded-full transition-all duration-1000" :style="'width: ' + calculateProgress() + '%'"></div>
                            </div>
                        </div>
                        <p class="mt-6 text-white/60 text-xs leading-relaxed italic">
                            Pastikan seluruh informasi sudah akurat sebelum melakukan finalisasi di halaman detail.
                        </p>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm space-y-6">
                    <h3 class="text-[#03045E] font-black text-lg flex items-center gap-3">
                        <span class="w-1.5 h-6 bg-[#0077B6] rounded-full"></span>
                        Informasi Penting
                    </h3>
                    <div class="space-y-5">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <h4 class="text-sm font-bold text-slate-700 mb-2">Edit File</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Menambahkan file baru akan menambah daftar file yang sudah ada. Anda dapat menghapus file lama melalui tombol hapus di setiap kartu file.
                            </p>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <h4 class="text-sm font-bold text-slate-700 mb-2">Batas Pengajuan</h4>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Selama status masih <span class="font-bold">Draft</span>, Anda bebas melakukan perubahan tanpa batas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal Redesigned -->
    <x-modal name="confirm-update-submission" :show="false" focusable>
        <div class="p-8 sm:p-10">
            <div class="flex flex-col items-center text-center mb-10">
                <div class="w-20 h-20 bg-blue-50 rounded-3xl flex items-center justify-center text-[#0077B6] mb-6 shadow-inner animate-bounce-slow">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </div>
                <h2 class="text-2xl font-black text-[#03045E] mb-2">Simpan Perubahan?</h2>
                <p class="text-slate-500 max-w-xs">Seluruh data yang Anda ubah akan diperbarui dalam sistem sebagai draft terbaru.</p>
            </div>

            <div class="bg-slate-50 rounded-2xl p-6 mb-8 border border-slate-100 text-center">
                <p class="text-xs text-slate-500 leading-relaxed capitalize font-medium">
                    {{ $submission->name }} • {{ $submission->category }}
                </p>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                <button type="button" 
                        @click="$dispatch('close')" 
                        class="px-6 py-4 rounded-2xl border-2 border-slate-100 text-slate-600 font-bold text-sm tracking-widest uppercase hover:bg-slate-50 transition-all active:scale-[0.98]">
                    Batal
                </button>
                <button type="button" 
                        @click="doSubmit()" 
                        class="px-6 py-4 rounded-2xl bg-gradient-to-r from-[#03045E] to-[#023E8A] text-white font-bold text-sm tracking-widest uppercase shadow-xl shadow-[#03045E]/20 hover:shadow-2xl hover:shadow-[#03045E]/30 transition-all active:scale-[0.98]">
                    Perbarui
                </button>
            </div>
        </div>
    </x-modal>

    <!-- Max File Warning Modal -->
    <x-modal name="max-file-warning" :show="false" focusable>
        <div class="p-8 sm:p-10">
            <div class="flex flex-col items-center text-center mb-8">
                <div class="w-20 h-20 bg-amber-50 rounded-3xl flex items-center justify-center text-amber-600 mb-6 shadow-inner scale-110">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h2 class="text-2xl font-black text-[#03045E] mb-2">Batas File Tercapai</h2>
                <p class="text-slate-500">Total file (lama + baru) tidak boleh melebihi 5 file pendukung.</p>
            </div>

            <div class="bg-amber-50/50 rounded-2xl p-6 border border-amber-100 mb-8">
                <p class="text-sm text-amber-800 leading-relaxed text-center italic">
                    Beberapa file terakhir yang Anda pilih telah diabaikan untuk tetap mematuhi batas kuota.
                </p>
            </div>

            <button type="button" 
                    @click="$dispatch('close')" 
                    class="w-full px-6 py-4 rounded-2xl bg-[#03045E] text-white font-bold text-sm tracking-widest uppercase shadow-xl shadow-[#03045E]/20 hover:bg-[#023E8A] transition-all active:scale-[0.98]">
                SAYA MENGERTI
            </button>
        </div>
    </x-modal>

</div>

<style>
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-bounce-slow {
        animation: bounce-slow 3s ease-in-out infinite;
    }
</style>

<script>
    function submissionForm() {
        return {
            loading: false,
            files: [],
            dragover: false,
            
            init() {
                // Initialize component
            },

            handleFileSelect(e) {
                const newFiles = Array.from(e.target.files);
                this.addFiles(newFiles);
            },

            handleDrop(e) {
                const droppedFiles = Array.from(e.dataTransfer.files);
                this.addFiles(droppedFiles);
            },

            addFiles(newFiles) {
                const dt = new DataTransfer();
                this.files.forEach(f => dt.items.add(f));

                newFiles.forEach(f => {
                    if (!this.files.some(existing => 
                        existing.name === f.name && 
                        existing.size === f.size && 
                        existing.lastModified === f.lastModified
                    )) {
                        dt.items.add(f);
                    }
                });

                // Calculate total files including existing ones from DB
                const existingFilesCount = {{ $submission->files->count() }};
                if (dt.items.length + existingFilesCount > 5) {
                    this.$dispatch('open-modal', 'max-file-warning');
                    const availableSlots = 5 - existingFilesCount;
                    const limitedDt = new DataTransfer();
                    for (let i = 0; i < Math.min(dt.items.length, availableSlots); i++) {
                        limitedDt.items.add(dt.files[i]);
                    }
                    this.updateFiles(limitedDt);
                } else {
                    this.updateFiles(dt);
                }
            },

            removeFile(index) {
                const dt = new DataTransfer();
                this.files.filter((_, i) => i !== index).forEach(f => dt.items.add(f));
                this.updateFiles(dt);
            },

            updateFiles(dt) {
                this.files = Array.from(dt.files);
                const input = document.getElementById('files');
                if (input) input.files = dt.files;
            },

            formatSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + ['Bytes', 'KB', 'MB', 'GB'][i];
            },

            calculateProgress() {
                const fields = ['name', 'category', 'address', 'description'];
                let filledCount = 0;
                fields.forEach(id => {
                    const el = document.getElementById(id);
                    if (el && el.value.trim() !== '') filledCount++;
                });
                // Check files (either existing or new)
                if ({{ $submission->files->count() }} > 0 || this.files.length > 0) filledCount++;
                return Math.round((filledCount / (fields.length + 1)) * 100);
            },

            openConfirm() {
                this.$dispatch('open-modal', 'confirm-update-submission');
            },

            doSubmit() {
                this.loading = true;
                this.$dispatch('close');
                this.$nextTick(() => {
                    this.$refs.editForm.submit();
                });
            }
        }
    }
</script>
@endsection
