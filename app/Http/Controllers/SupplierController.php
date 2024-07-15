<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Supplier::all();
        return view('admin.supplier', ['data' => $data]);
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
        //     'nama_supplier' => 'required|string|max:255',
        //     'nama_kapal' => 'required|string|max:255',
        //     'alamat' => 'required|string|max:255',
        // ]);

        Supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'nama_kapal' => $request->nama_kapal,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
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
        //     'nama_supplier' => 'required|string|max:255',
        //     'nama_kapal' => 'required|string|max:255',
        //     'alamat' => 'required|string|max:255',
        // ]);

        $supplier = Supplier::findOrFail($id);
        $data = [
            'nama_supplier' => $request->nama_supplier,
            'nama_kapal' => $request->nama_kapal,
            'alamat' => $request->alamat,
        ];

        $supplier->update($data);

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus.');
    }
}
