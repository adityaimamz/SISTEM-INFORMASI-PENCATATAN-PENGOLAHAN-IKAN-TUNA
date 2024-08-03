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
    <h1 style="text-align: center">Laporan Data Packing Pt.Tirta Bitung Bahari</h1>

    <table class="table" id="table1">
        <thead>
            <tr>
                <th>No</th>
                <th>No Box</th>
                <th>Buyer</th>
                <th>Produk</th>
                <th>pcs</th>
                <th>Berat</th>
                <th>Kode Trace</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($packings as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->no_box }}</td>
                    <td>{{ $item->buyer }}</td>
                    <td>{{ $item->service->ikan->jenis_ikan }}</td>
                    <td>{{ $item->pcs }}</td>
                    <td>{{ $item->berat }}</td>
                    <td>{{ $item->service->kode_trace->kode_trace }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
