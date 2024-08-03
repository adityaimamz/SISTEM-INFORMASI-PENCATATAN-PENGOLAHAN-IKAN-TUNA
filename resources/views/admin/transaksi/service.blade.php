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
                        <h3>Data Service</h3>
                        <p class="text-subtitle text-muted">Silahkan kelola data service</p>
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
                        <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal"
                            data-bs-target="#tambahServiceModal">
                            Tambah Service
                        </button>

                        <div class="modal fade" id="tambahServiceModal" tabindex="-1" role="dialog"
                            aria-labelledby="tambahServiceModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tambahServiceModalTitle">Tambah Service</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('service.store') }}"
                                            enctype="multipart/form-data" class="mt-0">
                                            @csrf
                                            <div class="form-group">
                                                <label for="kode_trace">Kode Trace</label>
                                                <select name="kode_trace_id" id="kode_trace_id"
                                                    class="form-control border-primary" required>
                                                    <option value="" disabled selected>Pilih Kode Trace</option>
                                                    @foreach ($kode_trace as $kode)
                                                        <option value="{{ $kode->id }}">{{ $kode->kode_trace }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="no_batch_id">No Batch</label>
                                                <select name="no_batch_id" id="no_batch_id"
                                                    class="form-control border-primary" required>
                                                    <option value="" disabled selected>Pilih No Batch</option>
                                                    @foreach ($no_batches as $no_batch)
                                                        <option value="{{ $no_batch->id }}">
                                                            {{ $no_batch->no_batch }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="id_ikan">Produk</label>
                                                <select name="id_ikan" id="id_ikan"
                                                    class="form-control border-primary" required>
                                                    <option value="" disabled selected>Pilih Produk</option>
                                                    @foreach ($kategori_ikan as $ikan)
                                                        <option value="{{ $ikan->id }}">{{ $ikan->jenis_ikan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="berat_produk">Berat Produk (KG)</label>
                                                <input type="number" name="kg" class="form-control border-primary"
                                                    step="0.01" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="supplier_id">Pcs</label>
                                                <input type="number" name="pcs" id="pcs"
                                                    class="form-control border-primary" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="tgl_service">Tgl Service</label>
                                                <input type="date" name="tgl_service" class="form-control border-primary"
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
                        <livewire:service-filter />
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Data Kode Trace
                        </h5>
                        <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal"
                            data-bs-target="#tambahKodeTraceModal">
                            Tambah Kode Trace
                        </button>

                        <!-- Vertically Centered modal Modal -->
                        <div class="modal fade" id="tambahKodeTraceModal" tabindex="-1" role="dialog"
                            aria-labelledby="tambahKodeTraceModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="tambahKodeTraceModalTitle">Tambah Kode Trace
                                        </h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('kode_trace.store') }}"
                                            enctype="multipart/form-data" class="mt-0">
                                            @csrf
                                            <div class="form-group">
                                                <label for="kode_trace">Kode Trace</label>
                                                <input type="text" name="kode_trace"
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
                                        <th>Kode Trace</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kode_trace as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->kode_trace }}</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary block"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editKodeTraceModal{{ $item->id }}">
                                                    Edit Kode Trace
                                                </button>
                                                <button type="button" class="btn btn-outline-danger block"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#hapusKodeTraceModal{{ $item->id }}">
                                                    Hapus Kode Trace
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit Kode Trace -->
                                        <div class="modal fade" id="editKodeTraceModal{{ $item->id }}"
                                            tabindex="-1" role="dialog"
                                            aria-labelledby="editKodeTraceModalTitle{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editKodeTraceModalTitle{{ $item->id }}">Edit Kode
                                                            Trace
                                                        </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="{{ route('kode_trace.update', $item->id) }}"
                                                            enctype="multipart/form-data" class="mt-0">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="kode_trace">Kode Trace</label>
                                                                <input type="text" name="kode_trace"
                                                                    class="form-control border-primary"
                                                                    value="{{ $item->kode_trace }}" required>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary ms-1">
                                                                <span class="d-none d-sm-block">Update</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Hapus Kode Trace -->
                                        <div class="modal fade" id="hapusKodeTraceModal{{ $item->id }}"
                                            tabindex="-1" role="dialog"
                                            aria-labelledby="hapusKodeTraceModalTitle{{ $item->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="hapusKodeTraceModalTitle{{ $item->id }}">Hapus Kode
                                                            Trace
                                                        </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus kode trace ini?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light-secondary"
                                                            data-bs-dismiss="modal">
                                                            <span class="d-none d-sm-block">Close</span>
                                                        </button>
                                                        <form method="POST"
                                                            action="{{ route('kode_trace.destroy', $item->id) }}"
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
        </div>
    </div>


    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const beratIkanInput = document.querySelector('input[name="berat_produk"]');

            beratIkanInput.addEventListener('input', function(event) {
                const value = beratIkanInput.value;

                // Replace commas with nothing
                const sanitizedValue = value.replace(',', '');

                if (value !== sanitizedValue) {
                    beratIkanInput.value = sanitizedValue;
                }
            });
        });
    </script>
@endsection
