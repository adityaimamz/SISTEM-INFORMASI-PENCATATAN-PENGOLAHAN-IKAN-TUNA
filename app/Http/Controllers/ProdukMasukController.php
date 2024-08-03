<?php

namespace App\Http\Controllers;

use App\Models\Packing;
use App\Models\StokCS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stokCS = StokCS::all();
        $packing = Packing::all();

        // Calculate grand total
        $grandtotal = DB::table('stok_c_s')
            ->select(DB::raw('SUM(CASE WHEN tipe_stok = "Stok Masuk" THEN pcs ELSE 0 END) - SUM(CASE WHEN tipe_stok = "Stok Keluar" THEN pcs ELSE 0 END) AS grandtotal'))
            ->first()
            ->grandtotal;

        return view('admin.transaksi.stok_masuk', [
            'stokCS' => $stokCS,
            'packing' => $packing,
            'grandtotal' => $grandtotal,
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

        return redirect()->route('stok-cs.index')->with('success', 'Produk Masuk berhasil ditambahkan.');
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

        return redirect()->route('stok-cs.index')->with('success', 'Produk Masuk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produkMasuk = produk_masuk::findOrFail($id);
        $produkMasuk->delete();

        return redirect()->route('stok-cs.index')->with('success', 'Produk Masuk berhasil dihapus.');
    }
}
