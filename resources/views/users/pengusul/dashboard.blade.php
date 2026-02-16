<x-app-layout>
    <x-slot name="header">
         <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-[#03045E] leading-tight tracking-tight">
                    {{ __('Dashboard Pengusul') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Halo, {{ Auth::user()->name }}. Kelola usulan Anda di sini.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-sky-50 text-sky-700 border border-sky-100">
                    Pengusul Area
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 bg-[#F8FAFC] min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                 <!-- Pending Tasks -->
                 <div class="group bg-white rounded-2xl p-5 shadow-sm border border-slate-100/60 hover:shadow-md transition-all duration-300 relative overflow-hidden">
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Usulan Saya</p>
                            <h3 class="text-2xl font-black text-[#023E8A] mt-1">0</h3>
                        </div>
                        <div class="p-3 bg-sky-50/50 rounded-xl text-sky-600 transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100 text-center">
                <div class="bg-sky-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                     <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-[#03045E]">Buat Usulan Baru</h3>
                <p class="text-slate-500 mt-2 max-w-md mx-auto mb-6">Anda belum memiliki usulan yang terdaftar. Mulai buat usulan baru untuk mengajukan pendaftaran.</p>
                <button class="inline-flex items-center px-5 py-2.5 bg-[#0077B6] border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#0096C7] focus:bg-[#0096C7] active:bg-[#005F8D] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#00B4D8] transition ease-in-out duration-150 shadow-lg shadow-blue-500/30">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Usulan
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
