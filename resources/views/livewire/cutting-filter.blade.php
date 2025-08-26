@php
    use App\Models\Penerimaan_ikan;
    use App\Models\Supplier;

    $Penerimaan_ikan = Penerimaan_ikan::all();
@endphp 
<div>
    <!---------------------------------------------- success/error messages --------------------------------------------->
    
        <div class="alert alert-success alert-dismissible fade show" role="alert">
           <!--session message-->
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

    
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
           <!--session error-->
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <!---------------------------------------------- Form Input Data --------------------------------------------->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Form Input Cutting</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="" class="form-label">Tanggal Cutting</label>
                    <input type="date" id="" 
                           wire:model.defer="" 
                           class="form-control" required>
                    <!--error message-->
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Tanggal Injek CO</label>
                    <input type="date" id="" 
                           wire:model.defer="" 
                           class="form-control"
                           min="" 
                           required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="" class="form-label">Supplier</label>
                    <select id="" 
                            wire:model.defer="" 
                            class="form-control border-primary"
                            required>
                        <option value="" selected disabled>Pilih Supplier</option>
                        <!--foreach-->
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
        </div>
    </div>
    <!---------------------------------------------- Add Data Button ---------------------------------------------->
    <div class="mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahDataModal"
            disabled>
            <i class="bi bi-plus-circle"></i> Tambah
        </button>
    </div>

    <!-----------------------------------------------status sesi---------------------------------------------->
    <div class="row mt-3">
        <div class="col-12">
            
                <div class="alert alert-success mb-0">
                    <i class="bi bi-check-circle"></i>
                    <strong>Sesi Aktif:</strong><br>
                </div>
            
                <div class="alert alert-warning mb-0">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            
                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle"></i>
                </div>
        </div>
    </div>
    
    <!-----------------------------------------------Tombol Tambah Data--------------------------------------------->
    <div class="mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahDataModal"
            disabled>
            <i class="bi bi-plus-circle"></i> Tambah
        </button>
    </div>
    
    <!-----------------------------------------------Add Data Modal--------------------------------------------->
    <div wire:ignore.self class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataModalTitle">
                        Tambah Data Ikan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store" class="mt-0">
                        <div class="form-group">
                            <label for="">Grade/sizing</label>
                            <select wire:model="" class="form-control border-primary" required>
                                <option value="">Grade/sizing</option>
                            </select>
                        </div>
                        
    <!------------------------------------------------------------------------- Data Display Info -------------------------------------------------------------------------->
    <div class="row mb-3">
        <div class="col-12">
        </div>
    </div>
    <div class="mb-3">
        <a href="{{ route('##', [
    ]) }}"
    target="_blank"
    class="btn btn-primary">
        <i class="bi bi-printer"></i> Export PDF
    </a>
    </div>

    <!----------------------------------structure tabel cutting---------------------------------->
    <div>
        <p style="font-weight: bold;"></p>
    </div>

    <style>
        #table {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 10px;
            width: auto;
            max-width: 800px;
        }

        #table th,
        #table td {
            border: 1px solid black;
            text-align: center;
            vertical-align: middle;
            padding: 2px 4px;
            font-size: 10px;
            line-height: 1.2;
        }

        #table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
            font-size: 9px;
            padding: 3px 2px;
        }

        #table {
            background-color: #e3f2fd;
            width: 60px;
            min-width: 60px;
            max-width: 60px;
        }

        #table {
            background-color: #e3f2fd;
            width: 60px;
            min-width: 60px;
            max-width: 60px;
        }

        #table {
            background-color: #e3f2fd;
            width: 60px;
            min-width: 60px;
            max-width: 60px;
        }

        #table {
            background-color: #e3f2fd;
            width: 60px;
            min-width: 60px;
            max-width: 60px;
        }

        #table {
            background-color: #e3f2fd;
            width: 60px;
            min-width: 60px;
            max-width: 60px;
        }

        #table {
            background-color: #e3f2fd;
            width: 60px;
            min-width: 60px;
            max-width: 60px;
        }

        #table {
            background-color: #e3f2fd;
            width: 60px;
            min-width: 60px;
            max-width: 60px;
        }

        #table {
            background-color: #e3f2fd;
            width: 60px;
            min-width: 60px;
            max-width: 60px;
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            #table {
                font-size: 8px;
                max-width: 100%;
            }
            
            #table th,
            #table td {
                padding: 1px 2px;
                font-size: 8px;
            }
            
            #table .action-btn {
                padding: 1px 2px;
                font-size: 8px;
            }
        } 
    </style>

    <div class="table-responsive">
        <table class="table table-bordered" id="table">
            <thead>
                <tr>
                    <th rowspan="2" class="no-column">No</th>
                    <th colspan="2" class="">??</th>
                    <th colspan="2" class="">??</th>
                    <th rowspan="2" class="">??</th>
                    <th rowspan="2" class="">??</th>
                    <th rowspan="2" class="">Action</th>
                </tr>
                <tr>
                    <th class="">??</th>
                    <th class="">??</th>
                    <th class="">??</th>
                    <th class="">??</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td></td>
                        <td class="action-column">
                            <button type="button" class="btn btn-outline-primary action-btn" data-bs-toggle="modal"
                                data-bs-target="#editModal">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger action-btn" data-bs-toggle="modal">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                
                <!-- Data Collection -->
                

                <tr class="total-row">
                    <!--total row-->
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal Edit dan Delete untuk semua item -->
    
        <div wire:ignore.self class="modal fade" id="editModal">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Cutting</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!--if end-->

                        <form>
                            <div class="form-group mb-3">
                                <!--------form inputan-------->
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <button type="button" class="btn btn-secondary me-md-2" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-1"></i> Update Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--------------------------- Modal Delete -------------------------->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Hapus Cutting</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus cutting ini?</p>
                    </div>
                    <div class="alert alert-info">
                        <strong>Data yang akan dihapus:</strong><br>
                        <!---data yang dituju--->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" >Hapus</button>
                </div>
            </div>
        </div>
    </div>

<script>
    <!----menutup data modal---->
</script>

</div>

        
                                
                       
        
                      
                
    