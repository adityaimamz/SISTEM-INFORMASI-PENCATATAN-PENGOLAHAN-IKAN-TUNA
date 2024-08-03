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

    <style>
        #table {
            border: 1.5px solid black;
        }

        #table th, #table td {
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
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCuttingModal{{ $item->no_batch }}">
                                Edit Cutting
                            </button>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#hapusCuttingModal{{ $item->no_batch }}">
                                Hapus Cutting
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Edit Cutting -->
                    <div class="modal fade" id="editCuttingModal{{ $item->no_batch }}" tabindex="-1" aria-labelledby="editCuttingModalTitle{{ $item->no_batch }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editCuttingModalTitle{{ $item->no_batch }}">Edit Cutting</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('cutting.update', $item->no_batch) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="no_batch">No Batch</label>
                                            <input type="text" name="no_batch" class="form-control border-primary" value="{{ $item->no_batch }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="id_produk">Id Produk</label>
                                            <input type="text" name="id_produk" class="form-control border-primary" value="{{ $item->id_produk }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="berat_produk">Berat Produk</label>
                                            <input type="number" name="berat_produk" class="form-control border-primary" step="0.01" value="{{ $item->berat_produk }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary ms-1">
                                            <span class="d-none d-sm-block">Update</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Hapus Cutting -->
                    <div class="modal fade" id="hapusCuttingModal{{ $item->no_batch }}" tabindex="-1" aria-labelledby="hapusCuttingModalTitle{{ $item->no_batch }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="hapusCuttingModalTitle{{ $item->no_batch }}">Hapus Cutting</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menghapus cutting ini?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-danger" wire:click="delete({{ $item->id }})" data-bs-dismiss="modal">Hapus</button>
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
