<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Alat</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 40px; color: #333; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 20px; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; font-size: 13px; }
        th { background-color: #f2f2f2; font-weight: bold; text-transform: uppercase; }
        .nav-area { margin-bottom: 30px; display: flex; gap: 10px; }
        .btn { text-decoration: none; padding: 10px 20px; border-radius: 6px; font-weight: bold; font-size: 14px; border: none; cursor: pointer; }
        .btn-back { background-color: #4b5563; color: white; }
        .btn-print { background-color: #4f46e5; color: white; }
        @media print { .no-print { display: none; } body { padding: 0; } }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Transaksi Peminjaman Alat</h1>
        <p>SMK INDONESIA - SISTEM INFORMASI INVENTARIS GUDANG</p>
        <p style="font-size: 12px;">Dicetak pada: {{ date('d F Y, H:i') }}</p>
    </div>

    <div class="nav-area no-print">
        <a href="{{ route('dashboard') }}" class="btn btn-back">⬅️ Kembali</a>
        <button onclick="window.print()" class="btn btn-print">🖨️ Cetak PDF</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Barang</th>
                <th style="text-align: center;">Jumlah</th>
                <th style="text-align: center;">Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            {{-- Bagian ini harus ditutup dengan @empty dan @endforelse --}}
            @forelse($peminjamans as $index => $p)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $p->user->name }}</td>
                    <td>{{ $p->barang->nama_barang }}</td>
                    <td style="text-align: center;">{{ $p->jumlah }}</td>
                    <td style="text-align: center;">{{ strtoupper($p->status) }}</td>
                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">Belum ada data transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 50px; float: right; text-align: center; width: 200px;">
        <p>Petugas Gudang,</p>
        <br><br><br>
        <p><strong>( {{ auth()->user()->name }} )</strong></p>
    </div>

</body>
</html>