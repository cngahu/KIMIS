<?php

namespace App\Services\Admin;
use App\Models\Admission;
use App\Services\Audit\AuditLogService;
use Illuminate\Support\Facades\Mail;
use App\Models\AdmissionUploadedDocument;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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


    public function verifyDocuments0(Admission $admission, $request)
    {
        $verify = $request->input('verify', []);
        $comments = $request->input('comments', []);

        foreach ($verify as $docId => $status) {

            $doc = AdmissionUploadedDocument::find($docId);

            if ($doc) {
                $doc->verified = $status == "1" ? 1 : 0;
                $doc->verified_by = Auth::id();
                $doc->verified_at = Carbon::now();
                $doc->comment = $comments[$docId] ?? null;
                $doc->save();
            }
        }

        // Check if all mandatory documents are verified
        $mandatory = \App\Models\AdmissionDocumentType::where('is_mandatory', 1)->get();

        foreach ($mandatory as $req) {
            $uploaded = $admission->uploadedDocuments
                ->firstWhere('document_type_id', $req->id);

            if (!$uploaded || !$uploaded->verified) {
                // Missing or rejected document
                $admission->status = 'documents_incomplete';
                $admission->save();
                return;
            }
        }

        // All good!
        $admission->status = 'docs_verified';
        $admission->save();
    }

    public function verifyDocument(Admission $admission, $docId, $action, $comment = null)
    {
        $doc = AdmissionUploadedDocument::where('admission_id', $admission->id)
            ->where('id', $docId)
            ->firstOrFail();

        $doc->verified_status = $action;          // approved, rejected, pending_fix
        $doc->verified_by = Auth::id();
        $doc->verified_at = now();
        $doc->comment = $comment;
        $doc->save();

        return $doc;
    }

    public function finalizeVerification(Admission $admission)
    {
        $docs = $admission->documents;

        $hasRejected = $docs->contains(fn($d) => $d->verified_status === 'rejected');
        $allApproved = $docs->every(fn($d) => in_array($d->verified_status, ['approved','pending_fix']));
        $hasPendingFix = $docs->contains(fn($d) => $d->verified_status === 'pending_fix');

        if ($hasRejected) {
            $admission->status = 'documents_uploaded'; // student must re-upload
            $admission->save();
            return 'rejected_documents';
        }

        if ($allApproved) {

            // NOW CHECK FEES
            if ($admission->fee_status === 'paid') {
                // fully paid → move directly to final admission
                $admission->status = 'ready_for_admission';
                $admission->save();
                return 'ready_for_admission';
            }

            // NOT fully paid → send to accounts
            $admission->status = 'pending_accounts_clearance';
            $admission->save();

            return $hasPendingFix ? 'pending_fix_needs_attention' : 'awaiting_accounts';
        }

        // Incomplete verification
        return 'verification_incomplete';
    }
}
