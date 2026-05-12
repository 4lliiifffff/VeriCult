<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Publik Kebudayaan - Tahun {{ $activeYear }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Arial', sans-serif; color: #333; line-height: 1.4; padding: 20px; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 22px; text-transform: uppercase; color: #03045E; }
        .header p { margin: 5px 0 0; color: #555; font-size: 13px; }
        
        .chart-container { width: 500px; height: 300px; margin: 0 auto 30px; text-align: center; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { padding: 8px 10px; border: 1px solid #ccc; text-align: left; vertical-align: top; }
        table th { background-color: #f4f4f4; font-weight: bold; font-size: 11px; text-transform: uppercase; }
        
        .footer { margin-top: 50px; text-align: right; font-size: 12px; }
        
        @media print {
            body { padding: 0; }
            @page { margin: 1.5cm; }
            button { display: none; }
            .page-break-inside-avoid { page-break-inside: avoid; }
        }
        
        .btn-print { display: block; margin: 0 auto 20px; padding: 10px 20px; font-size: 16px; background: #0077B6; color: #fff; border: none; border-radius: 5px; cursor: pointer; text-align: center; width: 200px; }
        .btn-print:hover { background: #023E8A; }
    </style>
</head>
<body>
    <button class="btn-print" onclick="window.print()">Cetak Laporan</button>

    <div class="header">
        <h1>LAPORAN PUBLIK DATA KEBUDAYAAN TERVALIDASI</h1>
        <p>Sistem Informasi Verifikasi Kebudayaan (VeriCult)</p>
        <p><strong>Periode Tahun:</strong> {{ $activeYear }}</p>
    </div>

    @if(!$categoryStats->isEmpty())
    <div class="chart-container page-break-inside-avoid">
        <h3 style="margin-bottom: 10px; color: #03045E; font-size: 14px;">Distribusi Berdasarkan Kategori</h3>
        <canvas id="categoryChart"></canvas>
    </div>
    @endif

    <div class="page-break-inside-avoid">
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
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right' }
                    }
                }
            });

            // Automatically trigger print after a small delay to ensure chart is rendered
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
    @else
    <script>
        setTimeout(() => { window.print(); }, 200);
    </script>
    @endif
</body>
</html>
