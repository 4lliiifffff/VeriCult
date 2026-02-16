@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#0077B6] focus:ring-[#00B4D8] rounded-lg shadow-sm w-full transition-all duration-200 hover:border-[#0096C7]']) }}>
