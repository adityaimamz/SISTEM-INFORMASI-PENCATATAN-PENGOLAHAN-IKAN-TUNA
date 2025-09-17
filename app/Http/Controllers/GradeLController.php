<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GradeL;

class GradeLController extends Controller
{
    public function index()
    {
        $gradeL = GradeL::all();
        return view('admin.data-master.gradel', compact('gradeL'));
    }

    public function store(Request $request)
    {
        GradeL::create([
            'grade_sizing' => $request->grade_sizing,
        ]);
        return redirect()->route('gradel.index')->with('success', 'Grade/Sizing created successfully');
    }

    public function update(Request $request, string $id)
    {
        GradeL::find($id)->update([
            'grade_sizing' => $request->grade_sizing,
        ]);
        return redirect()->route('gradel.index')->with('success', 'Grade/Sizing updated successfully');
    }

    public function destroy(string $id)
    {
        GradeL::find($id)->delete();
        return redirect()->route('gradel.index')->with('success', 'Grade/Sizing deleted successfully');
    }
}
