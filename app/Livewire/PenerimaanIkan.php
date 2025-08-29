<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Penerimaan_Ikan;
use App\Models\Supplier;
use App\Models\Grade;
use App\Models\KategoriBeratPenerimaan;

class PenerimaanIkan extends Component
{
    // Properti untuk form input dan filter
    public $session_date;
    public $session_tgl_bongkar = '';
    public $session_supplier = '';
    public $session_jenis_penerimaan = '';
    public $session_no_bak = '';
    public $selected_grade_id = '';
    public $selected_kategori_berat_id = '';
    public $penerimaanIkans = [];
    public $suppliers = [];
    public $grades = [];
    public $kategoriBerats = [];
    public $combinations = [];
    public $rows = [];
    public $data = []; // Menambahkan properti $data yang hilang

    public function mount()
    {
        $this->grades = Grade::all();
        $this->kategoriBerats = KategoriBeratPenerimaan::all();
        $this->suppliers = Supplier::all();
        $this->addRow(); // Tambahkan baris kosong saat pertama kali load
    }

    public function addRow()
    {
        $this->rows[] = [
            'berat_ikan' => '',
            'suhu_ikan' => '',
            'grade_id' =>'',
            'kategori_berat_id' => '',
        ];
    }

    public function removeRow($index)
    {
        if (isset($this->rows[$index])) {
            unset($this->rows[$index]);
            $this->rows = array_values($this->rows);
        }
    }

    public function updated($propertyName)
    {
        if (str_starts_with($propertyName, 'rows.')) {
            $this->validateOnly($propertyName, [
                'rows.*.berat_ikan' => 'required|numeric|min:0.1',
                'rows.*.suhu_ikan' => 'required|numeric',
            ]);
            return;
        }
        if (in_array($propertyName, [
            'session_date', 
            'session_tgl_bongkar', 
            'session_supplier', 
            'session_jenis_penerimaan', 
            'session_no_bak', 
            'selected_grade_id', 
            'selected_kategori_berat_id'
        ])) {
            if ($this->session_date && $this->session_tgl_bongkar 
                && $this->session_supplier && $this->session_jenis_penerimaan 
                && $this->session_no_bak && $this->selected_grade_id 
                && $this->selected_kategori_berat_id) {
                $this->loadData();
            }
        }

    }
    
    public function saveAll()
    {
        \Log::info('Menyimpan Data');
        $this->validate([
            'session_date' => 'required|date',
            'session_tgl_bongkar' => 'required|date|after_or_equal:session_date',
            'session_supplier' => 'required|exists:suppliers,supplier_id',
            'session_jenis_penerimaan' => 'required|in:Fresh GG,Frozen WR YF,Frozen WR BF,Frozen WR BE,Frozen GG YF,Frozen GG BF,Frozen GG BE',
            'session_no_bak' => 'required|string|max:50',
            'selected_grade_id' => 'required|exists:grades,id',
            'selected_kategori_berat_id' => 'required|exists:kategori_berat_penerimaan,kategori_berat_id',
            'rows' => 'required|array|min:1',
            'rows.*.berat_ikan' => 'required|numeric|min:0.1',
            'rows.*.suhu_ikan' => 'required|numeric',
        ]);

        try {
            foreach ($this->rows as $row) {
                [$grade_id, $kategori_berat_id] = explode(' - ', $this->selected_grade_id . ' - ' . $this->selected_kategori_berat_id);
                Penerimaan_Ikan::create([
                    'tgl_penerimaan' => $this->session_date,
                    'tgl_bongkar' => $this->session_tgl_bongkar,
                    'supplier_id' => $this->session_supplier,
                    'jenis_penerimaan' => $this->session_jenis_penerimaan,
                    'no_bak' => $this->session_no_bak,
                    'grade_id' => $grade_id,
                    'kategori_berat_id' => $kategori_berat_id,
                    'berat_ikan' => $row['berat_ikan'],
                    'suhu_ikan' => $row['suhu_ikan'],
                    'created_by' => auth()->id()
                ]);
            }

            $this->reset(['rows', 'session_date', 'session_tgl_bongkar', 'session_supplier', 
                         'session_jenis_penerimaan', 'session_no_bak', 'selected_grade_id', 
                         'selected_kategori_berat_id']);
            $this->addRow(); // Tambahkan baris kosong setelah simpan
            
            session()->flash('message', 'Data berhasil disimpan!');
            
        } catch (\Exception $e) {
            \Log::error('Error saving data: ' . $e->getMessage());
            session()->flash('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

                                // Method kombinasi grade dan kategori berat
    public function generateCombination()
    {
        $this->combinations = [];

        foreach ($this->grades as $grade) {
            foreach ($this->kategoriBerats as $kategoriBerat) {
                $this->combinations[] = [
                    'grade_id' => $grade->grade_id,
                    'grade' => $grade->grade,
                    'kategori_berat_id' => $kategoriBerat->kategori_berat_id,
                    'kategori_berat' => $kategoriBerat->kategori_berat,
                    'value' => $grade->grade_id . ' - ' . $kategoriBerat->kategori_berat_id,
                ];
            }
        }
    }
                                // Method filter data
    public function filterData()
    {
        try {
            $query = \App\Models\Penerimaan_Ikan::with(['supplier', 'grade', 'kategoriBeratPenerimaan']);
            
            // Filter berdasarkan form input
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
                $query->where('no_bak', 'like', '%' . $this->session_no_bak . '%');
            }
            
            if ($this->selected_grade_id) {
                $query->where('grade_id', $this->selected_grade_id);
            }
            
            if ($this->selected_kategori_berat_id) {
                $query->where('kategori_berat_id', $this->selected_kategori_berat_id);
            }
            
            $this->penerimaanIkans = $query->latest()->get();
            $this->data = $this->penerimaanIkans; // Menyimpan data ke properti $data
                
        } catch (\Exception $e) {
            \Log::error('Error filtering data: ' . $e->getMessage());
            $this->data = []; // Inisialisasi $data dengan array kosong jika error
        }
    }

    //Load Data
    public function loadData()
    {
        $this->rows = [];
        $existingData = Penerimaan_Ikan::where('tgl_penerimaan', $this->session_date)
                    ->where('tgl_bongkar', $this->session_tgl_bongkar)
                    ->where('supplier_id', $this->session_supplier)
                    ->where('jenis_penerimaan', $this->session_jenis_penerimaan)
                    ->where('no_bak', $this->session_no_bak)
                    ->where('grade_id', $this->selected_grade_id)
                    ->where('kategori_berat_id', $this->selected_kategori_berat_id)
                    ->get();
        
        if ($existingData->isNotEmpty()) {
            foreach ($existingData as $data) {
                $this->rows[] = [
                    'berat_ikan' => $data->berat_ikan,
                    'suhu_ikan' => $data->suhu_ikan,
                ];
            }
        } else {
            $this->addRow();
        }
    }

    // Method render
    public function render()
    {
        return view('livewire.penerimaan-ikan', [
            'data' => $this->data,
            'suppliers' => $this->suppliers,
            'grades' => $this->grades,
            'kategori_berat' => $this->kategoriBerats,
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
