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

    <div class="mb-3">
        @if ($kode_trace)
            <a href="{{ route('service.pdf', ['kode_trace' => $kode_trace]) }}" class="btn btn-primary">Export PDF</a>
        @else
            <button class="btn btn-primary" disabled>Export PDF</button>
        @endif
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
                        <td>{{ $item->no_batch->no_batch }}</td>
                        <td>{{ $item->tgl_service }}</td>
                        <td>{{ $item->kg }}</td>
                        <td>{{ $item->pcs }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#editServiceModal" wire:click="loadServiceForEdit({{ $item->id }})">
                                Edit Service
                            </button>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#hapusServiceModal{{ $item->id }}">
                                Hapus Service
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Edit Service -->
                    <div wire:ignore.self class="modal fade" id="editServiceModal" tabindex="-1" role="dialog"
                        aria-labelledby="editServiceModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editServiceModalTitle">Edit Service</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form wire:submit.prevent="updateService">
                                        <div class="form-group">
                                            <label for="edit_kode_trace">Kode Trace</label>
                                            <select wire:model="edit_kode_trace" class="form-control border-primary" required>
                                                @foreach ($kode_traces as $kode_trace)
                                                    <option value="{{ $kode_trace->id }}">{{ $kode_trace->kode_trace }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_no_batch_id">No Batch</label>
                                            <select wire:model="edit_no_batch_id" class="form-control border-primary" required>
                                                @foreach ($cuttings as $cutting)
                                                    <option value="{{ $cutting->no_batch }}">{{ $cutting->no_batch->id }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_id_ikan">Produk</label>
                                            <select wire:model="edit_id_ikan" class="form-control border-primary" required>
                                                @foreach ($Kategori_produk as $ikan)
                                                    <option value="{{ $ikan->id }}">{{ $ikan->jenis_ikan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_kg">Berat Produk (KG)</label>
                                            <input type="number" wire:model="edit_kg" class="form-control border-primary" step="0.01" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_pcs">Pcs</label>
                                            <input type="number" wire:model="edit_pcs" class="form-control border-primary" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_tgl_service">Tgl Service</label>
                                            <input type="date" wire:model="edit_tgl_service" class="form-control border-primary" required>
                                        </div>
                                        <button type="submit" data-bs-dismiss="modal" wire:click="updateService({{ $item->id }})" class="btn btn-primary ms-1">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Hapus Service -->
                    <div class="modal fade" id="hapusServiceModal{{ $item->id }}" tabindex="-1"
                        aria-labelledby="hapusServiceModalTitle{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="hapusServiceModalTitle{{ $item->id }}">Hapus Service</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menghapus service ini?</p>
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
            </tbody>
        </table>
    </div>
</div>
