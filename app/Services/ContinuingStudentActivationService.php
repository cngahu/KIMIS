<?php

namespace App\Services;
use App\Mail\UserAccountCreatedMail;
use App\Models\CohortStageTimeline;
use App\Models\Masterdata;
use App\Models\User;
use App\Models\Student;
use App\Models\StudentProfile;
use App\Models\Enrollment;
use App\Models\StudentOpeningBalance;
use App\Models\CourseCohort;
use App\Models\CourseStageMapping;
use App\Services\Audit\AuditLogService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class ContinuingStudentActivationService
{

    public function activate0(array $data): Student
    {
        return DB::transaction(function () use ($data) {

            /** ------------------------------------------------
             * 1. Lock & validate masterdata
             * ------------------------------------------------ */
            $master = Masterdata::where('admissionNo', $data['admissionno'])
                ->lockForUpdate()
                ->firstOrFail();

            if (!is_null($master->activated_at)) {
                throw new \Exception('Student already activated.');
            }

            /** ------------------------------------------------
             * 2. Create / link user
             * ------------------------------------------------ */
            $temporaryPassword = Str::random(10);

            $user = User::firstOrCreate(
                ['username' => $master->admissionNo],
                [
                    'surname'   => $master->full_name,
                    'firstname' => $master->full_name,
                    'email'     => $data['email'],
                    'phone'     => $data['phone'],
                    'national_id' => $master->idno,
                    'campus_id' => $master->campus_id,
                    'userrole'  => 'student',
                    'password'  => Hash::make($temporaryPassword),
                    'must_change_password' => 1,
                ]
            );

            if (!$user->hasRole('student')) {
                $user->assignRole('student');
            }

            /** ------------------------------------------------
             * 3. Create student
             * ------------------------------------------------ */
            $student = Student::create([
                'user_id'        => $user->id,
                'student_number' => $master->admissionNo,
                'course_id'      => $master->course_id,
                'campus_id'      => $master->campus_id,
                'status'         => 'active',
                'activated_at'   => now(),
                'source'         => 'legacy_masterdata',
                'admission_id'=> $master->id,
                'pending_initial_billing' => 1,
            ]);

            /** ------------------------------------------------
             * 4. Student profile
             * ------------------------------------------------ */
            StudentProfile::create([
                'student_id' => $student->id,
                'id_number'  => $master->idno,
                'phone'      => $data['phone'],
                'email'      => $data['email'],
                'extra_data' => [
                    'legacy_intake' => $master->intake,
                    'legacy_stage'  => $master->current,
                ],
            ]);

            /** ------------------------------------------------
             * 5. Resolve cohort
             * ------------------------------------------------ */
//            $cohort = CourseCohort::where('course_id', $master->course_id)
//                ->where('label', 'like', "%{$master->intake}%")
//                ->first();

            $cohort=$master->cohort_id_provisional;
//            ? CourseCohort::find($master->cohort_id_provisional):$cohort;
            if (!$cohort) {
                throw new \Exception('Unable to resolve cohort.');
            }

            /** ------------------------------------------------
             * 6. Resolve stage via mapper
             * ------------------------------------------------ */
            $mapping = CourseStageMapping::where('course_id', $master->course_id)
                ->whereHas('stage', function ($q) use ($master) {
                    $q->where('code', trim($master->current));
                })
                ->first();

            if (!$mapping) {
                throw new \Exception('Unable to resolve current stage.');
            }

            /** ------------------------------------------------
             * 7. Enrollment
             * ------------------------------------------------ */
            Enrollment::create([
                'student_id' => $student->id,
                'course_id'  => $master->course_id,
                'campus_id'  => $master->campus_id,
                'cohort_id'  => $cohort->id,
                'stage_id'   => $mapping->course_stage_id,
                'status'     => 'active',
                'source'     => 'legacy',
            ]);

            /** ------------------------------------------------
             * 8. Opening balance
             * ------------------------------------------------ */
            if ((float)$master->balance !== 0.0) {
                StudentOpeningBalance::create([
                    'student_id' => $student->id,
                    'amount'     => $master->balance,
                    'as_of_date' => now(),
                    'source'     => 'legacy_masterdata',
                ]);
            }

            /** ------------------------------------------------
             * 9. Mark masterdata activated
             * ------------------------------------------------ */
            $master->update([
                'activated_at' => now(),
            ]);

            /** ------------------------------------------------
             * 10. Audit
             * ------------------------------------------------ */
            app(AuditLogService::class)->log(
                'continuing_student_activated',
                $student,
                ['masterdata_id' => $master->id]
            );

            return $student;
        });
    }
    public function activate(array $data): Student
    {
        return DB::transaction(function () use ($data) {

            // 1. Lock masterdata
            $master = Masterdata::where('admissionNo', $data['admissionno'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($master->activated_at) {
                throw new \Exception('Student already activated.');
            }

            // 2. Create user
            $temporaryPassword = Str::random(10);

            $user = User::firstOrCreate(
                ['username' => $master->admissionNo],
                [
                    'surname'   => $master->full_name,
                    'firstname' => $master->full_name,
                    'email'     => $data['email'],
                    'phone'     => $data['phone'],
                    'national_id' => $master->idno,
                    'campus_id' => $master->campus_id,
                    'userrole'  => 'student',
                    'password'  => Hash::make($temporaryPassword),
                    'must_change_password' => 1,
                ]
            );

            if (!$user->hasRole('student')) {
                $user->assignRole('student');
            }

            if (!empty($user->email)) {
                Mail::to($user->email)->send(
                    new UserAccountCreatedMail($user, $temporaryPassword)
                );
            }

            // 3. Create student
            $student = Student::create([
                'user_id'        => $user->id,
                'student_number' => $master->admissionNo,
                'course_id'      => $master->course_id,
                'campus_id'      => $master->campus_id,
                'status'         => 'active',
                'activated_at'   => now(),
                'source'         => 'legacy_masterdata',
                'pending_initial_billing' => 1,
                'admission_id'=>$master->id,
            ]);

            // 4. Profile
            StudentProfile::create([
                'student_id' => $student->id,
                'id_number'  => $master->idno,
                'phone'      => $data['phone'],
                'email'      => $data['email'],
                'extra_data' => [
                    'legacy_intake' => $master->intake,
                    'legacy_stage'  => $master->current,
                ],
            ]);

            // ✅ 5. Resolve cohort (HERE)
//            $cohortId = $this->resolveCohort($master);
            $cohortId=$master->cohort_id_provisional;

            // ✅ 6. Resolve stage
//            $stageId = $this->resolveStage($master);

            // 6. Resolve stage (NEW)
            $stageId = $this->resolveCurrentTimelineStage($cohortId);

            // 7. Enrollment
            Enrollment::create([
                'student_id'        => $student->id,
                'course_id'         => $master->course_id,
                'campus_id'         => $master->campus_id,

                // Legacy-friendly fields
                'year'              => now()->year,
                'cohort'            => $master->intake,
                'semester'          => null,

                // Canonical structure
                'course_cohort_id'  => $cohortId,
                'course_stage_id'   => $stageId,


                'status'            => 'active',
                'source'            => 'legacy',
                'activated_at'      => now(),
            ]);


            // 8. Opening balance
            if ((float)$master->balance !== 0.0) {
                StudentOpeningBalance::create([
                    'student_id' => $student->id,
                    'amount'     => $master->balance,
                    'as_of_date' => now(),
                    'source'     => 'legacy_masterdata',
                ]);
            }

            $legacyStageId = $this->resolveStage($master);

//            if ($legacyStageId !== $stageId) {
//                Log::warning('Legacy vs timeline stage mismatch', [
//                    'admissionNo' => $master->admissionNo,
//                    'legacy_stage' => $master->current,
//                    'timeline_stage_id' => $stageId,
//                ]);
//            }

            // 9. Mark activated
            $master->update(['activated_at' => now()]);

            return $student;
        });
    }

    /* =========================================================
       PRIVATE HELPERS LIVE BELOW
       ========================================================= */

    private function resolveCohort(Masterdata $master): int
    {
        // Example: "Sep-25"
        try {
            $date = Carbon::createFromFormat('M-y', $master->intake);
        } catch (\Exception $e) {
            throw new \Exception('Invalid intake format: ' . $master->intake);
        }

        $cohort = CourseCohort::where('course_id', $master->course_id)
            ->where('intake_year', $date->year)
            ->where('intake_month', $date->month)
            ->first();

        if (!$cohort) {
            throw new \Exception(
                "No cohort found for {$date->format('M Y')}."
            );
        }

        return $cohort->id;
    }

    private function resolveStage(Masterdata $master): int
    {
        $mapping = CourseStageMapping::where('course_id', $master->course_id)
            ->whereHas('stage', function ($q) use ($master) {
                $q->where('code', trim($master->current));
            })
            ->first();

        if (!$mapping) {
            throw new \Exception(
                'Unable to resolve stage: ' . $master->current
            );
        }

        return $mapping->course_stage_id;
    }

    private function resolveCurrentTimelineStage(int $cohortId): int
    {
        $timeline = CohortStageTimeline::where('course_cohort_id', $cohortId)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();

        if (!$timeline) {
            throw new \Exception(
                'No active stage found for cohort timeline.'
            );
        }

        return $timeline->course_stage_id;
    }

}
