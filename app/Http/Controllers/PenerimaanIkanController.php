<?php

namespace App\Http\Controllers;

use App\Models\Kategori_ikan;
use App\Models\Penerimaan_Ikan;
use App\Models\Supplier;
use App\Models\Grade;
use App\Models\KategoriBeratPenerimaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PenerimaanIkanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Penerimaan_Ikan::all();
        $suppliers = Supplier::all();
        $grades = Grade::all();
        $kategori_berat_penerimaans = KategoriBeratPenerimaan::all();
        return view('admin.transaksi.penerimaan_ikan', ['data' => $data, 'suppliers' => $suppliers, 'grades' => $grades, 'kategori_berat_penerimaans' => $kategori_berat_penerimaans]);
    }

    public function getIkan($id)
    {
        $ikan = Kategori_ikan::find($id);

        return $ikan ? json_encode($ikan) : 'ikan tidak ditemukan';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function ikanPdf($month, $year)
    {
        $data = Penerimaan_Ikan::whereYear('tgl_penerimaan', $year)
            ->whereMonth('tgl_penerimaan', $month)
            ->get();

        $pdf = Pdf::loadView('pdf.ikan', compact('data', 'month', 'year'));
        return $pdf->download('ikan_report_' . $month . '_' . $year . '.pdf');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'supplier_id' => 'required|exists:suppliers,id',
        //     'ikan_id' => 'required|exists:ikans,id',
        //     'tgl_penerimaan' => 'required|date',
        // ]);

        Penerimaan_Ikan::create([
            'supplier_id' => $request->supplier_id,
            'grade_id' => $request->grade_id,
            'kategori_berat_id' => $request->kategori_berat_id,
            'berat_ikan' => $request->berat_ikan,
            'tgl_penerimaan' => $request->tgl_penerimaan,
        ]);

        return redirect()->route('penerimaan_ikan.index')->with('success', 'Penerimaan Ikan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $penerimaanIkan = Penerimaan_Ikan::findOrFail($id);
        $penerimaanIkan->update([
            'supplier_id' => $request->supplier_id,
            'grade_id' => $request->grade_id,
            'kategori_berat_id' => $request->kategori_berat_id,
            'tgl_penerimaan' => $request->tgl_penerimaan,
            'berat_ikan' => $request->berat_ikan,
        ]);

        return redirect()->route('penerimaan_ikan.index')->with('success', 'Penerimaan Ikan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $penerimaanIkan = Penerimaan_Ikan::findOrFail($id);
        $penerimaanIkan->delete();

        return redirect()->route('penerimaan_ikan.index')->with('success', 'Penerimaan Ikan berhasil dihapus.');
    }
}
