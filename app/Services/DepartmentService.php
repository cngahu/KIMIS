<?php

namespace App\Services;


use App\Models\Departmentt;
use Illuminate\Http\Request;

class DepartmentService
{
    public function getDepartments(Request $request)
    {
        return Departmentt::with('college')
            ->when($request->college_id, function ($q) use ($request) {
                $q->where('college_id', $request->college_id);
            })
            ->orderBy('name')
            ->get();
    }

    public function store(array $data): Departmentt
    {
        return Departmentt::create($data);
    }

    public function update(Departmentt $department, array $data): bool
    {
        return $department->update($data);
    }

    public function delete(Departmentt $department): bool
    {
        return $department->delete();
    }
}
