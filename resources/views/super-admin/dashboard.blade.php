@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Shared Colors
        const palette = [
            '#03045E', // Deep Blue
            '#4361EE', // Indigo
            '#3A0CA3', // Purple
            '#7209B7', // Violet
            '#F72585', // Rose
            '#4CC9F0', // Sky
            '#10B981', // Emerald
            '#F59E0B', // Amber
            '#EF4444', // Red
            '#06D6A0', // Mint
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
                        pointStyle: 'circle',
                        color: '#64748B'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(3, 4, 94, 0.9)',
                    backdropBlur: 8,
                    titleFont: { family: "'Outfit', sans-serif", size: 13, weight: '800' },
                    bodyFont: { family: "'Outfit', sans-serif", size: 12 },
                    padding: 15,
                    cornerRadius: 16,
                    displayColors: true,
                    boxPadding: 6
                }
            }
        };

        // 1. Status Distribution Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($statusStats)) !!}.map(s => {
                    const map = {
                        '{{\App\Models\CulturalSubmission::STATUS_DRAFT}}': 'Draf',
                        '{{\App\Models\CulturalSubmission::STATUS_SUBMITTED}}': 'Diajukan',
                        '{{\App\Models\CulturalSubmission::STATUS_ADMINISTRATIVE_REVIEW}}': 'Review Admin',
                        '{{\App\Models\CulturalSubmission::STATUS_FIELD_VERIFICATION}}': 'Verlap',
                        '{{\App\Models\CulturalSubmission::STATUS_VERIFIED}}': 'Verifikasi',
                        '{{\App\Models\CulturalSubmission::STATUS_PUBLISHED}}': 'Publikasi',
                        '{{\App\Models\CulturalSubmission::STATUS_REJECTED}}': 'Ditolak',
                        '{{\App\Models\CulturalSubmission::STATUS_REVISION}}': 'Revisi'
                    };
                    return map[s] || s.replace('_', ' ').toUpperCase();
                }),
                datasets: [{
                    data: {!! json_encode(array_values($statusStats)) !!},
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
                        labels: {
                            ...chartOptions.plugins.legend.labels,
                            padding: 15,
                            boxWidth: 8
                        }
                    }
                }
            }
        });

        // 2. Category Distribution Chart (Historical / Yearly)
        const yearlyCtx = document.getElementById('yearlyChart')?.getContext('2d');
        if (yearlyCtx) {
            new Chart(yearlyCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($yearlyComparison->pluck('period_year')) !!}.map(String),
                    datasets: [{
                        label: 'Total Usulan',
                        data: {!! json_encode($yearlyComparison->pluck('count')) !!},
                        backgroundColor: palette,
                        //  backgroundColor: '#4361EE',
                        borderRadius: 12,
                        barThickness: 'flex',
                        maxBarThickness: 40
                    }]
                },
                options: {
                    ...chartOptions,
                    plugins: { ...chartOptions.plugins, legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#F8FAFC', drawBorder: false }, ticks: { font: { size: 10 } } },
                        x: { grid: { display: false }, ticks: { font: { family: "'Outfit', sans-serif", weight: '800', size: 11 } } }
                    }
                }
            });
        }

        // 3. Trend Chart
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        const monthsShort = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const monthsEng = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        const typeTrendData = {!! json_encode($typeTrend) !!};
        const opkData = monthsEng.map(m => {
            const data = typeTrendData[m] || [];
            return (data.find(d => d.submission_type === 'opk') || {count: 0}).count;
        });
        const potensiData = monthsEng.map(m => {
            const data = typeTrendData[m] || [];
            return (data.find(d => d.submission_type === 'potensi-kebudayaan') || {count: 0}).count;
        });
        const cagarBudayaData = monthsEng.map(m => {
            const data = typeTrendData[m] || [];
            return (data.find(d => d.submission_type === 'cagar-budaya') || {count: 0}).count;
        });
        const aktifData = monthsEng.map(m => {
            const data = typeTrendData[m] || [];
            return (data.find(d => d.submission_type === 'aktif') || {count: 0}).count;
        });

        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: monthsShort,
                datasets: [
                    {
                        label: 'OPK',
                        data: opkData,
                        borderColor: '#4361EE',
                        backgroundColor: 'rgba(67, 97, 238, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 4,
                        pointRadius: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#4361EE',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Potensi',
                        data: potensiData,
                        borderColor: '#F59E0B',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 4,
                        pointRadius: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#F59E0B',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Cagar Budaya',
                        data: cagarBudayaData,
                        borderColor: '#F72585',
                        backgroundColor: 'rgba(247, 37, 133, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 4,
                        pointRadius: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#F72585',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Aktif',
                        data: aktifData,
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 4,
                        pointRadius: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#F72585',
                        pointBorderWidth: 2
                    }
                ]
            },
            options: {
                ...chartOptions,
                interaction: { intersect: false, mode: 'index' },
                plugins: { 
                    legend: { 
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: { boxWidth: 10, usePointStyle: true, font: { weight: '800' } }
                    } 
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { color: '#F8FAFC', drawBorder: false },
                        ticks: { font: { weight: '600', size: 10 }, color: '#94A3B8' }
                    },
                    x: { 
                        grid: { display: false },
                        ticks: { font: { weight: '700', size: 10 }, color: '#64748B' }
                    }
                }
            }
        });

        // 4. Kecamatan Distribution
        const kecamatanCtx = document.getElementById('kecamatanChart').getContext('2d');
        const kecamatanData = {!! json_encode($kecamatanDistribution) !!};
        new Chart(kecamatanCtx, {
            type: 'bar',
            data: {
                labels: kecamatanData.map(v => v.name.replace('Kecamatan ', '')),
                datasets: [
                    {
                        label: 'Total Pengajuan',
                        data: kecamatanData.map(v => v.count),
                        backgroundColor: '#4361EE',
                        borderRadius: 5,
                    }
                ]
            },
            options: {
                ...chartOptions,
                indexAxis: 'y',
                plugins: {
                    ...chartOptions.plugins,
                    legend: {
                        ...chartOptions.plugins.legend,
                        position: 'top',
                        align: 'end'
                    }
                },
                scales: {
                    x: { beginAtZero: true, grid: { color: '#F8FAFC', drawBorder: false }, ticks: { precision: 0 } },
                    y: { grid: { display: false }, ticks: { font: { weight: '800', size: 10 }, color: '#334155' } }
                }
            }
        });


        // 5. Active Category (Aktif)
        const activeCatCtx = document.getElementById('activeCatChart').getContext('2d');
        const activeCatData = {!! json_encode($aktifCategoryStats) !!};
        new Chart(activeCatCtx, {
            type: 'polarArea',
            data: {
                labels: Object.keys(activeCatData),
                datasets: [{
                    data: Object.values(activeCatData),
                    backgroundColor: palette.slice(0, Object.keys(activeCatData).length).map(c => c + '88'), // 50% opacity
                    borderColor: palette,
                    borderWidth: 2
                }]
            },
            options: {
                ...chartOptions,
                scales: {
                    r: {
                        grid: { color: '#F1F5F9' },
                        ticks: { display: false }
                    }
                },
                plugins: {
                    ...chartOptions.plugins,
                    legend: {
                        ...chartOptions.plugins.legend,
                        position: 'bottom',
                        labels: { boxWidth: 8, font: { size: 9 } }
                    }
                }
            }
        });
    });
