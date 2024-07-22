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
                    <td>{{ $item->penerimaan_ikan->ikan->kategori->grade }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
