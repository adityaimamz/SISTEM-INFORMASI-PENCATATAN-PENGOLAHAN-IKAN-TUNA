<?php

namespace App\Http\Controllers;

use App\Models\CuttingL;
use App\Models\Penerimaan_ikan;
use App\Models\GradeSizing;
use Illuminate\Http\Request;
use DB;
use DataTables;

class CuttingLController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('cutting_ls')
                ->join('penerimaan_ikan', 'cutting_ls.penerimaan_id', '=', 'penerimaan_ikan.penerimaan_id')
                ->join('suppliers', 'penerimaan_ikan.supplier_id', '=', 'suppliers.supplier_id')
                ->join('grade_sizings', 'cutting_ls.grade_size_id', '=', 'grade_sizings.grade_size_id')
                ->select(
                    'cutting_ls.*',
                    'suppliers.nama_supplier',
                    'grade_sizings.nama_grade',
                    'grade_sizings.size'
                )
                ->orderBy('cutting_ls.tggl_cutting', 'desc')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group" role="group">';
                    $btn .= '<a href="'.route('cutting-loin.edit', $row->cuttingl_id).'" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i> Edit</a>';
                    $btn .= '<form action="'.route('cutting-loin.destroy', $row->cuttingl_id).'" method="POST" style="display:inline">';
                    $btn .= csrf_field();
                    $btn .= method_field('DELETE');
                    $btn .= '<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')"><i class="bi bi-trash"></i> Hapus</button>';
                    $btn .= '</form>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->editColumn('tggl_cutting', function($row) {
                    return date('d/m/Y', strtotime($row->tggl_cutting));
                })
                ->editColumn('berat_loin', function($row) {
                    return number_format($row->berat_loin, 2);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.transaksi.cutting-loin.index');
    }

    public function create()
    {
        $penerimaan = Penerimaan_ikan::with('supplier')
            ->whereNotIn('penerimaan_id', function($query) {
                $query->select('penerimaan_id')->from('cutting_ls');
            })
            ->get();

        $gradeSizes = GradeSizing::all();
        
        return view('admin.transaksi.cutting-loin.create', compact('penerimaan', 'gradeSizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tggl_cutting' => 'required|date',
            'tggl_injek_co' => 'required|date|after_or_equal:tggl_cutting',
            'tggl_service' => 'required|date|after_or_equal:tggl_cutting',
            'grade_size_id' => 'required|exists:grade_sizings,grade_size_id',
            'berat_loin' => 'required|numeric|min:0',
            'suhu_loin' => 'required|numeric',
            'penerimaan_id' => 'required|exists:penerimaan_ikan,penerimaan_id',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['created_at'] = now();
            $data['updated_at'] = now();

            DB::table('cutting_ls')->insert($data);

            DB::commit();
            return redirect()->route('cutting-loin.index')
                ->with('success', 'Data berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $data = CuttingL::findOrFail($id);
        $penerimaan = Penerimaan_ikan::with('supplier')->get();
        $gradeSizes = GradeSizing::all();
        
        return view('admin.transaksi.cutting-loin.edit', compact('data', 'penerimaan', 'gradeSizes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tggl_cutting' => 'required|date',
            'tggl_injek_co' => 'required|date|after_or_equal:tggl_cutting',
            'tggl_service' => 'required|date|after_or_equal:tggl_cutting',
            'grade_size_id' => 'required|exists:grade_sizings,grade_size_id',
            'berat_loin' => 'required|numeric|min:0',
            'suhu_loin' => 'required|numeric',
            'penerimaan_id' => 'required|exists:penerimaan_ikan,penerimaan_id',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except(['_token', '_method']);
            $data['updated_at'] = now();

            DB::table('cutting_ls')
                ->where('cuttingl_id', $id)
                ->update($data);

            DB::commit();
            return redirect()->route('cutting-loin.index')
                ->with('success', 'Data berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $data = CuttingL::findOrFail($id);
            $data->delete();

            DB::commit();
            return redirect()->route('cutting-loin.index')
                ->with('success', 'Data berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}