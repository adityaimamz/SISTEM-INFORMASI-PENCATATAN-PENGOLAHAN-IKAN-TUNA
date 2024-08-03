<?php

namespace App\Http\Controllers;

use App\Models\Cutting;
use App\Models\Penerimaan_ikan;
use App\Models\Supplier;
use App\Models\NoBatch;
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


    public function cuttingPdf($no_batch)
    {
        $cuttings = Cutting::where('no_batch_id', $no_batch)->get();

        $pdf = Pdf::loadView('pdf.cutting', compact('cuttings', 'no_batch'));
        return $pdf->download('cutting_report_' . $no_batch . '.pdf');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        Cutting::create([
            'no_batch_id' => $request->no_batch_id, // Menambahkan no_batch
            'id_produk' => $request->id_produk,
            'berat_produk' => $request->berat_produk,
            'kategori_berat_id' => $request->kategori_berat_id,
            'tgl_cutting' => $request->tgl_cutting,
        ]);

        return redirect()->route('cutting.index')->with('success', 'Cutting berhasil ditambahkan.');
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
