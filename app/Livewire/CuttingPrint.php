<?php

namespace App\Livewire;

use App\Models\Cutting;
use App\Models\KategoriBeratCutting;
use Carbon\Carbon;
use Livewire\Component;

class CuttingPrint extends Component
{
    public $cuttings = [];
    public $filterMonth;
    public $total13;
    public $total15;
    public $total5;

    public function mount()
    {
        $this->filterData();
    }

    public function filterData()
    {
        if ($this->filterMonth) {
            $this->cuttings = Cutting::whereMonth('tgl_cutting', Carbon::parse($this->filterMonth)->month)
                ->whereYear('tgl_cutting', Carbon::parse($this->filterMonth)->year)
                ->get();
        } else {
            $this->cuttings = Cutting::all();
        }

        $this->calculateTotals();
    }

    private function calculateTotals()
    {
        $dataCollection = collect($this->cuttings);
        $this->total13 = $dataCollection->where('kategori_berat.kategori_berat', '1/3')->sum('berat_produk');
        $this->total15 = $dataCollection->where('kategori_berat.kategori_berat', '3/5')->sum('berat_produk');
        $this->total5 = $dataCollection->where('kategori_berat.kategori_berat', '5 UP')->sum('berat_produk');
    }

    public function exportData()
    {
        // Add export logic here (e.g., PDF or Excel)
    }

    public function render()
    {
        return view('livewire.cutting-print', [
            'cuttings' => $this->cuttings,
            'total13' => $this->total13,
            'total15' => $this->total15,
            'total5' => $this->total5,
        ]);
    }
}
