<div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="month">Month</label>
            <select id="month" wire:model="month" wire:change="filterData" class="form-control">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ sprintf('%02d', $m) }}">{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-6">
            <label for="year">Year</label>
            <select id="year" wire:model="year" wire:change="filterData" class="form-control">
                @for ($y = 2020; $y <= now()->year; $y++)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
        </div>
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

    <div class="mb-3">
        <a href="{{ route('stok-keluar.pdf', ['month' => $month, 'year' => $year]) }}" class="btn btn-primary"><i class="bi bi-printer"></i> Export PDF</a>
    </div>

    <div class="table-responsive">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Box</th>
                    <th>Jumlah Produk</th>
                    <th>No Seal</th>
                    <th>No Container</th>
                    <th>Tanggal Keluar</th>
                    <th>Tanggal Berangkat</th>
                    <th>Tanggal Tiba</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->no_box }}</td>
                        <td>{{ $item->jumlah_produk }}</td>
                        <td>{{ $item->no_seal }}</td>
                        <td>{{ $item->no_container }}</td>
                        <td>{{ $item->tgl_keluar }}</td>
                        <td>{{ $item->tgl_berangkat }}</td>
                        <td>{{ $item->tgl_tiba }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h5 class="card-title">Stok Produksi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Total Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $totalStok }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
