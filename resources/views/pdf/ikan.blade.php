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
                    <td>{{ $item->ikan->kategori->grade }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
