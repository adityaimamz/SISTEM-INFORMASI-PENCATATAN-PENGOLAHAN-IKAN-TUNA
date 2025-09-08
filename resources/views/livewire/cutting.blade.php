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

    {{-- Form Data & Filter --}}
    <div class="card shadow-sm border-0">
        <div class="card-header py-2 px-3 text-white"
             style="background: linear-gradient(135deg,hsl(210, 97.60%, 48.80%),rgba(209, 202, 0, 0.88)); font-size: 0.85rem;">
            <i class="bi bi-pencil-square me-1"></i>Form Input Data Cutting
        </div>  
        <div class="card-body p-3">
            <div class="row g-2">
                <div class="col-md-auto">
                    <label for="tgl_cutting" class="form-label small">Tanggal Cutting</label>
                        <input type="date" id="tgl_cutting" 
                            wire:model.live="tgl_cutting" 
                            class="form-control form-control-sm @error('tgl_cutting') is-invalid @enderror"
                            required>
                        @error('tgl_cutting')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                </div>

                <div class="col-md-auto">
                    <label for="tgl_injek_co" class="form-label small">Tanggal Injek CO</label>
                        <input type="date" id="tgl_injek_co" 
                            wire:model.live="tgl_injek_co"
                            class="form-control form-control-sm @error('tgl_injek_co') is-invalid @enderror"
                            @if($tgl_cutting) disabled @endif 
                            min="{{ $tgl_cutting }}"
                            required>
                        @error('tgl_injek_co')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                </div>

                <div class="col-md-auto">
                    <label for="tanggal_penerimaan" class="form-label small">Tanggal Penerimaan</label>
                        <select id="tanggal_penerimaan" 
                            wire:model.live="penerimaan_id"
                            class="form-select form-select-sm @error('penerimaan_id') is-invalid @enderror"
                            @if(!$tgl_injek_co) disabled @endif 
                            required>
                        <option value="">Pilih Tanggal Penerimaan</option>
                        @foreach ($penerimaan_ikan as $penerimaan)
                            <option value="{{ $penerimaan->id }}">
                                {{ \Carbon\Carbon::parse($penerimaan->tgl_penerimaan)->format('d F Y') }} - {{ $penerimaan->supplier->nama_supplier }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-auto">
                    <label for="jenis_penerimaan" class="form-label small">Jenis Penerimaan</label>
                        <select id="jenis_penerimaan" 
                            wire:model.live="penerimaan_id"
                            class="form-select form-select-sm @error('penerimaan_id') is-invalid @enderror"
                            @if(!$tanggal_penerimaan) disabled @endif 
                            required>
                        <option value="">Pilih Jenis Penerimaan</option>
                        @foreach ($penerimaan_ikan as $penerimaan)
                            <option value="{{ $penerimaan->id }}">
                                {{ $penerimaan->jenis_penerimaan }} - {{ $penerimaan->supplier->nama_supplier }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    