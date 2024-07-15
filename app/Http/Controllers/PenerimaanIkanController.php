<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penerimaan_Ikan;
use App\Models\Supplier;
use App\Models\Ikan;

class PenerimaanIkanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Penerimaan_Ikan::all();
        $suppliers = Supplier::all();
        $ikans = Ikan::all();
        return view('admin.penerimaan_ikan', ['data' => $data, 'suppliers' => $suppliers, 'ikans' => $ikans]);
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
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'ikan_id' => 'required|exists:ikans,id',
            'tgl_penerimaan' => 'required|date',
        ]);

        Penerimaan_Ikan::create([
            'supplier_id' => $request->supplier_id,
            'ikan_id' => $request->ikan_id,
            'tgl_penerimaan' => $request->tgl_penerimaan,
        ]);

        return redirect()->route('penerimaan_ikan.index')->with('success', 'Penerimaan Ikan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'ikan_id' => 'required|exists:ikans,id',
            'tgl_penerimaan' => 'required|date',
        ]);

        $penerimaanIkan = Penerimaan_Ikan::findOrFail($id);
        $penerimaanIkan->update([
            'supplier_id' => $request->supplier_id,
            'ikan_id' => $request->ikan_id,
            'tgl_penerimaan' => $request->tgl_penerimaan,
        ]);

        return redirect()->route('penerimaan_ikan.index')->with('success', 'Penerimaan Ikan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $penerimaanIkan = Penerimaan_Ikan::findOrFail($id);
        $penerimaanIkan->delete();

        return redirect()->route('penerimaan_ikan.index')->with('success', 'Penerimaan Ikan berhasil dihapus.');
    }
}
