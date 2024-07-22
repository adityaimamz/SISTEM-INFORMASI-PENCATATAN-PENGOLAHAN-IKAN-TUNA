<?php

namespace App\Http\Controllers;

use App\Models\Cutting;
use App\Models\DetailProduk;
use App\Models\Service;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

        return view('admin.service', ['data' => $data, 'cuttings' => $cuttings, 'detailproduk' => $detailproduk]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function servicePdf($month, $year)
    {
        $data = Service::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        $pdf = Pdf::loadView('pdf.service', compact('data', 'month', 'year'));
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
        $request->validate([
            'no_batch' => 'required|exists:cuttings,no_batch',
            'id_detail' => 'required|exists:detail_produks,id',
        ]);

        $service = Service::findOrFail($kode_trace);
        $service->update([
            'no_batch' => $request->no_batch,
            'id_detail' => $request->id_detail,
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
