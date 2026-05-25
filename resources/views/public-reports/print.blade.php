<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Publik Kebudayaan - {{ ($activeYear && $activeYear !== 'all') ? 'Tahun ' . $activeYear : 'Semua Periode' }}</title>
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
            line-height: 1.5; 
            padding: 40px; 
            font-size: 13px; 
            background: #fff;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .header { 
            text-align: center; 
            border-bottom: 3px solid var(--primary); 
            padding-bottom: 20px; 
            margin-bottom: 30px; 
        }
        .header h1 { 
            margin: 0; 
            font-size: 24px; 
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
        
        .chart-container { 
            position: relative;
            width: 100%; 
            max-width: 600px;
            height: 350px; 
            margin: 0 auto 40px; 
            text-align: center; 
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
            .header {
                margin-bottom: 20px !important;
                padding-bottom: 12px !important;
                border-bottom-width: 2px !important;
            }
            .header h1 {
                font-size: 18px !important;
            }
            .chart-container {
                width: 100% !important;
                max-width: 440px !important;
                height: 240px !important;
                margin: 10px auto 20px !important;
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
                height: 280px;
                margin-bottom: 25px;
            }
        }
        
        .btn-print { 
            display: block; 
            margin: 0 auto 30px; 
            padding: 12px 24px; 
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
    <button class="btn-print" onclick="window.print()">Cetak Laporan</button>

    <div class="header">
        <h1>LAPORAN PUBLIK DATA KEBUDAYAAN TERVALIDASI</h1>
        <p>Sistem Informasi Verifikasi Kebudayaan (VeriCult)</p>
        <p><strong>Periode Tahun:</strong> {{ ($activeYear && $activeYear !== 'all') ? $activeYear : 'Semua Periode' }}</p>
    </div>

    @if(!$categoryStats->isEmpty())
    <div class="chart-container" style="page-break-inside: avoid;">
        <h3 style="margin-bottom: 10px; color: #03045E; font-size: 14px;">Distribusi Berdasarkan Kategori</h3>
        <canvas id="categoryChart"></canvas>
        <img id="categoryChartImage" class="chart-print-image" alt="Chart Distribusi Kategori">
    </div>
    @endif

    <div>
        <h3 style="color: #03045E; font-size: 14px; margin-bottom: 10px; border-bottom: 1px solid #ccc; padding-bottom: 5px;">Rincian Data Kebudayaan ({{ $submissions->count() }} Data)</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 25%">Nama Objek</th>
                    <th style="width: 25%">Kategori</th>
                    <th style="width: 25%">Wilayah (Desa/Kec)</th>
                    <th style="width: 20%">Tgl Validasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($submissions as $index => $sub)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td><strong>{{ $sub->name }}</strong></td>
                    <td>{{ $sub->category }}</td>
                    <td>
                        {{ $sub->village->name ?? '-' }}<br>
                        <small style="color: #666;">Kec. {{ $sub->village->kecamatan->name ?? '-' }}</small>
                    </td>
                    <td>{{ $sub->published_at ? $sub->published_at->translatedFormat('d M Y') : '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #777; font-style: italic;">Tidak ada data pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer page-break-inside-avoid">
        <p>Dicetak Pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>Sistem VeriCult</p>
    </div>

    @if(!$categoryStats->isEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('categoryChart').getContext('2d');
            
            // To ensure chart renders fully before printing if user uses auto-print
            Chart.defaults.animation = false;
            
            const isMobile = window.innerWidth < 640 || window.matchMedia('(max-width: 640px)').matches;
            
            const chartInstance = new Chart(ctx, {
                type: 'doughnut',
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
                    devicePixelRatio: 2, // Double canvas resolution for crystal-clear vector prints
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

            // Convert chart to static image for print reliability and then trigger print
            setTimeout(() => {
                const img = document.getElementById('categoryChartImage');
                if (img) {
                    img.src = chartInstance.toBase64Image();
                }
                window.print();
            }, 600);
        });
    </script>
    @else
    <script>
        setTimeout(() => { window.print(); }, 200);
    </script>
    @endif
</body>
</html>
