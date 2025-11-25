<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Models\Admission;
use App\Models\AdmissionFeePayment;
use App\Services\Audit\AuditLogService;
class AccountsController extends Controller
{
    //
    protected AuditLogService $audit;

    public function __construct(AuditLogService $audit)
    {
        $this->audit = $audit;
    }

    public function dashboard()
    {
        return view('admin.accounts.dashboard', [
            'totalInvoiced' => Invoice::sum('amount'),
        'totalPaid'     => Invoice::where('status', 'paid')->sum('amount'),
        'totalPending'  => Invoice::where('status', 'pending')->sum('amount'),

        'invoiceCount'  => Invoice::count(),
            'totalInvoices'     => Invoice::count(),
            'paidInvoices'      => Invoice::where('status','paid')->count(),
            'pendingInvoices'   => Invoice::where('status','pending')->count(),
            'sponsorPending'    => AdmissionFeePayment::where('payment_type','sponsor')->where('status','pending')->count(),
            'payLaterPending'   => AdmissionFeePayment::where('payment_type','pay_later')->where('status','pending')->count(),
            'partialPending'    => AdmissionFeePayment::where('payment_type','partial')->where('status','pending')->count(),

        ]);
    }

    public function invoices()
    {
        $invoices = Invoice::with([
            'application.course',
            'admission.user',
            'admission.application.course'
        ])->orderBy('created_at','desc')
        ->paginate(200);


        return view('admin.accounts.invoices', compact('invoices'));
    }
    public function index(Request $request)
    {
        $query = Invoice::query();

        if ($request->service_name) {
            $query->whereHas('service', function($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->service_name}%");
            });
        }

        if ($request->college_id) {
            $query->where('college_id', $request->college_id);
        }

        if ($request->student_name) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->student_name}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $invoices = $query->paginate(20);

        return view('admin.accounts.index', compact('invoices'));
    }

    public function verifySponsor(AdmissionFeePayment $payment)
    {
        $payment->update(['status' => 'verified']);

        $admission = $payment->admission;
        $admission->update(['fee_status' => 'fee_paid']);

        $this->audit->log('sponsor_payment_verified', $payment);

        return back()->with('success','Sponsor payment verified and student cleared.');
    }

    public function markOfflinePayment(AdmissionFeePayment $payment)
    {
        $payment->update([
            'status'  => 'paid',
            'paid_at' => now(),
        ]);

        $this->audit->log('offline_payment_marked', $payment);

        $this->updateAdmissionFeeStatus($payment->admission);

        return back()->with('success','Offline payment updated.');
    }

    public function clearForAdmission(Admission $admission)
    {
        $admission->update(['fee_status' => 'fee_paid']);

        $this->audit->log('finance_cleared_student', $admission);

        return back()->with('success','Student cleared by Accounts.');
    }

    private function updateAdmissionFeeStatus(Admission $admission)
    {
        $required = $admission->required_fee;
        $paid = AdmissionFeePayment::where('admission_id',$admission->id)
            ->where('status','paid')
            ->sum('amount');

        if ($paid >= $required) {
            $admission->update(['fee_status' => 'fee_paid']);
        } else {
            $admission->update(['fee_status' => 'fee_pending']);
        }
    }
}
