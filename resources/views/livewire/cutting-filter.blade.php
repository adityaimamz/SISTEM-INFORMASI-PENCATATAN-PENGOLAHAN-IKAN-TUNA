<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="no_batch">No Batch</label>
            <select id="no_batch" wire:model="no_batch" wire:change="filterData" class="form-control">
                <option value="">Pilih No Batch</option>
                @foreach ($no_batches as $noBatch)
                    <option value="{{ $noBatch->id }}">{{ $noBatch->no_batch }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="tanggal_penerimaan">Tanggal Penerimaan</label>
            <input type="date" class="form-control" value="{{ $tanggal_penerimaan }}" readonly>
        </div>
        <div class="col-md-3">
            <label for="tanggal_cutting">Tanggal Cutting</label>
            <input type="date" class="form-control" value="{{ $tgl_cutting }}" readonly>
        </div>
        <div class="col-md-3">
            <label for="supplier">Supplier</label>
            <input type="text" class="form-control" value="{{ $supplier }}" readonly>
        </div>
        <div class="col-md-3">
            <label for="grade">Grade</label>
            <input type="text" class="form-control" value="{{ $grade }}" readonly>
        </div>
    </div>

    <div class="mb-3">
        @if ($no_batch)
            <a href="{{ route('cutting.pdf', ['no_batch' => $no_batch]) }}" class="btn btn-primary">Export PDF</a>
        @else
            <button class="btn btn-primary" disabled>Export PDF</button>
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
                    <th rowspan="2">NO</th>
                    <th colspan="1">1/3</th>
                    <th colspan="1">3/5</th>
                    <th colspan="1">5 UP</th>
                    <th rowspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cuttings as $key => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->kategori_berat->kategori_berat == '1/3' ? $item->berat_produk : '' }}</td>
                        <td>{{ $item->kategori_berat->kategori_berat == '3/5' ? $item->berat_produk : '' }}</td>
                        <td>{{ $item->kategori_berat->kategori_berat == '5 UP' ? $item->berat_produk : '' }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#editCuttingModal" wire:click="loadCuttingForEdit({{ $item->id }})">
                                Edit Cutting
                            </button>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#hapusCuttingModal{{ $item->id }}">
                                Hapus Cutting
                            </button>
                        </td>
                    </tr>

                    <!-- Modal for Editing Cutting -->
                    <div wire:ignore.self class="modal fade" id="editCuttingModal" tabindex="-1" role="dialog"
                    aria-labelledby="editCuttingModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editCuttingModalTitle">Edit Cutting</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form wire:submit.prevent="updateCutting">
                                    <div class="form-group">
                                        <label for="edit_no_batch_id">No Batch</label>
                                        <select class="form-control border-primary" wire:model="edit_no_batch" required>
                                            @foreach ($no_batches as $batch)
                                                <option value="{{ $batch->id }}">{{ $batch->no_batch }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                
                                    <div class="form-group">
                                        <label for="edit_berat_produk">Berat Produk</label>
                                        <input type="number" class="form-control border-primary" 
                                            wire:model="edit_berat_produk" step="0.01" required>
                                    </div>
                
                                    <div class="form-group">
                                        <label for="edit_id_produk">Id Produk</label>
                                        <select class="form-control border-primary" wire:model="edit_id_produk" required>
                                            @foreach ($penerimaan_ikan as $ikan)
                                                <option value="{{ $ikan->id }}">tanggal: {{ $ikan->tgl_penerimaan }} - berat: 
                                                    {{ $ikan->berat_ikan }} - grade: {{ $ikan->grade->grade }} - supplier: 
                                                    {{ $ikan->supplier->nama_supplier }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                
                                    <div class="form-group">
                                        <label for="edit_tgl_cutting">Tgl Cutting</label>
                                        <input type="date" class="form-control border-primary" wire:model="edit_tgl_cutting" required>
                                    </div>
                
                                    <button data-bs-dismiss="modal" wire:click="updateCutting" type="submit" class="btn btn-primary ms-1">
                                        Update
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                

                    <!-- Modal Hapus Cutting -->
                    <div class="modal fade" id="hapusCuttingModal{{ $item->id }}" tabindex="-1"
                        aria-labelledby="hapusCuttingModalTitle{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="hapusCuttingModalTitle{{ $item->id }}">Hapus Cutting</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menghapus cutting ini?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-danger" wire:click="delete({{ $item->id }})"
                                        data-bs-dismiss="modal">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @php
                    $dataCollection = collect($cuttings);
                    $total13 = $dataCollection->where('kategori_berat.kategori_berat', '1/3')->sum('berat_produk');
                    $total15 = $dataCollection->where('kategori_berat.kategori_berat', '3/5')->sum('berat_produk');
                    $total5 = $dataCollection->where('kategori_berat.kategori_berat', '5 UP')->sum('berat_produk');
                @endphp

                <tr>
                    <td colspan="1">Total</td>
                    <td>{{ $total13 }}</td>
                    <td>{{ $total15 }}</td>
                    <td>{{ $total5 }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
