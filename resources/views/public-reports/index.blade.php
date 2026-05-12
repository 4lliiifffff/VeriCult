<x-layouts.public>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-3xl sm:text-4xl font-black text-[#03045E] mb-4">Laporan Publik Kebudayaan</h1>
                <p class="text-slate-500 max-w-2xl mx-auto">Akses dan unduh data rekapitulasi kebudayaan yang telah tervalidasi dan dipublikasikan secara resmi.</p>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-[2rem] p-6 shadow-xl shadow-slate-200/50 mb-8 border border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
                <form action="{{ route('public.reports.index') }}" method="GET" class="flex items-center gap-3 w-full md:w-auto">
                    <label for="year" class="text-sm font-bold text-slate-600">Periode Data:</label>
                    <select name="year" id="year" onchange="this.form.submit()" class="rounded-xl border-slate-200 text-slate-700 font-medium focus:ring-[#0077B6] focus:border-[#0077B6] w-32">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" {{ $activeYear == $year ? 'selected' : '' }}>Tahun {{ $year }}</option>
                        @endforeach
                    </select>
                </form>

                <a href="{{ route('public.reports.print', ['year' => $activeYear]) }}" target="_blank" class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#0077B6] hover:bg-[#03045E] text-white rounded-xl font-bold tracking-wide transition-all shadow-lg shadow-blue-900/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak / Unduh PDF
                </a>
            </div>

            <!-- Summary Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Chart -->
                <div class="lg:col-span-1 bg-white rounded-[2rem] p-6 shadow-xl shadow-slate-200/50 border border-slate-100">
                    <h3 class="text-lg font-black text-[#03045E] mb-6">Distribusi Kategori</h3>
                    <div class="relative h-64">
                        @if($categoryStats->isEmpty())
                            <div class="absolute inset-0 flex items-center justify-center text-slate-400 font-medium text-sm">Belum ada data</div>
                        @else
                            <canvas id="categoryChart"></canvas>
                        @endif
                    </div>
                </div>

                <!-- Table Preview -->
                <div class="lg:col-span-2 bg-white rounded-[2rem] p-6 shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden flex flex-col">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-black text-[#03045E]">Data Kebudayaan ({{ $activeYear }})</h3>
                        <span class="px-3 py-1 bg-blue-50 text-[#0077B6] rounded-lg text-xs font-bold">{{ $submissions->count() }} Total</span>
                    </div>
                    
                    <div class="flex-1 overflow-auto border border-slate-100 rounded-xl">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-[10px] font-black text-slate-500 uppercase tracking-widest border-b border-slate-100">
                                    <th class="p-4">Nama Objek</th>
                                    <th class="p-4">Kategori</th>
                                    <th class="p-4">Wilayah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($submissions as $sub)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="p-4">
                                            <p class="font-bold text-[#03045E] text-sm">{{ $sub->name }}</p>
                                        </td>
                                        <td class="p-4">
                                            <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-[10px] font-bold uppercase tracking-wider">{{ $sub->category }}</span>
                                        </td>
                                        <td class="p-4 text-xs text-slate-500">
                                            {{ $sub->village->name ?? '-' }}<br>
                                            <span class="text-[9px] uppercase tracking-wider">{{ $sub->village->kecamatan->name ?? '-' }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="p-8 text-center text-slate-400 font-medium">Tidak ada data kebudayaan tervalidasi pada periode ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @if(!$categoryStats->isEmpty())
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('categoryChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($categoryStats->keys()) !!},
                    datasets: [{
                        data: {!! json_encode($categoryStats->values()) !!},
                        backgroundColor: [
                            '#03045E', '#0077B6', '#00B4D8', '#90E0EF', 
                            '#4361EE', '#3A0CA3', '#7209B7', '#F72585'
                        ],
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { font: { family: "'Outfit', sans-serif", size: 10 } } }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
    @endif
    @endpush
</x-layouts.public>
