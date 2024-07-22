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
</body>
</html>
