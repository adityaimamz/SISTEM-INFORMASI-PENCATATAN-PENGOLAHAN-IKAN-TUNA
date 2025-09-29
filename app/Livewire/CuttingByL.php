<?php

namespace App\livewire;

use App\Models\CuttingL;
use App\Models\Penerimaan_ikan;
use App\Models\GradeL;
use App\Models\GradeService;
use App\Models\GradeHservice;
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
    public $no_ikan;
    public $penerimaan_ikan;
    public $selectedSizingLoin = [];
    public $sizingLoin = [];
    public $selectedGradingService = [];
    public $gradingService = [];
    public $selectedGradingHservice = [];
    public $gradingHservice = [];
    

    public $rows = [];

    public function mount()
    {
        $this->penerimaan_ikan = Penerimaan_ikan::with('supplier')
            ->orderBy('tgl_penerimaan', 'desc')
            ->get();

        // inisialisasi data
        $this->sizingLoin = GradeL::all();
        $this->selectedSizingLoin = [''];
        $this->gradingService = GradeService::all();
        $this->selectedGradingService = [''];
        $this->gradingHservice = GradeHservice::all();
        $this->selectedGradingHservice = [''];

        $this->rows = [];
    }

    public function updatePenerimaanid($value) {
        if ($value) {
            $penerimaan = Penerimaan_Ikan::find($value);
            if ($penerimaan) {
                $this->selectedPenerimaan = $penerimaan;
                $this->no_ikan = $penerimaan->no_ikan;
                $this->updateNoLoinInRows();
            }
        }else {
            $this->selectedPenerimaan = null;
            $this->no_ikan = null;
            $this->updateNoLoinInRows();
        }
    }

    public function updateNoLoinInRows()
    {
        if(empty($this->no_ikan)) {
            return;
        }
        foreach ($this->rows as $index=> $row) {
            $this->rows[$index]['no_loin'] = $this->no_ikan;
        }
    }

    public function addRow()
    {
        $this->rows[] = [
            'berat_produk' => '',
            'suhu_loin' => '',
            'no_loin' => $this->no_ikan ?? '',
            'berat_1' => '',
            'berat_2' => '',
            'berat_3' => '',
            'berat_4' => '',
            'berat_5' => '',
            'berat_6' => '',
        ];
    }

    public function removeRow($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
    }
    
    public function saveAll()
    {

        $validateData = $this->validate([
            'session_tggl_cutting' => 'required',
            'session_tggl_injek_co' => 'required',
            'session_tggl_service' => 'required',
            'penerimaan_id' => 'required',
            'no_ikan' => 'required',
            'selectedSizingLoin' => 'required',
            'selectedGradingService' => 'required',
            'selectedGradingHservice' => 'required',
            'rows' => 'required',
            'no_batch' => 'required',
            'rows.*.berat' => 'required',
            'rows.*.suhu_loin' => 'required',
            'rows.*.no_loin' => 'required',
        ]);

        try {
            foreach ($this->rows as $row) {
                CuttingL::create([
                    'tggl_cutting' => $this->session_tggl_cutting,
                    'tggl_injek_co' => $this->session_tggl_injek_co,
                    'tggl_service' => $this->session_tggl_service,
                    'penerimaan_id' => $this->penerimaan_id,
                    'no_ikan' => $this->no_ikan,
                    'grade_size_id' => $this->selectedSizingLoin,
                    'berat_loin' => $row['berat'],
                    'suhu_loin' => $row['suhu_loin'],
                    'no_loin' => $row['no_loin'],
                ]);
            }
            
            DB::commit();
            $this->dispatch('alert', type: 'success', message: 'Data berhasil disimpan');
            $this->resetForm();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: 'Gagal menyimpan data: ' . $th->getMessage());
        }
    }
    
    public function resetForm()
    {
        $this->reset(['no_batch', 'rows']);
        $this->addRow();
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
            'no_ikan' => $this->no_ikan,
            'selectedSizingLoin' => $this->selectedSizingLoin,
            'sizingLoin' => $this->sizingLoin,
            'selectedGradingService' => $this->selectedGradingService,
            'gradingService' => $this->gradingService,
            'selectedGradingHservice' => $this->selectedGradingHservice,
            'gradingHservice' => $this->gradingHservice,
            'rows' => $this->rows,
        ]);
    }

}
