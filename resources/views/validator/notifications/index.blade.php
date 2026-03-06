<x-layouts.validator>
    <x-slot name="header">
        <div class="relative mb-8 bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-8 overflow-hidden shadow-2xl shadow-blue-900/20">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase bg-white/10 text-[#00B4D8] border border-white/20 backdrop-blur-md">
                            Aktivitas Sistem
                        </span>
                    </div>
                    <h2 class="text-4xl font-black text-white tracking-tight leading-tight">
                        Pusat <span class="text-[#00B4D8]">Notifikasi</span>
                    </h2>
                    <p class="text-blue-100/70 text-lg font-medium">Info terbaru seputar antrian dan review Anda.</p>
                </div>
                
                @if(Auth::user()->unreadNotifications->count() > 0)
                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-xl p-4 rounded-2xl border border-white/20 shadow-inner">
                        <form action="{{ route('validator.notifications.mark-all-read') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-white text-[#03045E] px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2 hover:bg-blue-50 transition-colors shadow-lg shadow-blue-900/10">
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
                'p-6 rounded-[2rem] border transition-all duration-300 flex items-start gap-5',
                'bg-white border-slate-100 shadow-xl shadow-slate-200/50' => $notification->read_at,
                'bg-indigo-50/50 border-indigo-100 shadow-xl shadow-indigo-900/5 ring-1 ring-indigo-200/50' => !$notification->read_at
            ])>
                <div @class([
                    'w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 shadow-sm',
                    'bg-indigo-500 text-white' => ($notification->data['type'] ?? 'info') === 'info',
                    'bg-emerald-500 text-white' => ($notification->data['type'] ?? 'info') === 'success',
                    'bg-rose-500 text-white' => ($notification->data['type'] ?? 'info') === 'warning',
                ])>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-1">
                        <h3 class="font-black text-[#03045E] text-base">{{ $notification->data['title'] }}</h3>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-slate-600 text-sm font-medium leading-relaxed">{{ $notification->data['message'] }}</p>
                    
                    <div class="mt-4 flex items-center gap-3">
                        @if($notification->data['url'])
                            <a href="{{ $notification->data['url'] }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:text-indigo-800 transition-colors">
                                Lihat Detail &rarr;
                            </a>
                        @endif
                        
                        @if(!$notification->read_at)
                            <button onclick="markAsRead('{{ $notification->id }}', this)" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-indigo-500 transition-colors">
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
            fetch(`/validator/notifications/${id}/mark-read`, {
                method: 'POST', // We need to fix the controller/routes for this individual mark read if we want JS
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    const card = button.closest('.p-6');
                    card.classList.remove('bg-indigo-50/50', 'border-indigo-100', 'shadow-indigo-900/5', 'ring-1', 'ring-indigo-200/50');
                    card.classList.add('bg-white', 'border-slate-100', 'shadow-slate-200/50');
                    button.remove();
                }
            });
        }
    </script>
    @endpush
</x-layouts.validator>
