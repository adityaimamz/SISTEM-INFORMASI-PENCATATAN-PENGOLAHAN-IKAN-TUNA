<?php

namespace App\Http\Controllers;

use App\Models\Cutting;
use App\Models\DetailProduk;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Service::with(['cutting', 'detail'])->get();
        $cuttings = Cutting::all();
        $detailproduk = DetailProduk::all();

        $totalBeratPerGrade = Service::selectRaw('kategori_ikans.grade, SUM(services.berat_produk) as total_berat')
        ->join('cuttings', 'services.no_batch', '=', 'cuttings.no_batch')
        ->join('penerimaan_ikans', 'cuttings.id_produk', '=', 'penerimaan_ikans.id')
        ->join('kategori_ikans', 'penerimaan_ikans.ikan_id', '=', 'kategori_ikans.id')
        ->groupBy('kategori_ikans.grade')
        ->get();
    

        return view('admin.service', [
            'data' => $data,
            'cuttings' => $cuttings,
            'detailproduk' => $detailproduk,
            'totalBeratPerGrade' => $totalBeratPerGrade,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function servicePdf($month, $year)
    {
        $data = Service::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

            $totalBeratPerGrade = Service::selectRaw('kategori_ikans.grade, SUM(services.berat_produk) as total_berat')
            ->join('cuttings', 'services.no_batch', '=', 'cuttings.no_batch')
            ->join('penerimaan_ikans', 'cuttings.id_produk', '=', 'penerimaan_ikans.id')
            ->join('kategori_ikans', 'penerimaan_ikans.ikan_id', '=', 'kategori_ikans.id')
            ->whereYear('services.created_at', $year)
            ->whereMonth('services.created_at', $month)
            ->groupBy('kategori_ikans.grade')
            ->get();
        

        $pdf = Pdf::loadView('pdf.service', compact('data', 'month', 'year', 'totalBeratPerGrade'));
        return $pdf->download('service_report_' . $month . '_' . $year . '.pdf');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Service::create([
            'kode_trace' => $request->kode_trace, // Menambahkan kode_lot
            'no_batch' => $request->no_batch,
            'id_detail' => $request->id_detail,
            'berat_produk' => $request->berat_produk,
        ]);

        return redirect()->route('service.index')->with('success', 'Service berhasil ditambahkan.');
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
/**
 * Update the specified resource in storage.
 */
    public function update(Request $request, $kode_trace)
    {

        $service = Service::findOrFail($kode_trace);
        $service->update([
            'kode_trace' => $request->kode_trace,
            'no_batch' => $request->no_batch,
            'id_detail' => $request->id_detail,
            'berat_produk' => $request->berat_produk,
        ]);

        return redirect()->route('service.index')->with('success', 'Service berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kode_trace)
    {
        $service = Service::findOrFail($kode_trace);
        $service->delete();

        return redirect()->route('service.index')->with('success', 'Service berhasil dihapus.');
    }
}
