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
                        <h3>Data Supplier</h3>
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
                        <h5 class="card-title">
                            Tambah Supplier
                        </h5>
                        <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#tambahSupplierModal">
                            Tambah Supplier
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
                                        <form method="POST" action="{{ route('supplier.store') }}" enctype="multipart/form-data" class="mt-0">
                                            @csrf
                                            <div class="form-group">
                                                <label for="supplier_id">Id Supplier</label>
                                                <input type="text" name="supplier_id" class="form-control border-primary" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_supplier">Nama Supplier</label>
                                                <input type="text" name="nama_supplier" class="form-control border-primary" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="nama_kapal">Nama Kapal</label>
                                                <input type="text" name="nama_kapal" class="form-control border-primary" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat">Alamat</label>
                                                <input type="text" name="alamat" class="form-control border-primary" required>
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
                                        <th>Id Supplier</th>
                                        <th>Nama Supplier</th>
                                        <th>Nama Kapal</th>
                                        <th>Alamat</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->supplier_id }}</td>
                                            <td>{{ $item->nama_supplier }}</td>
                                            <td>{{ $item->nama_kapal }}</td>
                                            <td>{{ $item->alamat }}</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#editSupplierModal{{ $item->id }}">
                                                    Edit Supplier
                                                </button>
                                                <button type="button" class="btn btn-outline-danger block" data-bs-toggle="modal" data-bs-target="#hapusSupplierModal{{ $item->id }}">
                                                    Hapus Supplier
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit Supplier -->
                                        <div class="modal fade" id="editSupplierModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editSupplierModalTitle{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editSupplierModalTitle{{ $item->id }}">Edit Supplier</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('supplier.update', $item->id) }}" enctype="multipart/form-data" class="mt-0">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="supplier_id">Id Supplier</label>
                                                                <input type="text" name="supplier_id" class="form-control border-primary" value="{{ $item->supplier_id }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nama_supplier">Nama Supplier</label>
                                                                <input type="text" name="nama_supplier" class="form-control border-primary" value="{{ $item->nama_supplier }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nama_kapal">Nama Kapal</label>
                                                                <input type="text" name="nama_kapal" class="form-control border-primary" value="{{ $item->nama_kapal }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="alamat">Alamat</label>
                                                                <input type="text" name="alamat" class="form-control border-primary" value="{{ $item->alamat }}" required>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary ms-1">
                                                                <span class="d-none d-sm-block">Update</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <!-- Modal Hapus Supplier -->
                                        <div class="modal fade" id="hapusSupplierModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="hapusSupplierModalTitle{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="hapusSupplierModalTitle{{ $item->id }}">Hapus Supplier</h5>
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
                                                        <form method="POST" action="{{ route('supplier.destroy', $item->id) }}" class="d-inline">
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
