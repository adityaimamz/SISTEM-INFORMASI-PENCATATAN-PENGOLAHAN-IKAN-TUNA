<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Penerimaan_Ikan;
use App\Models\Supplier;
use App\Models\Grade;
use App\Models\KategoriBeratPenerimaan;

class PenerimaanIkan extends Component
{
    public $penerimaanIkans = [];
    public $combinations = [];
    public $session_penerimaan_id;
    public $date;
    public $supplier;
    public $suppliers = [];
    public $data = [];
    public $kategori_berat;

    // NEW MODEL LIVEWIRE PENERIMAAN IKAN
    public $rows = [];
    public $grades = [];
    
    public function addRow()
    {
        $this->rows[] = ['berat_ikan' => '', 'suhu_ikan' => '', 'grade_id' =>''];
    }
    public function removeRow($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
    }
    public function updatedRows(){
        $this->validate([
            'rows.*.berat_ikan' => 'required|numeric',
            'rows.*.suhu_ikan' => 'required|numeric',
        ]);
    }
    public function destroyRow($index){
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
    }
    public function saveAll(){
        foreach($this->rows as $row){
            if (!isset($row['penerimaan_id']) || !$row['penerimaan_id']) {
                continue;
            }
        \App\Models\Penerimaan_Ikan::create([
            'tgl_penerimaan' => $this->session_date,
            'tgl_bongkar' => $this->session_tgl_bongkar,
            'supplier_id' => $this->session_supplier,
            'jenis_penerimaan' => $this->session_jenis_penerimaan,
            'no_bak' => $this->session_no_bak,
            'created_by' => auth()->user()->id,
            //row data
            'grade_id' => $row['grade_id'],
            'kategori_berat_id' => $row['kategori_berat_id'],
            'berat_ikan' => $row['berat_ikan'],
            'suhu_ikan' => $row['suhu_ikan'],
        ]);
        }
        $this->rows = [];
        session()->flash('message', 'Data berhasil disimpan!');
    }
    // END NEW MODEL LIVEWIRE PENERIMAAN IKAN

//--------------------------------------------------------------------------------------------------------//
        // OLD MODEL LIVEWIRE SESSION PENERIMAAN IKAN
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
    public $session_selectedIds = [];
    public $session_noBakValue = '';

    public function mount()
    {
        $this->penerimaanIkans = \App\Models\Penerimaan_Ikan::with
                                (['grade', 'kategoriBeratPenerimaan'])->get(); //Load data penerimaan ikan
        $this->suppliers = Supplier::all(); //Load data supplier
        $this->grades = Grade::all(); //Load data grade
        $this->kategoriBerats = KategoriBeratPenerimaan::all(); //Load data kategori berat
        $this->generateCombination(); //Generate kombinasi gradeXkategori berat

        $this->date = now()->toDateString(); //Load data tanggal
        $this->session_date = now()->toDateString(); 
        
        $this->filterData();
    }
    // Method kombinasi grade dan kategori berat
    public function generateCombination()
    {
        $grades = $this->grades;
        $kategoriBerats = $this->kategoriBerats;

        $this->combinations = [];

        foreach ($grades as $grade) {
            foreach ($kategoriBerats as $kategoriBerat) {
                $this->combinations[] = [
                    'grade' => $grade->grade,
                    'kategori_berat' => $kategoriBerat->kategori_berat,
                    'value' => $grade->grade_id . ' - ' . $kategoriBerat->kategori_berat_id,
                ];
            }
        }
    }

                                        // AWAL METHOD SEMUA UPDATE DATA
    public function updatedSessionDate()
    {
        $this->date = $this->session_date;
        $this->session_supplier = null;
        $this->session_tgl_bongkar = null;
        $this->session_jenis_penerimaan = null;
        $this->session_no_bak = null;
        $this->filterData();
    }
    public function updatedSessionTglBongkar()
    {
        $this->filterData();
    }
    public function updatedSessionSupplier()
    {
        $this->supplier = $this->session_supplier;
        $this->filterData();
    }
    public function updatedSessionJenisPenerimaan($value)
    {
        $this->filterData();
    }
    public function updatedSessionNoBak()
    {
        $this->filterData();
    }
                                        // AKHIR METHOD SEMUA UPDATE DATA



