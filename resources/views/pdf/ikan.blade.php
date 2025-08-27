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

        .info2 {
            text-align: right;
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
        <h1>PT BAHARI PRIMA MANUNGGAL</h1>
        <p>KOMPLEK PELABUHAN PERIKANAN SAMUDERA BITUNG</p>
        <p>JL. Bakti Mulya 2 No. 58, Kel. Tegal Alur, Kec. Kalideres, Jakarta Barat</p>
    </div>

    <!-- Date and Supplier Information -->
    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <!-- Kolom Kiri -->
            <td style="text-align: left; vertical-align: top; width: 50%;">
                <p><strong>Tanggal Penerimaan</strong>: {{ $date ?? 'Semua Tanggal' }}</p>
                <p><strong>Tanggal Bongkar</strong>: {{ $tgl_bongkar ?? '-' }}</p>
            </td>

            <!-- Kolom Kanan -->
            <td style="text-align: right; vertical-align: top; width: 50%;">
                <p><strong>Supplier</strong>: {{ $supplier_name }}</p>
                <p><strong>Jenis Penerimaan</strong>: {{ $jenis_penerimaan_display }}</p>
            </td>
        </tr>
</table>                    A   aZa                                                             a       ASA A0  A0AS    .   <a href="">aS       
    aA  
    0
            36L6
                3   603,
    <table class="table table-bordered" id="table">
        <tr>
            <th rowspan="2" class="no-column" style="width: 5%;" text-align="center">NO</th>
            <th colspan="2" class="section-20up">20 UP</th>
            <th colspan="2" class="section-20down">20 DOWN</th>
            <th rowspan="2" class="suhu-column">Suhu (°C)</th>
            <th rowspan="2" class="no-bak-column">No Bak</th>
        </tr>
        <tr>
            <th class="section-20up">B/C</th>
            <th class="section-20up">D</th>
            <th class="section-20down">B/C</th>
            <th class="section-20down">D</th>
        </tr>
        <tbody>
            {{-- @dd($data) --}}
            @foreach ($data as $key => $item)
                    <tr>
                        <td class="no-column">{{ $key + 1 }}</td>
                        <!-- 20 UP Section -->
                        <td class="section-20up">{{ $item->grade->grade == 'B/C' && $item->kategori_berat_penerimaan->kategori_berat == '20 UP' ? $item->berat_ikan : '' }}</td>
                        <td class="section-20up">{{ $item->grade->grade == 'D' && $item->kategori_berat_penerimaan->kategori_berat == '20 UP' ? $item->berat_ikan : '' }}</td>
                        <!-- 20 DOWN Section -->
                        <td class="section-20down">{{ $item->grade->grade == 'B/C' && $item->kategori_berat_penerimaan->kategori_berat == '20 DOWN' ? $item->berat_ikan : '' }}</td>
                        <td class="section-20down">{{ $item->grade->grade == 'D' && $item->kategori_berat_penerimaan->kategori_berat == '20 DOWN' ? $item->berat_ikan : '' }}</td>
                        <!-- Suhu Column -->
                        <td class="suhu-column">{{ $item->suhu_ikan ?? '-' }}°C</td>
                            3   32000000000000000000000000000000000000000000000002<<                       <td class="no-bak-column">{{ $item->no_bak ?? '-' }}</td>
                    </tr>
                @endforeach
                
                @php
                    $dataCollection = collect($data);

                    // 20 UP columns (≥20kg)
                    $total_20up_bc = $dataCollection
                        ->where('grade.grade', 'B/C')
                        ->where('kategori_berat_penerimaan.kategori_berat', '20 UP')
                        ->sum('berat_ikan');
                    $total_20up_d = $dataCollection
                        ->where('grade.grade', 'D')
                        ->where('kategori_berat_penerimaan.kategori_berat', '20 UP')
                        ->sum('berat_ikan');
                    // 20 DOWN columns (10-19kg)
                    $total_20down_bc = $dataCollection
                        ->where('grade.grade', 'B/C')
                        ->where('kategori_berat_penerimaan.kategori_berat', '20 DOWN')
                        ->sum('berat_ikan');
                    $total_20down_d = $dataCollection
                        ->where('grade.grade', 'D')
                        ->where('kategori_berat_penerimaan.kategori_berat', '20 DOWN')
                        ->sum('berat_ikan');
                @endphp
            <tr>
                <td><strong>Total (kg)</strong></td>
                <td class="section-20up"><strong>{{ $total_20up_bc }}</strong></td>
                <td class="section-20up"><strong>{{ $total_20up_d }}</strong></td>
                <td class="section-20down"><strong>{{ $total_20down_bc }}</strong></td>
                <td class="section-20down"><strong>{{ $total_20down_d }}</strong></td>
                <td class="suhu-column">-</td>
                <td></td>
            </tr>
            <tr class="total-row">
                <td><strong>Total (Ekor)</strong></td>
                <td class="section-20up"><strong>{{ $data->where('grade.grade', 'B/C')->where('kategori_berat_penerimaan.kategori_berat', '20 UP')->count() }}</strong></td>
                <td class="section-20up"><strong>{{ $data->where('grade.grade', 'D')->where('kategori_berat_penerimaan.kategori_berat', '20 UP')->count() }}</strong></td>
                <td class="section-20down"><strong>{{ $data->where('grade.grade', 'B/C')->where('kategori_berat_penerimaan.kategori_berat', '20 DOWN')->count() }}</strong></td>
                <td class="section-20down"><strong>{{ $data->where('grade.grade', 'D')->where('kategori_berat_penerimaan.kategori_berat', '20 DOWN')->count() }}</strong></td>
                <td class="suhu-column">-</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
