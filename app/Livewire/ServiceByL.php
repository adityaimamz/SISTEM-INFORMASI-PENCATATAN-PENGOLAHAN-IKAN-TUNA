<?php

namespace App\Livewire;

use App\Models\ServiceL;
use App\Models\Penerimaan_ikan;
use App\Models\Supplier;
use App\Models\Kategori_produk;
use App\Models\CuttingL;
use Livewire\Component;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;


class ServiceByL extends Component
{
    public function render()
    {
        return view('livewire.servicel');
    }
}

