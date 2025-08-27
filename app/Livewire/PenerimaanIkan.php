<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Penerimaan_ikan;
use App\Models\Supplier;
use App\Models\Grade;
use App\Models\KategoriBeratPenerimaan;

class PenerimaanIkan extends Component
{
    public $session_penerimaan_id;
    public $date;
    public $supplier;
    public $suppliers;
    public $data = [];
    public $grades;
    public $kategori_berat;
    public $summary;
    
    // Session date - tanggal penerimaan yang diinputkan sekali
    public $session_date;
    
    // Session tgl_bongkar - tanggal bongkar yang diinputkan sekali
    public $session_tgl_bongkar= '';
    
    // Session supplier - supplier yang diinputkan sekali
    public $session_supplier= '';

    // Session jenis_penerimaan - jenis penerimaan yang diinputkan sekali
    public $session_jenis_penerimaan= '';

    // Session no_bak - no bak yang diinputkan sekali
    public $session_no_bak= '';

    // Properti untuk create/add new data
    public $grade_id;
    public $berat_ikan;
    public $suhu_ikan;
   

    // Properti untuk edit
    public $edit_penerimaan_id;
    public $edit_supplier_id;
    public $edit_grade_id;
    public $edit_kategori_berat_id;
    public $edit_jenis_penerimaan;
    public $edit_tgl_penerimaan;
    public $edit_tgl_bongkar;
    public $edit_berat_ikan;
    public $edit_suhu_ikan;
    

    // Add new properties for No. Bak functionality
    public $selectedIds = [];
    public $noBakValue = '';

    public function mount()
    {
        $this->date = now()->toDateString();
        $this->session_date = now()->toDateString(); // Set default session date
        $this->suppliers = Supplier::all();
        $this->grades = Grade::all();
        $this->kategori_berat = KategoriBeratPenerimaan::all();
        //$this->summary = all();
        
        // Filter data based on current date initially
        $this->filterData();
    }

    // Method untuk update data ketika session_date berubah
    public function updatedSessionDate()
    {
        // Update filter date to match session date
        $this->date = $this->session_date;
        // Reset session supplier when date changes
        $this->session_supplier = null;
        $this->session_tgl_bongkar = null;
        $this->session_jenis_penerimaan = null;
        $this->session_no_bak = null;
        $this->filterData();
    }

    // Method untuk update data ketika session_tgl_bongkar berubah
    public function updatedSessionTglBongkar()
    {
        $this->filterData();
    }

    // Method untuk update data ketika session_supplier berubah
    public function updatedSessionSupplier()
    {
        // Update filter supplier to match session supplier
        $this->supplier = $this->session_supplier;
        $this->filterData();
    }

    // Method untuk update data ketika session_jenis_penerimaan berubah
    public function updatedSessionJenisPenerimaan($value)
    {
        $this->filterData();
    }

    // Fungsi untuk filter data berdasarkan tanggal, supplier, dan jenis_penerimaan
    public function filterData()
    {
        try {
            $query = Penerimaan_ikan::with(['supplier', 'grade', 'kategori_berat_penerimaan']);

            // Apply date filter if set
            if ($this->session_date) {
                $query->whereDate('tgl_penerimaan', $this->session_date);
            }

            // Apply tgl_bongkar filter if set
            if ($this->session_tgl_bongkar) {
                $query->whereDate('tgl_bongkar', $this->session_tgl_bongkar);
            }

            // Apply supplier filter if set
            if ($this->session_supplier) {
                $query->where('supplier_id', $this->session_supplier);
            }

            // Apply jenis_penerimaan filter if set
            if ($this->session_jenis_penerimaan) {
                $query->where('jenis_penerimaan', $this->session_jenis_penerimaan);
            }

            // Apply no_bak filter if set
            if ($this->session_no_bak) {
                $query->where('no_bak', $this->session_no_bak);
               }

            // Get filtered data
            $this->data = $query->orderBy('created_at', 'asc')->get();
            
        } catch (\Exception $e) {
            \Log::error('Error filtering data: ' . $e->getMessage());
            $this->data = [];
            session()->flash('error', 'Gagal memuat data: ' . $e->getMessage());
        }
    }

