<?php

namespace App\Services\Admin;
use App\Models\Admission;
use App\Services\Audit\AuditLogService;
use Illuminate\Support\Facades\Mail;
class DocumentVerificationService
{
    protected AuditLogService $audit;

    public function __construct(AuditLogService $audit)
    {
        $this->audit = $audit;
    }

    /** Build full student view */
    public function buildStudentVerificationData(Admission $admission)
    {
        return [
            'admission'   => $admission,
            'application' => $admission->application,
            'documents'   => $admission->uploadedDocuments, // <-- rename for clarity
            'requirements' => \App\Models\AdmissionDocumentType::where('status','active')->get(),
        ];
    }

    /** Approve documents */
    public function approve(Admission $admission)
    {
        $old = $admission->status;

        $admission->update([
            'status' => 'docs_verified'
        ]);

        $this->audit->log('documents_verified', $admission, [
            'old' => ['status' => $old],
            'new' => ['status' => 'docs_verified'],
        ]);
    }

    /** Reject documents */
    public function reject(Admission $admission, $request)
    {
        $old = $admission->status;

        $admission->update([
            'status' => 'documents_rejected',
            'rejection_reason' => $request->reason,
        ]);

        $this->audit->log('documents_rejected', $admission, [
            'old' => ['status' => $old],
            'new' => ['status' => 'documents_rejected'],
        ]);

        // Send rejection email (optional)
    }
}
