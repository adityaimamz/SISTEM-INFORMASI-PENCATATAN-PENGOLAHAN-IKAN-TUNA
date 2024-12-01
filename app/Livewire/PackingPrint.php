<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Packing;
use App\Models\Service;
use Illuminate\Support\Carbon;

class PackingPrint extends Component
{
    public $services;
    public $data;
    public $selectedMonth;

    public function mount()
    {
        $this->services = Service::all();
        $this->data = Packing::all();
    }

    public function filterData()
    {
        $this->data = Packing::query()
            ->when($this->selectedMonth, function ($query) {
                $query->whereMonth('tgl_packing', Carbon::parse($this->selectedMonth)->month)
                      ->whereYear('tgl_packing', Carbon::parse($this->selectedMonth)->year);
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.packing-print', [
            'data' => $this->data,
            'services' => $this->services,
        ]);
    }
}
