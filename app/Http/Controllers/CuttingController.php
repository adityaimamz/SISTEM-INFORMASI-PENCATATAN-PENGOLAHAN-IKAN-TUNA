<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cutting; // Mengubah model yang digunakan menjadi Cutting
use App\Models\DetailProduk;
use App\Models\Penerimaan_ikan;

class CuttingController extends Controller // Mengubah nama controller menjadi CuttingController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cutting = Cutting::all(); // Mengubah variabel menjadi $cutting
        $detailproduk = DetailProduk::all();
        $penerimaan_ikan = Penerimaan_ikan::all();
        return view('admin.cutting', ['cutting' => $cutting, 'detailproduk' => $detailproduk, 'penerimaan_ikan' => $penerimaan_ikan]); // Mengubah view yang dipanggil menjadi 'admin.cutting'
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

        Cutting::create([ // Mengubah model yang digunakan menjadi Cutting
            'id_produk' => $request->id_produk,
            'berat_produk' => $request->berat_produk,
            'nama_produk' => $request->nama_produk,
        ]);

        return redirect()->route('cutting.index')->with('success', 'Cutting berhasil ditambahkan.'); // Mengubah route redirect menjadi 'cutting.index'
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

        $cutting = Cutting::findOrFail($id); // Mengubah model yang digunakan menjadi Cutting
        $data = [
            'id_produk' => $request->id_produk,
            'berat_produk' => $request->berat_produk,
            'nama_produk' => $request->nama_produk,
        ];

        $cutting->update($data);

        return redirect()->route('cutting.index')->with('success', 'Cutting berhasil diperbarui.'); // Mengubah route redirect menjadi 'cutting.index'
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cutting = Cutting::findOrFail($id); // Mengubah model yang digunakan menjadi Cutting
        $cutting->delete();

        return redirect()->route('cutting.index')->with('success', 'Cutting berhasil dihapus.'); // Mengubah route redirect menjadi 'cutting.index'
    }
}

