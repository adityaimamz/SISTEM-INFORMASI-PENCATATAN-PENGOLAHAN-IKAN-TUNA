@extends('layouts.app')

@section('content')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Data Grade Penerimaan</h3>
            <p class="text-subtitle text-muted">Silahkan kelola data grade penerimaan</p>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-outline-primary rounded-pill"
                        data-bs-toggle="modal" data-bs-target="#tambahIkanModal">
                        <i class="bi bi-plus-circle-fill"></i> Tambah
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="table2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Grade</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grades as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->grade }}</td>
                                        <td>
                                            <button type="button" class="btn btn-outline-primary rounded-pill"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editIkanModal{{ $item->id }}">
                                                <i class="bi bi-pencil-fill"></i> 
                                            </button>
                                            <button type="button" class="btn btn-outline-danger rounded-pill"
                                                data-bs-toggle="modal"
                                                data-bs-target="#hapusIkanModal{{ $item->id }}">
                                                <i class="bi bi-trash-fill"></i> 
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Modal Edit Ikan -->
                                    <div class="modal fade" id="editIkanModal{{ $item->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="editIkanModalTitle{{ $item->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editIkanModalTitle{{ $item->id }}">
                                                        Edit Grade Penerimaan</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{ route('grade.update', $item->id) }}"
                                                        enctype="multipart/form-data" class="mt-0">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group">
                                                            <label for="grade">Grade Penerimaan</label>
                                                            <input type="text" name="grade"
                                                                class="form-control border-primary"
                                                                value="{{ $item->grade }}" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary ms-1">
                                                            <span class="d-none d-sm-block">Update</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Hapus Ikan -->
                                    <div class="modal fade" id="hapusIkanModal{{ $item->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="hapusIkanModalTitle{{ $item->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="hapusIkanModalTitle{{ $item->id }}">Hapus Grade Penerimaan</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menghapus grade penerimaan ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light-secondary"
                                                        data-bs-dismiss="modal">
                                                        <span class="d-none d-sm-block">Close</span>
                                                    </button>
                                                    <form method="POST"
                                                        action="{{ route('grade.destroy', $item->id) }}"
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

        <!-- Vertically Centered modal Modal -->
        <div class="modal fade" id="tambahIkanModal" tabindex="-1" role="dialog"
            aria-labelledby="tambahIkanModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahIkanModalTitle">Tambah Grade Penerimaan</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('grade.store') }}"
                            enctype="multipart/form-data" class="mt-0">
                            @csrf
                            <div class="form-group">
                                <label for="grade">Grade Penerimaan</label>
                                <input type="text" name="grade" class="form-control border-primary" required>
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
@endsection
