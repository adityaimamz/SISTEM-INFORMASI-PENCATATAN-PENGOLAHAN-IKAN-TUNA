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
        $query = Penerimaan_ikan::query();

        if ($this->date) {
            $query->whereDate('tgl_penerimaan', $this->date);
        }

        if ($this->supplier) {
            $query->where('supplier_id', $this->supplier);
        }

        $this->data = $query->get();
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
            'edit_supplier_id' => 'required|exists:suppliers,id',
            'edit_grade_id' => 'required|exists:grades,id',
            'edit_kategori_berat_id' => 'required|exists:kategori_berat_penerimaans,id',
            'edit_tgl_penerimaan' => 'required|date',
            'edit_berat_ikan' => 'required|numeric|min:0',
        ]);

        $ikan = Penerimaan_ikan::findOrFail($this->edit_id);
        $ikan->update([
            'supplier_id' => $this->edit_supplier_id,
            'grade_id' => $this->edit_grade_id,
            'kategori_berat_id' => $this->edit_kategori_berat_id,
            'tgl_penerimaan' => $this->edit_tgl_penerimaan,
            'berat_ikan' => $this->edit_berat_ikan,
        ]);

        // Refresh data setelah update
        $this->filterData();

        // Reset edit properties
        $this->resetEditFields();

        session()->flash('message', 'Penerimaan Ikan berhasil diperbarui.');
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
