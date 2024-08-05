<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;

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
            
        $this->totalBeratPerGrade = Service::selectRaw('Kategori_produks.grade, SUM(services.berat_produk) as total_berat')
            ->join('cuttings', 'services.no_batch', '=', 'cuttings.no_batch')
            ->join('penerimaan_ikans', 'cuttings.id_produk', '=', 'penerimaan_ikans.id')
            ->join('Kategori_produks', 'penerimaan_ikans.ikan_id', '=', 'Kategori_produks.id')
            ->whereYear('services.created_at', $this->year)
            ->whereMonth('services.created_at', $this->month)
            ->groupBy('Kategori_produks.grade')
            ->get();

    }

    public function render()
    {
        return view('livewire.filter-service', [
            'data' => $this->data,
            'totalBeratPerGrade' => $this->totalBeratPerGrade,
        ]);
    }
}
