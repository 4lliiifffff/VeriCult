@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { family: "'Outfit', sans-serif", weight: '700', size: 11 },
                        padding: 25,
                        usePointStyle: true,
                        color: '#64748B'
                    }
                },
                tooltip: {
                    backgroundColor: '#03045E',
                    titleFont: { family: "'Outfit', sans-serif", size: 13, weight: '800' },
                    bodyFont: { family: "'Outfit', sans-serif", size: 12 },
                    padding: 12,
                    cornerRadius: 12,
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
                    backgroundColor: ['#03045E', '#0077B6', '#00B4D8', '#48CAE4', '#90E0EF'],
                    borderWidth: 4,
                    borderColor: '#ffffff',
                    hoverOffset: 15
                }]
            },
            options: {
                ...chartOptions,
                cutout: '75%',
                layout: { padding: 10 }
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
                    backgroundColor: '#0077B6',
                    hoverBackgroundColor: '#03045E',
                    borderRadius: 8,
                    barThickness: 15
                }]
            },
            options: {
                ...chartOptions,
                plugins: { ...chartOptions.plugins, legend: { display: false } },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { color: '#F1F5F9', drawBorder: false },
                        ticks: { font: { family: "'Outfit', sans-serif", weight: '600', size: 10 }, color: '#94A3B8' }
                    },
                    x: { 
                        grid: { display: false }, 
                        ticks: { font: { family: "'Outfit', sans-serif", weight: '700', size: 9 }, color: '#64748B' } 
                    }
                }
            }
        });

        // 3. Yearly Comparison Chart
        const yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
        new Chart(yearlyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($yearlyComparison->pluck('period_year')) !!}.map(String),
                datasets: [{
                    label: 'Total Pengajuan',
                    data: {!! json_encode($yearlyComparison->pluck('count')) !!},
                    borderColor: '#03045E',
                    backgroundColor: 'rgba(3, 4, 94, 0.05)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 4,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#03045E',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                ...chartOptions,
                plugins: { ...chartOptions.plugins, legend: { display: false } },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { color: '#F1F5F9', borderDash: [5, 5], drawBorder: false },
                        ticks: { font: { family: "'Outfit', sans-serif", weight: '600', size: 10 }, color: '#94A3B8' }
                    },
                    x: { 
                        grid: { display: false },
                        ticks: { font: { family: "'Outfit', sans-serif", weight: '700', size: 11 }, color: '#64748B' }
                    }
                }
            }
        });

        // 4. Village Review Distribution
        const villageCtx = document.getElementById('villageReviewChart').getContext('2d');
        const villageData = {!! json_encode($villageReviewStats) !!};
        new Chart(villageCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(villageData).map(v => v.replace('Desa ', '')),
                datasets: [{
                    label: 'Jumlah Review',
                    data: Object.values(villageData),
                    backgroundColor: '#00B4D8',
                    hoverBackgroundColor: '#03045E',
                    borderRadius: 6,
                    barThickness: 12
                }]
            },
            options: {
                ...chartOptions,
                indexAxis: 'y',
                plugins: { ...chartOptions.plugins, legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, grid: { color: '#F1F5F9', drawBorder: false } },
                    y: { grid: { display: false }, ticks: { font: { family: "'Outfit', sans-serif", weight: '800', size: 11 }, color: '#334155' } }
                }
            }
        });

        // 5. Active Category Distribution
        const activeCatCtx = document.getElementById('activeCatChart').getContext('2d');
        const activeCatData = {!! json_encode($aktifCategoryStats) !!};
        new Chart(activeCatCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(activeCatData),
                datasets: [{
                    data: Object.values(activeCatData),
                    backgroundColor: ['#03045E', '#0077B6', '#00B4D8', '#48CAE4', '#90E0EF', '#023E8A', '#0096C7'],
                    borderWidth: 3,
                    borderColor: '#fff'
                }]
            },
            options: {
                ...chartOptions,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 10, font: { size: 9, weight: '700' }, padding: 15 }
                    }
                }
            }
        });
    });
