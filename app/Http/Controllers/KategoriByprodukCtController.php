<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriByprodukCt;

class KategoriByprodukCtController extends Controller
{
    public function index()
    {
        $kategoriByprodukCts = KategoriByprodukCt::all();
        return view('admin.data-master.kategori_byproduk_ct', compact('kategoriByprodukCts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255|unique:kategori_byproduk_cts,nama_produk',
        ]);

        try {
            KategoriByprodukCt::create([
                'nama_produk' => $request->nama_produk,
            ]);
            return redirect()->route('kategori-byproduk-ct.index')->with('success', 'Kategori By Produk Cutting berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('kategori-byproduk-ct.index')->with('error', 'Kategori By Produk Cutting sudah ada.');
        }
    }

    public function edit($id)
    {
        try {
            $kategoriByprodukCts = KategoriByprodukCt::findOrFail($id);
            return view('admin.data-master.kategori_byproduk_ct_edit', compact('kategoriByprodukCts'));
        } catch (\Exception $e) {
            return redirect()->route('kategori-byproduk-ct.index')->with('error', 'Kategori By Produk Cutting tidak ditemukan.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required',
        ]);

        try {
            $kategoriByprodukCts = KategoriByprodukCt::findOrFail($kategori_byprodukid);
            $kategoriByprodukCts->update([
                'nama_produk' => $request->nama_produk,
            ]);

            return redirect()->route('kategori-byproduk-ct.index')->with('success', 'Kategori By Produk Cutting berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('kategori-byproduk-ct.index')->with('error', 'Kategori By Produk Cutting sudah ada.');
        }
    }

    public function destroy($id)
    {
        try {
            $kategoriByprodukCts = KategoriByprodukCt::findOrFail($id);
            $kategoriByprodukCts->delete();
            return redirect()->route('kategori-byproduk-ct.index')->with('success', 'Kategori By Produk Cutting berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('kategori-byproduk-ct.index')->with('error', 'Kategori By Produk Cutting tidak ditemukan.');
        }
    }
}
