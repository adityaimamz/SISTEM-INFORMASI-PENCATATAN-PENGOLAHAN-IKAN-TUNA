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
    <h1 style="text-align: center">Laporan Data Stok Masuk Pt.Tirta Bitung Bahari</h1>

    <h4>Report untuk Bulan: {{ $month }} Tahun: {{ $year }}</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Box</th>
                <th>Stok Masuk</th>
                <th>Tanggal Masuk</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->no_box }}</td>
                    <td>{{ $item->stok_masuk }}</td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
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
