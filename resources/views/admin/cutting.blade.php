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
                        <h3>Data Cutting dan Detail Produk</h3>
                        <p class="text-subtitle text-muted">Silahkan kelola data cutting dan detail produk</p>
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

                        <!-- Vertically Centered modal Modal -->
                        <div class="modal fade" id="tambahCuttingModal" tabindex="-1" role="dialog"
                            aria-labelledby="tambahCuttingModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tambahCuttingModalTitle">Tambah Cutting</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('cutting.store') }}"
                                            enctype="multipart/form-data" class="mt-0">
                                            @csrf
                                            <div class="form-group">
                                                <label for="berat_produk">Berat Produk</label>
                                                <input type="text" name="berat_produk"
                                                    class="form-control border-primary" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_produk">Nama Produk</label>
                                                <input type="text" name="nama_produk" class="form-control border-primary"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_produk">Id Produk</label>
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
                                        <th>Id Produk</th>
                                        <th>Berat Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cutting as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->id_produk }}</td>
                                            <td>{{ $item->berat_produk }}</td>
                                            <td>{{ $item->nama_produk }}</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary block"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editCuttingModal{{ $item->id }}">
                                                    Edit Cutting
                                                </button>
                                                <button type="button" class="btn btn-outline-danger block"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#hapusCuttingModal{{ $item->id }}">
                                                    Hapus Cutting
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit Cutting -->
                                        <div class="modal fade" id="editCuttingModal{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="editCuttingModalTitle{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editCuttingModalTitle{{ $item->id }}">
                                                            Edit Cutting</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="{{ route('cutting.update', $item->id) }}"
                                                            enctype="multipart/form-data" class="mt-0">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="id_produk">Id Produk</label>
                                                                <input type="text" name="id_produk"
                                                                    class="form-control border-primary"
                                                                    value="{{ $item->id_produk }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="berat_produk">Berat Produk</label>
                                                                <input type="text" name="berat_produk"
                                                                    class="form-control border-primary"
                                                                    value="{{ $item->berat_produk }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nama_produk">Nama Produk</label>
                                                                <input type="text" name="nama_produk"
                                                                    class="form-control border-primary"
                                                                    value="{{ $item->nama_produk }}" required>
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
                                        <div class="modal fade" id="hapusCuttingModal{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="hapusCuttingModalTitle{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="hapusCuttingModalTitle{{ $item->id }}">Hapus Cutting
                                                        </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus cutting ini?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary"
                                                            data-bs-dismiss="modal">
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                        <form method="POST"
                                                            action="{{ route('cutting.destroy', $item->id) }}"
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
                </div>
            </section>
            <!-- Basic Tables end -->

        </div>

    </div>
@endsection
