<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
        }

        .header img {
            width: 80px;
            height: auto;
        }

        .header h1 {
            margin: 0;
        }

        .header p {
            margin: 2px 0;
            font-size: 12px;
        }

        .info {
            text-align: left;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
    <!-- Header Section -->
    <div class="header">
        <img src="{{ public_path('img/logo-removebg.png') }}" alt="Logo">
        <h1>PT. TIRTA BITUNG BAHARI</h1>
        <p>KOMPLEK PELABUHAN PERIKANAN SAMUDERA BITUNG</p>
        <p>JL. MADIDIHANG, KEL. AERTEMBAGA I, KEC. AERTEMBAGA</p>
        <p>KOTA BITUNG, SULAWESI UTARA</p>
    </div>

    <!-- Date and Supplier Information -->
    <h2>NOTA PEMBELIAN</h2>
    <div class="info">
        <p><strong>Tanggal</strong>: {{ $date }}</p>
        <p><strong>Supplier</strong>: {{ $supplier_name }}</p>
    </div>

    <table class="table table-bordered" id="table">
        <tr>
            <th rowspan="2">NO</th>
            {{-- <th rowspan="2">Total</th> --}}
            <th colspan="4">10-19</th>
            <th colspan="4">20-29</th>
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
            {{-- @dd($data) --}}
            @foreach ($data as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->grade->grade == 'AB' && $item->kategori_berat_penerimaan->kategori_berat == '10-19' ? $item->berat_ikan : '' }}
                    </td>
                    <td>{{ $item->grade->grade == 'C' && $item->kategori_berat_penerimaan->kategori_berat == '10-19' ? $item->berat_ikan : '' }}
                    </td>
                    <td>{{ $item->grade->grade == 'ABC' && $item->kategori_berat_penerimaan->kategori_berat == '10-19' ? $item->berat_ikan : '' }}
                    </td>
                    <td>{{ $item->grade->grade == 'Lokal' && $item->kategori_berat_penerimaan->kategori_berat == '10-19' ? $item->berat_ikan : '' }}
                    </td>
                    <td>{{ $item->grade->grade == 'AB' && $item->kategori_berat_penerimaan->kategori_berat == '20-29' ? $item->berat_ikan : '' }}
                    </td>
                    <td>{{ $item->grade->grade == 'C' && $item->kategori_berat_penerimaan->kategori_berat == '20-29' ? $item->berat_ikan : '' }}
                    </td>
                    <td>{{ $item->grade->grade == 'ABC' && $item->kategori_berat_penerimaan->kategori_berat == '20-29' ? $item->berat_ikan : '' }}
                    </td>
                    <td>{{ $item->grade->grade == 'Lokal' && $item->kategori_berat_penerimaan->kategori_berat == '20-29' ? $item->berat_ikan : '' }}
                    </td>
                    <td>{{ $item->grade->grade == 'AB' && $item->kategori_berat_penerimaan->kategori_berat == '30 UP' ? $item->berat_ikan : '' }}
                    </td>
                    <td>{{ $item->grade->grade == 'C' && $item->kategori_berat_penerimaan->kategori_berat == '30 UP' ? $item->berat_ikan : '' }}
                    </td>
                    <td>{{ $item->grade->grade == 'ABC' && $item->kategori_berat_penerimaan->kategori_berat == '30 UP' ? $item->berat_ikan : '' }}
                    </td>
                    <td>{{ $item->grade->grade == 'Lokal' && $item->kategori_berat_penerimaan->kategori_berat == '30 UP' ? $item->berat_ikan : '' }}
                    </td>
                </tr>
            @endforeach
            @php
                $dataCollection = collect($data);

                $total_10up_ab = $dataCollection
                    ->where('grade.grade', 'AB')
                    ->where('kategori_berat_penerimaan.kategori_berat', '10-19')
                    ->sum('berat_ikan');
                $total_10up_c = $dataCollection
                    ->where('grade.grade', 'C')
                    ->where('kategori_berat_penerimaan.kategori_berat', '10-19')
                    ->sum('berat_ikan');
                $total_10up_abc = $dataCollection
                    ->where('grade.grade', 'ABC')
                    ->where('kategori_berat_penerimaan.kategori_berat', '10-19')
                    ->sum('berat_ikan');
                $total_10up_lokal = $dataCollection
                    ->where('grade.grade', 'Lokal')
                    ->where('kategori_berat_penerimaan.kategori_berat', '10-19')
                    ->sum('berat_ikan');
                $total_20up_ab = $dataCollection
                    ->where('grade.grade', 'AB')
                    ->where('kategori_berat_penerimaan.kategori_berat', '20-29')
                    ->sum('berat_ikan');
                $total_20up_c = $dataCollection
                    ->where('grade.grade', 'C')
                    ->where('kategori_berat_penerimaan.kategori_berat', '20-29')
                    ->sum('berat_ikan');
                $total_20up_abc = $dataCollection
                    ->where('grade.grade', 'ABC')
                    ->where('kategori_berat_penerimaan.kategori_berat', '20-29')
                    ->sum('berat_ikan');
                $total_20up_lokal = $dataCollection
                    ->where('grade.grade', 'Lokal')
                    ->where('kategori_berat_penerimaan.kategori_berat', '20-29')
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
