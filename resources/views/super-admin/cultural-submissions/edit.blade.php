<x-layouts.super-admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('super-admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('super-admin.cultural-submissions.index') }}" class="hover:text-[#0077B6] transition-colors text-slate-400">Pengajuan Kebudayaan</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('super-admin.cultural-submissions.show', $submission) }}" class="hover:text-[#0077B6] transition-colors text-slate-400">{{ $submission->name }}</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Edit Pengajuan</span>
        </nav>

        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-5 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6 sm:gap-8">
                <div class="flex items-center gap-4 sm:gap-8">
                    <div class="w-14 h-14 sm:w-20 sm:h-20 rounded-[1.25rem] sm:rounded-[2rem] bg-[#0077B6] flex items-center justify-center text-white shadow-xl shadow-blue-900/20 font-black text-xl sm:text-2xl uppercase">
                        {{ substr($submission->name, 0, 2) }}
                    </div>
                    <div class="space-y-1 sm:space-y-2">
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="px-2.5 py-1 rounded-full text-[7px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-slate-100 text-slate-500 border border-slate-200">
                                Management
                            </div>
                            <div class="h-3 w-[1px] bg-slate-200"></div>
                            <span class="text-slate-400 text-[7px] sm:text-[10px] font-bold uppercase tracking-widest">Update Data</span>
                        </div>
                        <h2 class="text-xl sm:text-4xl font-black text-[#03045E] tracking-tight leading-tight">
                            Edit <span class="text-[#00B4D8]">Pengajuan</span>
                        </h2>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('super-admin.cultural-submissions.show', $submission) }}" class="flex-1 sm:flex-none px-5 py-3 sm:px-6 sm:py-4 bg-slate-50 text-slate-500 rounded-xl sm:rounded-2xl font-black text-[9px] sm:text-[10px] uppercase tracking-widest hover:bg-[#03045E] hover:text-white transition-all flex items-center justify-center gap-3 border border-slate-100 active:scale-95 group/btn">
                        <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform text-slate-400 group-hover/btn:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-10 pb-20">
        {{-- Main Control Panel --}}
        <div class="bg-white p-6 sm:p-14 lg:p-16 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-white relative group">
            <form action="{{ route('super-admin.cultural-submissions.update', $submission) }}" method="POST" class="space-y-12 sm:space-y-16">
                @csrf
                @method('PUT')

                <!-- Publication Status (Main Action) -->
                <section class="p-6 sm:p-10 bg-gradient-to-br from-blue-50 to-indigo-50/30 rounded-[2.5rem] border border-blue-100/50 relative">
                    <div class="absolute -right-16 -top-16 w-48 h-48 bg-white/50 rounded-full blur-3xl transition-transform duration-1000 group-hover:scale-150"></div>
                    
                    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center gap-10">
                        <div class="flex-1 space-y-4">
                            <h3 class="text-[10px] font-black text-[#0077B6] uppercase tracking-[0.3em] flex items-center gap-3">
                                <span class="w-8 h-px bg-[#0077B6]"></span>
                                Status Publikasi
                            </h3>
                            <h2 class="text-2xl sm:text-3xl font-black text-[#03045E] tracking-tight leading-tight">Kontrol Visibilitas Objek</h2>
                            <p class="text-xs sm:text-sm text-slate-500 font-bold leading-relaxed italic uppercase tracking-tight opacity-75">Atur bagaimana objek ini ditampilkan ke masyarakat umum melalui galeri publik sistem VeriCult.</p>
                        </div>
                        
                        <div class="w-full lg:w-80 shrink-0">
                            <x-dropdown-select 
                                name="status" 
                                id="status" 
                                label="Status Saat Ini" 
                                placeholder="Pilih Status"
                                variant="light"
                                :selected="$submission->status" 
                                :options="[
                                    \App\Models\CulturalSubmission::STATUS_PUBLISHED => 'Terbitkan (Public)',
                                    \App\Models\CulturalSubmission::STATUS_VERIFIED => 'Arsipkan (Internal)',
                                    \App\Models\CulturalSubmission::STATUS_REJECTED => 'Batalkan (Rejected)',
                                ]" 
                            />
                        </div>
                    </div>
                </section>

                <!-- Basic Info (Read Only) -->
                <section class="space-y-8 sm:space-y-10">
                    <h2 class="text-[10px] font-black text-[#0077B6] uppercase tracking-[0.3em] flex items-center gap-4">
                        <span class="shrink-0 text-[#03045E]">Informasi Identitas</span>
                        <div class="flex-1 h-px bg-slate-100"></div>
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-10">
                        <div class="md:col-span-2 group/field">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3 block group-hover/field:text-[#0077B6] transition-colors ml-1">Nama Objek Kebudayaan</label>
                            <div class="relative">
                                <input type="text" value="{{ $submission->name }}" readonly class="w-full px-8 py-5 bg-slate-50 border border-slate-100 rounded-2xl font-black text-[#03045E] cursor-not-allowed shadow-inner transition-all text-base">
                                <svg class="absolute right-6 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                        </div>

                        <div class="group/field">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3 block group-hover/field:text-[#0077B6] transition-colors ml-1">Kategori Kebudayaan</label>
                            <div class="relative">
                                <input type="text" value="{{ $submission->category }}" readonly class="w-full px-8 py-5 bg-slate-50 border border-slate-100 rounded-2xl font-black text-[#03045E] cursor-not-allowed shadow-inner transition-all text-base">
                                <svg class="absolute right-6 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            </div>
                        </div>

                        <div class="group/field">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3 block group-hover/field:text-[#0077B6] transition-colors ml-1">ID Pengajuan</label>
                            <div class="relative">
                                <input type="text" value="SUB-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}" readonly class="w-full px-8 py-5 bg-slate-50 border border-slate-100 rounded-2xl font-black text-[#03045E] cursor-not-allowed shadow-inner transition-all text-base uppercase tracking-tighter">
                                <svg class="absolute right-6 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                        </div>

                        <div class="md:col-span-2 group/field">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3 block group-hover/field:text-[#0077B6] transition-colors ml-1">Deskripsi Objek</label>
                            <div class="relative">
                                <div class="w-full px-8 py-8 bg-slate-50 border border-slate-100 rounded-[2rem] font-medium text-slate-600 leading-relaxed shadow-inner min-h-[160px] whitespace-pre-wrap break-words italic">{{ $submission->description }}</div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Technical Data (Read Only) -->
                @if(!empty($submission->category_data))
                <section class="space-y-8 sm:space-y-10">
                    <h2 class="text-[10px] font-black text-[#0077B6] uppercase tracking-[0.3em] flex items-center gap-4">
                        <span class="shrink-0 text-[#03045E]">Data Teknis Komprehensif</span>
                        <div class="flex-1 h-px bg-slate-100"></div>
                    </h2>

                    <div class="p-6 sm:p-10 bg-slate-50/50 rounded-[2.5rem] border border-slate-100 group/tech shadow-inner">
                        @php
                            $subCatField = array_keys(array_filter($submission->category_data, fn($k) => str_starts_with($k, 'sub_kategori'), ARRAY_FILTER_USE_KEY))[0] ?? null;
                            $subCatValue = $subCatField ? ($submission->category_data[$subCatField] ?? null) : null;
                            $flatFields = \App\Models\CulturalSubmission::getFlatCategoryFields($submission->category, $subCatValue);
                            
                            $processedKeys = [];
                            if ($subCatField) $processedKeys[] = $subCatField;
                        @endphp

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-10">
                            @foreach($submission->category_data as $dataKey => $dataValue)
                                @if(!empty($dataValue) && $dataKey !== 'unesco_categories' && !in_array($dataKey, $processedKeys))
                                    @php
                                        $fieldDef = $flatFields[$dataKey] ?? null;
                                        if (!$fieldDef) continue;

                                        if (($fieldDef['type'] ?? '') === 'radio' && in_array($dataValue, ['Ya', 'Tidak'])) {
                                            $hasDependent = false;
                                            foreach($flatFields as $k => $f) {
                                                if (isset($f['condition']) && $f['condition']['field'] === $dataKey && !empty($submission->category_data[$k])) {
                                                    $hasDependent = true;
                                                    break;
                                                }
                                            }
                                            if ($hasDependent) continue;
                                        }

                                        $displayValue = $dataValue;
                                        $displayLabel = $fieldDef['label'] ?? str_replace('_', ' ', ucfirst($dataKey));

                                        if ($dataValue === 'Lainnya') {
                                            $otherKey = $dataKey . '_lainnya';
                                            if (!empty($submission->category_data[$otherKey])) {
                                                $displayValue = $submission->category_data[$otherKey];
                                                $processedKeys[] = $otherKey;
                                            }
                                        }

                                        $isFullWidth = ($fieldDef['type'] ?? '') === 'textarea' || is_array($dataValue);
                                    @endphp

                                    <div class="space-y-2 {{ $isFullWidth ? 'md:col-span-2' : '' }}">
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ $displayLabel }}</p>

                                        @if(is_array($dataValue))
                                            @if(isset($dataValue[0]) && is_array($dataValue[0]))
                                                <div class="overflow-hidden rounded-2xl border border-slate-100 shadow-sm bg-white">
                                                    <div class="overflow-x-auto">
                                                        <table class="w-full text-left border-collapse min-w-max responsive-table">
                                                            <thead class="bg-slate-50/50 border-b border-slate-100">
                                                                <tr>
                                                                    @foreach(array_keys($dataValue[0]) as $col)
                                                                        <th class="px-5 py-3 text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ str_replace('_', ' ', $col) }}</th>
                                                                    @endforeach
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-slate-50">
                                                                @foreach($dataValue as $row)
                                                                    <tr class="hover:bg-slate-50/30 transition-colors">
                                                                        @foreach($row as $cell)
                                                                            <td class="px-5 py-4 text-sm font-bold text-[#03045E]">{{ $cell ?: '-' }}</td>
                                                                        @endforeach
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($dataValue as $item)
                                                        <span class="px-4 py-2 bg-blue-50 text-[#0077B6] rounded-xl text-xs font-black border border-blue-100/50 shadow-sm">{{ $item }}</span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @else
                                            <div class="{{ ($fieldDef['type'] ?? '') === 'textarea' ? 'p-6 bg-white/50 rounded-2xl border border-slate-100 text-slate-600 font-medium leading-relaxed italic text-base' : 'text-lg font-black text-[#03045E] tracking-tight' }}">
                                                {{ $displayValue }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </section>
                @endif

                <!-- Form Actions -->
                <div class="pt-10 sm:pt-12 border-t border-slate-50 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-3 text-slate-400 group/warn">
                        <svg class="w-5 h-5 group-hover/warn:text-amber-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <p class="text-[10px] font-bold uppercase tracking-widest italic leading-tight">Perubahan akan langsung berdampak pada akses publik.</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                        <a href="{{ route('super-admin.cultural-submissions.show', $submission) }}" class="px-8 py-5 bg-slate-50 text-slate-500 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#03045E] hover:text-white transition-all text-center border border-slate-100 active:scale-95">Batal</a>
                        <button type="submit" class="px-12 py-5 bg-[#03045E] text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-[#0077B6] transition-all shadow-2xl shadow-blue-900/40 active:scale-95 group flex items-center justify-center gap-3">
                            Simpan Perubahan
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="p-8 sm:p-10 bg-amber-50 rounded-[2.5rem] border border-amber-100 flex flex-col sm:flex-row gap-6 relative overflow-hidden group">
            <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl transition-transform duration-1000 group-hover:scale-150"></div>
            <div class="w-14 h-14 rounded-2xl bg-white shadow-xl flex items-center justify-center text-amber-500 shrink-0 border border-amber-100 group-hover:rotate-12 transition-transform">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div class="relative z-10">
                <p class="text-[10px] font-black text-amber-700 uppercase tracking-[0.3em] mb-2 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    Audit Trail & Publikasi
                </p>
                <p class="text-[13px] font-bold text-amber-600/80 leading-relaxed uppercase tracking-tight opacity-90">
                    Setiap perubahan pada status publikasi akan dicatat secara permanen. Mempublikasikan data berarti Anda telah memvalidasi keabsahan informasi teknis sesuai standar registrasi nasional.
                </p>
            </div>
        </div>
    </div>
</x-layouts.super-admin>
