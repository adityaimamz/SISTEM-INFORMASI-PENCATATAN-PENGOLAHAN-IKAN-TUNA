<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    {{-- Style Tabel CSS --}}
    <style>
        .excel-table {
            font-size: 0.75rem;
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }
        .excel-table th, 
        .excel-table td {
            border: 1px solid hsl(0, 100.00%, 0.40%);
            padding: 2px 4px;
            vertical-align: middle;
            text-align: center;
            height: 28px;
        }
        .excel-input {
            width: 100%;
            height: 22px;
            padding: 0 2px;
            font-size: 0.75rem;
            font-family: 'Arial Narrow', sans-serif;
            border: 1px solid hsl(0, 89.20%, 7.30%);
            border-radius: 3px;
        }
        .excel-table select {
            height: 22px;
            font-size: 0.75rem;
            padding: 0 2px;
            border-radius: 0;
        }
        .excel-table .btn-sm {
            padding: 0 6px;
            height: 22px;
            font-size: 0.7rem;
            line-height: 1;
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
    </table>

    <table class="excel-table">
        <thead class="table-light text-center align-middle" style="background-color:rgb(121, 173, 246);">
            <tr>
                {{-- No Bak dan Aksi menempel ke bawah --}}
                <th rowspan="2" style="width: 100px;">No. Bak</th>

                {{-- Grade di atas --}}
                <th colspan="3">
                    <select wire:model.live="selected_grade_id" 
                            class="excel-input @error('selected_grade_id') is-invalid @enderror" 
                            @if(!$session_date || !$session_tgl_bongkar || !$session_supplier || !$session_jenis_penerimaan || !$session_no_bak) disabled @endif 
                            required style="font-size:.8rem; height:30px; background-color:rgb(121, 173, 246);">
                        <option value="" class="text-center" style="font-weight: bold;">-- Grade/Size --</option>
                        @foreach($grades as $grade)
                            @foreach($kategori_berat as $kategori)
                                <option value="{{ $grade->id }}_{{ $kategori->id }}" class="text-center" style="font-weight: bold;">
                                    {{ $grade->grade }} - {{ $kategori->kategori_berat }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                </th>
                <th rowspan="2" style="width: 80px;">Aksi</th>
            </tr>
            <tr>
                <th style="width: 120px;">Berat (Kg)</th>
                <th style="width: 120px;">Suhu (°C)</th>
                <th style="width: 120px;">No Ikan</th>
            </tr>
        </thead>

        <tbody>
            @php
                $rowsCollection = collect($rows ?? []);
                $total_berat = $rowsCollection->sum(fn($r) => (float)($r['berat_ikan'] ?? 0));
                $total_ekor  = $rowsCollection->count();
            @endphp

            @if(isset($rows) && count($rows) > 0)
                @foreach($rows as $index => $row)
                    <tr>
                            {{-- No. Bak --}}
                                <td class="text-center align-middle">
                                    {{ $session_no_bak }}
                                </td>

                            {{-- Berat --}}
                                <td>
                                    <input type="number" step="0.01" 
                                            wire:model="rows.{{ $index }}.berat_ikan"
                                            class="excel-input text-center"
                                            placeholder="Kg"
                                            required>
                                                @error('rows.{{ $index }}.berat_ikan')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                </td>

                            {{-- Suhu --}}
                                <td>
                                    <input type="number" step="0.1" 
                                            wire:model="rows.{{ $index }}.suhu_ikan"
                                            class="excel-input text-center"
                                        placeholder="°C"
                                        required>
                                            @error('rows.{{ $index }}.suhu_ikan')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                </td>

                            {{-- No Ikan --}}
                                <td>
                                    <input type="number" step="1" 
                                            wire:model="rows.{{ $index }}.no_ikan"
                                            class="excel-input text-center"
                                            placeholder="No Ikan"
                                            required>
                                            @error('rows.{{ $index }}.no_ikan')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                </td>
                                <!--
                                <td>
                                    <button class="btn btn-danger btn-sm py-0"
                                            wire:click="removeRow({{ $index }})"
                                            style="font-size:.7rem; height:30px; width:30px;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                                -->
                            </tr>
                @endforeach
            @endif

            @if(isset($rows) && count($rows) > 0)
                <tr class="table-secondary fw-bold excel-input text-center" style="background-color:rgb(121, 173, 246);">
                    <td>Total</td>
                    <td>{{ number_format($total_berat, 2) }} kg</td>
                    <td>{{ $total_ekor }} ekor</td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>

</html>
