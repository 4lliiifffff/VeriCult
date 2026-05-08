<x-layouts.super-admin>
    <x-slot name="header">
        <nav class="flex items-center gap-2 text-[10px] sm:text-sm font-medium text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2">
            <a href="{{ route('super-admin.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('super-admin.kecamatans.index') }}" class="hover:text-[#0077B6] transition-colors">Data Kecamatan</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#03045E]">Edit Kecamatan</span>
        </nav>

        <div class="relative bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-8 overflow-hidden shadow-2xl shadow-blue-900/20 mb-8">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="relative z-10">
                <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight">
                    Edit <span class="text-[#00B4D8]">Nama Kecamatan</span>
                </h2>
                <p class="text-blue-100/70 text-base sm:text-lg font-medium">Ubah nama kecamatan untuk menjaga integritas data wilayah.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white p-6 sm:p-10 relative overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-slate-50 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>
            
            <form action="{{ route('super-admin.kecamatans.update', $kecamatan) }}" method="POST" class="relative z-10 space-y-8">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <label for="name" class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Nama Kecamatan</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $kecamatan->name) }}" required
                        class="block w-full px-6 py-5 bg-slate-50 border-slate-100 rounded-2xl text-sm font-bold text-[#03045E] focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all placeholder:text-slate-300 shadow-inner">
                    @error('name')
                        <p class="text-xs font-bold text-rose-500 mt-2 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="submit" class="flex-1 px-8 py-5 bg-[#03045E] text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-[#0077B6] transition-all shadow-lg shadow-blue-900/20 active:scale-95 flex items-center justify-center gap-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('super-admin.kecamatans.index') }}" class="px-8 py-5 bg-slate-100 text-slate-500 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-all flex items-center justify-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.super-admin>
