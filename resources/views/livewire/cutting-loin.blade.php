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
    <div class="card shadow-sm border-0">
        <div class="card-header py-2 px-3 text-white"
             style="background: linear-gradient(135deg,hsl(210, 97.60%, 48.80%),rgba(209, 202, 0, 0.88)); font-size: 0.85rem;">
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
                           @if(!$session_tggl_cutting) disabled @endif 
                            min="{{ $session_tggl_cutting }}"
                           required>
                    @error('session_tggl_service')
                        <div class="invalid-feedback small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-auto">
                    <label for="penerimaan_id" class="form-label small">Jenis Penerimaan</label>
                    <select id="penerimaan_id" 
                            wire:model.live="penerimaan_id"
                            class="form-select form-select-sm @error('penerimaan_id') is-invalid @enderror"
                            @if(!$selectedTanggalPenerimaan) disabled @endif 
                            required>
                        <option value="">Pilih Jenis Penerimaan</option>
                        @forelse ($filteredPenerimaan as $penerimaan)
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