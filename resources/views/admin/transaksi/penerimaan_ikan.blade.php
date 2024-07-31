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
                    <h3>Data Penerimaan Ikan</h3>
                    <p class="text-subtitle text-muted">Silahkan kelola data penerimaan ikan</p>
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

            <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal"
            data-bs-target="#tambahPenerimaanModal">
            Tambah Penerimaan
        </button>
        <!-- Vertically Centered modal Modal -->
        <div class="modal fade" id="tambahPenerimaanModal" tabindex="-1" role="dialog"
            aria-labelledby="tambahPenerimaanModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahPenerimaanModalTitle">Tambah Penerimaan</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('penerimaan_ikan.store') }}"
                            enctype="multipart/form-data" class="mt-0">
                            @csrf
                            <div class="form-group">
                                <label for="supplier_id">Supplier</label>
                                <select name="supplier_id" class="form-control border-primary" required>
                                    <option value="" selected disabled>Pilih Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->supplier_id }}">
                                            {{ $supplier->nama_supplier }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="grade_id">Grade</label>
                                <select name="grade_id" class="form-control border-primary" required>
                                    <option value="" selected disabled>Pilih Grade</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->grade }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kategori_berat_id">Kategori Berat</label>
                                <select name="kategori_berat_id" class="form-control border-primary"
                                    required>
                                    <option value="" selected disabled>Pilih Kategori Berat</option>
                                    @foreach ($kategori_berat_penerimaans as $kategori_berat)
                                        <option value="{{ $kategori_berat->id }}">
                                            {{ $kategori_berat->kategori_berat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="berat_ikan">Berat Ikan</label>
                                <input type="number" name="berat_ikan" id="berat_ikan" step="0.01"
                                    class="form-control border-primary" required>
                            </div>
                            <div class="form-group">
                                <label for="tgl_penerimaan">Tanggal Penerimaan</label>
                                <input type="date" name="tgl_penerimaan"
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
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Filter Penerimaan Ikan
                    </h5>
                </div>
                <div class="card-body">
                    @livewire('penerimaan-ikan')
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
