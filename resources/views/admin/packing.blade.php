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
                        <h3>Data Packing</h3>
                        <p class="text-subtitle text-muted">Silahkan kelola data packing</p>
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
                            Tambah Packing
                        </h5>
                        <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#tambahPackingModal">
                            Tambah Packing
                        </button>
                        
                        <!-- Vertically Centered modal Modal -->
                        <div class="modal fade" id="tambahPackingModal" tabindex="-1" role="dialog" aria-labelledby="tambahPackingModalTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="tambahPackingModalTitle">Tambah Packing</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <i data-feather="x"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('packing.store') }}" enctype="multipart/form-data" class="mt-0">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="no_box">No Box</label>
                                                    <input type="text" name="no_box" class="form-control border-primary" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="kode_trace">Kode Lot</label>
                                                    <select name="kode_trace" class="form-control border-primary" required>
                                                        @foreach ($services as $service)
                                                            <option value="{{ $service->kode_trace }}">{{ $service->kode_trace }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="tgl_packing">Tanggal Packing</label>
                                                    <input type="date" name="tgl_packing" class="form-control border-primary" required>
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
                                        <th>No box</th>
                                        <th>Kode Lot</th>
                                        <th>Tanggal Packing</th>
                                        <th>Grade</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->no_box }}</td>
                                            <td>{{ $item->service->kode_trace }}</td>
                                            <td>{{ $item->tgl_packing }}</td>
                                            <td>{{ $item->service->cutting->penerimaan_ikan->kategori_ikan->grade }}</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#editPackingModal{{ $item->no_box }}">
                                                    Edit Packing
                                                </button>
                                                <button type="button" class="btn btn-outline-danger block" data-bs-toggle="modal" data-bs-target="#hapusPackingModal{{ $item->no_box }}">
                                                    Hapus Packing
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit Packing -->
                                        <div class="modal fade" id="editPackingModal{{ $item->no_box }}" tabindex="-1" role="dialog" aria-labelledby="editPackingModalTitle{{ $item->no_box }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editPackingModalTitle{{ $item->no_box }}">Edit Packing</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('packing.update', $item->no_box) }}" enctype="multipart/form-data" class="mt-0">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="kode_trace">Kode Lot</label>
                                                                <select name="kode_trace" class="form-control border-primary" required>
                                                                    @foreach ($services as $service)
                                                                        <option value="{{ $service->id }}" {{ $service->id == $item->kode_trace ? 'selected' : '' }}>{{ $service->kode_trace }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tgl_packing">Tanggal Packing</label>
                                                                <input type="date" name="tgl_packing" class="form-control border-primary" value="{{ $item->tgl_packing }}" required>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary ms-1">
                                                                <span class="d-none d-sm-block">Update</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <!-- Modal Hapus Packing -->
                                        <div class="modal fade" id="hapusPackingModal{{ $item->no_box }}" tabindex="-1" role="dialog" aria-labelledby="hapusPackingModalTitle{{ $item->no_box }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="hapusPackingModalTitle{{ $item->no_box }}">Hapus Packing</h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus packing ini?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                        <form method="POST" action="{{ route('packing.destroy', $item->no_box) }}" class="d-inline">
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
