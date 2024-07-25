<?php

namespace App\Http\Controllers;

use App\Models\Packing;
use App\Models\produk_masuk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produkMasuk = produk_masuk::all();
        $packing = Packing::all();

        $totalMasuk = DB::table('produk_masuks')
            ->sum('stok_masuk');

        $totalKeluar = DB::table('produk_keluars')
            ->sum('jumlah_produk');

        $totalStok = $totalMasuk - $totalKeluar;

        return view('admin.stok_masuk', [
            'produkMasuk' => $produkMasuk,
            'packing' => $packing,
            'totalStok' => $totalStok,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function stokMasukPdf($month, $year)
    {
        $data = produk_masuk::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();

        $totalMasuk = produk_masuk::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum('stok_masuk');

        $totalKeluar = DB::table('produk_keluars')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum('jumlah_produk');

        $totalStok = $totalMasuk - $totalKeluar;

        $pdf = Pdf::loadView('pdf.stok_masuk', compact('data', 'month', 'year', 'totalStok'));
        return $pdf->download('stok_masuk_report_' . $month . '_' . $year . '.pdf');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        produk_masuk::create([
            'no_box' => $request->no_box,
            'stok_masuk' => $request->stok_masuk,
        ]);

        return redirect()->route('produk-masuk.index')->with('success', 'Produk Masuk berhasil ditambahkan.');
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
        $produkMasuk = produk_masuk::findOrFail($id);
        $data = [
            'stok_masuk' => $request->stok_masuk,
        ];

        $produkMasuk->update($data);

        return redirect()->route('produk-masuk.index')->with('success', 'Produk Masuk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produkMasuk = produk_masuk::findOrFail($id);
        $produkMasuk->delete();

        return redirect()->route('produk-masuk.index')->with('success', 'Produk Masuk berhasil dihapus.');
    }
}
