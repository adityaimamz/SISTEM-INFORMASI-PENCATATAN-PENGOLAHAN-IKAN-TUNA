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
                <th>Kode Lot</th>
                <th>Tanggal Packing</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->service->kode_trace }}</td>
                    <td>{{ $item->tgl_packing }}</td>
                    <td>{{ $item->service->cutting->penerimaan_ikan->ikan->kategori->grade }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
