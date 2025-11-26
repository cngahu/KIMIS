<?php

namespace App\Services\Admin;
use App\Models\Admission;
use App\Models\Student;
use App\Models\StudentProfile;
use App\Models\Enrollment;
use App\Models\AdmissionFeePayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Audit\AuditLogService;
class StudentAdmissionService
{
    public function admit(Admission $admission)
    {
        // 1. Prevent double admission
        if ($admission->status === 'admitted') {
            return back()->with('error', 'Student is already admitted.');
        }

        // 2. Validate payment
        $requiredFee = $admission->required_fee ?? 0;

        $paidTotal = AdmissionFeePayment::where('admission_id', $admission->id)
            ->where('status', 'paid')
            ->sum('amount');

        if (bccomp($paidTotal, $requiredFee, 2) < 0) {
            return back()->with('error', 'Student has not paid full required fee.');
        }

        DB::beginTransaction();
        try {
            $old = $admission->getOriginal();

            /**
             * -----------------------------------------------
             * 3. Update admission: assign admission number
             * -----------------------------------------------
             */
            $admission->admission_number = 'ADM-' . date('Y') . '-' .
                str_pad($admission->id, 5, '0', STR_PAD_LEFT);

            $admission->status = 'admitted';
            $admission->admitted_at = now();
            $admission->save();


            /**
             * -----------------------------------------------
             * 4. Create Student record
             * -----------------------------------------------
             */
            $application = $admission->application;   // already linked
            $course = $application->course;           // course applied for

            $student = Student::create([
                'user_id'       => $admission->user_id,
                'admission_id'  => $admission->id,
                'student_number' => $this->generateStudentNumber(),
                'course_id'     => $course->id,
                'campus_id'     => $course->college_id,
                'admitted_at'   => now(),
                'status'        => 'active'
            ]);


            /**
             * -----------------------------------------------
             * 5. Create Student Profile record
             * (pulling from admission details & application)
             * -----------------------------------------------
             */
            $details = $admission->details; // admission_details table

            StudentProfile::create([
                'student_id' => $student->id,

                // Bio details (from application form)
                'id_number'     => $application->id_number ?? null,
                'gender'        => $application->gender ?? null,
                'date_of_birth' => $application->date_of_birth ?? null,
                'nationality'   => $application->nationality ?? null,

                // Contact
                'phone'         => $application->phone ?? null,
                'email'         => $application->email ?? null,
                'postal_address'=> $application->postal_address ?? null,
                'town'          => $application->town ?? null,

                // Counties
                'home_county_id' => $application->home_county_id ?? null,
                'current_county_id' => $application->current_county_id ?? null,

                // Guardian — from admission_details
                'guardian_name'        => $details->parent_name ?? null,
                'guardian_phone'       => $details->parent_phone ?? null,
                'guardian_relationship'=> $details->parent_relationship ?? null,

                // Next of Kin — from admission_details
                'nok_name'        => $details->nok_name ?? null,
                'nok_phone'       => $details->nok_phone ?? null,
                'nok_relationship'=> $details->nok_relationship ?? null,

                // Medical
                'disability'      => $details->disability_status ?? null,
                'chronic_illness' => $details->chronic_illness ?? null,
                'allergies'       => $details->allergies ?? null,

                // Academic
                'kcse_mean_grade' => $application->kcse_grade ?? null,
                'school_attended' => $details->education_school ?? null,
                'year_completed'  => $details->education_year ?? null,

                'extra_data' => null
            ]);


            /**
             * -----------------------------------------------
             * 6. Create Enrollment Record
             * -----------------------------------------------
             */
            Enrollment::create([
                'student_id' => $student->id,
                'course_id'  => $course->id,
                'campus_id'  => $course->college_id,
                'year'       => date('Y'),
                'cohort'     => date('M Y') . " Intake",
                'status'     => 'active'
            ]);


            /**
             * -----------------------------------------------
             * 7. Audit Log
             * -----------------------------------------------
             */
            app(AuditLogService::class)->log('student_admitted', $admission, [
                'old' => $old,
                'new' => $admission->getChanges(),
                'student_id' => $student->id,
            ]);


            DB::commit();
            return back()->with('success', 'Student admitted successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Student Admission FAILED: ".$e->getMessage());
            return back()->with('error', 'Admission failed, please try again.');
        }
    }


    /**
     * Generate a student number like: KIHBT/2025/00001
     */
    private function generateStudentNumber(): string
    {
        $year = date('Y');
        $count = Student::whereYear('created_at', $year)->count() + 1;

        return 'KIHBT/' . $year . '/' . str_pad($count, 5, '0', STR_PAD_LEFT);
    }
}
