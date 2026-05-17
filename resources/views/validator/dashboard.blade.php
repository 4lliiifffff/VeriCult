@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Shared Palette
        const palette = [
            '#03045E', // Tradisi Lisan
            '#0077B6', // Manuskrip
            '#00B4D8', // Adat Istiadat
            '#06D6A0', // Ritus
            '#10B981', // Pengetahuan Tradisional
            '#20BF55', // Teknologi Tradisional
            '#FFD166', // Seni
            '#FF9F1C', // Bahasa
            '#FF5400', // Permainan Rakyat
            '#EF4444', // Olahraga Tradisional
            '#F72585', // Cagar Budaya
            '#7209B7', // Potensi Cagar Budaya
            '#3A0CA3', // Potensi Kebudayaan
            '#4361EE', // Laporan Kebudayaan Aktif
        ];

        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { family: "'Outfit', sans-serif", weight: '700', size: 11 },
                        padding: 20,
                        usePointStyle: true,
                        color: '#64748B'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(3, 4, 94, 0.9)',
                    titleFont: { family: "'Outfit', sans-serif", size: 13, weight: '800' },
                    bodyFont: { family: "'Outfit', sans-serif", size: 12 },
                    padding: 15,
                    cornerRadius: 16,
                    displayColors: true
                }
            }
        };

        // 1. My Review Pipeline Chart
        const pipelineCtx = document.getElementById('pipelineChart').getContext('2d');
        new Chart(pipelineCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($myReviewStats)) !!}.map(s => s.replace('_', ' ').toUpperCase()),
                datasets: [{
                    data: {!! json_encode(array_values($myReviewStats)) !!},
                    backgroundColor: palette,
                    borderWidth: 0,
                    hoverOffset: 15,
                    borderRadius: 1
                }]
            },
            options: {
                ...chartOptions,
                cutout: '75%',
                plugins: {
                    ...chartOptions.plugins,
                    legend: {
                        ...chartOptions.plugins.legend,
                        position: 'right',
                        labels: { ...chartOptions.plugins.legend.labels, padding: 15, boxWidth: 8 }
                    }
                }
            }
        });

        // 2. Global Category Distribution Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($categoryStats)) !!},
                datasets: [{
                    label: 'Populasi Data',
                    data: {!! json_encode(array_values($categoryStats)) !!},
                    backgroundColor: palette,
                    borderRadius: 8,
                    maxBarThickness: 30
                }]
            },
            options: {
                ...chartOptions,
                plugins: { ...chartOptions.plugins, legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#F8FAFC', drawBorder: false }, ticks: { font: { size: 10 } } },
                    x: { grid: { display: false }, ticks: { font: { family: "'Outfit', sans-serif", weight: '700', size: 9 }, color: '#64748B' } }
                }
            }
        });

        // 3. Yearly Comparison Chart
        const yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
        new Chart(yearlyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($yearlyComparison->keys()->map(fn($y) => (string)$y)->toArray()) !!},
                datasets: [{
                    label: 'Total Pengajuan',
                    data: {!! json_encode($yearlyComparison->values()->toArray()) !!},
                    borderColor: '#03045E',
                    backgroundColor: 'rgba(3, 4, 94, 0.05)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 4,
                    pointRadius: 6,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#03045E',
                    pointBorderWidth: 2,
                    pointHoverRadius: 8
                }]
            },
            options: {
                ...chartOptions,
                plugins: { ...chartOptions.plugins, legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#F8FAFC', borderDash: [5, 5], drawBorder: false }, ticks: { font: { size: 10 }, precision: 0 } },
                    x: { grid: { display: false }, ticks: { font: { weight: '800', size: 11 } } }
                }
            }
        });

        // 4. Village Review Distribution
        const villageCtx = document.getElementById('villageReviewChart').getContext('2d');
        const villageData = {!! json_encode($villageReviewStats) !!};
        new Chart(villageCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(villageData).map(v => v.replace('Desa ', '').replace('Kelurahan ', '')),
                datasets: [{
                    label: 'Jumlah Review',
                    data: Object.values(villageData),
                    backgroundColor: palette,
                    borderRadius: 5,
                }]
            },
            options: {
                ...chartOptions,
                indexAxis: 'y',
                plugins: { ...chartOptions.plugins, legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, grid: { color: '#F8FAFC', drawBorder: false } },
                    y: { grid: { display: false }, ticks: { font: { weight: '800', size: 10 }, color: '#334155' } }
                }
            }
        });
    });
