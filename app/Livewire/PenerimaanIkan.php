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
    public $session_tgl_bongkar;
    public $session_supplier;
    public $session_jenis_penerimaan;
    public $session_no_bak;
    public $selected_grade_id;
    public $selected_kategori_berat_id;
    public $penerimaanIkans = [];
    public $suppliers = [];
    public $grades = [];
    public $kategoriBerats = [];
    public $no_ikan = [];
    public $combinations = [];
    public $rows = [];
    public $data = []; // Menambahkan properti $data yang hilang

    public function mount()
    {
        $this->grades = Grade::all();
        $this->kategoriBerats = KategoriBeratPenerimaan::all();
        $this->suppliers = Supplier::all();
        $this->addRow(); // Tambahkan baris kosong saat pertama kali load
        $this->resetForm();
    }

    public function addRow()
    {
        $this->rows[] = [
            'grade_id' =>'',
            'kategori_berat_id' => '',
            'berat_ikan' => '',
            'suhu_ikan' => '',
            'no_ikan' => '',
        ];
    }

    public function removeRow($index)
    {
        if (isset($this->rows[$index])) {
            unset($this->rows[$index]);
            $this->rows = array_values($this->rows);
        }
    }
// Method updated dan reset Form saat filter berubah
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'updateFilter' => 'filterData',
    ];
    public function updated($propertyName)
    {
        $filterField = [
            'session_date',
            'session_tgl_bongkar', 
            'session_supplier', 
            'session_jenis_penerimaan', 
            'session_no_bak', 
            'selected_grade_id'
        ];
        if (in_array($propertyName, $filterField)) {
            $this->rows = [];
            $this->filterData();
            if($this->session_date && $this->session_tgl_bongkar && 
            $this->session_supplier && $this->session_jenis_penerimaan && 
            $this->session_no_bak && $this->selected_grade_id) {
                $this->loadData();
            } else {
                $this->reset(['rows']);
                $this->addRow();
            }
        }
    }
    public function resetForm()
    {
        $this->rows = [];
        $this->addRow();
        $this->reset ([
            //'session_date', 
            'session_tgl_bongkar', 
            'session_supplier', 
            'session_jenis_penerimaan', 
            'session_no_bak', 
            'selected_grade_id'
        ]);
    }



// Method saveAll
    public function saveAll()
    {
        \Log::info('Menyimpan Data', [
            'selected_grade_id' => $this->selected_grade_id,
            'rows' => $this->rows
        ]);

        try {
            $validated = $this->validate([
            'session_date' => 'required|date',
            'session_tgl_bongkar' => 'required|date|after_or_equal:session_date',
            'session_supplier' => 'required|exists:suppliers,supplier_id',
            'session_jenis_penerimaan' => 'required|in:Fresh GG,Frozen WR YF,Frozen WR BF,Frozen WR BE,Frozen GG YF,Frozen GG BF,Frozen GG BE',
            'session_no_bak' => 'required|string|max:50',
            'selected_grade_id' => 'required|string',
            //'selected_kategori_berat_id' => 'required|string',
            'rows.*.berat_ikan' => 'required|numeric|min:0.1',
            'rows.*.suhu_ikan' => 'required|numeric',
            'rows.*.no_ikan' => 'required|string|max:50',
            'rows' => 'required|array|min:1',
        ]);
        if (strpos($this->selected_grade_id, '_') === false) {
            throw new \Exception('Grade/size tidak valid');
        }
        list($grade_id, $kategori_berat_id) = explode('_', $this->selected_grade_id);
        \Log::info('Data yang disimpan', [
            'grade_id' => $grade_id,
            'kategori_berat_id' => $kategori_berat_id,
            'rows' => $this->rows
        ]);
        foreach ($this->rows as $row) {
            $exists = Penerimaan_Ikan::where('tgl_penerimaan', $this->session_date)
                ->where('tgl_bongkar', $this->session_tgl_bongkar)
                ->where('supplier_id', $this->session_supplier)
                ->where('jenis_penerimaan', $this->session_jenis_penerimaan)
                ->where('no_bak', $this->session_no_bak)
                ->where('grade_id', $grade_id)
                ->where('kategori_berat_id', $kategori_berat_id)
                ->where('berat_ikan', $row['berat_ikan'])
                ->where('suhu_ikan', $row['suhu_ikan'])
                ->where('no_ikan', $row['no_ikan'])
                ->exists();

            if(!$exists) {
                $penerimaan = Penerimaan_Ikan::create([
                    'tgl_penerimaan' => $this->session_date,
                    'tgl_bongkar' => $this->session_tgl_bongkar,
                    'supplier_id' => $this->session_supplier,
                    'jenis_penerimaan' => $this->session_jenis_penerimaan,
                    'no_bak' => $this->session_no_bak,
                    'grade_id' => $grade_id,
                    'kategori_berat_id' => $kategori_berat_id,
                    'berat_ikan' => $row['berat_ikan'],
                    'suhu_ikan' => $row['suhu_ikan'],
                    'no_ikan' => $row['no_ikan'],
                    'created_by' => auth()->id(),
                ]);
            }
        }
            $this->reset(['rows','session_supplier', 'session_jenis_penerimaan', 'session_no_bak', 'selected_grade_id']);
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
                    'value' => $grade->grade_id . '_' . $kategoriBerat->kategori_berat_id,
                ];
            }
        }
    }


