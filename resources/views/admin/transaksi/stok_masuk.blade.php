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
                        <h3>Data Produk Masuk</h3>
                        <p class="text-subtitle text-muted">Silahkan kelola data produk masuk</p>
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
                            Tambah Produk Masuk
                        </h5>
                        <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal"
                            data-bs-target="#tambahProdukMasukModal">
                            Tambah Produk Masuk
                        </button>

                        <div class="modal fade" id="tambahProdukMasukModal" tabindex="-1" role="dialog" aria-labelledby="tambahProdukMasukModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tambahProdukMasukModalTitle">Tambah Produk Masuk</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('produk-masuk.store') }}" enctype="multipart/form-data" class="mt-0">
                                            @csrf
                                            <div class="form-group">
                                                <label for="no_box ">No Box</label>
                                                <select name="no_box" class="form-control border-primary" required>
                                                    @foreach ($packing as $data)
                                                        <option value="{{ $data->no_box }}">{{ $data->no_box }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="stok_masuk">Stok Masuk</label>
                                                <input type="number" name="stok_masuk" class="form-control border-primary" required>
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
                                        <th>No Box</th>
                                        <th>Stok Masuk</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produkMasuk as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->no_box }}</td>
                                            <td>{{ $item->stok_masuk }}</td>
                                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#editProdukMasukModal{{ $item->id }}">
                                                    Edit Produk Masuk
                                                </button>
                                                <button type="button" class="btn btn-outline-danger block" data-bs-toggle="modal" data-bs-target="#hapusProdukMasukModal{{ $item->id }}">
                                                    Hapus Produk Masuk
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit Produk Masuk -->
                                        <div class="modal fade" id="editProdukMasukModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editProdukMasukModalTitle{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editProdukMasukModalTitle{{ $item->id }}">Edit Produk Masuk</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('produk-masuk.update', $item->id) }}" enctype="multipart/form-data" class="mt-0">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="no_box">No Box</label>
                                                                <select name="no_box" class="form-control border-primary" required>
                                                                    @foreach ($packing as $data)
                                                                        <option value="{{ $data->no_box }}" {{ $data->no_box == $item->no_box ? 'selected' : '' }}>{{ $data->no_box }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="stok_masuk">Stok Masuk</label>
                                                                <input type="number" name="stok_masuk" class="form-control border-primary" value="{{ $item->stok_masuk }}" required>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary ms-1">
                                                                <span class="d-none d-sm-block">Update</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Hapus Produk Masuk -->
                                        <div class="modal fade" id="hapusProdukMasukModal{{ $item->id}}" tabindex="-1" role="dialog" aria-labelledby="hapusProdukMasukModalTitle{{ $item->id}}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="hapusProdukMasukModalTitle{{ $item->id}}">Hapus Produk Masuk</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus produk masuk ini?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                        <form method="POST" action="{{ route('produk-masuk.destroy', $item->id) }}" class="d-inline">
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

                <!-- Tabel Total Stok -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title">Stok Produksi</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Total Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $totalStok }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
