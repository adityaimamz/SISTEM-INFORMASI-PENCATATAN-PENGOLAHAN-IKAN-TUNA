<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Packing;
use App\Models\Service;
use Illuminate\Support\Carbon;

class PackingFilter extends Component
{
    public $services;
    public $data;
    public $selectedDate;

    public function mount()
    {
        $this->services = Service::all();
        $this->data = Packing::all();
    }

    public function filterData()
    {
        $this->data = Packing::query()
            ->when($this->selectedDate, function($query) {
                $date = Carbon::parse($this->selectedDate)->format('Y-m-d');
                $query->whereDate('tgl_packing', $date);
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.packing-filter');
    }
}
