<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBeratPenerimaan;

class KategoriBeratPenerimaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori_berat_penerimaan = KategoriBeratPenerimaan::all();
        return view('admin.data-master.kategori_berat_penerimaan', compact('kategori_berat_penerimaan'));
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
        KategoriBeratPenerimaan::create([
            'kategori_berat' => $request->kategori_berat,
        ]);
        return redirect()->route('kategori_berat_penerimaan.index')->with('success', 'Kategori Berat Penerimaan created successfully');
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
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        KategoriBeratPenerimaan::find($id)->update([
            'kategori_berat' => $request->kategori_berat,
        ]);
        return redirect()->route('kategori_berat_penerimaan.index')->with('success', 'Kategori Berat Penerimaan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        KategoriBeratPenerimaan::find($id)->delete();
        return redirect()->route('kategori_berat_penerimaan.index')->with('success', 'Kategori Berat Penerimaan deleted successfully');
    }
}
