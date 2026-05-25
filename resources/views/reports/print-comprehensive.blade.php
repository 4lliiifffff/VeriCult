<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Komprehensif Kebudayaan - {{ ($activeYear && $activeYear !== 'all') ? 'Tahun ' . $activeYear : 'Semua Periode' }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    <style>
        :root {
            --primary: #03045E;
            --secondary: #0077B6;
            --accent: #00B4D8;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-light: #e2e8f0;
            --bg-light: #f8fafc;
        }
        body { 
            font-family: 'Outfit', sans-serif; 
            color: var(--text-dark); 
            line-height: 1.6; 
            padding: 40px; 
            font-size: 13px; 
            background: #fff;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .header { 
            text-align: center; 
            border-bottom: 3px double var(--primary); 
            padding-bottom: 20px; 
            margin-bottom: 35px; 
        }
        .header h1 { 
            margin: 0; 
            font-size: 26px; 
            font-weight: 800;
            text-transform: uppercase; 
            color: var(--primary); 
            letter-spacing: 0.05em;
        }
        .header p { 
            margin: 8px 0 0; 
            color: var(--text-muted); 
            font-size: 14px; 
            font-weight: 500;
        }
        
        .section-title { 
            font-size: 20px; 
            font-weight: 800; 
            color: var(--secondary); 
            border-bottom: 2px solid var(--secondary); 
            padding-bottom: 8px; 
            margin-top: 45px; 
            margin-bottom: 20px; 
            text-transform: uppercase; 
            letter-spacing: 0.05em;
        }
        .analysis-box { 
            background-color: var(--bg-light); 
            border-left: 4px solid var(--accent); 
            padding: 20px; 
            margin-bottom: 25px; 
            font-style: italic; 
            color: #475569; 
            border-radius: 0 12px 12px 0;
            line-height: 1.6;
        }
        
        .chart-container { 
            position: relative;
            width: 100%; 
            max-width: 700px; 
            height: 350px; 
            margin: 30px auto 40px; 
            text-align: center; 
            page-break-inside: avoid;
        }
        .chart-container canvas {
            display: block;
            width: 100% !important;
            height: 100% !important;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 30px; 
        }
        table th, table td { 
            padding: 12px 15px; 
            border: 1px solid var(--border-light); 
            text-align: left; 
            vertical-align: middle; 
        }
        table th { 
            background-color: var(--bg-light); 
            font-weight: 700; 
            font-size: 12px; 
            text-transform: uppercase; 
            letter-spacing: 0.05em;
            color: var(--primary); 
        }
        table tr:nth-child(even) { 
            background-color: #fcfcfc; 
        }
        
        .footer { 
            margin-top: 60px; 
            text-align: right; 
            font-size: 13px; 
            color: var(--text-muted);
            page-break-inside: avoid; 
        }
        .footer .sign-area { 
            margin-top: 80px; 
            font-weight: 700; 
            color: var(--text-dark);
        }
        
        @media print {
            @page { 
                size: A4 portrait;
                margin: 15mm 15mm 15mm 15mm; 
            }
            body { 
                padding: 0 !important; 
                margin: 0 !important;
                font-size: 11px !important;
                background: #fff !important;
                color: #000 !important;
                width: 100% !important;
                max-width: 100% !important;
            }
            .no-print, button { 
                display: none !important; 
            }
            .page-break-before { 
                page-break-before: always; 
            }
            .header {
                margin-bottom: 20px !important;
                padding-bottom: 12px !important;
                border-bottom-width: 2px !important;
            }
            .header h1 {
                font-size: 20px !important;
            }
            .chart-container {
                width: 100% !important;
                max-width: 440px !important;
                height: 240px !important;
                margin: 15px auto 20px !important;
            }
            table {
                width: 100% !important;
                max-width: 100% !important;
                font-size: 10px !important;
                page-break-inside: auto !important;
            }
            thead {
                display: table-header-group !important;
            }
            tr { 
                page-break-inside: avoid !important; 
                page-break-after: auto !important;
            }
            td, th {
                padding: 8px 10px !important;
            }
        }

        @media (max-width: 640px) {
            body {
                padding: 15px;
            }
            .chart-container {
                height: 260px;
                margin-bottom: 25px;
            }
        }
        
        .btn-print { 
            display: block; 
            margin: 0 auto 30px; 
            padding: 14px 28px; 
            font-size: 14px; 
            font-weight: 700;
            background: var(--secondary); 
            color: #fff; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            text-align: center; 
            text-transform: uppercase;
            letter-spacing: 0.05em;
            box-shadow: 0 4px 6px -1px rgba(0, 119, 182, 0.2);
            transition: all 0.3s ease;
        }
        .btn-print:hover { 
            background: var(--primary); 
            box-shadow: 0 10px 15px -3px rgba(3, 4, 94, 0.2);
            transform: translateY(-2px);
        }
        
        .chart-print-image {
            display: none;
        }
        @media print {
            .chart-container canvas {
                display: none !important;
            }
            .chart-print-image {
                display: block !important;
                margin: 0 auto !important;
                max-width: 100% !important;
                height: auto !important;
            }
            .chartjs-size-monitor {
                position: fixed !important;
            }
        }
    </style>
</head>
<body>
    <button class="btn-print" onclick="window.print()">Cetak Laporan Lengkap</button>

    <div class="header">
        <h1>LAPORAN KOMPREHENSIF DATA KEBUDAYAAN</h1>
        <p>Sistem Informasi Verifikasi Kebudayaan (VeriCult)</p>
        <p><strong>Periode Analisis: {{ ($activeYear && $activeYear !== 'all') ? 'Tahun ' . $activeYear : 'Semua Periode' }}</strong></p>
    </div>

    <!-- Bagian 1: Keseluruhan -->
    <div>
        <div class="section-title">1. Tinjauan Keseluruhan</div>
        
        <div class="analysis-box">
            <strong>Deskripsi & Analisis:</strong><br>
            {{ $analysisText['overall'] }} Dari total data tersebut, distribusi berdasarkan kategori menunjukkan fokus pelestarian atau pengajuan pada area tertentu.
        </div>

        @if(!$categoryStats->isEmpty())
        <div class="chart-container">
            <canvas id="overallChart"></canvas>
            <img id="overallChartImage" class="chart-print-image" alt="Chart Tinjauan Keseluruhan">
        </div>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 10%; text-align: center;">No</th>
                    <th style="width: 60%;">Kategori Kebudayaan</th>
                    <th style="width: 30%; text-align: center;">Jumlah Laporan</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($categoryStats as $cat => $count)
                <tr>
                    <td style="text-align: center;">{{ $i++ }}</td>
                    <td>{{ $cat }}</td>
                    <td style="text-align: center;"><strong>{{ $count }}</strong></td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="2" style="text-align: right;"><strong>Total Keseluruhan</strong></td>
                    <td style="text-align: center;"><strong>{{ $totalSubmissions }}</strong></td>
                </tr>
            </tbody>
        </table>
        @else
        <p style="text-align: center; font-style: italic; color: #94a3b8;">Belum ada data pada tahun ini.</p>
        @endif
    </div>

    <!-- Bagian 2: Kecamatan -->
    <div class="page-break-before">
        <div class="section-title">2. Distribusi Tingkat Kecamatan</div>
        
        <div class="analysis-box">
            <strong>Deskripsi & Analisis:</strong><br>
            {{ $analysisText['kecamatan'] }} Pemetaan tingkat kecamatan ini penting untuk melihat konsentrasi program pemajuan kebudayaan di level daerah.
        </div>

        @if(!$kecamatanStats->isEmpty())
        <div class="chart-container" style="max-width: 800px; height: 350px;">
            <canvas id="kecamatanChart"></canvas>
            <img id="kecamatanChartImage" class="chart-print-image" alt="Chart Distribusi Tingkat Kecamatan">
        </div>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 10%; text-align: center;">No</th>
                    <th style="width: 60%;">Nama Kecamatan</th>
                    <th style="width: 30%; text-align: center;">Total Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($kecamatanStats as $kec => $count)
                <tr>
                    <td style="text-align: center;">{{ $i++ }}</td>
                    <td>Kecamatan {{ str_replace('Kecamatan ', '', $kec) }}</td>
                    <td style="text-align: center;"><strong>{{ $count }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <!-- Bagian 3: Desa/Kelurahan -->
    <div class="page-break-before">
        <div class="section-title">3. Distribusi Tingkat Desa / Kelurahan</div>
        
        <div class="analysis-box">
            <strong>Deskripsi & Analisis:</strong><br>
            {{ $analysisText['desa'] }} Keterlibatan desa menunjukkan partisipasi aktif akar rumput dalam pendataan kebudayaan lokal.
        </div>

        @if(!$desaStats->isEmpty())
        <div class="chart-container" style="max-width: 800px; height: 350px;">
            <canvas id="desaChart"></canvas>
            <img id="desaChartImage" class="chart-print-image" alt="Chart Distribusi Tingkat Desa">
        </div>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 10%; text-align: center;">No</th>
                    <th style="width: 60%;">Nama Desa / Kelurahan</th>
                    <th style="width: 30%; text-align: center;">Total Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($desaStats->take(20) as $desa => $count)
                <tr>
                    <td style="text-align: center;">{{ $i++ }}</td>
                    <td>{{ $desa }}</td>
                    <td style="text-align: center;"><strong>{{ $count }}</strong></td>
                </tr>
                @endforeach
                @if($desaStats->count() > 20)
                <tr>
                    <td colspan="3" style="text-align: center; font-style: italic; color: #64748b;">Menampilkan 20 desa teratas dari total {{ $desaStats->count() }} desa.</td>
                </tr>
                @endif
            </tbody>
        </table>
        @endif
    </div>

    <div class="footer">
        <p>Laporan Resmi Dicetak Oleh: <strong>{{ auth()->user()->name }} (Validator)</strong></p>
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }}</p>
        
        <div class="sign-area">
            ( ____________________________ )<br>
            <span style="font-weight: normal; margin-top: 5px; display: inline-block;">Tanda Tangan Validator</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.defaults.animation = false;
            const isMobile = window.innerWidth < 640 || window.matchMedia('(max-width: 640px)').matches;
            
            // 1. Overall Category Chart
            @if(!$categoryStats->isEmpty())
            const overallChartInstance = new Chart(document.getElementById('overallChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode($categoryStats->keys()) !!},
                    datasets: [{
                        data: {!! json_encode($categoryStats->values()) !!},
                        backgroundColor: [
                            '#03045E', '#0077B6', '#00B4D8', '#06D6A0',
                            '#10B981', '#20BF55', '#FFD166', '#FF9F1C',
                            '#FF5400', '#EF4444', '#F72585', '#7209B7',
                            '#3A0CA3', '#4361EE'
                        ],
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    devicePixelRatio: 2,
                    plugins: {
                        legend: { 
                            position: isMobile ? 'bottom' : 'right',
                            labels: {
                                font: {
                                    family: "'Outfit', sans-serif",
                                    size: 10,
                                    weight: 'bold'
                                },
                                boxWidth: 12,
                                padding: 10
                            }
                        }
                    }
                }
            });
            @endif

            // 2. Kecamatan Chart
            @if(!$kecamatanStats->isEmpty())
            const kecamatanChartInstance = new Chart(document.getElementById('kecamatanChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($kecamatanStats->keys()->map(fn($k) => str_replace('Kecamatan ', '', $k))) !!},
                    datasets: [{
                        label: 'Total Pengajuan',
                        data: {!! json_encode($kecamatanStats->values()) !!},
                        backgroundColor: '#0077B6',
                        borderRadius: 4
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    devicePixelRatio: 2,
                    scales: { 
                        y: { beginAtZero: true, ticks: { precision: 0 } },
                        x: {
                            ticks: {
                                font: {
                                    family: "'Outfit', sans-serif",
                                    size: 9,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    family: "'Outfit', sans-serif",
                                    size: 10,
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            });
            @endif

            // 3. Desa Chart (Top 10 max for chart visibility)
            @if(!$desaStats->isEmpty())
            @php $topDesaStats = $desaStats->take(10); @endphp
            const desaChartInstance = new Chart(document.getElementById('desaChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($topDesaStats->keys()) !!},
                    datasets: [{
                        label: 'Total Pengajuan',
                        data: {!! json_encode($topDesaStats->values()) !!},
                        backgroundColor: '#10B981',
                        borderRadius: 4
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    devicePixelRatio: 2,
                    indexAxis: 'y',
                    scales: { 
                        x: { beginAtZero: true, ticks: { precision: 0 } },
                        y: {
                            ticks: {
                                font: {
                                    family: "'Outfit', sans-serif",
                                    size: 9,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    plugins: { legend: { display: false } }
                }
            });
            @endif

            // Convert charts to static images for print reliability and then trigger print
            setTimeout(() => {
                const overallImg = document.getElementById('overallChartImage');
                if (overallImg && typeof overallChartInstance !== 'undefined') {
                    overallImg.src = overallChartInstance.toBase64Image();
                }
                const kecamatanImg = document.getElementById('kecamatanChartImage');
                if (kecamatanImg && typeof kecamatanChartInstance !== 'undefined') {
                    kecamatanImg.src = kecamatanChartInstance.toBase64Image();
                }
                const desaImg = document.getElementById('desaChartImage');
                if (desaImg && typeof desaChartInstance !== 'undefined') {
                    desaImg.src = desaChartInstance.toBase64Image();
                }
                window.print();
            }, 1000);
        });
    </script>
</body>
</html>
