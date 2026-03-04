<x-layouts.validator>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-[#03045E] tracking-tighter">Pusat Notifikasi</h1>
                <p class="text-slate-500 font-medium text-sm">Info terbaru seputar antrian dan review Anda.</p>
            </div>
            @if(Auth::user()->unreadNotifications->count() > 0)
                <form action="{{ route('validator.notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-2.5 bg-indigo-50 text-indigo-600 rounded-xl font-black text-xs uppercase tracking-widest border border-indigo-100 hover:bg-indigo-600 hover:text-white transition-all">
                        Tandai Semua Terbaca
                    </button>
                </form>
            @endif
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
