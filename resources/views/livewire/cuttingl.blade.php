<div>
    <!-- Success/Eror Message -->
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

    {{-- Form Input Data & Filter --}}
    <div class="card shadow-sm border-0">
        <div class="card-header py-2 px-3 text white"
            style="background: linear-gradient(135deg, hsl(210, 97.60%, 48.80%), rgba(209, 202, 0, 0.88)); font-size: 0.85rem;">
            <i class="bi bi-pencil-square me-1"></i>Form Input Data Cutting
        </div>
        <div class="card-body p-3">
            <div class="row g-2">
                <div class="col-md-auto">
                    <label for="session_tggl_cutting" class="form-label small">Tanggal Cutting</label>
                    <input type="date" id="session_tggl_cutting" 
                           wire:model.live="session_tggl_cutting" 
                           class="form-control form-control-sm @error('session_tggl_cutting') is-invalid @enderror"
                           required>
                    @error('session_tggl_cutting')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>  

                <div class="col-md-auto">
                    <label for="session_tggl_injek_co" class="form-label small">Tanggal Injek CO</label>
                    <input type="date" id="session_tggl_injek_co" 
                           wire:model.live="session_tggl_injek_co"
                           class="form-control form-control-sm @error('session_tggl_injek_co') is-invalid @enderror"
                           @if(!$session_tggl_cutting) disabled @endif 
                           min="{{ $session_tggl_cutting }}"
                           required>
                    @error('session_tggl_injek_co')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-auto">
                    <label for="session_tggl_service" class="form-label small">Tanggal Service</label>
                    <input type="date" id="session_tggl_service" 
                           wire:model.live="session_tggl_service"
                           class="form-control form-control-sm @error('session_tggl_service') is-invalid @enderror"
                           @if(!$session_tggl_injek_co) disabled @endif 
                           min="{{ $session_tggl_injek_co }}"
                           required>
                    @error('session_tggl_service')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-auto">
                    <label for="penerimaan_id" class="form-label small">Supplier</label>
                    <select id="penerimaan_id"
                            wire:model.live="penerimaan_id"
                            class="form-select form-select-sm @error('penerimaan_id') is-invalid @enderror"
                            @if(!$session_tggl_service) disabled @endif
                            required>
                        <option value="">Supplier</option>
                        @forelse ($penerimaan_ikan as $penerimaan)
                            @php
                                $jenis = $penerimaan->jenis_penerimaan;
                                $supplier = $penerimaan->supplier->nama_supplier ?? 'Tidak ada supplier';
                                $alamat = $penerimaan->supplier->alamat ?? 'Tidak ada alamat';
                                $displayText = $jenis . '  ' . $alamat . '  ' . $supplier;
                            @endphp
                            <option value="{{ $penerimaan->penerimaan_id }}">
                                {{ $displayText }}
                            </option>
                        @empty
                            <option value="">Tidak ada data penerimaan ikan</option>
                        @endforelse
                    </select>
                    @error('penerimaan_id')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Status Sesi --}}
    <div class="row mt-3">
        <div class="col-12">
            @if($session_tggl_cutting && $session_tggl_injek_co && $penerimaan_id)
                @php    
                    $selectedPenerimaan = $penerimaan_ikan->firstWhere('penerimaan_id', $penerimaan_id);
                @endphp
                <div class="p-2 rounded-3 shadow-sm text-white"
                    style="background: linear-gradient(135deg,hsl(210, 97.60%, 48.80%),rgba(209, 202, 0, 0.88)); font-size: 0.75rem;">
                    <i class="bi bi-check-circle-fill me-1"></i> 
                    <strong>Sesi Aktif:</strong>
                    <div class="mt-1">
                        <span><strong>Tanggal Cutting:</strong> {{ \Carbon\Carbon::parse($session_tggl_cutting)->format('d F Y') }}</span><br>
                        <span><strong>Tanggal Injek CO:</strong> {{ \Carbon\Carbon::parse($session_tggl_injek_co)->format('d F Y') }}</span><br>
                        @if($selectedPenerimaan)
                            <span><strong>Tanggal Penerimaan:</strong> {{ \Carbon\Carbon::parse($selectedPenerimaan->tgl_penerimaan)->format('d F Y') }}</span><br>
                            <span><strong>Jenis Penerimaan:</strong> {{ $selectedPenerimaan->jenis_penerimaan }}</span><br>
                            <span><strong>Supplier:</strong> {{ $selectedPenerimaan->supplier->nama_supplier ?? 'Tidak ada supplier' }}</span>
                        @endif
                    </div>
                </div>
            @else
                <div class="p-2 rounded-3 shadow-sm text-white"
                    style="background:hsl(210, 97.60%, 48.80%); border: 1px solid rgb(255, 255, 255); font-size: 0.75rem;">
                    <i class="bi bi-info-circle me-1"></i> 
                    @if(!$session_tggl_cutting)
                        Pilih tanggal cutting terlebih dahulu.
                    @elseif(!$session_tggl_injek_co)
                        Pilih tanggal injek CO terlebih dahulu.
                    @elseif(!$selectedTanggalPenerimaan)
                        Pilih tanggal penerimaan untuk melanjutkan input data.
                    @elseif(!$penerimaan_id)
                        Pilih jenis penerimaan untuk melanjutkan input data.
                    @else
                        Lengkapi semua data sesi terlebih dahulu.
                    @endif
                </div>
            @endif
        </div>
    </div>

    {{-- Style Tabel CSS --}}
    <style>
        .excel-table {
            font-size: 0.75rem;
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }
        .excel-table th, 
        .excel-table td {
            border: 1px solid hsl(0, 100.00%, 0.40%);
            padding: 2px 4px;
            vertical-align: middle;
        }
        .excel-input {
            width: 100%;
            height: 22px;
            padding: 0 2px;
            font-size: 0.75rem;
            font-family: 'Arial Narrow', sans-serif;
            border: 1px solid hsl(0, 89.20%, 7.30%);
            border-radius: 3px;
        }
        .excel-input:focus {
            border-color: hsl(0, 89.20%, 7.30%);
            box-shadow: none;
        }
        .excel-table select {
            height: 22px;
            font-size: 0.75rem;
            padding: 0 2px;
            border-radius: 0;
        }
        .excel-table .btn-sm {
            padding: 0 6px;
            height: 22px;
            font-size: 0.7rem;
            line-height: 1;
        }   
    </style>

    {{-- ======== TABEL INPUT DETAIL (berat & pcs) + Tombol Tambah & Simpan ======== --}}
    <div class="d-flex justify-content-center my-3">
        <div class="card-header d-flex justify-content-between align-items-center py-1 px-2" style="max-width: 450px;">
            <span class="fw-semibold" style="font-size: 1.3rem; font-family: 'Copperplate', fantasy; color:rgb(16, 10, 10); letter-spacing: 1px; text-transform: uppercase;">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" width="100" height="100"> Tally Cutting By Loin</span>
        </div>
    </div>

    <div class="card-body p-1">
        <button class="btn btn-sm btn-success py-0 px-1 mb-2" wire:click="addRow" style="font-size: 0.8rem;">
            <i class="bi bi-plus-circle"></i> <span>Tambah</span>
        </button>
        <div class="card shadow-sm mb-2">
            <div class="table-responsive">
                <table class="excel-table">
                    <thead class="table-light text-center align-middle" style="background-color:rgb(121, 173, 246);">
                        <tr>
                            <th rowspan="4" style="width: 5px;">No</th>
                            <th colspan="9" style="width: 200px;">No. Batch</th>
                            <th rowspan="4" style="width: 5px;">Aksi</th>
                        </tr>
                        <tr>
                            <th colspan="3" style="width: 30px;">Cutting</th>
                            <th colspan="3" style="width: 30px;">RM Service</th>
                            <th colspan="3" style="width: 30px;">Hasil Service</th>
                        </tr>
                        <tr>
                            <th colspan="3" style="width: 30px;">Grade</th>
                            <th colspan="1" style="width: 30px;">Grade</th>
                            <th colspan="1" style="width: 30px;">Grade</th>
                            <th colspan="1" style="width: 30px;">Grade</th>
                            <th colspan="1" style="width: 30px;">Grade</th>
                            <th colspan="1" style="width: 30px;">Grade</th>
                            <th colspan="1" style="width: 30px;">Grade</th>
                        </tr>
                        <tr>
                            <th colspan="1" style="width: 30px;">Berat</th>
                            <th colspan="1" style="width: 30px;">Suhu Loin</th>
                            <th colspan="1" style="width: 30px;">No. Loin</th>
                            <th colspan="1" style="width: 30px;">Berat</th>
                            <th colspan="1" style="width: 30px;">Berat</th>
                            <th colspan="1" style="width: 30px;">Berat</th>
                            <th colspan="1" style="width: 30px;">Berat</th>
                            <th colspan="1" style="width: 30px;">Berat</th>
                            <th colspan="1" style="width: 30px;">Berat</th>
                        </tr>
                    </thead>

                    <tbody>
                            



                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
 