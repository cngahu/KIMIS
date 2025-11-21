<?php

namespace App\Services;
use App\Models\Application;
use App\Models\Requirement;
use App\Models\ApplicationRequirementAnswer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use App\Services\Audit\AuditLogService;
class ApplicationService
{
    protected AuditLogService $audit;
    protected string $disk = 'public'; // storage/app/public

    public function __construct(AuditLogService $audit)
    {
        $this->audit = $audit;
    }

    /**
     * Create application (pending payment) and store requirement answers.
     */
    public function create(array $data): Application
    {
        return DB::transaction(function () use ($data) {

            // 1. Create application record
            $application = Application::create([
                'course_id'             => $data['course_id'],
                'full_name'             => $data['full_name'],
                'id_number'             => $data['id_number'] ?? null,
                'phone'                 => $data['phone'],
                'email'                 => $data['email'] ?? null,
                'date_of_birth'         => $data['date_of_birth'] ?? null,
                'home_county_id'        => $data['home_county_id'] ?? null,
                'current_county_id'     => $data['current_county_id'] ?? null,
                'current_subcounty_id'  => $data['current_subcounty_id'] ?? null,
                'postal_address'        => $data['postal_address'] ?? null,
                'postal_code_id'        => $data['postal_code_id'] ?? null,
                'co'                    => $data['co'] ?? null,
                'town'                  => $data['town'] ?? null,
                'financier'             => $data['financier'],
                'kcse_mean_grade'       => $data['kcse_mean_grade'] ?? null,
                'declaration'           => true,

                // 🔹 NEW: fixed upload paths from controller payload
               // 'kcse_certificate_path'            => $data['kcse_certificate_path'] ?? null,
              //  'school_leaving_certificate_path'  => $data['school_leaving_certificate_path'] ?? null,
                'birth_certificate_path'           => $data['birth_certificate_path'] ?? null,
                'national_id_path'                 => $data['national_id_path'] ?? null,

                'status'                => 'pending_payment',
                'payment_status'        => 'pending',
                'reference'             => $this->generateReference(),
            ]);

            // 2. Save requirement answers
            if (!empty($data['requirements'])) {
                $this->saveRequirementAnswers($application, $data['requirements']);
            }

            // 3. Create invoice
            $amount = $this->getCourseFee($application->course_id);
            app(\App\Services\PaymentService::class)->generateInvoice($application, $amount);

            // 4. Log audit
            $this->audit->log('application_created', $application);

            return $application;
        });
    }
    protected function getCourseFee($courseId)
    {
        return 1000;
    }

    /**
     * Store requirement answers (files or text).
     */
    protected function saveRequirementAnswers(Application $application, array $answers)
    {
        $requirements = Requirement::where('course_id', $application->course_id)->get();

        foreach ($requirements as $req) {

            if (!array_key_exists($req->id, $answers)) continue;

            $input = $answers[$req->id];
            $value = null;
            $original = null;

            if ($req->type === 'file' && $input instanceof UploadedFile) {

                $origName = $input->getClientOriginalName();

                $stored = $input->storeAs(
                    "applications/{$application->id}/requirements",
                    Str::slug(pathinfo($origName, PATHINFO_FILENAME)) . "_" . time() . "." . $input->getClientOriginalExtension(),
                    $this->disk
                );

                $value = $stored;
                $original = $origName;

            } elseif ($req->type === 'text') {
                $value = $input;
            }

            ApplicationRequirementAnswer::create([
                'application_id' => $application->id,
                'requirement_id' => $req->id,
                'value'          => $value,
                'original_name'  => $original,
            ]);
        }
    }

    /**
     * Generate unique application reference.
     */
    protected function generateReference(): string
    {
        // Lock the row for update to prevent race conditions
        $seq = \App\Models\ApplicationSequence::lockForUpdate()->first();

        // Increment
        $next = $seq->last_number + 1;

        // Update in DB
        $seq->update(['last_number' => $next]);

        // Format: APP-2025-10001
        return 'APP-' . date('Y') . '-' . str_pad($next, 5, '0', STR_PAD_LEFT);
    }


}
