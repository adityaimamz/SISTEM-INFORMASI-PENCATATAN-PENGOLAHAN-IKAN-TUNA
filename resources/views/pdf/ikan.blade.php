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
    <h1 style="text-align: center">Laporan Data Penerimaan Ikan Pt.Tirta Bitung Bahari</h1>

    <h4>Report untuk Bulan: {{ $month }} Tahun: {{ $year }}</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Supplier</th>
                <th>Ikan</th>
                <th>Tanggal Penerimaan</th>
                <th>Berat Ikan</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->supplier->nama_supplier }}</td>
                    <td>{{ $item->ikan->jenis_ikan }}</td>
                    <td>{{ $item->tgl_penerimaan }}</td>
                    <td>{{ $item->ikan->berat_ikan }}</td>
                    <td>{{ $item->kategori_ikan->grade }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
