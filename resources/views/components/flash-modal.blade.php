@if (session('success') || session('error'))
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
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" 
            aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal Panel -->
        <div x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="inline-block align-bottom bg-white rounded-[2.5rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm w-full border border-slate-100">
            
            <div class="bg-white p-8 sm:p-10">
                <div class="flex flex-col items-center text-center">
                    @if(session('success'))
                        <div class="flex-shrink-0 flex items-center justify-center h-20 w-20 rounded-3xl bg-emerald-50 text-emerald-500 mb-6 border border-emerald-100 shadow-inner">
                            <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-[#03045E] mb-3" id="modal-title">
                            Berhasil!
                        </h3>
                        <p class="text-slate-500 text-sm font-medium leading-relaxed">
                            {!! session('success') !!}
                        </p>
                    @else
                        <div class="flex-shrink-0 flex items-center justify-center h-20 w-20 rounded-3xl bg-rose-50 text-rose-500 mb-6 border border-rose-100 shadow-inner">
                            <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-[#03045E] mb-3" id="modal-title">
                            Terjadi Kesalahan
                        </h3>
                        <p class="text-slate-500 text-sm font-medium leading-relaxed">
                            {{ session('error') }}
                        </p>
                    @endif
                </div>
            </div>
            
            <div class="px-8 pb-8 sm:px-10 sm:pb-10">
                <button type="button" @click="open = false" class="w-full py-4 bg-[#03045E] hover:bg-[#0077B6] text-white text-xs font-black uppercase tracking-[0.2em] rounded-2xl transition-all shadow-lg shadow-blue-900/20 active:scale-95">
                    OK, Mengerti
                </button>
            </div>
        </div>
    </div>
</div>
@endif
