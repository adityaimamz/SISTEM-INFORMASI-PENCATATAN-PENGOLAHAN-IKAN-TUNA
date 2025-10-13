<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriProduk;

class KategoriProdukController extends Controller
{
    public function index()
    {
        $kategoriProduks = KategoriProduk::all();
        return view('admin.data-master.kategori_produk', compact('kategoriProduks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255|unique:kategori_produks,nama_produk',
        ]);

        try {
            KategoriProduk::create([
                'nama_produk' => $request->nama_produk,
            ]);
            return redirect()->route('kategori-produk.index')->with('success', 'Kategori Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('kategori-produk.index')->with('error', 'Kategori Produk sudah ada.');
        }
    }

    public function edit($id)
    {
        try {
            $kategoriProduk = KategoriProduk::findOrFail($id);
            return view('admin.data-master.kategori_produk_edit', compact('kategoriProduk'));
        } catch (\Exception $e) {
            return redirect()->route('kategori-produk.index')->with('error', 'Kategori Produk tidak ditemukan.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255|unique:kategori_produks,nama_produk',
        ]);

        try {
            $kategoriProduk = KategoriProduk::findOrFail($id);
            $kategoriProduk->update([
                'nama_produk' => $request->nama_produk,
            ]);
            return redirect()->route('kategori-produk.index')->with('success', 'Kategori Produk berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('kategori-produk.index')->with('error', 'Kategori Produk sudah ada.');
        }
    }

    public function destroy($id)
    {
        try {
            $kategoriProduk = KategoriProduk::findOrFail($id);
            $kategoriProduk->delete();
            return redirect()->route('kategori-produk.index')->with('success', 'Kategori Produk berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('kategori-produk.index')->with('error', 'Kategori Produk tidak ditemukan.');
        }
    }
}