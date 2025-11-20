<?php

namespace App\Services\Admin;
use App\Mail\ApplicationApprovedMail;
use App\Mail\OfficerAssignmentMail;
use App\Models\Application;
use App\Services\AdmissionPdfService;
use App\Services\ApplicantAccountService;
use App\Services\Audit\AuditLogService;
use Illuminate\Support\Facades\Mail;
class ApplicationReviewService
{

    protected AuditLogService $audit;

    public function __construct(AuditLogService $audit)
    {
        $this->audit = $audit;
    }

    /**
     * Assign reviewer to application
     */
    public function assignReviewer(Application $application, int $reviewerId)
    {
        // Update assignment
        $application->update([
            'reviewer_id' => $reviewerId,
            'status' => 'under_review',
        ]);

        // Log audit
        $this->audit->log('application_assigned', $application, [
            'new' => ['reviewer_id' => $reviewerId]
        ]);

        // Send email to officer
        Mail::to($application->reviewer->email)
            ->send(new OfficerAssignmentMail($application));

        return $application;
    }

    /**
     * Approve application
     */
    public function approve0(Application $application, string $comment = null)
    {
        $application->update([
            'status' => 'approved',
            'reviewer_comments' => $comment,
        ]);

        $this->audit->log('application_approved', $application, [
            'new' => ['reviewer_comments' => $comment]
        ]);

        // Send email to applicant
        Mail::to($application->email)
            ->send(new \App\Mail\ApplicationApprovedMail($application));

        // Send email to registrar
//        Mail::to('papacosi@gmail.com')
//            ->send(new \App\Mail\AdminApplicationApprovedMail($application));

        return $application;
    }
    public function approve(Application $application, string $comment = null)
    {
        // Create applicant portal account
        $account = app(ApplicantAccountService::class)
            ->createApplicantAccount($application);

        $rawPassword = $account['password'];  // Needed for email
        $user = $account['user'];

        // Update application
        $application->update([
            'status' => 'approved',
            'reviewer_comments' => $comment,
        ]);

        // Log
        $this->audit->log('application_approved', $application, [
            'new' => ['reviewer_comments' => $comment]
        ]);

        // Generate PDFs
//        $admissionLetter = app(AdmissionPdfService::class)
//            ->generateAdmissionLetter($application);
//
//        $feeStructure = app(AdmissionPdfService::class)
//            ->generateFeeStructure($application);
//
//        // Send email
//        Mail::to($application->email)->send(
//            new ApplicationApprovedMail(
//                $application,
//                $user,
//                $rawPassword,
//                $admissionLetter,
//                $feeStructure
//            )
//        );
        $admissionLetter = app(AdmissionPdfService::class)
            ->generateAdmissionLetter($application);

        $feeStructure = app(AdmissionPdfService::class)
            ->generateFeeStructure($application);

        Mail::to($application->email)->send(
            new ApplicationApprovedMail(
                $application,
                $user,
                $rawPassword,
                $admissionLetter,
                $feeStructure
            )
        );

        return $application;
    }

    /**
     * Reject application
     */
    public function reject0(Application $application, string $comment)
    {
        $application->update([
            'status' => 'rejected',
            'reviewer_comments' => $comment,
        ]);

        $this->audit->log('application_rejected', $application, [
            'new' => ['reviewer_comments' => $comment]
        ]);

        // Notify applicant
        Mail::to($application->email)
            ->send(new \App\Mail\ApplicationRejectedMail($application));

        // Notify registrar
        Mail::to('papacosi@gmail.com')
            ->send(new \App\Mail\AdminApplicationRejectedMail($application));

        return $application;
    }
    public function reject(Application $application, string $comment)
    {
        $application->update([
            'status' => 'rejected',
            'reviewer_comments' => $comment,
        ]);

        // Log
        $this->audit->log('application_rejected', $application, [
            'new' => ['reviewer_comments' => $comment]
        ]);

        // Send rejection email
        Mail::to($application->email)->send(
            new \App\Mail\ApplicationRejectedMail($application, $comment)
        );

        return $application;
    }

    public function markViewed(Application $application)
    {
        $this->audit->log('application_viewed_by_officer', $application);
    }

}
