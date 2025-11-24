<?php

namespace App\Services\Admin;

use App\Models\AdmissionDocumentType;

class AdmissionDocumentTypeService
{
    public function create(array $data)
    {
        return AdmissionDocumentType::create($data);
    }

    public function update(AdmissionDocumentType $doc, array $data)
    {
        return $doc->update($data);
    }

    public function delete(AdmissionDocumentType $doc)
    {
        return $doc->delete();
    }
}
