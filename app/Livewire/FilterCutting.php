<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cutting;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

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

        $this->totalBeratPerGrade = Cutting::selectRaw('kategoris.grade, SUM(cuttings.berat_produk) as total_berat')
            ->join('penerimaan_ikans', 'cuttings.id_produk', '=', 'penerimaan_ikans.id')
            ->join('ikans', 'penerimaan_ikans.ikan_id', '=', 'ikans.id')
            ->join('kategoris', 'ikans.kategoris_id', '=', 'kategoris.id')
            ->whereYear('cuttings.created_at', $this->year)
            ->whereMonth('cuttings.created_at', $this->month)
            ->groupBy('kategoris.grade')
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
