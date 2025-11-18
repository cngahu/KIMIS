<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostalCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('postal_code')?->id;

        return [
            'code' => 'required|string|max:20|unique:postal_codes,code,' . $id,
            'town' => 'nullable|string|max:255',
        ];
    }
}
