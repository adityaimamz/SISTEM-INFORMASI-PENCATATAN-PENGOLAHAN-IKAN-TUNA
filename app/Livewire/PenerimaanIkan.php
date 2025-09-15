<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Penerimaan_Ikan;
use App\Models\Supplier;
use App\Models\Grade;
use App\Models\KategoriBeratPenerimaan;
use App\Models\Cutting;
use Barryvdh\DomPDF\Facade\Pdf;

class PenerimaanIkan extends Component
{
    // Properti untuk menyimpan data
    public $rows = [];
    public $penerimaan_id = null;  
    public $session_date = null;
    public $session_tgl_bongkar = null;
    public $session_supplier = null;
    public $session_jenis_penerimaan = null;
    public $session_no_bak = null;
    public $selected_grade_id = null;
    public $selected_kategori_berat_id = null;
    
    // Properti untuk form input
    public $suppliers = [];
    public $grades = [];
    public $kategori_berat = [];
    public $penerimaanIkans = [];
    public $data = [];

    // Inisialisasi komponen
    public function mount()
    {
        $this->suppliers = Supplier::all();
        $this->grades = Grade::all();
        $this->kategori_berat = KategoriBeratPenerimaan::all();
        $this->loadData();  
    }

    // Load Data
    public function loadData()
    {
        try {
            $this->rows = [];
            // Gunakan relasi yang benar
            $query = Penerimaan_Ikan::with(['grade', 'kategoriBeratPenerimaan']);
            
            // Hanya filter jika nilai filter tidak null
            if (!empty($this->penerimaan_id)) {
                $query->where('penerimaan_id', $this->penerimaan_id);
            }
            
            if (!empty($this->session_date)) {
                $query->where('tgl_penerimaan', $this->session_date);
            }
            
            $penerimaans = $query->orderBy('penerimaan_id', 'desc')->get();
            
            foreach ($penerimaans as $penerimaan) {
                $this->rows[] = [
                    'penerimaan_id' => $penerimaan->penerimaan_id,
                    'grade_id' => $penerimaan->grade_id,
                    'kategori_berat_id' => $penerimaan->kategori_berat_id,
                    'berat_ikan' => $penerimaan->berat_ikan,
                    'suhu_ikan' => $penerimaan->suhu_ikan,
                    'no_ikan' => $penerimaan->no_ikan,
                ];
            }
            
        } catch (\Exception $e) {
            \Log::error('Error loading data: ' . $e->getMessage());
            session()->flash('error', 'Gagal memuat data: ' . $e->getMessage());
        }
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
            if (isset($this->rows[$index]['penerimaan_id'])) {
                try { 
                    Penerimaan_Ikan::where('penerimaan_id', $this->rows[$index]['penerimaan_id'])->delete();
                    session()->flash('message', 'Data berhasil dihapus');
                } catch (\Exception $e) {
                    session()->flash('error', 'Gagal menghapus data: ' . $e->getMessage());
                    return;
                }
            }
            unset($this->rows[$index]);
            $this->rows = array_values($this->rows);
        }
    }

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
            $this->reset(['rows','session_no_bak', 'selected_grade_id']);
            $this->addRow(); 
            
            session()->flash('message', 'Data berhasil disimpan!');

        } catch (\Exception $e) {
            \Log::error('Error saving data: ' . $e->getMessage());
            session()->flash('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function generateCombination()
    {
        $this->combinations = [];

        foreach ($this->grades as $grade) {
            foreach ($this->kategori_berat as $kategoriBerat) {
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
            $query = Penerimaan_Ikan::with('supplier', 'grade', 'kategoriBeratPenerimaan');
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
            $result = $query->orderBy('no_ikan', 'asc')->get();
            $this->penerimaanIkans = $result;
            $this->data = $this->penerimaanIkans;
            
            $this->rows = [];
            foreach ($result as $data) {
                $this->rows[] = [
                    'penerimaan_id' => $data->penerimaan_id,
                    'grade_id' => $data->grade_id,
                    'kategori_berat_id' => $data->kategori_berat_id,
                    'berat_ikan' => $data->berat_ikan,
                    'suhu_ikan' => $data->suhu_ikan,
                    'no_ikan' => $data->no_ikan,
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Error filtering data: ' . $e->getMessage());
            $this->data = [];
            $this->penerimaanIkans = [];
            $this->rows = [];
            session()->flash('error', 'Gagal filter data: ' . $e->getMessage()); 
        }
    }

    public function print()
    {
        try {
            // Validasi data yang diperlukan
            if (!$this->session_date || !$this->session_tgl_bongkar || 
                !$this->session_supplier || !$this->session_jenis_penerimaan || 
                !$this->session_no_bak || !$this->selected_grade_id) {
                throw new \Exception('Harap lengkapi semua filter terlebih dahulu');
            }
    
            // Pastikan ada data rows
            if (empty($this->rows)) {
                throw new \Exception('Tidak ada data yang akan dicetak');
            }
    
            // Ambil data supplier
            $supplier = \App\Models\Supplier::find($this->session_supplier);
            
            // Parse grade_id dan kategori_berat_id
            list($grade_id, $kategori_berat_id) = explode('_', $this->selected_grade_id);
            $grade = \App\Models\Grade::find($grade_id);
            $kategoriBerat = \App\Models\KategoriBeratPenerimaan::find($kategori_berat_id);

            //hitung total berat
            $total_berat = collect($this->rows)->sum('berat_ikan');
            $total_ekor = count($this->rows);
    
            // Siapkan data untuk view
            $data = [
                'session_date' => \Carbon\Carbon::parse($this->session_date)->format('d/m/Y'),
                'session_tgl_bongkar' => \Carbon\Carbon::parse($this->session_tgl_bongkar)->format('d/m/Y'),
                'session_supplier' => $supplier ? $supplier->nama_supplier : 'Tidak Diketahui',
                'session_jenis_penerimaan' => $this->session_jenis_penerimaan,
                'session_no_bak' => $this->session_no_bak,
                'grade' => $grade ? $grade->grade : '-',
                'kategori_berat' => $kategoriBerat ? $kategoriBerat->kategori_berat : '-',
                'rows' => $this->rows,
                'total_berat' => $total_berat,
                'total_ekor' => $total_ekor,
                'printed_at' => now()->format('d/m/Y H:i:s')
            ];
    
            // Generate PDF
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.laporan_penerimaan_ikan', $data);
            
            //$pdf = Pdf::loadView('admin.laporan.laporan_penerimaan_ikan', [
            //    'session_date' => $this->session_date,
            //    'session_supplier' => \App\Models\Supplier::find($this->session_supplier)->nama_supplier ?? 'Tidak Diketahui',
            //    'rows' => $this->rows,
            //]);
            // Nama file PDF
            $fileName = 'Laporan-Penerimaan-Ikan-' . now()->format('Ymd_His') . '.pdf';
    
            // Return PDF untuk di-download
            //return $pdf->download('laporan-penerimaan-'.now()->format('Ymd_His').'.pdf');


            return response()->stream(
                function () use ($pdf) {
                    echo $pdf->output();
                },
                $fileName,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . $fileName . '"'
                ]
            );
    
        } catch (\Exception $e) {
            $this->dispatch('show-error', message: 'Gagal mencetak: ' . $e->getMessage());
            \Log::error('Error in print: ' . $e->getMessage());
            //session()->flash('error', 'Gagal mencetak: ' . $e->getMessage());
        }
    
    }

    public function render() 
    {
        // Pastikan data sudah dimuat dengan relasi yang benar
        $this->kategori_berat = KategoriBeratPenerimaan::all();
        
        return view('livewire.penerimaan-ikan', [
            'penerimaanIkans' => $this->penerimaanIkans,
            'data' => $this->data,
            'session_date' => $this->session_date,
            'session_tgl_bongkar' => $this->session_tgl_bongkar,
            'suppliers' => $this->suppliers,
            'session_supplier' => $this->session_supplier,
            'session_jenis_penerimaan' => $this->session_jenis_penerimaan,
            'grades' => $this->grades,
            'kategori_berat' => $this->kategori_berat,
            'session_no_bak' => $this->session_no_bak,
            'records' => Penerimaan_Ikan::with(['grade', 'kategoriBeratPenerimaan'])->get(),
        ])->layout('layouts.app');
    }
}