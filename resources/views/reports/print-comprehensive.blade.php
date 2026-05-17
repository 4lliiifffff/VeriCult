<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Komprehensif Kebudayaan - Tahun {{ $activeYear }}</title>
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
            width: 100%; 
            max-width: 700px; 
            height: 350px; 
            margin: 30px auto 40px; 
            text-align: center; 
            page-break-inside: avoid;
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
            body { padding: 0; }
            @page { margin: 1.5cm; }
            .no-print, button { display: none !important; }
            .page-break-inside-avoid { page-break-inside: avoid; }
            .page-break-before { page-break-before: always; }
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
    </style>
</head>
<body>
    <button class="btn-print" onclick="window.print()">Cetak Laporan Lengkap</button>

    <div class="header">
        <h1>LAPORAN KOMPREHENSIF DATA KEBUDAYAAN</h1>
        <p>Sistem Informasi Verifikasi Kebudayaan (VeriCult)</p>
        <p><strong>Periode Analisis: Tahun {{ $activeYear }}</strong></p>
    </div>

    <!-- Bagian 1: Keseluruhan -->
    <div class="page-break-inside-avoid">
        <div class="section-title">1. Tinjauan Keseluruhan</div>
        
        <div class="analysis-box">
            <strong>Deskripsi & Analisis:</strong><br>
            {{ $analysisText['overall'] }} Dari total data tersebut, distribusi berdasarkan kategori menunjukkan fokus pelestarian atau pengajuan pada area tertentu.
        </div>

        @if(!$categoryStats->isEmpty())
        <div class="chart-container">
            <canvas id="overallChart"></canvas>
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
            
            // 1. Overall Category Chart
            @if(!$categoryStats->isEmpty())
            new Chart(document.getElementById('overallChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode($categoryStats->keys()) !!},
                    datasets: [{
                        data: {!! json_encode($categoryStats->values()) !!},
                        backgroundColor: ['#03045E', '#0077B6', '#00B4D8', '#90E0EF', '#4361EE', '#3A0CA3', '#7209B7', '#F72585'],
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
            @endif

            // 2. Kecamatan Chart
            @if(!$kecamatanStats->isEmpty())
            new Chart(document.getElementById('kecamatanChart').getContext('2d'), {
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
                    scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                }
            });
            @endif

            // 3. Desa Chart (Top 10 max for chart visibility)
            @if(!$desaStats->isEmpty())
            @php $topDesaStats = $desaStats->take(10); @endphp
            new Chart(document.getElementById('desaChart').getContext('2d'), {
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
                    indexAxis: 'y',
                    scales: { x: { beginAtZero: true, ticks: { precision: 0 } } },
                    plugins: { legend: { display: false } }
                }
            });
            @endif

            // Auto print prompt
            setTimeout(() => { window.print(); }, 800);
        });
    </script>
</body>
</html>
