<?php

namespace App\Http\Controllers;

use App\Models\Kategori_produk;
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
        $ikan = Kategori_produk::find($id);

        return $ikan ? json_encode($ikan) : 'ikan tidak ditemukan';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function ikanPdf(Request $request)
    {
        $date = $request->get('date');
        $supplier = $request->get('supplier');
    
        $query = Penerimaan_Ikan::query();
    
        if ($date) {
            $query->whereDate('tgl_penerimaan', $date);
        }
    
        if ($supplier) {
            $query->where('supplier_id', $supplier);
        }
    
        $data = $query->get();
    
        $pdf = Pdf::loadView('pdf.ikan', compact('data'));
        return $pdf->download('ikan_report_' . $date . '.pdf');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,supplier_id',
            'grade_id' => 'required|exists:grades,id',
            'berat_ikan' => 'required|numeric|min:0',
            'tgl_penerimaan' => 'required|date',
        ]);
    
        // Pemetaan kategori berat berdasarkan berat ikan
        $kategoriBeratId = $this->getKategoriBeratId($validated['berat_ikan']);
    
        // Simpan data penerimaan ikan
        Penerimaan_Ikan::create([
            'supplier_id' => $validated['supplier_id'],
            'grade_id' => $validated['grade_id'],
            'kategori_berat_id' => $kategoriBeratId,
            'berat_ikan' => $validated['berat_ikan'],
            'tgl_penerimaan' => $validated['tgl_penerimaan'],
        ]);
    
        return redirect()->route('penerimaan_ikan.index')->with('success', 'Penerimaan Ikan berhasil ditambahkan.');
    }
    
    /**
     * Mendapatkan ID kategori berat berdasarkan berat ikan.
     */
    private function getKategoriBeratId($berat)
    {
        if ($berat >= 10 && $berat <= 19) {
            return KategoriBeratPenerimaan::where('kategori_berat', '10-19')->first()->id;
        } elseif ($berat >= 20 && $berat <= 29) {
            return KategoriBeratPenerimaan::where('kategori_berat', '20-29')->first()->id;
        } elseif ($berat >= 30) {
            return KategoriBeratPenerimaan::where('kategori_berat', '30 UP')->first()->id;
        } 
    
        // Default handling jika tidak ada kategori cocok
        return null;
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
