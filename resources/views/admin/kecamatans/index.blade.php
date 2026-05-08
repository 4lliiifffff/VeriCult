<x-layouts.admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-sm font-medium text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Kelola Kecamatan</span>
        </nav>

        <div class="relative bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-8 overflow-hidden shadow-2xl shadow-blue-900/20 mb-8">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.2em] uppercase bg-white/10 text-white border border-white/20 backdrop-blur-xl">
                            Wilayah Administrasi
                        </span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight break-words">
                        Daftar <span class="text-[#00B4D8]">Kecamatan</span>
                    </h2>
                    <p class="text-blue-100/70 text-base sm:text-lg font-medium">Manajemen wilayah kecamatan yang terdaftar di dalam sistem.</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div x-data="{ 
            deleteModalOpen: false,
            targetKecamatan: null, 
            actionUrl: '',

            openDeleteModal(kecamatan, url) {
                this.targetKecamatan = kecamatan;
                this.actionUrl = url;
                this.deleteModalOpen = true;
                this.$dispatch('open-modal', 'delete-modal');
            }
        }" 
        class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white relative group overflow-hidden">
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 sm:px-8 py-4 sm:py-5">Nama Kecamatan</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Jumlah Desa Terdaftar</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Tanggal Dibuat</th>
                        <th class="px-6 sm:px-8 py-4 sm:py-5 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($kecamatans as $kecamatan)
                        <tr class="hover:bg-slate-50/30 transition-all duration-200 group/u">
                            <td class="px-6 sm:px-8 py-4 sm:py-5">
                                <div class="font-bold text-sm sm:text-base text-[#03045E] group-hover/u:text-[#0077B6] transition-colors truncate">{{ $kecamatan->name }}</div>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 text-center font-black">
                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest bg-sky-50 text-sky-600 border border-sky-100 shadow-sm">
                                    {{ $kecamatan->villages_count }} Desa
                                </span>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 text-center">
                                <span class="text-[10px] sm:text-[11px] font-bold text-slate-500 tabular-nums">{{ $kecamatan->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td class="px-6 sm:px-8 py-4 sm:py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button type="button" @click="openDeleteModal({{ json_encode($kecamatan) }}, '{{ route('admin.kecamatans.destroy', $kecamatan) }}')"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all duration-300 shadow-sm border border-rose-100" title="Hapus Kecamatan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <div class="w-16 h-16 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-200">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-slate-400 font-bold tracking-wide uppercase text-xs">Kecamatan Tidak Ditemukan</p>
                                        <p class="text-slate-300 text-[10px] mt-1 uppercase tracking-widest">Belum ada kecamatan yang terdaftar.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($kecamatans->hasPages())
            <div class="px-8 py-8 border-t border-slate-50 bg-slate-50/30">
                {{ $kecamatans->links() }}
            </div>
        @endif

        <!-- Delete Modal -->
        <x-modal name="delete-modal" :show="false" focusable>
            <div x-show="deleteModalOpen" class="p-8 sm:p-12 text-center">
                <div class="mx-auto border-4 border-rose-400 bg-rose-50 h-20 w-20 rounded-3xl flex items-center justify-center text-rose-500 mb-6 font-black text-3xl shadow-inner italic">!</div>
                <h3 class="text-2xl font-black text-[#03045E] mb-2">Hapus Kecamatan?</h3>
                <p class="text-slate-500 font-medium leading-relaxed max-w-sm mx-auto">
                    Kecamatan <span x-text="targetKecamatan?.name" class="font-black text-rose-600"></span> akan dihapus permanen. Desa-desa yang terhubung akan dilepaskan (tanpa kecamatan).
                </p>
                <div class="grid grid-cols-2 gap-4 w-full mt-10">
                    <button type="button" @click="deleteModalOpen = false; $dispatch('close')" class="px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-[11px] uppercase tracking-widest transition-all">Batal</button>
                    <form :action="actionUrl" method="POST" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-6 py-4 bg-rose-500 hover:bg-rose-600 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest shadow-lg shadow-rose-900/20 transition-all duration-300">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </x-modal>
    </div>
</x-layouts.admin>
