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
        $validated = $request->validate([
            'grade_service' => 'required|string|max:20|unique:grade_services,grade_service',
        ]);

        GradeService::create($validated);
        
        return redirect()
            ->route('gradeservice.index')
            ->with('success', 'Grade Service created successfully');
    }

    public function update(Request $request, string $id)
    {
        $gradeService = GradeService::findOrFail($id);
        
        $validated = $request->validate([
            'grade_service' => 'required|string|max:20|unique:grade_services,grade_service,'.$id.',grade_service_id',
        ]);

        $gradeService->update($validated);
        
        return redirect()
            ->route('gradeservice.index')
            ->with('success', 'Grade Service updated successfully');
    }

    public function destroy(string $id)
    {
        $gradeService = GradeService::findOrFail($id);
        $gradeService->delete();
        
        return redirect()
            ->route('gradeservice.index')
            ->with('success', 'Grade Service deleted successfully');
    }
}