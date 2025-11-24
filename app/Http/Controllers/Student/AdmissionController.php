<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\AdmissionDocumentType;
use App\Models\AdmissionFeePayment;
use App\Models\AdmissionUploadedDocument;
use App\Services\Audit\AuditLogService;
use App\Services\Student\AdmissionDocumentUploadService;
use App\Services\Student\AdmissionFormService;
use Illuminate\Http\Request;

use App\Services\Student\AdmissionPaymentService;
use App\Models\Invoice;
use Illuminate\Support\Facades\Storage;
use Auth;
use Illuminate\Support\Str;

class AdmissionController extends Controller
{
    //
    public function simulateAdmissionPayment(Request $request, AdmissionPaymentService $service)
    {
        // Only allow this in non-production modes
        if (app()->environment('production')) {
            abort(403, "Simulation not allowed in production");
        }

        $validated = $request->validate([
            'invoice_id'   => 'required|exists:invoices,id',
            'amount_paid'  => 'required|numeric|min:1',
            'reference'    => 'nullable|string|max:255',
        ]);

        $invoice = Invoice::findOrFail($validated['invoice_id']);

        // Override invoice amount if simulating partial paid
        // (optional depending on your test style)
        if ($validated['amount_paid'] != $invoice->amount) {
            $invoice->update(['amount' => $validated['amount_paid']]);
        }

        // Use your payment service to mark it paid
        $service->markInvoicePaid($invoice, $validated['reference'] ?? 'SIM-' . strtoupper(Str::random(6)));

        return response()->json([
            'success' => true,
            'message' => "Invoice {$invoice->invoice_number} marked as PAID.",
            'admission_status' => optional($invoice->application->admission)->status,
        ]);
    }

    public function dashboard()
    {
        $admission = Admission::where('user_id', auth()->id())->first();

        return view('student.admission.dashboard', compact('admission'));
    }


    public function acceptOffer()
    {
        $admission = Admission::where('user_id', auth()->id())->firstOrFail();

        if ($admission->status !== 'offer_sent') {
            return back()->with('error', 'You have already accepted your offer.');
        }
        $admission->update([
            'status' => 'offer_accepted',
            'offer_accepted_at' => now(),
        ]);
        // audit log (if you use your audit service)
//         AuditLogService::log('offer_accepted', $admission);
        return back()->with('success', 'Offer accepted successfully. Please continue with your admission form.');
    }


    public function showAdmissionForm()
    {
        $admission = Admission::with('details')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('student.admission.form', compact('admission'));
    }
    public function submitAdmissionForm(Request $request)
    {
        $admission = Admission::where('user_id', auth()->id())->firstOrFail();

        // Validation stays in request or controller (your choice)
        $validated = $request->validate([
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'parent_id_number' => 'nullable|string|max:50',
            'parent_relationship' => 'required|string|max:50',
            'parent_email' => 'nullable|email',

            'nok_name' => 'required|string|max:255',
            'nok_phone' => 'required|string|max:20',
            'nok_relationship' => 'required|string|max:50',
            'nok_address' => 'required|string|max:255',

            'religion' => 'nullable|string|max:50',
            'disability_status' => 'nullable|string|max:255',
            'chronic_illness' => 'nullable|string|max:255',
            'allergies' => 'nullable|string|max:255',

            'education_school' => 'required|string|max:255',
            'education_year' => 'required|max:4',
            'education_index_number' => 'required|string|max:50',

            'emergency_name' => 'required|string|max:255',
            'emergency_phone' => 'required|string|max:20',

            'declaration' => 'accepted'
        ]);
        $validated['declaration'] = $request->has('declaration') ? 1 : 0;

        // CALL THE SERVICE
        app(AdmissionFormService::class)
            ->saveAdmissionForm($admission, $validated);

        return redirect()
            ->route('student.admission.documents')
            ->with('success', 'Admission form submitted successfully.');
    }

    public function showDocumentsPage()
    {
        $admission = Admission::where('user_id', auth()->id())->firstOrFail();

        $docTypes = AdmissionDocumentType::where('status', 'active')->get();

        $uploaded = AdmissionUploadedDocument::where('admission_id', $admission->id)
            ->get()
            ->keyBy('document_type_id');

        return view('student.admission.documents', compact('admission','docTypes','uploaded'));
    }

    public function uploadDocuments(Request $request)
    {
        $admission = Admission::where('user_id', auth()->id())->firstOrFail();

        app(AdmissionDocumentUploadService::class)
            ->upload($admission, $request);

        return back()->with('success', 'Documents uploaded successfully.');
    }
    public function paymentPage0()
    {
        $admission = Admission::with('application.course')->where('user_id', auth()->id())->firstOrFail();

        $courseFee = $admission->application->course->cost ?? 0;

        $payments = AdmissionFeePayment::where('admission_id', $admission->id)->get();
        $totalPaid = $payments->where('status', 'paid')->sum('amount');
        $balance = $courseFee - $totalPaid;

        return view('student.admission.payment', compact('admission', 'courseFee', 'totalPaid', 'balance', 'payments'));
    }

