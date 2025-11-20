<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // public form
    }

    public function rules()
    {
        return [
            // Honeypot field — MUST be empty
            'website' => 'nullable|max:0',

            // Course
            'course_id' => 'required|exists:courses,id',

            // Personal info
            'full_name' => 'required|string|max:255',
            'id_number' => 'nullable|string|max:50',
            'phone' => 'required|regex:/^\+254[0-9]{9}$/',
            'email' => 'required|email|max:255',

            'date_of_birth' => 'nullable|date',

            // Address
            'home_county_id' => 'required|exists:counties,id',
            'current_county_id' => 'required|exists:counties,id',
            'current_subcounty_id' => 'required|exists:subcounties,id',
            'postal_address' => 'required|string|max:255',
            'postal_code_id' => 'required|exists:postal_codes,id',
            'co' => 'nullable|string|max:255',
            'town' => 'nullable|string|max:255',

            // Other fields
            'financier' => 'required|in:self,parent',
            'kcse_mean_grade' => 'required|string|max:5',

            // Declaration
            'declaration' => 'required|accepted',

            // 🔹 Fixed uploads
            'kcse_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'school_leaving_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'birth_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'national_id' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',


            // Dynamic requirements array
            'requirements' => 'nullable|array',
            'requirements.*' => 'nullable', // validated below
        ];
    }

    /**
     * Additional validation for dynamic requirements.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $course = \App\Models\Course::find($this->course_id);

            if (!$course) return;

            $requirements = $course->requirements;

            foreach ($requirements as $req) {

                $field = "requirements.{$req->id}";
                $input = $this->input("requirements.{$req->id}");
                $file  = $this->file("requirements.{$req->id}");

                if ($req->required) {
                    if ($req->type === 'upload' && !$file) {
                        $validator->errors()->add($field, "{$req->course_requirement} is required.");
                    }

                    if ($req->type === 'text' && empty($input)) {
                        $validator->errors()->add($field, "{$req->course_requirement} is required.");
                    }
                }

                if ($req->type === 'upload' && $file) {
                    if (!$file->isValid()) {
                        $validator->errors()->add($field, "Invalid file upload.");
                    }
                }
            }
        });
    }

}
