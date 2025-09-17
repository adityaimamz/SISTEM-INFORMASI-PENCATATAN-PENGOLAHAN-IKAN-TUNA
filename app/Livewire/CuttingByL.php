<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\CuttingL;
use App\Models\PenerimaanIkan;
use Livewire\WithPagination;

class CuttingByL extends Component
{
    use WithPagination;
    
    // Properti untuk form
    public $tggl_cutting;
    public $tggl_injek_co;
    public $tggl_service;
    public $grade_size_id;
    public $berat_loin;
    public $suhu_loin;
    public $penerimaan_id;
    
    // Fungsi simpan data
    public function simpan()
    {
        $this->validate([
            'tggl_cutting' => 'required|date',
            'tggl_injek_co' => 'required|date|after_or_equal:tggl_cutting',
            'tggl_service' => 'required|date|after_or_equal:tggl_cutting',
            'grade_size_id' => 'required|exists:grade_sizings,grade_size_id',
            'berat_loin' => 'required|numeric|min:0',
            'suhu_loin' => 'required|numeric',
            'penerimaan_id' => 'required|exists:penerimaan_ikan,penerimaan_id',
        ]);

        try {
            CuttingL::create($this->all());
            session()->flash('message', 'Data berhasil disimpan');
            $this->reset();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    // Render view
    public function render()
    {
        $penerimaan = PenerimaanIkan::with('supplier')->get();
        return view('livewire.cutting-loin', [
            'penerimaanList' => $penerimaan
        ]);
    }
}