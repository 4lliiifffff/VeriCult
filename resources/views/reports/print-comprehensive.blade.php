<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Komprehensif Kebudayaan - Tahun {{ $activeYear }}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Arial', sans-serif; color: #333; line-height: 1.5; padding: 20px; font-size: 12px; }
        .header { text-align: center; border-bottom: 3px double #03045E; padding-bottom: 15px; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; color: #03045E; }
        .header p { margin: 5px 0 0; color: #555; font-size: 14px; }
        
        .section-title { font-size: 18px; font-weight: bold; color: #0077B6; border-bottom: 2px solid #0077B6; padding-bottom: 5px; margin-top: 40px; margin-bottom: 15px; text-transform: uppercase; }
        .analysis-box { background-color: #f8fafc; border-left: 4px solid #4361EE; padding: 15px; margin-bottom: 20px; font-style: italic; color: #475569; }
        
        .chart-container { width: 100%; max-width: 600px; height: 300px; margin: 0 auto 30px; text-align: center; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { padding: 10px; border: 1px solid #cbd5e1; text-align: left; vertical-align: middle; }
        table th { background-color: #f1f5f9; font-weight: bold; font-size: 12px; text-transform: uppercase; color: #1e293b; }
        table tr:nth-child(even) { background-color: #f8fafc; }
        
        .footer { margin-top: 50px; text-align: right; font-size: 12px; page-break-inside: avoid; }
        .footer .sign-area { margin-top: 80px; font-weight: bold; }
        
        @media print {
            body { padding: 0; }
            @page { margin: 1.5cm; }
            button { display: none; }
            .page-break-inside-avoid { page-break-inside: avoid; }
            .page-break-before { page-break-before: always; }
        }
        
        .btn-print { display: block; margin: 0 auto 20px; padding: 12px 25px; font-size: 16px; background: #0077B6; color: #fff; border: none; border-radius: 8px; cursor: pointer; text-align: center; width: 250px; font-weight: bold; }
        .btn-print:hover { background: #023E8A; }
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
