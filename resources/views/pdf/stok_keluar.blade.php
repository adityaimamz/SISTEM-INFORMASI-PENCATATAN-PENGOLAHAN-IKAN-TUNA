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

    <h1 class="report-title" style="text-align: center">Laporan Data Stok Keluar Pt.Tirta Bitung Bahari</h1>

    <table class="table" id="table2">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Pcs</th>
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
                    <td>{{ $item->noContainer->no_container }}</td>
                    <td>{{ $item->tgl_keluar }}</td>
                    <td>{{ $item->tgl_berangkat }}</td>
                    <td>{{ $item->tgl_tiba }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
