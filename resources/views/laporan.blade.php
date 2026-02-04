<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Alat</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { bg-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 30px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PEMINJAMAN ALAT GUDANG</h2>
        <p>Tanggal Cetak: {{ date('d-m-Y') }}</p>
    </div>

    <button class="no-print" onclick="window.print()" style="margin-bottom: 20px; padding: 10px; cursor: pointer;">
        Cetak Laporan (Print)
    </button>
    <a href="{{ route('dashboard') }}" class="no-print" style="margin-left: 10px;">Kembali</a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporans as $key => $l)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $l->user->name }}</td>
                <td>{{ $l->barang->nama_barang }}</td>
                <td>{{ $l->jumlah }}</td>
                <td>{{ $l->tgl_pinjam ?? '-' }}</td>
                <td>{{ $l->tgl_kembali ?? '-' }}</td>
                <td>{{ strtoupper($l->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>