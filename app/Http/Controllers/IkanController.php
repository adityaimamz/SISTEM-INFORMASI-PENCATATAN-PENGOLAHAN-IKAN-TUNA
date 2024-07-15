<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ikan;
use App\Models\Kategori;

class IkanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ikan = Ikan::all();
        $kategori = Kategori::all();
        return view('admin.ikan', ['ikan' => $ikan, 'kategori' => $kategori]);
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
        // $request->validate([
        //     'jenis_ikan' => 'required|string|max:255',
        //     'berat_ikan' => 'required|string|max:255',
        //     'kategoris_id' => 'required|integer',
        // ]);

        Ikan::create([
            'jenis_ikan' => $request->jenis_ikan,
            'berat_ikan' => $request->berat_ikan,
            'kategoris_id' => $request->kategoris_id,
        ]);

        return redirect()->route('ikan.index')->with('success', 'Ikan berhasil ditambahkan.');
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
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'jenis_ikan' => 'required|string|max:255',
        //     'berat_ikan' => 'required|string|max:255',
        //     'kategoris_id' => 'required|integer',
        // ]);

        $ikan = Ikan::findOrFail($id);
        $data = [
            'jenis_ikan' => $request->jenis_ikan,
            'berat_ikan' => $request->berat_ikan,
            'kategoris_id' => $request->kategoris_id,
        ];

        $ikan->update($data);

        return redirect()->route('ikan.index')->with('success', 'Ikan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ikan = Ikan::findOrFail($id);
        $ikan->delete();

        return redirect()->route('ikan.index')->with('success', 'Ikan berhasil dihapus.');
    }
}
