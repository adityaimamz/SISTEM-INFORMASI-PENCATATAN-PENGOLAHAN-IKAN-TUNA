<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\KodeTrace;
use App\Models\Cutting;
use App\Models\Kategori_produk;
use Carbon\Carbon;

class ServicePrint extends Component
{
    public $kode_traces;
    public $services = [];
    public $filterMonth;
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
        if ($this->filterMonth) {
            $this->services = Service::whereMonth('tgl_service', Carbon::parse($this->filterMonth)->month)
                ->whereYear('tgl_service', Carbon::parse($this->filterMonth)->year)
                ->with(['ikan', 'cutting'])
                ->get();
        } else {
            $this->services = collect();
        }
    }

    public function exportData()
    {
        return redirect()->route('service.pdf', ['filterMonth' => $this->filterMonth]);
    }

    public function render()
    {
        return view('livewire.service-print', [
            'services' => $this->services,
            'kode_traces' => $this->kode_traces,
            'cuttings' => $this->cuttings,
            'Kategori_produk' => $this->Kategori_produk,
        ]);
    }
}