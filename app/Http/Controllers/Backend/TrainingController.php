<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\Course;
use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display a listing of the trainings.
     */
    public function index(Request $request)
    {
        $search  = $request->input('search');
        $status  = $request->input('status');
        $course  = $request->input('course_id');
        $college = $request->input('college_id');

        $trainings = Training::with(['course', 'college', 'user'])
            ->when($search, function ($q) use ($search) {
                $q->whereHas('course', function ($cq) use ($search) {
                    $cq->where('course_name', 'like', "%{$search}%")
                        ->orWhere('course_code', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->when($course, function ($q) use ($course) {
                $q->where('course_id', $course);
            })
            ->when($college, function ($q) use ($college) {
                $q->where('college_id', $college);
            })
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        $courses  = Course::orderBy('course_name')->get();
        $colleges = College::orderBy('name')->get();

        // Statuses used in filters
        $statuses = [
            Training::STATUS_DRAFT,
            Training::STATUS_PENDING_REGISTRAR,
            Training::STATUS_REGISTRAR_APPROVED_HQ,
            Training::STATUS_HQ_REVIEWED,
            Training::STATUS_APPROVED,
            Training::STATUS_REJECTED,
        ];

        return view('admin.trainings.index', compact(
            'trainings',
            'courses',
            'colleges',
            'statuses',
            'search',
            'status',
            'course',
            'college'
        ));
    }

    /**
     * Show the form for creating a new training.
     * Only HOD & superadmin.
     */
    public function create()
    {
        if (! Auth::user()->hasAnyRole(['hod', 'superadmin'])) {
            abort(403);
        }

        $courses  = Course::orderBy('course_name')->get();
        $colleges = College::orderBy('name')->get();

        return view('admin.trainings.create', compact('courses', 'colleges'));
    }

    /**
     * Store a newly created training in storage.
     * Saved as Draft.
     */
    public function store(Request $request)
    {
        if (! Auth::user()->hasAnyRole(['hod', 'superadmin'])) {
            abort(403);
        }

        $data = $request->validate([
            'course_id'  => 'required|exists:courses,id',
            'college_id' => 'required|exists:colleges,id',
            'start_date' => 'required|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'cost'       => 'required|numeric|min:0',
        ]);

        $data['user_id'] = Auth::id();
        $data['status']  = Training::STATUS_DRAFT;

        $training = Training::create($data);

        return redirect()
            ->route('trainings.edit', $training)
            ->with('success', 'Training created as Draft. You can now review and send for approval.');
    }

    /**
     * Display the specified training.
     */
    public function show(Training $training)
    {
        $training->load(['course', 'college', 'user']);

        return view('admin.trainings.show', compact('training'));
    }

    /**
     * Show the form for editing the specified training.
     * HOD can edit only Draft/Rejected, superadmin any.
     */
    public function edit(Training $training)
    {
        $user = Auth::user();

        if (! $user->hasAnyRole(['hod', 'superadmin'])) {
            abort(403);
        }

        if ($user->hasRole('hod') && ! $training->isEditableByHod()) {
            return redirect()
                ->route('trainings.show', $training)
                ->with('error', 'You cannot edit this training once it has been submitted for approval.');
        }

        $courses  = Course::orderBy('course_name')->get();
        $colleges = College::orderBy('name')->get();

        return view('admin.trainings.edit', compact('training', 'courses', 'colleges'));
    }

    /**
     * Update the specified training in storage.
     */
    public function update(Request $request, Training $training)
    {
        $user = Auth::user();

        if (! $user->hasAnyRole(['hod', 'superadmin'])) {
            abort(403);
        }

        if ($user->hasRole('hod') && ! $training->isEditableByHod()) {
            return redirect()
                ->route('trainings.show', $training)
                ->with('error', 'You cannot update this training once it has been submitted for approval.');
        }

        $data = $request->validate([
            'course_id'  => 'required|exists:courses,id',
            'college_id' => 'required|exists:colleges,id',
            'start_date' => 'required|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'cost'       => 'required|numeric|min:0',
        ]);

        // Optionally track last edited by
        $data['user_id'] = Auth::id();

        $training->update($data);

        return redirect()
            ->route('trainings.show', $training)
            ->with('success', 'Training updated successfully.');
    }

    /**
     * Remove the specified training from storage.
     * HOD only Draft/Rejected; superadmin any.
     */
    public function destroy(Training $training)
    {
        $user = Auth::user();

        if (! $user->hasAnyRole(['hod', 'superadmin'])) {
            abort(403);
        }

        if ($user->hasRole('hod') && ! $training->isEditableByHod()) {
            return back()->with('error', 'You cannot delete this training once it has been submitted for approval.');
        }

        $training->delete();

        return redirect()
            ->route('all.trainings')
            ->with('success', 'Training deleted successfully.');
    }

    /**
     * HOD: send Draft/Rejected training for Registrar approval.
     */
    public function sendForApproval(Training $training)
    {
        $user = Auth::user();

        if (! $user->hasAnyRole(['hod', 'superadmin'])) {
            abort(403, 'Only HOD can submit trainings for approval.');
        }

        if (! $training->isEditableByHod()) {
            return back()->with('error', 'Only Draft or Rejected trainings can be submitted for approval.');
        }

        $training->status = Training::STATUS_PENDING_REGISTRAR;
        $training->save();

        return back()->with('success', 'Training sent to Campus Registrar for approval.');
    }

    /**
     * Backwards-compat: if you already wired a route to submitForApproval,
     * we just forward to sendForApproval().
     */
    public function submitForApproval(Training $training)
    {
        return $this->sendForApproval($training);
    }

    /**
     * Registrar inbox – list trainings waiting Registrar approval.
     */
    public function registrarIndex(Request $request)
    {
        $user = auth()->user();

        if (! $user->hasAnyRole(['campus_registrar', 'kihbt_registrar', 'superadmin'])) {
            abort(403);
        }

        $trainings = Training::with(['course', 'college', 'user'])
            ->where('status', Training::STATUS_PENDING_REGISTRAR)
            ->orderBy('start_date', 'asc')
            ->paginate(15);

        return view('admin.trainings.registrar_index', compact('trainings'));
    }

    public function hqregistrarIndex(Request $request)
    {
        $user = auth()->user();

        if (! $user->hasAnyRole(['kihbt_registrar', 'kihbt_registrar', 'superadmin'])) {
            abort(403);
        }

        $trainings = Training::with(['course', 'college', 'user'])
            ->where('status', Training::STATUS_REGISTRAR_APPROVED_HQ)
            ->orderBy('start_date', 'asc')
            ->paginate(15);

        return view('admin.trainings.hqregistrar_index', compact('trainings'));
    }

    public function directorregistrarIndex(Request $request)
    {
        $user = auth()->user();

        if (! $user->hasAnyRole(['director', 'superadmin'])) {
            abort(403);
        }

        $trainings = Training::with(['course', 'college', 'user'])
            ->where('status', Training::STATUS_HQ_REVIEWED)
            ->orderBy('start_date', 'asc')
            ->paginate(15);

        return view('admin.trainings.drregistrar_index', compact('trainings'));
    }

    /**
     * Campus Registrar: approve → send to HQ.
     */
    public function registrarApprove(Training $training)
    {
        $user = auth()->user();

        if (! $user->hasAnyRole(['campus_registrar', 'superadmin'])) {
            abort(403);
        }

        if ($training->status !== Training::STATUS_PENDING_REGISTRAR) {
            return back()->with('error', 'Only trainings pending Registrar approval can be approved.');
        }

        $training->status = Training::STATUS_REGISTRAR_APPROVED_HQ;
        $training->save();

        return back()->with('success', 'Training approved and sent to HQ for review.');
    }

    /**
     * Campus Registrar: reject back to HOD.
     */
    public function registrarReject(Request $request, Training $training)
    {
        $user = auth()->user();

        if (! $user->hasAnyRole(['campus_registrar', 'superadmin'])) {
            abort(403);
        }

        if ($training->status !== Training::STATUS_PENDING_REGISTRAR) {
            return back()->with('error', 'Only trainings pending Registrar approval can be rejected.');
        }

        // If you later add a 'rejection_reason' column:
        // $request->validate(['reason' => 'nullable|string|max:1000']);
        // $training->rejection_reason = $request->input('reason');

        $training->status = Training::STATUS_REJECTED;
        $training->save();

        return back()->with('success', 'Training rejected and returned to HOD.');
    }

    /**
     * KIHBT Registrar (HQ): mark as HQ Reviewed.
     */
    public function hqReview(Training $training)
    {
        $user = auth()->user();

        if (! $user->hasAnyRole(['kihbt_registrar', 'superadmin'])) {
            abort(403);
        }

        if ($training->status !== Training::STATUS_REGISTRAR_APPROVED_HQ) {
            return back()->with('error', 'Only Registrar-approved trainings can be reviewed by HQ.');
        }

        $training->status = Training::STATUS_HQ_REVIEWED;
        $training->save();

        return back()->with('success', 'Training marked as HQ Reviewed.');
    }

    /**
     * Director: final approval after HQ review.
     */
    public function directorApprove(Training $training)
    {
        $user = auth()->user();

        if (! $user->hasAnyRole(['director', 'superadmin'])) {
            abort(403);
        }

        if ($training->status !== Training::STATUS_HQ_REVIEWED) {
            return back()->with('error', 'Only HQ Reviewed trainings can be finally approved.');
        }

        $training->status = Training::STATUS_APPROVED;
        $training->save();

        return back()->with('success', 'Training finally approved.');
    }

    /**
     * Director: final rejection (while under HQ review).
     */
    public function directorReject(Training $training)
    {
        $user = auth()->user();

        if (! $user->hasAnyRole(['director', 'superadmin'])) {
            abort(403);
        }

        if (! in_array($training->status, [
            Training::STATUS_REGISTRAR_APPROVED_HQ,
            Training::STATUS_HQ_REVIEWED,
        ], true)) {
            return back()->with('error', 'Only trainings under HQ review can be rejected by the Director.');
        }

        $training->status = Training::STATUS_REJECTED;
        $training->save();

        return back()->with('success', 'Training rejected by Director.');
    }
}
