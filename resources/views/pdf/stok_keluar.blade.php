<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center">Laporan Data Stok Keluar Pt.Tirta Bitung Bahari</h1>

    <h4>Report untuk Bulan: {{ $month }} Tahun: {{ $year }}</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Box</th>
                <th>Jumlah Produk</th>
                <th>No Seal</th>
                <th>No Container</th>
                <th>Tanggal Keluar</th>
                <th>Tanggal Berangkat</th>
                <th>Tanggal Tiba</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->no_box }}</td>
                    <td>{{ $item->jumlah_produk }}</td>
                    <td>{{ $item->no_seal }}</td>
                    <td>{{ $item->no_container }}</td>
                    <td>{{ $item->tgl_keluar }}</td>
                    <td>{{ $item->tgl_berangkat }}</td>
                    <td>{{ $item->tgl_tiba }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Total Stok Produksi</h4>
    <table>
        <thead>
            <tr>
                <th>Total Stok</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $totalStok }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
