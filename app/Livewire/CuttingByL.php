<?php

namespace App\livewire;

use App\Models\CuttingL;
use App\Models\Penerimaan_ikan;
use App\Models\GradeL;
use App\Models\GradeService;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CuttingByL extends Component
{
    public $cuttingls = [];
    public $session_tggl_cutting;
    public $session_tggl_injek_co;
    public $session_tggl_service;
    public $berat_loin = [];
    public $total_loin = [];
    public $penerimaan_id;
    public $penerimaan_ikan;
    public $selectedSizingLoin = [];
    public $sizingLoin = [];
    public $selectedGradingService = [];
    public $gradingService = [];

    public function mount()
    {
        $this->penerimaan_ikan = Penerimaan_ikan::with('supplier')
            ->orderBy('tgl_penerimaan', 'desc')
            ->get();

        $this->sizingLoin = GradeL::all();
        $this->selectedSizingLoin = [''];

        $this->gradingService = GradeService::all();
        $this->selectedGradingService = [''];
    }
    


    public function render()
    {
        return view('livewire.cuttingl', [
            'cuttingls' => $this->cuttingls,
            'session_tggl_cutting' => $this->session_tggl_cutting,
            'session_tggl_injek_co' => $this->session_tggl_injek_co,
            'session_tggl_service' => $this->session_tggl_service,
            'berat_loin' => $this->berat_loin,
            'total_loin' => $this->total_loin,
            'penerimaan_id' => $this->penerimaan_id,
            'penerimaan_ikan' => $this->penerimaan_ikan,
            'selectedSizingLoin' => $this->selectedSizingLoin,
            'sizingLoin' => $this->sizingLoin,
            'selectedGradingService' => $this->selectedGradingService,
            'gradingService' => $this->gradingService,
        ]);
    }

}
