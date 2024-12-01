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
    <h1 style="text-align: center">Laporan Data Cutting Pt.Tirta Bitung Bahari</h1>

    <table class="table" id="table">
        <thead>
            <tr>
                <th rowspan="1">NO</th>
                <th>Nama Supplier</th>
                <th>Tanggal penerimaan</th>
                <th>Tanggal cutting</th>
                <th colspan="1">1/3</th>
                <th colspan="1">3/5</th>
                <th colspan="1">5 UP</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cuttings as $key => $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->penerimaan_ikan->supplier->nama_supplier }}</td>
                    <td>{{ $item->penerimaan_ikan->tgl_penerimaan }}</td>
                    <td>{{ $item->tgl_cutting }}</td>
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
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $total13 }}</td>
                <td>{{ $total15 }}</td>
                <td>{{ $total5 }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
