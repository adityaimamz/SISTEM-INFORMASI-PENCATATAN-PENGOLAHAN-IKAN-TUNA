<?php

namespace App\Http\Controllers;

use App\Models\Cutting;
use App\Models\DetailProduk; // Mengubah model yang digunakan menjadi Cutting
use App\Models\Penerimaan_ikan;
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
        $detailproduk = DetailProduk::all();
        $penerimaan_ikan = Penerimaan_ikan::all();

        $totalBeratPerGrade = Cutting::selectRaw('kategori_ikans.grade, SUM(cuttings.berat_produk) as total_berat')
        ->join('penerimaan_ikans', 'cuttings.id_produk', '=', 'penerimaan_ikans.id')
        ->join('kategori_ikans', 'penerimaan_ikans.ikan_id', '=', 'kategori_ikans.id')
        ->groupBy('kategori_ikans.grade')
        ->get();
    

        return view('admin.cutting', [
            'cutting' => $cutting,
            'detailproduk' => $detailproduk,
            'penerimaan_ikan' => $penerimaan_ikan,
            'totalBeratPerGrade' => $totalBeratPerGrade,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function cuttingPdf($month, $year)
    {
        $data = Cutting::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

            $totalBeratPerGrade = Cutting::selectRaw('kategori_ikans.grade, SUM(cuttings.berat_produk) as total_berat')
            ->join('penerimaan_ikans', 'cuttings.id_produk', '=', 'penerimaan_ikans.id')
            ->join('kategori_ikans', 'penerimaan_ikans.ikan_id', '=', 'kategori_ikans.id')
            ->whereYear('cuttings.created_at', $year)
            ->whereMonth('cuttings.created_at', $month)
            ->groupBy('kategori_ikans.grade')
            ->get();
        

        $pdf = Pdf::loadView('pdf.cutting', compact('data', 'month', 'year', 'totalBeratPerGrade'));
        return $pdf->download('cutting_report_' . $month . '_' . $year . '.pdf');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        Cutting::create([
            'no_batch' => $request->no_batch, // Menambahkan no_batch
            'id_produk' => $request->id_produk,
            'berat_produk' => $request->berat_produk,
            'nama_produk' => $request->nama_produk,
        ]);

        return redirect()->route('cutting.index')->with('success', 'Cutting berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $no_batch)
    {
        // $request->validate([
        //     'jenis_ikan' => 'required|string|max:255',
        //     'berat_ikan' => 'required|string|max:255',
        //     'kategoris_id' => 'required|integer',
        // ]);

        $cutting = Cutting::findOrFail($no_batch); // Mengubah model yang digunakan menjadi Cutting
        $data = [
            'id_produk' => $request->id_produk,
            'berat_produk' => $request->berat_produk,
            'nama_produk' => $request->nama_produk,
        ];

        $cutting->update($data);

        return redirect()->route('cutting.index')->with('success', 'Cutting berhasil diperbarui.'); // Mengubah route redirect menjadi 'cutting.index'
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($no_batch)
    {
        $cutting = Cutting::findOrFail($no_batch); // Mengubah model yang digunakan menjadi Cutting
        $cutting->delete();

        return redirect()->route('cutting.index')->with('success', 'Cutting berhasil dihapus.'); // Mengubah route redirect menjadi 'cutting.index'
    }
}