</script>
@endpush

<x-layouts.validator>
    <x-slot name="header">
        <div class="relative bg-white rounded-[2.5rem] p-10 shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full blur-3xl transition-transform duration-1000 group-hover:scale-110"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.2em] uppercase bg-[#03045E] text-white shadow-lg shadow-blue-900/20">
                            Validator Ahli
                        </div>
                        <div class="h-4 w-[1px] bg-slate-200"></div>
                        <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Portal Verifikasi</span>
                    </div>
                    <h2 class="text-4xl sm:text-5xl font-black text-[#03045E] tracking-tight leading-tight">
                        Dashboard <span class="text-[#0077B6]">Validator</span>
                    </h2>
                    <p class="text-slate-500 text-lg font-medium max-w-2xl leading-relaxed">
                        Pantau dan verifikasi pengajuan kebudayaan dengan teliti untuk menjaga integritas data kebudayaan nasional.
                    </p>
                </div>
                
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 bg-slate-50 p-6 rounded-[2rem] border border-slate-100 shadow-inner relative z-20">
                    <form action="{{ route('validator.dashboard') }}" method="GET" class="flex-1 sm:flex-none">
                        <select name="year" onchange="this.form.submit()" class="w-full sm:w-48 bg-white border-slate-200 rounded-2xl text-xs font-black uppercase tracking-widest text-[#03045E] focus:ring-4 focus:ring-blue-900/5 focus:border-[#0077B6] transition-all py-3.5 px-5 shadow-sm">
                            <option value="">Semua Periode</option>
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}" {{ $activeYear == $year ? 'selected' : '' }}>Tahun {{ $year }}</option>
                            @endforeach
                        </select>
                    </form>
                    <div class="hidden sm:block h-10 w-px bg-slate-200 mx-2"></div>
                    <a href="{{ route('validator.cultural.create') }}" class="w-full sm:w-auto justify-center inline-flex bg-[#03045E] text-white px-8 py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-[#0077B6] transition-all shadow-lg shadow-blue-900/20 gap-2 items-center active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        Buat Pengajuan
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-10 pb-12">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6">
            <!-- Pengajuan Saya -->
            <div class="group bg-[#03045E] text-white rounded-[2.5rem] p-8 shadow-xl shadow-blue-900/30 border border-white/10 hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-500 relative overflow-hidden lg:col-span-1">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-white/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-[#00B4D8] group-hover:bg-white group-hover:text-[#03045E] transition-all duration-500 shadow-inner mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-white/50 uppercase tracking-[0.2em] mb-1">Pengajuan Saya</p>
                        <h3 class="text-3xl font-black text-white tabular-nums tracking-tight">{{ number_format($stats['my_submissions']) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Other Stats -->
            @php
                $statItems = [
                    ['key' => 'total_submitted', 'label' => 'Total Diajukan', 'color' => 'blue', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>'],
                    ['key' => 'my_reviews', 'label' => 'Review Saya', 'color' => 'amber', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>'],
                    ['key' => 'needs_revision', 'label' => 'Perlu Revisi', 'color' => 'rose', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>'],
                    ['key' => 'forwarded', 'label' => 'Forwarded', 'color' => 'emerald', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>'],
                    ['key' => 'rejected', 'label' => 'Ditolak', 'color' => 'slate', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>'],
                ];
            @endphp

            @foreach($statItems as $item)
            <div class="group bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/30 border border-white hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-slate-50 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <div @class([
                        'w-12 h-12 rounded-2xl flex items-center justify-center transition-all duration-500 shadow-inner mb-6',
                        'bg-blue-50 text-[#0077B6] group-hover:bg-[#0077B6] group-hover:text-white' => $item['color'] == 'blue',
                        'bg-amber-50 text-amber-600 group-hover:bg-amber-600 group-hover:text-white' => $item['color'] == 'amber',
                        'bg-rose-50 text-rose-500 group-hover:bg-rose-500 group-hover:text-white' => $item['color'] == 'rose',
                        'bg-emerald-50 text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white' => $item['color'] == 'emerald',
                        'bg-slate-50 text-slate-500 group-hover:bg-slate-500 group-hover:text-white' => $item['color'] == 'slate',
                    ])>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $item['icon'] !!}</svg>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">{{ $item['label'] }}</p>
                        <h3 class="text-3xl font-black text-[#03045E] tabular-nums tracking-tight">{{ number_format($stats[$item['key']]) }}</h3>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Analytics Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white">
                <h3 class="text-lg font-black text-[#03045E] mb-1">Status Verifikasi</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-10">Pipa Review Personal</p>
                <div class="h-80 relative">
                    <canvas id="pipelineChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white">
                <h3 class="text-lg font-black text-[#03045E] mb-1">Beban Wilayah</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-10">Distribusi Review Per Desa</p>
                <div class="h-80 relative">
                    <canvas id="villageReviewChart"></canvas>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 bg-white p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white">
                <h3 class="text-lg font-black text-[#03045E] mb-1">Kategori Objek</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-10">Populasi Data Kebudayaan</p>
                <div class="h-72 relative">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>

            <div class="lg:col-span-2 bg-white p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white">
                <h3 class="text-lg font-black text-[#03045E] mb-1">Tren Pertumbuhan</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-10">Akumulasi Pengajuan Tahunan</p>
                <div class="h-72 relative">
                    <canvas id="yearlyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Submissions Table -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white overflow-hidden group">
            <div class="p-8 sm:p-10 border-b border-slate-50 flex items-center justify-between">
                <div>
                    <h3 class="text-xl sm:text-2xl font-black text-[#03045E]">Antrean Verifikasi</h3>
                    <p class="text-slate-400 font-medium text-xs mt-1">Submission terbaru yang menunggu tindak lanjut.</p>
                </div>
                <a href="{{ route('validator.submissions.index') }}" class="px-6 py-3 rounded-2xl bg-slate-50 border-2 border-slate-100 text-[#03045E] font-black text-[10px] tracking-widest uppercase hover:bg-white hover:border-[#0077B6] hover:text-[#0077B6] transition-all">
                    Lihat Semua
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-max">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                            <th class="px-10 py-5">Objek Kebudayaan</th>
                            <th class="px-10 py-5">Pengusul</th>
                            <th class="px-10 py-5 text-center">Waktu Masuk</th>
                            <th class="px-10 py-5 text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentSubmissions as $submission)
                        <tr class="hover:bg-slate-50/50 transition-colors group/row">
                            <td class="px-10 py-6">
                                <div class="font-bold text-sm text-[#03045E] mb-1 group-hover/row:text-[#0077B6] transition-colors">{{ $submission->name }}</div>
                                <div class="inline-flex px-2 py-0.5 bg-blue-50 text-[#0077B6] text-[8px] font-black uppercase tracking-widest rounded-md border border-blue-100">{{ $submission->category }}</div>
                            </td>
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-xl bg-slate-100 text-[#03045E] flex items-center justify-center font-black text-xs">
                                        {{ substr($submission->user->name, 0, 2) }}
                                    </div>
                                    <div class="text-xs font-bold text-slate-600">{{ $submission->user->name }}</div>
                                </div>
                            </td>
                            <td class="px-10 py-6 text-center">
                                <div class="text-xs font-bold text-[#03045E]">{{ $submission->created_at->translatedFormat('d M Y') }}</div>
                                <div class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">{{ $submission->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-10 py-6 text-right">
                                <a href="{{ route('validator.submissions.show', $submission) }}" class="inline-flex items-center gap-3 px-6 py-3 bg-[#03045E] text-white text-[9px] font-black uppercase tracking-widest rounded-2xl hover:bg-[#0077B6] hover:shadow-lg hover:shadow-blue-900/20 active:scale-95 transition-all">
                                    Mulai Review
                                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-10 py-20 text-center flex flex-col items-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-200 mb-4 shadow-inner">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </div>
                                <p class="text-slate-400 font-black text-[10px] tracking-[0.2em] uppercase">Semua Antrean Bersih</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.validator>
