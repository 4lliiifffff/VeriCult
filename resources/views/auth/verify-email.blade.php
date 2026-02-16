<x-guest-layout>
    <!-- Header with Animated Icon -->
    <div class="mb-10 text-center">
        <div class="relative w-20 h-20 mx-auto mb-5">
            <div class="absolute inset-0 bg-gradient-to-br from-[#48CAE4] to-[#90E0EF] rounded-2xl animate-pulse opacity-75"></div>
            <div class="relative w-20 h-20 bg-gradient-to-br from-[#00B4D8] to-[#48CAE4] rounded-2xl flex items-center justify-center shadow-2xl shadow-[#00B4D8]/40">
                <svg class="w-11 h-11 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        <h2 class="text-3xl font-bold text-[#03045E] mb-2">Verifikasi Email</h2>
        <p class="text-[#64748B]">Silakan verifikasi alamat email Anda</p>
    </div>

    <!-- Info Message -->
    <div class="mb-6 bg-gradient-to-r from-[#E0F2FE] to-[#DBEAFE] border-l-4 border-[#0077B6] p-4 rounded-xl shadow-sm">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-[#0077B6] mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <p class="text-sm text-[#03045E] font-bold">Email Verifikasi Telah Dikirim</p>
                <p class="text-xs text-[#475569] mt-1 leading-relaxed">
                    Kami telah mengirimkan link verifikasi ke alamat email Anda. Silakan periksa inbox atau folder spam.
                </p>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 bg-gradient-to-r from-[#DCFCE7] to-[#D1FAE5] border-l-4 border-[#10B981] p-4 rounded-xl shadow-sm">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-[#10B981] mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="text-sm text-[#065F46] font-bold">✓ Link Verifikasi Baru Telah Dikirim!</p>
                    <p class="text-xs text-[#047857] mt-1 leading-relaxed">
                        Silakan periksa email Anda dan klik link verifikasi yang baru saja kami kirimkan.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="space-y-4">
        <!-- Resend Verification Email -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full bg-gradient-to-r from-[#0077B6] to-[#00B4D8] hover:from-[#006BA3] hover:to-[#00A3C5] text-white font-bold py-3.5 px-4 rounded-xl transition-all duration-300 ease-in-out shadow-md hover:shadow-lg flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                {{ __('Kirim Ulang Email Verifikasi') }}
            </button>
        </form>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full border-2 border-[#0077B6] text-[#023E8A] hover:bg-[#F0F9FF] hover:border-[#0096C7] font-bold py-3.5 px-4 rounded-xl transition-all duration-300 ease-in-out shadow-sm flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                {{ __('Logout') }}
            </button>
        </form>
    </div>

    <!-- Help Section -->
    <div class="mt-10 pt-8 border-t border-gray-100">
        <h3 class="text-sm font-bold text-[#03045E] mb-4 flex items-center">
            <svg class="w-4 h-4 mr-2 text-[#0077B6]" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
            </svg>
            Tidak menerima email?
        </h3>
        <ul class="space-y-3 text-xs text-[#475569]">
            <li class="flex items-start bg-gradient-to-r from-[#F8FAFC] to-white p-3.5 rounded-xl border border-gray-100">
                <svg class="w-4 h-4 text-[#0077B6] mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="leading-relaxed"><strong class="text-[#03045E]">Periksa folder spam</strong> atau junk email Anda</span>
            </li>
            <li class="flex items-start bg-gradient-to-r from-[#F8FAFC] to-white p-3.5 rounded-xl border border-gray-100">
                <svg class="w-4 h-4 text-[#0077B6] mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="leading-relaxed"><strong class="text-[#03045E]">Pastikan alamat email</strong> yang Anda daftarkan sudah benar</span>
            </li>
            <li class="flex items-start bg-gradient-to-r from-[#F8FAFC] to-white p-3.5 rounded-xl border border-gray-100">
                <svg class="w-4 h-4 text-[#0077B6] mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="leading-relaxed"><strong class="text-[#03045E]">Tunggu beberapa menit</strong>, kemudian klik tombol "Kirim Ulang" di atas</span>
            </li>
        </ul>
    </div>

    <!-- Security Badge -->
    <div class="mt-8 pt-6 border-t border-gray-100">
        <div class="flex items-center justify-center text-xs text-gray-500">
            <svg class="w-4 h-4 mr-2 text-[#0077B6]" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span class="font-medium">Email verifikasi dilindungi dengan enkripsi</span>
        </div>
    </div>
</x-guest-layout>
