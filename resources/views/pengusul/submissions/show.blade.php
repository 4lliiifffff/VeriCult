@extends('layouts.pengusul')

@section('content')
<div class="py-6 bg-[#F8FAFC] min-h-screen font-sans">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
        
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('pengusul.submissions.index') }}" class="p-2 rounded-lg hover:bg-white transition-colors">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div class="flex-1">
                <h2 class="font-bold text-2xl text-[#03045E] leading-tight tracking-tight">
                    Detail Pengajuan
                </h2>
                <p class="text-sm text-slate-500 mt-1">{{ $submission->name }}</p>
            </div>
            <div>
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-{{ $submission->status_color }}-50 text-{{ $submission->status_color }}-600 border border-{{ $submission->status_color }}-100">
                    {{ $submission->status_label }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-5">
                
                <!-- Details Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100/60 overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-[#03045E]">Informasi Pengajuan</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Kebudayaan</label>
                            <p class="text-base font-semibold text-slate-700">{{ $submission->name }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Kategori</label>
                                <p class="text-sm text-slate-600">{{ $submission->category }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Status</label>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-{{ $submission->status_color }}-50 text-{{ $submission->status_color }}-600 border border-{{ $submission->status_color }}-100">
                                    {{ $submission->status_label }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat Lokasi</label>
                            <p class="text-sm text-slate-600">{{ $submission->address }}</p>
                        </div>

                        <!-- Files -->
                        @if($submission->files->count() > 0)
                        <div class="mt-8">
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                                <span>Dokumen & Bukti Pendukung</span>
                                <span class="px-2 py-0.5 rounded-full bg-[#0077B6] text-white text-[10px]">{{ $submission->files->count() }}</span>
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($submission->files as $file)
                                <div class="relative flex items-center p-4 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md hover:border-[#0077B6]/30 transition-all duration-300 group">
                                    <div class="flex items-center gap-4 overflow-hidden flex-1">
                                        <!-- Icon -->
                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-slate-50 text-slate-400 group-hover:scale-110 group-hover:bg-[#0077B6]/10 group-hover:text-[#0077B6] transition-all duration-300 shrink-0">
                                            @if($file->file_icon == 'image')
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            @elseif($file->file_icon == 'video')
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10z"></path></svg>
                                            @elseif($file->file_icon == 'document')
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            @else
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                            @endif
                                        </div>
                                        
                                        <!-- Meta -->
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-slate-700 truncate group-hover:text-[#0077B6] transition-colors" title="{{ $file->original_name }}">
                                                {{ $file->original_name }}
                                            </p>
                                            <p class="text-xs text-slate-500 mt-0.5">
                                                {{ $file->file_size_human }} • {{ strtoupper($file->file_type) }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Action -->
                                    <a href="{{ $file->url }}" target="_blank" 
                                       class="absolute inset-0 z-10 focus:outline-none" 
                                       title="Download/Lihat {{ $file->original_name }}">
                                    </a>
                                    
                                    <div class="z-20 p-2 text-slate-300 group-hover:text-[#0077B6] transition-colors">
                                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Deskripsi</label>
                            <p class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $submission->description }}</p>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <div class="grid grid-cols-2 gap-4 text-xs text-slate-500">
                                <div>
                                    <span class="font-bold">Dibuat:</span> {{ $submission->created_at->format('d M Y, H:i') }}
                                </div>
                                <div>
                                    <span class="font-bold">Diperbarui:</span> {{ $submission->updated_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100/60 overflow-hidden p-6">
                    <h3 class="text-base font-bold text-[#03045E] mb-4">Aksi</h3>
                    <div class="flex flex-wrap gap-3">
                        @if($submission->isEditable())
                        <a href="{{ route('pengusul.submissions.edit', $submission) }}" class="inline-flex items-center px-4 py-2 bg-amber-50 text-amber-700 border border-amber-200 font-semibold rounded-lg hover:bg-amber-100 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit Pengajuan
                        </a>
                        @endif

                        @if($submission->canBeSubmitted())
                        <form action="{{ route('pengusul.submissions.submit', $submission) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengirim pengajuan ini untuk direview? Anda tidak dapat mengeditnya setelah dikirim.')">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#0077B6] to-[#00B4D8] text-white font-semibold rounded-lg shadow-lg shadow-[#0077B6]/30 hover:from-[#023E8A] hover:to-[#0077B6] transition-all">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Kirim untuk Review
                            </button>
                        </form>
                        @endif

                        @if($submission->status == 'draft')
                        <form action="{{ route('pengusul.submissions.destroy', $submission) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus draft ini?')" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-50 text-red-600 border border-red-200 font-semibold rounded-lg hover:bg-red-100 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus Draft
                            </button>
                        </form>
                        @endif

                        <a href="{{ route('pengusul.submissions.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-50 text-slate-600 border border-slate-200 font-semibold rounded-lg hover:bg-slate-100 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>

            </div>

            <!-- Timeline Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100/60 overflow-hidden p-6 sticky top-6">
                    <h3 class="text-base font-bold text-[#03045E] mb-4">Timeline Pengajuan</h3>
                    @include('pengusul.submissions.partials.timeline')
                </div>
            </div>
        </div>

    </div>
</div>


@endsection
