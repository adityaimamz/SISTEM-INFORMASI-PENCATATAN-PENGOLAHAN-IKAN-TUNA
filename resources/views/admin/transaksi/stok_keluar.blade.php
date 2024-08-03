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
                        <h3>Data Produk Keluar</h3>
                        <p class="text-subtitle text-muted">Silahkan kelola data produk keluar</p>
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
                            Tambah Produk Keluar
                        </h5>
                        <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal"
                            data-bs-target="#tambahProdukKeluarModal">
                            Tambah Produk Keluar
                        </button>

                        <div class="modal fade" id="tambahProdukKeluarModal" tabindex="-1" role="dialog" aria-labelledby="tambahProdukKeluarModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tambahProdukKeluarModalTitle">Tambah Produk Keluar</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('produk-keluar.store') }}" enctype="multipart/form-data" class="mt-0">
                                            @csrf
                                            <div class="form-group">
                                                <label for="kode_trace">Kode Trace</label>
                                                <select name="kode_trace_id" class="form-control border-primary" required>
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}">
                                                            {{ $service->kode_trace->kode_trace }} {{ $service->ikan->jenis_ikan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="jumlah_produk">pcs</label>
                                                <input type="number" name="pcs" class="form-control border-primary" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="no_seal">No Seal</label>
                                                <input type="number" name="no_seal" class="form-control border-primary" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="no_container">No Container</label>
                                                <input type="number" name="no_container" class="form-control border-primary" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tgl_keluar">Tanggal Keluar</label>
                                                <input type="date" name="tgl_keluar" class="form-control border-primary" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tgl_berangkat">Tanggal Berangkat</label>
                                                <input type="date" name="tgl_berangkat" class="form-control border-primary" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tgl_tiba">Tanggal Tiba</label>
                                                <input type="date" name="tgl_tiba" class="form-control border-primary" required>
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
                        <a href={{ route('stok-keluar.pdf') }} class="btn btn-primary">Export</a>
                        <div class="table-responsive">
                            <table class="table" id="table2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Pcs</th>
                                        <th>No Seal</th>
                                        <th>No Container</th>
                                        <th>Tanggal Keluar</th>
                                        <th>Tanggal Berangkat</th>
                                        <th>Tanggal Tiba</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produkKeluar as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->service->ikan->jenis_ikan }}</td>
                                            <td>{{ $item->pcs }}</td>
                                            <td>{{ $item->no_seal }}</td>
                                            <td>{{ $item->no_container }}</td>
                                            <td>{{ $item->tgl_keluar }}</td>
                                            <td>{{ $item->tgl_berangkat }}</td>
                                            <td>{{ $item->tgl_tiba }}</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#editProdukKeluarModal{{ $item->id }}">
                                                    Edit Produk Keluar
                                                </button>
                                                <button type="button" class="btn btn-outline-danger block" data-bs-toggle="modal" data-bs-target="#hapusProdukKeluarModal{{ $item->id }}">
                                                    Hapus Produk Keluar
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit Produk Keluar -->
                                        <div class="modal fade" id="editProdukKeluarModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editProdukKeluarModalTitle{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editProdukKeluarModalTitle{{ $item->id }}">Edit Produk Keluar</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('produk-keluar.update', $item->id) }}" enctype="multipart/form-data" class="mt-0">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="kode_trace">Kode Trace</label>
                                                                <select name="kode_trace_id" class="form-control border-primary" required>
                                                                    @foreach ($services as $service)
                                                                        <option value="{{ $service->id }}">
                                                                            {{ $service->kode_trace->kode_trace }} {{ $service->ikan->jenis_ikan }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="jumlah_produk">pcs</label>
                                                                <input type="number" name="pcs" class="form-control border-primary" value="{{ $item->pcs }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="no_seal">No Seal</label>
                                                                <input type="number" name="no_seal" class="form-control border-primary" value="{{ $item->no_seal }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="no_container">No Container</label>
                                                                <input type="number" name="no_container" class="form-control border-primary" value="{{ $item->no_container }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tgl_keluar">Tanggal Keluar</label>
                                                                <input type="date" name="tgl_keluar" class="form-control border-primary" value="{{ $item->tgl_keluar }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tgl_berangkat">Tanggal Berangkat</label>
                                                                <input type="date" name="tgl_berangkat" class="form-control border-primary" value="{{ $item->tgl_berangkat }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tgl_tiba">Tanggal Tiba</label>
                                                                <input type="date" name="tgl_tiba" class="form-control border-primary" value="{{ $item->tgl_tiba }}" required>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary ms-1">
                                                                <span class="d-none d-sm-block">Update</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Hapus Produk Keluar -->
                                        <div class="modal fade" id="hapusProdukKeluarModal{{ $item->id}}" tabindex="-1" role="dialog" aria-labelledby="hapusProdukKeluarModalTitle{{ $item->id}}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="hapusProdukKeluarModalTitle{{ $item->id}}">Hapus Produk Keluar</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus produk keluar ini?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                        <form method="POST" action="{{ route('produk-keluar.destroy', $item->id) }}" class="d-inline">
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
        </div>
    </div>
@endsection
