<?php

namespace App\Http\Controllers\Registrar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admission;
use App\Services\Admin\DocumentVerificationService;

class DocumentVerificationController extends Controller
{
    //

    protected DocumentVerificationService $svc;

    public function __construct(DocumentVerificationService $svc)
    {
        $this->svc = $svc;
    }

    public function index()
    {
        $students = Admission::with(['application.course'])
            ->whereIn('status', ['fee_pending', 'awaiting_fee_decision', 'fee_paid','awaiting_sponsor_verification'])
            ->paginate(50);

        return view('admin.registrar.verification.index', compact('students'));
    }

    public function show(Admission $admission)
    {
        $data = $this->svc->buildStudentVerificationData($admission);

        return view('admin.registrar.verification.show', $data);
    }

    public function approve(Request $request, Admission $admission)
    {
        $this->svc->approve($admission, $request);

        return redirect()->route('registrar.verification.index')
            ->with('success', 'Documents verified and approved successfully.');
    }

    public function reject(Request $request, Admission $admission)
    {
        $this->svc->reject($admission, $request);

        return redirect()->back()
            ->with('error', 'Documents rejected. Student notified.');
    }

    public function verifyDocument(Request $request, Admission $admission)
    {
        $this->svc->verifyDocuments($admission, $request);

        return back()->with('success', 'Document verification saved successfully.');
    }

    public function verifyDocument1(Request $request, Admission $admission)
    {
        $request->validate([
            'doc_id' => 'required|integer',
            'action' => 'required|in:approved,rejected,pending_fix',
            'comment' => 'nullable|string'
        ]);

        $this->svc->verifyDocument($admission, $request->doc_id, $request->action, $request->comment);

        return back()->with('success', 'Document verification updated.');
    }

    public function finalize(Admission $admission)
    {
        $result = $this->svc->finalizeVerification($admission);

        return back()->with('success', "Verification outcome: $result");
    }
}
