<?php

namespace App\Livewire;

use App\Models\Cutting as CuttingModel;
use App\Models\Penerimaan_ikan;
use App\Models\Supplier;
use App\Models\KategoriByprodukCt;
use Livewire\Component;



class Cutting extends Component
{
    // Properti untuk form input dan filter
    public $session_tgl_cutting;
    public $session_tgl_injek_co; 
    public $penerimaan_id;
    public $cuttings = [];
    public $suppliers = [];
    public $selectedSupplier;
    public $rows = [];
    public $data = []; // menambahkan properti $data yang hilang
    
     

    // Properties for editing
    public $cutting_id;
    public $edit_tgl_cutting;
    public $edit_tgl_injek_co;

    // Insialisasi data
    public function mount()
    {
        $this->penerimaan_ikan = Penerimaan_ikan::with('supplier')
            ->orderBy('tgl_penerimaan', 'desc')
            ->get();
        $this->cuttings = collect();
        $this->penerimaan_id = null;
    }

    //memuat data penerimaan ikan
    public function loadPenerimaanIkan()
    {
        $this->penerimaan_ikan = Penerimaan_ikan::with('supplier')
            ->orderBy('tgl_penerimaan', 'desc')
            ->get();
        return $this->penerimaan_ikan;
    }

    public function loadCuttingForEdit($id)
    {
        $cutting = Cutting::findOrFail($id);
        if ($cutting) {
            $this->edit_tgl_cutting = $cutting->tgl_cutting;
            $this->edit_tgl_injek_co = $cutting->tgl_injek_co;
            $this->selectedSupplier = $cutting->supplier_id;
        }
    }

    public function updateCutting()
    {
        // Validasi input
        $this->validate([
            'edit_tgl_cutting' => 'required|date',
            'edit_tgl_injek_co' => 'required|date',
            'selectedSupplier' => 'required',
        ]);
    
        // Update data cutting
        $cutting = Cutting::findOrFail($this->cutting_id);
        $cutting->update([
            'tgl_cutting' => $this->edit_tgl_cutting,
            'tgl_injek_co' => $this->edit_tgl_injek_co,
        ]);
    
        // Refresh data setelah update
        $this->filterData();
    
        // Tampilkan pesan sukses
        session()->flash('message', 'Cutting data updated successfully.');
    }
    
    public function delete($id)
    {
        Cutting::destroy($id);
        $this->filterData();
    }

    public function render()
    {
        return view('livewire.cutting', [
            'cuttings' => $this->cuttings,
            'tgl_cutting' => $this->tgl_cutting,
            'tgl_injek_co' => $this->tgl_injek_co,
            'selectedSupplier' => $this->selectedSupplier,
        ]);
    }   
}
