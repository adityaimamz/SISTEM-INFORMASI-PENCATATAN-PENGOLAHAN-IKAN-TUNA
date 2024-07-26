<?php

namespace App\Livewire;

use App\Models\Cutting;
use Livewire\Component;

class FilterCutting extends Component
{
    public $month;
    public $year;
    public $data;
    public $totalBeratPerGrade;

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
        $this->data = Cutting::whereYear('created_at', $this->year)
            ->whereMonth('created_at', $this->month)
            ->get();

        $this->$totalBeratPerGrade = Cutting::selectRaw('kategori_ikans.grade, SUM(cuttings.berat_produk) as total_berat')
            ->join('penerimaan_ikans', 'cuttings.id_produk', '=', 'penerimaan_ikans.id')
            ->join('kategori_ikans', 'penerimaan_ikans.ikan_id', '=', 'kategori_ikans.id')
            ->whereYear('cuttings.created_at', $this->$year)
            ->whereMonth('cuttings.created_at', $this->$month)
            ->groupBy('kategori_ikans.grade')
            ->get();
    }

    public function render()
    {
        return view('livewire.filter-cutting', [
            'data' => $this->data,
            'totalBeratPerGrade' => $this->totalBeratPerGrade,
        ]);
    }
}
