<?php

namespace App\Services\Student;

use App\Models\AdmissionDocumentType;
use App\Models\AdmissionUploadedDocument;
use Illuminate\Http\Request;

use Illuminate\Validation\ValidationException;

class AdmissionDocumentUploadService
{
    public function upload($admission, Request $request)
    {
        $types = AdmissionDocumentType::where('status','active')->get();

        foreach ($types as $type) {

            if (!$request->hasFile("documents.$type->id")) {
                continue;
            }

            $file = $request->file("documents.$type->id");

            $ext = $file->getClientOriginalExtension();
            $allowed = explode(',', $type->file_types);

            if (!in_array($ext, $allowed)) {
                throw ValidationException::withMessages([
                    "documents.$type->id" => "Invalid file type."
                ]);
            }

            $path = $file->store(
                "admissions/{$admission->id}",
                'public'
            );

            AdmissionUploadedDocument::updateOrCreate(
                [
                    'admission_id' => $admission->id,
                    'document_type_id' => $type->id,
                ],
                [
                    'file_path' => $path,
                ]
            );
        }

        // Check mandatory docs
        $mandatoryCount = AdmissionDocumentType::where('is_mandatory', 1)->count();

        $uploadedCount = AdmissionUploadedDocument::where('admission_id', $admission->id)
            ->whereIn('document_type_id',
                AdmissionDocumentType::where('is_mandatory',1)->pluck('id')
            )->count();

        if ($mandatoryCount === $uploadedCount) {
            $admission->status = 'documents_uploaded';
            $admission->save();
        }
    }
}

