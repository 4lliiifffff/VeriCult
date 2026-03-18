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
                        font: { family: 'Inter, sans-serif', weight: 'bold', size: 10 },
                        padding: 20,
                        usePointStyle: true
                    }
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
                    backgroundColor: ['#48CAE4', '#0077B6', '#023E8A', '#03045E', '#CAF0F8', '#90E0EF', '#00B4D8'],
                    borderWidth: 0,
                    hoverOffset: 15,
                }]
            },
            options: {
                ...chartOptions,
                layout: {
                    padding: 10
                }
            }
        });

        // 2. Category Distribution Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($categoryStats)) !!},
                datasets: [{
                    label: 'Jumlah Objek',
                    data: {!! json_encode(array_values($categoryStats)) !!},
                    backgroundColor: '#0077B6',
                    borderRadius: 12,
                    barThickness: 20
                }]
            },
            options: {
                ...chartOptions,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { display: false } },
                    x: { grid: { display: false }, ticks: { font: { size: 9, weight: 'bold' } } }
                }
            }
        });

        // 3. Submission Trend Chart
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyTrend->pluck('month_name')) !!}.map(m => {
                    const months = {
                        'Jan': 'Jan', 'Feb': 'Feb', 'Mar': 'Mar', 'Apr': 'Apr', 'May': 'Mei', 'Jun': 'Jun',
                        'Jul': 'Jul', 'Aug': 'Agu', 'Sep': 'Sep', 'Oct': 'Okt', 'Nov': 'Nov', 'Dec': 'Des'
                    };
                    return months[m] || m;
                }),
                datasets: [{
                    label: 'Pengajuan Baru',
                    data: {!! json_encode($monthlyTrend->pluck('count')) !!},
                    borderColor: '#48CAE4',
                    backgroundColor: 'rgba(72, 202, 228, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 4,
                    pointRadius: 6,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#48CAE4',
                    pointBorderWidth: 3
                }]
            },
            options: {
                ...chartOptions,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                    x: { grid: { display: false } }
                }
            }
        });

        // 4. Yearly Comparison Chart
        const yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
        new Chart(yearlyCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($yearlyComparison->pluck('period_year')) !!}.map(String),
                datasets: [{
                    label: 'Total Pengajuan',
                    data: {!! json_encode($yearlyComparison->pluck('count')) !!},
                    backgroundColor: '#00B4D8',
                    borderRadius: 8,
                    barThickness: 30
                }]
            },
            options: {
                ...chartOptions,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                    x: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
                }
            }
        });
    });
</script>
@endpush

