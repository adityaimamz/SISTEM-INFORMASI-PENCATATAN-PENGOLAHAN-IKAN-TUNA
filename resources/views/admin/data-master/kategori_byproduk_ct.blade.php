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
                        <h3>Data By Produk Cutting </h3>
                        <p class="text-subtitle text-muted">Silahkan kelola data By Produk Cutting</p>
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
                        <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal"
                            data-bs-target="#tambahByprodukCtModal">
                            Tambah Produk
                        </button>

                        <!-- Vertically Centered modal Modal -->
                        <div class="modal fade" id="tambahByprodukCtModal" tabindex="-1" role="dialog"
                            aria-labelledby="tambahByprodukCtModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tambahByprodukCtModalTitle">Tambah By Produk Cutting</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('kategori-byproduk-ct.store') }}"
                                            enctype="multipart/form-data" class="mt-0">
                                            @csrf
                                            <div class="form-group">
                                                <label for="nama_produk">Nama By Produk Cutting</label>
                                                <input type="text" name="nama_produk" class="form-control border-primary"
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
                            <table class="table" id="table2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kategori as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama_produk }}</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary block"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editByprodukCtModal{{ $item->id }}">
                                                    Edit Produk
                                                </button>
                                                <button type="button" class="btn btn-outline-danger block"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#hapusByprodukCtModal{{ $item->id }}">
                                                    Hapus Produk
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit By Produk -->
                                        <div class="modal fade" id="editByprodukCtModal{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="editByprodukCtModalTitle{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editByprodukCtModalTitle{{ $item->id }}">
                                                            Edit By Produk</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('kategori-byproduk-ct.update', ['kategori_byproduk_ct' => $item->kategori_byproduk_id]) }}"
                                                            enctype="multipart/form-data" class="mt-0">
                                                            @csrf
                                                            @method('PUT')
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

                                        <!-- Modal Hapus By Produk -->
                                        <div class="modal fade" id="hapusByprodukCtModal{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="hapusByprodukCtModalTitle{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="hapusByprodukCtModalTitle{{ $item->id }}">Hapus Produk</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus produk ini?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary"
                                                            data-bs-dismiss="modal">
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                        <form method="POST"
                                                            action="{{ route('kategori-byproduk-ct.destroy', ['kategori_byproduk_ct' => $item->kategori_byproduk_id]) }}"
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
