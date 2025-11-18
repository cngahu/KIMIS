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
            'cost'        => 'required|numeric|min:0',
        ]);

        // Link to logged-in user
        $data['user_id'] = Auth::id();
        $data['status'] = 'Pending';

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
        $data = $request->validate([
            'course_id'   => 'required|exists:courses,id',
            'college_id'  => 'required|exists:colleges,id',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'status'      => 'nullable|string|max:50', // or 'required|in:Pending,Active,Completed,Cancelled'
            'cost'        => 'required|numeric|min:0',
        ]);

        // Optionally update user_id to "last edited by"
        $data['user_id'] = Auth::id();

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
}
