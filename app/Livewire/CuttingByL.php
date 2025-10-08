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
    public $berat_rm = [1=> 0, 2=> 0, 3=> 0];                       //array rm
    public $total_rm = 0;
    public $berat_hs = [1=> 0, 2=> 0, 3=> 0];                       //array hs
    public $total_hs = 0;
    public $pcs = [];
    public $pcs_loin = [];
    public $pcs_rm = [1=> 0, 2=> 0, 3=> 0];
    public $pcs_hs = [1=> 0, 2=> 0, 3=> 0];
    
    public $penerimaan_id;                          // Data Penerimaan
    public $no_ikan;
    public $selectedPenerimaan;
    public $penerimaan_ikan;
    public $filteredPenerimaan = [];
    public $selectedTanggalPenerimaan;              // selected tgl penerimaan
    public $selectedSizingLoin = [1 => null];                // Data Sizing Loin
    public $sizingLoin = [];
    public $selectedGradingService = [];            // Data Grading Service
    public $gradingService = [];
    public $selectedGradingHservice = [];           // Data Grading Hservice
    public $gradingHservice = [];

    public $filterTanggalCutting;                   // filter data
    public $filterTanggalInjekCo;
    public $filterTanggalService;

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
        $this->selectedSizingLoin = [1 => null];
        $this->gradingService = GradeService::all();
        $this->selectedGradingService = [1 => null, 2 => null, 3 => null];
        $this->gradingHservice = GradeHservice::all();
        $this->selectedGradingHservice = [1 => null, 2 => null, 3 => null];

        //Inisialisasi filter tanggal
        $this->filterTanggalCutting = $this->session_tggl_cutting;
        $this->filterTanggalInjekCo = $this->session_tggl_injek_co;
        $this->filterTanggalService = $this->session_tggl_service;
        if ($this->filterTanggalCutting || $this->filterTanggalInjekCo || $this->filterTanggalService) {
            $this->searchByBatch();
        }

        //inisialisasi array
        $this->berat_rm = [0, 0, 0];
        $this->pcs_rm = [0, 0, 0];
        $this->berat_hs = [0, 0, 0];
        $this->pcs_hs = [0, 0, 0];
        $this->pcs_loin = 0;
        $this->berat_loin = 0;
        $this->selectedTanggalPenerimaan = null;
        $this->filteredPenerimaan = collect();
        
        //inisialisasi no batch
        $this->allBatches = $this->getAvailableBatches();
        $this->resetForm();

        if (!is_array($this->rows)) {
            $this->rows = [
                [
                    'no_loin' => '',
                    'berat_loin' => 0,
                    'suhu_loin' => 0
                ]
            ];
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

//simpan data
    public function saveAll()
    {
        try {
            DB::beginTransaction();

            $validatedData = $this->validate([
                'session_tggl_cutting' => 'required|date',
                'session_tggl_injek_co' => 'required|date',
                'session_tggl_service' => 'required|date',
                'penerimaan_id' => 'required|exists:penerimaan_ikans,penerimaan_id',
                'no_batch' => 'required|string',
                'selectedSizingLoin.1' => 'required|exists:grade_sizings,grade_size_id',
                'rows.*.berat_loin' => 'required|numeric',
                'rows.*.suhu_loin' => 'required|numeric',
                'rows.*.no_loin' => 'required|string',

                'selectedGradingService.1' => 'nullable|exists:grade_services,grade_service_id',
                'berat_rm.1' => 'nullable|numeric',
                'pcs_rm.1' => 'nullable|integer',

                'selectedGradingHservice.1' => 'nullable|exists:grade_servicehs,grade_servicehs_id',
                'berat_hs.1' => 'nullable|numeric',
                'pcs_hs.1' => 'nullable|integer',
            ]);

            foreach ($this->rows as $row) {
                \App\Models\CuttingL::updateOrCreate (
                    [
                        'no_batch' => $this->no_batch,
                        'no_loin' => $row['no_loin']
                    ],
                    [
                        'berat_loin' => $row['berat_loin'],
                        'suhu_loin' => $row['suhu_loin']
                    ]
                );
            }

            $additionalData = [];
            for ($i = 2; $i <= 3; $i++) {

                if (isset($this->selectedGradingService[$i])) {
                }
            }
            $additionalData =  $additionalData ?? [];
            $additionalData = array_merge($additionalData, [
                'tggl_cutting' => $this->session_tggl_cutting,
                'tggl_injek_co' => $this->session_tggl_injek_co,
                'tggl_service' => $this->session_tggl_service,
                'penerimaan_id' => $this->penerimaan_id,
                'no_batch' => $this->no_batch,
                'grade_size_id' => $this->selectedSizingLoin[1],
                'no_loin' => $this->rows[0]['no_loin'],
                'berat_loin' => $this->rows[0]['berat_loin'],
                'suhu_loin' => $this->rows[0]['suhu_loin'],
                'grade_service_id' => $this->selectedGradingService[1] ?? null,
                'grade_servicehs_id' => $this->selectedGradingHservice[1] ?? null,
            ]);

                if(!empty($this->selectedGradingService[1])) {
                    $additionalData = array_merge($additionalData, [
                        'grade_service_id' => $this->selectedGradingService[1] ?? null,
                        'berat_rm' => $this->berat_rm[1] ?? 0,
                        'pcs_rm' => $this->pcs_rm[1] ?? 0,
                    ]);
                }

                if(!empty($this->selectedGradingHservice[1])) {
                    $additionalData = array_merge($additionalData, [
                        'grade_servicehs_id' => $this->selectedGradingHservice[1] ?? null,
                        'berat_hs' => $this->berat_hs[1] ?? 0,
                        'pcs_hs' => $this->pcs_hs[1] ?? 0,
                    ]);
                }

                $cuttingL = CuttingL::create($additionalData);
                
                //data tambahan
                for ($i = 2; $i <= 3; $i++) {
                    if (isset($this->selectedGradingService[$i]) || isset($this->selectedGradingHservice[$i])) {
                        $additionalRecord = array_merge($additionalData, [
                            // Data RM Service
                            'grade_service_id' => $this->selectedGradingService[$i] ?? null,
                            'berat_rm' => $this->berat_rm[$i] ?? 0,
                            'pcs_rm' => $this->pcs_rm[$i] ?? 0,

                            // Data Hasil Service
                            'grade_servicehs_id' => $this->selectedGradingHservice[$i] ?? null,
                            'berat_hs' => $this->berat_hs[$i] ?? 0,
                            'pcs_hs' => $this->pcs_hs[$i] ?? 0,
                        ]);
                        $cuttingL = CuttingL::create($additionalRecord);
                    }
                }

            DB::commit();
            session()->flash('message', 'Data berhasil disimpan');
            $this->resetForm();

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal menyimpan data: ' . $e->getMessage());
            \Log::error('Error saving cutting data:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        } 
    }

// update data
    public function updated($propertyName)
    {
        if (in_array($propertyName, ['session_tggl_cutting', 'session_tggl_injek_co', 'session_tggl_service'])) {
            $this->searchByBatch();
        }

        if (str_starts_with($propertyName, 'rows.')) {
            $this->calculateTotals();
            $index = explode('.', $propertyName)[1];
            $row = $this->rows[$index] ?? null;

            if ($row) {
                //update data ke database
                \App\Models\CuttingL::updateOrCreate(
                    [
                        'no_batch' => $this->no_batch,
                        'no_loin' => $row['no_loin']
                    ],
                    [
                        'berat_loin' => $row['berat_loin'],
                        'suhu_loin' => $row['suhu_loin']
                    ]
                );
            }
        }
        //handle perubahan tanggal penerimaan
        if ($propertyName === 'selectedTanggalPenerimaan') {
            $this->updatedSelectedTanggalPenerimaan($this->selectedTanggalPenerimaan);
        }
    }

//filter tanggal
    public function updateFilterTanggal($type) {
        switch ($type) {
            case 'cutting':
                $this->filterTanggalCutting = $this->session_tggl_cutting;
                break;
            case 'injek_co':
                $this->filterTanggalInjekCo = $this->session_tggl_injek_co;
                break;
            case 'service':
                $this->filterTanggalService = $this->session_tggl_service;
                break;
        }
        $this->searchByBatch();
    }

    //searh no batch
    public $searchBatch = '';
    public $allBatches = [];

    public function searchByBatch () {
        try {
            $query = \App\Models\CuttingL::query();

            if (!empty($this->session_tggl_cutting)) {
                $query->whereDate('tggl_cutting', $this->session_tggl_cutting);
            }

            if (!empty($this->session_tggl_injek_co)) {
                $query->whereDate('tggl_injek_co', $this->session_tggl_injek_co);
            }

            if (!empty($this->session_tggl_service)) {
                $query->whereDate('tggl_service', $this->session_tggl_service);
            }

            if (!empty($this->no_batch)) {
                $query->where('no_batch', $this->no_batch);
                return collect();
            }
    
            $results = $query->with([
                    'grade_size',
                    'grade_service', 
                    'grade_servicehs',
                    'penerimaan.supplier'
                ])
                ->get();

            if ($results->isNotEmpty()) {
                if (empty($this->no_batch) && $results->first()->no_batch) {
                    $this->no_batch = $results->first()->no_batch;
                }
                $this->selectedSizingLoin = [1 => $results->first()->grade_size_id ?? null];

                $this->rows = $results->map(function ($item) {
                    return [
                        'no_batch' => $item->no_batch ?? '',
                        'grade_size_id' => $item->grade_size_id ?? '',
                        'no_loin' => $item->no_loin ?? '',
                        'berat_loin' => $item->berat_loin ?? 0,
                        'suhu_loin' => $item->suhu_loin ?? 0,
                    ];
                })->toArray();

                return $results;
            } else {
                $this->resetForm();
                return collect();
            }

        } catch (\Exception $e) {
            \Log::error('Error in searchByBatch: ' . $e->getMessage());
            return collect();
        }

    }
    // method mendapatkan daftar no batch
    public function getAvailableBatches () {
        return CuttingL::select('no_batch')
            ->distinct()
            ->orderBy('no_batch', 'asc')
            ->pluck('no_batch');
    }
    // method memicu pencarian no batch
    public function updatedNoBatch($value) {
        if (!empty($value)) {
            $this->searchByBatch();
        } else {
            $this->resetForm();
        }
    }
    // reset filter
    public function resetFilters () {
        $this->reset([
            'session_tggl_cutting',
            'session_tggl_injek_co',
            'session_tggl_service',
            'filterTanggalCutting',
            'filterTanggalInjekCo',
            'filterTanggalService',
        ]);
        $this->searchByBatch();
    }

//reset form
    public function resetForm()
    {
        $this->rows = [[
            'no_batch' => '',
            'grade_size_id' => '',
            'no_loin' => '',
            'berat_loin' => '',
            'suhu_loin' => '',
        ]];
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
        $this->allBatches = $this->getAvailableBatches();

        $cuttingData = collect();
        if (!empty($this->no_batch)) {
            $cuttingData = $this->searchByBatch();
        }
        

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

            'cuttingData' => $cuttingData,
            'allBatches' => $this->allBatches,
            ]);
    }
}