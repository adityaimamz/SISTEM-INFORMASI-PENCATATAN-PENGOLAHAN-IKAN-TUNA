<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="selectedDate">Date</label>
            <input type="date" id="selectedDate" wire:model="selectedDate" wire:change="filterData" class="form-control">
        </div>
    </div>

    <div class="mb-3">
        @if($selectedDate)
            <a href="{{ route('packing.pdf', ['date' => $selectedDate]) }}" class="btn btn-primary">Export PDF</a>
        @else
            <button class="btn btn-primary" disabled>Export PDF</button>
        @endif
    </div>

    <div class="table-responsive">
        <table class="table" id="table1">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Box</th>
                    <th>Buyer</th>
                    <th>Produk</th>
                    <th>pcs</th>
                    <th>Berat</th>
                    <th>Kode Trace</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->no_box }}</td>
                        <td>{{ $item->buyer }}</td>
                        <td>{{ $item->service->ikan->jenis_ikan }}</td>
                        <td>{{ $item->pcs }}</td>
                        <td>{{ $item->berat }}</td>
                        <td>{{ $item->service->kode_trace->kode_trace }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal"
                                data-bs-target="#editPackingModal{{ $item->id }}">
                                Edit Packing
                            </button>
                            <button type="button" class="btn btn-outline-danger block" data-bs-toggle="modal"
                                data-bs-target="#hapusPackingModal{{ $item->id }}">
                                Hapus Packing
                            </button>
                        </td>
                    </tr>
                    <!-- Modal Edit Packing -->
                    <div class="modal fade" id="editPackingModal{{ $item->id }}" tabindex="-1"
                        role="dialog" aria-labelledby="editPackingModalTitle{{ $item->id }}"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPackingModalTitle{{ $item->id }}">Edit Packing
                                    </h5>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST"
                                        action="{{ route('packing.update', $item->id) }}"
                                        enctype="multipart/form-data" class="mt-0">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="kode_trace">Kode Lot</label>
                                            <select name="kode_trace" class="form-control border-primary" required>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}"
                                                        {{ $service->id == $item->kode_trace ? 'selected' : '' }}>
                                                        {{ $service->kode_trace }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tgl_packing">Tanggal Packing</label>
                                            <input type="date" name="tgl_packing"
                                                class="form-control border-primary"
                                                value="{{ $item->tgl_packing }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary ms-1">
                                            <span class="d-none d-sm-block">Update</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Hapus Packing -->
                    <div class="modal fade" id="hapusPackingModal{{ $item->id }}"
                        tabindex="-1" role="dialog"
                        aria-labelledby="hapusPackingModalTitle{{ $item->id }}"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="hapusPackingModalTitle{{ $item->id }}">Hapus
                                        Packing</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menghapus packing ini?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary"
                                        data-bs-dismiss="modal">
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <form method="POST"
                                        action="{{ route('packing.destroy', $item->id) }}"
                                        class="d-inline">
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
