<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Packing;
use App\Models\Service;
use App\Models\ProdukMasuk;
use Barryvdh\DomPDF\Facade\Pdf;


class PackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Packing::all();
        $services = Service::all();
        return view('admin.packing', ['data' => $data,  'services' => $services]);
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
            'berat' => $request->berat,
        ]);
    
        return redirect()->route('packing.index')->with('success', 'Packing berhasil ditambahkan.');
    }

    public function packingPdf($month, $year)
    {
        $data = Packing::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        $pdf = Pdf::loadView('pdf.packing', compact('data', 'month', 'year'));
        return $pdf->download('packing_report_' . $month . '_' . $year . '.pdf');
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
    public function update(Request $request, $no_box)
    {
        $packing = Packing::findOrFail($no_box);
        $packing->update([
            'no_box' => $request->no_box, 
            'kode_trace_id' => $request->kode_trace_id,
            'buyer' => $request->buyer,
            'berat' => $request->berat,
        ]);

        return redirect()->route('packing.index')->with('success', 'Packing berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($no_box)
    {
        $packing = Packing::findOrFail($no_box);
        $packing->delete();

        return redirect()->route('packing.index')->with('success', 'Packing berhasil dihapus.');
    }
}
