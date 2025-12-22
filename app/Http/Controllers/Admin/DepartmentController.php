<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\DepartmentRequest;
use App\Models\College;
use App\Models\Departmentt;
use App\Services\DepartmentService;

class DepartmentController extends Controller
{
    public function __construct(private DepartmentService $service) {}

    public function index(Request $request)
    {
        $colleges = College::orderBy('name')->get();
        $departments = $this->service->getDepartments($request);

        return view('admin.departments.index', compact('departments', 'colleges'));
    }

    public function create()
    {
        $colleges = College::orderBy('name')->get();
        return view('admin.departments.create', compact('colleges'));
    }

    public function store(DepartmentRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function edit(Departmett $department)
    {
        $colleges = College::orderBy('name')->get();
        return view('admin.departments.edit', compact('department', 'colleges'));
    }

    public function update(DepartmentRequest $request, Departmett $department)
    {
        $this->service->update($department, $request->validated());

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Departmett $department)
    {
        $this->service->delete($department);

        return back()->with('success', 'Department deleted successfully.');
    }
}