    public function paymentPage1()
    {
        $admission = Admission::with('application.course')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $payments = AdmissionFeePayment::where('admission_id', $admission->id)->get();

        $courseFee = $admission->application->course->cost;
        $paid = $payments->where('status', 'paid')->sum('amount');
        $balance = $courseFee - $paid;

        return view('student.admission.payment.index', compact('admission','courseFee','paid','balance','payments'));
    }


    // shows payment options + balances
    public function paymentPage()
    {


        $admission = Admission::with('application.course')->where('user_id', auth()->id())->firstOrFail();

//        $courseFee = $admission->application->course->cost ?? 0;
        $courseFee = $admission->required_fee;

        $payments = \App\Models\AdmissionFeePayment::where('admission_id', $admission->id)->get();
        $totalPaid = $payments->where('status','paid')->sum('amount');
        $balance = $courseFee - $totalPaid;

        return view('student.admission.payment.index', compact('admission','courseFee','totalPaid','balance','payments'));
    }

    /**
     * Handle create invoice (from form), then redirect to iframe page
     * route: POST /student/admission/payment/create
     */
    public function createPayment(Request $request, AdmissionPaymentService $service)
    {

        $admission = Admission::where('user_id', auth()->id())->firstOrFail();

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'mode' => 'required|in:full,partial',
        ]);

        // optionally validate amount <= balance (if not sponsor/pay later)
//        $courseFee = optional($admission->application->course)->cost ?? 0;
        $courseFee=$admission->required_fee;
        $paid = \App\Models\AdmissionFeePayment::where('admission_id', $admission->id)->where('status','paid')->sum('amount');
        $balance = $courseFee - $paid;

        if ($validated['amount'] > $balance) {
            return back()->withErrors(['amount' => 'Amount cannot exceed outstanding balance.']);
        }

        $type = $validated['mode'] === 'full' ? 'full' : 'partial';
        $invoice = $service->createInvoiceForAdmission($admission, $validated['amount'], $type);

        // redirect to the payment iframe page for this invoice
        return redirect()->route('student.admission.payment.iframe', $invoice->id);
    }

    /**
     * Show payment iframe (use your ecitizen blade)
     */
    public function paymentIframe(Invoice $invoice)
    {
//        dd('Payment iframe page - integrate your payment gateway here.');
        $admission = Admission::where('id', $invoice->metadata ? data_get(json_decode($invoice->metadata,true),'admission_id') : $invoice->application->id)->first();
        // load view that contains the iframe form (see below)
        return view('student.admission.payment.iframe', compact('invoice','admission'));
    }

    /**
     * Sponsor form (GET)
     */
    public function sponsorForm()
    {
        $admission = Admission::where('user_id', auth()->id())->firstOrFail();
        return view('student.admission.payment.sponsor', compact('admission'));
    }

    /**
     * Sponsor submission (POST)
     */
    public function sponsorSubmit(Request $request, AdmissionPaymentService $service)
    {
        $admission = Admission::where('user_id', auth()->id())->firstOrFail();

        $validated = $request->validate([
            'sponsor_name' => 'required|string|max:255',
            'sponsor_letter' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'amount' => 'nullable|numeric|min:0'
        ]);

        $path = null;
        if ($request->hasFile('sponsor_letter')) {
            $path = $request->file('sponsor_letter')->store("admissions/{$admission->id}/sponsors", 'public');
        }

        $rec = $service->createNonInvoicePayment($admission, [
            'payment_type' => 'sponsor',
            'sponsor_name' => $validated['sponsor_name'],
            'sponsor_letter' => $path,
            'amount' => $validated['amount'] ?? 0,
        ]);

        return redirect()->route('student.admission.payment')->with('success','Sponsor record submitted. Accounts will verify.');
    }

    /**
     * Pay later form (GET + POST)
     */
    public function payLaterForm()
    {
        $admission = Admission::where('user_id', auth()->id())->firstOrFail();
        return view('student.admission.payment.paylater', compact('admission'));
    }

    public function payLaterSubmit(Request $request, AdmissionPaymentService $service)
    {
        $admission = Admission::where('user_id', auth()->id())->firstOrFail();

        $validated = $request->validate([
            'explanation' => 'required|string|max:2000',
        ]);

        $rec = $service->createNonInvoicePayment($admission, [
            'payment_type' => 'pay_later',
            'explanation' => $validated['explanation'],
            'amount' => 0
        ]);

        return redirect()->route('student.admission.payment')->with('success','Pay-later request submitted.');
    }

    /**
     * Payment callback / simulation endpoint manually call to mark invoice paid (safe for dev)
     * POST /student/admission/payment/callback (or use GET for a quick simulate)
     */
    public function paymentCallback(Request $request, AdmissionPaymentService $service)
    {
        // Example: pass invoice_id and gateway_ref. In production you'd validate signature
        $invoiceId = $request->input('invoice_id');
        $gatewayRef = $request->input('gateway_reference', null);

        $invoice = Invoice::findOrFail($invoiceId);

        $service->markInvoicePaid($invoice, $gatewayRef);

        return redirect()->route('student.admission.payment')->with('success','Payment registered (simulated).');
    }

}
