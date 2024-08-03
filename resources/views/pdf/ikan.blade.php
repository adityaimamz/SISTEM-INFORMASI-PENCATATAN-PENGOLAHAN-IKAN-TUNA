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
            text-align: center;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center">Laporan Data Penerimaan Ikan Pt.Tirta Bitung Bahari</h1>

    <table class="table table-bordered" id="table">
        <tr>
            <th rowspan="2">NO</th>
            {{-- <th rowspan="2">Total</th> --}}
            <th colspan="4">10 UP</th>
            <th colspan="4">20 UP</th>
            <th colspan="4">30 UP</th>
        </tr>
        <tr>
            <th>AB</th>
            <th>C</th>
            <th>ABC</th>
            <th>Lokal</th>
            <th>AB</th>
            <th>C</th>
            <th>ABC</th>
            <th>Lokal</th>
            <th>AB</th>
            <th>C</th>
            <th>ABC</th>
            <th>Lokal</th>
        </tr>
        <tbody>
            @foreach ($data as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->grade->grade == 'AB' && $item->kategori_berat_penerimaan->kategori_berat == '10 UP' ? $item->berat_ikan : '' }}</td>
                    <td>{{ $item->grade->grade == 'C' && $item->kategori_berat_penerimaan->kategori_berat == '10 UP' ? $item->berat_ikan : '' }}</td>
                    <td>{{ $item->grade->grade == 'ABC' && $item->kategori_berat_penerimaan->kategori_berat == '10 UP' ? $item->berat_ikan : '' }}</td>
                    <td>{{ $item->grade->grade == 'Lokal' && $item->kategori_berat_penerimaan->kategori_berat == '10 UP' ? $item->berat_ikan : '' }}</td>
                    <td>{{ $item->grade->grade == 'AB' && $item->kategori_berat_penerimaan->kategori_berat == '20 UP' ? $item->berat_ikan : '' }}</td>
                    <td>{{ $item->grade->grade == 'C' && $item->kategori_berat_penerimaan->kategori_berat == '20 UP' ? $item->berat_ikan : '' }}</td>
                    <td>{{ $item->grade->grade == 'ABC' && $item->kategori_berat_penerimaan->kategori_berat == '20 UP' ? $item->berat_ikan : '' }}</td>
                    <td>{{ $item->grade->grade == 'Lokal' && $item->kategori_berat_penerimaan->kategori_berat == '20 UP' ? $item->berat_ikan : '' }}</td>
                    <td>{{ $item->grade->grade == 'AB' && $item->kategori_berat_penerimaan->kategori_berat == '30 UP' ? $item->berat_ikan : '' }}</td>
                    <td>{{ $item->grade->grade == 'C' && $item->kategori_berat_penerimaan->kategori_berat == '30 UP' ? $item->berat_ikan : '' }}</td>
                    <td>{{ $item->grade->grade == 'ABC' && $item->kategori_berat_penerimaan->kategori_berat == '30 UP' ? $item->berat_ikan : '' }}</td>
                    <td>{{ $item->grade->grade == 'Lokal' && $item->kategori_berat_penerimaan->kategori_berat == '30 UP' ? $item->berat_ikan : '' }}</td>
                </tr>
            @endforeach
            @php
                $dataCollection = collect($data);

                $total_10up_ab = $dataCollection
                    ->where('grade.grade', 'AB')
                    ->where('kategori_berat_penerimaan.kategori_berat', '10 UP')
                    ->sum('berat_ikan');
                $total_10up_c = $dataCollection
                    ->where('grade.grade', 'C')
                    ->where('kategori_berat_penerimaan.kategori_berat', '10 UP')
                    ->sum('berat_ikan');
                $total_10up_abc = $dataCollection
                    ->where('grade.grade', 'ABC')
                    ->where('kategori_berat_penerimaan.kategori_berat', '10 UP')
                    ->sum('berat_ikan');
                $total_10up_lokal = $dataCollection
                    ->where('grade.grade', 'Lokal')
                    ->where('kategori_berat_penerimaan.kategori_berat', '10 UP')
                    ->sum('berat_ikan');
                $total_20up_ab = $dataCollection
                    ->where('grade.grade', 'AB')
                    ->where('kategori_berat_penerimaan.kategori_berat', '20 UP')
                    ->sum('berat_ikan');
                $total_20up_c = $dataCollection
                    ->where('grade.grade', 'C')
                    ->where('kategori_berat_penerimaan.kategori_berat', '20 UP')
                    ->sum('berat_ikan');
                $total_20up_abc = $dataCollection
                    ->where('grade.grade', 'ABC')
                    ->where('kategori_berat_penerimaan.kategori_berat', '20 UP')
                    ->sum('berat_ikan');
                $total_20up_lokal = $dataCollection
                    ->where('grade.grade', 'Lokal')
                    ->where('kategori_berat_penerimaan.kategori_berat', '20 UP')
                    ->sum('berat_ikan');
                $total_30up_ab = $dataCollection
                    ->where('grade.grade', 'AB')
                    ->where('kategori_berat_penerimaan.kategori_berat', '30 UP')
                    ->sum('berat_ikan');
                $total_30up_c = $dataCollection
                    ->where('grade.grade', 'C')
                    ->where('kategori_berat_penerimaan.kategori_berat', '30 UP')
                    ->sum('berat_ikan');
                $total_30up_abc = $dataCollection
                    ->where('grade.grade', 'ABC')
                    ->where('kategori_berat_penerimaan.kategori_berat', '30 UP')
                    ->sum('berat_ikan');
                $total_30up_lokal = $dataCollection
                    ->where('grade.grade', 'Lokal')
                    ->where('kategori_berat_penerimaan.kategori_berat', '30 UP')
                    ->sum('berat_ikan');
            @endphp

            <tr>
                <td><strong>Total</strong></td>
                {{-- <td><strong></strong></td> --}}
                <td><strong>{{ $total_10up_ab }}</strong></td>
                <td><strong>{{ $total_10up_c }}</strong></td>
                <td><strong>{{ $total_10up_abc }}</strong></td>
                <td><strong>{{ $total_10up_lokal }}</strong></td>
                <td><strong>{{ $total_20up_ab }}</strong></td>
                <td><strong>{{ $total_20up_c }}</strong></td>
                <td><strong>{{ $total_20up_abc }}</strong></td>
                <td><strong>{{ $total_20up_lokal }}</strong></td>
                <td><strong>{{ $total_30up_ab }}</strong></td>
                <td><strong>{{ $total_30up_c }}</strong></td>
                <td><strong>{{ $total_30up_abc }}</strong></td>
                <td><strong>{{ $total_30up_lokal }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
