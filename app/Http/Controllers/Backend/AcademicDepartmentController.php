<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\AcademicDepartment;
use App\Models\College;
use Illuminate\Http\Request;
use App\Models\User;


class AcademicDepartmentController extends Controller
{
    public function index()
    {
        $departments = AcademicDepartment::with('college')
            ->orderBy('name')
            ->get();

        return view('backend.academic_departments.index', compact('departments'));
    }

    public function create()
    {
        $colleges = College::orderBy('name')->get();

        return view('backend.academic_departments.create', compact('colleges'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'college_id' => 'required|exists:colleges,id',
        ]);

        AcademicDepartment::create($request->all());

        return redirect()
            ->route('backend.academic-departments.index')
            ->with('success', 'Department created successfully');
    }

    public function edit($id)
    {
        $department = AcademicDepartment::findOrFail($id);
        $colleges   = College::orderBy('name')->get();

        return view('backend.academic_departments.edit', compact('department', 'colleges'));
    }

    public function update(Request $request, $id)
    {
        $department = AcademicDepartment::findOrFail($id);

        $request->validate([
            'name'       => 'required|string|max:255',
            'college_id' => 'required|exists:colleges,id',
        ]);

        $department->update($request->all());

        return redirect()
            ->route('backend.academic-departments.index')
            ->with('success', 'Department updated successfully');
    }

    public function destroy($id)
    {
        AcademicDepartment::findOrFail($id)->delete();

        return redirect()
            ->route('backend.academic-departments.index')
            ->with('success', 'Department deleted successfully');
    }

    public function assignHodForm($id)
    {
        $department = AcademicDepartment::with('college', 'hod')->findOrFail($id);

        // Only users who can be HODs (Spatie role)
        $hods = User::role('hod')
            ->orderBy('surname')
            ->orderBy('firstname')
            ->get();


        return view(
            'backend.academic_departments.assign_hod',
            compact('department', 'hods')
        );
    }

    public function assignHod(Request $request, $id)
    {
        $department = AcademicDepartment::findOrFail($id);

        $request->validate([
            'hod_user_id' => 'nullable|exists:users,id',
        ]);

        $department->update([
            'hod_user_id' => $request->hod_user_id,
        ]);

        return redirect()
            ->route('backend.academic-departments.index')
            ->with('success', 'HOD assigned successfully');
    }

}
