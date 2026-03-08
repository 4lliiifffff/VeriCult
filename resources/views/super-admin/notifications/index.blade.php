<x-layouts.super-admin>
    <x-slot name="header">
        <div class="relative mb-6 sm:mb-8 bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-8 overflow-hidden shadow-2xl shadow-blue-900/20">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase bg-white/10 text-[#00B4D8] border border-white/20 backdrop-blur-md">
                            Super Admin
                        </span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight break-words">
                        Notifikasi <span class="text-[#00B4D8]">Sistem</span>
                    </h2>
                    <p class="text-blue-100/70 text-base sm:text-lg font-medium">Pantau aktivitas terbaru di platform VeriCult.</p>
                </div>
                
                @if(Auth::user()->unreadNotifications->count() > 0)
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-xl p-4 rounded-2xl border border-white/20 shadow-inner w-full md:w-auto">
                        <form action="{{ route('super-admin.notifications.mark-all-read') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full justify-center bg-white text-[#03045E] px-6 py-4 sm:py-3 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2 hover:bg-blue-50 transition-colors shadow-lg shadow-blue-900/10 active:scale-95">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Tandai Semua Terbaca
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-4">
        @forelse($notifications as $notification)
            <div @class([
                'p-5 sm:p-6 rounded-[1.5rem] sm:rounded-[2rem] border transition-all duration-300 flex flex-col sm:flex-row items-start gap-4 sm:gap-5',
                'bg-white border-slate-100 shadow-xl shadow-slate-200/50' => $notification->read_at,
                'bg-blue-50/50 border-blue-100 shadow-xl shadow-blue-900/5 ring-1 ring-blue-200/50' => !$notification->read_at
            ])>
                <div @class([
                    'w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 shadow-sm',
                    'bg-blue-500 text-white' => ($notification->data['type'] ?? 'info') === 'info',
                    'bg-emerald-500 text-white' => ($notification->data['type'] ?? 'info') === 'success',
                    'bg-amber-500 text-white' => ($notification->data['type'] ?? 'info') === 'warning',
                ])>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0 w-full">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 sm:gap-4 mb-2">
                        <h3 class="font-black text-[#03045E] text-sm sm:text-base break-words">{{ $notification->data['title'] }}</h3>
                        <span class="text-[9px] sm:text-[10px] font-black text-slate-400 font-mono uppercase tracking-widest shrink-0">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-slate-600 text-[13px] sm:text-sm font-medium leading-relaxed break-words">{{ $notification->data['message'] }}</p>
                    
                    <div class="mt-4 flex items-center gap-3">
                        @if($notification->data['url'])
                            <a href="{{ $notification->data['url'] }}" class="text-[10px] font-black text-[#0077B6] uppercase tracking-widest hover:text-[#03045E] transition-colors">
                                Lihat Detail &rarr;
                            </a>
                        @endif
                        
                        @if(!$notification->read_at)
                            <button onclick="markAsRead('{{ $notification->id }}', this)" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-blue-500 transition-colors">
                                Tandai Terbaca
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="py-20 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 text-slate-200">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </div>
                <h3 class="text-lg font-black text-slate-400 uppercase tracking-widest">Aktivitas Nihil</h3>
                <p class="text-slate-300 text-sm font-bold uppercase mt-2">Belum ada notifikasi untuk Anda.</p>
            </div>
        @endforelse

        <div class="pt-6">
            {{ $notifications->links() }}
        </div>
    </div>

    @push('scripts')
    <script>
        function markAsRead(id, button) {
            fetch(`/super-admin/notifications/${id}/mark-read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    const card = button.closest('.p-6');
                    card.classList.remove('bg-blue-50/50', 'border-blue-100', 'shadow-blue-900/5', 'ring-1', 'ring-blue-200/50');
                    card.classList.add('bg-white', 'border-slate-100', 'shadow-slate-200/50');
                    button.remove();
                }
            });
        }
    </script>
    @endpush
</x-layouts.super-admin>
