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
    <h1 style="text-align: center">Laporan Data Cutting Pt.Tirta Bitung Bahari</h1>

    <h4>Report untuk Bulan: {{ $month }} Tahun: {{ $year }}</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Batch</th>
                <th>Id Produk</th>
                <th>Berat Produk</th>
                <th>Nama Produk</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->no_batch }}</td>
                    <td>{{ $item->id_produk }}</td>
                    <td>{{ $item->berat_produk }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>{{ $item->penerimaan_ikan->ikan->grade }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        <h4>Total Berat Per Grade</h4>
        <table>
            <thead>
                <tr>
                    <th>Grade</th>
                    <th>Total Berat (kg)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($totalBeratPerGrade as $grade)
                    <tr>
                        <td>{{ $grade->grade }}</td>
                        <td>{{ $grade->total_berat }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