</script>
@endpush

<x-layouts.validator>
    <x-slot name="header">
        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 z-40 group">
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
            
            <div class="relative z-10 flex flex-col xl:flex-row xl:items-center justify-between gap-6 sm:gap-8">
                <div class="space-y-2 sm:space-y-3">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="px-3 sm:px-4 py-1 sm:py-1.5 rounded-full text-[8px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-[#03045E] text-white shadow-lg shadow-blue-900/20">
                            Validator Ahli
                        </div>
                        <div class="h-3 sm:h-4 w-[1px] bg-slate-200"></div>
                        <span class="text-slate-400 text-[8px] sm:text-[10px] font-bold uppercase tracking-widest">Portal Verifikasi</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black text-[#03045E] tracking-tight leading-tight">
                        Dashboard <span class="text-[#0077B6]">Validator</span>
                    </h2>
                    <p class="text-slate-500 text-sm sm:text-lg font-medium max-w-2xl leading-relaxed">
                        Pantau dan verifikasi pengajuan kebudayaan dengan teliti untuk menjaga integritas data.
                    </p>
                </div>
                
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 bg-slate-50 p-5 sm:p-6 rounded-[2rem] border border-slate-100 shadow-inner relative z-20">
                    <form action="{{ route('validator.dashboard') }}" method="GET" class="flex-1 sm:flex-none auto-submit min-w-[200px]">
                        <x-dropdown-select 
                            name="year" 
                            id="year" 
                            placeholder="Semua Periode"
                            all-label="Semua Periode"
                            variant="light"
                            :selected="$activeYear" 
                            :options="collect($availableYears)->mapWithKeys(fn($y) => [$y => 'Tahun ' . $y])->toArray()" 
                        />
                    </form>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6 sm:space-y-10 pb-12">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-6">

            <!-- Other Stats -->
            @php
                $statItems = [
                    ['key' => 'total_submitted', 'label' => 'Diajukan', 'color' => 'blue', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>'],
                    ['key' => 'my_reviews', 'label' => 'Review Saya', 'color' => 'amber', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>'],
                    ['key' => 'needs_revision', 'label' => 'Perlu Revisi', 'color' => 'rose', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>'],
                    ['key' => 'forwarded', 'label' => 'Forwarded', 'color' => 'emerald', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>'],
                    ['key' => 'rejected', 'label' => 'Ditolak', 'color' => 'slate', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>'],
                ];
            @endphp

            @foreach($statItems as $item)
            <div class="group bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-8 shadow-xl shadow-slate-200/30 border border-white hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-slate-50 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <div @class([
                        'w-10 h-10 sm:w-12 sm:h-12 rounded-2xl flex items-center justify-center transition-all duration-500 shadow-inner mb-4 sm:mb-6',
                        'bg-blue-50 text-[#0077B6] group-hover:bg-[#0077B6] group-hover:text-white' => $item['color'] == 'blue',
                        'bg-amber-50 text-amber-600 group-hover:bg-amber-600 group-hover:text-white' => $item['color'] == 'amber',
                        'bg-rose-50 text-rose-500 group-hover:bg-rose-500 group-hover:text-white' => $item['color'] == 'rose',
                        'bg-emerald-50 text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white' => $item['color'] == 'emerald',
                        'bg-slate-50 text-slate-500 group-hover:bg-slate-500 group-hover:text-white' => $item['color'] == 'slate',
                    ])>
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $item['icon'] !!}</svg>
                    </div>
                    <div>
                        <p class="text-[8px] sm:text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">{{ $item['label'] }}</p>
                        <h3 class="text-2xl sm:text-3xl font-black text-[#03045E] tabular-nums tracking-tight">{{ number_format($stats[$item['key']]) }}</h3>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Analytics Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
            <div class="bg-white p-6 sm:p-10 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white">
                <h3 class="text-base sm:text-lg font-black text-[#03045E] mb-1">Status Verifikasi</h3>
                <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-8 sm:mb-10">Pipa Review Personal</p>
                <div class="h-64 sm:h-80 relative">
                    <canvas id="pipelineChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 sm:p-10 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white">
                <h3 class="text-base sm:text-lg font-black text-[#03045E] mb-1">Beban Wilayah</h3>
                <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-8 sm:mb-10">Distribusi Review Per Desa</p>
                <div class="h-64 sm:h-80 relative">
                    <canvas id="villageReviewChart"></canvas>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
            <div class="lg:col-span-1 bg-white p-6 sm:p-10 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white">
                <h3 class="text-base sm:text-lg font-black text-[#03045E] mb-1">Kategori Objek</h3>
                <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-8 sm:mb-10">Populasi Data Kebudayaan</p>
                <div class="h-56 sm:h-72 relative">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>

            <div class="lg:col-span-2 bg-white p-6 sm:p-10 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white">
                <h3 class="text-base sm:text-lg font-black text-[#03045E] mb-1">Tren Pertumbuhan</h3>
                <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-8 sm:mb-10">Akumulasi Pengajuan Tahunan</p>
                <div class="h-56 sm:h-72 relative">
                    <canvas id="yearlyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Submissions Table -->
        <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white overflow-hidden group">
            <div class="p-6 sm:p-10 border-b border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg sm:text-2xl font-black text-[#03045E]">Antrean Verifikasi</h3>
                    <p class="text-slate-400 font-medium text-[10px] sm:text-sm mt-1">Semua pengajuan yang menunggu tindak lanjut (seluruh periode).</p>
                </div>
                <a href="{{ route('validator.submissions.index') }}" class="px-5 sm:px-6 py-2.5 sm:py-3 rounded-2xl bg-slate-50 border-2 border-slate-100 text-[#03045E] font-black text-[9px] sm:text-[10px] tracking-widest uppercase hover:bg-white hover:border-[#0077B6] hover:text-[#0077B6] transition-all">
                    Lihat Semua &rarr;
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[640px]">
                    <thead>
                        <tr class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                            <th class="px-6 sm:px-10 py-4 sm:py-5">Objek Kebudayaan</th>
                            <th class="px-6 sm:px-10 py-4 sm:py-5">Pengusul</th>
                            <th class="px-6 sm:px-10 py-4 sm:py-5 text-center">Waktu Masuk</th>
                            <th class="px-6 sm:px-10 py-4 sm:py-5 text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentSubmissions as $submission)
                        <tr class="hover:bg-slate-50/50 transition-colors group/row">
                            <td class="px-6 sm:px-10 py-4 sm:py-6">
                                <div class="font-bold text-xs sm:text-sm text-[#03045E] mb-1 group-hover/row:text-[#0077B6] transition-colors line-clamp-1 max-w-[200px] sm:max-w-md">{{ $submission->name }}</div>
                                <div class="inline-flex px-2 py-0.5 bg-blue-50 text-[#0077B6] text-[8px] font-black uppercase tracking-widest rounded-md border border-blue-100">{{ $submission->category }}</div>
                            </td>
                            <td class="px-6 sm:px-10 py-4 sm:py-6">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 sm:h-9 sm:w-9 rounded-xl bg-slate-100 text-[#03045E] flex items-center justify-center font-black text-[10px] sm:text-xs">
                                        {{ substr($submission->user->name, 0, 2) }}
                                    </div>
                                    <div class="text-[10px] sm:text-xs font-bold text-slate-600 line-clamp-1">{{ $submission->user->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 sm:px-10 py-4 sm:py-6 text-center">
                                <div class="text-[10px] sm:text-xs font-bold text-[#03045E]">{{ $submission->created_at->translatedFormat('d M Y') }}</div>
                                <div class="text-[8px] sm:text-[9px] font-black text-slate-400 uppercase tracking-tighter">{{ $submission->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 sm:px-10 py-4 sm:py-6 text-right">
                                <a href="{{ route('validator.submissions.show', $submission) }}" class="inline-flex items-center gap-2 sm:gap-3 px-4 sm:px-6 py-2.5 sm:py-3 bg-[#03045E] text-white text-[8px] sm:text-[9px] font-black uppercase tracking-widest rounded-2xl hover:bg-[#0077B6] hover:shadow-lg hover:shadow-blue-900/20 active:scale-95 transition-all">
                                    <span class="hidden sm:inline">Mulai Review</span>
                                    <span class="sm:hidden">Review</span>
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 sm:px-10 py-20 text-center flex flex-col items-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-200 mb-4 shadow-inner">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </div>
                                <p class="text-slate-400 font-black text-[10px] tracking-[0.2em] uppercase">Antrean Bersih</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.validator>
