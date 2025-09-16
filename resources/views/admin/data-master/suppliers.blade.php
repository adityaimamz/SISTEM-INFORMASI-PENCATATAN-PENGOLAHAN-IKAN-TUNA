@extends('layouts.app')

@section('content')
    <div id="main">
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12">
                        <h3>PT BAHARI PRIMA MANUNGGAL</h3>
                        <p class="text-subtitle text-muted">Data Supplier</p>
                    </div>
                </div>
            </div>

            <section class="section">
                <div class="card" style="border-radius: 10px; overflow: hidden;">
                    <div class="card-header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                        <h4 class="card-title text-white">Daftar Supplier</h4>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#tambahSupplierModal">
                            <i class="bi bi-plus-circle"></i> Tambah
                        </button>
                    </div>
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table2">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Kode Supplier</th>
                                        <th>Nama Supplier</th>
                                        <th>Asal Daerah</th>
                                        <th class="text-center" style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suppliers as $item)
                                    <tr style="background: linear-gradient(to right, #f9f9f9 0%, #f0f7ff 100%);">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ str_pad($item->supplier_id, 2, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $item->nama_supplier }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" 
                                                data-bs-target="#editSupplierModal{{ $item->supplier_id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form action="{{ route('suppliers.destroy', $item->supplier_id) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editSupplierModal{{ $item->supplier_id }}" tabindex="-1" role="dialog" 
                                        aria-labelledby="editSupplierModalLabel{{ $item->supplier_id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);">
                                                    <h5 class="modal-title text-white" id="editSupplierModalLabel{{ $item->supplier_id }}">Edit Supplier</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('suppliers.update', $item->supplier_id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3">
                                                            <label for="supplier_id" class="form-label">Kode Supplier</label>
                                                            <input type="text" class="form-control" id="supplier_id" 
                                                                name="supplier_id" value="{{ str_pad($item->supplier_id, 2, '0', STR_PAD_LEFT) }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="nama_supplier" class="form-label">Nama Supplier</label>
                                                            <input type="text" class="form-control" id="nama_supplier" 
                                                                name="nama_supplier" value="{{ $item->nama_supplier }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="alamat" class="form-label">Asal Daerah</label>
                                                            <textarea class="form-control" id="alamat" name="alamat" required>{{ $item->alamat }}</textarea>
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
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

    <!-- Modal Tambah -->
    <div class="modal fade" id="tambahSupplierModal" tabindex="-1" role="dialog" 
        aria-labelledby="tambahSupplierModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);">
                    <h5 class="modal-title text-white" id="tambahSupplierModalTitle">Tambah Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('suppliers.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="supplier_id" class="form-label">Kode Supplier</label>
                            <input type="text" class="form-control" id="supplier_id" 
                                name="supplier_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_supplier" class="form-label">Nama Supplier</label>
                            <input type="text" class="form-control" id="nama_supplier" 
                                name="nama_supplier" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Asal Daerah</label>
                            <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
