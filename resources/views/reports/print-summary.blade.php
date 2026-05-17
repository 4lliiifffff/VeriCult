<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rekapitulasi Data Kebudayaan {{ $activeCategory ? '- ' . $activeCategory : '(Semua Kategori)' }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
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
        
        .cat-title { 
            font-size: 18px; 
            font-weight: 800; 
            margin: 40px 0 15px; 
            border-bottom: 2px solid var(--border-light); 
            padding-bottom: 8px; 
            color: var(--primary); 
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
            tr { page-break-inside: avoid; }
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
        <table>
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
