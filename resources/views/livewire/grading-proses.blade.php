<div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Proses Grading Ikan</h4>
        </div>
        <div class="card-body">
            <!-- Filter Section -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <label for="tanggalPenerimaan" class="form-label">Tanggal Penerimaan</label>
                    <input type="date" class="form-control" id="tanggalPenerimaan" wire:model.live="tanggalPenerimaan">
                </div>
                <div class="col-md-3">
                    <label for="tanggalBongkar" class="form-label">Tanggal Bongkar</label>
                    <input type="date" class="form-control" id="tanggalBongkar" wire:model.live="tanggalBongkar">
                </div>
                <div class="col-md-3">
                    <label for="jenisPenerimaan" class="form-label">Jenis Penerimaan</label>
                    <select class="form-select" id="jenisPenerimaan" wire:model.live="jenisPenerimaan">
                        <option value="">Semua</option>
                        <option value="Fresh GG">Fresh GG</option>
                        <option value="Frozen GG">Frozen GG</option>
                        <option value="Frozen WR">Frozen WR</option>
                    </select>
                </div>
            </div>

            <!-- Bulk Action -->
            <div class="row mb-3">
                <div class="col-md-6 d-flex align-items-end">
                    <div class="d-flex gap-2 w-100">
                        <select class="form-select" wire:model="selectedGrade" style="max-width: 200px;">
                            <option value="">Pilih Grade</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->grade }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-primary" wire:click="bulkUpdateGrade" wire:loading.attr="disabled">
                            <span wire:loading.remove>Update Grade Terpilih</span>
                            <span wire:loading>Memproses...</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th>No. Penerimaan</th>
                            <th>Supplier</th>
                            <th>Grade</th>
                            <th>Berat (kg)</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penerimaanIkan as $item)
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input" 
                                        wire:model="selectedPenerimaan" 
                                        value="{{ $item->penerimaan_id }}">
                                </td>
                                <td>{{ $item->penerimaan_id }}</td>
                                <td>{{ $item->supplier->nama_supplier ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->grade ? 'primary' : 'secondary' }}">
                                        {{ $item->grade->grade ?? 'Belum di-grade' }}
                                    </span>
                                </td>
                                <td>{{ number_format($item->berat_ikan, 2) }}</td>
                                <td>{{ $item->tgl_penerimaan->format('d/m/Y') }}</td>
                                <td>{{ $item->jenis_penerimaan }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" 
                                            wire:click="openGradingModal({{ $item->penerimaan_id }})">
                                        <i class="fas fa-edit"></i> Ubah Grade
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data penerimaan ikan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Grading Modal -->
    <div class="modal fade" id="gradingModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Grade Ikan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="gradeId" class="form-label">Grade</label>
                        <select class="form-select" id="gradeId" wire:model="gradeId" required>
                            <option value="">Pilih Grade</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->grade }}</option>
                            @endforeach
                        </select>
                        @error('gradeId') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                        <textarea class="form-control" id="keterangan" wire:model="keterangan" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" wire:click="saveGrade">
                        <span wire:loading.remove>Simpan</span>
                        <span wire:loading>Menyimpan...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Show modal when showGradingModal is true
            Livewire.on('showGradingModal', () => {
                const modal = new bootstrap.Modal(document.getElementById('gradingModal'));
                modal.show();
            });
            
            // Hide modal when grading is complete
            Livewire.on('hideGradingModal', () => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('gradingModal'));
                if (modal) {
                    modal.hide();
                }
            });
        });
    </script>
    @endpush
</div>
