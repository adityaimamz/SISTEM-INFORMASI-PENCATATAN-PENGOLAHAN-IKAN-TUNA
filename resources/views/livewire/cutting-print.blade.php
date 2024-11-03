<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="filterMonth">Filter by Month</label>
            <input type="month" id="filterMonth" wire:model="filterMonth" wire:change="filterData" class="form-control">
        </div>
    </div>

    <div class="mb-3">
        @if ($filterMonth)
            <a href="{{ route('cutting.pdf', ['filterMonth' => $filterMonth]) }}" class="btn btn-primary"><i class="bi bi-printer"></i> Export PDF</a>
        @else
            <button class="btn btn-primary" disabled> <i class="bi bi-printer"></i>
                Export PDF</button>
        @endif
    </div>


    <style>
        #table {
            border: 1.5px solid black;
        }

        #table th,
        #table td {
            border: 0.5px solid black;
        }
    </style>

    <div class="table-responsive">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Supplier</th>
                    <th>Tanggal penerimaan</th>
                    <th>Tanggal cutting</th>
                    <th>1/3</th>
                    <th>3/5</th>
                    <th>5 UP</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cuttings as $index => $cutting)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $cutting->penerimaan_ikan->supplier->nama_supplier }}</td>
                        <td>{{ $cutting->penerimaan_ikan->tgl_penerimaan }}</td>
                        <td>{{ $cutting->tgl_cutting }}</td>
                        <td>{{ $cutting->kategori_berat->kategori_berat == '1/3' ? $cutting->berat_produk : '' }}</td>
                        <td>{{ $cutting->kategori_berat->kategori_berat == '3/5' ? $cutting->berat_produk : '' }}</td>
                        <td>{{ $cutting->kategori_berat->kategori_berat == '5 UP' ? $cutting->berat_produk : '' }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ $total13 }}</td>
                    <td>{{ $total15 }}</td>
                    <td>{{ $total5 }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
