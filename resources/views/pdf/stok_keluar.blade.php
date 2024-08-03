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

    <table class="table" id="table2">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Pcs</th>
                <th>No Seal</th>
                <th>No Container</th>
                <th>Tanggal Keluar</th>
                <th>Tanggal Berangkat</th>
                <th>Tanggal Tiba</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produkKeluar as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->service->ikan->jenis_ikan }}</td>
                    <td>{{ $item->pcs }}</td>
                    <td>{{ $item->no_seal }}</td>
                    <td>{{ $item->no_container }}</td>
                    <td>{{ $item->tgl_keluar }}</td>
                    <td>{{ $item->tgl_berangkat }}</td>
                    <td>{{ $item->tgl_tiba }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
