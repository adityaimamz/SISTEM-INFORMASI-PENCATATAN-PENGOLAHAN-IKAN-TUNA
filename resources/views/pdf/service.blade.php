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
    <h2>Report for Month: {{ $month }} Year: {{ $year }}</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk Cutting</th>
                <th>Nama Detail Produk</th>
                <th>Grade</th>
                <th>Berat Produk</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->cutting->nama_produk }}</td>
                    <td>{{ $item->detail->nama_produk }}</td>
                    <td>{{ $item->cutting->penerimaan_ikan->ikan->kategori->grade }}</td>
                    <td>{{ $item->cutting->berat_produk }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