// Method filter data
    public function filterData()
    {
        try {
            $validated = $this->validate([
                'session_date' => 'nullable|date',
                'session_tgl_bongkar' => 'nullable|date',
                'session_supplier' => 'nullable|exists:suppliers,supplier_id',
                'session_jenis_penerimaan' => 'nullable|string|in:Fresh GG,Frozen WR YF,Frozen WR BF,Frozen WR BE,Frozen GG YF,Frozen GG BF,Frozen GG BE',
                'session_no_bak' => 'nullable|string|max:50',
                'selected_grade_id' => 'nullable|string',
            ]);
            $query = Penerimaan_Ikan::query();
            $query = $query->with(['supplier', 'grade', 'kategoriBeratPenerimaan']);
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
            
            if ($this->selected_grade_id && strpos($this->selected_grade_id, '_') !== false) {
                list($grade_id, $kategori_berat_id) = explode('_', $this->selected_grade_id);
                $query->where('grade_id', $grade_id)
                      ->where('kategori_berat_id', $kategori_berat_id);
            } else {
                $query->where('grade_id', $this->selected_grade_id);
            }
            $result = $query->latest()->get();
            $this->penerimaanIkans = $query->latest()->get();
            $this->data = $this->penerimaanIkans;
            
            foreach ($result as $data) {
                $this->rows[] = [
                    'grade_id' => $data->grade_id,
                    'kategori_berat_id' => $data->kategori_berat_id,
                    'berat_ikan' => $data->berat_ikan,
                    'suhu_ikan' => $data->suhu_ikan,
                    'no_ikan' => $data->no_ikan,
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Error filtering data: ' . $e->getMessage());
            $this->data = []; // Inisialisasi $data dengan array kosong jika error
        }
    }

// Load Data
    public function loadData()
    {
        try {

            if(strpos($this->selected_grade_id, '_') === false) {
                throw new \Exception('Invalid grade_id format');
            }
            
            if (!$this->session_date || !$this->session_tgl_bongkar || 
            !$this->session_supplier || !$this->session_jenis_penerimaan || 
            !$this->session_no_bak || !$this->selected_grade_id || 
            !$this->selected_kategori_berat_id) {
            return;
            }
        
            list($grade_id, $kategori_berat_id) = explode('_', $this->selected_grade_id);
            $existingData = Penerimaan_Ikan::where('tgl_penerimaan', $this->session_date)
                    ->where('tgl_bongkar', $this->session_tgl_bongkar)
                    ->where('supplier_id', $this->session_supplier)
                    ->where('jenis_penerimaan', $this->session_jenis_penerimaan)
                    ->where('no_bak', $this->session_no_bak)
                    ->where('grade_id', $grade_id)
                    ->where('kategori_berat_id', $kategori_berat_id)
                    ->get();

            $this->rows = [];
        
            if ($existingData->isNotEmpty()) {
                foreach ($existingData as $data) {
                    $this->rows[] = [
                        'grade_id' => $data->grade_id,
                        'kategori_berat_id' => $data->kategori_berat_id,
                        'berat_ikan' => $data->berat_ikan,
                        'suhu_ikan' => $data->suhu_ikan,
                        'no_ikan' => $data->no_ikan,
                    ];
                }
            } else {
                $this->addRow();
            }
        } catch (\Exception $e) {
            \Log::error('Error in loadData: ' . $e->getMessage());
            $this->rows = [];
        }
    }

// Method render
    public function render() 
{
        return view('livewire.penerimaan-ikan', [
            'penerimaanIkans' => $this->penerimaanIkans,
            'data' => $this->data,
            'session_date' => $this->session_date,
            'session_tgl_bongkar' => $this->session_tgl_bongkar,
            'suppliers' => $this->suppliers,
            'session_supplier' => $this->session_supplier,
            'session_jenis_penerimaan' => $this->session_jenis_penerimaan,
            'grades' => $this->grades,
            'kategori_berat' => $this->kategoriBerats,
            'session_no_bak' => $this->session_no_bak,
            'records' => PenerimaanIkan::all(),
        ])->layout('layouts.app');
    }
}
