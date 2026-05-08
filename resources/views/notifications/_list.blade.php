@forelse($notifications as $notification)
    @php
        $rolePrefix = request()->segment(1);
        $readUrl = route($rolePrefix . '.notifications.read-and-redirect', $notification->id);
        
        $actionLabel = 'Akses Resource';
        if ($rolePrefix === 'pengusul' || $rolePrefix === 'pengusul-desa') {
            $actionLabel = 'Lihat Proyek';
        } elseif ($rolePrefix === 'validator') {
            $actionLabel = 'Periksa Resource';
        }
    @endphp
    <div @class([
        'relative group overflow-hidden rounded-[2rem] sm:rounded-[2.5rem] border transition-all duration-700',
        'bg-white border-slate-100 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-slate-300/70' => $notification->read_at,
        'bg-gradient-to-br from-indigo-50/50 via-white to-blue-50/30 border-indigo-100 shadow-2xl shadow-indigo-900/10 ring-1 ring-indigo-500/5' => !$notification->read_at
    ])>
        {{-- Side Indicator --}}
        @if(!$notification->read_at)
            <div class="absolute left-0 top-0 bottom-0 w-2 bg-gradient-to-b from-[#0077B6] to-[#03045E]"></div>
        @endif

        <a href="{{ $readUrl }}" class="flex flex-col sm:flex-row items-start gap-5 sm:gap-10 p-5 sm:p-10">
            {{-- Icon Container --}}
            <div @class([
                'w-12 h-12 sm:w-20 sm:h-20 rounded-2xl sm:rounded-[2.5rem] flex items-center justify-center shrink-0 transition-all duration-700 group-hover:scale-110 group-hover:-rotate-3 shadow-xl relative overflow-hidden',
                'bg-indigo-600 text-white shadow-indigo-900/20' => ($notification->data['type'] ?? 'info') === 'info',
                'bg-emerald-500 text-white shadow-emerald-900/20' => ($notification->data['type'] ?? 'info') === 'success',
                'bg-rose-500 text-white shadow-rose-900/20' => ($notification->data['type'] ?? 'info') === 'warning' || ($notification->data['type'] ?? 'info') === 'error',
            ])>
                <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <svg class="w-6 h-6 sm:w-10 sm:h-10 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0 text-left">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3 sm:mb-4">
                    <h3 @class([
                        'font-black text-lg sm:text-2xl tracking-tight transition-all duration-500',
                        'text-[#03045E] group-hover:text-[#0077B6]' => $notification->read_at,
                        'text-[#0077B6]' => !$notification->read_at
                    ])>
                        {{ $notification->data['title'] }}
                    </h3>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest shrink-0 bg-slate-50 px-4 py-1.5 rounded-full border border-slate-100 shadow-sm">
                        {{ $notification->created_at->diffForHumans() }}
                    </span>
                </div>
                <p class="text-slate-500 text-[11px] sm:text-lg font-bold leading-relaxed mb-6 sm:mb-8 uppercase tracking-tight opacity-75">
                    {{ $notification->data['message'] }}
                </p>
                
                <div class="flex flex-wrap items-center justify-start gap-4 sm:gap-6">
                    <span class="text-[9px] sm:text-[10px] font-black text-[#03045E] uppercase tracking-widest flex items-center gap-3 group-hover:translate-x-2 transition-transform duration-500">
                        {{ $actionLabel }}
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-slate-50 flex items-center justify-center group-hover:bg-[#03045E] group-hover:text-white transition-all duration-500 border border-slate-100 shadow-sm">
                            <svg class="w-3 h-3 sm:w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </span>
                    
                    @if(!$notification->read_at)
                        <div class="flex items-center gap-2.5 px-4 py-2 rounded-full bg-blue-50 border border-blue-100 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-[#00B4D8] animate-pulse"></span>
                            <span class="text-[9px] font-black text-[#0077B6] uppercase tracking-widest">Pesan Baru</span>
                        </div>
                    @endif
                </div>
            </div>
        </a>

        {{-- Quick Read Action --}}
        @if(!$notification->read_at)
            <button onclick="markAsRead('{{ $notification->id }}', this)" class="absolute top-10 right-10 w-12 h-12 rounded-2xl bg-white shadow-xl border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-[#03045E] hover:text-white hover:rotate-12 hover:scale-110 transition-all duration-500 hidden lg:flex" title="Tandai Terbaca">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </button>
        @endif
    </div>
@empty
    <div class="py-32 text-center">
        <div class="relative w-32 h-32 bg-slate-50/50 backdrop-blur-3xl rounded-[3rem] border border-slate-100 flex items-center justify-center mx-auto mb-10 text-slate-200 group">
            <svg class="w-16 h-16 relative z-10 transition-transform duration-700 group-hover:scale-110 " fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            <div class="absolute inset-0 bg-blue-500/5 rounded-full scale-0 group-hover:scale-150 transition-transform duration-1000"></div>
        </div>
        <h3 class="text-2xl font-black text-slate-400 uppercase tracking-widest">Hening</h3>
        <p class="text-slate-400/80 text-[10px] font-black uppercase mt-3 tracking-widest">Tidak ditemukan notifikasi yang sesuai dengan kriteria pencarian Anda.</p>
    </div>
@endforelse

<div class="pt-12 pagination-container">
    {{ $notifications->links() }}
</div>
