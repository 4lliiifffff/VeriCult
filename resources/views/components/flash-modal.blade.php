@if (session('success') || session('error'))
<template x-teleport="body">
    <div x-data="{ open: true }" 
        x-show="open" 
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] overflow-y-auto" 
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Backdrop -->
                <div x-show="open" 
                    x-transition:enter="transition-opacity ease-linear duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity ease-linear duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-[#03045E]/60 transition-opacity" 
                    aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Panel -->
                <div x-show="open"
                    x-transition:enter="transition ease-out duration-400"
                    x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-250"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-white rounded-[3rem] text-left overflow-hidden shadow-[0_32px_64px_-12px_rgba(3,4,94,0.15)] transform transition-all sm:my-8 sm:align-middle sm:max-w-sm w-full border border-white/20 relative">
                    
                    {{-- Decorative Pattern --}}
                    <div class="absolute top-0 right-0 -mt-16 -mr-16 w-48 h-48 bg-slate-50 rounded-full opacity-50"></div>
                    <div class="absolute bottom-0 left-0 -mb-16 -ml-16 w-48 h-48 bg-[#0077B6]/5 rounded-full opacity-50"></div>

                    <div class="relative z-10 bg-white p-10 sm:p-12">
                    <div class="flex flex-col items-center text-center">
                        @if(session('success'))
                            <div class="flex-shrink-0 flex items-center justify-center h-24 w-24 rounded-[2rem] bg-emerald-50 text-emerald-500 mb-8 border border-emerald-100 shadow-inner group transition-transform duration-500 hover:scale-110">
                                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h3 class="text-3xl font-black text-[#03045E] mb-3 tracking-tight" id="modal-title">
                                Berhasil!
                            </h3>
                            <p class="text-slate-500 text-sm font-bold leading-relaxed">
                                {!! session('success') !!}
                            </p>
                        @else
                            <div class="flex-shrink-0 flex items-center justify-center h-24 w-24 rounded-[2rem] bg-rose-50 text-rose-500 mb-8 border border-rose-100 shadow-inner group transition-transform duration-500 hover:scale-110">
                                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <h3 class="text-3xl font-black text-[#03045E] mb-3 tracking-tight" id="modal-title">
                                Ada Kendala
                            </h3>
                            <p class="text-slate-500 text-sm font-bold leading-relaxed">
                                {{ session('error') }}
                            </p>
                        @endif
                    </div>
                </div>
                
                <div class="px-10 pb-10 sm:px-12 sm:pb-12 relative z-10">
                    <button type="button" @click="open = false" 
                        class="w-full py-5 bg-gradient-to-r from-[#03045E] to-[#0077B6] hover:shadow-blue-900/30 text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-2xl transition-all shadow-xl shadow-blue-900/20 active:scale-95">
                        OK, Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
@endif