                                        // AWAL METHOD FILTER SEMUA DATA
    public function filterData()
    {
        try {
            $query = \App\Models\Penerimaan_Ikan::query()
                                ->with(['grade', 'kategoriBeratPenerimaan']);

            if ($this->session_date) {
                $query->whereDate('tgl_penerimaan', $this->session_date);
            }
            if ($this->session_tgl_bongkar) {
                $query->whereDate('tgl_bongkar', $this->session_tgl_bongkar);
            }
            if ($this->session_supplier) {
                $query->where('supplier_id', $this->session_supplier);
            }
            if ($this->session_jenis_penerimaan) {
                $query->where('jenis_penerimaan', $this->session_jenis_penerimaan);
            }
            if ($this->session_no_bak) {
                $query->where('no_bak', $this->session_no_bak);
               }
            $this->data = $query->orderBy('created_at', 'asc')->get();
            
        } catch (\Exception $e) {
            \Log::error('Error filtering data: ' . $e->getMessage());
            $this->data = [];
            session()->flash('error', 'Gagal memuat data: ' . $e->getMessage());
        }
    }
                                        // AKHIR METHOD FILTER SEMUA DATA


                                        // AWAL METHOD STORE SEMUA DATA
    public function store()
    {
        // Methode simpan data baru
        if(!$this->penerimaan_id){
            $this->addError('penerimaan_id', 'Silahkan pilih grade/size');
            return;
        }
        list($grade_id, $kategori_berat_id) = explode(' - ', $row['penerimaan_id']);

        if(!$grade_id || !$kategori_berat_id){
            $this->addError('penerimaan_id', 'Silahkan pilih grade/size');
            return;
        }
        
        
        // Validasi data
        $this->validate([
            'grade_id' => 'required|exists:grades,id',
            'berat_ikan' => 'required|numeric|min:10',
            'suhu_ikan' => 'required|numeric|min:-50|max:50',
        ]);

        try {
            // Validasi semua session
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

            if (!$this->session_no_bak) {
                session()->flash('error', 'Pilih no bak terlebih dahulu.');
                return;
            }

            // Tentukan kategori_berat_id berdasarkan berat_ikan
            $kategori_berat_id = $this->getKategoriBeratId($this->berat_ikan);
            if (!$kategori_berat_id) {
                session()->flash('error', 'Berat ikan tidak valid. Minimal 10kg.');
                return;
            }

            // Simpan data penerimaan ikan
            PenerimaanIkan::create([
                'grade_id' => $grade_id,
                'kategori_berat_id' => $kategori_berat_id,
                'tgl_penerimaan' => $this->session_date,
                'tgl_bongkar' => $this->session_tgl_bongkar,
                'supplier_id' => $this->session_supplier,
                'jenis_penerimaan' => $this->session_jenis_penerimaan,
                'no_bak' => $this->session_no_bak,
                'created_by' => auth()->user()->id,
                'berat_ikan' => $this->berat_ikan,
                'suhu_ikan' => $this->suhu_ikan,
            ]);

            // Refresh data setelah create
            $this->filterData();
            $this->PenerimaanIkan = PenerimaanIkan::with(['grade', 'kategoriBeratPenerimaan'])->get();

            // Reset form fields
            $this->resetCreateForm();
            $this->reset(['penerimaan_id', 'berat_ikan', 'suhu_ikan']);

            session()->flash('message', 'Data penerimaan ikan berhasil ditambahkan.');
            
            // Dispatch event to close modal
            $this->dispatch('closeModal');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menambahkan data: ' . $e->getMessage());
        }
    }

                                            // AKHIR METHOD STORE SEMUA DATA


                                            // AWAL METHOD EDIT DATA
    public function edit($penerimaan_id)
    {
        $ikan = PenerimaanIkan::findOrFail($penerimaan_id);

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

                                            // AKHIR METHOD EDIT DATA


                                            // AWAL METHOD UPDATE DATA
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
            $ikan = PenerimaanIkan::findOrFail($this->edit_penerimaan_id);
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

                                            // AKHIR METHOD UPDATE DATA

                                            
                                            // AWAL METHOD DELETE DATA
    public function delete($penerimaan_id)
    {
        try {
            PenerimaanIkan::destroy($penerimaan_id);
            $this->filterData();
            session()->flash('message', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

                                            // AKHIR METHOD DELETE DATA


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

                                            // AWAL METHOD RESET FORM
    private function resetCreateForm()
    {
        $this->grade_id = null;
        $this->berat_ikan = null;
        $this->suhu_ikan = null;
    }

                                            // AKHIR METHOD RESET FORM

                                            
                                            // AWAL METHOD RESET FORM EDIT
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

                                            // AKHIR METHOD RESET FORM EDIT


                                            // AWAL METHOD RENDER
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
            'records' => PenerimaanIkan::all(),
            'penerimaanIkans' => $this->penerimaanIkans,
        ])->layout('layouts.app');
    }
}
