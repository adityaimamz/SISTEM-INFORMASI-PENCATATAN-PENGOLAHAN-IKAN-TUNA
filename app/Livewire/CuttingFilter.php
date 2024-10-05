<?php

namespace App\Livewire;

use App\Models\Cutting;
use App\Models\KategoriBeratCutting;
use App\Models\NoBatch;
use App\Models\Penerimaan_ikan;
use Livewire\Component;

class CuttingFilter extends Component
{
    public $no_batches;
    public $penerimaan_ikan;
    public $kategori_berat_cuttings;
    public $cuttings = [];
    public $no_batch;
    public $tanggal_penerimaan;
    public $supplier;
    public $grade;
    public $tgl_cutting;

    // Properties for editing
    public $cutting_id;
    public $edit_no_batch;
    public $edit_id_produk;
    public $edit_berat_produk;
    public $edit_kategori_berat_id;
    public $edit_tgl_cutting;

    public function mount()
    {
        $this->no_batches = NoBatch::all();
        $this->penerimaan_ikan = Penerimaan_ikan::all();
        $this->kategori_berat_cuttings = KategoriBeratCutting::all();
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
                    $this->supplier = $penerimaanIkan->supplier->nama_supplier;
                    $this->grade = $penerimaanIkan->grade->grade;
                    $this->tgl_cutting = $cutting->tgl_cutting;
                }
            }
        } else {
            $this->cuttings = collect();
            $this->tanggal_penerimaan = null;
            $this->supplier = null;
            $this->grade = null;
            $this->tgl_cutting = null;
        }
    }

    public function loadCuttingForEdit($id)
    {
        $cutting = Cutting::findOrFail($id);
        if ($cutting) {
            $this->cutting_id = $cutting->id;
            $this->edit_no_batch = $cutting->no_batch_id;
            $this->edit_id_produk = $cutting->id_produk;
            $this->edit_berat_produk = $cutting->berat_produk;
            $this->edit_kategori_berat_id = $cutting->kategori_berat_id;
            $this->edit_tgl_cutting = $cutting->tgl_cutting;
        }
    }

    public function updateCutting()
    {
        // Add validation rules
        $this->validate([
            'edit_no_batch' => 'required|exists:no_batches,id',
            'edit_id_produk' => 'required|exists:penerimaan_ikans,id',
            'edit_berat_produk' => 'required|numeric|min:0',
            'edit_kategori_berat_id' => 'required|exists:kategori_berat_cuttings,id',
            'edit_tgl_cutting' => 'required|date',
        ]);

        // Perform the update
        $cutting = Cutting::findOrFail($this->cutting_id);
        $cutting->update([
            'no_batch_id' => $this->edit_no_batch,
            'id_produk' => $this->edit_id_produk,
            'berat_produk' => $this->edit_berat_produk,
            'kategori_berat_id' => $this->edit_kategori_berat_id,
            'tgl_cutting' => $this->edit_tgl_cutting,
        ]);

        // Refresh data after updating
        $this->filterData();

        // Flash success message
        session()->flash('message', 'Cutting data updated successfully.');
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
            'penerimaan_ikan' => $this->penerimaan_ikan,
            'kategori_berat_cuttings' => $this->kategori_berat_cuttings,
        ]);
    }
}
