<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionDocumentType;
use App\Services\Admin\AdmissionDocumentTypeService;
use Illuminate\Http\Request;

class AdmissionDocumentTypeController extends Controller
{
    //

    protected AdmissionDocumentTypeService $service;

    public function __construct(AdmissionDocumentTypeService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $docs = AdmissionDocumentType::orderBy('name')->get();
        return view('admin.admission.documents.index', compact('docs'));
    }

    public function create()
    {
        return view('admin.admission.documents.create');
    }

    public function store(Request $request)
    {
        $this->service->create($request->all());
        return redirect()->route('admin.admission.documents.index')
            ->with('success', 'Document added.');
    }

    public function edit(AdmissionDocumentType $doc)
    {
        return view('admin.admission.documents.edit', compact('doc'));
    }

    public function update(Request $request, AdmissionDocumentType $doc)
    {
        $this->service->update($doc, $request->all());
        return back()->with('success', 'Document updated.');
    }

    public function destroy(AdmissionDocumentType $doc)
    {
        $this->service->delete($doc);
        return back()->with('success', 'Document deleted.');
    }
}
