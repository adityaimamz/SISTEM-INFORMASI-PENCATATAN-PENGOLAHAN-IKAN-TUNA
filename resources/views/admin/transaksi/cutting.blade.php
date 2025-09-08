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
                        <h3>Data Cutting</h3>
                        <p class="text-subtitle text-muted">Silahkan kelola data cutting</p>
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
                <div class="modal fade" id="tambahCuttingModal" 
                    tabindex="-1" role="dialog" 
                    aria-labelledby="tambahCuttingModalTitle" 
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahCuttingModalTitle">Tambah Cutting</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('cutting.store') }}" enctype="multipart/form-data" class="mt-0">
                                    @csrf
                                    <div class="form-group">
                                        <label for="no_batch_id">No Batch</label>
                                        <select name="no_batch_id" id="no_batch_id" class="form-control border-primary" required>
                                            <option value="" selected disabled>Pilih No Batch</option>
                                            @foreach ($cutting as $item)
                                                <option value="{{ $item->id }}">{{ $item->no_batch }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="berat_produk">Berat Produk</label>
                                        <input type="number" name="berat_produk" class="form-control border-primary" step="0.01" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="tgl_cutting">Tanggal Cutting</label>
                                        <input type="date" name="tgl_cutting" class="form-control border-primary" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="supplier_id">Supplier</label>
                                        <select name="supplier_id" id="supplier_id" 
                                            class="form-control border-primary" required>
                                            <option value="" selected disabled>Pilih Supplier</option>
                                            @foreach ($penerimaan_ikan as $penerimaan)
                                                <option value="{{ $penerimaan->supplier_id }}">
                                                    {{ $penerimaan->supplier->nama_supplier }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="tgl_injek_co">Tanggal Injeksi Co</label>
                                        <input type="date" name="tgl_injek_co" class="form-control border-primary" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary ms-1">
                                        <span class="d-none d-sm-block">Submit</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @livewire('cutting')
                </div>
            </section>
        </div>
    </div>
@endsection
