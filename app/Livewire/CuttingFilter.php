<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cutting;
use App\Models\KategoriBeratCutting;
use App\Models\NoBatch;

class CuttingFilter extends Component
{
    public $no_batches;
    public $cuttings = [];
    public $no_batch;
    public $tanggal_penerimaan;
    public $supplier;
    public $grade;
    public $tgl_cutting;

    public function mount()
    {
        $this->no_batches = NoBatch::all();
        $this->cuttings = collect();
    }

    public function filterData()
    {
        if ($this->no_batch) {
            $this->cuttings = Cutting::where('no_batch_id', $this->no_batch)->get();

            $cutting = $this->cuttings->first(); 
            if ($cutting) {
                $penerimaanIkan = $cutting->penerimaan_ikan; 
                if ($penerimaanIkan) {
                    $this->tanggal_penerimaan = $penerimaanIkan->tgl_penerimaan;
                    $this->supplier = $penerimaanIkan->supplier->nama_supplier; // Assuming supplier has a name attribute
                    $this->grade = $penerimaanIkan->grade->grade;
                    $this->tgl_cutting = $cutting->tgl_cutting;
                }
            }
        } else {
            $this->cuttings = collect();
            $this->tanggal_penerimaan = null;
            $this->supplier = null;
            $this->grade = null;
            $this->tgl_cutting = null;}
    }

    public function delete($id)
    {
        Cutting::destroy($id);
        $this->filterData();
    }

    public function render()
    {
        return view('livewire.cutting-filter', [
            'cuttings' => $this->cuttings,
            'no_batches' => $this->no_batches,
        ]);
    }
}