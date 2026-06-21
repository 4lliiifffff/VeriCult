<x-layouts.pengusul-desa>
    <x-slot name="header">
        <nav class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-slate-400 mb-6 sm:mb-8 overflow-x-auto whitespace-nowrap pb-2 uppercase tracking-widest">
            <a href="{{ route('pengusul-desa.dashboard') }}" class="hover:text-[#0077B6] transition-colors">Dashboard</a>
            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 shrink-0 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-[#03045E]">Pusat Notifikasi</span>
        </nav>

        @include('notifications._header', [
            'markAllReadRoute' => 'pengusul-desa.notifications.mark-all-read',
            'deleteAllRoute'   => 'pengusul-desa.notifications.delete-all',
        ])
    </x-slot>

    @include('notifications._filter', ['routeName' => 'pengusul-desa.notifications.index'])

    @include('notifications._mark-read-script')
</x-layouts.pengusul-desa>
