<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="filterMonth">Filter by Month</label>
            <input type="month" id="filterMonth" wire:model="filterMonth" wire:change="filterData" class="form-control">
        </div>
    </div>

    <div class="mb-3">
        @if ($filterMonth)
            <a href="{{ route('service.pdf', ['filterMonth' => $filterMonth]) }}" class="btn btn-primary"><i class="bi bi-printer"></i> Export PDF</a>
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
                    <th>Nama Produk</th>
                    <th>Tanggal Penerimaan</th>
                    <th>Tanggal Cutting</th>
                    <th>No Batch</th>
                    <th>Tanggal Service</th>
                    <th>KG</th>
                    <th>Pcs</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $index => $service)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $service->ikan->jenis_ikan }}</td>
                        <td>{{ $service->cutting->penerimaan_ikan->tgl_penerimaan }}</td>
                        <td>{{ $service->cutting->tgl_cutting }}</td>
                        <td>{{ $service->cutting->no_batch->no_batch }}</td>
                        <td>{{ $service->tgl_service }}</td>
                        <td>{{ $service->kg }}</td>
                        <td>{{ $service->pcs }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
