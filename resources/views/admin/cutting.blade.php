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
                        <h3>Data Cutting</h3>
                        <p class="text-subtitle text-muted">Silahkan kelola data cutting</p>
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
                            Tambah Cutting
                        </h5>
                        <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal"
                            data-bs-target="#tambahCuttingModal">
                            Tambah Cutting
                        </button>

                        <div class="modal fade" id="tambahCuttingModal" tabindex="-1" role="dialog" aria-labelledby="tambahCuttingModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tambahCuttingModalTitle">Tambah Cutting</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('cutting.store') }}" enctype="multipart/form-data" class="mt-0">
                                            @csrf
                                            <div class="form-group">
                                                <label for="no_batch">No Batch</label>
                                                <input type="number" name="no_batch" class="form-control border-primary" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="berat_produk">Berat Produk</label>
                                                <input type="number" name="berat_produk" class="form-control border-primary" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_produk">Nama Produk</label>
                                                <input type="text" name="nama_produk" class="form-control border-primary" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="id_produk">Id Produk</label>
                                                <select name="id_produk" class="form-control border-primary" required>
                                                    @foreach ($penerimaan_ikan as $kan)
                                                        <option value="{{ $kan->id }}">{{ $kan->id }}</option>
                                                    @endforeach
                                                </select>
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="table2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Batch</th>
                                        <th>Id Produk</th>
                                        <th>Berat Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Grade</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cutting as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->no_batch }}</td>
                                            <td>{{ $item->id_produk }}</td>
                                            <td>{{ $item->berat_produk }}</td>
                                            <td>{{ $item->nama_produk }}</td>
                                            <td>{{ $item->penerimaan_ikan->ikan->kategori->grade }}</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#editCuttingModal{{ $item->no_batch }}">
                                                    Edit Cutting
                                                </button>
                                                <button type="button" class="btn btn-outline-danger block" data-bs-toggle="modal" data-bs-target="#hapusCuttingModal{{ $item->no_batch }}">
                                                    Hapus Cutting
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit Cutting -->
                                        <div class="modal fade" id="editCuttingModal{{ $item->no_batch }}" tabindex="-1" role="dialog" aria-labelledby="editCuttingModalTitle{{ $item->no_batch }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editCuttingModalTitle{{ $item->no_batch }}">Edit Cutting</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('cutting.update', $item->no_batch) }}" enctype="multipart/form-data" class="mt-0">
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
                                                                <input type="number" name="berat_produk" class="form-control border-primary" value="{{ $item->berat_produk }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nama_produk">Nama Produk</label>
                                                                <input type="text" name="nama_produk" class="form-control border-primary" value="{{ $item->nama_produk }}" required>
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
                                        <div class="modal fade" id="hapusCuttingModal{{ $item->no_batch }}" tabindex="-1" role="dialog" aria-labelledby="hapusCuttingModalTitle{{ $item->no_batch }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
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
                                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                        <form method="POST" action="{{ route('cutting.destroy', $item->no_batch) }}" class="d-inline">
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

                <!-- Tabel Total Berat Per Grade -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title">Total Berat Per Grade</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Grade</th>
                                        <th>Total Berat (kg)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($totalBeratPerGrade as $grade)
                                        <tr>
                                            <td>{{ $grade->grade }}</td>
                                            <td>{{ $grade->total_berat }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
