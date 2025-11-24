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

class AdmissionController extends Controller
{
    //

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
         AuditLogService::log('offer_accepted', $admission);
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

    public function paymentPage()
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

}
