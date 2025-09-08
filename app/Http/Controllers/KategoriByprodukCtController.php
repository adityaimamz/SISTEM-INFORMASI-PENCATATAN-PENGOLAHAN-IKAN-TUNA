<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriByprodukCt;

class KategoriByprodukCtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = KategoriByprodukCt::all();
        return view('admin.data-master.kategori_byproduk_ct', compact('kategori'));
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
        KategoriByprodukCt::create([
            'nama_produk' => $request->nama_produk,
        ]);

        return redirect()->route('kategori-byproduk-ct.index')->with('success', 'Kategori By Produk Cutting berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($kategori_byproduk_ct)
    {
        $kategori = KategoriByprodukCt::findOrFail($kategori_byproduk_ct);
        return view('admin.data-master.kategori_byproduk_ct_show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kategori_byproduk_ct)
    {
        $kategori = KategoriByprodukCt::findOrFail($kategori_byproduk_ct);
        return view('admin.data-master.kategori_byproduk_ct_edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kategori_byproduk_ct)
    {
        $kategori = KategoriByprodukCt::findOrFail($kategori_byproduk_ct);
        $data = [
            'nama_produk' => $request->nama_produk,
        ];

        $kategori->update($request->all());

        return redirect()->route('kategori-byproduk-ct.index')->with('success', 'Kategori By Produk Cutting berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kategori_byproduk_ct)
    {
        $kategori = KategoriByprodukCt::findOrFail($kategori_byproduk_ct);
        $kategori->delete();

        return redirect()->route('kategori-byproduk-ct.index')->with('success', 'Kategori By Produk Cutting berhasil dihapus.');
    }
}
