<x-layouts.super-admin>
    <x-slot name="header">
        <!-- Breadcrumbs & Navigation -->
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('super-admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Data Kecamatan</span>
        </nav>

        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6 sm:gap-8">
                <div class="space-y-2 sm:space-y-3">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="px-3 sm:px-4 py-1 sm:py-1.5 rounded-full text-[8px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-[#03045E] text-white shadow-lg shadow-blue-900/20">
                            Territory
                        </div>
                        <div class="h-3 sm:h-4 w-[1px] bg-slate-200"></div>
                        <span class="text-slate-400 text-[8px] sm:text-[10px] font-bold uppercase tracking-widest">Manajemen Wilayah Administrasi</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black text-[#03045E] tracking-tight leading-tight">
                        Kelola <span class="text-[#0077B6]">Kecamatan</span>
                    </h2>
                    <p class="text-slate-500 text-sm sm:text-lg font-medium max-w-2xl leading-relaxed">Kelola daftar kecamatan dan pantau persebaran data kebudayaan di setiap wilayah.</p>
                </div>

                <div class="shrink-0 flex flex-col sm:flex-row gap-4 sm:gap-6">
                    <a href="{{ route('super-admin.kecamatans.create') }}" class="group/btn px-8 py-5 bg-[#03045E] text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-[#0077B6] transition-all shadow-lg shadow-blue-900/20 active:scale-95 flex items-center justify-center gap-3">
                        <div class="p-1.5 rounded-lg bg-white/10 group-hover/btn:bg-white/20 transition-colors">
                            <svg class="w-4 h-4 group-hover/btn:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        Tambah Kecamatan
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div x-data="{ 
            deleteModalOpen: false, 
            targetName: '', 
            actionUrl: '',
            openDeleteModal(name, url) {
                this.targetName = name;
                this.actionUrl = url;
                this.deleteModalOpen = true;
            }
        }" 
        class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden relative">
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-max responsive-table">
                <thead>
                    <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 sm:px-10 py-4 sm:py-6">Nama Kecamatan</th>
                        <th class="px-6 sm:px-10 py-4 sm:py-6 text-center">Jumlah Desa</th>
                        <th class="px-6 sm:px-10 py-4 sm:py-6 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($kecamatans as $kecamatan)
                    <tr class="hover:bg-slate-50/30 transition-colors group/u">
                        <td class="px-6 sm:px-10 py-4 sm:py-6">
                            <div class="font-bold text-sm sm:text-base text-[#03045E] group-hover/u:text-[#0077B6] transition-colors">{{ $kecamatan->name }}</div>
                        </td>
                        <td class="px-6 sm:px-10 py-4 sm:py-6 text-center">
                            <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-blue-50 text-[#03045E] border border-blue-100">
                                {{ $kecamatan->villages_count }} Desa
                            </span>
                        </td>
                        <td class="px-6 sm:px-10 py-4 sm:py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('super-admin.kecamatans.edit', $kecamatan) }}" class="p-2.5 rounded-xl bg-slate-50 text-slate-400 hover:bg-[#03045E] hover:text-white transition-all shadow-sm border border-slate-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <button type="button" 
                                    @click="openDeleteModal('{{ $kecamatan->name }}', '{{ route('super-admin.kecamatans.destroy', $kecamatan) }}')"
                                    class="p-2.5 rounded-xl bg-rose-50 text-rose-400 hover:bg-rose-500 hover:text-white transition-all shadow-sm border border-rose-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($kecamatans->hasPages())
        <div class="px-6 sm:px-10 py-6 border-t border-slate-50 bg-slate-50/30">
            {{ $kecamatans->links() }}
        </div>
        @endif

        <!-- Delete Modal -->
        <div x-show="deleteModalOpen" style="display: none;" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto" 
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div @click="deleteModalOpen = false" class="fixed inset-0 bg-slate-900/75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-white">
                    <div class="bg-white px-8 pt-10 pb-4 sm:p-10 sm:pb-4 text-center sm:text-left">
                        <div class="mx-auto sm:mx-0 flex items-center justify-center h-16 w-16 rounded-3xl bg-red-50 text-red-600 mb-6">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-[#03045E]" id="modal-title">Hapus Kecamatan?</h3>
                        <p class="mt-3 text-slate-500 font-medium leading-relaxed">
                            Apakah Anda yakin ingin menghapus kecamatan <span x-text="targetName" class="font-black text-red-600"></span>? 
                            Seluruh data desa yang terikat pada wilayah ini mungkin akan terpengaruh. Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>
                    <div class="px-8 py-8 sm:px-10 flex flex-col sm:flex-row-reverse gap-3">
                        <form :action="actionUrl" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-4 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300 shadow-lg shadow-red-900/20">
                                Ya, Hapus Permanen
                            </button>
                        </form>
                        <button type="button" @click="deleteModalOpen = false" class="flex-1 inline-flex justify-center items-center px-6 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all duration-300">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.super-admin>
