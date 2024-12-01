<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Penerimaan_Ikan;
use App\Models\Supplier;

class Ikan extends Component
{
    public $date;
    public $supplier;
    public $data;
    public $suppliers;

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
        $this->supplier = '';
        $this->suppliers = Supplier::all(); // Load all suppliers
        $this->filterData();
    }

    public function updated($property)
    {
        $this->filterData();
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

    public function render()
    {
        return view('livewire.ikan');
    }
}
