<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Packing;
use App\Models\Service;
use App\Models\StokCS;
use App\Models\ProdukMasuk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class PackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all packing data
        $data = Packing::all();
        $services = Service::all();

        // Calculate totals for each product
        $productTotals = Packing::select('services.id as service_id', 'services.id_ikan', 'Kategori_produks.jenis_ikan', 
            DB::raw('SUM(packings.pcs) as total_pcs'),
            DB::raw('SUM(packings.berat) as total_kg')
        )
        ->join('services', 'services.id', '=', 'packings.kode_trace_id')
        ->join('Kategori_produks', 'Kategori_produks.id', '=', 'services.id_ikan')
        ->groupBy('services.id', 'services.id_ikan', 'Kategori_produks.jenis_ikan')
        ->get();

        // Calculate grand totals
        $grandTotals = Packing::select(
            DB::raw('SUM(pcs) as total_pcs'),
            DB::raw('SUM(berat) as total_kg')
        )->first();

        // Prepare data for the view
        $namaproduk = $productTotals->mapWithKeys(function ($item) {
            return [$item->jenis_ikan => ['pcs' => $item->total_pcs, 'kg' => $item->total_kg]];
        })->toArray();

        return view('admin.transaksi.packing', [
            'data' => $data,
            'services' => $services,
            'productTotals' => $productTotals,
            'totalpcs' => $grandTotals->total_pcs,
            'totalkg' => $grandTotals->total_kg,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Packing::create([
            'no_box' => $request->no_box, 
            'kode_trace_id' => $request->kode_trace_id,
            'buyer' => $request->buyer,
            'pcs' => $request->pcs,
            'berat' => $request->berat,
            'tgl_packing' => $request->tgl_packing,
        ]);

        StokCS::create([
            'kode_trace_id' => $request->kode_trace_id,
            'pcs' => $request->pcs,
            'tipe_stok' => 'Stok Masuk',
        ]);
    
        return redirect()->route('packing.index')->with('success', 'Packing berhasil ditambahkan.');
    }

    public function packingPdf($date)
    {
        $parsedDate = Carbon::parse($date);
        $packings = Packing::whereDate('tgl_packing', $parsedDate)->get();

        $pdf = Pdf::loadView('pdf.packing', compact('packings', 'date'));
        return $pdf->download('packing_report_' . $parsedDate->format('Y-m-d') . '.pdf');
    }
    

    /**
     * Display the specified resource.
     */
    public function show($no_box)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($no_box)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $packing = Packing::findOrFail($id);
        $packing->update([
            'no_box' => $request->no_box, 
            'kode_trace_id' => $request->kode_trace_id,
            'buyer' => $request->buyer,
            'pcs' => $request->pcs,
            'berat' => $request->berat,
            'tgl_packing' => $request->tgl_packing,
        ]);

        return redirect()->route('packing.index')->with('success', 'Packing berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $packing = Packing::findOrFail($id);
        $packing->delete();

        return redirect()->route('packing.index')->with('success', 'Packing berhasil dihapus.');
    }
}
