<?php

namespace App\Services;
use App\Models\Applicant;
use App\Services\Audit\AuditLogService;
use Illuminate\Support\Facades\DB;
class ApplicantService
{
    protected AuditLogService $audit;

    public function __construct(AuditLogService $audit)
    {
        $this->audit = $audit;
    }

    public function createOrUpdate(array $data): Applicant
    {
        return DB::transaction(function () use ($data) {

            // Check if applicant exists using ID number or phone
            $query = Applicant::query();

            if (!empty($data['id_number'])) {
                $query->orWhere('id_number', $data['id_number']);
            }

            if (!empty($data['phone'])) {
                $query->orWhere('phone', $data['phone']);
            }

            $existing = $query->first();

            if ($existing) {
                $old = $existing->getOriginal();
                $existing->update($data);

                $this->audit->log('applicant_updated', $existing, [
                    'old' => $old,
                    'new' => $existing->getChanges(),
                ]);

                return $existing;
            }

            $applicant = Applicant::create($data);

            $this->audit->log('applicant_created', $applicant, [
                'new' => $applicant->getAttributes(),
            ]);

            return $applicant;
        });
    }

    protected function getCourseFee($courseId)
    {
        return 1000;
    }


}
