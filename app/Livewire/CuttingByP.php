<?php

namespace App\Livewire;

use App\Models\Cutting;
use App\Models\Penerimaan_ikan;
use App\Models\Supplier;
use App\Models\KategoriByprodukCt;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

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
        $this->calculateTotals();
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
            $newRow['berat_produk' . $i] = '';
            $newRow['total_produk' . $i] = '';
        }
        $this->rows[] = $newRow;
        $this->calculateTotals();
    }

    public function calculateTotals()
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
            $this->calculateTotals();
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
        try {
            // Validasi input
            $validated = $this->validate([
                'penerimaan_id' => 'required|exists:penerimaan_ikan,penerimaan_id',
                'session_tgl_cutting' => 'required|date',
                'session_tgl_injek_co' => 'required|date|after_or_equal:session_tgl_cutting',
            ], [
                'penerimaan_id.required' => 'Penerimaan harus dipilih',
                'session_tgl_cutting.required' => 'Tanggal cutting harus diisi',
                'session_tgl_injek_co.required' => 'Tanggal injek CO harus diisi',
                'session_tgl_injek_co.after_or_equal' => 'Tanggal injek CO harus setelah atau sama dengan tanggal cutting',
            ]);

            // Validasi minimal satu produk dipilih
            if(empty(array_filter($this->selectedKategoriByproduk))) {
                $this->dispatch('show-error', 'Silakan pilih minimal satu produk');
                return;
            }

            // Validasi ada data yang diisi
            $hasData = false;
            foreach ($this->rows as $row) {
                for($i = 1; $i <= 7; $i++) {
                    if(!empty($row['berat_produk' . $i]) || !empty($row['total_produk' . $i])) {
                        $hasData = true;
                        break 2;
                    }
                }
            }

            if(!$hasData) {
                $this->dispatch('show-error', 'Tidak ada data yang akan disimpan');
                return;
            }

            // Proses penyimpanan
            DB::beginTransaction();
            $savedCount = 0;

            foreach ($this->rows as $row) {
                $berat_produk = [];
                $total_produk = [];
                $hasRowData = false;

                // Siapkan data untuk setiap produk
                for($i = 1; $i <= 7; $i++) {
                    $berat = !empty($row['berat_produk' . $i]) ? (float)$row['berat_produk' . $i] : 0;
                    $total = !empty($row['total_produk' . $i]) ? (int)$row['total_produk' . $i] : 0;
                    
                    if($berat > 0 || $total > 0) {
                        $hasRowData = true;
                    }
                    
                    $berat_produk[$i] = $berat;
                    $total_produk[$i] = $total;
                }

                // Hanya simpan jika ada data yang valid
                if($hasRowData) {
                    // Simpan setiap produk terpilih sebagai baris terpisah
                    foreach ($this->selectedKategoriByproduk as $kategoriId) {
                        if (empty($kategoriId)) continue;
                        
                        $data = [
                            'penerimaan_id' => $this->penerimaan_id,
                            'tgl_cutting' => $this->session_tgl_cutting,
                            'tgl_injek_co' => $this->session_tgl_injek_co,
                            'kategori_byproduk_id' => $kategoriId,
                            'berat_produk' => $berat_produk,
                            'total_produk' => $total_produk,
                            'no_batch' => $row['no_batch'] ?? null,
                        ];

                        Cutting::create($data);
                        $savedCount++;
                    }
                }
            }

            if ($savedCount === 0) {
                throw new \Exception('Tidak ada data yang berhasil disimpan');
            }

            DB::commit();
            
            // Reset form
            $this->resetForm();
            
            // Tampilkan pesan sukses
            $this->dispatch('show-success', 'Data berhasil disimpan. Total data: ' . $savedCount);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            $this->dispatch('show-error', 'Validasi gagal: ' . $e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal menyimpan data cutting: ' . $e->getMessage());
            $this->dispatch('show-error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    protected function resetForm()
    {
        $this->rows = [];
        $this->addRow();
        $this->penerimaan_id = null;
        $this->selectedKategoriByproduk = [
            1 => null, 2 => null, 3 => null, 4 => null, 
            5 => null, 6 => null, 7 => null
        ];
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
