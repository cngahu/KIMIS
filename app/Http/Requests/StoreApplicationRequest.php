<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

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

            // 👇 Will be conditionally required (>= 18) in withValidator()
            'id_number' => 'nullable|string|max:50',

            'phone' => 'required|regex:/^\+254[0-9]{9}$/',
            'email' => 'required|email|max:255',

            // 👇 Make DOB required so age logic is always possible
            'date_of_birth' => 'required|date|before:today',

            // Address
            'home_county_id'       => 'required|exists:counties,id',
            'current_county_id'    => 'required|exists:counties,id',
            'current_subcounty_id' => 'required|exists:subcounties,id',
            'postal_address'       => 'required|string|max:255',
            'postal_code_id'       => 'required|exists:postal_codes,id',
            'co'                   => 'nullable|string|max:255',
            'town'                 => 'nullable|string|max:255',

            // Other fields
            'financier'       => 'required|in:self,parent',
            'kcse_mean_grade' => 'required|string|max:5',

            // Declaration
            'declaration' => 'required|accepted',

            // 🔹 Fixed uploads (conditionally required in withValidator)
            'birth_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'national_id'       => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

            // Dynamic requirements array
            'requirements'   => 'nullable|array',
            'requirements.*' => 'nullable', // validated below
        ];
    }

    /**
     * Additional validation for dynamic requirements + age-based docs.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            /**
             * 1) Dynamic course requirements (your existing logic)
             */
            $course = \App\Models\Course::find($this->course_id);

            if ($course) {
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
            }

            /**
             * 2) Age-based logic:
             *    - If age >= 18  → require id_number + national_id
             *    - If age <  18  → require birth_certificate
             */
            $dob = $this->input('date_of_birth');

            if ($dob) {
                try {
                    $dateOfBirth = Carbon::parse($dob);
                } catch (\Exception $e) {
                    // If parsing fails, leave it to the base 'date' rule error
                    return;
                }

                $age = $dateOfBirth->age;

                if ($age >= 18) {
                    // ID Number required
                    if (empty($this->input('id_number'))) {
                        $validator->errors()->add(
                            'id_number',
                            'ID Number is required for applicants 18 years and above.'
                        );
                    }

                    // National ID file required
                    if (! $this->hasFile('national_id')) {
                        $validator->errors()->add(
                            'national_id',
                            'National ID upload is required for applicants 18 years and above.'
                        );
                    }

                } else {
                    // Birth certificate required
                    if (! $this->hasFile('birth_certificate')) {
                        $validator->errors()->add(
                            'birth_certificate',
                            'Birth Certificate upload is required for applicants below 18 years.'
                        );
                    }
                }
            }
        });
    }
}
