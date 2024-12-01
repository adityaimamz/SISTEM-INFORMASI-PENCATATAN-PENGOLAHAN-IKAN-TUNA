<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NoBatch;

class NoBatchController extends Controller
{
    public function index()
    {
        $noBatch = NoBatch::all();
        return view('admin.transaksi.cutting', compact('noBatch'));
    }

    public function store(Request $request)
    {
        NoBatch::create([
            'no_batch' => $request->no_batch,
        ]);
        return redirect()->route('cutting.index')->with('success', 'Kategori berat cutting berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $noBatch = NoBatch::findOrFail($id);
        $noBatch->update([
            'no_batch' => $request->no_batch,
        ]);
        return redirect()->route('cutting.index')->with('success', 'Kategori berat cutting berhasil diperbarui');
    }

    public function destroy($id)
    {
        $noBatch = NoBatch::findOrFail($id);
        $noBatch->delete();
        return redirect()->route('cutting.index')->with('success', 'Kategori berat cutting berhasil dihapus');
    }

}
