<?php

namespace App\Http\Controllers;

use App\Models\Cutting;
use App\Models\Penerimaan_ikan;
use App\Models\Supplier;
use App\Models\NoBatch;
use Carbon\Carbon;
use App\Models\KategoriBeratCutting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CuttingController extends Controller// Mengubah nama controller menjadi CuttingController

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cutting = Cutting::all();
        $no_batch = NoBatch::all();
        $penerimaan_ikan = Penerimaan_ikan::all();
        $suppliers = Supplier::all();
        $kategori_berat_cuttings = KategoriBeratCutting::all();


        return view('admin.transaksi.cutting-filter', [
            'cutting' => $cutting,
            'penerimaan_ikan' => $penerimaan_ikan,
            'suppliers' => $suppliers,
            'kategori_berat_cuttings' => $kategori_berat_cuttings,
            'no_batch' => $no_batch
        ]);
    }


    public function cuttingPdf(Request $request)
    {
        $filterMonth = $request->input('filterMonth');
    
        $cuttings = Cutting::whereMonth('tgl_cutting', Carbon::parse($filterMonth)->month)
            ->whereYear('tgl_cutting', Carbon::parse($filterMonth)->year)
            ->with(['kategori_berat', 'penerimaan_ikan.supplier', 'no_batch'])
            ->get();
    
        $total13 = $cuttings->where('kategori_berat.kategori_berat', '1/3')->sum('berat_produk');
        $total15 = $cuttings->where('kategori_berat.kategori_berat', '3/5')->sum('berat_produk');
        $total5 = $cuttings->where('kategori_berat.kategori_berat', '5 UP')->sum('berat_produk');
    
        $pdf = Pdf::loadView('pdf.cutting', [
            'cuttings' => $cuttings,
            'total13' => $total13,
            'total15' => $total15,
            'total5' => $total5,
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
        ]);
    
        // Tentukan kategori berat otomatis berdasarkan berat produk
        $kategoriBeratId = $this->getKategoriBeratId($validated['berat_produk']);
    
        // Simpan data cutting
        Cutting::create([
            'no_batch_id' => $validated['no_batch_id'],
            'id_produk' => $validated['id_produk'],
            'berat_produk' => $validated['berat_produk'],
            'kategori_berat_id' => $kategoriBeratId, // Terisi otomatis
            'tgl_cutting' => $validated['tgl_cutting'],
        ]);
    
        return redirect()->route('cutting.index')->with('success', 'Cutting berhasil ditambahkan.');
    }
    
    /**
     * Mendapatkan ID kategori berat berdasarkan berat produk.
     */
    private function getKategoriBeratId($berat)
    {
        if ($berat >= 1 && $berat <= 3) {
            return KategoriBeratCutting::where('kategori_berat', '1/3')->first()->id;
        } elseif ($berat > 3 && $berat <= 5) {
            return KategoriBeratCutting::where('kategori_berat', '3/5')->first()->id;
        } elseif ($berat > 5) {
            return KategoriBeratCutting::where('kategori_berat', '5 UP')->first()->id;
        }
    
        return null; // Default jika tidak ada kategori yang cocok
    }

  
    public function update(Request $request, $no_batch)
    {

        $cutting = Cutting::findOrFail($no_batch); // Mengubah model yang digunakan menjadi Cutting
        $data = [
            'no_batch_id' => $request->no_batch_id,
            'id_produk' => $request->id_produk,
            'kategori_berat_id' => $request->kategori_berat_id,
            'berat_produk' => $request->berat_produk,
            'tgl_cutting' => $request->tgl_cutting,
        ];

        $cutting->update($data);

        return redirect()->route('cutting.index')->with('success', 'Cutting berhasil diperbarui.'); // Mengubah route redirect menjadi 'cutting.index'
    }
    public function destroy($no_batch)
    {
        $cutting = Cutting::findOrFail($no_batch); // Mengubah model yang digunakan menjadi Cutting
        $cutting->delete();

        return redirect()->route('cutting.index')->with('success', 'Cutting berhasil dihapus.'); // Mengubah route redirect menjadi 'cutting.index'
    }
}
