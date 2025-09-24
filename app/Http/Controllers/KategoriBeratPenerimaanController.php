<?php

namespace App\Http\Controllers;

use App\Models\KategoriBeratPenerimaan;
use Illuminate\Http\Request;

class KategoriBeratPenerimaanController extends Controller
{
    public function index()
    {
        $kategori_berat_penerimaan = KategoriBeratPenerimaan::all();
        return view('admin.data-master.kategori_berat_penerimaan', compact('kategori_berat_penerimaan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_berat' => 'required|string|max:255|unique:kategori_berat_penerimaan'
        ]);

        KategoriBeratPenerimaan::create($request->all());
        return redirect()->route('kategori_berat_penerimaan.index')
            ->with('success', 'Kategori Berat Penerimaan created successfully.');
    }

    public function update(Request $request, $kategori_berat_id)
    {
        $request->validate([
            'kategori_berat' => 'required|string|max:255|unique:kategori_berat_penerimaan,kategori_berat,'.$kategori_berat_id
        ]);

        $kategori = KategoriBeratPenerimaan::findOrFail($kategori_berat_id);
        $kategori->update($request->all());

        return redirect()->route('kategori_berat_penerimaan.index')
            ->with('success', 'Kategori Berat Penerimaan updated successfully');
    }

    public function destroy($id)
    {
        try {
            $kategori = KategoriBeratPenerimaan::findOrFail($kategori_berat_id);
            $kategori->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}