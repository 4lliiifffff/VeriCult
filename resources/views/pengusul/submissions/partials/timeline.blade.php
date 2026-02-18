<div class="relative">
    <!-- Timeline Items -->
    <div class="space-y-0">
        <!-- Draft -->
        <div class="relative flex items-start gap-4 group/item">
            <!-- Line segment for this item -->
            <div class="absolute left-4 top-8 bottom-0 w-0.5 bg-slate-200 group-last/item:hidden"></div>
            
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-100 border-2 border-gray-300 flex items-center justify-center z-10">
                <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
            </div>
            <div class="flex-1 pb-8">
                <p class="text-sm font-bold text-slate-700">Draft Created</p>
                <p class="text-xs text-slate-400 mt-0.5">{{ $submission->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <!-- Submitted -->
        @if($submission->status != 'draft')
        <div class="relative flex items-start gap-4 group/item">
            <div class="absolute left-4 top-8 bottom-0 w-0.5 bg-slate-200 group-last/item:hidden"></div>
            <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $submission->submitted_at ? 'bg-blue-100 border-blue-300' : 'bg-slate-100 border-slate-300' }} border-2 flex items-center justify-center z-10">
                <svg class="w-4 h-4 {{ $submission->submitted_at ? 'text-blue-600' : 'text-slate-400' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="flex-1 pb-8">
                <p class="text-sm font-bold {{ $submission->submitted_at ? 'text-slate-700' : 'text-slate-400' }}">Submitted for Review</p>
                @if($submission->submitted_at)
                <p class="text-xs text-slate-400 mt-0.5">{{ $submission->submitted_at->format('d M Y, H:i') }}</p>
                @else
                <p class="text-xs text-slate-400 mt-0.5">Pending</p>
                @endif
            </div>
        </div>
        @endif

        <!-- Administrative Review -->
        @if(in_array($submission->status, ['administrative_review', 'field_verification', 'verified', 'published']))
        <div class="relative flex items-start gap-4 group/item">
            <div class="absolute left-4 top-8 bottom-0 w-0.5 bg-slate-200 group-last/item:hidden"></div>
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-100 border-2 border-indigo-300 flex items-center justify-center z-10">
                <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="flex-1 pb-8">
                <p class="text-sm font-bold text-slate-700">Administrative Review</p>
                <p class="text-xs text-slate-400 mt-0.5">In Progress</p>
            </div>
        </div>
        @endif

        <!-- Verified -->
        @if(in_array($submission->status, ['verified', 'published']))
        <div class="relative flex items-start gap-4 group/item">
            <div class="absolute left-4 top-8 bottom-0 w-0.5 bg-slate-200 group-last/item:hidden"></div>
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-100 border-2 border-emerald-300 flex items-center justify-center z-10">
                <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="flex-1 pb-8">
                <p class="text-sm font-bold text-slate-700">Verified</p>
                @if($submission->verified_at)
                <p class="text-xs text-slate-400 mt-0.5">{{ $submission->verified_at->format('d M Y, H:i') }}</p>
                @else
                <p class="text-xs text-slate-400 mt-0.5">Completed</p>
                @endif
            </div>
        </div>
        @endif

        <!-- Published -->
        @if($submission->status == 'published')
        <div class="relative flex items-start gap-4 group/item">
            <div class="absolute left-4 top-8 bottom-0 w-0.5 bg-slate-200 group-last/item:hidden"></div>
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 border-2 border-green-300 flex items-center justify-center z-10">
                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="flex-1 pb-8">
                <p class="text-sm font-bold text-slate-700">Published</p>
                @if($submission->published_at)
                <p class="text-xs text-slate-400 mt-0.5">{{ $submission->published_at->format('d M Y, H:i') }}</p>
                @else
                <p class="text-xs text-slate-400 mt-0.5">Completed</p>
                @endif
            </div>
        </div>
        @endif

        <!-- Rejected -->
        @if($submission->status == 'rejected')
        <div class="relative flex items-start gap-4 group/item">
            <div class="absolute left-4 top-8 bottom-0 w-0.5 bg-slate-200 group-last/item:hidden"></div>
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-red-100 border-2 border-red-300 flex items-center justify-center z-10">
                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="flex-1 pb-8">
                <p class="text-sm font-bold text-red-700">Rejected</p>
                <p class="text-xs text-slate-400 mt-0.5">See reason above</p>
            </div>
        </div>
        @endif

        <!-- Revision -->
        @if($submission->status == 'revision')
        <div class="relative flex items-start gap-4 group/item">
            <div class="absolute left-4 top-8 bottom-0 w-0.5 bg-slate-200 group-last/item:hidden"></div>
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-amber-100 border-2 border-amber-300 flex items-center justify-center z-10">
                <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="flex-1 pb-8">
                <p class="text-sm font-bold text-amber-700">Needs Revision</p>
                <p class="text-xs text-slate-400 mt-0.5">Please update and resubmit</p>
            </div>
        </div>
        @endif
    </div>
</div>
