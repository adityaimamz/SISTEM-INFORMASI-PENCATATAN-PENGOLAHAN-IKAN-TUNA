<div>
    <!-- Success/Error Messages -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Form Input Data --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Form Input Penerimaan Ikan</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="session_date" class="form-label">Tanggal Penerimaan</label>
                        <input type="date" id="session_date" 
                               wire:model.live="session_date" 
                               class="form-control @error('session_date') is-invalid @enderror" required>
                        @error('session_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="session_tgl_bongkar" class="form-label">Tanggal Bongkar</label>
                        <input type="date" id="session_tgl_bongkar" 
                               wire:model.live="session_tgl_bongkar" 
                               class="form-control @error('session_tgl_bongkar') is-invalid @enderror"
                               @if(!$session_date) disabled @endif 
                               min="{{ $session_date }}"
                               required>
                        @error('session_tgl_bongkar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="session_supplier" class="form-label">Supplier</label>
                        <select id="session_supplier" 
                                wire:model.live="session_supplier" 
                                class="form-select @error('session_supplier') is-invalid @enderror"
                                @if(!$session_date || !$session_tgl_bongkar) disabled @endif 
                                required>
                            <option value="">Pilih Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->supplier_id }}">
                                    {{ $supplier->nama_supplier }}
                                </option>
                            @endforeach
                        </select>
                        @error('session_supplier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="session_jenis_penerimaan" class="form-label">
                            Jenis Penerimaan
                            <span class="text-danger">*</span>
                        </label>
                        <select 
                            id="session_jenis_penerimaan"
                            wire:model.live="session_jenis_penerimaan"
                            wire:loading.attr="disabled"
                            wire:target="session_jenis_penerimaan"
                            class="form-select @error('session_jenis_penerimaan') is-invalid @enderror"
                            @if(!$session_date || !$session_tgl_bongkar || !$session_supplier) disabled @endif 
                            required>
                            <option value="" selected disabled>Pilih Jenis Penerimaan</option>
                            <option value="Fresh GG">Fresh GG</option>
                            <option value="Frozen WR">Frozen WR YF</option>
                            <option value="Frozen WR">Frozen WR BF</option>
                            <option value="Frozen WR">Frozen WR BE</option>
                            <option value="Frozen GG">Frozen GG YF</option>
                            <option value="Frozen GG">Frozen GG BF</option>
                            <option value="Frozen GG">Frozen GG BE</option>
                        </select>
                        @error('session_jenis_penerimaan')
                            <div class="invalid-feedback d-block">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="session_no_bak" class="form-label">No. Bak</label>
                        <input type="text" id="session_no_bak" 
                               wire:model.live="session_no_bak"
                               wire:loading.attr="disabled"
                               wire:target="session_no_bak"
                               class="form-control @error('session_no_bak') is-invalid @enderror"
                               @if(!$session_date || !$session_tgl_bongkar || !$session_supplier || !$session_jenis_penerimaan) disabled @endif 
                               required>
                        @error('session_no_bak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Status Sesi --}}
            <div class="row mt-3">
                <div class="col-12">
                    @if($session_date && $session_tgl_bongkar && $session_supplier && $session_jenis_penerimaan)
                        @php    
                            $selectedSupplier = $suppliers->firstWhere('supplier_id', $session_supplier);
                        @endphp
                        <div class="alert alert-success mb-0">
                            <i class="bi bi-check-circle"></i> 
                            <strong>Sesi Aktif:</strong><br>
                            <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($session_date)->format('d F Y') }}<br>
                            <strong>Tanggal Bongkar:</strong> {{ \Carbon\Carbon::parse($session_tgl_bongkar)->format('d F Y') }}<br>
                            <strong>Supplier:</strong> {{ $selectedSupplier ? $selectedSupplier->nama_supplier : 'Unknown' }}<br>
                            <strong>Jenis Penerimaan:</strong> {{ $session_jenis_penerimaan }}<br>
                            <strong>No. Bak:</strong> {{ $session_no_bak }}
                        </div>
                    @else
                        <div class="alert alert-{{ $session_date || $session_tgl_bongkar || $session_supplier || $session_jenis_penerimaan || $session_no_bak ? 'warning' : 'info' }} mb-0">
                            <i class="bi bi-{{ $session_date || $session_tgl_bongkar || $session_supplier || $session_jenis_penerimaan || $session_no_bak ? 'exclamation-triangle' : 'info-circle' }}"></i> 
                            @if(!$session_date)
                                Pilih tanggal penerimaan terlebih dahulu.
                            @elseif(!$session_tgl_bongkar)
                                Pilih tanggal bongkar terlebih dahulu.
                            @elseif(!$session_supplier)
                                Pilih supplier untuk melanjutkan input data.
                            @elseif(!$session_jenis_penerimaan)
                                Pilih jenis penerimaan untuk melanjutkan input data.
                            @elseif(!$session_no_bak)
                                Pilih no. bak untuk melanjutkan input data.
                            @else
                                Pilih tanggal penerimaan, tanggal bongkar, supplier, jenis penerimaan, dan no. bak terlebih dahulu.
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Tambah Data --}}
    <div class="mb-3">
        <button type="button" 
                class="btn btn-primary" 
                data-bs-toggle="modal" 
                data-bs-target="#tambahDataModal"
                @if(!$session_date || !$session_tgl_bongkar || !$session_supplier || !$session_jenis_penerimaan || !$session_no_bak) disabled @endif>
            <i class="bi bi-plus-circle"></i> Tambah
        </button>
        @if(!$session_date || !$session_tgl_bongkar || !$session_supplier || !$session_jenis_penerimaan || !$session_no_bak)
            <div class="text-muted mt-1">
                <small>Lengkapi form di atas untuk mengaktifkan tombol tambah data</small>
            </div>
        @endif
    </div>

    <!-- Add Data Modal -->
    <div wire:ignore.self class="modal fade" id="tambahDataModal" tabindex="-1" role="dialog" aria-labelledby="tambahDataModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahDataModalTitle">
                        Tambah Data Ikan
                        @if($session_date && $session_tgl_bongkar && $session_supplier && $session_jenis_penerimaan && $session_no_bak)
                            @php
                                $selectedSupplier = $suppliers->firstWhere('supplier_id', $session_supplier);
                            @endphp
                            <br><small class="text-muted">{{ \Carbon\Carbon::parse($session_date)->format('d F Y') }} - {{ \Carbon\Carbon::parse($session_tgl_bongkar)->format('d F Y') }} - {{ $selectedSupplier ? $selectedSupplier->nama_supplier : 'Unknown' }}</small>
                        @endif
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    @if($session_date && $session_tgl_bongkar && $session_supplier && $session_jenis_penerimaan && $session_no_bak)
                        @php
                            $selectedSupplier = $suppliers->firstWhere('supplier_id', $session_supplier);
                        @endphp
                        <div class="alert alert-success" style="max-height: 50px; overflow-y: auto;">
                            <i class="bi bi-check-circle my-1"></i> 
                            <strong>Sesi Aktif:</strong><br>
                            <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($session_date)->format('d F Y') }}<br>
                            <strong>Tanggal Bongkar:</strong> {{ \Carbon\Carbon::parse($session_tgl_bongkar)->format('d F Y') }}<br>
                            <strong>Supplier:</strong> {{ $selectedSupplier ? $selectedSupplier->nama_supplier : 'Unknown' }}<br>
                            <strong>Jenis Penerimaan:</strong> {{ $session_jenis_penerimaan }}<br>
                        </div>
                    @endif
                    <form wire:submit.prevent="store" class="mt-0">
                        <div class="form-group">
                            <label for="grade_id">Grade</label>
                            <select wire:model="grade_id" class="form-control border-primary" required>
                                <option value="">Pilih Grade</option>
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->grade }}</option>
                                @endforeach
                            </select>
                            @error('grade_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="berat_ikan">Berat Ikan (kg)</label>
                            <input type="number" wire:model="berat_ikan" step="0.01" min="10" class="form-control border-primary" required>
                            @error('berat_ikan') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="suhu_ikan">Suhu Ikan (°C)</label>
                            <input type="number" wire:model="suhu_ikan" step="0.1" min="-50" max="50" class="form-control border-primary" required>
                            @error('suhu_ikan') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <span class="d-none d-sm-block">Batal</span>
                            </button>
                            <button type="submit" class="btn btn-primary ms-1">
                                <span class="d-none d-sm-block">Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Display Info -->
    <div class="row mb-3">
        <div class="col-12">
            @if($session_date && $session_tgl_bongkar && $session_supplier && $session_jenis_penerimaan && $session_no_bak)
                @php
                    $selectedSupplier = $suppliers->firstWhere('supplier_id', $session_supplier);
                @endphp
                <div class="alert alert-primary">
                    <i class="bi bi-table"></i> 
                    <strong>Data yang ditampilkan:</strong><br>
                    <strong>Tanggal Penerimaan:</strong> {{ \Carbon\Carbon::parse($session_date)->format('d F Y') }}<br>
                    <strong>Tanggal Bongkar:</strong> {{ \Carbon\Carbon::parse($session_tgl_bongkar)->format('d F Y') }}<br>
                    <strong>Supplier:</strong> {{ $selectedSupplier ? $selectedSupplier->nama_supplier : 'Unknown' }}
                    @if($session_jenis_penerimaan)
                    <br><strong>Jenis Penerimaan:</strong> {{ $session_jenis_penerimaan }}
                    @endif
                    @if($session_no_bak)
                    <br><strong>No. Bak:</strong> {{ $session_no_bak }}
                    @endif
                </div>
            @elseif($session_date || $session_tgl_bongkar || $session_supplier || $session_jenis_penerimaan || $session_no_bak)
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i> 
                    <strong>Data yang ditampilkan:</strong><br>
                    @if($session_date)
                        <strong>Tanggal Penerimaan:</strong> {{ \Carbon\Carbon::parse($session_date)->format('d F Y') }}<br>
                    @endif
                    @if($session_tgl_bongkar)
                        <strong>Tanggal Bongkar:</strong> {{ \Carbon\Carbon::parse($session_tgl_bongkar)->format('d F Y') }}<br>
                    @endif
                    @if($session_supplier)
                        <strong>Supplier:</strong> {{ $session_supplier }}<br>
                    @endif
                    @if($session_jenis_penerimaan)
                        <strong>Jenis Penerimaan:</strong> {{ $session_jenis_penerimaan }}<br>
                    @endif
                    @if($session_no_bak)
                        <strong>No. Bak:</strong> {{ $session_no_bak }}<br>
                    @endif
                    <br><em>Lengkapi pilihan untuk melihat data spesifik</em>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> 
                    Pilih tanggal penerimaan, tanggal bongkar, supplier, jenis penerimaan, dan no bak untuk melihat data
                </div>
            @endif
        </div>
    </div>
    <div class="mb-3">
        <a href="{{ route('ikan.pdf', [
            'date' => $session_date,
            'tgl_bongkar' => $session_tgl_bongkar,
            'supplier' => $session_supplier,
            'jenis_penerimaan' => $session_jenis_penerimaan,
            'no_bak' => $session_no_bak,
        ]) }}" 
        target="_blank" 
        class="btn btn-primary"
        @if(!$session_date || !$session_tgl_bongkar || !$session_supplier || !$session_jenis_penerimaan || !$session_no_bak) disabled @endif>
            <i class="bi bi-printer"></i> Export PDF
        </a>
        @if(!$session_date || !$session_tgl_bongkar || !$session_supplier || !$session_jenis_penerimaan || !$session_no_bak)
            <small class="text-muted d-block mt-1">Pilih tanggal penerimaan, tanggal bongkar, supplier, no bak, dan jenis penerimaan terlebih dahulu</small>
        @endif
    </div>

    <div>
        <p style="font-weight: bold;">
            *20 UP, 20 DOWN.
        </p>
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

        #table .section-20up {
            background-color: #e3f2fd;
            width: 50px;
            min-width: 50px;
            max-width: 50px;
        }

        #table .section-20down {
            background-color: #fff3e0;
            width: 50px;
            min-width: 50px;
            max-width: 50px;
        }

        #table .total-row {
            background-color: #e8f5e8;
            font-weight: bold;
            font-size: 9px;
        }

        #table .action-column {
            width: 60px;
            min-width: 60px;
            max-width: 60px;
        }

        #table .action-btn {
            padding: 2px 4px;
            font-size: 10px;
            margin: 1px;
            border-radius: 2px;
        }

        #table .no-column {
            width: 35px;
            min-width: 35px;
            max-width: 35px;
            font-size: 9px;
        }

        #table .suhu-column {
            width: 65px;
            min-width: 65px;
            max-width: 65px;
            background-color: #f0f8ff;
            font-weight: bold;
        }

        #table .no-bak-column {
            width: 50px;
            min-width: 50px;
            max-width: 50px;
            background-color: #f0f8ff;
            font-weight: bold;
        }
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .table-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 10px;
            }
            #table {
                font-size: 10px;
                max-width: 100%;
            }
            
            #table th,
            #table td {
                padding: 2px 4px;
                font-size: 10px;
            }
            
            #table .action-btn {
                padding: 2px 4px;
                font-size: 10px;
            }
        }
    </style>

    <div style="display: flex; flex-wrap: wrap;"> 
        <table class="table table-bordered" id="table"> 
            <thead> 
                <tr> 
                    <th rowspan="4">NO. BAK</th> 
                    <!--th rowspan="2" class="no-column">NO</th--> 
                    <th colspan="2" class="section-20up">20 UP</th> 
                    <th colspan="2" class="section-20down">20 DOWN</th> 
                    <th rowspan="2" class="suhu-column">Suhu (°C)</th> 
                    <th rowspan="2" class="action-column">Action</th> 
                </tr> 
                <tr> 
                    <th class="section-20up">B/C</th> 
                    <th class="section-20up">D</th> 
                    <th class="section-20down">B/C</th> 
                    <th class="section-20down">D</th> 
                </tr> 
            </thead> 
            <tbody> 
                @php 
                    $grouped = $records->groupBy('no_bak'); 
                @endphp 
                
                @foreach($grouped as $no_bak => $items) 
                    @foreach($items->chunk(8) as $chunk) 
                        @foreach ($chunk as $key => $item) 
                            <tr> 
                                @if($loop->first) 
                                    <td rowspan="{{ $chunk->count() }}">{{ $no_bak }}</td> 
                                @endif 
                                    <!--td class="no-column">{{ $key + 1 }}</td--> 
                                    <!-- 20 UP Section --> 
                                    <td class="section-20up">{{ $item->grade->grade == 'B/C' && $item->kategori_berat_penerimaan->kategori_berat == '20 UP' ? $item->berat_ikan : '' }}</td> 
                                    <td class="section-20up">{{ $item->grade->grade == 'D' && $item->kategori_berat_penerimaan->kategori_berat == '20 UP' ? $item->berat_ikan : '' }}</td> 
                                    <!-- 20 DOWN Section --> 
                                    <td class="section-20down">{{ $item->grade->grade == 'B/C' && $item->kategori_berat_penerimaan->kategori_berat == '20 DOWN' ? $item->berat_ikan : '' }}</td> 
                                    <td class="section-20down">{{ $item->grade->grade == 'D' && $item->kategori_berat_penerimaan->kategori_berat == '20 DOWN' ? $item->berat_ikan : '' }}</td> 
                                    <!-- Suhu Column --> 
                                    <td class="suhu-column">{{ $item->suhu_ikan ?? '-' }}°C</td> 
                                    <td class="action-column"> 
                                        <button type="button" class="btn btn-outline-primary action-btn" 
                                            data-bs-toggle="modal" data-bs-target="#editModal{{ $item->penerimaan_id }}" 
                                            wire:click="edit({{ $item->penerimaan_id }})" 
                                            title="Edit {{ $item->supplier->nama_supplier }} - {{ $item->grade->grade }} ({{ $item->berat_ikan }}kg)"> 
                                            <i class="bi bi-pencil"></i>
                                        </button> 
                                        <button type="button" class="btn btn-outline-danger action-btn" 
                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->penerimaan_id }}" 
                                            title="Hapus {{ $item->supplier->nama_supplier }} - {{ $item->grade->grade }} ({{ $item->berat_ikan }}kg)"> 
                                            <i class="bi bi-trash"></i> 
                                        </button> 
                                    </td> 
                                </tr> 
                        @endforeach 
                
                        @php
                            $dataCollection = collect($data);

                            // 20 UP columns (≥20kg)
                            $total_20up_bc = $dataCollection
                                ->where('grade.grade', 'B/C')
                                ->where('kategori_berat_penerimaan.kategori_berat', '20 UP')
                                ->sum('berat_ikan');
                            $total_20up_d = $dataCollection
                                ->where('grade.grade', 'D')
                                ->where('kategori_berat_penerimaan.kategori_berat', '20 UP')
                                ->sum('berat_ikan');
                            // 20 DOWN columns (10-19kg)
                            $total_20down_bc = $dataCollection
                                ->where('grade.grade', 'B/C')
                                ->where('kategori_berat_penerimaan.kategori_berat', '20 DOWN')
                                ->sum('berat_ikan');
                            $total_20down_d = $dataCollection
                                ->where('grade.grade', 'D')
                                ->where('kategori_berat_penerimaan.kategori_berat', '20 DOWN')
                                ->sum('berat_ikan');
                        @endphp

                            <tr class="total-row">
                                <td><strong>Total (kg)</strong></td>
                                <td class="section-20up"><strong>{{ $total_20up_bc }}</strong></td>
                                <td class="section-20up"><strong>{{ $total_20up_d }}</strong></td>
                                <td class="section-20down"><strong>{{ $total_20down_bc }}</strong></td>
                                <td class="section-20down"><strong>{{ $total_20down_d }}</strong></td>
                                <td class="suhu-column">-</td>
                                <td></td>
                            </tr>
                            <tr class="total-row">
                                <td><strong>Total (Ekor)</strong></td>
                                <td class="section-20up"><strong>{{ $data->where('grade.grade', 'B/C')->where('kategori_berat_penerimaan.kategori_berat', '20 UP')->count() }}</strong></td>
                                <td class="section-20up"><strong>{{ $data->where('grade.grade', 'D')->where('kategori_berat_penerimaan.kategori_berat', '20 UP')->count() }}</strong></td>
                                <td class="section-20down"><strong>{{ $data->where('grade.grade', 'B/C')->where('kategori_berat_penerimaan.kategori_berat', '20 DOWN')->count() }}</strong></td>
                                <td class="section-20down"><strong>{{ $data->where('grade.grade', 'D')->where('kategori_berat_penerimaan.kategori_berat', '20 DOWN')->count() }}</strong></td>
                                <td class="suhu-column">-</td>
                                <td></td>
                            </tr>
                        </tbody>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

