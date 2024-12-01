<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\No_container;

class NoContainersController extends Controller
{
    public function index()
    {
        $noContainers = No_container::all();
        return view('admin.transaksi.stok_keluar', compact('noContainers'));
    }

    public function store(Request $request)
    {
        No_container::create([
            'no_container' => $request->no_container,
        ]);
        return redirect()->route('produk-keluar.index')->with('success', 'No Container berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $noContainer = No_container::findOrFail($id);
        $noContainer->update([
            'no_container' => $request->no_container,
        ]);
        return redirect()->route('produk-keluar.index')->with('success', 'No Container berhasil diperbarui');
    }   
    public function destroy($id)
    {
        $noContainer = No_container::findOrFail($id);
        $noContainer->delete();
        return redirect()->route('produk-keluar.index')->with('success', 'No Container berhasil dihapus');
    }   
}

