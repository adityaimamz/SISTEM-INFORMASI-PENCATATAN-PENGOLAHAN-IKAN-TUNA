<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;

class FilterService extends Component
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
        $this->data = Service::whereYear('created_at', $this->year)
            ->whereMonth('created_at', $this->month)
            ->get();

        $this->totalBeratPerGrade = Service::selectRaw('kategoris.grade, SUM(services.berat_produk) as total_berat')
            ->join('cuttings', 'services.no_batch', '=', 'cuttings.no_batch')
            ->join('penerimaan_ikans', 'cuttings.id_produk', '=', 'penerimaan_ikans.id')
            ->join('ikans', 'penerimaan_ikans.ikan_id', '=', 'ikans.id')
            ->join('kategoris', 'ikans.kategoris_id', '=', 'kategoris.id')
            ->whereYear('services.created_at', $this->year)
            ->whereMonth('services.created_at', $this->month)
            ->groupBy('kategoris.grade')
            ->get();
    }

    public function render()
    {
        return view('livewire.filter-service', [
            'data' => $this->data,
            'totalBeratPerGrade' => $this->totalBeratPerGrade
        ]);
    }
}
