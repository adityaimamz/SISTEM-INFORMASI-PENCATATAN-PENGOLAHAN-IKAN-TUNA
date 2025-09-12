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
    
    // Property untuk filter
    public $filter_tgl_cutting_from;
    public $filter_tgl_cutting_to;
    public $filter_tgl_injek_co_from;
    public $filter_tgl_injek_co_to;
    public $filter_tgl_penerimaan_from;
    public $filter_tgl_penerimaan_to;
    public $filter_jenis_penerimaan;
    
    // Properties for editing
    public $cutting_id;
    public $edit_tgl_cutting;
    public $edit_tgl_injek_co;

    // Insialisasi data
    public function mount()
    {
        // Inisialisasi variabel yang diperlukan
        $this->kategori_byproduk_ct = KategoriByprodukCt::all();
        $this->penerimaan_ikan = Penerimaan_ikan::with('supplier')
            ->orderBy('tgl_penerimaan', 'desc')
            ->get();
            
        $this->selectedKategoriByproduk = [
            1 => null, 2 => null, 3 => null, 4 => null, 
            5 => null, 6 => null, 7 => null
        ];
        
        $this->rows = [];
        $this->filteredPenerimaan = collect();
        $this->addRow();
        
        // Inisialisasi session jika ada di URL
        if (request()->has('tgl_cutting')) {
            $this->session_tgl_cutting = request('tgl_cutting');
        }
        if (request()->has('tgl_injek_co')) {
            $this->session_tgl_injek_co = request('tgl_injek_co');
        }
        if (request()->has('penerimaan_id')) {
            $this->penerimaan_id = request('penerimaan_id');
            $this->selectedTanggalPenerimaan = request('penerimaan_id');
        }
        
        // Load data jika semua filter terisi
        if ($this->session_tgl_cutting && $this->session_tgl_injek_co && $this->penerimaan_id) {
            $this->loadData();
        } else {
            $this->reset(['rows']);
            $this->addRow();
        }
    }

    // Fungsi untuk memuat data yang sudah ada di database
    public function loadData()
    {
        try {
            // Reset rows terlebih dahulu
            $this->reset(['rows']);
            
            // Ambil data dari database berdasarkan filter
            $cuttings = Cutting::with(['penerimaan', 'kategoriByproduk'])
                ->where('tgl_cutting', $this->session_tgl_cutting)
                ->where('tgl_injek_co', $this->session_tgl_injek_co)
                ->where('penerimaan_id', $this->penerimaan_id)
                ->get();
            
            // Inisialisasi array untuk menyimpan data per produk
            $productsData = [];
            
            // Kelompokkan data berdasarkan kategori_byproduk_id
            foreach ($cuttings as $item) {
                $produkId = $item->kategori_byproduk_id;
                
                if (!isset($productsData[$produkId])) {
                    $productsData[$produkId] = [
                        'kategori_byproduk_id' => $produkId,
                        'berat' => 0,
                        'total' => 0,
                        'no_batch' => $item->no_batch // Ambil no_batch pertama yang ditemukan
                    ];
                }
                
                // Akumulasikan berat dan total
                $productsData[$produkId]['berat'] += $item->berat_kg;
                $productsData[$produkId]['total'] += $item->total_pcs;
            }

            //set selectedKategoriByproduk
            foreach ($productsData as $produk) {
                $index = array_search($produk['kategori_byproduk_id'], array_column($this->kategori_byproduk_ct->toArray(), 'kategori_byproduk_id')) + 1;
                if ($index > 0) {
                    $this->selectedKategoriByproduk[$index] = $produk['kategori_byproduk_id'];
                }
            }
            
            // Konversi ke format rows yang diharapkan
            foreach ($productsData as $produk) {
                $row = [
                    'no_batch' => $produk['no_batch'],
                    'kategori_byproduk_id' => []
                ];
                
                // Temukan urutan produk berdasarkan kategori_byproduk_id
                $urutan = array_search($produk['kategori_byproduk_id'], $this->selectedKategoriByproduk);
                if ($urutan === false) {
                    $urutan = 1; // Default ke kolom pertama jika tidak ditemukan
                }
                
                // Inisialisasi array untuk menyimpan data produk (1-7)
                for ($i = 1; $i <= 7; $i++) {
                    if ($i == $urutan) {
                        $row['berat_produk' . $i] = $produk['berat'];
                        $row['total_produk' . $i] = $produk['total'];
                        $row['kategori_byproduk_id'][$i] = $produk['kategori_byproduk_id'];
                    } else {
                        $row['berat_produk' . $i] = 0;
                        $row['total_produk' . $i] = 0;
                        $row['kategori_byproduk_id'][$i] = null;
                    }
                }
                
                $this->rows[] = $row;
            }
            
            // Jika tidak ada data, tambahkan baris kosong
            if (count($this->rows) === 0) {
                $this->addRow();
            }
            
            // Hitung total
            $this->calculateTotals();
            
        } catch (\Exception $e) {
            \Log::error('Error in loadData: ' . $e->getMessage());
            $this->rows = [];
            $this->addRow();
        }
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
            // Debug input data
            \Log::info('Data yang diterima:', [
                'penerimaan_id' => $this->penerimaan_id,
                'selectedKategoriByproduk' => $this->selectedKategoriByproduk,
                'rows' => $this->rows,
                'session_tgl_cutting' => $this->session_tgl_cutting,
                'session_tgl_injek_co' => $this->session_tgl_injek_co,
            ]);

            // Validasi input dasar
            $this->validate([
                'penerimaan_id' => 'required',
                'session_tgl_cutting' => 'required|date',
                'session_tgl_injek_co' => 'required|date|after_or_equal:session_tgl_cutting',
                'rows.*.no_batch' => 'nullable|string|max:50',
                'selectedKategoriByproduk' => 'nullable|array',
            ], [
                'penerimaan_id.required' => 'Penerimaan harus dipilih',
                'session_tgl_cutting.required' => 'Tanggal cutting harus diisi',
                'session_tgl_injek_co.required' => 'Tanggal injek CO harus diisi',
                'session_tgl_injek_co.after_or_equal' => 'Tanggal injek CO harus setelah atau sama dengan tanggal cutting',
            ]);

            DB::beginTransaction();
            $savedCount = 0;
            $hasAnyData = false;
            
            // Pastikan rows adalah array
            $rows = is_array($this->rows) ? $this->rows : [];
            
            foreach ($rows as $rowIndex => $row) {
                // Pastikan selectedKategoriByproduk adalah array
                $selectedProducts = is_array($this->selectedKategoriByproduk ?? null) ? 
                                 array_filter($this->selectedKategoriByproduk) : [];
                
                if (empty($selectedProducts)) {
                    \Log::warning('Tidak ada produk yang dipilih untuk baris: ' . $rowIndex);
                    continue;
                }

                foreach ($selectedProducts as $kategoriId) {
                    if (empty($kategoriId)) continue;
                    
                    // Ambil nilai berat dan total produk untuk produk ini
                    $beratKey = 'berat_produk' . $kategoriId;
                    $pcsKey = 'total_produk' . $kategoriId;
                    
                    // Ambil nilai dari row
                    $berat_produk = !empty($row[$beratKey]) ? [$row[$beratKey]] : [];
                    $total_produk = !empty($row[$pcsKey]) ? [$row[$pcsKey]] : [];
                    
                    // Debug data yang akan diproses
                    \Log::debug('Memproses data:', [
                        'rowIndex' => $rowIndex,
                        'kategoriId' => $kategoriId,
                        'berat_produk' => $berat_produk,
                        'total_produk' => $total_produk,
                        'has_berat' => !empty(array_filter($berat_produk)),
                        'has_total' => !empty(array_filter($total_produk))
                    ]);
                    
                    // Skip jika tidak ada data yang diisi
                    if (empty(array_filter($berat_produk)) && empty(array_filter($total_produk))) {
                        continue;
                    }

                    $hasAnyData = true;
                    
                    // Siapkan data untuk disimpan
                    $data = [
                        'penerimaan_id' => $this->penerimaan_id,
                        'tgl_cutting' => $this->session_tgl_cutting,
                        'tgl_injek_co' => $this->session_tgl_injek_co,
                        'kategori_byproduk_id' => $kategoriId,
                        'no_batch' => $row['no_batch'] ?? null,
                    ];

                    // Tambahkan berat_produk dan total_produk
                    $data['berat_produk'] = !empty(array_filter($berat_produk)) ? 
                                          json_encode($berat_produk) : json_encode([]);
                    $data['total_produk'] = !empty(array_filter($total_produk)) ? 
                                          json_encode($total_produk) : json_encode([]);

                    // Debug data sebelum disimpan
                    \Log::info('Menyimpan data cutting:', $data);
                    
                    // Simpan data
                    $cutting = Cutting::create($data);
                    
                    if (!$cutting->exists) {
                        throw new \Exception('Gagal menyimpan data ke database');
                    }
                    
                    $savedCount++;
                }
            }

            if (!$hasAnyData) {
                // Tampilkan pesan yang lebih informatif
                $message = 'Tidak ada data yang akan disimpan. ';
                $message .= 'Pastikan Anda telah memilih minimal satu produk dan mengisi berat atau total produk.';
                throw new \Exception($message);
            }

            DB::commit();
            
            $this->dispatch('show-success', 'Data berhasil disimpan! Total data: ' . $savedCount);
            $this->resetForm();
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error saat menyimpan data cutting: ' . $e->getMessage());
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

    // Method untuk mengambil,filter & reset data yang ada
    public function applyFilters()
    {
        $query = Cutting::query()
            ->join('penerimaan_ikan', 'cutting.penerimaan_id', '=', 'penerimaan_ikan.penerimaan_id')
            ->select('cuttings.*');

        if ($this->filter_tgl_cutting_from) {
            $query->whereDate('cuttings.tgl_cutting', '>=', $this->filter_tgl_cutting_from);
        }

        if ($this->filter_tgl_cutting_to) {
            $query->whereDate('cuttings.tgl_cutting', '<=', $this->filter_tgl_cutting_to);
        }

        if ($this->filter_tgl_injek_co_from) {
            $query->whereDate('cuttings.tgl_injek_co', '>=', $this->filter_tgl_injek_co_from);
        }

        if ($this->filter_tgl_injek_co_to) {
            $query->whereDate('cuttings.tgl_injek_co', '<=', $this->filter_tgl_injek_co_to);
        }

        if ($this->filter_tgl_penerimaan_from) {
            $query->whereDate('penerimaan_ikan.tgl_penerimaan', '>=', $this->filter_tgl_penerimaan_from);
        }

        if ($this->filter_tgl_penerimaan_to) {
            $query->whereDate('penerimaan_ikan.tgl_penerimaan', '<=', $this->filter_tgl_penerimaan_to);
        }

        if ($this->filter_jenis_penerimaan) {
            $query->where('penerimaan_ikan.jenis_penerimaan', $this->filter_jenis_penerimaan);
        }

        return $query->orderBy('cuttings.created_at', 'desc')->get();
    }
    
    public function resetFilters()
    {
        $this->filter_tgl_cutting_from = now()->format('Y-m-d');
        $this->filter_tgl_cutting_to = now()->format('Y-m-d');
        $this->filter_tgl_injek_co_from = now()->format('Y-m-d');
        $this->filter_tgl_injek_co_to = now()->format('Y-m-d');
        $this->filter_tgl_penerimaan_from = now()->format('Y-m-d');
        $this->filter_tgl_penerimaan_to = now()->format('Y-m-d');
        $this->filter_jenis_penerimaan = '';

        $this->applyFilters();
    }

    protected function getFilteredData()
    {
        $query = Cutting::with(['penerimaan_ikan.supplier']);

        //filter tanggal cutting
        if ($this->filter_tgl_cutting_from && $this->filter_tgl_cutting_to) {
            $query->whereBetween('tgl_cutting', [
                $this->filter_tgl_cutting_from . ' 00:00:00', 
                $this->filter_tgl_cutting_to . ' 23:59:59'
            ]);
        }
        //filter tanggal injek co
        if ($this->filter_tgl_injek_co_from && $this->filter_tgl_injek_co_to) {
            $query->whereBetween('tgl_injek_co', [
                $this->filter_tgl_injek_co_from . ' 00:00:00', 
                $this->filter_tgl_injek_co_to . ' 23:59:59'
            ]);
        }
        //filter tanggal penerimaan
        if ($this->filter_tgl_penerimaan_from && $this->filter_tgl_penerimaan_to) {
            $query->whereBetween('penerimaan_ikan.tgl_penerimaan', [
                $this->filter_tgl_penerimaan_from . ' 00:00:00', 
                $this->filter_tgl_penerimaan_to . ' 23:59:59'
            ]);

            if ($this->filter_jenis_penerimaan) {
                $query->where('penerimaan_ikan.jenis_penerimaan', $this->filter_jenis_penerimaan);
            }
        }

        return $query->orderBy('tgl_cutting', 'desc')->get   ();
    }
    
    // Method untuk filter data
    public function filterData()
    {
        $query = Cutting::with(['penerimaan.supplier', 'kategoriByproduk']);

        // Filter berdasarkan tanggal cutting
        if ($this->session_tgl_cutting) {
            $query->whereDate('tgl_cutting', $this->session_tgl_cutting);
        }

        // Filter berdasarkan tanggal injek co
        if ($this->session_tgl_injek_co) {
            $query->whereDate('tgl_injek_co', $this->session_tgl_injek_co);
        }

        // Filter berdasarkan tanggal penerimaan
        if ($this->selectedTanggalPenerimaan) {
            $penerimaanIds = Penerimaan_ikan::where('penerimaan_id', $this->selectedTanggalPenerimaan)
                ->pluck('penerimaan_id');
            $query->whereIn('penerimaan_id', $penerimaanIds);
        }

        // Filter berdasarkan jenis penerimaan
        if ($this->penerimaan_id) {
            $query->where('penerimaan_id', $this->penerimaan_id);
        }

        $this->cuttings = $query->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        $this->filterData();
        
        return view('livewire.cutting', [
            'cuttings' => $this->cuttings,
            'session_tgl_cutting' => $this->session_tgl_cutting,
            'session_tgl_injek_co' => $this->session_tgl_injek_co,
            'selectedSupplier' => $this->selectedSupplier,
            'penerimaan_ikan' => $this->penerimaan_ikan,
            'kategori_byproduk_ct' => KategoriByprodukCt::all(),
        ]);
    }

    // Update method updatedPenerimaanId untuk memuat data saat penerimaan_id berubah
    public function updatedPenerimaanId($value)
    {
        if ($this->session_tgl_cutting && $this->session_tgl_injek_co && $this->penerimaan_id) {
            $this->loadData();
        } else {
            $this->reset(['rows']);
            $this->addRow();
        }
    }
    
    // Update method updatedSessionTglInjekCo untuk reset data jika tanggal berubah
    public function updatedSessionTglInjekCo($value)
    {
        $this->reset(['selectedTanggalPenerimaan', 'penerimaan_id', 'rows']);
        $this->addRow();
    }
    
    // Update method updatedSessionTglCutting untuk reset data jika tanggal berubah
    public function updatedSessionTglCutting($value)
    {
        $this->reset(['session_tgl_injek_co', 'selectedTanggalPenerimaan', 'penerimaan_id', 'rows']);
        $this->addRow();
    }
}