    // Fungsi untuk menyimpan data baru
    public function store()
    {
        $this->validate([
            'grade_id' => 'required|exists:grades,id',
            'berat_ikan' => 'required|numeric|min:10',
            'suhu_ikan' => 'required|numeric|min:-50|max:50',
        ]);

        try {
            // Validasi session_date, session_tgl_bongkar, dan session_supplier terlebih dahulu
            if (!$this->session_date) {
                session()->flash('error', 'Pilih tanggal penerimaan terlebih dahulu.');
                return;
            }

            if (!$this->session_tgl_bongkar) {
                session()->flash('error', 'Pilih tanggal bongkar terlebih dahulu.');
                return;
            }

            if (!$this->session_supplier) {
                session()->flash('error', 'Pilih supplier terlebih dahulu.');
                return;
            }

            if (!$this->session_jenis_penerimaan) {
                session()->flash('error', 'Pilih jenis penerimaan terlebih dahulu.');
                return;
            }

            // Tentukan kategori_berat_id berdasarkan berat_ikan
            $kategori_berat_id = $this->getKategoriBeratId($this->berat_ikan);
            if (!$kategori_berat_id) {
                session()->flash('error', 'Berat ikan tidak valid. Minimal 10kg.');
                return;
            }

            // Simpan data baru
            Penerimaan_ikan::create([
                'penerimaan_id' => $this->session_penerimaan_id,
                'supplier_id' => $this->session_supplier,
                'grade_id' => $this->grade_id,
                'kategori_berat_id' => $kategori_berat_id,
                'tgl_penerimaan' => $this->session_date,
                'tgl_bongkar' => $this->session_tgl_bongkar,
                'berat_ikan' => $this->berat_ikan,
                'suhu_ikan' => $this->suhu_ikan,
                'jenis_penerimaan' => $this->session_jenis_penerimaan,
                'no_bak' => $this->session_no_bak,
            ]);

            // Refresh data setelah create
            $this->filterData();

            // Reset form fields
            $this->resetCreateForm();

            session()->flash('message', 'Data penerimaan ikan berhasil ditambahkan.');
            
            // Dispatch event to close modal
            $this->dispatch('closeModal');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    // Fungsi untuk mengisi properti edit
    public function edit($penerimaan_id)
    {
        $ikan = Penerimaan_ikan::findOrFail($penerimaan_id);

        $this->edit_penerimaan_id = $ikan->penerimaan_id;
        $this->edit_supplier_id = $ikan->supplier_id;
        $this->edit_grade_id = $ikan->grade_id;
        $this->edit_kategori_berat_id = $ikan->kategori_berat_id;
        $this->edit_tgl_penerimaan = $ikan->tgl_penerimaan;
        $this->edit_tgl_bongkar = $ikan->tgl_bongkar;
        $this->edit_berat_ikan = $ikan->berat_ikan;
        $this->edit_suhu_ikan = $ikan->suhu_ikan;
        $this->edit_jenis_penerimaan = $ikan->jenis_penerimaan;
        $this->edit_no_bak = $ikan->no_bak;
    }

    // Fungsi untuk menyimpan perubahan
    public function update()
    {
        $this->validate([
            'edit_penerimaan_id' => 'required|exists:penerimaan_ikans,penerimaan_id',
            'edit_supplier_id' => 'required|exists:suppliers,supplier_id',
            'edit_grade_id' => 'required|exists:grades,id',
            'edit_berat_ikan' => 'required|numeric|min:10',
            'edit_suhu_ikan' => 'required|numeric|min:-50|max:50',
            'edit_tgl_penerimaan' => 'required|date',
            'edit_jenis_penerimaan' => 'required|string|max:10',
            'edit_tgl_bongkar' => 'required|date|after_or_equal:edit_tgl_penerimaan',
            'edit_no_bak' => 'required|string|max:10',
        ]);

        try {
            // Tentukan kategori_berat_id berdasarkan berat_ikan
            $kategori_berat_id = $this->getKategoriBeratId($this->edit_berat_ikan);
            if (!$kategori_berat_id) {
                session()->flash('error', 'Berat ikan tidak valid. Minimal 10kg.');
                return;
            }

            // Update data
            $ikan = Penerimaan_ikan::findOrFail($this->edit_penerimaan_id);
            $ikan->update([
                'supplier_id' => $this->edit_supplier_id,
                'grade_id' => $this->edit_grade_id,
                'kategori_berat_id' => $kategori_berat_id,
                'tgl_penerimaan' => $this->edit_tgl_penerimaan,
                'tgl_bongkar' => $this->edit_tgl_bongkar,
                'berat_ikan' => $this->edit_berat_ikan,
                'suhu_ikan' => $this->edit_suhu_ikan,
                'jenis_penerimaan' => $this->edit_jenis_penerimaan,
                'no_bak' => $this->edit_no_bak,
            ]);

            // Refresh data setelah update
            $this->filterData();

            // Reset field setelah update
            $this->resetEditFields();

            session()->flash('message', 'Data penerimaan ikan berhasil diperbarui.');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    // Fungsi untuk menghapus data
    public function delete($penerimaan_id)
    {
        try {
            Penerimaan_ikan::destroy($penerimaan_id);
            $this->filterData();
            session()->flash('message', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Mendapatkan ID kategori berat berdasarkan berat ikan.
     */
    private function getKategoriBeratId($berat)
    {
        try {
            if ($berat >= 20) {
                $kategori = KategoriBeratPenerimaan::where('kategori_berat', '20 UP')->first();
                return $kategori ? $kategori->id : null;
            } elseif ($berat >= 10 && $berat < 20) {
                $kategori = KategoriBeratPenerimaan::where('kategori_berat', '20 DOWN')->first();
                return $kategori ? $kategori->id : null;
            }

            return null; // Jika tidak ada kategori yang cocok
        } catch (\Exception $e) {
            \Log::error('Error getting kategori berat ID: ' . $e->getMessage());
            return null;
        }
    }

    // Fungsi untuk mereset field create setelah store
    private function resetCreateForm()
    {
        $this->grade_id = null;
        $this->berat_ikan = null;
        $this->suhu_ikan = null;
    }

    // Fungsi untuk mereset field edit setelah update
    private function resetEditFields()
    {
        $this->edit_penerimaan_id = null;
        $this->edit_supplier_id = null;
        $this->edit_grade_id = null;
        $this->edit_kategori_berat_id = null;
        $this->edit_tgl_penerimaan = null;
        $this->edit_tgl_bongkar = null;
        $this->edit_berat_ikan = null;
        $this->edit_suhu_ikan = null;
        $this->edit_jenis_penerimaan = null;
        $this->edit_no_bak = null;
    }

    public function render()
    {
        return view('livewire.penerimaan-ikan', [
            'data' => $this->data,
            'suppliers' => $this->suppliers,
            'grades' => $this->grades,
            'kategori_berat' => $this->kategori_berat,
            'session_date' => $this->session_date,
            'session_tgl_bongkar' => $this->session_tgl_bongkar,
            'session_supplier' => $this->session_supplier,
            'session_jenis_penerimaan' => $this->session_jenis_penerimaan,
            'session_no_bak' => $this->session_no_bak,
            'records' => Penerimaan_ikan::all(),
        ])->layout('layouts.app');
    }
}
