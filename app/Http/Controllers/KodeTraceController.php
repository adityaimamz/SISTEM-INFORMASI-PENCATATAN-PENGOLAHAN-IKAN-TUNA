<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KodeTrace;


class KodeTraceController extends Controller
{


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
        KodeTrace::create([
            'kode_trace' => $request->kode_trace,
        ]);
        return redirect()->route('service.index')->with('success', 'Kode trace berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kodeTrace = KodeTrace::findOrFail($id);
        $kodeTrace->update([
            'kode_trace' => $request->kode_trace,
        ]);
        return redirect()->route('service.index')->with('success', 'Kode trace berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kodeTrace = KodeTrace::findOrFail($id);
        $kodeTrace->delete();
        return redirect()->route('service.index')->with('success', 'Kode trace berhasil dihapus');
    }
}
