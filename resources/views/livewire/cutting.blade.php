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
                    <label for="session_tgl_cutting" class="form-label small">Tanggal Cutting</label>
                        <input type="date" id="session_tgl_cutting" 
                            wire:model.live="session_tgl_cutting" 
                            class="form-control form-control-sm @error('session_tgl_cutting') is-invalid @enderror"
                            required>
                        @error('session_tgl_cutting')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                </div>

                <div class="col-md-auto">
                    <label for="session_tgl_injek_co" class="form-label small">Tanggal Injek CO</label>
                        <input type="date" id="session_tgl_injek_co" 
                            wire:model.live="session_tgl_injek_co"
                            class="form-control form-control-sm @error('session_tgl_injek_co') is-invalid @enderror"
                            @if(!$session_tgl_cutting) disabled @endif 
                            min="{{ $session_tgl_cutting }}"
                            required>
                        @error('session_tgl_injek_co')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                </div>

                <div class="col-md-auto">
                    <label for="selectedTanggalPenerimaan" class="form-label small">Tanggal Penerimaan</label>
                        <select id="selectedTanggalPenerimaan" 
                            wire:model.live="selectedTanggalPenerimaan"
                            wire:change="updateSelectedTanggalPenerimaan($event.target.value)"
                            class="form-select form-select-sm @error('selectedTanggalPenerimaan') is-invalid @enderror"
                            @if(!$session_tgl_injek_co) disabled @endif 
                            required>
                            <option value="">Pilih Tanggal Penerimaan</option>
                            @foreach ($penerimaan_ikan->unique('tgl_penerimaan') as $penerimaan)
                                <option value="{{ $penerimaan->penerimaan_id }}">
                                    {{ \Carbon\Carbon::parse($penerimaan->tgl_penerimaan)->format('d F Y') }}
                                </option>
                            @endforeach
                        </select>
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
                                    $displayText = $jenis . ' ' . $supplier;
                                @endphp
                                <option value="{{ $penerimaan->penerimaan_id }}">
                                    {{ $displayText }}
                                </option>
                            @empty
                                <option value="">Tidak ada data penerimaan ikan</option>
                            @endforelse
                        </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Status Sesi --}}
    <div class="row mt-3">
        <div class="col-12">
            @if($session_tgl_cutting && $session_tgl_injek_co && $penerimaan_id)
                <div class="p-2 rounded-3 shadow-sm text-white"
                    style="background: linear-gradient(135deg,hsl(210, 97.60%, 48.80%),rgba(209, 202, 0, 0.88)); font-size: 0.75rem;">
                    <i class="bi bi-check-circle-fill me-1"></i> 
                    <strong>Sesi Aktif:</strong>
                    <div class="mt-1">
                        <span><strong>Tanggal Cutting       :</strong> {{ \Carbon\Carbon::parse($session_tgl_cutting)->format('d F Y') }}</span><br>
                        <span><strong>Tanggal Injek CO      :</strong> {{ \Carbon\Carbon::parse($session_tgl_injek_co)->format('d F Y') }}</span><br>
                        @if($penerimaan_id && $filteredPenerimaan->isNotEmpty())
                            <span><strong>Jenis Penerimaan  :</strong> 
                                {{ $filteredPenerimaan->firstWhere('penerimaan_id', $penerimaan_id)->jenis_penerimaan }}
                            </span><br>
                        @endif
                    </div>
                </div>
            @else
                <div class="p-2 rounded-3 shadow-sm text-white"
                    style="background:hsl(210, 97.60%, 48.80%); border: 1px solid rgb(255, 255, 255); font-size: 0.75rem;">
                    <i class="bi bi-info-circle me-1"></i> 
                    @if(!$session_tgl_cutting)
                        Pilih tanggal cutting terlebih dahulu.
                    @elseif(!$session_tgl_injek_co)
                        Pilih tanggal injek CO terlebih dahulu.
                    @elseif(!$penerimaan_id)
                        Pilih jenis penerimaan untuk melanjutkan input data.
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
                <img src="{{ asset('img/logo.png') }}" alt="Logo" width="100" height="100"> Tally Cutting By Produk</span>
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
                            <th rowspan="2" style="width: 100px;">No. Batch</th>
                            {{-- Produk Tabel 1 --}}
                            <th colspan="2">
                                <select wire:model.live="selected_produk_id" 
                                        class="excel-input @error('selected_produk_id') is-invalid @enderror" 
                                        required style="font-size:.8rem; height:30px; background-color:rgb(121, 173, 246);">
                                    <option value="" class="text-center" style="font-weight: bold;">-- Produk --</option>
                                    @foreach($kategori_byproduk_ct as $produk)
                                        <option value="{{ $produk->kategori_byproduk_ct_id }}" class="text-center">{{ $produk->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </th>
                            {{-- Produk Tabel 2 --}}
                            <th colspan="2">
                                <select wire:model.live="selected_produk_id" 
                                        class="excel-input @error('selected_produk_id') is-invalid @enderror" 
                                        required style="font-size:.8rem; height:30px; background-color:rgb(121, 173, 246);">
                                    <option value="" class="text-center" style="font-weight: bold;">-- Produk --</option>
                                    @foreach($kategori_byproduk_ct as $produk)
                                        <option value="{{ $produk->kategori_byproduk_ct_id }}" class="text-center">{{ $produk->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </th>
                            {{-- Produk Tabel 3 --}}
                            <th colspan="2">
                                <select wire:model.live="selected_produk_id" 
                                        class="excel-input @error('selected_produk_id') is-invalid @enderror" 
                                        required style="font-size:.8rem; height:30px; background-color:rgb(121, 173, 246);">
                                    <option value="" class="text-center" style="font-weight: bold;">-- Produk --</option>
                                    @foreach($kategori_byproduk_ct as $produk)
                                        <option value="{{ $produk->kategori_byproduk_ct_id }}" class="text-center">{{ $produk->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </th>
                            {{-- Produk Tabel 4 --}}
                            <th colspan="2">
                                <select wire:model.live="selected_produk_id" 
                                        class="excel-input @error('selected_produk_id') is-invalid @enderror" 
                                        required style="font-size:.8rem; height:30px; background-color:rgb(121, 173, 246);">
                                    <option value="" class="text-center" style="font-weight: bold;">-- Produk --</option>
                                    @foreach($kategori_byproduk_ct as $produk)
                                        <option value="{{ $produk->kategori_byproduk_ct_id }}" class="text-center">{{ $produk->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </th>
                            {{-- Produk Tabel 5 --}}
                            <th colspan="2">
                                <select wire:model.live="selected_produk_id" 
                                        class="excel-input @error('selected_produk_id') is-invalid @enderror" 
                                        required style="font-size:.8rem; height:30px; background-color:rgb(121, 173, 246);">
                                    <option value="" class="text-center" style="font-weight: bold;">-- Produk --</option>
                                    @foreach($kategori_byproduk_ct as $produk)
                                        <option value="{{ $produk->kategori_byproduk_ct_id }}" class="text-center">{{ $produk->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </th>
                            {{-- Produk Tabel 6 --}}
                            <th colspan="2">
                                <select wire:model.live="selected_produk_id" 
                                        class="excel-input @error('selected_produk_id') is-invalid @enderror" 
                                        required style="font-size:.8rem; height:30px; background-color:rgb(121, 173, 246);">
                                    <option value="" class="text-center" style="font-weight: bold;">-- Produk --</option>
                                    @foreach($kategori_byproduk_ct as $produk)
                                        <option value="{{ $produk->kategori_byproduk_ct_id }}" class="text-center">{{ $produk->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </th>
                            {{-- Produk Tabel 7 --}}
                            <th colspan="2">
                                <select wire:model.live="selected_produk_id" 
                                        class="excel-input @error('selected_produk_id') is-invalid @enderror" 
                                        required style="font-size:.8rem; height:30px; background-color:rgb(121, 173, 246);">
                                    <option value="" class="text-center" style="font-weight: bold;">-- Produk --</option>
                                    @foreach($kategori_byproduk_ct as $produk)
                                        <option value="{{ $produk->kategori_byproduk_ct_id }}" class="text-center">{{ $produk->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th rowspan="2" style="width: 40px;">Aksi</th>
                        </tr>
                        <tr>
                            <th style="width: 120px;">Berat (Kg)</th>
                            <th style="width: 120px;">Total (Pcs)</th>
                            <th style="width: 120px;">Berat (Kg)</th>
                            <th style="width: 120px;">Total (Pcs)</th>
                            <th style="width: 120px;">Berat (Kg)</th>
                            <th style="width: 120px;">Total (Pcs)</th>
                            <th style="width: 120px;">Berat (Kg)</th>
                            <th style="width: 120px;">Total (Pcs)</th>
                            <th style="width: 120px;">Berat (Kg)</th>
                            <th style="width: 120px;">Total (Pcs)</th>
                            <th style="width: 120px;">Berat (Kg)</th>
                            <th style="width: 120px;">Total (Pcs)</th>
                            <th style="width: 120px;">Berat (Kg)</th>
                            <th style="width: 120px;">Total (Pcs)</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $rowsCollection = collect($rows ?? []);
                            $total_berat1 = $rowsCollection->sum(fn($r) => (float)($r['berat_produk1'] ?? 0));
                            $total_berat2 = $rowsCollection->sum(fn($r) => (float)($r['berat_produk2'] ?? 0));
                            $total_berat3 = $rowsCollection->sum(fn($r) => (float)($r['berat_produk3'] ?? 0));
                            $total_berat4 = $rowsCollection->sum(fn($r) => (float)($r['berat_produk4'] ?? 0));
                            $total_berat5 = $rowsCollection->sum(fn($r) => (float)($r['berat_produk5'] ?? 0));
                            $total_berat6 = $rowsCollection->sum(fn($r) => (float)($r['berat_produk6'] ?? 0));
                            $total_berat7 = $rowsCollection->sum(fn($r) => (float)($r['berat_produk7'] ?? 0));
                            

                            $this->total_pcs1 = $rowsCollection->sum(function($row) {
                                $total = 0;
                                for ($i = 1; $i <= 1; $i++) {
                                    $total += (int)($row['total_produk' . $i] ?? 0);
                                }
                                return $total;
                            });
                            $this->total_pcs2 = $rowsCollection->sum(function($row) {
                                $total = 0;
                                for ($i = 2; $i <= 2; $i++) {
                                    $total += (int)($row['total_produk' . $i] ?? 0);
                                }
                                return $total;
                            });
                            $this->total_pcs3 = $rowsCollection->sum(function($row) {
                                $total = 0;
                                for ($i = 3; $i <= 3; $i++) {
                                    $total += (int)($row['total_produk' . $i] ?? 0);
                                }
                                return $total;
                            });
                            $this->total_pcs4 = $rowsCollection->sum(function($row) {
                                $total = 0;
                                for ($i = 4; $i <= 4; $i++) {
                                    $total += (int)($row['total_produk' . $i] ?? 0);
                                }
                                return $total;
                            });
                            $this->total_pcs5 = $rowsCollection->sum(function($row) {
                                $total = 0;
                                for ($i = 5; $i <= 5; $i++) {
                                    $total += (int)($row['total_produk' . $i] ?? 0);
                                }
                                return $total;
                            });
                            $this->total_pcs6 = $rowsCollection->sum(function($row) {
                                $total = 0;
                                for ($i = 6; $i <= 6; $i++) {
                                    $total += (int)($row['total_produk' . $i] ?? 0);
                                }
                                return $total;
                            });
                            $this->total_pcs7 = $rowsCollection->sum(function($row) {
                                $total = 0;
                                for ($i = 7; $i <= 7; $i++) {
                                    $total += (int)($row['total_produk' . $i] ?? 0);
                                }
                                return $total;
                            });
                        @endphp

                        @if(isset($rows) && count($rows) > 0)
                            @foreach($rows as $index => $row)
                                <tr>
                                {{-- No. Batch --}}
                                    <td>
                                        <input type="text" 
                                            wire:model="rows.{{ $index }}.no_batch" 
                                            class="excel-input text-center"
                                            placeholder="No Batch" 
                                            required>
                                            @error('rows.{{ $index }}.no_batch')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                    </td>
                                {{-- Berat & Total Produk 1 --}}
                                    <td>
                                        <input type="number" step="0.1" 
                                            wire:model="rows.{{ $index }}.berat_produk1"
                                            class="excel-input text-center"
                                            placeholder="Kg"
                                            required>
                                                @error('rows.{{ $index }}.berat_produk1')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                    </td>
                                    <td>
                                        <input type="number" 
                                            wire:model="rows.{{ $index }}.total_produk1"
                                            class="excel-input text-center"
                                            placeholder="Pcs"
                                            required>
                                                @error('rows.{{ $index }}.total_produk1')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                    </td>
                                {{-- Berat & Total Produk 2 --}}
                                    <td>
                                        <input type="number" step="0.1" 
                                            wire:model="rows.{{ $index }}.berat_produk2"
                                            class="excel-input text-center"
                                            placeholder="Kg"
                                            required>
                                                @error('rows.{{ $index }}.berat_produk2')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                    </td>
                                    <td>
                                        <input type="number" 
                                            wire:model="rows.{{ $index }}.total_produk2"
                                            class="excel-input text-center"
                                            placeholder="Pcs"
                                            required>
                                                @error('rows.{{ $index }}.total_produk2')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                    </td>
                                {{-- Berat & Total Produk 3 --}}
                                    <td>
                                        <input type="number" step="0.1" 
                                            wire:model="rows.{{ $index }}.berat_produk3"
                                            class="excel-input text-center"
                                            placeholder="Kg"
                                            required>
                                                @error('rows.{{ $index }}.berat_produk3')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                    </td>
                                    <td>
                                        <input type="number" 
                                            wire:model="rows.{{ $index }}.total_produk3"
                                            class="excel-input text-center"
                                            placeholder="Pcs"
                                            required>
                                                @error('rows.{{ $index }}.total_produk3')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                    </td>
                                {{-- Berat & Total Produk 4 --}}
                                    <td>
                                        <input type="number" step="0.1" 
                                            wire:model="rows.{{ $index }}.berat_produk4"
                                            class="excel-input text-center"
                                            placeholder="Kg"
                                            required>
                                                @error('rows.{{ $index }}.berat_produk4')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                    </td>
                                    <td>
                                        <input type="number" 
                                            wire:model="rows.{{ $index }}.total_produk4"
                                            class="excel-input text-center"
                                            placeholder="Pcs"
                                            required>
                                                @error('rows.{{ $index }}.total_produk4')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                    </td>
                                {{-- Berat & Total Produk 5 --}}
                                    <td>
                                        <input type="number" step="0.1" 
                                            wire:model="rows.{{ $index }}.berat_produk5"
                                            class="excel-input text-center"
                                            placeholder="Kg"
                                            required>
                                                @error('rows.{{ $index }}.berat_produk5')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                    </td>
                                    <td>
                                        <input type="number" 
                                            wire:model="rows.{{ $index }}.total_produk5"
                                            class="excel-input text-center"
                                            placeholder="Pcs"
                                            required>
                                                @error('rows.{{ $index }}.total_produk5')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                    </td>
                                {{-- berat & total produk 6 --}}
                                    <td>
                                        <input type="number" step="0.1" 
                                            wire:model="rows.{{ $index }}.berat_produk6"
                                            class="excel-input text-center"
                                            placeholder="Kg"
                                            required>
                                                @error('rows.{{ $index }}.berat_produk6')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                    </td>
                                    <td>
                                        <input type="number" 
                                            wire:model="rows.{{ $index }}.total_produk6"
                                            class="excel-input text-center"
                                            placeholder="Pcs"
                                            required>
                                                @error('rows.{{ $index }}.total_produk6')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                    </td>
                                {{-- berat & total produk 7 --}}
                                    <td>
                                        <input type="number" step="0.1" 
                                            wire:model="rows.{{ $index }}.berat_produk7"
                                            class="excel-input text-center"
                                            placeholder="Kg"
                                            required>
                                                @error('rows.{{ $index }}.berat_produk7')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                    </td>
                                    <td>
                                        <input type="number" 
                                            wire:model="rows.{{ $index }}.total_produk7"
                                            class="excel-input text-center"
                                            placeholder="Pcs"
                                            required>
                                                @error('rows.{{ $index }}.total_produk7')
                                                    <div class="text-danger small">{{ $message }}</div>
                                                @enderror
                                    </td>
                                {{-- aksi --}}
                                    <td>
                                        <button class="btn btn-danger btn-sm py-0"
                                                wire:click="removeRow({{ $index }})"
                                                style="font-size:.7rem; height:30px; width:30px;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        @if(isset($rows) && count($rows) > 0)
                            <tr class="table-secondary fw-bold excel-input text-center" style="background-color:rgb(121, 173, 246);">
                                <td>Total</td>
                                <td>{{ number_format($total_berat1, 2) }} kg</td>
                                <td>{{ $total_pcs1 }} pcs</td>
                                <td>{{ number_format($total_berat2, 2) }} kg</td>
                                <td>{{ $total_pcs2 }} pcs</td>
                                <td>{{ number_format($total_berat3, 2) }} kg</td>
                                <td>{{ $total_pcs3 }} pcs</td>
                                <td>{{ number_format($total_berat4, 2) }} kg</td>
                                <td>{{ $total_pcs4 }} pcs</td>
                                <td>{{ number_format($total_berat5, 2) }} kg</td>
                                <td>{{ $total_pcs5 }} pcs</td>
                                <td>{{ number_format($total_berat6, 2) }} kg</td>
                                <td>{{ $total_pcs6 }} pcs</td>
                                <td>{{ number_format($total_berat7, 2) }} kg</td>
                                <td>{{ $total_pcs7 }} pcs</td>
                                <td></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Button Simpan --}}
    <div class="card-footer text-end py-1 px-2">
        <button type="button" 
                class="btn btn-primary btn-sm py-0 px-2" 
                    wire:click.prevent="saveAll" 
                    wire:loading.attr="disabled"
                    style="font-size: 0.7rem; height: 30px;">
            <span wire:loading.remove wire:target="saveAll">
                <i class="bi bi-save"></i> <span>Simpan</span>
            </span>
            <span wire:loading wire:target="saveAll">
                <span class="spinner-border spinner-border-sm" role="status"></span> 
                Menyimpan...</span>
        </button>

        <button type="button" 
                class="btn btn-secondary btn-sm py-0 px-2" 
                    wire:click="print"
                    style="font-size: 0.7rem; height: 30px;">
            <i class="bi bi-printer"></i> Print
        </button>


        {{-- ALERT PESAN --}}
        @if (session()->has('message'))
            <div class="alert alert-success mt-3">
                {{ session('message') }}
            </div>
        @endif

        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('closeModal', () => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('tambahDataModal'));
                    if (modal) {
                        modal.hide();
                    }
                });
            });
        </script>
    </div>
</div>
    