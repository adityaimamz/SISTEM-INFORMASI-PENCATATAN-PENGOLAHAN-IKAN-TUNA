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

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center">Laporan Data Service Pt.Tirta Bitung Bahari</h1>
    <table class="table" id="table1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>No Batch</th>
                <th>Tanggal Service</th>
                <th>KG</th>
                <th>Pcs</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($services as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->ikan->jenis_ikan }}</td>
                    <td>{{ $item->no_batch->no_batch }}</td>
                    <td>{{ $item->tgl_service }}</td>
                    <td>{{ $item->kg }}</td>
                    <td>{{ $item->pcs }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
