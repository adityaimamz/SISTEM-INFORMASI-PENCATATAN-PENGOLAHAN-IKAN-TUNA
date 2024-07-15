<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailProduk; // Mengubah model yang digunakan menjadi DetailProduk
use App\Models\Kategori;
use App\Models\Penerimaan_ikan;

class DetailProdukController extends Controller // Mengubah nama controller menjadi DetailProdukController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
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

        DetailProduk::create([ 
            'nama_produk' => $request->nama_produk,
        ]);

        return redirect()->route('cutting.index')->with('success', 'Detail Produk berhasil ditambahkan.'); // Mengubah route redirect menjadi 'detail_produk.index'
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

        $detailProduk = DetailProduk::findOrFail($id); 
        $data = [
            'nama_produk' => $request->nama_produk,
        ];

        $detailProduk->update($data);

        return redirect()->route('cutting.index')->with('success', 'Detail Produk berhasil diperbarui.'); // Mengubah route redirect menjadi 'detail_produk.index'
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $detailProduk = DetailProduk::findOrFail($id); // Mengubah model yang digunakan menjadi DetailProduk
        $detailProduk->delete();

        return redirect()->route('cutting.index')->with('success', 'Detail Produk berhasil dihapus.'); // Mengubah route redirect menjadi 'detail_produk.index'
    }
}

