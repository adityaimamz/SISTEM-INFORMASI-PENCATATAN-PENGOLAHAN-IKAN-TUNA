<?php

namespace App\Livewire;

use App\Models\Cutting;
use App\Models\KategoriBeratCutting;
use App\Models\NoBatch;
use App\Models\Penerimaan_ikan;
use Livewire\Component;
use App\Models\Supplier;


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
    public $supplier_id;
    public $tgl_injek_co;  

    // Properties for editing
    public $cutting_id;
    public $edit_no_batch;
    public $edit_id_produk;
    public $edit_berat_produk;
    public $edit_kategori_berat_id;
    public $edit_tgl_cutting;
    public $edit_supplier;
    public $edit_grade;
    public $edit_tgl_injek_co;
    public $edit_supplier_id;

    public function mount()
    {
        $this->no_batches = NoBatch::all();
        $this->penerimaan_ikan = Penerimaan_ikan::all();
        $this->kategori_berat_cuttings = KategoriBeratCutting::all();
        $this->cuttings = collect();
        $this->tanggal_penerimaan = null;
        $this->supplier = null;
        $this->grade = null;
        $this->tgl_cutting = null;
        $this->cutting_id = null;
        $this->edit_no_batch = null;
        $this->edit_id_produk = null;
        $this->edit_berat_produk = null;
        $this->edit_kategori_berat_id = null;
        $this->edit_tgl_cutting = null;
        $this->edit_supplier = null;
        $this->edit_grade = null;
        $this->edit_tgl_injek_co = null;
        $this->edit_supplier_id = null;
        $this->selectedSupplier = null;
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
                    $this->supplier_id = $cutting->supplier_id;
                    $this->tgl_injek_co = $cutting->tgl_injek_co;
                }
            }
        } else {
            $this->cuttings = collect();
            $this->tanggal_penerimaan = null;
            $this->supplier = null;
            $this->grade = null;
            $this->tgl_cutting = null;
            $this->tgl_injek_co = null;
            $this->cutting_id = null;
            $this->edit_no_batch = null;
            $this->edit_id_produk = null;
            $this->edit_berat_produk = null;
            $this->edit_kategori_berat_id = null;
            $this->edit_tgl_cutting = null;
            $this->edit_supplier = null;
            $this->edit_grade = null;
            $this->edit_tgl_injek_co = null;
            $this->edit_supplier_id = null;
            $this->selectedSupplier = null;
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
            $this->edit_supplier = $cutting->supplier->nama_supplier;
            $this->edit_grade = $cutting->grade->grade;
            $this->edit_tgl_injek_co = $cutting->tgl_injek_co;
            $this->supplier_id = $cutting->supplier_id;
            $this->edit_supplier_id = $cutting->supplier_id;
            $this->selectedSupplier = $cutting->supplier_id;
        }
    }

    public function updateCutting()
    {
        // Validasi input
        $this->validate([
            'edit_no_batch' => 'required',
            'edit_id_produk' => 'required',
            'edit_berat_produk' => 'required|numeric|min:0',
            'edit_tgl_cutting' => 'required|date',
            'edit_supplier' => 'required',
            'edit_grade' => 'required',
            'edit_tgl_injek_co' => 'required|date',
            'edit_supplier_id' => 'required',
            'selectedSupplier' => 'required',
        ]);
    
        // Tentukan kategori berat otomatis berdasarkan berat produk
        $kategoriBeratId = $this->getKategoriBeratId($this->edit_berat_produk);
    
        // Update data cutting
        $cutting = Cutting::findOrFail($this->cutting_id);
        $cutting->update([
            'no_batch_id' => $this->edit_no_batch,
            'id_produk' => $this->edit_id_produk,
            'berat_produk' => $this->edit_berat_produk,
            'kategori_berat_id' => $kategoriBeratId, // Otomatis diisi
            'tgl_cutting' => $this->edit_tgl_cutting,
            'supplier_id' => $this->supplier_id,
            'grade_id' => $this->edit_grade,
            'tgl_injek_co' => $this->edit_tgl_injek_co,
            'supplier_id' => $this->edit_supplier_id,
        ]);
    
        // Refresh data setelah update
        $this->filterData();
    
        // Tampilkan pesan sukses
        session()->flash('message', 'Cutting data updated successfully.');
    }
    
    /**
     * Mendapatkan ID kategori berat berdasarkan berat produk.
     */
    private function getKategoriBeratId($berat)
    {
        if ($berat >= 1 && $berat <= 3) {
            return KategoriBeratCutting::where('kategori_berat', '1/3')->first()->id;
        } elseif ($berat > 3 && $berat <= 5) {
            return KategoriBeratCutting::where('kategori_berat', '3/5')->first()->id;
        } elseif ($berat > 5) {
            return KategoriBeratCutting::where('kategori_berat', '5 UP')->first()->id;
        }
    
        return null; // Default jika tidak ada kategori cocok
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
            'tanggal_penerimaan' => $this->tanggal_penerimaan,
            'supplier' => $this->supplier,
            'grade' => $this->grade,
            'tgl_cutting' => $this->tgl_cutting,
            'supplier_id' => $this->supplier_id,
            'tgl_injek_co' => $this->tgl_injek_co,
            'cutting_id' => $this->cutting_id,
            'edit_no_batch' => $this->edit_no_batch,
            'edit_id_produk' => $this->edit_id_produk,
            'edit_berat_produk' => $this->edit_berat_produk,
            'edit_kategori_berat_id' => $this->edit_kategori_berat_id,
            'edit_tgl_cutting' => $this->edit_tgl_cutting,
            'edit_supplier' => $this->edit_supplier,
            'edit_grade' => $this->edit_grade,
            'edit_tgl_injek_co' => $this->edit_tgl_injek_co,
            'edit_supplier_id' => $this->edit_supplier_id,
            'selectedSupplier' => $this->selectedSupplier,
        ]);
    }   
}
