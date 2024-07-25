<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produk_keluar;
use App\Models\produk_masuk;
use App\Models\Packing;
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
    
        $totalMasuk = DB::table('produk_masuks')
            ->sum('stok_masuk');

        $totalKeluar = DB::table('produk_keluars')
            ->sum('jumlah_produk');

        $totalStok = $totalMasuk - $totalKeluar;

        return view('admin.stok_keluar', [
            'produkKeluar' => $produkKeluar,
            'packing' => $packing,
            'totalStok' => $totalStok
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function stokKeluarPdf($month, $year)
    {
        $data = produk_keluar::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        $totalKeluar = produk_keluar::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum('jumlah_produk');

        $totalMasuk = DB::table('produk_masuks')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum('stok_masuk');

        $totalStok = $totalMasuk - $totalKeluar;

        $pdf = Pdf::loadView('pdf.stok_keluar', compact('data', 'month', 'year', 'totalStok'));
        return $pdf->download('stok_keluar_report_'.$month.'_'.$year.'.pdf');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        produk_keluar::create([
            'no_box' => $request->no_box,
            'jumlah_produk' => $request->jumlah_produk,
            'no_seal' => $request->no_seal,
            'no_container' => $request->no_container,
            'tgl_keluar' => $request->tgl_keluar,
            'tgl_berangkat' => $request->tgl_berangkat,
            'tgl_tiba' => $request->tgl_tiba,
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
            'jumlah_produk' => $request->jumlah_produk,
            'no_seal' => $request->no_seal,
            'no_container' => $request->no_container,
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
