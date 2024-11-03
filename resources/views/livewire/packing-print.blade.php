<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="selectedMonth">Select Month</label>
            <input type="month" id="selectedMonth" wire:model="selectedMonth" wire:change="filterData" class="form-control">
        </div>
    </div>

    <div class="mb-3">
        @if ($selectedMonth)
            <a href="{{ route('packing.pdf', ['month' => $selectedMonth]) }}" class="btn btn-primary"><i class="bi bi-printer"></i> Export PDF</a>
        @else
            <button class="btn btn-primary" disabled><i class="bi bi-printer"></i> Export PDF</button>
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
        <table class="table" id="table1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Box</th>
                    <th>Buyer</th>
                    <th>Produk</th>
                    <th>Kode Trace</th>
                    <th>Nama Supplier</th>
                    <th>pcs</th>
                    <th>Berat (Kg)</th>
                    <th>Kode Trace</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->no_box }}</td>
                        <td>{{ $item->buyer }}</td>
                        <td>{{ $item->service->ikan->jenis_ikan }}</td>
                        <td>{{ $item->service->kode_trace->kode_trace }}</td>
                        <td>{{ $item->service->cutting->penerimaan_ikan->supplier->nama_supplier }}</td>
                        <td>{{ $item->pcs }}</td>
                        <td>{{ $item->berat }}</td>
                        <td>{{ $item->service->kode_trace->kode_trace }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
