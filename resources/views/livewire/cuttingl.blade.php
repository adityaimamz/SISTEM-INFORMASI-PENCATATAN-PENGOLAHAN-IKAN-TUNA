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
                
            </div>
            
        </div>
        
    </div>
    
</div>
