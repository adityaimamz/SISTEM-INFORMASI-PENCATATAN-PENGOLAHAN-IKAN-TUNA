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
                        <h3>Data Produk CS</h3>
                        <p class="text-subtitle text-muted">Silahkan kelola data stok CS</p>
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Tipe Stok</th>
                                        <th>PCS</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stokCS as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->service->ikan->jenis_ikan }}</td>
                                            <td>{{ $item->tipe_stok }}</td>
                                            <td>{{ $item->pcs }}</td>
                                            {{-- <td>
                                                <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#editProdukMasukModal{{ $item->id }}">
                                                    Edit Produk Masuk
                                                </button>
                                                <button type="button" class="btn btn-outline-danger block" data-bs-toggle="modal" data-bs-target="#hapusProdukMasukModal{{ $item->id }}">
                                                    Hapus Produk Masuk
                                                </button>
                                            </td> --}}
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
                                                        <form method="POST" action="{{ route('stok-cs.update', $item->id) }}" enctype="multipart/form-data" class="mt-0">
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
                                                        <form method="POST" action="{{ route('stok-cs.destroy', $item->id) }}" class="d-inline">
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
                                    <tr>
                                        <td colspan="3">Grand total</td>
                                        <td>{{ $grandtotal }}</td>
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
