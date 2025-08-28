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

    {{-- Form Input Data & Filter --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Filter & Input Data Penerimaan</h5>
            <div>
                <button type="button" wire:click="filterData" class="btn btn-primary btn-sm me-1">
                    <i class="bi bi-funnel"></i> Terapkan Filter
                </button>
                <button type="button" wire:click="resetFilter" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="session_date" class="form-label">Tanggal Penerimaan</label>
                    <input type="date" id="session_date" 
                           wire:model.live="session_date" 
                           class="form-control @error('session_date') is-invalid @enderror" 
                           required>
                    @error('session_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
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

                <div class="col-md-3">
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

                <div class="col-md-3">
                    <label for="session_jenis_penerimaan" class="form-label">Jenis Penerimaan</label>
                    <select id="session_jenis_penerimaan"
                            wire:model.live="session_jenis_penerimaan"
                            wire:loading.attr="disabled"
                            class="form-select @error('session_jenis_penerimaan') is-invalid @enderror"
                            @if(!$session_date || !$session_tgl_bongkar || !$session_supplier) disabled @endif 
                            required>
                        <option value="" selected disabled>Pilih Jenis Penerimaan</option>
                        <option value="Fresh GG">Fresh GG</option>
                        <option value="Frozen WR YF">Frozen WR YF</option>
                        <option value="Frozen WR BF">Frozen WR BF</option>
                        <option value="Frozen WR BE">Frozen WR BE</option>
                        <option value="Frozen GG YF">Frozen GG YF</option>
                        <option value="Frozen GG BF">Frozen GG BF</option>
                        <option value="Frozen GG BE">Frozen GG BE</option>
                    </select>
                    @error('session_jenis_penerimaan')
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="session_no_bak" class="form-label">No. Bak</label>
                    <input type="text" id="session_no_bak" 
                           wire:model.live="session_no_bak" 
                           class="form-control @error('session_no_bak') is-invalid @enderror"
                           @if(!$session_date || !$session_tgl_bongkar || !$session_supplier || !$session_jenis_penerimaan) disabled @endif 
                           required>
                    @error('session_no_bak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Status Sesi --}}
    <div class="row mt-3">
        <div class="col-12">
            @if($session_date && $session_tgl_bongkar && $session_supplier && $session_jenis_penerimaan && $session_no_bak)
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

    {{-- Tombol Tambah Data --}}
    {{-- ======== TABEL INPUT DETAIL (berat & suhu) ======== --}}
    <div class="card" style="max-width: 450px;">
        <div class="card-header d-flex justify-content-between align-items-center py-1 px-2">
            <span class="small fw-bold">Tally Penerimaan Ikan Tuna</span>
            <button class="btn btn-sm btn-success py-0 px-1" wire:click="addRow" style="font-size: 0.7rem;">
                <i class="bi bi-plus-circle"></i> <span class="small">Tambah</span>
            </button>
        </div>
        <div class="card-body p-1">
            <div class="table-responsive">
            <table class="table table-bordered table-sm text-center align-middle" style="font-size: .75rem;">
            <table class="table table-bordered table-sm align-middle mb-0">
            <thead class="table-light text-center align-middle">
                <tr>
                    {{-- No Bak dan Aksi menempel ke bawah --}}
                    <th rowspan="2" style="width: 100px;">No. Bak</th>

                    {{-- Grade di atas --}}
                    <th colspan="2">
                        <select wire:model.live="selected_grade_id" 
                                class="form-control form-control-sm text-center" 
                                style="font-size:.8rem; height:30px;">
                            <option value="">-- Grade/Size --</option>
                            @foreach($grades as $grade)
                                @foreach($kategori_berat as $kategori)
                                    <option value="{{ $grade->grade_id }}_{{ $kategori->kategori_berat_id }}">
                                        {{ $grade->grade }} {{ $kategori->kategori_berat }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    </th>

                    <th rowspan="2" style="width: 80px;">Aksi</th>
                </tr>
                <tr>
                    <th style="width: 120px;">Berat (Kg)</th>
                    <th style="width: 120px;">Suhu (°C)</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $rowsCollection = collect($rows ?? []);
                    $total_berat = $rowsCollection->sum(fn($r) => (float)($r['berat_ikan'] ?? 0));
                    $total_ekor  = $rowsCollection->count();
                @endphp

                @if(isset($rows) && count($rows) > 0)
                    @foreach($rows as $index => $row)
                        <tr>
                            {{-- No. Bak --}}
                            <td class="text-center align-middle">
                                {{ $session_no_bak }}</td>

                            {{-- Berat --}}
                            <td>
                                <input type="number" step="0.01" 
                                    wire:model="rows.{{ $index }}.berat_ikan"
                                    class="form-control form-control-sm text-center"
                                    placeholder="Kg"
                                    required>
                                @error('rows.'.$index.'.berat_ikan')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </td>

                            {{-- Suhu --}}
                            <td>
                                <input type="number" step="0.1" 
                                    wire:model="rows.{{ $index }}.suhu_ikan"
                                    class="form-control form-control-sm text-center"
                                    placeholder="°C"
                                    required>
                                @error('rows.'.$index.'.suhu_ikan')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm py-0"
                                        wire:click="removeRow({{ $index }})"
                                        style="font-size:.7rem; height:30px; width:30px;">
                                    <i class="bi bi-x"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif

                @if(isset($rows) && count($rows) > 0)
                    <tr class="table-secondary fw-bold text-center">
                        <td>Total</td>
                        <td>{{ number_format($total_berat, 2) }} kg</td>
                        <td>{{ $total_ekor }} ekor</td>
                        <td></td>
                    </tr>
                @endif
            </tbody>
        </table>
      

        </div>
        <div class="card-footer text-end py-1 px-2">
            <button class="btn btn-primary btn-sm py-0 px-2" wire:click="saveAll" 
                style="font-size: 0.7rem; height: 30px;">
                <i class="bi bi-save"></i> Simpan
            </button>
        </div>
    </div>

    {{-- ALERT PESAN --}}
    @if (session()->has('message'))
        <div class="alert alert-success mt-3">
            {{ session('message') }}
        </div>
    @endif
</div>

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
