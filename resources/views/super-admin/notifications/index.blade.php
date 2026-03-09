<x-layouts.super-admin>
    <x-slot name="header">
        <div class="relative mb-6 sm:mb-8 bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2.5rem] p-8 sm:p-10 overflow-hidden shadow-2xl shadow-blue-900/20 text-white">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-64 h-64 bg-[#00B4D8]/20 rounded-full blur-[80px]"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.2em] uppercase bg-white/10 text-white border border-white/20 backdrop-blur-xl">
                            Command Center
                        </span>
                    </div>
                    <h2 class="text-4xl sm:text-5xl font-black tracking-tight leading-none">
                        Pusat <span class="text-[#00B4D8]">Notifikasi</span>
                    </h2>
                    <p class="text-blue-100/80 text-sm sm:text-base font-medium max-w-xl leading-relaxed">Pantau seluruh aktivitas sistem dan pembaruan data dari satu dashboard terpadu.</p>
                </div>
                
                @if(Auth::user()->unreadNotifications->count() > 0)
                    <form action="{{ route('super-admin.notifications.mark-all-read') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto bg-white/10 hover:bg-white text-white hover:text-[#03045E] px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest flex items-center justify-center gap-3 transition-all duration-500 border border-white/20 hover:border-white shadow-xl hover:shadow-white/20 active:scale-95 group">
                            <svg class="w-5 h-5  transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Tandai Terbaca
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-5 pb-20">
        @forelse($notifications as $notification)
            <div @class([
                'relative group overflow-hidden rounded-[2rem] border transition-all duration-700',
                'bg-white border-slate-100 shadow-xl shadow-slate-200/40 hover:shadow-2xl hover:shadow-slate-300/60' => $notification->read_at,
                'bg-gradient-to-br from-indigo-50/50 via-white to-blue-50/30 border-indigo-200/60 shadow-2xl shadow-indigo-900/5 ring-1 ring-indigo-500/10' => !$notification->read_at
            ])>
                {{-- Side Indicator --}}
                @if(!$notification->read_at)
                    <div class="absolute left-0 top-0 bottom-0 w-2 bg-gradient-to-b from-indigo-500 to-blue-600"></div>
                @endif

                <a href="{{ route('super-admin.notifications.read-and-redirect', $notification->id) }}" class="flex flex-col sm:flex-row items-center sm:items-start gap-6 sm:gap-8 p-7 sm:p-9">
                    {{-- Icon Container --}}
                    <div @class([
                        'w-16 h-16 rounded-[1.5rem] flex items-center justify-center shrink-0 transition-all duration-700 group-hover:scale-110 group-hover:-rotate-3 shadow-inner relative overflow-hidden',
                        'bg-indigo-600 text-white shadow-indigo-200' => ($notification->data['type'] ?? 'info') === 'info',
                        'bg-emerald-500 text-white shadow-emerald-200' => ($notification->data['type'] ?? 'info') === 'success',
                        'bg-rose-500 text-white shadow-rose-200' => ($notification->data['type'] ?? 'info') === 'warning',
                        'bg-rose-600 text-white shadow-rose-300' => ($notification->data['type'] ?? 'info') === 'error',
                    ])>
                        <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <svg class="w-8 h-8 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0 text-center sm:text-left">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                            <h3 @class([
                                'font-black text-lg sm:text-xl tracking-tight transition-all duration-500',
                                'text-[#03045E] group-hover:text-indigo-700' => $notification->read_at,
                                'text-indigo-950' => !$notification->read_at
                            ])>
                                {{ $notification->data['title'] }}
                            </h3>
                            <span class="text-[10px] font-black text-slate-400 font-mono uppercase tracking-[0.1em] shrink-0 bg-slate-50 px-3 py-1 rounded-full border border-slate-100">
                                {{ $notification->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-slate-600 text-sm sm:text-base font-medium leading-relaxed mb-6">
                            {{ $notification->data['message'] }}
                        </p>
                        
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-6">
                            <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest flex items-center gap-3 group-hover:translate-x-2 transition-transform duration-500">
                                Akses Resource
                                <div class="w-8 h-8 rounded-full bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-500">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </div>
                            </span>
                            
                            @if(!$notification->read_at)
                                <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-ping"></span>
                                    <span class="text-[9px] font-black text-indigo-600 uppercase tracking-tighter">Baru</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </a>

                {{-- Quick Read Action --}}
                @if(!$notification->read_at)
                    <button onclick="markAsRead('{{ $notification->id }}', this)" class="absolute top-6 right-6 w-10 h-10 rounded-xl bg-white/50 backdrop-blur-md border border-slate-100 flex items-center justify-center shadow-lg shadow-slate-200/20 text-slate-400 hover:bg-indigo-600 hover:text-white hover:border-indigo-600 hover:rotate-12 hover:scale-110 transition-all duration-500 hidden sm:flex" title="Tandai Terbaca">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                @endif
            </div>
        @empty
            <div class="py-32 text-center">
                <div class="relative w-32 h-32 bg-slate-50/50 backdrop-blur-3xl rounded-[3rem] border border-slate-100 flex items-center justify-center mx-auto mb-10 text-slate-200 group">
                    <svg class="w-16 h-16 relative z-10 transition-transform duration-700 group-hover:scale-110 " fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <div class="absolute inset-0 bg-indigo-500/5 rounded-full scale-0 group-hover:scale-150 transition-transform duration-1000"></div>
                </div>
                <h3 class="text-2xl font-black text-slate-400 uppercase tracking-widest">Hening</h3>
                <p class="text-slate-400/80 text-sm font-bold uppercase mt-3 tracking-tighter">Seluruh laporan dan aktivitas sistem telah tertata rapi.</p>
            </div>
        @endforelse

        <div class="pt-12">
            {{ $notifications->links() }}
        </div>
    </div>

    @push('scripts')
    <script>
        function markAsRead(id, button) {
            event.preventDefault();
            event.stopPropagation();
            
            fetch(`/super-admin/notifications/${id}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    const card = button.closest('.group');
                    card.classList.remove('bg-gradient-to-br', 'from-indigo-50/50', 'via-white', 'to-blue-50/30', 'border-indigo-200/60', 'shadow-2xl', 'shadow-indigo-900/5', 'ring-1', 'ring-indigo-500/10');
                    card.classList.add('bg-white', 'border-slate-100', 'shadow-xl', 'shadow-slate-200/40');
                    
                    const indicator = card.querySelector('.absolute.left-0.top-0');
                    if (indicator) indicator.style.opacity = '0';
                    
                    const badge = card.querySelector('.flex.items-center.gap-2.px-3');
                    if (badge) badge.style.opacity = '0';

                    const title = card.querySelector('h3');
                    if (title) {
                        title.classList.remove('text-indigo-950');
                        title.classList.add('text-[#03045E]');
                    }

                    button.style.transform = 'scale(0) rotate(90deg)';
                    button.style.opacity = '0';
                    
                    setTimeout(() => {
                        if (indicator) indicator.remove();
                        if (badge) badge.remove();
                        button.remove();
                    }, 500);
                }
            });
        }
    </script>
    @endpush
</x-layouts.super-admin>
