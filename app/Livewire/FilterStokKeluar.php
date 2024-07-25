<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\produk_keluar;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;


class FilterStokKeluar extends Component
{
    public $month;
    public $year;
    public $data;
    public $totalStok;

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
        $this->data = produk_keluar::whereYear('created_at', $this->year)
            ->whereMonth('created_at', $this->month)
            ->get();

        $totalKeluar = produk_keluar::whereYear('created_at', $this->year)
            ->whereMonth('created_at', $this->month)
            ->sum('jumlah_produk');

        $totalMasuk = DB::table('produk_masuks')
            ->whereYear('created_at', $this->year)
            ->whereMonth('created_at', $this->month)
            ->sum('stok_masuk');   

        $this->totalStok = $totalMasuk - $totalKeluar;
        
    }

    public function render()
    {
        return view('livewire.filter-stok-keluar', [
            'totalStok' => $this->totalStok
        ]);
    }
}