<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Penerimaan_Ikan;
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
    public $editItem;
    public $editForm = [
        'supplier_id' => '',
        'grade_id' => '',
        'kategori_berat_id' => '',
        'berat_ikan' => '',
        'tgl_penerimaan' => ''
    ];

    public function mount()
    {
        $this->date = now()->toDateString();
        $this->suppliers = Supplier::all();
        $this->grades = Grade::all();
        $this->kategori_berat = KategoriBeratPenerimaan::all();
    }

    public function filterData()
    {
        $query = Penerimaan_Ikan::query();

        if ($this->date) {
            $query->whereDate('tgl_penerimaan', $this->date);
        }

        if ($this->supplier) {
            $query->where('supplier_id', $this->supplier);
        }

        $this->data = $query->get();
    }

    public function edit($id)
    {
        $this->editItem = Penerimaan_Ikan::find($id);
        $this->editForm = [
            'supplier_id' => $this->editItem->supplier_id,
            'grade_id' => $this->editItem->grade_id,
            'kategori_berat_id' => $this->editItem->kategori_berat_id,
            'berat_ikan' => $this->editItem->berat_ikan,
            'tgl_penerimaan' => $this->editItem->tgl_penerimaan
        ];
    }

    public function update()
    {
        $this->editItem->update($this->editForm);
        $this->reset('editItem', 'editForm');
        $this->filterData();
    }

    public function delete($id)
    {
        Penerimaan_Ikan::destroy($id);
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
