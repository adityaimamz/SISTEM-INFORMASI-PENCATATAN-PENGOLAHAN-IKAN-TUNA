<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GradeHService;

class GradeHController extends Controller
{
    public function index()
    {
        $gradeHServices = GradeHService::all();
        return view('admin.data-master.grade_hservice', compact('gradeHServices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grade_servicehs' => 'required|string|max:255',
        ]);
        
        GradeHService::create([
            'grade_servicehs' => $request->grade_servicehs,
        ]);
        
        return redirect()->route('grade_hservice.index')->with('success', 'Grade H Service created successfully');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'grade_servicehs' => 'required',
        ]);
        
            GradeHService::find($id)->update([
            'grade_servicehs' => $request->grade_servicehs,
        ]);
        
        return redirect()->route('grade_hservice.index')->with('success', 'Grade H Service updated successfully');
    }

    public function destroy(string $id)
    {
        GradeHService::find($id)->delete();
        return redirect()->route('grade_hservice.index')->with('success', 'Grade H Service deleted successfully');
    }
}