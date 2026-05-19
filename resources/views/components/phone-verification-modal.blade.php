@if(Auth::check() && in_array(Auth::user()->roles->first()?->name, ['pengusul', 'pengusul-desa']) && empty(Auth::user()->no_hp))
<div x-data="{ 
        isOpen: true,
        isForced: {{ session('force_phone_verification') ? 'true' : 'false' }},
        step: 1, 
        phoneNumber: '', 
        otpToken: '', 
        isLoading: false, 
        errorMessage: '', 
        successMessage: '',
        
        closeModal() {
            if (!this.isForced) {
                this.isOpen = false;
            }
        },
        
        sendOtp() {
            if(!this.phoneNumber || this.phoneNumber.length < 10) {
                this.errorMessage = 'Masukkan nomor telepon yang valid (min. 10 digit).';
                return;
            }
            this.isLoading = true;
            this.errorMessage = '';
            
            fetch('{{ route('phone.verification.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ phone_number: this.phoneNumber })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                this.isLoading = false;
                if(res.status === 200) {
                    this.step = 2;
                    this.successMessage = res.body.message;
                } else {
                    this.errorMessage = res.body.message || res.body.errors?.phone_number?.[0] || 'Terjadi kesalahan.';
                }
            })
            .catch(error => {
                this.isLoading = false;
                this.errorMessage = 'Terjadi kesalahan jaringan.';
            });
        },
        
        verifyOtp() {
            if(!this.otpToken || this.otpToken.length !== 6) {
                this.errorMessage = 'Kode OTP harus 6 digit.';
                return;
            }
            this.isLoading = true;
            this.errorMessage = '';
            
            fetch('{{ route('phone.verification.verify') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ token: this.otpToken })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(res => {
                this.isLoading = false;
                if(res.status === 200) {
                    window.location.reload();
                } else {
                    this.errorMessage = res.body.message || res.body.errors?.token?.[0] || 'Terjadi kesalahan.';
                }
            })
            .catch(error => {
                this.isLoading = false;
                this.errorMessage = 'Terjadi kesalahan jaringan.';
            });
        }
    }" 
    class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-slate-900/75"
    x-show="isOpen"
    style="display: none;"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    
    <div @click.away="!isForced ? closeModal() : null" class="bg-white rounded-3xl w-full max-w-md p-8 shadow-2xl relative overflow-hidden text-center"
         x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300 delay-75" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-8">
        
        <!-- Close Button (Only if not forced) -->
        <button x-show="!isForced" @click="closeModal" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-white/10 text-white/70 hover:bg-white/20 hover:text-white transition-all z-20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <!-- Decorative Header -->
        <!-- <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-br from-[#03045E] to-[#0077B6] rounded-t-3xl"></div>
        <div class="absolute -top-16 -right-16 w-32 h-32 bg-white/10 rounded-full blur-xl z-0"></div>
        
        <div class="relative z-10"> -->
        
        <!-- Icon -->
        <div class="w-20 h-20 bg-white rounded-2xl mx-auto flex items-center justify-center shadow-lg border border-slate-50 mb-6 mt-4">
            <svg class="w-10 h-10 text-[#0077B6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
        </div>

        <h3 class="text-2xl font-black text-[#03045E] mb-2" x-text="step === 1 ? 'Lengkapi Profil Anda' : 'Verifikasi OTP'"></h3>
        <p class="text-slate-500 text-sm font-medium mb-8" x-show="!isForced" x-text="step === 1 ? 'Untuk melanjutkan, Anda diwajibkan untuk mengisi nomor telepon (WhatsApp) yang aktif.' : 'Masukkan 6 digit kode yang telah dikirim ke Email dan WhatsApp Anda.'"></p>
        <p class="text-rose-500 text-sm font-bold mb-8" x-show="isForced">Peringatan: Anda diwajibkan untuk memverifikasi Nomor Handphone sebelum dapat mengakses form pengajuan kebudayaan!</p>

        <!-- Error Message -->
        <div x-show="errorMessage" x-transition class="mb-6 bg-red-50 text-red-600 text-xs font-bold px-4 py-3 rounded-xl border border-red-100 flex items-center gap-2 text-left">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span x-text="errorMessage"></span>
        </div>
        
        <!-- Success Message -->
        <div x-show="successMessage" x-transition class="mb-6 bg-emerald-50 text-emerald-600 text-xs font-bold px-4 py-3 rounded-xl border border-emerald-100 flex items-center gap-2 text-left">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span x-text="successMessage"></span>
        </div>

        <!-- Step 1: Input Phone Number -->
        <div x-show="step === 1" x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="relative group text-left mb-6">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#0077B6] transition-colors">
                    <span class="font-bold text-sm">+62</span>
                </div>
                <input type="text" x-model="phoneNumber" placeholder="81234567890" class="block w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all" @keydown.enter="sendOtp">
            </div>
            
            <button @click="sendOtp" :disabled="isLoading" class="w-full bg-[#03045E] text-white py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#0077B6] hover:shadow-xl hover:shadow-blue-900/20 hover:-translate-y-0.5 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                <span x-show="!isLoading">Kirim Kode Verifikasi</span>
                <span x-show="isLoading" class="flex items-center justify-center gap-2">
                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Memproses...
                </span>
            </button>
        </div>

        <!-- Step 2: Input OTP -->
        <div x-show="step === 2" style="display: none;" x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="relative group text-left mb-6">
                <input type="text" x-model="otpToken" maxlength="6" placeholder="******" class="block w-full text-center tracking-[1em] py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-lg font-black focus:ring-4 focus:ring-[#0077B6]/10 focus:border-[#0077B6] transition-all" @keydown.enter="verifyOtp">
            </div>
            
            <button @click="verifyOtp" :disabled="isLoading" class="w-full bg-[#10B981] text-white py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#059669] hover:shadow-xl hover:shadow-emerald-900/20 hover:-translate-y-0.5 transition-all disabled:opacity-50 disabled:cursor-not-allowed mb-4">
                <span x-show="!isLoading">Verifikasi & Simpan</span>
                <span x-show="isLoading" class="flex items-center justify-center gap-2">
                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Memverifikasi...
                </span>
            </button>

            <button @click="step = 1; otpToken = ''; successMessage = ''; errorMessage = '';" class="text-[10px] font-bold text-slate-400 hover:text-[#0077B6] uppercase tracking-widest transition-colors">
                Ubah Nomor Telepon
            </button>
        </div>
        </div>
    </div>
</div>
@endif
