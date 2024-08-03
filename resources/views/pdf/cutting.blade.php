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
    <h1 style="text-align: center">Laporan Data Cutting Pt.Tirta Bitung Bahari</h1>

    <table class="table" id="table">
        <thead>
            <tr>
                <th rowspan="1">NO</th>
                <th colspan="1">1/3</th>
                <th colspan="1">3/5</th>
                <th colspan="1">5 UP</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cuttings as $key => $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kategori_berat->kategori_berat == '1/3' ? $item->berat_produk : '' }}</td>
                    <td>{{ $item->kategori_berat->kategori_berat == '3/5' ? $item->berat_produk : '' }}</td>
                    <td>{{ $item->kategori_berat->kategori_berat == '5 UP' ? $item->berat_produk : '' }}</td>
                </tr>
            @endforeach
            @php
                $dataCollection = collect($cuttings);

                $total13 = $dataCollection->where('kategori_berat.kategori_berat', '1/3')->sum('berat_produk');
                $total15 = $dataCollection->where('kategori_berat.kategori_berat', '3/5')->sum('berat_produk');
                $total5 = $dataCollection->where('kategori_berat.kategori_berat', '5 UP')->sum('berat_produk');
            @endphp

            <tr>
                <td colspan="1">Total</td>
                <td>{{ $total13 }}</td>
                <td>{{ $total15 }}</td>
                <td>{{ $total5 }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
