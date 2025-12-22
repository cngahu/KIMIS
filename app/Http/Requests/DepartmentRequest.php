<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->hasRole('superadmin');
    }

    public function rules(): array
    {
        $departmentId = $this->route('department')?->id;

        return [
            'college_id' => ['required', 'exists:colleges,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:departmentts,name,' . $departmentId . ',id,college_id,' . $this->college_id
            ],
            'code' => ['nullable', 'string', 'max:50'],
        ];
    }
}
