@extends('layouts.app')

@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Data Penerimaan Ikan</h3>
                        <p class="text-subtitle text-muted">Silahkan kelola data penerimaan ikan</p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ Request::segment(1) }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Tambah Penerimaan Ikan
                        </h5>
                        <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#tambahPenerimaanModal">
                            Tambah Penerimaan
                        </button>
                        <!-- Vertically Centered modal Modal -->
                        <div class="modal fade" id="tambahPenerimaanModal" tabindex="-1" role="dialog" aria-labelledby="tambahPenerimaanModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tambahPenerimaanModalTitle">Tambah Penerimaan</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('penerimaan_ikan.store') }}" enctype="multipart/form-data" class="mt-0">
                                            @csrf
                                            <div class="form-group">
                                                <label for="supplier_id">Supplier</label>
                                                <select name="supplier_id" class="form-control border-primary" required>
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="ikan_id">Ikan</label>
                                                <select name="ikan_id" id="ikan_id" class="form-control border-primary" required>
                                                    <option value="" selected disabled>Pilih Ikan</option>
                                                    @foreach ($ikans as $ikan)
                                                        <option value="{{ $ikan->id }}">{{ $ikan->jenis_ikan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="grade">Grade</label>
                                                <input type="text" name="grade" id="grade" class="form-control border-primary" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="berat_ikan">Berat Ikan</label>
                                                <input type="text" name="berat_ikan" id="berat_ikan" step="0.01" class="form-control border-primary" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tgl_penerimaan">Tanggal Penerimaan</label>
                                                <input type="date" name="tgl_penerimaan" class="form-control border-primary" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary ms-1">
                                                <span class="d-none d-sm-block">Submit</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Supplier</th>
                                        <th>Ikan</th>
                                        <th>Tanggal Penerimaan</th>
                                        <th>Berat Ikan (KG)</th>
                                        <th>Grade</th>
                                        <th>Kategori</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->supplier->nama_supplier }}</td>
                                            <td>{{ $item->kategori_ikan->jenis_ikan }}</td>
                                            <td>{{ $item->tgl_penerimaan }}</td>
                                            <td>{{ $item->berat_ikan }}</td>
                                            <td>{{ $item->kategori_ikan->grade }}</td>
                                            <td>{{ $item->kategori_ikan->kategori }}</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#editPenerimaanModal{{ $item->id }}">
                                                    Edit Penerimaan
                                                </button>
                                                <button type="button" class="btn btn-outline-danger block" data-bs-toggle="modal" data-bs-target="#hapusPenerimaanModal{{ $item->id }}">
                                                    Hapus Penerimaan
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit Penerimaan -->
                                        <div class="modal fade" id="editPenerimaanModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editPenerimaanModalTitle{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editPenerimaanModalTitle{{ $item->id }}">Edit Penerimaan</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('penerimaan_ikan.update', $item->id) }}" enctype="multipart/form-data" class="mt-0">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="supplier_id">Supplier</label>
                                                                <select name="supplier_id" class="form-control border-primary" required>
                                                                    @foreach ($suppliers as $supplier)
                                                                        <option value="{{ $supplier->id }}" {{ $supplier->id == $item->supplier_id ? 'selected' : '' }}>{{ $supplier->nama_supplier }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ikan_id">Ikan</label>
                                                                <select name="ikan_id" class="form-control border-primary" required>
                                                                    @foreach ($ikans as $ikan)
                                                                        <option value="{{ $ikan->id }}" {{ $ikan->id == $item->ikan_id ? 'selected' : '' }}>{{ $ikan->jenis_ikan }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tgl_penerimaan">Tanggal Penerimaan</label>
                                                                <input type="date" name="tgl_penerimaan" class="form-control border-primary" value="{{ $item->tgl_penerimaan }}" required>
                                                            </div>
                                                            <div class="form-group"></div>
                                                                <label for="berat_ikan">Berat Ikan</label>
                                                                <input type="text" name="berat_ikan" step="0.01" class="form-control border-primary" value="{{ $item->berat_ikan }}" required>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary ms-1">
                                                                <span class="d-none d-sm-block">Update</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <!-- Modal Hapus Penerimaan -->
                                        <div class="modal fade" id="hapusPenerimaanModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="hapusPenerimaanModalTitle{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="hapusPenerimaanModalTitle{{ $item->id }}">Hapus Penerimaan</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus penerimaan ini?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                        <form method="POST" action="{{ route('penerimaan_ikan.destroy', $item->id) }}" class="d-inline">
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
                </div>

            </section>
            <!-- Basic Tables end -->

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ikanSelect = document.getElementById('ikan_id');
            const gradeInput = document.getElementById('grade');

            ikanSelect.addEventListener('change', function () {
                const ikanId = this.value;

                if (ikanId) {
                    fetch(`/get-grade/${ikanId}`)
                        .then(response => response.json())
                        .then(data => {
                            gradeInput.value = data.grade;
                        })
                        .catch(error => console.error('Error fetching grade:', error));
                } else {
                    gradeInput.value = '';
                }
            });
        });
    </script>
@endsection
