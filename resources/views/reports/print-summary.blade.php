<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rekapitulasi Data Kebudayaan {{ $activeCategory ? '- ' . $activeCategory : '(Semua Kategori)' }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; color: #333; line-height: 1.4; padding: 20px; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 22px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; color: #555; font-size: 13px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { padding: 8px 10px; border: 1px solid #ccc; text-align: left; vertical-align: top; }
        table th { background-color: #f4f4f4; font-weight: bold; uppercase; font-size: 11px; text-transform: uppercase; }
        
        .cat-title { font-size: 16px; font-weight: bold; margin: 30px 0 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; color: #03045E; }
        
        .footer { margin-top: 50px; text-align: right; font-size: 12px; }
        .footer .sign-area { margin-top: 70px; font-weight: bold; }
        
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
<body onload="window.print()">
    <button class="btn-print" onclick="window.print()">Cetak Laporan</button>

    <div class="header">
        <h1>REKAPITULASI DATA KEBUDAYAAN TERVALIDASI</h1>
        <p>Sistem Informasi Verifikasi Kebudayaan (VeriCult)</p>
        <p><strong>Filter Kategori:</strong> {{ $activeCategory ?: 'Semua Kategori' }}</p>
    </div>

    @forelse($groupedSubmissions as $category => $submissions)
        <div class="cat-title">{{ $category }} ({{ $submissions->count() }} Data)</div>
        <table class="page-break-inside-avoid">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 25%">Nama Objek</th>
                    <th style="width: 30%">Lokasi</th>
                    <th style="width: 20%">Pengusul</th>
                    <th style="width: 20%">Tgl Validasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $index => $sub)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td><strong>{{ $sub->name }}</strong></td>
                    <td>{{ $sub->address }}</td>
                    <td>{{ $sub->user->name ?? '-' }}</td>
                    <td>{{ $sub->published_at ? $sub->published_at->translatedFormat('d F Y') : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @empty
        <p style="text-align: center; color: #777; font-style: italic; margin-top: 50px;">Tidak ada data kebudayaan tervalidasi yang ditemukan.</p>
    @endforelse

    <div class="footer page-break-inside-avoid">
        <p>Dicetak Pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>VeriCult Verifier Team</p>
        <div class="sign-area">( ....................................... )</div>
    </div>
</body>
</html>
