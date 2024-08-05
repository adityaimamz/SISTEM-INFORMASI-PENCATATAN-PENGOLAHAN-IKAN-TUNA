<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\Service;
use App\Models\KodeTrace;
use App\Models\Cutting;
use App\Models\Kategori_produk;

class ServiceFilter extends Component
{
    public $kode_traces;
    public $services = [];
    public $kode_trace;
    public $cuttings;
    public $Kategori_produk;

    public function mount()
    {
        $this->kode_traces = KodeTrace::all();
        $this->cuttings = Cutting::all();
        $this->Kategori_produk = Kategori_produk::all();
        $this->services = collect();
    }

    public function filterData()
    {
        if ($this->kode_trace) {
            $this->services = Service::where('kode_trace_id', $this->kode_trace)->get();
        } else {
            $this->services = collect();
        }
    }

    public function delete($id)
    {
        Service::destroy($id);
        $this->filterData();
    }

    public function render()
    {
        return view('livewire.service-filter', [
            'services' => $this->services,
            'kode_traces' => $this->kode_traces,
            'cuttings' => $this->cuttings,
            'Kategori_produk' => $this->Kategori_produk,
        ]);
    }
}