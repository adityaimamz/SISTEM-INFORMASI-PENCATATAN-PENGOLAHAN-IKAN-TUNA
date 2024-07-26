<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori_ikan;
use App\Models\Kategori;

class IkanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ikan = Kategori_ikan::all();
        return view('admin.ikan', ['ikan' => $ikan]);
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
        //     'jenis_ikan' => 'required|string|max:255',
        //     'berat_ikan' => 'required|string|max:255',
        //     'kategoris_id' => 'required|integer',
        // ]);

        Kategori_ikan::create([
            'jenis_ikan' => $request->jenis_ikan,
            'kategori' => $request->kategori,
            'grade' => $request->grade,
        ]);

        return redirect()->route('ikan.index')->with('success', 'Ikan berhasil ditambahkan.');
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
        //     'jenis_ikan' => 'required|string|max:255',
        //     'berat_ikan' => 'required|string|max:255',
        //     'kategoris_id' => 'required|integer',
        // ]);

        $ikan = Ikan::findOrFail($id);
        $data = [
            'jenis_ikan' => $request->jenis_ikan,
            'kategori' => $request->kategori,
            'grade' => $request->grade,
        ];

        $ikan->update($data);

        return redirect()->route('ikan.index')->with('success', 'Ikan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ikan = Ikan::findOrFail($id);
        $ikan->delete();

        return redirect()->route('ikan.index')->with('success', 'Ikan berhasil dihapus.');
    }
}
