<?php
namespace App\Http\Controllers;

use App\Models\CuttingL;
use Illuminate\Http\Request;

class CuttingLController extends Controller
{
    // Method untuk generate PDF
    public function cuttingLPdf()
    {
        $data = CuttingL::with(['grade_size', 'penerimaan'])->get();
        $pdf = \PDF::loadView('pdf.cutting-l', compact('data'));
        return $pdf->download('cutting-loin-'.date('Y-m-d').'.pdf');
    }
}