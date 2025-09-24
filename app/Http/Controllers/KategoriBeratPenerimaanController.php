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
            'kategori_berat' => 'required|string|max:255|unique:kategori_berat_penerimaans,kategori_berat'
        ]);
    
        try {
            KategoriBeratPenerimaan::create([
                'kategori_berat' => $request->kategori_berat
            ]);
    
            return redirect()->route('kategori_berat_penerimaan.index')
                ->with('success', 'Data berhasil disimpan');
                
        } catch (\Exception $e) {
            \Log::error('Error storing kategori berat: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, $kategori_berat_id)
    {
        $request->validate([
            'kategori_berat' => 'required|string|max:255|unique:kategori_berat_penerimaans,kategori_berat,'.$kategori_berat_id.',kategori_berat_id'
        ]);

        $kategori = KategoriBeratPenerimaan::findOrFail($kategori_berat_id);
        $kategori->update($request->all());

        return redirect()->route('kategori_berat_penerimaan.index')
            ->with('success', 'Kategori Berat Penerimaan updated successfully');
    }

    public function destroy($kategori_berat_id)
    {
        \DB::beginTransaction();
        try {
            $kategori = KategoriBeratPenerimaan::find($kategori_berat_id);

            $kategori->delete();
            \DB::commit();
            
            return redirect()->route('kategori_berat_penerimaan.index')
            ->with('success', 'Kategori Berat Penerimaan deleted successfully');
            
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error deleting kategori: ' . $e->getMessage());
            return redirect()->back()
            ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    
    }
    
}