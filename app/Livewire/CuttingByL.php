<?php

namespace App\livewire;

use App\Models\CuttingL;
use App\Models\Penerimaan_ikan;
use App\Models\GradeL;
use App\Models\GradeService;
use App\Models\GradeHservice;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CuttingByL extends Component
{
    public $cuttingls = [];                         // Data Cutting loin
    public $session_tggl_cutting;                  
    public $session_tggl_injek_co;                  
    public $session_tggl_service; 
    public $no_batch;

    public $berat = [];
    public $berat_loin = 0;                         // penjumlahan berat
    public $total_loin = 0;
    public $berat_rm = [0, 0, 0];                       //array rm
    public $total_rm = 0;
    public $berat_hs = [0, 0, 0];                       //array hs
    public $total_hs = 0;
    public $pcs = [];
    public $pcs_loin = [];
    public $pcs_rm = [0, 0, 0];
    public $pcs_hs = [0, 0, 0];
    
    public $penerimaan_id;                          // Data Penerimaan
    public $no_ikan;
    public $selectedPenerimaan;
    public $penerimaan_ikan;
    public $filteredPenerimaan = [];
    public $selectedTanggalPenerimaan;              // selected tgl penerimaan
    public $selectedSizingLoin = [];                // Data Sizing Loin
    public $sizingLoin = [];
    public $selectedGradingService = [];            // Data Grading Service
    public $gradingService = [];
    public $selectedGradingHservice = [];           // Data Grading Hservice
    public $gradingHservice = [];

    public $rows = [];

// inisialisasi data
    public function mount()
    {
        $this->penerimaan_ikan = Penerimaan_ikan::with(['supplier' => function ($query) {
            $query->select('supplier_id', 'nama_supplier', 'alamat');
        }])
            ->select('penerimaan_ikans.*')
            ->orderBy('tgl_penerimaan', 'desc')
            ->get()
            ->unique('supplier_id')
            ->map(function ($item) {
                $item->tgl_penerimaan = \Carbon\Carbon::parse($item->tgl_penerimaan)->toDateString();
                return $item;
            })
            ->filter(function ($item) {
                return $item->supplier_id !== null;
            })
            ->values();

        $this->sizingLoin = GradeL::all();
        $this->selectedSizingLoin = [''];
        $this->gradingService = GradeService::all();
        $this->selectedGradingService = [''];
        $this->gradingHservice = GradeHservice::all();
        $this->selectedGradingHservice = [''];

        //inisialisasi array
        $this->berat_rm = [0, 0, 0];
        $this->berat_hs = [0, 0, 0];
        $this->pcs_rm = [0, 0, 0];
        $this->pcs_hs = [0, 0, 0];
        $this->pcs_loin = 0;
        $this->berat_loin = 0;
        $this->selectedTanggalPenerimaan = null;
        $this->filteredPenerimaan = collect();

        if (!is_array($this->rows)) {
            $this->rows = [];
        }
    }


//otomatis dipanggil jika penerimaan_id berubah
    public function updatedPenerimaanId($value) 
    {
        if ($value) {
            $penerimaan = Penerimaan_ikan::find($value);
            if ($penerimaan) {
                $this->selectedPenerimaan = $penerimaan;
                $this->no_ikan = $penerimaan->no_ikan;
            }
        }else {
            $this->selectedPenerimaan = null;
            $this->no_ikan = null;
        }
    }

//memanggil tanggal penerimaan ke cutting/service loin
    public function updatedSelectedTanggalPenerimaan($value)
    {
        $this->selectedTanggalPenerimaan = $value;
        $this->penerimaan_id = $value;
        $this->no_ikan = null;

        if ($value) {
            $this->filteredPenerimaan = $this->penerimaan_ikan->filter(function ($item) use ($value) {
                return \Carbon\Carbon::parse($item->tgl_penerimaan)->toDateString() === $value;
            })->values();
        } else {
            $this->filteredPenerimaan = collect();
        }
    }


//tambah row
    public function addRow()
    {
        $this->rows[] = [
            'berat_loin' => '',
            'suhu_loin' => '',
            'no_loin' => '',
            'berat_1' => '', 'berat_2' => '', 'berat_3' => '',
            'berat_4' => '', 'berat_5' => '', 'berat_6' => '',
            
        ];
    }

//hapus row
    public function removeRow($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
        $this->calculateTotals();
    }

//hitung total berat & pcs
    public function calculateTotals()
    {
        $this->berat_loin = 0;
        $this->berat_rm = [0, 0, 0];
        $this->pcs_rm = [0, 0, 0];
        $this->berat_hs = [0, 0, 0];
        $this->pcs_hs = [0, 0, 0];

        //inisialisasi array untuk berat
        $berat = [];
        $berat_rm = 0;
        $berat_hs = 0;
        for ($i=0; $i <= 5; $i++) {
            $berat[$i] = 0;
        }

        //hitung total & pcs dari semua rows
        foreach($this->rows as $row) {
            //total berat (cutting loin)
            $this->berat_loin += (float) ($row['berat_loin'] ?? 0);

            //total berat (RM service & pcs)
            for ($i= 1; $i <= 3; $i++) {
                $berat = (float) ($row['berat_' . $i] ?? 0);
                $this->berat_rm[$i-1] += $berat;
                if ($berat > 0) {
                    $this->pcs_rm[$i-1]++;
                }
            } 
            
            //total berat (HS service & pcs)
            for ($i=4; $i <= 6; $i++) {
                $berat = (float) ($row['berat_' . $i] ?? 0);
                $this->berat_hs[$i-4] += $berat;
                if ($berat > 0) {
                    $this->pcs_hs[$i-4]++;
                }
            }
        }
        // property untuk digunakan pada view
        $this->berat = $berat;
        $this->berat_rm = array_map('floatval', $this->berat_rm);
        $this->berat_hs = array_map('floatval', $this->berat_hs);
        $this->pcs_loin = count($this->rows);
    }

    public function updated($propertyName)
    {
        if (str_starts_with($propertyName, 'rows.')) {
            $this->calculateTotals();
        }

        if ($propertyName == 'selectedTanggalPenerimaan') {
            $this->updatedSelectedTanggalPenerimaan($this->selectedTanggalPenerimaan);
        }
    }
    
//simpan data
    public function saveAll()
    {

        $validateData = $this->validate([
            'session_tggl_cutting' => 'required|date',
            'session_tggl_injek_co' => 'required|date',
            'session_tggl_service' => 'required|date',
            'penerimaan_id' => 'required|exists:penerimaan_ikans,penerimaan_id',
            'no_ikan' => 'required|string',
            'selectedTanggalPenerimaan' => 'required|date',
            'selectedSizingLoin' => 'required|exists:grade_sizings,grade_size_id',
            'selectedGradingService' => 'required|exists:grade_services,grade_service_id',
            'selectedGradingHservice' => 'required|exists:grade_servicehs,grade_servicehs_id',
            'rows' => 'required|array',
            'no_batch' => 'required|string',
            'rows.*.berat' => 'required|numeric',
            'rows.*.suhu_loin' => 'required|numeric',
            'rows.*.no_loin' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            foreach ($this->rows as $row) {
                CuttingL::create([
                    'tggl_cutting' => $this->session_tggl_cutting,
                    'tggl_injek_co' => $this->session_tggl_injek_co,
                    'tggl_service' => $this->session_tggl_service,
                    'penerimaan_id' => $this->penerimaan_id,
                    'no_ikan' => $this->no_ikan,
                    'no_batch' => $this->no_batch,
                    'grade_size_id' => $this->selectedSizingLoin,
                    'grade_service_id' => $this->selectedGradingService,
                    'grade_servicehs_id' => $this->selectedGradingHservice,
                    'berat_loin' => $row['berat'],
                    'suhu_loin' => $row['suhu_loin'],
                    'no_loin' => $row['no_loin'],
                ]);
            }
            
            DB::commit();
            $this->dispatch('alert', type: 'success', message: 'Data berhasil disimpan');
            $this->resetForm();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: 'Gagal menyimpan data: ' . $th->getMessage());
        }
    }
    
//reset form
    public function resetForm()
    {
        $this->reset(['no_batch', 'rows']);
        $this->addRow();
    }

//render view
    public function render()
    {
        // filter berdasarlan tgl penerimaan
        $filteredPenerimaan = $this->penerimaan_ikan;
        if ($this->selectedTanggalPenerimaan) {
            //jika memilih tgl penerimaan
            $filteredPenerimaan = $this->penerimaan_ikan->filter(function($item) {
                return $item->tgl_penerimaan == $this->selectedTanggalPenerimaan;
            });
        }
        //perhitungan total & pcs
        $this->calculateTotals();

        return view('livewire.cuttingl', [
            'cuttingls' => $this->cuttingls,                                        // data session
            'session_tggl_cutting' => $this->session_tggl_cutting,
            'session_tggl_injek_co' => $this->session_tggl_injek_co,
            'session_tggl_service' => $this->session_tggl_service,

            'berat_loin' => $this->berat_loin,                                      // berat & pcs
            'berat_rm' => $this->berat_rm,
            'berat_hs' => $this->berat_hs,
            'pcs_loin' => $this->pcs_loin,
            'pcs_rm' => $this->pcs_rm,
            'pcs_hs' => $this->pcs_hs,
            'total_loin' => $this->total_loin,

            'penerimaan_id' => $this->penerimaan_id,                                // penerimaan    
            'penerimaan_ikan' => $this->penerimaan_ikan,
            'no_ikan' => $this->no_ikan,
            'selectedTanggalPenerimaan' => $this->selectedTanggalPenerimaan,
            'filteredPenerimaan' => $filteredPenerimaan,

            'selectedPenerimaan' => $this->selectedPenerimaan,                      // selected penerimaan  
            'selectedSizingLoin' => $this->selectedSizingLoin,
            'sizingLoin' => $this->sizingLoin,
            'selectedGradingService' => $this->selectedGradingService,
            'gradingService' => $this->gradingService,
            'selectedGradingHservice' => $this->selectedGradingHservice,
            'gradingHservice' => $this->gradingHservice,
            'rows' => $this->rows,
        ]);
    }

}
