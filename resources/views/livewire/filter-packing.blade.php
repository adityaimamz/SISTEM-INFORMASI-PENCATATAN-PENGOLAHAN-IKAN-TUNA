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

    <div class="mb-3">
        <a href="{{ route('packing.pdf', ['month' => $month, 'year' => $year]) }}" class="btn btn-primary">Export PDF</a>
    </div>

    <div class="table-responsive">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Box</th>
                    <th>Kode Lot</th>
                    <th>Tanggal Packing</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->no_box }}</td>
                        <td>{{ $item->service->kode_trace }}</td>
                        <td>{{ $item->tgl_packing }}</td>
                        <td>{{ $item->service->cutting->penerimaan_ikan->kategori_ikan->grade }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
