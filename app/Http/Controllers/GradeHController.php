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
            'grade_servicehs' => 'required|string|max:255|unique:grade_servicehs, grade_servicehs',
        ]);
        
        try {
            GradeHService::create([
                'grade_servicehs' => $request->grade_servicehs,
            ]);
            return redirect()->route('grade_hservice.index')->with('success', 'Grade H Service created successfully');
        } catch (\Exception $e) {
            return redirect()->route('grade_hservice.index')->with('error', 'Grade H Service already exists');
        }
    }

    public function edit($id)
    {
        try {
            $gradeHService = GradeHService::find($id);
            return view('admin.data-master.grade_hservice_edit', compact('gradeHService'));
        } catch (\Exception $e) {
            return redirect()->route('grade_hservice.index')->with('error', 'Grade H Service not found');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'grade_servicehs' => 'required',
        ]);
        
        try {

            $gradeHService = GradeHService::find($id);
            $gradeHService->update ([
                'grade_servicehs' => $request->grade_servicehs,
            ]);
            return redirect()->route('grade_hservice.index')->with('success', 'Grade H Service updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('grade_hservice.index')->with('error', 'Grade H Service already exists');
        }
    }

    public function destroy($id)
    {
        $gradeHService = GradeHService::find($id);
        $gradeHService->delete();
        return redirect()->route('grade_hservice.index')->with('success', 'Grade H Service deleted successfully');
    }
}