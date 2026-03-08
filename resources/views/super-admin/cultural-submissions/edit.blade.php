<x-layouts.super-admin>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('super-admin.cultural-submissions.show', $submission) }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-[#03045E] shadow-sm hover:bg-[#03045E] hover:text-white transition-all shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div class="min-w-0">
                    <h1 class="text-xl sm:text-2xl font-black text-[#03045E] tracking-tighter truncate break-words">Edit: {{ $submission->name }}</h1>
                    <p class="text-slate-500 font-medium text-[11px] sm:text-sm">Pembaruan data resmi kebudayaan.</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white p-6 sm:p-12 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white">
            <form action="{{ route('super-admin.cultural-submissions.update', $submission) }}" method="POST" class="space-y-8 sm:space-y-10">
                @csrf
                @method('PUT')

                <!-- Publication Status (Only Editable Part) -->
                <div class="p-6 sm:p-8 bg-blue-50/50 rounded-2xl sm:rounded-3xl border border-blue-100/50 space-y-6">
                    <h3 class="text-xs font-black text-[#0077B6] uppercase tracking-[0.3em] flex items-center gap-2">
                        <span class="w-2 h-4 bg-[#0077B6] rounded-full"></span>
                        Pengaturan Publikasi
                    </h3>
                    
                    <div class="max-w-md">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block">Status Visibilitas Publik</label>
                        <select name="status" class="w-full px-5 py-4 bg-white border-2 border-slate-200 rounded-2xl focus:border-[#0077B6] focus:ring-0 transition-all font-bold text-[#03045E] shadow-sm">
                            <option value="{{ \App\Models\CulturalSubmission::STATUS_PUBLISHED }}" {{ $submission->status === \App\Models\CulturalSubmission::STATUS_PUBLISHED ? 'selected' : '' }}>Terbitkan (Published)</option>
                            <option value="{{ \App\Models\CulturalSubmission::STATUS_VERIFIED }}" {{ $submission->status === \App\Models\CulturalSubmission::STATUS_VERIFIED ? 'selected' : '' }}>Arsipkan (Verified but Hidden)</option>
                            <option value="{{ \App\Models\CulturalSubmission::STATUS_REJECTED }}" {{ $submission->status === \App\Models\CulturalSubmission::STATUS_REJECTED ? 'selected' : '' }}>Tolak / Batalkan (Rejected)</option>
                        </select>
                        <p class="mt-3 text-[10px] text-slate-400 font-medium italic leading-relaxed">Pilih "Terbitkan" untuk menampilkan data ini di galeri publik. Pilih "Arsipkan" untuk menyembunyikan tanpa menghapus data.</p>
                    </div>
                </div>

                <!-- Basic Info (Read Only) -->
                <div class="space-y-6 opacity-80">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] pb-2 border-b border-slate-50 flex items-center gap-2">
                        <span class="w-2 h-4 bg-slate-200 rounded-full"></span>
                        Informasi Utama (Read-Only)
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Nama Objek Kebudayaan</label>
                            <input type="text" value="{{ $submission->name }}" readonly class="w-full px-5 py-3.5 bg-slate-100 border-2 border-slate-200 rounded-2xl font-bold text-slate-500 cursor-not-allowed">
                        </div>

                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Kategori</label>
                            <input type="text" value="{{ $submission->category }}" readonly class="w-full px-5 py-3.5 bg-slate-100 border-2 border-slate-200 rounded-2xl font-bold text-slate-500 cursor-not-allowed">
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Deskripsi Singkat</label>
                        <textarea readonly rows="4" class="w-full px-5 py-3.5 bg-slate-100 border-2 border-slate-200 rounded-2xl font-bold text-slate-500 cursor-not-allowed">{{ $submission->description }}</textarea>
                    </div>
                </div>

                <!-- Strategic Category Data (Read Only) -->
                <div class="space-y-6 opacity-80">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] pb-2 border-b border-slate-50 flex items-center gap-2">
                        <span class="w-2 h-4 bg-slate-100 rounded-full"></span>
                        Detail Strategis (Read-Only)
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($fields as $name => $field)
                            @if($field['type'] !== 'file')
                            <div class="{{ $field['type'] === 'textarea' ? 'md:col-span-2' : '' }}">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">{{ $field['label'] }}</label>
                                
                                @if($field['type'] === 'textarea')
                                    <textarea readonly rows="3" class="w-full px-5 py-3.5 bg-slate-100 border-2 border-slate-200 rounded-2xl font-bold text-slate-500 cursor-not-allowed">{{ $submission->category_data[$name] ?? '' }}</textarea>
                                @else
                                    <input type="text" value="{{ $submission->category_data[$name] ?? '' }}" readonly class="w-full px-5 py-3.5 bg-slate-100 border-2 border-slate-200 rounded-2xl font-bold text-slate-500 cursor-not-allowed">
                                @endif
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="pt-8 sm:pt-10 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 sm:gap-4 border-t border-slate-50">
                    <a href="{{ route('super-admin.cultural-submissions.show', $submission) }}" class="flex items-center justify-center px-8 py-4 bg-slate-100 text-slate-500 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all text-center">Batalkan</a>
                    <button type="submit" class="px-12 py-4 bg-[#03045E] text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#0077B6] transition-all shadow-xl shadow-blue-900/20 active:scale-95">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
        
        <div class="mt-8 p-6 bg-amber-50 rounded-2xl border border-amber-100 flex gap-4">
            <svg class="w-6 h-6 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <p class="text-xs font-black text-amber-700 uppercase tracking-widest mb-1">Peringatan Admin</p>
                <p class="text-xs font-medium text-amber-600 leading-relaxed">Pembaruan data ini akan langsung berdampak pada halaman publik jika status data saat ini adalah "Published". Pastikan keabsahan data sebelum menyimpan.</p>
            </div>
        </div>
    </div>
</x-layouts.super-admin>
