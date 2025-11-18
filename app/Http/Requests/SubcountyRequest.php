<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubcountyRequest extends FormRequest
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
        $id = $this->route('subcounty')?->id;

        return [
            'county_id' => 'required|exists:counties,id',
            'name' => 'required|string|max:255|unique:subcounties,name,' . $id . ',id,county_id,' . $this->county_id,
            'code' => 'nullable|string|max:50'
        ];
    }
}
