<div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="selectedDate">Date</label>
            <input type="date" id="selectedDate" wire:model="selectedDate" wire:change="filterData" class="form-control">
        </div>
    </div>
{{-- 
    <div class="mb-3">
        @if ($selectedDate)
            <a href="{{ route('packing.pdf', ['date' => $selectedDate]) }}" class="btn btn-primary">Export PDF</a>
        @else
            <button class="btn btn-primary" disabled>Export PDF</button>
        @endif
    </div> --}}

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
                    <th>No Box</th>
                    <th>Buyer</th>
                    <th>Produk</th>
                    <th>pcs</th>
                    <th>Berat (Kg)</th>
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
                                data-bs-target="#editPackingModal" wire:click="loadPackingForEdit({{ $item->id }})">
                                Edit Packing
                            </button>
                            <button type="button" class="btn btn-outline-danger block" data-bs-toggle="modal"
                                data-bs-target="#hapusPackingModal{{ $item->id }}">
                                Hapus Packing
                            </button>
                        </td>
                    </tr>
                    <!-- Modal Edit Packing -->
                    <div wire:ignore.self class="modal fade" id="editPackingModal" tabindex="-1" role="dialog"
                        aria-labelledby="editPackingModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPackingModalTitle">Edit Packing</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form wire:submit.prevent="updatePacking">
                                        @csrf
                                        <!-- No Box -->
                                        <div class="form-group">
                                            <label for="edit_no_box">No Box</label>
                                            <input type="text" wire:model="edit_no_box"
                                                class="form-control border-primary" required>
                                        </div>

                                        <!-- Kode Trace -->
                                        <div class="form-group">
                                            <label for="edit_kode_trace_id">Kode Trace</label>
                                            <select wire:model="edit_kode_trace_id" class="form-control border-primary"
                                                required>
                                                <option value="">Pilih Kode Trace</option>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}">
                                                        {{ $service->kode_trace->kode_trace }} -
                                                        {{ $service->ikan->jenis_ikan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Buyer -->
                                        <div class="form-group">
                                            <label for="edit_buyer">Buyer</label>
                                            <input type="text" wire:model="edit_buyer"
                                                class="form-control border-primary" required>
                                        </div>

                                        <!-- Berat -->
                                        {{-- <div class="form-group">
                                            <label for="edit_berat">Berat</label>
                                            <input type="number" wire:model="edit_berat"
                                                class="form-control border-primary" step="0.01" required>
                                        </div> --}}

                                        <!-- Pcs -->
                                        <div class="form-group">
                                            <label for="edit_pcs">Pcs</label>
                                            <input type="number" wire:model="edit_pcs"
                                                class="form-control border-primary" required>
                                        </div>

                                        <!-- Tanggal Packing -->
                                        <div class="form-group">
                                            <label for="edit_tgl_packing">Tanggal Packing</label>
                                            <input type="date" wire:model="edit_tgl_packing"
                                                class="form-control border-primary" required>
                                        </div>

                                        <!-- Submit Button -->
                                        <button type="submit" data-bs-dismiss="modal" wire:click="updatePacking({{ $item->id }})" class="btn btn-primary ms-1">
                                            <span class="d-none d-sm-block">Update</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Modal Hapus Packing -->
                    <div class="modal fade" id="hapusPackingModal{{ $item->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="hapusPackingModalTitle{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="hapusPackingModalTitle{{ $item->id }}">Hapus
                                        Packing</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menghapus packing ini?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <button type="button" class="btn btn-danger"
                                        wire:click="delete({{ $item->id }})"
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
