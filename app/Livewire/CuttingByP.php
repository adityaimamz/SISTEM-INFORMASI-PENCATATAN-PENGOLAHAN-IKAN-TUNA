<?php

namespace App\Livewire;

use App\Models\Cutting;
use App\Models\Penerimaan_ikan;
use App\Models\Supplier;
use App\Models\KategoriByprodukCt;
use Livewire\Component;



class CuttingByP extends Component
{

// Properti untuk form input dan filter
    public $cuttings = [];                      //tabel cutting
    public $session_tgl_cutting;
    public $session_tgl_injek_co;
    public $total_berat1 = 0;
    public $total_berat2 = 0;
    public $total_berat3 = 0;
    public $total_berat4 = 0;
    public $total_berat5 = 0;
    public $total_berat6 = 0;
    public $total_berat7 = 0;
    public $total_pcs1 = 0; 
    public $total_pcs2 = 0;
    public $total_pcs3 = 0;
    public $total_pcs4 = 0;
    public $total_pcs5 = 0;
    public $total_pcs6 = 0;
    public $total_pcs7 = 0;
    public $penerimaan_ikan;                    //tabel penerimaan
    public $penerimaan_id;
    public $selectedTanggalPenerimaan;
    public $filteredPenerimaan = [];
    public $suppliers = [];
    public $selectedSupplier;
    public $kategori_byproduk_ct = [];          //tabel produk
    public $rows = [];
    public $data = [];
    
// Properties for editing
    public $cutting_id;
    public $edit_tgl_cutting;
    public $edit_tgl_injek_co;

// Insialisasi data
    public function mount()
    {        
        $this->cuttings = collect();                    //tabel cutting
        $this->session_tgl_cutting = null;
        $this->session_tgl_injek_co = null;
        $this->rows = [];
        $this->addRow();
        $this->total_berat1 = 0;
        $this->total_berat2 = 0;
        $this->total_berat3 = 0;
        $this->total_berat4 = 0;
        $this->total_berat5 = 0;
        $this->total_berat6 = 0;
        $this->total_berat7 = 0;
        $this->total_pcs1 = 0;
        $this->total_pcs2 = 0;
        $this->total_pcs3 = 0;
        $this->total_pcs4 = 0;
        $this->total_pcs5 = 0;
        $this->total_pcs6 = 0;
        $this->total_pcs7 = 0;
        $this->penerimaan_id = null;                    //tabel penerimaan
        $this->penerimaan_ikan = Penerimaan_ikan::with('supplier')
            ->orderBy('tgl_penerimaan', 'desc')
            ->get();
        $this->selectedTanggalPenerimaan = null;
        $this->filteredPenerimaan = collect();
        $this->kategori_byproduk_ct = KategoriByprodukCt::all();     //tabel produk
    }

    //memuat data- data yang ada pada penerimaan ikan
    public function loadPenerimaanIkan()
    {
        $this->penerimaan_ikan = Penerimaan_ikan::with('supplier')
            ->orderBy('tgl_penerimaan', 'desc')
            ->get();
        return $this->penerimaan_ikan;
    }

    public function updateSelectedTanggalPenerimaan($value)
    {
        if($value) {
            $this->filteredPenerimaan = Penerimaan_ikan::where('penerimaan_id', $value)
                ->with('supplier')
                ->get();
        } else {
            $this->filteredPenerimaan = collect();
        }
        $this->penerimaan_id = null;
    }
    //memuat data- data yang ada pada penerimaan ikan

//add, update, remove row

    public function addRow()
    {
        $newRow = ['no_batch' => ''];
        for ($i = 1; $i <= 7; $i++) {
            $newRow['berat_produk' . $i] = 0;
            $newRow['total_produk' . $i] = 0;
        }
        $this->rows[] = $newRow;
        $this->updatedRows();
    }

