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
                                                <label for="no_batch_id">No Batch</label>
                                                <select name="no_batch_id" id="no_batch_id" class="form-control border-primary">
                                                    <option value="" selected disabled>Pilih No Batch</option>
                                                    @foreach ($no_batch as $item)
                                                        <option value="{{ $item->id }}">{{ $item->no_batch }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="form-group">
                                                <label for="berat_produk">Berat Produk</label>
                                                <input type="number" name="berat_produk"
                                                    class="form-control border-primary" step="0.01" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="id_produk">Id Produk</label>
                                                <select name="id_produk" id="id_produk" class="form-control border-primary"
                                                    required>
                                                    <option value="" selected disabled>Pilih Penerimaan Ikan</option>
                                                    @foreach ($penerimaan_ikan as $kan)
                                                        <option value="{{ $kan->id }}">tanggal:
                                                            {{ $kan->tgl_penerimaan }} berat : {{ $kan->berat_ikan }} grade:
                                                            {{ $kan->grade->grade }} supplier:
                                                            {{ $kan->supplier->nama_supplier }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="kategori_berat_id">Kategori Berat</label>
                                                <select name="kategori_berat_id" id="kategori_berat_id"
                                                    class="form-control border-primary" required>
                                                    <option value="" selected disabled>Pilih Kategori Berat</option>
                                                    @foreach ($kategori_berat_cuttings as $kan)
                                                        <option value="{{ $kan->id }}">{{ $kan->kategori_berat }}
                                                        </option>
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
                        <livewire:cutting-filter />
                    </div>
                </div>
            </section>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Data No Batch
                    </h5>
                    <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal"
                        data-bs-target="#tambahNoBatchModal">
                        Tambah No Batch
                    </button>

                    <!-- Vertically Centered modal Modal -->
                    <div class="modal fade" id="tambahNoBatchModal" tabindex="-1" role="dialog"
                        aria-labelledby="tambahNoBatchModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="tambahNoBatchModalTitle">Tambah No Batch
                                    </h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('no_batch.store') }}"
                                        enctype="multipart/form-data" class="mt-0">
                                        @csrf
                                        <div class="form-group">
                                            <label for="no_batch">No Batch</label>
                                            <input type="text" name="no_batch" class="form-control border-primary"
                                                required>
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
                        <table class="table" id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Batch</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($no_batch as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->no_batch }}</td>
                                        <td>
                                            <button type="button" class="btn btn-outline-primary block"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editNoBatchModal{{ $item->id }}">
                                                Edit No Batch
                                            </button>
                                            <button type="button" class="btn btn-outline-danger block"
                                                data-bs-toggle="modal"
                                                data-bs-target="#hapusNoBatchModal{{ $item->id }}">
                                                Hapus No Batch
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Modal Edit No Batch -->
                                    <div class="modal fade" id="editNoBatchModal{{ $item->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="editNoBatchModalTitle{{ $item->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editNoBatchModalTitle{{ $item->id }}">Edit No Batch
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST"
                                                        action="{{ route('no_batch.update', $item->id) }}"
                                                        enctype="multipart/form-data" class="mt-0">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="no_batch">No Batch</label>
                                                            <input type="text" name="no_batch"
                                                                class="form-control border-primary"
                                                                value="{{ $item->no_batch }}" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary ms-1">
                                                            <span class="d-none d-sm-block">Update</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Hapus No Batch -->
                                    <div class="modal fade" id="hapusNoBatchModal{{ $item->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="hapusNoBatchModalTitle{{ $item->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="hapusNoBatchModalTitle{{ $item->id }}">Hapus No Batch
                                                    </h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menghapus no batch ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <span class="d-none d-sm-block">Close</span>
                                                    </button>
                                                    <form method="POST"
                                                        action="{{ route('no_batch.destroy', $item->id) }}"
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
        </div>
    </div>
@endsection
