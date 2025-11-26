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
        $user      = Auth::user();
        $search    = $request->input('search');
        $status    = $request->input('status');
        $courseId  = $request->input('course_id');
        $collegeId = $request->input('college_id'); // campus filter (for superadmin & kihbt_registrar)

        $isSuper = $user->hasRole('superadmin');
        $isHq    = $user->hasRole('kihbt_registrar'); // HQ registrar sees ALL campuses

        $trainings = Training::with(['course', 'college', 'user'])
            // 🔎 Search by course name/code
            ->when($search, function ($q) use ($search) {
                $q->whereHas('course', function ($cq) use ($search) {
                    $cq->where('course_name', 'like', "%{$search}%")
                        ->orWhere('course_code', 'like', "%{$search}%");
                });
            })
            // 📌 Status filter
            ->when($status, function ($q) use ($status) {
                $q->where('status', $status);
            })
            // 📌 Course filter
            ->when($courseId, function ($q) use ($courseId) {
                $q->where('course_id', $courseId);
            })
            // 🏫 Superadmin & KIHBT registrar: optional campus filter from request
            ->when(($isSuper || $isHq) && $collegeId, function ($q) use ($collegeId) {
                $q->where('college_id', $collegeId);
            })
            // 🏫 All other roles: force to own campus
            ->when(!$isSuper && !$isHq && $user->campus_id, function ($q) use ($user) {
                $q->where('college_id', $user->campus_id);
            })
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        $courses = Course::orderBy('course_name')->get();

        // 🔹 Campus list:
        //     - Superadmin & KIHBT Registrar: all campuses + campus filter dropdown
        //     - Others: only their own campus, and no real filter visual effect
        if ($isSuper || $isHq) {
            $colleges = College::orderBy('name')->get();
        } else {
            $colleges = College::where('id', $user->campus_id)->get();
        }

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
            'courseId',
            'collegeId'
        ));
    }


    /**
     * Show the form for creating a new training.
     * Only HOD & superadmin.
     */
    public function create()
    {
        $user = Auth::user();

        if (! $user->hasAnyRole(['hod', 'superadmin'])) {
            abort(403);
        }

        // If SUPERADMIN → see all courses
        if ($user->hasRole('superadmin')) {
            $courses = Course::orderBy('course_name')->get();
        } else {
            // HOD / others → only courses for their campus
            $courses = Course::where('college_id', $user->campus_id)
                ->orderBy('course_name')
                ->get();
        }

        // no need for $colleges anymore here
        return view('admin.trainings.create', compact('courses'));
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
            'course_id'   => 'required|exists:courses,id',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'cost'        => 'required|numeric|min:0',
            // ❌ REMOVE validation for college_id
        ]);

        $user = Auth::user();

        // Ensure user has campus_id set
        if (! $user->campus_id) {
            return back()
                ->withErrors(['campus_id' => 'Your account is not linked to any campus. Contact the system administrator.'])
                ->withInput();
        }

        $data['user_id']    = $user->id;
        $data['college_id'] = $user->campus_id;   // 👈 auto assign campus of logged-in user
        $data['status']     = Training::STATUS_DRAFT;

        Training::create($data);

        return redirect()
            ->route('all.trainings')
            ->with('success', 'Training created as Draft.');
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

        if ($user->hasRole('superadmin')) {
            $courses = Course::orderBy('course_name')->get();
        } else {
            $courses = Course::where('college_id', $user->campus_id)
                ->orderBy('course_name')
                ->get();
        }

        return view('admin.trainings.edit', compact('training', 'courses'));
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
           // 'cost'       => 'required|numeric|min:0',
        ]);

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

        // Clear old rejection info when resubmitting
        $training->status            = Training::STATUS_PENDING_REGISTRAR;
        $training->rejection_comment = null;
        $training->rejection_stage   = null;
        $training->rejected_by       = null;
        $training->rejected_at       = null;
        $training->save();

        return back()->with('success', 'Training sent to Campus Registrar for approval.');
    }

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

        if (! $user->hasAnyRole(['kihbt_registrar', 'superadmin'])) {
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
        // Clear rejection info if any left
        $training->rejection_comment = null;
        $training->rejection_stage   = null;
        $training->rejected_by       = null;
        $training->rejected_at       = null;
        $training->save();

        return back()->with('success', 'Training approved and sent to HQ for review.');
    }

    /**
     * Campus Registrar: reject back to HOD with comment.
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

        $data = $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $this->rejectTraining($training, 'campus_registrar', $data['reason'], $user->id);

        return back()->with('success', 'Training rejected and returned to HOD with comments.');
    }

    /**
     * KIHBT Registrar (HQ): approve → HQ Reviewed.
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
        $training->rejection_comment = null;
        $training->rejection_stage   = null;
        $training->rejected_by       = null;
        $training->rejected_at       = null;
        $training->save();

        return back()->with('success', 'Training marked as HQ Reviewed.');
    }

    /**
     * KIHBT Registrar (HQ): reject back to HOD with comment.
     */
    public function hqReject(Request $request, Training $training)
    {
        $user = auth()->user();

        if (! $user->hasAnyRole(['kihbt_registrar', 'superadmin'])) {
            abort(403);
        }

        if ($training->status !== Training::STATUS_REGISTRAR_APPROVED_HQ) {
            return back()->with('error', 'Only Registrar-approved trainings can be rejected by HQ.');
        }

        $data = $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $this->rejectTraining($training, 'kihbt_registrar', $data['reason'], $user->id);

        return back()->with('success', 'Training rejected by HQ and returned to HOD with comments.');
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
        $training->rejection_comment = null;
        $training->rejection_stage   = null;
        $training->rejected_by       = null;
        $training->rejected_at       = null;
        $training->save();

        return back()->with('success', 'Training finally approved.');
    }

    /**
     * Director: final rejection (while under HQ review or just after Registrar approval).
     */
    public function directorReject(Request $request, Training $training)
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

        $data = $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $this->rejectTraining($training, 'director', $data['reason'], $user->id);

        return back()->with('success', 'Training rejected by Director and returned to HOD with comments.');
    }

    /**
     * Shared helper to handle rejections with comments.
     */
    protected function rejectTraining(Training $training, string $stage, string $reason, int $userId): void
    {
        $training->status            = Training::STATUS_REJECTED;
        $training->rejection_comment = $reason;
        $training->rejection_stage   = $stage;
        $training->rejected_by       = $userId;
        $training->rejected_at       = now();
        $training->save();
    }
}
