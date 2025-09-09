<?php

namespace App\Http\Controllers;

use App\Models\Cutting;
use App\Models\Penerimaan_ikan;
use App\Models\Supplier;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Grade;


class CuttingController extends Controller// Mengubah nama controller menjadi CuttingController

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cutting = Cutting::all();
        $penerimaan_ikan = Penerimaan_ikan::all();
        $suppliers = Supplier::all();
        $selectedSupplier = null;

        return view('admin.transaksi.cutting', [
            'cutting' => $cutting,
            'penerimaan_ikan' => $penerimaan_ikan,
            'suppliers' => $suppliers,
            'selectedSupplier' => $selectedSupplier
        ]);
    }


    public function cuttingPdf(Request $request)
    {
        $filterMonth = $request->input('filterMonth');
    
        $cuttings = Cutting::whereMonth('tgl_cutting', Carbon::parse($filterMonth)->month)
            ->whereYear('tgl_cutting', Carbon::parse($filterMonth)->year)
            ->with(['kategori_berat', 'penerimaan_ikan.supplier'])
            ->get();
    
        $pdf = Pdf::loadView('pdf.cutting', [
            'cuttings' => $cuttings,
            'filterMonth' => $filterMonth,
        ]);
    
        return $pdf->download('cutting_report_' . $filterMonth . '.pdf');
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'no_batch_id' => 'required',
            'id_produk' => 'required',
            'berat_produk' => 'required|numeric|min:1',
            'tgl_cutting' => 'required|date',
            'tgl_injek_co' => 'required|date',
            'supplier_id' => 'required',
            'selectedSupplier' => 'required',
        ]);
    
        // Tentukan kategori berat otomatis berdasarkan berat produk
        $kategoriBeratId = $this->getKategoriBeratId($validated['berat_produk']);
    
        // Simpan data cutting
        Cutting::create([
            'id_produk' => $validated['id_produk'],
            'berat_produk' => $validated['berat_produk'],
            'kategori_berat_id' => $kategoriBeratId, // Terisi otomatis
            'tgl_cutting' => $validated['tgl_cutting'],
            'tgl_injek_co' => $validated['tgl_injek_co'],
            'supplier_id' => $validated['supplier_id'],
            'selectedSupplier' => $validated['selectedSupplier'],
        ]);
    
        return redirect()->route('cutting.index')->with('success', 'Cutting berhasil ditambahkan.');
    }

  
    public function update(Request $request, Cutting $cutting)
    {

        $data = [
            'id_produk' => $request->id_produk,
            'kategori_berat_id' => $request->kategori_berat_id,
            'berat_produk' => $request->berat_produk,
            'tgl_cutting' => $request->tgl_cutting,
            'tgl_injek_co' => $request->tgl_injek_co,
            'supplier_id' => $request->supplier_id,
            'selectedSupplier' => $request->selectedSupplier,
        ];

        $cutting->update($data);

        return redirect()->route('cutting.index')->with('success', 'Cutting berhasil diperbarui.'); // Mengubah route redirect menjadi 'cutting.index'
    }
}
