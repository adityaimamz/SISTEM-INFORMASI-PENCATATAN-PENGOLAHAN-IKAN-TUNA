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
                        <h3>Data Master Kategori Berat Penerimaan</h3>
                        <p class="text-subtitle text-muted">Silahkan kelola data kategori berat penerimaan</p>
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
                            Tambah Kategori Berat Penerimaan
                        </h5>
                        <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal"
                            data-bs-target="#tambahKategoriBeratModal">
                            Tambah Kategori Berat Penerimaan
                        </button>

                        <!-- Vertically Centered modal Modal -->
                        <div class="modal fade" id="tambahKategoriBeratModal" tabindex="-1" role="dialog"
                            aria-labelledby="tambahKategoriBeratModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tambahKategoriBeratModalTitle">Tambah Kategori Berat Penerimaan</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('kategori_berat_penerimaan.store') }}"
                                            enctype="multipart/form-data" class="mt-0">
                                            @csrf
                                            <div class="form-group">
                                                <label for="kategori_berat">Kategori Berat</label>
                                                <input type="text" name="kategori_berat" class="form-control border-primary"
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
                                        <th>Kategori Berat</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kategori_berat_penerimaan as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kategori_berat }}</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary block"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editKategoriBeratModal{{ $item->id }}">
                                                    Edit Kategori Berat
                                                </button>
                                                <button type="button" class="btn btn-outline-danger block"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#hapusKategoriBeratModal{{ $item->id }}">
                                                    Hapus Kategori Berat
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit Kategori Berat -->
                                        <div class="modal fade" id="editKategoriBeratModal{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="editKategoriBeratModalTitle{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editKategoriBeratModalTitle{{ $item->id }}">
                                                            Edit Kategori Berat</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('kategori_berat_penerimaan.update', $item->id) }}"
                                                            enctype="multipart/form-data" class="mt-0">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="kategori_berat">Kategori Berat</label>
                                                                <input type="text" name="kategori_berat"
                                                                    class="form-control border-primary"
                                                                    value="{{ $item->kategori_berat }}" required>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary ms-1">
                                                                <span class="d-none d-sm-block">Update</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Hapus Kategori Berat -->
                                        <div class="modal fade" id="hapusKategoriBeratModal{{ $item->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="hapusKategoriBeratModalTitle{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="hapusKategoriBeratModalTitle{{ $item->id }}">Hapus Kategori Berat</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus kategori berat ini?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary"
                                                            data-bs-dismiss="modal">
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                        <form method="POST"
                                                            action="{{ route('kategori_berat_penerimaan.destroy', $item->id) }}"
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
