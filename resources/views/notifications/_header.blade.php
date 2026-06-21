{{--
    Shared Notification Page Header
    Props:
      $markAllReadRoute — e.g. 'admin.notifications.mark-all-read'
      $deleteAllRoute   — e.g. 'admin.notifications.delete-all'
--}}

@php
    $user = Auth::user();
    $unreadCount = $user->unreadNotifications()->count();
    $totalCount  = $user->notifications()->count();
@endphp

<div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-5 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group">
    {{-- Decorative Bubble --}}
    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>

    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6 sm:gap-8">
        <div class="flex items-center gap-4 sm:gap-8">
            <div class="w-14 h-14 sm:w-20 sm:h-20 rounded-[1.25rem] sm:rounded-[2rem] bg-[#03045E] flex items-center justify-center text-white shadow-xl shadow-blue-900/20 font-black text-xl sm:text-2xl uppercase">
                <svg class="w-7 h-7 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                    </path>
                </svg>
            </div>
            <div class="space-y-1 sm:space-y-2">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="px-2.5 py-1 rounded-full text-[7px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-blue-50 text-[#0077B6] border border-blue-100">
                        Pusat Notifikasi
                    </div>
                    <div class="h-3 w-[1px] bg-slate-200"></div>
                    <span class="text-slate-400 text-[7px] sm:text-[10px] font-bold uppercase tracking-widest">Notifikasi</span>
                </div>
                <h2 class="text-xl sm:text-4xl font-black text-[#03045E] tracking-tight leading-tight">
                    Pesan <span class="text-[#00B4D8]">Sistem</span>
                </h2>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            @if($unreadCount > 0)
                <form action="{{ route($markAllReadRoute) }}" method="POST" class="w-full md:w-auto">
                    @csrf
                    <button type="submit"
                        class="w-full px-6 py-4 bg-[#03045E] text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-[#0077B6] transition-all flex items-center justify-center gap-3 shadow-xl shadow-blue-900/20 active:scale-95 group/btn">
                        Tandai Semua Terbaca
                    </button>
                </form>
            @endif

            @if($totalCount > 0)
                <button type="button" @click="$dispatch('open-modal', 'confirm-delete-all-notifications')"
                    class="w-full px-6 py-4 bg-rose-500 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-rose-600 transition-all flex items-center justify-center gap-3 shadow-xl shadow-rose-900/20 active:scale-95">
                    <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                    Hapus Semua Notifikasi
                </button>
            @endif
        </div>

        @if($totalCount > 0)
            <x-modal name="confirm-delete-all-notifications" focusable maxWidth="md">
                <form action="{{ route($deleteAllRoute) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="bg-white p-8 sm:p-12">
                        <div class="w-20 h-20 rounded-[2rem] bg-rose-50 text-rose-600 flex items-center justify-center mb-8 shadow-xl shadow-rose-900/10 border border-rose-100">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </div>

                        <h3 class="text-3xl font-black text-[#03045E] tracking-tight leading-tight mb-4">Hapus Semua Notifikasi?</h3>
                        <p class="text-slate-500 font-bold text-sm leading-relaxed mb-0 uppercase tracking-tight">
                            Tindakan ini akan menghapus semua notifikasi Anda dan tidak dapat dikembalikan.
                        </p>
                    </div>

                    <div class="px-8 sm:px-12 py-8 bg-slate-50 flex flex-col sm:flex-row-reverse gap-4">
                        <button type="submit"
                            class="flex-1 px-8 py-5 bg-rose-600 hover:bg-rose-700 text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] transition-all duration-300 shadow-xl shadow-rose-900/40 active:scale-95">
                            Konfirmasi Hapus
                        </button>
                        <button type="button" @click="$dispatch('close-modal', 'confirm-delete-all-notifications')"
                            class="flex-1 px-8 py-5 bg-white text-slate-500 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] transition-all duration-300 border border-slate-200 active:scale-95">
                            Batal
                        </button>
                    </div>
                </form>
            </x-modal>
        @endif
    </div>
</div>
