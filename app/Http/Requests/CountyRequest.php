<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // Permission already handled in controller middleware
    }

    public function rules()
    {
        $id = $this->route('county')?->id;

        return [
            'name' => 'required|string|max:255|unique:counties,name,' . $id,
            'code' => 'nullable|string|max:50|unique:counties,code,' . $id,
        ];
    }
}
