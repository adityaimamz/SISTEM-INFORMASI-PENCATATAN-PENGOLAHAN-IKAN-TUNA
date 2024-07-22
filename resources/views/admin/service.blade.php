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
                        <h3>Data Service dan Detail Produk</h3>
                        <p class="text-subtitle text-muted">Silahkan kelola data service dan detail produk</p>
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
                            Tambah Service
                        </h5>
                        <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#tambahServiceModal">
                            Tambah Service
                        </button>
                        
                        <!-- Vertically Centered modal Modal -->
<!-- Vertically Centered modal Modal -->
                        <div class="modal fade" id="tambahServiceModal" tabindex="-1" role="dialog" aria-labelledby="tambahServiceModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tambahServiceModalTitle">Tambah Service</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('service.store') }}" enctype="multipart/form-data" class="mt-0">
                                            @csrf
                                            <div class="form-group">
                                                <label for="kode_trace">Kode Trace</label>
                                                <input type="text" name="kode_trace" class="form-control border-primary" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="no_batch">No Batch</label>
                                                <select name="no_batch" class="form-control border-primary" required>
                                                    @foreach ($cuttings as $cutting)
                                                        <option value="{{ $cutting->no_batch }}">{{ $cutting->nama_produk }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="id_detail">Detail Produk</label>
                                                <select name="id_detail" class="form-control border-primary" required>
                                                    @foreach ($detailproduk as $detail_produk)
                                                        <option value="{{ $detail_produk->id }}">{{ $detail_produk->nama_produk }}</option>
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
                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk Cutting</th>
                                        <th>Nama Detail Produk</th>
                                        <th>Grade</th>
                                        <th>Berat Produk</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->cutting->nama_produk }}</td>
                                            <td>{{ $item->detail->nama_produk }}</td>
                                            <td>{{ $item->cutting->penerimaan_ikan->ikan->kategori->grade }}</td>
                                            <td>{{ $item->cutting->berat_produk }}</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#editServiceModal{{ $item->kode_trace }}">
                                                    Edit Service
                                                </button>
                                                <button type="button" class="btn btn-outline-danger block" data-bs-toggle="modal" data-bs-target="#hapusServiceModal{{ $item->kode_trace }}">
                                                    Hapus Service
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit Service -->
                                        <div class="modal fade" id="editServiceModal{{ $item->kode_trace }}" tabindex="-1" role="dialog" aria-labelledby="editServiceModalTitle{{ $item->kode_trace }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editServiceModalTitle{{ $item->kode_trace }}">Edit Service</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('service.update', $item->kode_trace) }}" enctype="multipart/form-data" class="mt-0">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="no_batch">No Batch</label>
                                                                <select name="no_batch" class="form-control border-primary" required>
                                                                    @foreach ($cuttings as $cutting)
                                                                        <option value="{{ $cutting->no_batch }}" {{ $cutting->no_batch == $item->no_batch ? 'selected' : '' }}>{{ $cutting->no_batch }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="id_detail">Detail Produk</label>
                                                                <select name="id_detail" class="form-control border-primary" required>
                                                                    @foreach ($detailproduk as $detail_produk)
                                                                        <option value="{{ $detail_produk->id }}" {{ $detail_produk->id == $item->id_detail ? 'selected' : '' }}>{{ $detail_produk->nama_produk }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary ms-1">
                                                                <span class="d-none d-sm-block">Update</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <!-- Modal Hapus Service -->
                                        <div class="modal fade" id="hapusServiceModal{{ $item->kode_trace }}" tabindex="-1" role="dialog" aria-labelledby="hapusServiceModalTitle{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="hapusServiceModalTitle{{ $item->kode_trace }}">Hapus Service</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus service ini?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                        <form method="POST" action="{{ route('service.destroy', $item->kode_trace) }}" class="d-inline">
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

                            <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Tambah Detail Produk
                        </h5>
                        <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal"
                            data-bs-target="#tambahDetailProdukModal">
                            Tambah Detail Produk
                        </button>

                        <!-- Vertically Centered modal Modal -->
                        <div class="modal fade" id="tambahDetailProdukModal" tabindex="-1" role="dialog"
                            aria-labelledby="tambahDetailProdukModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tambahDetailProdukModalTitle">Tambah Detail Produk
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('detailproduk.store') }}"
                                            enctype="multipart/form-data" class="mt-0">
                                            @csrf
                                            <div class="form-group">
                                                <label for="nama_produk">Nama Produk</label>
                                                <input type="text" name="nama_produk"
                                                    class="form-control border-primary" required>
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
                                        <th>Nama Produk</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detailproduk as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama_produk }}</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary block"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editDetailProdukModal{{ $item->id }}">
                                                    Edit Detail Produk
                                                </button>
                                                <button type="button" class="btn btn-outline-danger block"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#hapusDetailProdukModal{{ $item->id }}">
                                                    Hapus Detail Produk
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit Detail Produk -->
                                        <div class="modal fade" id="editDetailProdukModal{{ $item->id }}"
                                            tabindex="-1" role="dialog"
                                            aria-labelledby="editDetailProdukModalTitle{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editDetailProdukModalTitle{{ $item->id }}">Edit Detail
                                                            Produk
                                                        </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="{{ route('detailproduk.update', $item->id) }}"
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

                                        <!-- Modal Hapus Detail Produk -->
                                        <div class="modal fade" id="hapusDetailProdukModal{{ $item->id }}"
                                            tabindex="-1" role="dialog"
                                            aria-labelledby="hapusDetailProdukModalTitle{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="hapusDetailProdukModalTitle{{ $item->id }}">Hapus
                                                            Detail Produk
                                                        </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus detail produk ini?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary"
                                                            data-bs-dismiss="modal">
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                        <form method="POST"
                                                            action="{{ route('detailproduk.destroy', $item->id) }}"
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
