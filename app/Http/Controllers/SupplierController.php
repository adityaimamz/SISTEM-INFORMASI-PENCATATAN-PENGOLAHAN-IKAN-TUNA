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
        $suppliers = Supplier::all();
        return view('admin.data-master.suppliers', ['suppliers' => $suppliers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.data-master.suppliers-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'require|unique:suppliers,supplier_id',
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        Supplier::create($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        $suppliers = Supplier::findOrFail($supplier);
        return view('admin.data-master.suppliers-show', ['supplier' => $suppliers]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $suppliers = Supplier::findOrFail($supplier);
        return view('admin.data-master.suppliers-edit', ['supplier' => $suppliers]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'supplier_id' => 'required|string|max:255',
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        $suppliers = Supplier::findOrFail($supplier);
        $data = [
            'supplier_id' => $request->supplier_id,
            'nama_supplier' => $request->nama_supplier,
            'alamat' => $request->alamat,

        ];

        $suppliers->update($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $suppliers = Supplier::findOrFail($supplier);
        $suppliers->delete();

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }
}
