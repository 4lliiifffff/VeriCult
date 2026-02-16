<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-white border-2 border-[#0077B6] rounded-lg font-semibold text-xs text-[#023E8A] uppercase tracking-widest shadow-sm hover:bg-[#F0F9FF] hover:border-[#0096C7] focus:outline-none focus:ring-2 focus:ring-[#00B4D8] focus:ring-offset-2 disabled:opacity-25 transition-all duration-300 ease-in-out']) }}>
    {{ $slot }}
</button>
