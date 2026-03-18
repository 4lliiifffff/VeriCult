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
                        'draft': 'Draft',
                        'submitted': 'Terkirim',
                        'administrative_review': 'Review Admin',
                        'field_verification': 'Verifikasi Lapangan',
                        'verified': 'Terverifikasi',
                        'published': 'Terpublikasi',
                        'rejected': 'Ditolak',
                        'revision': 'Butuh Revisi'
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

    <div class="space-y-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="group bg-white rounded-[2rem] p-6 sm:p-8 shadow-xl shadow-slate-200/50 border border-white hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-gradient-to-br from-[#0077B6]/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total Entitas</p>
                        <h3 class="text-3xl sm:text-4xl font-black text-[#03045E] tabular-nums">{{ $totalUsers }}</h3>
                        <div class="mt-4 flex items-center gap-2 text-emerald-500 font-bold text-xs bg-emerald-50 w-fit px-2 py-1 rounded-lg">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                            <span>{{ $newUsersThisMonth }} Baru</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-[#0077B6] group-hover:bg-[#0077B6] group-hover:text-white transition-colors duration-300">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Suspended Users -->
            <div class="group bg-white rounded-[2rem] p-6 sm:p-8 shadow-xl shadow-slate-200/50 border border-white hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-gradient-to-br from-red-500/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Ditangguhkan</p>
                        <h3 class="text-3xl sm:text-4xl font-black text-[#03045E] tabular-nums">{{ $suspendedUsersCount }}</h3>
                        <p class="mt-4 text-[10px] text-slate-400 font-bold uppercase tracking-widest italic">Review dibutuhkan</p>
                    </div>
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-red-50 flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition-colors duration-300 shadow-inner">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Pending Approvals -->
            <a href="{{ route('super-admin.users.pengusul-desa') }}" class="group bg-white rounded-[2rem] p-6 sm:p-8 shadow-xl shadow-slate-200/50 border border-white hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-gradient-to-br from-amber-500/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Persetujuan Desa</p>
                        <h3 class="text-3xl sm:text-4xl font-black text-[#03045E] tabular-nums">{{ $pendingApprovalsCount }}</h3>
                        @if($pendingApprovalsCount > 0)
                            <div class="mt-4 flex items-center gap-2 text-amber-600 font-bold text-[10px] bg-amber-50 w-fit px-2 py-1 rounded-lg animate-pulse">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                                </span>
                                <span>Butuh Approval</span>
                            </div>
                        @else
                            <p class="mt-4 text-[10px] text-slate-400 font-bold uppercase tracking-widest italic">Semua Beres</p>
                        @endif
                    </div>
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl {{ $pendingApprovalsCount > 0 ? 'bg-amber-100 text-amber-600' : 'bg-slate-50 text-slate-400' }} flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300 shadow-inner">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                </div>
            </a>

            <!-- Unverified Users -->
            <div class="group bg-white rounded-[2rem] p-6 sm:p-8 shadow-xl shadow-slate-200/50 border border-white hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-gradient-to-br from-indigo-500/10 to-transparent rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Belum Terverifikasi</p>
                        <h3 class="text-3xl sm:text-4xl font-black text-[#03045E] tabular-nums">{{ $unverifiedUsersCount }}</h3>
                        <p class="mt-4 text-[10px] text-slate-400 font-bold uppercase tracking-widest italic">Email pending</p>
                    </div>
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-500 group-hover:text-white transition-colors duration-300 shadow-inner">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Role Distribution Summary -->
            <div class="group bg-[#03045E] rounded-[2rem] p-6 sm:p-8 shadow-xl shadow-[#03045E]/30 border border-white/10 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10 text-white">
                    <p class="text-xs font-black text-white/40 uppercase tracking-[0.2em] mb-4">Distribusi Peran</p>
                    <div class="space-y-3 sm:space-y-4">
                        @foreach($usersByRole as $role)
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] sm:text-xs font-bold text-white/70 capitalize">{{ str_replace('-', ' ', $role->name) }}</span>
                            <span class="text-xs sm:text-sm font-black text-[#00B4D8]">{{ $role->users_count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Submission Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-[#03045E] rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 shadow-xl shadow-blue-900/10 relative overflow-hidden text-white border border-[#03045E]">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                <p class="text-[9px] sm:text-[10px] font-black text-white/60 uppercase tracking-widest mb-1 z-10 relative">Total Pengajuan ({{ $activeYear }})</p>
                <h3 class="text-3xl sm:text-4xl font-black z-10 relative group hover:scale-105 transition-transform origin-left">{{ $totalSubmissionsThisYear }}</h3>
            </div>
            <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 shadow-xl shadow-slate-200/50 border border-slate-100 relative overflow-hidden">
                 <p class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Telah Diverifikasi ({{ $activeYear }})</p>
                 <h3 class="text-3xl sm:text-4xl font-black text-[#0077B6] group hover:scale-105 transition-transform origin-left">{{ $verifiedThisYear }}</h3>
            </div>
            <div class="bg-white rounded-[1.5rem] sm:rounded-[2rem] p-5 sm:p-6 shadow-xl shadow-slate-200/50 border border-slate-100 relative overflow-hidden">
                 <p class="text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Telah Dipublikasi ({{ $activeYear }})</p>
                 <h3 class="text-3xl sm:text-4xl font-black text-emerald-500 group hover:scale-105 transition-transform origin-left">{{ $publishedThisYear }}</h3>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Status Distribution -->
            <div class="bg-white p-6 sm:p-8 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white relative overflow-hidden">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Distribusi Status Layanan</h3>
                </div>
                <div class="h-64 relative">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <!-- Category Distribution -->
            <div class="bg-white p-6 sm:p-8 rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white lg:col-span-2 relative overflow-hidden">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Populasi Kategori Budaya</h3>
                </div>
                <div class="h-64 relative">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Trend Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Trend Chart -->
            <div class="bg-white p-6 sm:p-10 rounded-[2rem] sm:rounded-[3rem] shadow-xl shadow-slate-200/50 border border-white">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Tren Pengajuan Bulanan (Tahun {{ $activeYear }})</h3>
                </div>
                <div class="h-80 relative">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <!-- Yearly Comparison Chart -->
            <div class="bg-white p-6 sm:p-10 rounded-[2rem] sm:rounded-[3rem] shadow-xl shadow-slate-200/50 border border-white">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Perbandingan Pengajuan Tahunan</h3>
                </div>
                <div class="h-80 relative">
                    <canvas id="yearlyChart"></canvas>
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
                        this.onlineUsers = await response.json();
                    } catch (error) {
                        console.error('Failed to fetch online users:', error);
                    }
                },
                
                init() {
                    setInterval(() => {
                        this.fetchOnlineUsers();
                    }, 5000);
                }
            }" 
            class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden relative group">
            
            <div class="p-6 sm:p-10 border-b border-slate-50 relative z-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-black text-[#03045E] flex items-center gap-3">
                            <span class="w-2 h-6 sm:w-2.5 sm:h-8 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_15px_rgba(16,185,129,0.5)]"></span>
                            Pemantauan Langsung
                        </h3>
                        <p class="text-slate-400 font-medium text-xs sm:text-sm mt-1">Pantau aktivitas pengguna secara real-time di seluruh platform.</p>
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
                         <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                            <th class="px-6 sm:px-8 py-4 sm:py-5">Identitas User</th>
                            <th class="px-6 sm:px-8 py-4 sm:py-5">Peran</th>
                            <th class="px-6 sm:px-8 py-4 sm:py-5">Lokasi Halaman</th>
                            <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Aktivitas Terakhir</th>
                            <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <template x-if="onlineUsers.length > 0">
                            <template x-for="online in onlineUsers" :key="online.id">
                                <tr class="hover:bg-slate-50/50 transition-all duration-200 group/row">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-[#03045E] to-[#0077B6] text-white flex items-center justify-center font-black text-xs shadow-lg shadow-blue-900/10 group-hover/row:scale-110 transition-transform" x-text="online.name.substring(0, 2).toUpperCase()"></div>
                                            <div class="font-bold text-sm text-[#03045E]" x-text="online.name"></div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 bg-slate-100/50 px-3 py-1 rounded-full border border-slate-200" x-text="online.role.replace('-', ' ')"></span>
                                    </td>
                                    <td class="px-8 py-5 text-xs">
                                        <div class="flex flex-col gap-1 max-w-xs xl:max-w-md">
                                            <span class="font-mono text-slate-500 truncate group-hover/row:text-[#0077B6]" x-text="online.current_url" :title="online.current_url"></span>
                                            <span class="text-[10px] text-slate-300 font-black uppercase tracking-widest" x-text="online.method"></span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-center text-xs font-bold text-slate-400">
                                        <span x-text="online.last_activity_human"></span>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <span x-show="online.status === 'Online'" class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">
                                            Aktif
                                        </span>
                                        <span x-show="online.status !== 'Online'" class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100">
                                            Tidak Aktif
                                        </span>
                                    </td>
                                </tr>
                            </template>
                        </template>
                        <template x-if="onlineUsers.length === 0">
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-4">
                                        <div class="w-16 h-16 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-200">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-slate-400 font-bold tracking-wide">Sistem sedang tenang.</p>
                                            <p class="text-slate-300 text-xs mt-1">Tidak ada pengguna aktif dalam 5 menit terakhir.</p>
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
            <div class="lg:col-span-2 bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden">
                <div class="p-6 sm:p-10 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-white">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-black text-[#03045E]">Pengguna Terbaru</h3>
                        <p class="text-slate-400 font-medium text-xs sm:text-sm mt-1">Entitas yang baru saja terdaftar di sistem.</p>
                    </div>
                    <a href="{{ route('super-admin.users.index') }}" class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3 rounded-2xl bg-slate-50 border-2 border-slate-100 text-[#03045E] font-black text-xs tracking-widest uppercase hover:bg-white hover:border-[#0077B6] hover:text-[#0077B6] transition-all group">
                        Daftar Lengkap
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-max">
                        <thead>
                            <tr class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] bg-slate-50/50 border-b border-slate-100">
                                <th class="px-6 sm:px-8 py-4 sm:py-5">Profil User</th>
                                <th class="px-6 sm:px-8 py-4 sm:py-5">Peran</th>
                                <th class="px-6 sm:px-8 py-4 sm:py-5 text-center">Status Akun</th>
                                <th class="px-6 sm:px-8 py-4 sm:py-5 text-right">Opsi Cepat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($recentUsers as $user)
                            <tr class="hover:bg-slate-50/30 transition-all duration-200 group/u">
                                <td class="px-6 sm:px-8 py-4 sm:py-5">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-[12px] sm:rounded-[14px] bg-gradient-to-br from-[#0077B6] to-[#00B4D8] text-white flex items-center justify-center font-black text-[10px] sm:text-sm shadow-md group-hover/u:scale-110 transition-transform">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <div class="ml-3 sm:ml-4">
                                            <div class="font-bold text-xs sm:text-sm text-[#03045E] group-hover/u:text-[#0077B6] transition-colors line-clamp-1">{{ $user->name }}</div>
                                            <div class="text-[10px] sm:text-[11px] text-slate-400 font-medium">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    @forelse($user->roles as $role)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border
                                            {{ $role->name == 'super-admin' ? 'bg-purple-50 text-purple-700 border-purple-100' : 
                                            ($role->name == 'validator' ? 'bg-indigo-50 text-indigo-700 border-indigo-100' : 
                                            'bg-sky-50 text-sky-700 border-sky-100') }}">
                                            {{ str_replace('-', ' ', $role->name) }}
                                        </span>
                                    @empty
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-slate-50 text-slate-500 border border-slate-100 italic">User</span>
                                    @endforelse
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @if($user->is_suspended)
                                        <span class="inline-flex items-center px-4 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-red-50 text-red-600 border border-red-100">Ditangguhkan</span>
                                    @elseif(is_null($user->email_verified_at))
                                        <span class="inline-flex items-center px-4 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100">Blm. Terverifikasi</span>
                                    @else
                                        <span class="inline-flex items-center px-4 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">Aktif</span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    @if(!$user->hasRole('super-admin'))
                                        <div class="flex items-center justify-end gap-2">
                                            @if($user->is_suspended)
                                                <form action="{{ route('super-admin.users.unsuspend', $user) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="p-2 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('super-admin.users.suspend', $user) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="p-2 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-[10px] text-slate-300 font-bold uppercase tracking-widest flex items-center gap-1 justify-end">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            Terkunci
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center text-slate-400 font-bold italic">Belum ada pengguna baru.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Audit Trail (Width: 1/3) -->
            <div class="bg-white rounded-[2rem] sm:rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-white overflow-hidden flex flex-col h-full group">
                <div class="p-6 sm:p-8 border-b border-slate-50 bg-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-20 h-20 bg-blue-50/50 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-black text-[#03045E]">Riwayat Aktivitas</h3>
                        <p class="text-slate-400 font-medium text-[11px] sm:text-xs mt-1">Jejak aktivitas sistem terenkripsi.</p>
                    </div>
                </div>
                <div class="overflow-y-auto max-h-[600px] flex-1 scrollbar-thin scrollbar-thumb-slate-200 scrollbar-track-transparent">
                    <div class="p-4 space-y-4">
                        @forelse($auditLogs as $log)
                        <div class="group/log p-5 rounded-2xl bg-white border border-slate-100 hover:border-[#0077B6]/30 hover:shadow-lg hover:shadow-slate-200/50 transition-all duration-300">
                            <div class="flex items-start gap-4">
                                <div class="mt-1 flex-shrink-0 relative">
                                    <div class="h-3 w-3 rounded-full ring-4 ring-white shadow-sm
                                        {{ $log->action == 'created' ? 'bg-emerald-400' : 
                                           ($log->action == 'deleted' || $log->action == 'suspended_user' ? 'bg-red-400' : 
                                           'bg-[#0077B6]') }}">
                                    </div>
                                    <div class="absolute inset-0 rounded-full animate-ping opacity-20
                                        {{ $log->action == 'created' ? 'bg-emerald-400' : 
                                           ($log->action == 'deleted' || $log->action == 'suspended_user' ? 'bg-red-400' : 
                                           'bg-[#0077B6]') }}">
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-[11px] font-black text-[#03045E] truncate pr-2">{{ $log->user->name ?? 'SYSTEM EVENT' }}</p>
                                        <span class="flex-shrink-0 text-[9px] font-black text-slate-400 uppercase tracking-tighter">{{ $log->created_at->diffForHumans(null, true, true) }}</span>
                                    </div>
                                    <p class="text-xs font-bold text-slate-600 leading-tight">
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
                                    </p>
                                    <div class="mt-3 flex items-center justify-between">
                                        <span class="text-[9px] font-black text-[#0077B6] bg-blue-50 px-2 py-0.5 rounded uppercase tracking-wider">
                                            {{ class_basename($log->model_type) }}
                                        </span>
                                        <span class="text-[10px] font-bold text-slate-300">#{{ $log->model_id }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-12 text-center space-y-4">
                            <div class="w-12 h-12 bg-slate-50 rounded-2xl mx-auto flex items-center justify-center text-slate-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-slate-300 font-bold text-xs uppercase tracking-widest">Aktivitas Nihil</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                <div class="p-6 bg-slate-50 border-t border-slate-100 text-center">
                    <a href="{{ route('super-admin.audit-logs.index') }}" class="text-[10px] font-black text-[#0077B6] uppercase tracking-[0.2em] hover:text-[#03045E] transition-colors">
                        Jelajahi Log &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.super-admin>
