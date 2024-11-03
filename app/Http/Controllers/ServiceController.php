<?php

namespace App\Http\Controllers;

use App\Models\Kategori_produk;
use App\Models\KodeTrace;
use App\Models\NoBatch;
use App\Models\Service;
use App\Models\Cutting;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Service::all();
        $no_batches = NoBatch::all();
        $cutting = Cutting::all();
        $kode_trace = KodeTrace::all();
        $Kategori_produk = Kategori_produk::all();

        return view('admin.transaksi.service', [
            'data' => $data,
            'no_batches' => $no_batches,
            'kode_trace' => $kode_trace,
            'cutting' => $cutting,
            'Kategori_produk' => $Kategori_produk,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
// app/Http/Controllers/ServiceController.php
public function servicePdf(Request $request)
{
    $filterMonth = $request->input('filterMonth');

    // Filter services by the specified month
    $services = Service::whereMonth('tgl_service', Carbon::parse($filterMonth)->month)
        ->whereYear('tgl_service', Carbon::parse($filterMonth)->year)
        ->with(['ikan', 'cutting'])
        ->get();

    $pdf = Pdf::loadView('pdf.service', [
        'services' => $services,
        'filterMonth' => $filterMonth,
    ]);

    return $pdf->download('service_report_' . $filterMonth . '.pdf');
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
        // Validasi input
        $validated = $request->validate([
            'kode_trace_id' => 'required',
            'no_batch_id' => 'required',
            'id_ikan' => 'required',
            'pcs' => 'required|integer|min:1',
            'tgl_service' => 'required|date',
        ]);
    
        // Hitung otomatis kg berdasarkan jumlah pcs
        $kg = $validated['pcs'] * 0.225; // 1 pcs = 225 gram atau 0.225 kg
    
        // Simpan data service
        Service::create([
            'kode_trace_id' => $validated['kode_trace_id'],
            'no_batch_id' => $validated['no_batch_id'],
            'id_ikan' => $validated['id_ikan'],
            'pcs' => $validated['pcs'],
            'kg' => $kg, // Berat otomatis terisi
            'tgl_service' => $validated['tgl_service'],
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
            'kode_trace_id' => $request->kode_trace, // Menambahkan kode_lot
            'no_batch_id' => $request->no_batch_id,
            'id_ikan' => $request->id_ikan,
            'kg' => $request->kg,
            'pcs' => $request->pcs,
            'tgl_service' => $request->tgl_service,
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
