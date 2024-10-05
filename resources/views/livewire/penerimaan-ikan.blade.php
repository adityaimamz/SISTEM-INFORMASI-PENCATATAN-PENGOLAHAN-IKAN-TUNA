<div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="date">Tanggal</label>
            <input type="date" id="date" class="form-control" wire:model="date" wire:change="filterData">
        </div>
        <div class="col-md-6">
            <label for="supplier">Supplier</label>
            <select id="supplier" wire:model="supplier" class="form-control" wire:change="filterData">
                <option value="">Pilih Supplier</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mb-3">
        <a href="{{ route('ikan.pdf', ['date' => $date, 'supplier' => $supplier]) }}" class="btn btn-primary">Export
            PDF</a>
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
        <table class="table table-bordered" id="table">
            <tr>
                <th rowspan="2">NO</th>
                <th colspan="4">10/19</th>
                <th colspan="4">20/29</th>
                <th colspan="4">30 UP</th>
                <th rowspan="2">Action</th>
            </tr>
            <tr>
                <th>AB</th>
                <th>C</th>
                <th>ABC</th>
                <th>Lokal</th>
                <th>AB</th>
                <th>C</th>
                <th>ABC</th>
                <th>Lokal</th>
                <th>AB</th>
                <th>C</th>
                <th>ABC</th>
                <th>Lokal</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->grade->grade == 'AB' && $item->kategori_berat_penerimaan->kategori_berat == '10-19' ? $item->berat_ikan : '' }}
                        </td>
                        <td>{{ $item->grade->grade == 'C' && $item->kategori_berat_penerimaan->kategori_berat == '10-19' ? $item->berat_ikan : '' }}
                        </td>
                        <td>{{ $item->grade->grade == 'ABC' && $item->kategori_berat_penerimaan->kategori_berat == '10-19' ? $item->berat_ikan : '' }}
                        </td>
                        <td>{{ $item->grade->grade == 'Lokal' && $item->kategori_berat_penerimaan->kategori_berat == '10-19' ? $item->berat_ikan : '' }}
                        </td>
                        <td>{{ $item->grade->grade == 'AB' && $item->kategori_berat_penerimaan->kategori_berat == '20-29' ? $item->berat_ikan : '' }}
                        </td>
                        <td>{{ $item->grade->grade == 'C' && $item->kategori_berat_penerimaan->kategori_berat == '20-29' ? $item->berat_ikan : '' }}
                        </td>
                        <td>{{ $item->grade->grade == 'ABC' && $item->kategori_berat_penerimaan->kategori_berat == '20-29' ? $item->berat_ikan : '' }}
                        </td>
                        <td>{{ $item->grade->grade == 'Lokal' && $item->kategori_berat_penerimaan->kategori_berat == '20-29' ? $item->berat_ikan : '' }}
                        </td>
                        <td>{{ $item->grade->grade == 'AB' && $item->kategori_berat_penerimaan->kategori_berat == '30 UP' ? $item->berat_ikan : '' }}
                        </td>
                        <td>{{ $item->grade->grade == 'C' && $item->kategori_berat_penerimaan->kategori_berat == '30 UP' ? $item->berat_ikan : '' }}
                        </td>
                        <td>{{ $item->grade->grade == 'ABC' && $item->kategori_berat_penerimaan->kategori_berat == '30 UP' ? $item->berat_ikan : '' }}
                        </td>
                        <td>{{ $item->grade->grade == 'Lokal' && $item->kategori_berat_penerimaan->kategori_berat == '30 UP' ? $item->berat_ikan : '' }}
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $item->id }}" wire:click="edit({{ $item->id }})">
                                Edit
                            </button>
                            <button type="button" class="btn btn-outline-danger block" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $item->id }}">
                                Hapus
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div wire:ignore.self class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                        role="dialog" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Penerimaan Ikan
                                    </h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form wire:submit.prevent="update">
                                        <div class="form-group">
                                            <label for="edit_supplier_id">Supplier</label>
                                            <select wire:model="edit_supplier_id" class="form-control border-primary"
                                                required>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->supplier_id }}">
                                                        {{ $supplier->nama_supplier }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_grade_id">Grade</label>
                                            <select wire:model="edit_grade_id" class="form-control border-primary"
                                                required>
                                                @foreach ($grades as $grade)
                                                    <option value="{{ $grade->id }}">
                                                        {{ $grade->grade }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_kategori_berat_id">Kategori Berat</label>
                                            <select wire:model="edit_kategori_berat_id"
                                                class="form-control border-primary" required>
                                                @foreach ($kategori_berat as $kategori)
                                                    <option value="{{ $kategori->id }}">
                                                        {{ $kategori->kategori_berat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_tgl_penerimaan">Tanggal Penerimaan</label>
                                            <input type="date" wire:model="edit_tgl_penerimaan"
                                                class="form-control border-primary" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_berat_ikan">Berat Ikan</label>
                                            <input type="number" wire:model="edit_berat_ikan" step="0.01"
                                                class="form-control border-primary" required>
                                        </div>
                                        <div class="form-group">
                                            <button data-bs-dismiss="modal" wire:click="update({{ $item->id }})" type="submit" class="btn btn-primary ms-1">
                                                Update
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Modal Delete -->
                    <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Hapus Penerimaan
                                        Ikan</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus data ini?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-danger"
                                        wire:click="delete({{ $item->id }})"
                                        data-bs-dismiss="modal">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @php
                    $dataCollection = collect($data);

                    $total_10up_ab = $dataCollection
                        ->where('grade.grade', 'AB')
                        ->where('kategori_berat_penerimaan.kategori_berat', '10-19')
                        ->sum('berat_ikan');
                    $total_10up_c = $dataCollection
                        ->where('grade.grade', 'C')
                        ->where('kategori_berat_penerimaan.kategori_berat', '10-19')
                        ->sum('berat_ikan');
                    $total_10up_abc = $dataCollection
                        ->where('grade.grade', 'ABC')
                        ->where('kategori_berat_penerimaan.kategori_berat', '10-19')
                        ->sum('berat_ikan');
                    $total_10up_lokal = $dataCollection
                        ->where('grade.grade', 'Lokal')
                        ->where('kategori_berat_penerimaan.kategori_berat', '10-19')
                        ->sum('berat_ikan');
                    $total_20up_ab = $dataCollection
                        ->where('grade.grade', 'AB')
                        ->where('kategori_berat_penerimaan.kategori_berat', '20-29')
                        ->sum('berat_ikan');
                    $total_20up_c = $dataCollection
                        ->where('grade.grade', 'C')
                        ->where('kategori_berat_penerimaan.kategori_berat', '20-29')
                        ->sum('berat_ikan');
                    $total_20up_abc = $dataCollection
                        ->where('grade.grade', 'ABC')
                        ->where('kategori_berat_penerimaan.kategori_berat', '20-29')
                        ->sum('berat_ikan');
                    $total_20up_lokal = $dataCollection
                        ->where('grade.grade', 'Lokal')
                        ->where('kategori_berat_penerimaan.kategori_berat', '20-29')
                        ->sum('berat_ikan');
                    $total_30up_ab = $dataCollection
                        ->where('grade.grade', 'AB')
                        ->where('kategori_berat_penerimaan.kategori_berat', '30 UP')
                        ->sum('berat_ikan');
                    $total_30up_c = $dataCollection
                        ->where('grade.grade', 'C')
                        ->where('kategori_berat_penerimaan.kategori_berat', '30 UP')
                        ->sum('berat_ikan');
                    $total_30up_abc = $dataCollection
                        ->where('grade.grade', 'ABC')
                        ->where('kategori_berat_penerimaan.kategori_berat', '30 UP')
                        ->sum('berat_ikan');
                    $total_30up_lokal = $dataCollection
                        ->where('grade.grade', 'Lokal')
                        ->where('kategori_berat_penerimaan.kategori_berat', '30 UP')
                        ->sum('berat_ikan');
                @endphp


                <tr>
                    <td colspan="1"><strong>Total</strong></td>
                    <td><strong>{{ $total_10up_ab }}</strong></td>
                    <td><strong>{{ $total_10up_c }}</strong></td>
                    <td><strong>{{ $total_10up_abc }}</strong></td>
                    <td><strong>{{ $total_10up_lokal }}</strong></td>
                    <td><strong>{{ $total_20up_ab }}</strong></td>
                    <td><strong>{{ $total_20up_c }}</strong></td>
                    <td><strong>{{ $total_20up_abc }}</strong></td>
                    <td><strong>{{ $total_20up_lokal }}</strong></td>
                    <td><strong>{{ $total_30up_ab }}</strong></td>
                    <td><strong>{{ $total_30up_c }}</strong></td>
                    <td><strong>{{ $total_30up_abc }}</strong></td>
                    <td><strong>{{ $total_30up_lokal }}</strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
