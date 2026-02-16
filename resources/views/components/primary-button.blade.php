<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-[#0077B6] to-[#00B4D8] border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-[#006BA3] hover:to-[#00A3C5] focus:outline-none focus:ring-2 focus:ring-[#00B4D8] focus:ring-offset-2 active:from-[#005A8A] active:to-[#0092B2] disabled:opacity-50 transition-all duration-300 ease-in-out shadow-md hover:shadow-lg']) }}>
    {{ $slot }}
</button>
