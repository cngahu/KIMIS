<?php

namespace App\Http\Controllers\Registrar;

use App\Http\Controllers\Controller;
use App\Models\AdmissionFeePayment;
use App\Services\Admin\StudentAdmissionService;
use Illuminate\Http\Request;

use App\Models\Admission;
use App\Services\Audit\AuditLogService;

use Illuminate\Support\Str;
class AdmissionProcessingController extends Controller
{
    //
    protected AuditLogService $audit;

    public function __construct(AuditLogService $audit)
    {
        $this->audit = $audit;
    }

//     List all verified admissions
    public function verifiedList()
    {
//        $students = Admission::with(['student', 'application.invoice'])
//            ->where('status', 'docs_verified')
//            ->get();
        $students = Admission::with(['student', 'application.course', 'feePayments'])
            ->where('status', 'docs_verified')
            ->get();


        return view('admin.registrar.admission.verified_list', compact('students'));
    }


    public function verifiedList0()
    {
        $students = Admission::with(['user', 'application.course'])
            ->where('status', 'docs_verified')
            ->get()
            ->map(function ($a) {

                $courseFee = optional($a->application->course)->cost ?? 0;

                $paid = \App\Models\AdmissionFeePayment::where('admission_id', $a->id)
                    ->where('status','paid')
                    ->sum('amount');

                $a->isFullyPaid = bccomp($paid, $courseFee, 2) >= 0;
                $a->paidTotal   = $paid;
                $a->courseFee   = $courseFee;

                return $a;
            });

        return view('admin.registrar.admission.verified_list', compact('students'));
    }

    // Admit and assign admission number
    public function admitStudent0(Admission $admission)
    {
        // Prevent double-admission
        if ($admission->status === 'admitted') {
            return back()->with('error', 'Student already admitted.');
        }

        // Must be fee-paid
        if ($admission->fee_status !== 'fee_paid') {
            return back()->with('error', 'Cannot admit student. Awaiting finance clearance.');
        }

        $old = $admission->getOriginal();

        // Generate admission number (customize format as needed)
        $admission->admission_number = 'ADM-' . date('Y') . '-' . Str::padLeft($admission->id, 5, '0');
        $admission->status = 'admitted';
        $admission->admitted_at = now();
        $admission->save();

        // Audit log
        $this->audit->log('student_admitted', $admission, [
            'old' => $old,
            'new' => $admission->getChanges(),
        ]);

        return back()->with('success', 'Student admitted successfully!');
    }

    public function admitStudent1(Admission $admission)
    {
        // Prevent double admission
        if ($admission->status === 'admitted') {
            return back()->with('error', 'Student is already admitted.');
        }

        // Compute payment from ledger table
        $courseFee  = $admission->required_fee ?? 0;

        $paidTotal = AdmissionFeePayment::where('admission_id', $admission->id)
            ->where('status', 'paid')
            ->sum('amount');

        // Ensure student has fully paid
        if (bccomp($paidTotal, $courseFee, 2) < 0) {
            return back()->with('error', 'Student has not paid full required fee.');
        }

        $old = $admission->getOriginal();

        // Generate admission number
        $admission->admission_number = 'ADM-' . date('Y') . '-' . str_pad($admission->id, 5, '0', STR_PAD_LEFT);
        $admission->status = 'admitted';
        $admission->admitted_at = now();
        $admission->save();

        // Audit
        app(AuditLogService::class)->log('student_admitted', $admission, [
            'old' => $old,
            'new' => $admission->getChanges(),
        ]);

        return back()->with('success', 'Student admitted successfully!');
    }
    public function admitStudent(Admission $admission)
    {
        return app(StudentAdmissionService::class)->admit($admission);
    }

}
