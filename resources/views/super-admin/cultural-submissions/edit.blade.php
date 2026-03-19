<x-layouts.super-admin>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('super-admin.cultural-submissions.show', $submission) }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-[#03045E] shadow-sm hover:bg-[#03045E] hover:text-white transition-all shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div class="min-w-0">
                    <h1 class="text-xl sm:text-2xl font-black text-[#03045E] tracking-tighter truncate break-words">Sinkronisasi Data: {{ $submission->name }}</h1>
                    <p class="text-slate-500 font-medium text-[11px] sm:text-sm">Manajemen status publikasi dan verifikasi data teknis.</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-10 pb-20">
        {{-- Main Control Panel --}}
        <div class="bg-white p-8 sm:p-12 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-white">
            <form action="{{ route('super-admin.cultural-submissions.update', $submission) }}" method="POST" class="space-y-12">
                @csrf
                @method('PUT')

                <!-- Publication Status (Main Action) -->
                <section class="p-8 sm:p-10 bg-gradient-to-br from-blue-50 to-indigo-50/30 rounded-[2rem] border border-blue-100/50 relative">
                    <div class="absolute -right-16 -top-16 w-48 h-48 bg-white/50 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center gap-10">
                        <div class="flex-1 space-y-4">
                            <h3 class="text-xs font-black text-[#0077B6] uppercase tracking-[0.3em] flex items-center gap-3">
                                <span class="w-8 h-px bg-[#0077B6]"></span>
                                Status Publikasi
                            </h3>
                            <h2 class="text-2xl font-black text-[#03045E] leading-tight">Kontrol Visibilitas Objek Kebudayaan</h2>
                            <p class="text-xs text-slate-500 font-medium leading-relaxed italic">Atur bagaimana objek ini ditampilkan ke masyarakat umum melalui galeri publik sistem VeriCult.</p>
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
                <section class="space-y-8">
                    <div class="flex items-center gap-4">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] flex items-center gap-3">
                            <span class="w-2 h-4 bg-slate-200 rounded-full"></span>
                            Informasi Identitas
                        </h3>
                        <div class="flex-1 h-px bg-slate-50"></div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="md:col-span-2 group/field">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block group-hover/field:text-[#0077B6] transition-colors">Nama Objek Kebudayaan</label>
                            <div class="relative">
                                <input type="text" value="{{ $submission->name }}" readonly class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-black text-slate-500 cursor-not-allowed shadow-sm transition-all">
                                <svg class="absolute right-6 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                        </div>

                        <div class="group/field">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block group-hover/field:text-[#0077B6] transition-colors">Kategori Kebudayaan</label>
                            <div class="relative">
                                <input type="text" value="{{ $submission->category }}" readonly class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-black text-slate-500 cursor-not-allowed shadow-sm transition-all">
                                <svg class="absolute right-6 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            </div>
                        </div>

                        <div class="group/field">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block group-hover/field:text-[#0077B6] transition-colors">ID Pengajuan</label>
                            <div class="relative">
                                <input type="text" value="SUB-{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}" readonly class="w-full px-6 py-5 bg-slate-50 border-2 border-slate-100 rounded-2xl font-black text-slate-500 cursor-not-allowed shadow-sm transition-all">
                                <svg class="absolute right-6 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                        </div>

                        <div class="md:col-span-2 group/field">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 block group-hover/field:text-[#0077B6] transition-colors">Deskripsi Objek</label>
                            <div class="relative">
                                <div class="w-full px-8 py-8 bg-slate-50 border-2 border-slate-100 rounded-[2rem] font-medium text-slate-600 leading-relaxed shadow-sm min-h-[200px] whitespace-pre-wrap break-words">{{ $submission->description }}</div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Technical Data (Read Only - Refactored Logic) -->
                @if(!empty($submission->category_data))
                <section class="space-y-8">
                    <div class="flex items-center gap-4">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] flex items-center gap-3">
                            <span class="w-2 h-4 bg-blue-400 rounded-full shadow-lg shadow-blue-500/20"></span>
                            Data Teknis Komprehensif
                        </h3>
                        <div class="flex-1 h-px bg-slate-50"></div>
                    </div>

                    <div class="p-8 sm:p-12 bg-white rounded-[2.5rem] border-2 border-slate-50 shadow-xl shadow-slate-200/20">
                        @php
                            // Determine sub-category if exists
                            $subCatField = array_keys(array_filter($submission->category_data, fn($k) => str_starts_with($k, 'sub_kategori'), ARRAY_FILTER_USE_KEY))[0] ?? null;
                            $subCatValue = $subCatField ? ($submission->category_data[$subCatField] ?? null) : null;
                            $flatFields = \App\Models\CulturalSubmission::getFlatCategoryFields($submission->category, $subCatValue);
                            
                            $processedKeys = [];
                            if ($subCatField) $processedKeys[] = $subCatField;
                        @endphp

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            @foreach($submission->category_data as $dataKey => $dataValue)
                                @if(!empty($dataValue) && $dataKey !== 'unesco_categories' && !in_array($dataKey, $processedKeys))
                                    @php
                                        $fieldDef = $flatFields[$dataKey] ?? null;
                                        if (!$fieldDef) continue;

                                        // Skip logical checks (Ya/Tidak) if detail exists
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

                                        // Merge Lainnya logic
                                        if ($dataValue === 'Lainnya') {
                                            $otherKey = $dataKey . '_lainnya';
                                            if (!empty($submission->category_data[$otherKey])) {
                                                $displayValue = 'Lainnya: ' . $submission->category_data[$otherKey];
                                                $processedKeys[] = $otherKey;
                                            }
                                        }

                                        $isFullWidth = ($fieldDef['type'] ?? '') === 'textarea' || is_array($dataValue);
                                    @endphp

                                    <div class="space-y-3 {{ $isFullWidth ? 'md:col-span-2' : '' }}">
                                        <div class="flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">{{ $displayLabel }}</p>
                                        </div>

                                        @if(is_array($dataValue))
                                            @if(isset($dataValue[0]) && is_array($dataValue[0]))
                                                {{-- Dynamic Table Rendering --}}
                                                <div class="overflow-hidden rounded-2xl border border-slate-100 shadow-sm">
                                                    <table class="w-full text-left border-collapse">
                                                        <thead class="bg-slate-50 border-b border-slate-100">
                                                            <tr>
                                                                @foreach(array_keys($dataValue[0]) as $col)
                                                                    <th class="px-5 py-3 text-[10px] font-black text-slate-400 uppercase tracking-wider">{{ str_replace('_', ' ', $col) }}</th>
                                                                @endforeach
                                                            </tr>
                                                        </thead>
                                                        <tbody class="divide-y divide-slate-50">
                                                            @foreach($dataValue as $row)
                                                                <tr class="hover:bg-slate-50/50 transition-colors">
                                                                    @foreach($row as $cell)
                                                                        <td class="px-5 py-4 text-sm font-bold text-slate-700 break-words">{{ $cell ?: '-' }}</td>
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                {{-- Multi-select/Checkbox chip rendering --}}
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($dataValue as $item)
                                                        <span class="px-4 py-2 bg-blue-50 text-[#0077B6] rounded-xl text-xs font-black border border-blue-100/50 shadow-sm">{{ $item }}</span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @else
                                            <p class="{{ ($fieldDef['type'] ?? '') === 'textarea' ? 'text-sm font-medium leading-relaxed italic text-slate-600 bg-slate-50/50 p-6 rounded-2xl border border-dotted border-slate-200' : 'text-lg font-black text-[#03045E]' }} break-all sm:break-words">
                                                {{ $displayValue }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        {{-- UNESCO & Support Links Sync --}}
                        <div class="mt-12 pt-10 border-t-2 border-slate-50 grid grid-cols-1 md:grid-cols-2 gap-10">
                            {{-- UNESCO --}}
                            @if(!empty($submission->category_data['unesco_categories']))
                                <div class="space-y-4">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kategori UNESCO</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($submission->category_data['unesco_categories'] as $cat)
                                            <div class="px-4 py-1.5 bg-[#03045E] text-white rounded-lg text-xs font-bold shadow-lg shadow-blue-900/10">{{ $cat }}</div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Media Links --}}
                            <div class="space-y-4 md:col-start-1">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tautan Dokumentasi</p>
                                <div class="space-y-3">
                                    @php
                                        $links = [
                                            'video_url' => ['icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z', 'label' => 'Video'],
                                            'dokumen_kajian_url' => ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'label' => 'Kajian'],
                                            'dokumen_lainnya_url' => ['icon' => 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.826a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1', 'label' => 'Lainnya']
                                        ];
                                    @endphp
                                    @foreach($links as $key => $meta)
                                        @if(!empty($submission->category_data[$key]))
                                            <a href="{{ $submission->category_data[$key] }}" target="_blank" class="flex items-center gap-3 p-3 bg-white border border-slate-100 rounded-xl hover:border-[#0077B6] hover:shadow-md transition-all group/link">
                                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#0077B6] flex items-center justify-center shrink-0 group-hover/link:bg-[#0077B6] group-hover/link:text-white transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $meta['icon'] }}"></path></svg>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-[9px] font-black text-slate-400 underline decoration-slate-200 underline-offset-2">{{ $meta['label'] }}</p>
                                                    <p class="text-xs font-bold text-[#0077B6] truncate">{{ $submission->category_data[$key] }}</p>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                @endif

                <!-- Form Actions -->
                <div class="pt-12 border-t border-slate-50 flex flex-col sm:flex-row items-center justify-end gap-4">
                    <a href="{{ route('super-admin.cultural-submissions.show', $submission) }}" class="w-full sm:w-auto px-8 py-5 bg-slate-100 text-slate-500 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all text-center">Batal</a>
                    <button type="submit" class="w-full sm:w-auto px-12 py-5 bg-[#03045E] text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#0077B6] transition-all shadow-xl shadow-blue-900/20 active:scale-95 group flex items-center justify-center gap-3">
                        Simpan Perubahan
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>
        </div>
        
        <div class="p-8 bg-amber-50 rounded-[2rem] border border-amber-100 flex flex-col sm:flex-row gap-6 relative overflow-hidden">
            <div class="absolute -left-10 -bottom-10 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl"></div>
            <div class="w-14 h-14 rounded-2xl bg-white shadow-lg flex items-center justify-center text-amber-500 shrink-0 border border-amber-100">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div class="relative z-10">
                <p class="text-xs font-black text-amber-700 uppercase tracking-widest mb-1.5 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    Audit Log Warning
                </p>
                <p class="text-sm font-medium text-amber-600/80 leading-relaxed">
                    Setiap perubahan pada status publikasi akan dicatat dalam <strong class="text-amber-800">Audit Trail</strong>. Mempublikasikan data ke ruang publik berarti Anda telah memvalidasi keabsahan data teknis sesuai standar registrasi kebudayaan nasional.
                </p>
            </div>
        </div>
    </div>
</x-layouts.super-admin>
