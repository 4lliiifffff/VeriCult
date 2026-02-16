@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-200 focus:border-[#0077B6] focus:ring-4 focus:ring-[#00B4D8]/10 rounded-xl shadow-sm w-full transition-all duration-300 hover:border-slate-300 placeholder-slate-400 text-slate-700']) }}>
