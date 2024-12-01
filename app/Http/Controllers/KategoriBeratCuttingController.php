<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBeratCutting;

class KategoriBeratCuttingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori_berat_cutting = KategoriBeratCutting::all();
        return view('admin.data-master.kategori_berat_cutting', compact('kategori_berat_cutting'));
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
        KategoriBeratCutting::create([
            'kategori_berat' => $request->kategori_berat,
        ]);
        return redirect()->route('kategori_berat_cutting.index')->with('success', 'Kategori berat cutting berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategoriBeratCutting = KategoriBeratCutting::find($id);
        $kategoriBeratCutting->update([
            'kategori_berat' => $request->kategori_berat,
        ]);
        return redirect()->route('kategori_berat_cutting.index')->with('success', 'Kategori berat cutting berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategoriBeratCutting = KategoriBeratCutting::find($id);
        $kategoriBeratCutting->delete();
        return redirect()->route('kategori_berat_cutting.index')->with('success', 'Kategori berat cutting berhasil dihapus');
    }
}
