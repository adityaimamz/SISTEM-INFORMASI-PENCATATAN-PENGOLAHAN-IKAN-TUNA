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
    public $total_berat = [];
    public $total_pcs = [];
    public $penerimaan_ikan;                    //tabel penerimaan
    public $penerimaan_id;
    public $selectedTanggalPenerimaan;
    public $filteredPenerimaan = [];
    public $suppliers = [];
    public $selectedSupplier;
    public $kategori_byproduk_ct = [];          //tabel produk
    public $selectedKategoriByproduk = [
        1 => null,
        2 => null,
        3 => null,
        4 => null,
        5 => null,
        6 => null,
        7 => null,
    ];
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
        $this->updatedRows();
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
        $this->penerimaan_id = null;                                 //tabel penerimaan
        $this->penerimaan_ikan = Penerimaan_ikan::with('supplier')
            ->orderBy('tgl_penerimaan', 'desc')
            ->get();
        $this->selectedTanggalPenerimaan = null;
        $this->filteredPenerimaan = collect();
        $this->kategori_byproduk_ct = KategoriByprodukCt::all();     //tabel produk
        $this->selectedKategoriByproduk = null;
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
        for($i = 1; $i <= 7; $i++) {
            $this->total_berat[$i] = 0;
            $this->total_pcs[$i] = 0;
        }
        foreach ($this->rows as $row) {
            for($i = 1; $i <= 7; $i++) {
                $this->total_berat[$i] += (float) ($row['berat_produk' . $i] ?? 0);
                $this->total_pcs[$i] += (int) ($row['total_produk' . $i] ?? 0);
            }
        }
    }

    public function update($propertyName) {
        \Log::info('Update Property:', [
            'propertyName' => $propertyName,
            'rows' => $this->rows,
        ]);

        if (str_starts_with($propertyName, 'rows.')) {
            $this->updatedRows();
        }
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

        if(empty(array_filter($this->selectedKategoriByproduk))) {
            session()->flash('error', 'Tidak Ada Produk');
            return;
        }

        foreach ($this->rows as $row) {
            $berat_produk = [];
            $total_produk = [];

            for($i = 1; $i <= 7; $i++) {
                $berat_produk[$i] = (float) ($row['berat_produk' . $i] ?? 0);
                $total_produk[$i] = (int) ($row['total_produk' . $i] ?? 0);
            }

            $data = [
                'penerimaan_id' => $this->penerimaan_id,
                'berat_produk' => $berat_produk,
                'total_produk' => $total_produk,
                'tgl_cutting' => $this->edit_tgl_cutting,
                'tgl_injek_co' => $this->edit_tgl_injek_co,
                'kategori_byproduk_id' => $this->selectedKategoriByproduk,
            ];

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
            'kategori_byproduk_ct' => KategoriByprodukCt::all(),
        ]);
    }   
}
