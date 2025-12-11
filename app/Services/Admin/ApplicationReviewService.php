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
            'status'      => 'under_review',
        ]);

        // Log audit
        $this->audit->log('application_assigned', $application, [
            'new' => ['reviewer_id' => $reviewerId],
        ]);

        // Send email to officer
        Mail::to($application->reviewer->email)
            ->send(new OfficerAssignmentMail($application));

        return $application;
    }

    /**
     * Legacy simple approve (kept for reference / backwards compatibility)
     */
    public function approve0(Application $application, string $comment = null)
    {
        $application->update([
            'status'            => 'approved',
            'reviewer_comments' => $comment,
        ]);

        $this->audit->log('application_approved', $application, [
            'new' => ['reviewer_comments' => $comment],
        ]);

        // Send email to applicant
        Mail::to($application->email)
            ->send(new \App\Mail\ApplicationApprovedMail($application));

        return $application;
    }

    /**
     * Approve application WITH chosen course.
     *
     * @param  \App\Models\Application  $application
     * @param  int                      $approvedCourseId   The course selected by the officer
     * @param  string|null              $comment            Officer's comments
     */



    public function approve(Application $application, string $comment = null, ?int $approvedCourseId = null)
    {
        // ---- 1. Metadata: applied vs admitted ----
        $meta = $application->metadata ?? [];

        // If we don't have the original yet, save it now
        if (! isset($meta['applied_course_id'])) {
            $meta['applied_course_id'] = $application->course_id;
        }

        // Decide which course is the admitted one
        $admittedCourseId = $approvedCourseId ?: $meta['applied_course_id'];

        $meta['admitted_course_id'] = $admittedCourseId;

        // ---- 2. Create applicant account (unchanged) ----
        $account = app(\App\Services\ApplicantAccountService::class)
            ->createApplicantAccount($application);

        $rawPassword = $account['password'];
        $user        = $account['user'];

        // ---- 3. Update application (status, comments, metadata, course_id = admitted) ----
        $application->update([
            'status'            => 'approved',
            'reviewer_comments' => $comment,
            'metadata'          => $meta,
            'course_id'         => $admittedCourseId,   // app now points to the admitted course
        ]);

        // ---- 4. Audit log ----
        $this->audit->log('application_approved', $application, [
            'new' => [
                'reviewer_comments'   => $comment,
                'applied_course_id'   => $meta['applied_course_id'],
                'admitted_course_id'  => $meta['admitted_course_id'],
            ]
        ]);

        // ---- 5. PDFs + email (your existing logic) ----
        $admissionLetter = app(\App\Services\AdmissionPdfService::class)
            ->generateAdmissionLetter($application);

        $feeStructure = app(\App\Services\AdmissionPdfService::class)
            ->generateFeeStructure($application);

        $medicalReport = app(\App\Services\AdmissionPdfService::class)
            ->generatemedical($application);

        $requirement = app(\App\Services\AdmissionPdfService::class)
            ->generaterequirement($application);

        \Mail::to($application->email)->send(
            new \App\Mail\ApplicationApprovedMail(
                $application,
                $user,
                $rawPassword,
                $admissionLetter,
                $feeStructure,
                $feeStructure,
                $requirement,
            )
        );

        return $application;
    }



    public function reject0(Application $application, string $comment)
    {
        $application->update([
            'status'            => 'rejected',
            'reviewer_comments' => $comment,
        ]);

        $this->audit->log('application_rejected', $application, [
            'new' => ['reviewer_comments' => $comment],
        ]);

        // Notify applicant
        Mail::to($application->email)
            ->send(new \App\Mail\ApplicationRejectedMail($application));

        // Notify registrar
        Mail::to('papacosi@gmail.com')
            ->send(new \App\Mail\AdminApplicationRejectedMail($application));

        return $application;
    }

    /**
     * Current reject implementation
     */
    public function reject(Application $application, string $comment)
    {
        $application->update([
            'status'            => 'rejected',
            'reviewer_comments' => $comment,
        ]);

        // Log
        $this->audit->log('application_rejected', $application, [
            'new' => ['reviewer_comments' => $comment],
        ]);

        // Send rejection email (with comment)
        if (!empty($application->email)) {
            Mail::to($application->email)->send(
                new \App\Mail\ApplicationRejectedMail($application, $comment)
            );
        }

        return $application;
    }

    public function markViewed(Application $application)
    {
        $this->audit->log('application_viewed_by_officer', $application);
    }
}
