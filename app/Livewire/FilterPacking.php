<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Packing;
use App\Models\Supplier;

class FilterPacking extends Component
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
        $this->data = Packing::whereYear('created_at', $this->year)
            ->whereMonth('created_at', $this->month)
            ->get();
    }

    public function render()
    {
        return view('livewire.filter-packing');
    }
}