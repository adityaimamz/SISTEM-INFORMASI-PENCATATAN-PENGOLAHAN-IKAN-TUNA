<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
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
        //     'kategori' => 'required|string|max:255',
        //     'grade' => 'required|string|max:255',
        // ]);

        Kategori::create([
            'kategori' => $request->kategori,
            'grade' => $request->grade,
        ]);

        return redirect()->route('ikan.index')->with('success', 'Kategori berhasil ditambahkan.');
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
        //     'kategori' => 'required|string|max:255',
        //     'grade' => 'required|string|max:255',
        // ]);

        $kategori = Kategori::findOrFail($id);
        $data = [
            'kategori' => $request->kategori,
            'grade' => $request->grade,
        ];

        $kategori->update($data);

        return redirect()->route('ikan.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('ikan.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
