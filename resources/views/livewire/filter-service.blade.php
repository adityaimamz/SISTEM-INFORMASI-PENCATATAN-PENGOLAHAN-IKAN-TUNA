<div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="month">Month</label>
            <select id="month" wire:model="month" wire:change="filterData" class="form-control">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ sprintf('%02d', $m) }}">{{ DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>
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

    <div class="mb-3">
        <a href="{{ route('service.pdf', ['month' => $month, 'year' => $year]) }}" class="btn btn-primary">Export
            PDF</a>
    </div>

    <div class="table-responsive">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Trace</th>
                    <th>Nama Produk Cutting</th>
                    <th>Nama Detail Produk</th>
                    <th>Grade</th>
                    <th>Berat Produk</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kode_trace  }}</td>
                        <td>{{ $item->cutting->nama_produk }}</td>
                        <td>{{ $item->detail->nama_produk }}</td>
                        <td>{{ $item->cutting->penerimaan_ikan->kategori_ikan->grade }}</td>
                        <td>{{ $item->berat_produk }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h5 class="card-title">Total Berat Per Grade</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Grade</th>
                            <th>Total Berat (kg)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($totalBeratPerGrade as $grade)
                            <tr>
                                <td>{{ $grade->grade }}</td>
                                <td>{{ $grade->total_berat }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
