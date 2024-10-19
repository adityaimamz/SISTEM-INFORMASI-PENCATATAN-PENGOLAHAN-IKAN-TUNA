<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produk_keluar;
use App\Models\produk_masuk;
use App\Models\Packing;
use App\Models\Service;
use App\Models\No_container;
use App\Models\StokCS;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ProdukKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produkKeluar = produk_keluar::all();
        $packing = Packing::all();
        $services = Service::all();
        $noContainers = No_container::all();
        return view('admin.transaksi.stok_keluar', [
            'produkKeluar' => $produkKeluar,
            'services' => $services,
            'packing' => $packing,
            'noContainers' => $noContainers,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function stokKeluarPdf()
    {
        $produkKeluar = produk_keluar::all();

        $pdf = Pdf::loadView('pdf.stok_keluar', compact('produkKeluar'));
        return $pdf->download('stok_keluar_report_'.'.pdf');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        produk_keluar::create([
            'kode_trace_id' => $request->kode_trace_id,
            'pcs' => $request->pcs,
            'no_container_id' => $request->no_container_id,
            'tgl_keluar' => $request->tgl_keluar,
            'tgl_berangkat' => $request->tgl_berangkat,
            'tgl_tiba' => $request->tgl_tiba,
        ]);

        StokCS::create([
            'kode_trace_id' => $request->kode_trace_id,
            'pcs' => $request->pcs,
            'tipe_stok' => 'Stok Keluar',
        ]);

    
        return redirect()->route('produk-keluar.index')->with('success', 'Produk Keluar berhasil ditambahkan.');
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
        $produkKeluar = produk_keluar::findOrFail($id);
        $data = [
            'kode_trace_id' => $request->kode_trace_id,
            'pcs' => $request->pcs,
            'no_container_id' => $request->no_container_id,
            'tgl_keluar' => $request->tgl_keluar,
            'tgl_berangkat' => $request->tgl_berangkat,
            'tgl_tiba' => $request->tgl_tiba,
        ];

        $produkKeluar->update($data);

        return redirect()->route('produk-keluar.index')->with('success', 'Produk Keluar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produkKeluar = produk_keluar::findOrFail($id);
        $produkKeluar->delete();

        return redirect()->route('produk-keluar.index')->with('success', 'Produk Keluar berhasil dihapus.');
    }
}
