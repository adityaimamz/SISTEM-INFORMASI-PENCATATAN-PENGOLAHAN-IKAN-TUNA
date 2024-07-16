<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Packing;
use App\Models\Service;
use App\Models\ProdukMasuk;

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
        $request->validate([
            'kode_lot' => 'required|exists:services,id',
            'tgl_packing' => 'required|date',
        ]);

        Packing::create([
            'kode_lot' => $request->kode_lot,
            'tgl_packing' => $request->tgl_packing,
        ]);

        return redirect()->route('packing.index')->with('success', 'Packing berhasil ditambahkan.');
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
        $request->validate([
            'kode_lot' => 'required|exists:services,id',
            'tgl_packing' => 'required|date',
        ]);

        $packing = Packing::findOrFail($id);
        $packing->update([
            'kode_lot' => $request->kode_lot,
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