<!-- Modal Edit dan Delete untuk semua item -->
@foreach ($data as $item)
    <!-- Modal Edit -->
    <div wire:ignore.self class="modal fade" id="editModal{{ $item->penerimaan_id }}" tabindex="-1"
        role="dialog" aria-labelledby="editModalLabel{{ $item->penerimaan_id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $item->penerimaan_id }}">
                        Edit Penerimaan Ikan - {{ $item->grade->grade }} ({{ $item->berat_ikan }}kg)
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    @if($session_date && $session_tgl_bongkar && $session_supplier && $session_jenis_penerimaan && $session_no_bak)
                        @php
                            $selectedSupplier = $suppliers->firstWhere('supplier_id', $session_supplier);
                        @endphp
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> 
                            <strong>Sesi Aktif:</strong><br>
                            <strong>Tanggal Penerimaan:</strong> {{ \Carbon\Carbon::parse($session_date)->format('d F Y') }}<br>
                            <strong>Tanggal Bongkar:</strong> {{ \Carbon\Carbon::parse($session_tgl_bongkar)->format('d F Y') }}<br>
                            <strong>Supplier:</strong> {{ $selectedSupplier ? $selectedSupplier->nama_supplier : 'Unknown' }}<br>
                            <strong>Jenis Penerimaan:</strong> {{ $session_jenis_penerimaan }}<br>
                            <strong>No. Bak:</strong> {{ $session_no_bak }}
                        </div>
                    @endif

                    <form wire:submit.prevent="update" class="mt-0">
                        <div class="form-group mb-3">
                            <label for="edit_grade_id" class="form-label">Grade</label>
                            <select wire:model="edit_grade_id" class="form-select border-primary" required>
                                <option value="">Pilih Grade</option>
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade->id }}" {{ $edit_grade_id == $grade->id ? 'selected' : '' }}>
                                        {{ $grade->grade }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_berat_ikan" class="form-label">Berat Ikan (kg)</label>
                            <input type="number" wire:model="edit_berat_ikan" step="0.01"
                                   class="form-control border-primary" min="0.01" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_suhu_ikan" class="form-label">Suhu Ikan (°C)</label>
                            <input type="number" wire:model="edit_suhu_ikan" step="0.1" min="-50" max="50"
                                   class="form-control border-primary" required>
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

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal{{ $item->penerimaan_id }}" tabindex="-1"
        role="dialog" aria-labelledby="deleteModalLabel{{ $item->penerimaan_id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel{{ $item->penerimaan_id }}">
                        Hapus Penerimaan Ikan - {{ $item->grade->grade }} ({{ $item->berat_ikan }}kg)
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data ini?</p>
                    <div class="alert alert-info">
                        <strong>Data yang akan dihapus:</strong><br>
                        Supplier: {{ $item->supplier->nama_supplier }}<br>
                        Jenis Penerimaan: {{ $item->jenis_penerimaan }}<br>
                        Tanggal Penerimaan: {{ \Carbon\Carbon::parse($item->tgl_penerimaan)->format('d/m/Y') }}<br>
                        Tanggal Bongkar: {{ \Carbon\Carbon::parse($item->tgl_bongkar)->format('d/m/Y') }}<br>
                        Grade: {{ $item->grade->grade }}<br>
                        Berat: {{ $item->berat_ikan }} kg<br>
                        Suhu: {{ $item->suhu_ikan ?? '-' }}°C<br>
                        No Bak: {{ $item->no_bak }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger"
                        wire:click="delete({{ $item->penerimaan_id }})"
                        data-bs-dismiss="modal">Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endforeach


    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('closeModal', () => {
                // Close the add data modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('tambahDataModal'));
                if (modal) {
                    modal.hide();
                }
            });
        });
    </script>

</div>