</script>
@endpush

<x-layouts.super-admin>
    <x-slot name="header">
        <div class="relative bg-white rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-10 shadow-xl shadow-slate-200/100 border border-slate-100 overflow-hidden group">
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-blue-50/50 rounded-full transition-transform duration-1000 group-hover:scale-110"></div>
            
            <div class="relative z-10 flex flex-col xl:flex-row xl:items-center justify-between gap-6 sm:gap-8">
                <div class="space-y-2 sm:space-y-3">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="px-3 sm:px-4 py-1 sm:py-1.5 rounded-full text-[8px] sm:text-[10px] font-black tracking-[0.2em] uppercase bg-[#03045E] text-white shadow-lg shadow-blue-900/20">
                            Super Admin
                        </div>
                        <div class="h-3 sm:h-4 w-[1px] bg-slate-200"></div>
                        <span class="text-slate-400 text-[8px] sm:text-[10px] font-bold uppercase tracking-widest">VeriCult Core System</span>
                    </div>
                    <h2 class="text-3xl sm:text-5xl font-black text-[#03045E] tracking-tight leading-tight">
                        Dashboard <span class="text-[#0077B6]">Pusat</span>
                    </h2>
                    <p class="text-slate-500 text-sm sm:text-lg font-medium max-w-2xl leading-relaxed">Kelola seluruh ekosistem kebudayaan, pantau performa wilayah, dan kendalikan integritas data.</p>
                </div>

                <!-- <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 bg-slate-50 p-5 sm:p-6 rounded-[2rem] border border-slate-100 shadow-inner relative z-20 self-start xl:self-auto">
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <a href="{{ route('super-admin.users.index') }}" class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-white text-[#03045E] border-2 border-slate-100 rounded-2xl font-black text-[9px] sm:text-[10px] uppercase tracking-widest hover:border-[#0077B6] hover:text-[#0077B6] transition-all shadow-sm active:scale-95 gap-2 group/btn">
                            <svg class="w-4 h-4 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span>Kelola User</span>
                        </a>
                        <a href="{{ route('super-admin.cultural-submissions.index') }}" class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-[#03045E] text-white rounded-2xl font-black text-[9px] sm:text-[10px] uppercase tracking-widest hover:bg-[#0077B6] transition-all shadow-lg shadow-blue-900/20 active:scale-95 gap-2 group/btn">
                            <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            <span>Data Budaya</span>
                        </a>
                    </div>
                </div> -->
            </div>
        </div>
    </x-slot>

    <div class="space-y-6 sm:space-y-10 pb-12">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <!-- Total Users -->
            <div class="group bg-white rounded-[2rem] p-6 sm:p-8 shadow-xl shadow-slate-200/30 border border-white hover:shadow-2xl hover:shadow-blue-900/10 hover:-translate-y-1.5 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-[#03045E] group-hover:bg-[#03045E] group-hover:text-white transition-all duration-500 shadow-inner mb-4 sm:mb-6">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <p class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Entitas</p>
                    <h3 class="text-3xl sm:text-4xl font-black text-[#03045E] tabular-nums tracking-tight">{{ number_format($totalUsers) }}</h3>
                </div>
            </div>

            <!-- Suspended -->
            <div class="group bg-white rounded-[2rem] p-6 sm:p-8 shadow-xl shadow-slate-200/30 border border-white hover:shadow-2xl hover:shadow-red-900/10 hover:-translate-y-1.5 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-red-50 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-rose-500 group-hover:bg-rose-500 group-hover:text-white transition-all duration-500 shadow-inner mb-4 sm:mb-6">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <p class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Ditangguhkan</p>
                    <h3 class="text-3xl sm:text-4xl font-black text-[#03045E] tabular-nums tracking-tight">{{ number_format($suspendedUsersCount) }}</h3>
                </div>
            </div>

            <!-- Pending Approvals -->
            <a href="{{ route('super-admin.users.pengusul-desa') }}" class="group bg-white rounded-[2rem] p-6 sm:p-8 shadow-xl shadow-slate-200/30 border border-white hover:shadow-2xl hover:shadow-amber-900/10 hover:-translate-y-1.5 transition-all duration-500 relative overflow-hidden block">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-amber-50 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition-all duration-500 shadow-inner mb-4 sm:mb-6">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <p class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Persetujuan Desa</p>
                    <h3 class="text-3xl sm:text-4xl font-black text-[#03045E] tabular-nums tracking-tight">{{ number_format($pendingApprovalsCount) }}</h3>
                </div>
            </a>

            <!-- Unverified -->
            <div class="group bg-white rounded-[2rem] p-6 sm:p-8 shadow-xl shadow-slate-200/30 border border-white hover:shadow-2xl hover:shadow-blue-900/10 hover:-translate-y-1.5 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-[#0077B6] group-hover:bg-[#0077B6] group-hover:text-white transition-all duration-500 shadow-inner mb-4 sm:mb-6">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <p class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Blm Verifikasi Email</p>
                    <h3 class="text-3xl sm:text-4xl font-black text-[#03045E] tabular-nums tracking-tight">{{ number_format($unverifiedUsersCount) }}</h3>
                </div>
            </div>
        </div>

        <!-- Role & Submissions Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 sm:gap-8">
            <!-- Role Distribution -->
            <div class="lg:col-span-1 bg-[#03045E] rounded-[2rem] sm:rounded-[2.5rem] p-6 sm:p-8 shadow-2xl shadow-blue-900/20 relative overflow-hidden group">
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white/5 rounded-full blur-3xl transition-transform duration-1000 group-hover:scale-110"></div>
                <div class="relative z-10">
                    <h3 class="text-[11px] sm:text-sm font-black text-white uppercase tracking-[0.2em] mb-6 sm:mb-8 flex items-center gap-3">
                        <span class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-white/10 flex items-center justify-center border border-white/10">
                            <svg class="w-4 h-4 text-[#00B4D8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </span>
                        Distribusi Peran
                    </h3>
                    <div class="space-y-5 sm:space-y-6">
                        @foreach($usersByRole as $role)
                        <div class="group/item">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] sm:text-xs font-bold text-white/70 capitalize tracking-wide">{{ str_replace('-', ' ', $role->name) }}</span>
                                <span class="text-[10px] sm:text-xs font-black text-[#00B4D8]">{{ $role->users_count }}</span>
                            </div>
                            <div class="h-1 sm:h-1.5 w-full bg-white/5 rounded-full overflow-hidden border border-white/5">
                                <div class="h-full bg-gradient-to-r from-[#0077B6] to-[#00B4D8] rounded-full transition-all duration-1000 group-hover/item:shadow-[0_0_10px_#00B4D8]" style="width: {{ $totalUsers > 0 ? ($role->users_count / $totalUsers * 100) : 0 }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Submissions Workflow & Insight -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Status Breakdown -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">
                    <!-- Draft -->
                    <div class="bg-white rounded-[2rem] p-5 sm:p-6 shadow-xl shadow-slate-200/30 border border-white group hover:-translate-y-1 transition-all duration-300">
                        <p class="text-[8px] sm:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Draf ({{ $activeYear }})</p>
                        <div class="flex items-end justify-between">
                            <h3 class="text-2xl sm:text-3xl font-black text-slate-600 tabular-nums">{{ $draftCount }}</h3>
                        </div>
                    </div>
                    <!-- In Review -->
                    <div class="bg-white rounded-[2rem] p-5 sm:p-6 shadow-xl shadow-slate-200/30 border border-white group hover:-translate-y-1 transition-all duration-300">
                        <p class="text-[8px] sm:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Direview ({{ $activeYear }})</p>
                        <div class="flex items-end justify-between">
                            <h3 class="text-2xl sm:text-3xl font-black text-[#4361EE] tabular-nums">{{ $reviewCount }}</h3>
                        </div>
                    </div>
                    <!-- Verified -->
                    <div class="bg-white rounded-[2rem] p-5 sm:p-6 shadow-xl shadow-slate-200/30 border border-white group hover:-translate-y-1 transition-all duration-300">
                        <p class="text-[8px] sm:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Diverifikasi ({{ $activeYear }})</p>
                        <div class="flex items-end justify-between">
                            <h3 class="text-2xl sm:text-3xl font-black text-[#10B981] tabular-nums">{{ $verifiedThisYear }}</h3>
                        </div>
                    </div>
                    <!-- Published -->
                    <div class="bg-white rounded-[2rem] p-5 sm:p-6 shadow-xl shadow-slate-200/30 border border-white group hover:-translate-y-1 transition-all duration-300">
                        <p class="text-[8px] sm:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Dipublikasi ({{ $activeYear }})</p>
                        <div class="flex items-end justify-between">
                            <h3 class="text-2xl sm:text-3xl font-black text-[#03045E] tabular-nums">{{ $publishedThisYear }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Types Breakdown -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <!-- OPK -->
                    <div class="bg-gradient-to-br from-[#4361EE] to-[#3A0CA3] rounded-[2rem] p-5 sm:p-6 shadow-2xl shadow-indigo-900/20 text-white relative overflow-hidden group hover:-translate-y-1 transition-transform">
                        <div class="absolute right-0 top-0 -mt-8 -mr-8 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                        <div class="relative z-10 flex justify-between items-start">
                            <div>
                                <p class="text-[8px] sm:text-[10px] font-black text-indigo-200 uppercase tracking-[0.2em] mb-2">OPK</p>
                                <h3 class="text-3xl sm:text-4xl font-black tabular-nums">{{ $opkCount }}</h3>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0 ml-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                        </div>
                    </div>
                    <!-- Potensi Kebudayaan -->
                    <div class="bg-gradient-to-br from-[#F59E0B] to-[#D97706] rounded-[2rem] p-5 sm:p-6 shadow-2xl shadow-amber-900/20 text-white relative overflow-hidden group hover:-translate-y-1 transition-transform">
                        <div class="absolute right-0 top-0 -mt-8 -mr-8 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                        <div class="relative z-10 flex justify-between items-start">
                            <div>
                                <p class="text-[8px] sm:text-[10px] font-black text-amber-200 uppercase tracking-[0.2em] mb-2">Potensi Budaya</p>
                                <h3 class="text-3xl sm:text-4xl font-black tabular-nums">{{ $potensiCount }}</h3>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0 ml-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        </div>
                    </div>
                    <!-- Cagar Budaya -->
                    <div class="bg-gradient-to-br from-[#F72585] to-[#7209B7] rounded-[2rem] p-5 sm:p-6 shadow-2xl shadow-rose-900/20 text-white relative overflow-hidden group hover:-translate-y-1 transition-transform">
                        <div class="absolute right-0 top-0 -mt-8 -mr-8 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                        <div class="relative z-10 flex justify-between items-start">
                            <div>
                                <p class="text-[8px] sm:text-[10px] font-black text-rose-200 uppercase tracking-[0.2em] mb-2">Cagar Budaya</p>
                                <h3 class="text-3xl sm:text-4xl font-black tabular-nums">{{ $cagarBudayaCount }}</h3>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0 ml-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                            </div>
                        </div>
                    </div>
                    <!-- Laporan Aktif -->
                    <div class="bg-gradient-to-br from-[#10B981] to-[#059669] rounded-[2rem] p-5 sm:p-6 shadow-2xl shadow-emerald-900/20 text-white relative overflow-hidden group hover:-translate-y-1 transition-transform">
                        <div class="absolute right-0 top-0 -mt-8 -mr-8 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                        <div class="relative z-10 flex justify-between items-start">
                            <div>
                                <p class="text-[8px] sm:text-[10px] font-black text-emerald-200 uppercase tracking-[0.2em] mb-2">Laporan Aktif</p>
                                <h3 class="text-3xl sm:text-4xl font-black tabular-nums">{{ $aktifCount }}</h3>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0 ml-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Shortcut -->
                <div class="flex items-center justify-end">
                    <a href="{{ route('super-admin.cultural-submissions.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-[#03045E] rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-[#0077B6] hover:text-white transition-all shadow-xl shadow-blue-900/10 active:scale-95 gap-2 border border-slate-100 group">
                        <span>Lihat Detail Pengajuan</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Visual Analytics Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
            <!-- Trend Chart -->
            <div class="lg:col-span-2 bg-white p-6 sm:p-10 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white">
                <div class="flex items-center justify-between mb-8 sm:mb-10">
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-[#03045E]">Tren Aktivitas</h3>
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Laporan Bulanan {{ $activeYear }}</p>
                    </div>
                </div>
                <div class="h-64 sm:h-80 relative">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <!-- Status Distribution -->
            <div class="bg-white p-6 sm:p-10 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white">
                <div class="flex items-center justify-between mb-8 sm:mb-10">
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-[#03045E]">Status Data</h3>
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Distribusi Seluruh Wilayah</p>
                    </div>
                </div>
                <div class="h-64 sm:h-80 relative">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <!-- Kecamatan Distribution -->
            <div class="lg:col-span-2 bg-white p-6 sm:p-10 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white">
                <div class="flex items-center justify-between mb-8 sm:mb-10">
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-[#03045E]">Distribusi Laporan Kecamatan</h3>
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Produktivitas per Kecamatan ({{ $activeYear }})</p>
                    </div>
                    <a href="{{ route('super-admin.kecamatans.index') }}" class="px-4 sm:px-6 py-2.5 sm:py-3 rounded-2xl bg-slate-50 border-2 border-slate-100 text-[#03045E] font-black text-[9px] sm:text-[10px] tracking-widest uppercase hover:bg-white hover:border-[#0077B6] hover:text-[#0077B6] transition-all whitespace-nowrap">
                        Kelola Wilayah
                    </a>
                </div>
                <div class="h-64 sm:h-80 relative">
                    <canvas id="kecamatanChart"></canvas>
                </div>
            </div>

            <!-- Active Category (Aktif) -->
            <div class="bg-white p-6 sm:p-10 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white">
                <div class="flex items-center justify-between mb-8 sm:mb-10">
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-[#03045E]">Kategori Aktif</h3>
                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Distribusi Laporan Kegiatan</p>
                    </div>
                </div>
                <div class="h-64 sm:h-80 relative">
                    <canvas id="activeCatChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Live Users Monitor -->
        <div x-data="{
                onlineUsers: {{ json_encode($onlineUsers) }},
                fetchOnlineUsers() {
                    fetch('{{ route('super-admin.api.online-users') }}')
                        .then(r => r.json())
                        .then(d => this.onlineUsers = d);
                },
                init() {
                    setInterval(() => this.fetchOnlineUsers(), 5000);
                }
            }" 
            class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white overflow-hidden group">
            
            <div class="p-6 sm:p-10 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                <div>
                    <h3 class="text-lg sm:text-2xl font-black text-[#03045E] flex items-center gap-3">
                        <span class="w-2 sm:w-2.5 h-2 sm:h-2.5 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(16,185,129,0.5)]"></span>
                        Monitor Sesi
                    </h3>
                    <p class="text-slate-400 font-medium text-[10px] sm:text-sm mt-1">Aktivitas user yang sedang mengakses platform.</p>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-max">
                    <thead>
                        <tr class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                            <th class="px-6 sm:px-10 py-4 sm:py-6">Pengguna</th>
                            <th class="px-6 sm:px-10 py-4 sm:py-6">Peran</th>
                            <th class="px-6 sm:px-10 py-4 sm:py-6">Akses Terakhir</th>
                            <th class="px-6 sm:px-10 py-4 sm:py-6 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <template x-for="online in onlineUsers" :key="online.id">
                            <tr class="hover:bg-slate-50/50 transition-colors group/row">
                                <td class="px-6 sm:px-10 py-4 sm:py-6">
                                    <div class="flex items-center gap-3 sm:gap-4">
                                        <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-xl bg-gradient-to-br from-[#03045E] to-[#4361EE] text-white flex items-center justify-center font-black text-xs sm:text-sm shadow-lg shadow-blue-900/10 group-hover/row:scale-110 transition-transform" x-text="online.name.substring(0, 2).toUpperCase()"></div>
                                        <div>
                                            <div class="font-bold text-xs sm:text-sm text-[#03045E]" x-text="online.name"></div>
                                            <div class="text-[9px] sm:text-[10px] text-slate-400 font-medium" x-text="online.email"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 sm:px-10 py-4 sm:py-6">
                                    <span class="text-[8px] sm:text-[9px] font-black uppercase tracking-widest text-slate-500 bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200" x-text="online.role.replace('-', ' ')"></span>
                                </td>
                                <td class="px-6 sm:px-10 py-4 sm:py-6">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] sm:text-xs font-bold text-slate-600" x-text="online.last_activity_human"></span>
                                        <span class="text-[8px] sm:text-[9px] font-black text-slate-300 uppercase tracking-tighter truncate max-w-[200px]" x-text="online.current_url"></span>
                                    </div>
                                </td>
                                <td class="px-6 sm:px-10 py-4 sm:py-6 text-center">
                                    <span class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl text-[8px] sm:text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm">Online</span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 items-start">
            <!-- Recent Users -->
            <div class="lg:col-span-2 bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white overflow-hidden group">
                <div class="p-6 sm:p-10 border-b border-slate-50 flex justify-between items-center bg-white relative overflow-hidden">
                    <div class="absolute top-0 left-0 -mt-6 -ml-6 w-24 h-24 bg-blue-50/50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-1000"></div>
                    <div class="relative z-10">
                        <h3 class="text-lg sm:text-2xl font-black text-[#03045E]">User Baru</h3>
                        <p class="text-slate-400 font-medium text-[10px] sm:text-sm mt-1">Entitas yang baru bergabung.</p>
                    </div>
                    <a href="{{ route('super-admin.users.index') }}" class="relative z-10 px-4 sm:px-6 py-2.5 sm:py-3 rounded-2xl bg-slate-50 border-2 border-slate-100 text-[#03045E] font-black text-[9px] sm:text-[10px] tracking-widest uppercase hover:bg-white hover:border-[#0077B6] hover:text-[#0077B6] transition-all">
                        Semua
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                                <th class="px-6 sm:px-10 py-4 sm:py-5">User</th>
                                <th class="px-6 sm:px-10 py-4 sm:py-5">Peran</th>
                                <th class="px-6 sm:px-10 py-4 sm:py-5 text-right">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($recentUsers as $user)
                            <tr class="hover:bg-slate-50/30 transition-colors group/u">
                                <td class="px-6 sm:px-10 py-4 sm:py-6">
                                    <div class="flex items-center gap-3 sm:gap-4">
                                        <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-xl bg-slate-100 text-[#03045E] flex items-center justify-center font-black text-xs sm:text-sm group-hover/u:bg-[#03045E] group-hover/u:text-white transition-all shadow-inner">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-xs sm:text-sm text-[#03045E]">{{ $user->name }}</div>
                                            <div class="text-[9px] sm:text-[10px] text-slate-400 font-medium">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 sm:px-10 py-4 sm:py-6">
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($user->roles as $role)
                                            <span class="px-2.5 py-1 rounded-lg text-[8px] sm:text-[9px] font-black uppercase tracking-widest border {{ $role->name == 'super-admin' ? 'bg-rose-50 text-rose-700 border-rose-100' : 'bg-sky-50 text-sky-700 border-sky-100' }}">
                                                {{ str_replace('-', ' ', $role->name) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 sm:px-10 py-4 sm:py-6 text-right">
                                    <a href="{{ route('super-admin.users.show', $user) }}" class="p-2 sm:p-2.5 rounded-xl bg-slate-50 text-slate-400 hover:bg-[#03045E] hover:text-white transition-all inline-block shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Audit Logs -->
            <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/30 border border-white overflow-hidden flex flex-col group min-h-[500px]">
                <div class="p-6 sm:p-10 border-b border-slate-50 bg-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-6 -mr-6 w-24 h-24 bg-blue-50/50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-1000"></div>
                    <div class="relative z-10">
                        <h3 class="text-lg sm:text-2xl font-black text-[#03045E]">Log Audit</h3>
                        <p class="text-slate-400 font-medium text-[10px] sm:text-sm mt-1">Integritas sistem.</p>
                    </div>
                </div>
                
                <div class="p-6 sm:p-8 space-y-6 sm:space-y-8 relative flex-1 overflow-y-auto max-h-[600px] custom-scrollbar">
                    <div class="absolute left-[39px] sm:left-[47px] top-10 bottom-10 w-px bg-slate-100"></div>
                    @foreach($auditLogs as $log)
                    <div class="relative flex items-start gap-4 sm:gap-6 group/log">
                        <div class="relative z-10 h-8 w-8 sm:h-10 sm:w-10 rounded-2xl bg-white border-2 border-slate-50 flex items-center justify-center shadow-sm group-hover/log:border-[#03045E] transition-colors">
                            <div class="h-2 w-2 rounded-full {{ $log->action == 'created' ? 'bg-emerald-500' : ($log->action == 'deleted' ? 'bg-rose-500' : 'bg-blue-500') }}"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <p class="text-[10px] sm:text-xs font-black text-[#03045E] truncate">{{ $log->user->name ?? 'SYSTEM' }}</p>
                                <span class="text-[8px] sm:text-[9px] font-black text-slate-300 uppercase tracking-tighter shrink-0">{{ $log->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="p-3 sm:p-4 rounded-2xl bg-slate-50 border border-slate-100 group-hover/log:bg-white group-hover/log:border-slate-200 group-hover/log:shadow-lg transition-all">
                                <p class="text-[10px] sm:text-[11px] font-bold text-slate-500 leading-relaxed">
                                    <span class="text-[#4361EE] uppercase tracking-widest text-[8px] sm:text-[9px]">{{ $log->action }}</span>
                                    <span class="opacity-50">@</span>
                                    <span class="text-[#03045E]">{{ class_basename($log->model_type) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.super-admin>
