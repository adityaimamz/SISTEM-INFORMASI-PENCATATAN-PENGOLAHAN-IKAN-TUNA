<?php

namespace App\Http\Controllers;

use App\Models\Kategori_ikan;
use App\Models\KodeTrace;
use App\Models\NoBatch;
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
        $data = Service::all();
        $no_batches = NoBatch::all();
        $kode_trace = KodeTrace::all();
        $kategori_ikan = Kategori_ikan::all();

        return view('admin.transaksi.service', [
            'data' => $data,
            'no_batches' => $no_batches,
            'kode_trace' => $kode_trace,
            'kategori_ikan' => $kategori_ikan,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
// app/Http/Controllers/ServiceController.php
    public function servicePdf($kode_trace)
    {
        $services = Service::where('kode_trace_id', $kode_trace)->get();

        $pdf = Pdf::loadView('pdf.service', compact('services', 'kode_trace'));
        return $pdf->download('service_report_' . $kode_trace . '.pdf');
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
            'kode_trace_id' => $request->kode_trace_id, // Menambahkan kode_lot
            'no_batch_id' => $request->no_batch_id,
            'id_ikan' => $request->id_ikan,
            'kg' => $request->kg,
            'pcs' => $request->pcs,
            'tgl_service' => $request->tgl_service,
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
