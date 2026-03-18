<div class="relative">
    <!-- Timeline Items -->
    <div class="space-y-0">
        @foreach($timeline as $item)
            @php
                // Map color strings to Tailwind classes
                $colorClasses = [
                    'gray'    => ['bg' => 'bg-gray-100', 'border' => 'border-gray-300', 'text' => 'text-gray-600', 'title' => 'text-slate-700'],
                    'blue'    => ['bg' => 'bg-blue-100', 'border' => 'border-blue-300', 'text' => 'text-blue-600', 'title' => 'text-slate-700'],
                    'indigo'  => ['bg' => 'bg-indigo-100', 'border' => 'border-indigo-300', 'text' => 'text-indigo-600', 'title' => 'text-slate-700'],
                    'emerald' => ['bg' => 'bg-emerald-100', 'border' => 'border-emerald-300', 'text' => 'text-emerald-600', 'title' => 'text-slate-700'],
                    'green'   => ['bg' => 'bg-green-100', 'border' => 'border-green-300', 'text' => 'text-green-600', 'title' => 'text-slate-700'],
                    'amber'   => ['bg' => 'bg-amber-100', 'border' => 'border-amber-300', 'text' => 'text-amber-600', 'title' => 'text-amber-700'],
                    'red'     => ['bg' => 'bg-red-100', 'border' => 'border-red-300', 'text' => 'text-red-600', 'title' => 'text-red-700'],
                ];
                $c = $colorClasses[$item['color']] ?? $colorClasses['gray'];
            @endphp
            
            <div class="relative flex items-start gap-4 group/item">
                <div class="absolute left-4 top-8 bottom-0 w-0.5 bg-slate-200 group-last/item:hidden"></div>
                
                <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $c['bg'] }} border-2 {{ $c['border'] }} flex items-center justify-center z-10 mt-1">
                    @if($item['icon'] === 'draft')
                        <svg class="w-4 h-4 {{ $c['text'] }}" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
                    @elseif($item['icon'] === 'submitted' || $item['icon'] === 'published')
                        <svg class="w-4 h-4 {{ $c['text'] }}" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                    @elseif($item['icon'] === 'forwarded')
                        <svg class="w-4 h-4 {{ $c['text'] }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                    @elseif($item['icon'] === 'verified')
                        <svg class="w-4 h-4 {{ $c['text'] }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    @elseif($item['icon'] === 'rejected')
                        <svg class="w-4 h-4 {{ $c['text'] }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                    @elseif($item['icon'] === 'revision')
                        <svg class="w-4 h-4 {{ $c['text'] }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    @endif
                </div>
                
                <div class="flex-1 pb-8 pt-1">
                    <p class="text-sm font-bold {{ $c['title'] }}">{{ $item['title'] }}</p>
                    <p class="text-[11px] font-bold text-slate-400 mt-0.5 tracking-wide">{{ \Carbon\Carbon::parse($item['date'])->translatedFormat('d F Y, H:i') }}</p>
                    
                    @if($item['description'])
                        <div class="mt-3 p-4 bg-white/50 rounded-2xl border {{ $c['border'] }} shadow-sm">
                            <p class="text-xs font-medium italic break-words whitespace-pre-wrap {{ $c['text'] }}">"{{ $item['description'] }}"</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