<x-layouts.super-admin>
    <x-slot name="header">
        <div class="relative bg-gradient-to-r from-[#03045E] to-[#0077B6] rounded-[2rem] p-8 shadow-2xl shadow-blue-900/20 mb-8">
            <!-- Background Decorations Clipping Container -->
            <div class="absolute inset-0 overflow-hidden rounded-[2rem] pointer-events-none">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-[#00B4D8]/20 rounded-full blur-2xl"></div>
            </div>
            
            <div class="relative z-10 flex flex-col xl:flex-row xl:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-[0.2em] uppercase bg-white/10 text-white border border-white/20 backdrop-blur-xl">
                            Super Admin
                        </span>
                        <span class="text-white/30 text-xs hidden sm:inline">|</span>
                        <span class="text-white/60 text-[10px] sm:text-xs font-bold uppercase tracking-widest hidden sm:inline">VeriCult Core</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight leading-tight break-words">
                        Dashboard <span class="text-[#00B4D8]">Overview</span>
                    </h2>
                    <p class="text-blue-100/70 text-base sm:text-lg font-medium">Selamat datang kembali di pusat kendali utama sistem.</p>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 bg-white/10 backdrop-blur-xl p-4 rounded-2xl border border-white/20 shadow-inner">
                    <form action="{{ route('super-admin.dashboard') }}" method="GET" class="flex flex-col gap-1 items-start sm:items-end flex-1 sm:flex-none auto-submit">
                        <x-dropdown-select 
                            name="year" 
                            id="year" 
                            label="Filter Periode" 
                            :selected="$activeYear" 
                            :options="collect($availableYears)->mapWithKeys(fn($y) => [$y => 'Tahun ' . $y])->toArray()" 
                        />
                    </form>
                    <div class="hidden sm:block h-10 w-px bg-white/20 mx-2"></div>
                    <div class="bg-white/5 sm:bg-transparent p-3 sm:p-0 rounded-xl">
                        <p class="text-[10px] font-black text-[#00B4D8] uppercase tracking-[0.2em] mb-0.5">Status Sistem</p>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-white font-black text-sm">AKTIF & BERJALAN</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Top Stats & Insights Section -->
    <div class="space-y-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Users Card -->
            <div class="group bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/40 border border-white hover:shadow-2xl hover:shadow-blue-900/10 hover:-translate-y-1.5 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-gradient-to-br from-[#0077B6]/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-[#0077B6] group-hover:bg-[#0077B6] group-hover:text-white transition-all duration-500 shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="text-emerald-500 font-black text-[10px] bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-100/50 flex items-center gap-1.5 animate-pulse">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            {{ $newUsersThisMonth }} Baru
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Entitas</p>
                        <h3 class="text-4xl font-black text-[#03045E] tabular-nums tracking-tight">{{ number_format($totalUsers) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Suspended Card -->
            <div class="group bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/40 border border-white hover:shadow-2xl hover:shadow-red-900/10 hover:-translate-y-1.5 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-gradient-to-br from-red-500/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-red-50 flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition-all duration-500 shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                        </div>
                        @if($suspendedUsersCount > 0)
                        <div class="text-red-500 font-black text-[10px] bg-red-50 px-3 py-1.5 rounded-full border border-red-100/50">Butuh Review</div>
                        @endif
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Ditangguhkan</p>
                        <h3 class="text-4xl font-black text-[#03045E] tabular-nums tracking-tight">{{ number_format($suspendedUsersCount) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Pending Card -->
            <a href="{{ route('super-admin.users.pengusul-desa') }}" class="group bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/40 border border-white hover:shadow-2xl hover:shadow-amber-900/10 hover:-translate-y-1.5 transition-all duration-500 relative overflow-hidden block">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-gradient-to-br from-amber-500/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl {{ $pendingApprovalsCount > 0 ? 'bg-amber-100 text-amber-600' : 'bg-slate-50 text-slate-400' }} flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-all duration-500 shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        @if($pendingApprovalsCount > 0)
                        <div class="flex items-center gap-1 text-amber-600 animate-bounce">
                           <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"></path></svg>
                        </div>
                        @endif
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Persetujuan Desa</p>
                        <h3 class="text-4xl font-black text-[#03045E] tabular-nums tracking-tight">{{ number_format($pendingApprovalsCount) }}</h3>
                    </div>
                </div>
            </a>

            <!-- Unverified Card -->
            <div class="group bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/40 border border-white hover:shadow-2xl hover:shadow-indigo-900/10 hover:-translate-y-1.5 transition-all duration-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-gradient-to-br from-indigo-500/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
                <div class="relative z-10 flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-500 shadow-inner">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Belum Terverifikasi</p>
                        <h3 class="text-4xl font-black text-[#03045E] tabular-nums tracking-tight">{{ number_format($unverifiedUsersCount) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Left: Role Distribution (Width 1/4) -->
            <div class="lg:col-span-1 bg-[#03045E] rounded-[2.5rem] p-8 shadow-2xl shadow-[#03045E]/30 border border-white/10 relative overflow-hidden group">
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white/5 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-[#00B4D8] border border-white/10 backdrop-blur-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="text-sm font-black text-white uppercase tracking-[0.2em]">Distribusi Peran</h3>
                    </div>
                    <div class="space-y-6">
                        @foreach($usersByRole as $role)
                        <div class="group/item">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold text-white/70 capitalize tracking-wide">{{ str_replace('-', ' ', $role->name) }}</span>
                                <span class="text-xs font-black text-[#00B4D8]">{{ $role->users_count }}</span>
                            </div>
                            <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden border border-white/5">
                                <div class="h-full bg-gradient-to-r from-[#0077B6] to-[#00B4D8] rounded-full transition-all duration-1000 group-hover/item:shadow-[0_0_10px_#00B4D8]" style="width: {{ $totalUsers > 0 ? ($role->users_count / $totalUsers * 100) : 0 }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right: Submissions Quick Insight (Width 3/4) -->
            <div class="lg:col-span-3 grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Total Submissions -->
                <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/40 border border-white relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#03045E]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 relative z-10">Total Pengajuan ({{ $activeYear }})</p>
                    <div class="flex items-end justify-between relative z-10">
                        <h3 class="text-4xl font-black text-[#03045E] tabular-nums">{{ $totalSubmissionsThisYear }}</h3>
                        <div class="p-3 bg-blue-50 rounded-2xl text-[#03045E] group-hover:bg-[#03045E] group-hover:text-white transition-colors duration-300 shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Verified Submissions -->
                <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/40 border border-white relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#0077B6]/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 relative z-10">Telah Diverifikasi ({{ $activeYear }})</p>
                    <div class="flex items-end justify-between relative z-10">
                        <h3 class="text-4xl font-black text-[#0077B6] tabular-nums">{{ $verifiedThisYear }}</h3>
                        <div class="p-3 bg-sky-50 rounded-2xl text-[#0077B6] group-hover:bg-[#0077B6] group-hover:text-white transition-colors duration-300 shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Published Submissions -->
                <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/40 border border-white relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 relative z-10">Telah Dipublikasi ({{ $activeYear }})</p>
                    <div class="flex items-end justify-between relative z-10">
                        <h3 class="text-4xl font-black text-emerald-500 tabular-nums">{{ $publishedThisYear }}</h3>
                        <div class="p-3 bg-emerald-50 rounded-2xl text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300 shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553 2.276A1 1 0 0120 13.17V19a2 2 0 01-2 2H6a2 2 0 01-2-2V13.17a1 1 0 01.447-.894L9 10m0 0l3-3m0 0l3 3m-3-3v12"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Trends Section -->
        <div class="space-y-12 py-4">
            <!-- Section Title -->
            <div class="flex items-center gap-4">
                <div class="h-px flex-1 bg-slate-100"></div>
                <h4 class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Statistik & Tren Sistem</h4>
                <div class="h-px flex-1 bg-slate-100"></div>
            </div>

            <!-- Group 1: Trend & Status -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Trend Chart (2/3) -->
                <div class="lg:col-span-2 bg-white p-8 sm:p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-white">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-lg font-black text-[#03045E]">Tren Pengajuan</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Aktivitas Bulanan Tahun {{ $activeYear }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-[#0077B6]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                        </div>
                    </div>
                    <div class="h-80 relative">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>

                <!-- Status Distribution (1/3) -->
                <div class="bg-white p-8 sm:p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-white">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-lg font-black text-[#03045E]">Status Layanan</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Distribusi Progres</p>
                        </div>
                    </div>
                    <div class="h-80 relative">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Group 2: Categories & Comparison -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Category Distribution -->
                <div class="bg-white p-8 sm:p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-white">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-lg font-black text-[#03045E]">Populasi Kategori</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Berdasarkan Jenis Objek Budaya</p>
                        </div>
                    </div>
                    <div class="h-72 relative">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

                <!-- Yearly Comparison -->
                <div class="bg-white p-8 sm:p-10 rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-white">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-lg font-black text-[#03045E]">Komparasi Tahunan</h3>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Pertumbuhan Data Antar Tahun</p>
                        </div>
                    </div>
                    <div class="h-72 relative">
                        <canvas id="yearlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Monitoring Section -->
        <div x-data="{
                onlineUsers: {{ json_encode($onlineUsers) }},
                loading: false,
                
                async fetchOnlineUsers() {
                    try {
                        const response = await fetch('{{ route('super-admin.api.online-users') }}');
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        const data = await response.json();
                        if (Array.isArray(data)) {
                            this.onlineUsers = data;
                        }
                    } catch (error) {
                        console.error('Gagal mengambil data pengguna online:', error);
                    }
                },
                
                init() {
                    setInterval(() => {
                        this.fetchOnlineUsers();
                    }, 5000);
                }
            }" 
            class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-white overflow-hidden relative group">
            
            <div class="p-8 sm:p-10 border-b border-slate-50 relative z-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <span class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_15px_rgba(16,185,129,0.5)]"></span>
                            <h3 class="text-xl sm:text-2xl font-black text-[#03045E]">Pemantauan Langsung</h3>
                        </div>
                        <p class="text-slate-400 font-medium text-xs sm:text-sm">Pantau aktivitas pengguna secara real-time di seluruh platform.</p>
                    </div>
                    <div class="flex items-center gap-3 bg-slate-50 px-5 py-2.5 rounded-2xl border border-slate-100 w-fit">
                        <svg class="w-4 h-4 text-[#0077B6] animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Pembaruan Otomatis: <span class="text-[#03045E]">5d</span></span>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto relative z-10">
                <table class="w-full text-left border-collapse min-w-max">
                    <thead>
                         <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/30 border-b border-slate-100">
                            <th class="px-8 py-5">Identitas User</th>
                            <th class="px-8 py-5">Peran</th>
                            <th class="px-8 py-5">Lokasi & Metode</th>
                            <th class="px-8 py-5 text-center">Aktivitas Terakhir</th>
                            <th class="px-8 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <template x-if="onlineUsers.length > 0">
                            <template x-for="online in onlineUsers" :key="online.id">
                                <tr class="hover:bg-slate-50/50 transition-all duration-300 group/row">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="h-11 w-11 rounded-[14px] bg-gradient-to-br from-[#03045E] to-[#0077B6] text-white flex items-center justify-center font-black text-sm shadow-lg shadow-blue-900/10 group-hover/row:scale-110 transition-transform duration-300" x-text="online.name.substring(0, 2).toUpperCase()"></div>
                                            <div>
                                                <div class="font-bold text-sm text-[#03045E] group-hover/row:text-[#0077B6] transition-colors" x-text="online.name"></div>
                                                <div class="text-[10px] text-slate-400 font-medium" x-text="'ID: #' + online.id"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-500 bg-slate-100/50 px-3 py-1.5 rounded-xl border border-slate-200" x-text="online.role.replace('-', ' ')"></span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col gap-1.5 max-w-xs xl:max-w-md">
                                            <div class="flex items-center gap-2">
                                                <span class="text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded bg-blue-50 text-[#0077B6] border border-blue-100" x-text="online.method"></span>
                                                <span class="font-mono text-[11px] text-slate-500 truncate" x-text="online.current_url" :title="online.current_url"></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-slate-600" x-text="online.last_activity_human"></span>
                                            <span class="text-[9px] font-black text-slate-300 uppercase tracking-tighter">Real-time update</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <span x-show="online.status === 'Online'" class="inline-flex items-center px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm">
                                            Aktif
                                        </span>
                                        <span x-show="online.status !== 'Online'" class="inline-flex items-center px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100 shadow-sm">
                                            Tidak Aktif
                                        </span>
                                    </td>
                                </tr>
                            </template>
                        </template>
                        <template x-if="onlineUsers.length === 0">
                            <tr>
                                <td colspan="5" class="px-8 py-24 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-5">
                                        <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 shadow-inner">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-slate-400 font-black text-sm tracking-widest uppercase">Sistem sedang tenang</p>
                                            <p class="text-slate-300 text-xs mt-1">Tidak ada aktivitas pengguna yang terdeteksi saat ini.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <!-- Recent Users Table (Width: 2/3) -->
            <div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-white overflow-hidden flex flex-col h-full group">
                <div class="p-8 sm:p-10 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-white relative overflow-hidden">
                    <div class="absolute top-0 left-0 -mt-6 -ml-6 w-24 h-24 bg-blue-50/50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-1000"></div>
                    <div class="relative z-10">
                        <h3 class="text-xl sm:text-2xl font-black text-[#03045E]">Pengguna Terbaru</h3>
                        <p class="text-slate-400 font-medium text-xs sm:text-sm mt-1">Entitas yang baru saja terdaftar di sistem.</p>
                    </div>
                    <a href="{{ route('super-admin.users.index') }}" class="relative z-10 w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3 rounded-2xl bg-slate-50 border-2 border-slate-100 text-[#03045E] font-black text-[10px] tracking-widest uppercase hover:bg-white hover:border-[#0077B6] hover:text-[#0077B6] transition-all group/btn">
                        Semua Pengguna
                        <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-max">
                        <thead>
                            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/30 border-b border-slate-100">
                                <th class="px-8 py-5">Profil User</th>
                                <th class="px-8 py-5">Peran</th>
                                <th class="px-8 py-5 text-center">Status Akun</th>
                                <th class="px-8 py-5 text-right">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($recentUsers as $user)
                            <tr class="hover:bg-slate-50/30 transition-all duration-300 group/u">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="h-11 w-11 rounded-[14px] bg-gradient-to-br from-[#0077B6] to-[#00B4D8] text-white flex items-center justify-center font-black text-sm shadow-lg shadow-blue-900/10 group-hover/u:scale-110 transition-all duration-300">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-sm text-[#03045E] group-hover/u:text-[#0077B6] transition-colors line-clamp-1">{{ $user->name }}</div>
                                            <div class="text-[10px] text-slate-400 font-medium">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-wrap gap-1.5">
                                        @forelse($user->roles as $role)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border shadow-sm
                                                {{ $role->name == 'super-admin' ? 'bg-purple-50 text-purple-700 border-purple-100' : 
                                                ($role->name == 'validator' ? 'bg-indigo-50 text-indigo-700 border-indigo-100' : 
                                                'bg-sky-50 text-sky-700 border-sky-100') }}">
                                                {{ str_replace('-', ' ', $role->name) }}
                                            </span>
                                        @empty
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest bg-slate-50 text-slate-500 border border-slate-100 italic">User</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    @if($user->is_suspended)
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest bg-red-50 text-red-600 border border-red-100 shadow-sm">Ditangguhkan</span>
                                    @elseif(is_null($user->email_verified_at))
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100 shadow-sm">Blm. Terverifikasi</span>
                                    @else
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm">Aktif</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-right">
                                    @if(!$user->hasRole('super-admin'))
                                        <div class="flex items-center justify-end gap-3">
                                            @if($user->is_suspended)
                                                <form action="{{ route('super-admin.users.unsuspend', $user) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="p-2.5 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all shadow-sm hover:shadow-emerald-200">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('super-admin.users.suspend', $user) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="p-2.5 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm hover:shadow-red-200">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('super-admin.users.show', $user) }}" class="p-2.5 rounded-xl bg-blue-50 text-[#0077B6] hover:bg-[#0077B6] hover:text-white transition-all shadow-sm hover:shadow-blue-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                        </div>
                                    @else
                                        <div class="flex items-center justify-end gap-2 text-[10px] text-slate-300 font-black uppercase tracking-widest bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            Terkunci
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-4">
                                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-200">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <p class="text-slate-300 font-bold italic">Belum ada pengguna baru.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Audit Trail (Width: 1/3) -->
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-white overflow-hidden flex flex-col h-full group">
                <div class="p-8 sm:p-10 border-b border-slate-50 bg-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-6 -mr-6 w-24 h-24 bg-blue-50/50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-1000"></div>
                    <div class="relative z-10">
                        <h3 class="text-xl sm:text-2xl font-black text-[#03045E]">Riwayat Aktivitas</h3>
                        <p class="text-slate-400 font-medium text-xs sm:text-sm mt-1">Jejak aktivitas sistem terenkripsi.</p>
                    </div>
                </div>
                
                <div class="overflow-y-auto max-h-[700px] flex-1 scrollbar-thin scrollbar-thumb-slate-200 scrollbar-track-transparent">
                    <div class="p-8 space-y-0 relative">
                        <!-- Vertical Line -->
                        <div class="absolute left-[39px] top-10 bottom-10 w-0.5 bg-slate-100"></div>

                        @forelse($auditLogs as $log)
                        <div class="relative flex items-start gap-6 pb-10 last:pb-0 group/log">
                            <!-- Indicator Dot -->
                            <div class="relative z-10 mt-1.5 flex-shrink-0">
                                <div class="h-6 w-6 rounded-full border-4 border-white shadow-md transition-transform duration-300 group-hover/log:scale-125
                                    {{ $log->action == 'created' ? 'bg-emerald-500' : 
                                       ($log->action == 'deleted' || $log->action == 'suspended_user' ? 'bg-red-500' : 
                                       'bg-[#0077B6]') }}">
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-2">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-black text-[#03045E] truncate">{{ $log->user->name ?? 'SYSTEM EVENT' }}</p>
                                        <span class="text-[9px] font-black text-[#0077B6] bg-blue-50 px-2 py-0.5 rounded border border-blue-100/50 uppercase tracking-wider">
                                            {{ class_basename($log->model_type) }}
                                        </span>
                                    </div>
                                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-tighter">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="p-4 rounded-2xl bg-slate-50/50 border border-slate-100 group-hover/log:border-[#0077B6]/30 group-hover/log:bg-white group-hover/log:shadow-lg group-hover/log:shadow-slate-200/30 transition-all duration-300">
                                    <p class="text-xs font-bold text-slate-600 leading-relaxed">
                                        <span class="text-[#03045E] opacity-70">Telah</span> 
                                        <span class="text-[#0077B6] font-black uppercase tracking-wide mx-0.5">
                                            {{ match($log->action) {
                                                'created' => 'Dibuat',
                                                'updated' => 'Diperbarui',
                                                'deleted' => 'Dihapus',
                                                'suspended_user' => 'User Ditangguhkan',
                                                'unsuspended_user' => 'User Diaktifkan',
                                                'approved_village' => 'Desa Disetujui',
                                                'rejected_village' => 'Desa Ditolak',
                                                default => ucfirst(str_replace(['_', '-'], ' ', $log->action))
                                            } }}
                                        </span>
                                        <span class="text-[#03045E] opacity-70">pada entitas dengan ID</span>
                                        <span class="text-slate-400 font-black ml-1">#{{ $log->model_id }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="py-20 text-center space-y-5">
                            <div class="w-16 h-16 bg-slate-50 rounded-3xl mx-auto flex items-center justify-center text-slate-200 shadow-inner">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-slate-300 font-black text-xs uppercase tracking-widest">Belum ada aktivitas</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                
                <div class="p-8 bg-slate-50/50 border-t border-slate-100 text-center">
                    <a href="{{ route('super-admin.audit-logs.index') }}" class="group/btn inline-flex items-center gap-2 text-[10px] font-black text-[#0077B6] uppercase tracking-[0.2em] hover:text-[#03045E] transition-all">
                        Eksplorasi Log Lengkap
                        <svg class="w-3.5 h-3.5 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.super-admin>
