<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Penerimaan_ikan;
use App\Models\Supplier;
use App\Models\Grade;
use App\Models\KategoriBeratPenerimaan;

class PenerimaanIkan extends Component
{
    public $date;
    public $supplier;
    public $suppliers;
    public $data = [];
    public $grades;
    public $kategori_berat;

    // Properti untuk edit
    public $edit_id;
    public $edit_supplier_id;
    public $edit_grade_id;
    public $edit_kategori_berat_id;
    public $edit_tgl_penerimaan;
    public $edit_berat_ikan;

    public function mount()
    {
        $this->date = now()->toDateString();
        $this->suppliers = Supplier::all();
        $this->grades = Grade::all();
        $this->kategori_berat = KategoriBeratPenerimaan::all();
        $this->filterData();
    }

    public function filterData()
    {
        // Reset data jika salah satu filter kosong
        if (!$this->date || !$this->supplier) {
            $this->data = [];
            return;
        }
    
        // Query hanya jika kedua filter terisi
        $this->data = Penerimaan_ikan::whereDate('tgl_penerimaan', $this->date)
            ->where('supplier_id', $this->supplier)
            ->get();
    }
    
    // Fungsi untuk mengisi properti edit
    public function edit($id)
    {
        $ikan = Penerimaan_ikan::findOrFail($id);

        $this->edit_id = $ikan->id;
        $this->edit_supplier_id = $ikan->supplier_id;
        $this->edit_grade_id = $ikan->grade_id;
        $this->edit_kategori_berat_id = $ikan->kategori_berat_id;
        $this->edit_tgl_penerimaan = $ikan->tgl_penerimaan;
        $this->edit_berat_ikan = $ikan->berat_ikan;
    }

    // Fungsi untuk menyimpan perubahan
    public function update()
    {
        $this->validate([
            'edit_supplier_id' => 'required|exists:suppliers,supplier_id',
            'edit_grade_id' => 'required|exists:grades,id',
            'edit_berat_ikan' => 'required|numeric|min:10', // Validasi minimal 10
            'edit_tgl_penerimaan' => 'required|date',
        ]);
    
        // Tentukan kategori berat otomatis berdasarkan berat ikan
        $kategoriBeratId = $this->getKategoriBeratId($this->edit_berat_ikan);
    
        // Update data penerimaan ikan
        $ikan = Penerimaan_ikan::findOrFail($this->edit_id);
        $ikan->update([
            'supplier_id' => $this->edit_supplier_id,
            'grade_id' => $this->edit_grade_id,
            'kategori_berat_id' => $kategoriBeratId, // Otomatis terisi
            'tgl_penerimaan' => $this->edit_tgl_penerimaan,
            'berat_ikan' => $this->edit_berat_ikan,
        ]);
    
        // Refresh data setelah update
        $this->filterData();
    
        // Reset field setelah update
        $this->resetEditFields();
    
        session()->flash('message', 'Penerimaan Ikan berhasil diperbarui.');
    }
    
    /**
     * Mendapatkan ID kategori berat berdasarkan berat ikan.
     */
    private function getKategoriBeratId($berat)
    {
        if ($berat >= 10 && $berat <= 19) {
            return KategoriBeratPenerimaan::where('kategori_berat', '10-19')->first()->id;
        } elseif ($berat >= 20 && $berat <= 29) {
            return KategoriBeratPenerimaan::where('kategori_berat', '20-29')->first()->id;
        } elseif ($berat >= 30) {
            return KategoriBeratPenerimaan::where('kategori_berat', '30 UP')->first()->id;
        }
    
        return null; // Jika tidak ada kategori yang cocok
    }    

    // Fungsi untuk mereset field edit setelah update
    public function resetEditFields()
    {
        $this->edit_id = null;
        $this->edit_supplier_id = null;
        $this->edit_grade_id = null;
        $this->edit_kategori_berat_id = null;
        $this->edit_tgl_penerimaan = null;
        $this->edit_berat_ikan = null;
    }

    public function delete($id)
    {
        Penerimaan_ikan::destroy($id);
        $this->filterData();
    }

    public function render()
    {
        return view('livewire.penerimaan-ikan', [
            'data' => $this->data,
            'suppliers' => $this->suppliers,
            'grades' => $this->grades,
            'kategori_berat' => $this->kategori_berat,
        ]);
    }
}
