<x-layouts.validator>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-[#03045E] leading-tight tracking-tight">
                    {{ __('Dashboard Validator') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Selamat datang, Validator. Siap memverifikasi data hari ini?</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                    Validator Area
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
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Menunggu Verifikasi</p>
                            <h3 class="text-2xl font-black text-[#023E8A] mt-1">0</h3>
                        </div>
                        <div class="p-3 bg-indigo-50/50 rounded-xl text-indigo-600 transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100 text-center">
                <div class="bg-indigo-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                     <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-[#03045E]">Belum Ada Tugas</h3>
                <p class="text-slate-500 mt-2 max-w-md mx-auto">Saat ini belum ada data pengajuan yang perlu diverifikasi. Silakan cek kembali nanti.</p>
            </div>
        </div>
    </div>
</x-layouts.validator>
