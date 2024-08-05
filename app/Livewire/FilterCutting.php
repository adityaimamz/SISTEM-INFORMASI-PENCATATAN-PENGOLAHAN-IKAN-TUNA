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

        $this->totalBeratPerGrade = Cutting::selectRaw('Kategori_produks.grade, SUM(cuttings.berat_produk) as total_berat')
            ->join('penerimaan_ikans', 'cuttings.id_produk', '=', 'penerimaan_ikans.id')
            ->join('Kategori_produks', 'penerimaan_ikans.ikan_id', '=', 'Kategori_produks.id')
            ->whereYear('cuttings.created_at', $this->year)
            ->whereMonth('cuttings.created_at', $this->month)
            ->groupBy('Kategori_produks.grade')
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
