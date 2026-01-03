<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\Course;
use App\Models\College;
use App\Models\TrainingRejection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display a listing of trainings with role-based visibility.
     */
    public function index(Request $request)
    {
        $user      = Auth::user();
        $search    = $request->input('search');
        $status    = $request->input('status');
        $courseId  = $request->input('course_id');
        $collegeId = $request->input('college_id'); // campus filter (for superadmin & kihbt_registrar)

        $isSuper = $user->hasRole('superadmin');
        $isHq    = $user->hasRole('kihbt_registrar');
        $isHod   = $user->hasRole('hod');

        $trainingsQuery = Training::with(['course', 'college', 'user'])
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
            });

        /**
         * ✅ VISIBILITY RULES
         */
        if ($isSuper || $isHq) {
            // Superadmin/HQ can optionally filter by campus
            if ($collegeId) {
                $trainingsQuery->where('college_id', $collegeId);
            }
        } elseif ($isHod) {
            // HOD sees ONLY assigned course trainings (+ optional campus restriction)
            $assignedCourseIds = $user->courses()->pluck('courses.id')->toArray();

            // If HOD has no assigned courses, show none
            $trainingsQuery->whereIn('course_id', $assignedCourseIds ?: [-1]);

            if ($user->campus_id) {
                $trainingsQuery->where('college_id', $user->campus_id);
            }
        } else {
            // Other roles: force campus
            if ($user->campus_id) {
                $trainingsQuery->where('college_id', $user->campus_id);
            } else {
                // no campus linked → show none (or you can abort)
                $trainingsQuery->whereRaw('1=0');
            }
        }

        $trainings = $trainingsQuery
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        /**
         * ✅ Filter dropdown data (courses + colleges) should also respect role
         */
        if ($isSuper || $isHq) {
            $courses  = Course::orderBy('course_name')->get();
            $colleges = College::orderBy('name')->get();
        } elseif ($isHod) {
            $courses  = $user->courses()->orderBy('course_name')->get();
            $colleges = College::where('id', $user->campus_id)->get();
        } else {
            $courses  = Course::where('college_id', $user->campus_id)->orderBy('course_name')->get();
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

    public function longTerm(Request $request)
    {
        $search   = $request->input('search');
        $campusId = $request->input('college_id');

        $trainings = Training::with(['course.requirements', 'college'])
            ->where('status', 'Approved')
            ->whereHas('course', fn($q) => $q->where('course_mode', 'Long Term'))
            ->when($search, function ($q) use ($search) {
                $q->whereHas('course', function ($courseQuery) use ($search) {
                    $courseQuery->where('course_name', 'like', "%{$search}%")
                        ->orWhere('course_code', 'like', "%{$search}%");
                });
            })
            ->when($campusId, fn($q) => $q->where('college_id', $campusId))
            ->orderBy('start_date', 'asc')
            ->paginate(9)
            ->appends($request->query());

        $colleges = \App\Models\College::orderBy('name')->get();

        return view('training_long_term', compact('trainings', 'colleges', 'search', 'campusId'));
    }

    public function shortTerm(Request $request)
    {
        $search   = $request->input('search');
        $campusId = $request->input('college_id');

        $trainings = Training::with(['course.requirements', 'college'])
            ->where('status', 'Approved')
            ->whereHas('course', fn($q) => $q->where('course_mode', 'Short Term'))
            ->when($search, function ($q) use ($search) {
                $q->whereHas('course', function ($courseQuery) use ($search) {
                    $courseQuery->where('course_name', 'like', "%{$search}%")
                        ->orWhere('course_code', 'like', "%{$search}%");
                });
            })
            ->when($campusId, fn($q) => $q->where('college_id', $campusId))
            ->orderBy('start_date', 'asc')
            ->paginate(9)
            ->appends($request->query());

        $colleges = \App\Models\College::orderBy('name')->get();

        return view('training_short_term', compact('trainings', 'colleges', 'search', 'campusId'));
    }




    /**
     * Show the form for creating a new training.
     * Only HOD & superadmin.
     */
    public function create()
    {
        $user = Auth::user();

        if (!$user->hasAnyRole(['hod', 'superadmin'])) {
            abort(403);
        }

        if ($user->hasRole('superadmin')) {
            $courses = Course::orderBy('course_name')->where('course_mode','Short Term')->get();
        } else {
            // ✅ only assigned courses
            $courses = $user->courses()->orderBy('course_name')->where('course_mode','Short Term')->get();
        }

        return view('admin.trainings.create', compact('courses'));
    }

    /**
     * Store a newly created training in storage.
     * Saved as Draft.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasAnyRole(['hod', 'superadmin'])) {
            abort(403);
        }

        $data = $request->validate([
            'course_id'  => 'required|exists:courses,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'cost'       => 'required|numeric|min:0',
        ]);

        // Ensure campus_id exists for non-superadmin
        if (!$user->hasRole('superadmin') && !$user->campus_id) {
            return back()
                ->withErrors(['campus_id' => 'Your account is not linked to any campus. Contact the system administrator.'])
                ->withInput();
        }

        // ✅ HOD can only create for assigned courses
        if ($user->hasRole('hod')) {
            $isAssigned = $user->courses()->where('courses.id', $data['course_id'])->exists();
            if (!$isAssigned) {
                return back()->withErrors(['course_id' => 'You are not assigned to that course.'])->withInput();
            }
        }

        $data['user_id']    = $user->id;
        $data['college_id'] = $user->hasRole('superadmin')
            ? (Course::find($data['course_id'])->college_id ?? null) // optional: use course college
            : $user->campus_id;

//        $data['status'] = Training::STATUS_DRAFT;
        $data['status'] = Training::STATUS_APPROVED;

        Training::create($data);

        return redirect()
            ->route('all.trainings')
            ->with('success', 'Training created as Draft.');
    }

    /**
     * Display the specified training.
     * (Optional: add visibility check if needed)
     */
//    public function show(Training $training)
//    {
//        $training->load([
//            'course',
//            'college',
//            'user',
//            'rejections.rejectedByUser',
//        ]);
//
//        return view('admin.trainings.show', compact('training'));
//    }

    public function show(Training $training)
    {
        $training->load([
            'course',
            'college',
            'user',
            'rejections.rejectedByUser',

            // ✅ approvers (add these relationships in Training model)
            'hodApprover',
            'registrarApprover',
            'kihbtRegistrarApprover',
            'directorApprover',
        ]);

        return view('admin.trainings.show', compact('training'));
    }


    /**
     * Show the form for editing the specified training.
     */
    public function edit(Training $training)
    {
        $user = Auth::user();

        if (!$user->hasAnyRole(['hod', 'superadmin'])) {
            abort(403);
        }

        if ($user->hasRole('superadmin')) {
            $courses = Course::orderBy('course_name')->get();
        } else {
            $courses = $user->courses()->orderBy('course_name')->get();
        }

        return view('admin.trainings.edit', compact('training', 'courses'));
    }

    /**
     * Update the specified training.
     */
    public function update(Request $request, Training $training)
    {
        $user = Auth::user();

        if (!$user->hasAnyRole(['hod', 'superadmin'])) {
            abort(403);
        }

        if ($user->hasRole('hod') && !$training->isEditableByHod()) {
            return redirect()
                ->route('trainings.show', $training)
                ->with('error', 'You cannot update this training once it has been submitted for approval.');
        }

        $data = $request->validate([
            'course_id'  => 'required|exists:courses,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            // 'cost'    => 'required|numeric|min:0',
        ]);

        // ✅ HOD can only update to assigned courses
        if ($user->hasRole('hod')) {
            $isAssigned = $user->courses()->where('courses.id', $data['course_id'])->exists();
            if (!$isAssigned) {
                return back()->withErrors(['course_id' => 'You are not assigned to that course.'])->withInput();
            }
        }

        $data['user_id']    = $user->id;
        $data['college_id'] = $user->hasRole('superadmin')
            ? ($training->college_id) // keep existing college (or compute from course)
            : $user->campus_id;

        $training->update($data);

        return redirect()
            ->route('trainings.show', $training)
            ->with('success', 'Training updated successfully.');
    }

    /**
     * Remove the specified training.
     */
    public function destroy(Training $training)
    {
        $user = Auth::user();

        if (!$user->hasAnyRole(['hod', 'superadmin'])) {
            abort(403);
        }

        if ($user->hasRole('hod') && !$training->isEditableByHod()) {
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

        if (!$user->hasAnyRole(['hod', 'superadmin'])) {
            abort(403, 'Only HOD can submit trainings for approval.');
        }

        if (!$training->isEditableByHod()) {
            return back()->with('error', 'Only Draft or Rejected trainings can be submitted for approval.');
        }

        // Capture HOD approver id
        if ($user->hasRole('hod')) {
            $this->setApprover($training, 'hod');
        }

        $training->status            = Training::STATUS_PENDING_REGISTRAR;

        // Clear old rejection info when resubmitting
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

        if (!$user->hasAnyRole(['campus_registrar', 'kihbt_registrar', 'superadmin'])) {
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

        if (!$user->hasAnyRole(['kihbt_registrar', 'superadmin'])) {
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

        if (!$user->hasAnyRole(['director', 'superadmin'])) {
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

        if (!$user->hasAnyRole(['campus_registrar', 'superadmin'])) {
            abort(403);
        }

        if ($training->status !== Training::STATUS_PENDING_REGISTRAR) {
            return back()->with('error', 'Only trainings pending Registrar approval can be approved.');
        }

        // Capture Registrar approver id
        if ($user->hasRole('campus_registrar')) {
            $this->setApprover($training, 'campus_registrar');
        }

        $training->status = Training::STATUS_REGISTRAR_APPROVED_HQ;

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

        if (!$user->hasAnyRole(['campus_registrar', 'superadmin'])) {
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

        if (!$user->hasAnyRole(['kihbt_registrar', 'superadmin'])) {
            abort(403);
        }

        if ($training->status !== Training::STATUS_REGISTRAR_APPROVED_HQ) {
            return back()->with('error', 'Only Registrar-approved trainings can be reviewed by HQ.');
        }

        // Capture HQ Registrar approver id
        if ($user->hasRole('kihbt_registrar')) {
            $this->setApprover($training, 'kihbt_registrar');
        }

        $training->status = Training::STATUS_HQ_REVIEWED;

        $training->rejection_comment = null;
        $training->rejection_stage   = null;
        $training->rejected_by       = null;
        $training->rejected_at       = null;

        $training->save();

        return back()->with('success', 'Training marked as HQ Reviewed.');
    }

    public function hqReject(Request $request, Training $training)
    {
        $user = auth()->user();

        if (!$user->hasAnyRole(['kihbt_registrar', 'superadmin'])) {
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

        if (!$user->hasAnyRole(['director', 'superadmin'])) {
            abort(403);
        }

        if ($training->status !== Training::STATUS_HQ_REVIEWED) {
            return back()->with('error', 'Only HQ Reviewed trainings can be finally approved.');
        }

        DB::transaction(function () use ($training, $user) {

            // Capture Director approver id
            if ($user->hasRole('director')) {
                $this->setApprover($training, 'director');
            }

            if (empty($training->series_code)) {
                $training->series_code = $this->generateSeriesCode($training);
            }

            $training->status            = Training::STATUS_APPROVED;
            $training->rejection_comment = null;
            $training->rejection_stage   = null;
            $training->rejected_by       = null;
            $training->rejected_at       = null;

            $training->save();
        });

        return back()->with('success', 'Training finally approved.');
    }

    public function directorReject(Request $request, Training $training)
    {
        $user = auth()->user();

        if (!$user->hasAnyRole(['director', 'superadmin'])) {
            abort(403);
        }

        if (!in_array($training->status, [
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

    protected function generateSeriesCode(Training $training): string
    {
        $training->loadMissing('course');

        if (!$training->course || !$training->course->course_code) {
            throw new \RuntimeException('Course or course_code is missing for this training.');
        }

        $year   = now()->year;
        $prefix = $training->course->course_code . '/' . $year . '/';

        $lastSeries = Training::where('course_id', $training->course_id)
            ->whereNotNull('series_code')
            ->where('series_code', 'like', $prefix . '%')
            ->orderBy('series_code', 'desc')
            ->lockForUpdate()
            ->value('series_code');

        $nextNumber = 1;

        if ($lastSeries) {
            $lastNumber = (int) substr($lastSeries, strrpos($lastSeries, '/') + 1);
            $nextNumber = $lastNumber + 1;
        }

        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
    protected function setApprover(Training $training, string $stageRole): void
    {
        $userId = auth()->id();

        // Only set once (don’t overwrite who approved earlier)
        switch ($stageRole) {
            case 'hod':
                $training->hod_approver_id ??= $userId;
                break;

            case 'campus_registrar':
                $training->registrar_approver_id ??= $userId;
                break;

            case 'kihbt_registrar':
                $training->kihbt_registrar_approver_id ??= $userId;
                break;

            case 'director':
                $training->director_approver_id ??= $userId;
                break;
        }
    }
    protected function rejectTraining(Training $training, string $stage, string $reason, int $userId): void
    {
        DB::transaction(function () use ($training, $stage, $reason, $userId) {

            TrainingRejection::create([
                'training_id' => $training->id,
                'rejected_by' => $userId,
                'stage'       => $stage,
                'reason'      => $reason,
                'rejected_at' => now(),
            ]);

            $training->status            = Training::STATUS_REJECTED;
            $training->rejection_comment = $reason;
            $training->rejection_stage   = $stage;
            $training->rejected_by       = $userId;
            $training->rejected_at       = now();
            $training->save();
        });
    }
}
