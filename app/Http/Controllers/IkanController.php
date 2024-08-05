<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori_produk;
use App\Models\Kategori;

class IkanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ikan = Kategori_produk::all();
        return view('admin.data-master.ikan', ['ikan' => $ikan]);
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

        Kategori_produk::create([
            'jenis_ikan' => $request->jenis_ikan,
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

        $ikan = Kategori_produk::findOrFail($id);
        $data = [
            'jenis_ikan' => $request->jenis_ikan,
        ];

        $ikan->update($data);

        return redirect()->route('ikan.index')->with('success', 'Ikan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ikan = Kategori_produk::findOrFail($id);
        $ikan->delete();

        return redirect()->route('ikan.index')->with('success', 'Ikan berhasil dihapus.');
    }
}
