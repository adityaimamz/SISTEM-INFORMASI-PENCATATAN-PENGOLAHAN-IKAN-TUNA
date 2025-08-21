@php
    use App\Models\Penerimaan_ikan;
    use App\Models\Supplier;

    $Penerimaan_ikan = Penerimaan_ikan::all();
@endphp 

<div class="d-flex flex-column">
    <div class="d-flex justify-content-between mb-2">
        <div class="form-group" style="width: 45%;">
            <label for="tgl_cutting">Tanggal Cutting</label>
            <input type="date" id="tgl_cutting" wire:model.defer="tgl_cutting" class="form-control border-primary" required>
            @error('tgl_cutting') <span class="text-danger">{{ $message }}</span> @enderror
            <label for="tgl_injek_co" class="mt-2">Tanggal Injek CO</label>
            <input type="date" id="tgl_injek_co" wire:model.defer="tgl_injek_co" class="form-control border-primary"
                min="{{ $tgl_cutting }}" required>
            @error('tgl_injek_co') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6" style="width: 45%;">
            <label for="supplier_id">Supplier</label>
            <select id="supplier_id" wire:model.defer="selectedSupplier" class="form-control border-primary"
                @if(!$tgl_cutting || !$tgl_injek_co) disabled @endif required>
                <option value="" selected disabled>Pilih Supplier</option>
                @foreach($Penerimaan_ikan as $penerimaan_ikan)
                    <option value="{{ $penerimaan_ikan->supplier_id }}">
                        {{ $penerimaan_ikan->supplier->nama_supplier }}
                    </option>
                @endforeach
            </select>
            @error('selectedSupplier') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            @if($tgl_cutting && $tgl_injek_co && $selectedSupplier)
                <div class="alert alert-success mb-0">
                    <i class="bi bi-check-circle"></i>
                    <strong>Sesi Aktif:</strong><br>
                    <strong>Tanggal Cutting:</strong> {{ \Carbon\Carbon::parse($tgl_cutting)->format('d F Y') }}<br>
                    <strong>Tanggal Injek Co:</strong> {{ \Carbon\Carbon::parse($tgl_injek_co)->format('d F Y') }}<br>
                    <strong>Supplier:</strong> {{ $selectedSupplier ? $selectedSupplier->supplier->nama_supplier : 'Unknown' }}<br>
                </div>
            @elseif(!$tgl_cutting || !$tgl_injek_co || !$selectedSupplier)
                <div class="alert alert-warning mb-0">
                    <i class="bi bi-exclamation-triangle"></i>
                    @if(!$tgl_cutting)
                        Pilih tanggal cutting terlebih dahulu.
                    @elseif(!$tgl_injek_co)
                        Pilih tanggal injeksi co terlebih dahulu.
                    @elseif(!$selectedSupplier)
                        Pilih supplier untuk melanjutkan input data.
                    @endif
                </div>
            @else
                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle"></i>
                    Pilih tanggal cutting, tanggal injeksi co, dan supplier terlebih dahulu.
                </div>
            @endif
        </div>
    <!-- Add Data Button -->
    <div class="mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahDataModal"
            @if(!$tgl_cutting || !$tgl_injek_co || !$selectedSupplier) disabled @endif>
            <i class="bi bi-plus-circle"></i> Tambah
        </button>
        @if(!$tgl_cutting || !$tgl_injek_co || !$selectedSupplier)
            <small class="text-muted d-block mt-1">Pilih tanggal cutting, tanggal injeksi co, dan supplier terlebih dahulu</small>
        @endif
    </div>
    