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
    /**
     * Display a listing of the trainings.
     */
    public function index(Request $request)
    {
        // Optional simple filters (can be expanded later)
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
        $statuses = ['Pending', 'Active', 'Completed', 'Cancelled'];

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
     */
    public function create()
    {
        $courses  = Course::orderBy('course_name')->get();
        $colleges = College::orderBy('name')->get();
        $statuses = ['Pending', 'Active', 'Completed', 'Cancelled'];

        return view('admin.trainings.create', compact('courses', 'colleges', 'statuses'));
    }

    /**
     * Store a newly created training in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id'   => 'required|exists:courses,id',
            'college_id'  => 'required|exists:colleges,id',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'status'      => 'nullable|string|max:50', // or 'required|in:Pending,Active,Completed,Cancelled'

        ]);

        // Link to logged-in user
        $data['user_id'] = Auth::id();
        $data['status'] = \App\Models\Training::STATUS_DRAFT;

        Training::create($data);

        return redirect()
            ->route('all.trainings')
            ->with('success', 'Training created successfully.');
    }

    /**
     * Display the specified training.
     */
    public function show(Training $training)
    {
        // Eager load relations if not already
        $training->load(['course', 'college', 'user']);

        return view('admin.trainings.show', compact('training'));
    }

    /**
     * Show the form for editing the specified training.
     */
    public function edit(Training $training)
    {
        $courses  = Course::orderBy('course_name')->get();
        $colleges = College::orderBy('name')->get();
        $statuses = ['Pending', 'Active', 'Completed', 'Cancelled'];

        return view('admin.trainings.edit', compact('training', 'courses', 'colleges', 'statuses'));
    }

    /**
     * Update the specified training in storage.
     */
    public function update(Request $request, Training $training)
    {
        $user = Auth::user();
        if ($user->hasRole('hod') &&
            $training->status !== Training::STATUS_DRAFT) {

            return redirect()
                ->route('all.trainings')
                ->with('error', 'You cannot edit this training once it has been submitted for approval.');
        }

        $data = $request->validate([
            'course_id'   => 'required|exists:courses,id',
            'college_id'  => 'required|exists:colleges,id',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'status'      => 'nullable|string|max:50', // or 'required|in:Pending,Active,Completed,Cancelled'

        ]);

        // Optionally update user_id to "last edited by"
        $data['user_id'] = $user;

        $training->update($data);

        return redirect()
            ->route('trainings.index')
            ->with('success', 'Training updated successfully.');
    }

    /**
     * Remove the specified training from storage.
     */
    public function destroy(Training $training)
    {
        $training->delete();

        return redirect()
            ->route('all.trainings')
            ->with('success', 'Training deleted successfully.');
    }

    public function submitForApproval(Training $training)
    {
        $user = Auth::user();

        // Only HOD can submit (adjust as you like)
        if (! $user->hasRole('hod')) {
            abort(403, 'Only HOD can submit trainings for approval.');
        }

        // Only Draft trainings can be submitted
        if ($training->status !== Training::STATUS_DRAFT) {
            return back()->with('error', 'Only trainings in Draft status can be submitted for approval.');
        }

        $training->status = Training::STATUS_PENDING_REGISTRAR;
        // Optional tracking fields if you have them:
        // $training->submitted_by = $user->id;
        // $training->submitted_at = now();
        $training->save();

        return back()->with('success', 'Training sent to Registrar for approval.');
    }

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
}
