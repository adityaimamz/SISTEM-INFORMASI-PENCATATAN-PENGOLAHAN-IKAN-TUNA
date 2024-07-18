<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Penerimaan_Ikan;
use App\Models\Supplier;

class Ikan extends Component
{
    public $month;
    public $year;
    public $data;

    public function mount()
    {
        $this->month = now()->format('m');
        $this->year = now()->format('Y');
        $this->filterData();
    }

    public function updated($property)
    {
        $this->filterData();
    }

    public function filterData()
    {
        $this->data = Penerimaan_Ikan::whereYear('tgl_penerimaan', $this->year)
            ->whereMonth('tgl_penerimaan', $this->month)
            ->get();
    }

    public function render()
    {
        return view('livewire.ikan');
    }
}