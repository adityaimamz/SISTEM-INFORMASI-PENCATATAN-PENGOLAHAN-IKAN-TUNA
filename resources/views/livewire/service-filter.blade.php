<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="kode_trace">Kode Trace</label>
            <select id="kode_trace" wire:model="kode_trace" wire:change="filterData" class="form-control">
                <option value="">Pilih Kode Trace</option>
                @foreach ($kode_traces as $kodeTrace)
                    <option value="{{ $kodeTrace->id }}">{{ $kodeTrace->kode_trace }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table" id="table1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>No Batch</th>
                    <th>Tanggal Service</th>
                    <th>KG</th>
                    <th>Pcs</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->ikan->jenis_ikan }}</td>
                        <td>{{ $item->cutting->no_batch->no_batch }}</td>
                        <td>{{ $item->tgl_service }}</td>
                        <td>{{ $item->kg }}</td>
                        <td>{{ $item->pcs }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $item->kode_trace }}">
                                Edit Service
                            </button>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#hapusServiceModal{{ $item->kode_trace }}">
                                Hapus Service
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Edit Service -->
                    <div class="modal fade" id="editServiceModal{{ $item->kode_trace }}" tabindex="-1" role="dialog" aria-labelledby="editServiceModalTitle{{ $item->kode_trace }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editServiceModalTitle{{ $item->kode_trace }}">Edit Service</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('service.update', $item->kode_trace) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="kode_trace">Kode Trace</label>
                                            <input type="text" name="kode_trace" class="form-control border-primary" value="{{ $item->kode_trace }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="no_batch">No Batch</label>
                                            <select name="no_batch" class="form-control border-primary" required>
                                                @foreach ($cuttings as $cutting)
                                                    <option value="{{ $cutting->no_batch }}" {{ $cutting->no_batch == $item->no_batch ? 'selected' : '' }}>
                                                        {{ $cutting->no_batch }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="id_ikan">Produk</label>
                                            <select name="id_ikan" class="form-control border-primary" required>
                                                @foreach ($kategori_ikan as $ikan)
                                                    <option value="{{ $ikan->id }}" {{ $ikan->id == $item->id_ikan ? 'selected' : '' }}>
                                                        {{ $ikan->jenis_ikan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="berat_produk">Berat Produk (KG)</label>
                                            <input type="number" name="kg" class="form-control border-primary" step="0.01" value="{{ $item->kg }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="pcs">Pcs</label>
                                            <input type="number" name="pcs" class="form-control border-primary" value="{{ $item->pcs }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="tgl_service">Tgl Service</label>
                                            <input type="date" name="tgl_service" class="form-control border-primary" value="{{ $item->tgl_service }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary ms-1">
                                            <span class="d-none d-sm-block">Update</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Hapus Service -->
                    <div class="modal fade" id="hapusServiceModal{{ $item->kode_trace }}" tabindex="-1" role="dialog" aria-labelledby="hapusServiceModalTitle{{ $item->kode_trace }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="hapusServiceModalTitle{{ $item->kode_trace }}">Hapus Service</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menghapus service ini?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <form method="POST" action="{{ route('service.destroy', $item->kode_trace) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger ms-1">
                                            <span class="d-none d-sm-block">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
