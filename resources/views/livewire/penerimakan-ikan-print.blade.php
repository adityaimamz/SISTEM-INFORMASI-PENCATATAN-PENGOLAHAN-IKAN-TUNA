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
        <a href="{{ route('ikan.pdf', ['month' => $month, 'year' => $year]) }}" class="btn btn-primary"><i class="bi bi-printer"></i> Export PDF</a>
    </div>

    <div class="table-responsive">
        <table class="table" id="table">
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
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item->tgl_penerimaan }}</td>
                        <td>{{ $item->tgl_bongkar }}</td>
                        <td>{{ $item->supplier->nama_supplier }}</td>
                        <td>{{ $item->Kategori_produk->jenis_ikan }}</td>
                        <td>{{ $item->no_bak }}</td>
                        <td>{{ $item->Kategori_produk->grade }} - {{ $item->Kategori_produk->kategori_berat }}</td>
                        <td>{{ $item->berat_ikan }}</td>
                        <td>{{ $item->suhu_ikan }}</td>
                        <td>{{ $item->no_ikan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
