<?php

namespace App\livewire;

use App\Models\CuttingL;
use App\Models\Penerimaan_ikan;
use App\Models\GradeL;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CuttingByL extends Component
{
    public $cuttingls = [];
    public $session_tggl_cutting;
    public $session_tggl_injek_co;
    public $berat_loin = [];
    public $total_loin = [];
    public $penerimaan_id;


    public function render()
    {
        return view('livewire.cuttingl', [
            'cuttingls' => $this->cuttingls,
            'session_tggl_cutting' => $this->session_tggl_cutting,
            'session_tggl_injek_co' => $this->session_tggl_injek_co,
            'berat_loin' => $this->berat_loin,
            'total_loin' => $this->total_loin,
            'penerimaan_id' => $this->penerimaan_id,
        ]);
    }

}