    public function updatedRows()
    {
        //kg
        $this->total_berat1 = collect($this->rows)->sum(function($row) {
            return (float)$row['berat_produk1'] ?? 0;
        });
        $this->total_berat2 = collect($this->rows)->sum(function($row) {
            return (float)$row['berat_produk2'] ?? 0;
        });
        $this->total_berat3 = collect($this->rows)->sum(function($row) {
            return (float)$row['berat_produk3'] ?? 0;
        });
        $this->total_berat4 = collect($this->rows)->sum(function($row) {
            return (float)$row['berat_produk4'] ?? 0;
        });
        $this->total_berat5 = collect($this->rows)->sum(function($row) {
            return (float)$row['berat_produk5'] ?? 0;
        });
        $this->total_berat6 = collect($this->rows)->sum(function($row) {
            return (float)$row['berat_produk6'] ?? 0;
        });
        $this->total_berat7 = collect($this->rows)->sum(function($row) {
            return (float)$row['berat_produk7'] ?? 0;
        });
        //pcs  
        $this->total_pcs1 = collect($this->rows)->sum(function($row) {
            $total = 0;
            for ($i = 1; $i <= 1; $i++) {
                $total += (int)$row['total_produk' . $i] ?? 0;
            }
            return $total;
        });
        $this->total_pcs2 = collect($this->rows)->sum(function($row) {
            $total = 0;
            for ($i = 2; $i <= 2; $i++) {
                $total += (int)$row['total_produk' . $i] ?? 0;
            }
            return $total;
        });
        $this->total_pcs3 = collect($this->rows)->sum(function($row) {
            $total = 0;
            for ($i = 3; $i <= 3; $i++) {
                $total += (int)$row['total_produk' . $i] ?? 0;
            }
            return $total;
        });
        $this->total_pcs4 = collect($this->rows)->sum(function($row) {
            $total = 0;
            for ($i = 4; $i <= 4; $i++) {
                $total += (int)$row['total_produk' . $i] ?? 0;
            }
            return $total;
        });
        $this->total_pcs5 = collect($this->rows)->sum(function($row) {
            $total = 0;
            for ($i = 5; $i <= 5; $i++) {
                $total += (int)$row['total_produk' . $i] ?? 0;
            }
            return $total;
        });
        $this->total_pcs6 = collect($this->rows)->sum(function($row) {
            $total = 0;
            for ($i = 6; $i <= 6; $i++) {
                $total += (int)$row['total_produk' . $i] ?? 0;
            }
            return $total;
        });
        $this->total_pcs7 = collect($this->rows)->sum(function($row) {
            $total = 0;
            for ($i = 7; $i <= 7; $i++) {
                $total += (int)$row['total_produk' . $i] ?? 0;
            }
            return $total;
        });
    }

    public function removeRow($index)
    {
        if (isset($this->rows[$index])) {
            if (isset($this->rows[$index]['cutting_id'])) {
                try { 
                    Cutting::where('cutting_id', $this->rows[$index]['cutting_id'])->delete();
                    session()->flash('message', 'Data berhasil dihapus');
                } catch (\Exception $e) {
                    session()->flash('error', 'Gagal menghapus data: ' . $e->getMessage());
                    return;
                }
            }
            unset($this->rows[$index]);
        }
    }

    public function saveAll()
    {
        if(!$this->penerimaan_id) {
            session()->flash('error', 'Penerimaan ID tidak boleh kosong');
            return;
        }

        foreach ($this->rows as $row) {
            $data = [
                'cutting_id' => $row['cutting_id'] ?? '',
                'no_batch' => $row['no_batch'] ?? '',
                'tgl_cutting' => $this->session_tgl_cutting,
                'tgl_injek_co' => $this->session_tgl_injek_co,
                'penerimaan_id' => $this->penerimaan_id,
                'kategori_byproduk_id' => $row['kategori_byproduk_id'] ?? null,
            ];

            for($i = 1; $i <= 7; $i++) {
                $data['berat_produk' . $i] = $row['berat_produk' . $i] ?? 0;
                $data['total_produk' . $i] = $row['total_produk' . $i] ?? 0;
            }

            try {
                if(isset($row['cutting_id']) && $row['cutting_id'] != '') {
                    $cutting = Cutting::find($row['cutting_id']);
                    if($cutting) {
                        $cutting->update($data);
                    }
                } else {
                    $data['cutting_id'] = (string) \Illuminate\Support\Str::uuid();
                    Cutting::query()->create($data);
                }
            } catch (\Exception $e) {
                session()->flash('error', 'Gagal menyimpan data: ' . $e->getMessage());
                \Log::error('Gagal menyimpan data cutting: ' . $e->getMessage());
                return;
            }
        }
        session()->flash('message', 'Data berhasil disimpan');
        $this->filterData();
    }

    public function loadCuttingForEdit($id)
    {
        $cutting = Cutting::findOrFail($id);
        if ($cutting) {
            $this->edit_tgl_cutting = $cutting->tgl_cutting;
            $this->edit_tgl_injek_co = $cutting->tgl_injek_co;
            $this->selectedSupplier = $cutting->supplier_id;
        }
    }

    public function updateCutting()
    {
        // Validasi input
        $this->validate([
            'edit_tgl_cutting' => 'required|date',
            'edit_tgl_injek_co' => 'required|date',
            'selectedSupplier' => 'required',
        ]);
    
        // Update data cutting
        $cutting = Cutting::findOrFail($this->cutting_id);
        $cutting->update([
            'tgl_cutting' => $this->edit_tgl_cutting,
            'tgl_injek_co' => $this->edit_tgl_injek_co,
        ]);
    
        // Refresh data setelah update
        $this->filterData();
    
        // Tampilkan pesan sukses
        session()->flash('message', 'Cutting data updated successfully.');
    }
    
    public function delete($id)
    {
        Cutting::destroy($id);
        $this->filterData();
    }

    public function render()
    {
        return view('livewire.cutting', [
            'cuttings' => $this->cuttings,
            'session_tgl_cutting' => $this->session_tgl_cutting,
            'session_tgl_injek_co' => $this->session_tgl_injek_co,
            'selectedSupplier' => $this->selectedSupplier,
            'penerimaan_ikan' => $this->penerimaan_ikan,
        ]);
    }   
}
