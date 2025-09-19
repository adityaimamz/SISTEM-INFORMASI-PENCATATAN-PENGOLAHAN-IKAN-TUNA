<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GradeService;

class GradeSController extends Controller
{

    public function index()
    {
        $gradeServices = GradeService::all();
        return view('admin.data-master.grade_service', compact('gradeServices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grading' => 'required',
        ]);
        
        GradeService::create([
            'grading' => $request->grading,
        ]);
        
        return redirect()->route('grade_service.index')->with('success', 'Grade Service created successfully');
    }

    public function update(Request $request, string $id)
    {
            GradeService::find($id)->update([
            'grading' => $request->grading,
        ]);
        
        return redirect()->route('grade_service.index')->with('success', 'Grade Service updated successfully');
    }

    public function destroy(string $id)
    {
        GradeService::find($id)->delete();
        return redirect()->route('grade_service.index')->with('success', 'Grade Service deleted successfully');
    }
}