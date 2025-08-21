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
                        <h3>Supplier</h3>
                        <p class="text-subtitle text-muted">Silahkan kelola data supplier</p>
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
                        <button type="button" class="btn btn-success btn-icon me-2" data-bs-toggle="modal" data-bs-target="#tambahSupplierModal">
                            <i class="bi bi-plus-circle"></i> Tambah
                        </button>                    
                        <!-- Vertically Centered modal Modal -->
                        <div class="modal fade" id="tambahSupplierModal" tabindex="-1" role="dialog" aria-labelledby="tambahSupplierModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tambahSupplierModalTitle">Tambah Supplier</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('suppliers.store') }}" method="POST" enctype="multipart/form-data" class="mt-0">
                                            @csrf
                                            <div class="form-group">
                                                <label for="supplier_id">Kode Supplier</label>
                                                <input type="text" name="supplier_id" class="form-control border-primary" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_supplier">Nama Supplier</label>
                                                <input type="text" name="nama_supplier" class="form-control border-primary" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat">Asal Daerah</label>
                                                <textarea name="alamat" class="form-control border-primary" required></textarea>
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
                                        <th>Kode Supplier</th>
                                        <th>Nama Supplier</th>
                                        <th>Asal Daerah</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suppliers as $item)
                                        <tr>
                                            <td>{{ $item->supplier_id }}</td>
                                            <td>{{ $item->nama_supplier }}</td>
                                            <td>{{ $item->alamat }}</td>
                                            <td>
                                                <button type="button" class="btn btn-success block" data-bs-toggle="modal" data-bs-target="#editSupplierModal{{ $item->id }}">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </button>
                                                <button type="button" class="btn btn-danger block" data-bs-toggle="modal" data-bs-target="#hapusSupplierModal{{ $item->id }}">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit Supplier -->
                                        <div class="modal fade" id="editSupplierModal{{ $item->supplier_id }}" tabindex="-1" role="dialog" aria-labelledby="editSupplierModalTitle{{ $item->supplier_id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editSupplierModalTitle{{ $item->supplier_id }}">Edit Supplier</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('suppliers.update', $item->supplier_id) }}" enctype="multipart/form-data" class="mt-0">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="supplier_id">Kode Supplier</label>
                                                                <input type="text" name="supplier_id" class="form-control border-primary" value="{{ $item->supplier_id }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nama_supplier">Nama Supplier</label>
                                                                <input type="text" name="nama_supplier" class="form-control border-primary" value="{{ $item->nama_supplier }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="alamat">Asal Daerah</label>
                                                                <textarea name="alamat" class="form-control border-primary" required>{{ $item->alamat }}</textarea>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                                    <span class="d-none d-sm-block">Close</span>
                                                                </button>
                                                                <button type="submit" class="btn btn-primary ms-1">
                                                                    <span class="d-none d-sm-block">Update</span>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal Hapus Supplier -->
                                        <div class="modal fade" id="hapusSupplierModal{{ $item->supplier_id }}" tabindex="-1" role="dialog" aria-labelledby="hapusSupplierModalTitle{{ $item->supplier_id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="hapusSupplierModalTitle{{ $item->supplier_id }}">Hapus Supplier</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus supplier ini?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                        <form method="POST" action="{{ route('suppliers.destroy', $item->supplier_id) }}" class="d-inline">
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
            <!-------------------------------------------- Basic Tables end -------------------------------------------->
        </div>
    </div>
@endsection
