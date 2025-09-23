<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::all();
        return view('admin.data-master.grade', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Grade::create([
            'grade' => $request->grade,
        ]);
        return redirect()->route('grade.index')->with('success', 'Grade created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $grade_id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $grade_id)
    {
        $grade = Grade::findOrFail($grade_id);
        return view('admin.data-master.grade-edit', compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $grade_id)
    {
        $grade = Grade::findOrFail($grade_id);
        $grade->update([
            'grade' => $request->grade,
        ]);
        return redirect()->route('grade.index')->with('success', 'Grade updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($grade_id)
    {
        try {
            $grade = Grade::findOrFail($grade_id);
            $grade->delete();
            return redirect()->route('grade.index')->with('success', 'Grade deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('grade.index')->with('error', 'Grade deleted failed');
        }
    }
}
