<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Cutting;
use App\Models\DetailProduk;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Service::all();
        $cuttings = Cutting::all();
        $detailproduk = DetailProduk::all();
        
        return view('admin.service', ['data' => $data, 'cuttings' => $cuttings, 'detailproduk' => $detailproduk]);
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
    public function update(Request $request, $kode_trace)
    {
        $request->validate([
            'no_batch' => 'required|exists:cuttings,id',
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
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('service.index')->with('success', 'Service berhasil dihapus.');
    }
}
