<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Student;
use App\Models\User;
use App\Models\CourseStage;
use App\Models\StudentCycleRegistration;
use App\Models\Invoice;

class StudentProfileController extends Controller
{
    /**
     * Show the student profile page
     * Passes ALL variables required by the shared dashboard layout
     */
    public function showProfile()
    {
        $user = Auth::user();

        $student = Student::with(['course.stages', 'campus', 'enrollments'])
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Latest enrollment
        $enrollment = $student->enrollments()->latest()->first();

        // Current cycle
        $cycle = [
            'year' => $enrollment?->year ?? now()->year,
            'term' => $enrollment?->term ?? 'Term 1',
        ];

        // Cycle registration
        $cycle_registration = StudentCycleRegistration::where('student_id', $student->id)
            ->where('cycle_year', $cycle['year'])
            ->where('cycle_term', $cycle['term'])
            ->first();

        // Course timeline (ordered stages)
        $timeline = collect();
        if ($student->course) {
            $timeline = $student->course->stages()
                ->orderBy('course_stage_mappings.sequence_number', 'asc')
                ->get();
        }

        // Current stage
        $current_stage = null;
        if ($enrollment && $enrollment->current_stage_id) {
            $current_stage = $timeline->firstWhere('id', $enrollment->current_stage_id);
        }
        if (!$current_stage && $timeline->isNotEmpty()) {
            $current_stage = $timeline->first();
        }

        // Pending invoice
        $pendingInvoice = null;
        if ($cycle_registration) {
            $pendingInvoice = Invoice::where([
                'user_id'       => $user->id,
                'category'      => 'tuition_fee',
                'status'        => 'pending',
                'billable_type' => StudentCycleRegistration::class,
                'billable_id'   => $cycle_registration->id,
            ])->latest()->first();
        }

        return view('student.profile.show', compact(
            'user',
            'student',
            'enrollment',
            'cycle',
            'cycle_registration',
            'timeline',
            'current_stage',
            'pendingInvoice'
        ));
    }

    /**
     * Show the student dashboard with academic data
     */
    public function showDashboard()
    {
        $user = Auth::user();

        $student = Student::with(['course.stages', 'campus', 'enrollments'])
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Latest enrollment
        $enrollment = $student->enrollments()->latest()->first();

        // Current cycle
        $cycle = [
            'year' => $enrollment?->year ?? now()->year,
            'term' => $enrollment?->term ?? 'Term 1',
        ];

        // Cycle registration
        $cycle_registration = StudentCycleRegistration::where('student_id', $student->id)
            ->where('cycle_year', $cycle['year'])
            ->where('cycle_term', $cycle['term'])
            ->first();

        // Course timeline (ordered stages)
        $timeline = collect();
        if ($student->course) {
            $timeline = $student->course->stages()
                ->orderBy('course_stage_mappings.sequence_number', 'asc')
                ->get();
        }

        // Current stage
        $current_stage = null;
        if ($enrollment && $enrollment->current_stage_id) {
            $current_stage = $timeline->firstWhere('id', $enrollment->current_stage_id);
        }
        if (!$current_stage && $timeline->isNotEmpty()) {
            $current_stage = $timeline->first();
        }

        // Pending invoice
        $pendingInvoice = null;
        if ($cycle_registration) {
            $pendingInvoice = Invoice::where([
                'user_id'       => $user->id,
                'category'      => 'tuition_fee',
                'status'        => 'pending',
                'billable_type' => StudentCycleRegistration::class,
                'billable_id'   => $cycle_registration->id,
            ])->latest()->first();
        }

        return view('student.student_dashboard', compact(
            'user',
            'student',
            'enrollment',
            'cycle',
            'cycle_registration',
            'timeline',
            'current_stage',
            'pendingInvoice'
        ));
    }

    /**
     * Update student's general profile info
     */
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'firstname' => 'required|string|max:255',
                'othername' => 'nullable|string|max:255',
                'surname'   => 'required|string|max:255',
                'email'     => 'required|email|max:255|unique:users,email,' . Auth::id(),
                'phone'     => 'nullable|string|max:20',
                'address'   => 'nullable|string|max:500',
                'city'      => 'nullable|string|max:100',
            ]);

            $user = Auth::user();
            $user->update([
                'firstname' => $validated['firstname'],
                'othername' => $validated['othername'] ?? null,
                'surname'   => $validated['surname'],
                'email'     => $validated['email'],
                'phone'     => $validated['phone'] ?? null,
                'address'   => $validated['address'] ?? null,
                'city'      => $validated['city'] ?? null,
            ]);

            $student = Student::where('user_id', $user->id)->first();
            if ($student) {
                $student->update([
                    'phone'   => $validated['phone'] ?? $student->phone,
                    'address' => $validated['address'] ?? $student->address,
                    'city'    => $validated['city'] ?? $student->city,
                ]);
            }

            return back()->with('message', 'Profile updated successfully')
                         ->with('alert-type', 'success');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())
                         ->withInput()
                         ->with('message', 'Please correct the errors below')
                         ->with('alert-type', 'error');
        } catch (\Exception $e) {
            \Log::error('Profile update failed: ' . $e->getMessage());
            return back()->with('message', 'An error occurred while updating your profile')
                         ->with('alert-type', 'error');
        }
    }

    /**
     * Update student's profile photo
     */
    public function updatePhoto(Request $request)
    {
        try {
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048|dimensions:max_width=2000,max_height=2000',
            ]);

            $user = Auth::user();
            $uploadPath = 'upload/student_images/';

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = time() . '_' . uniqid('', true) . '.' . $file->getClientOriginalExtension();

                if (!file_exists(public_path($uploadPath))) {
                    mkdir(public_path($uploadPath), 0755, true);
                }

                $file->move(public_path($uploadPath), $filename);

                if ($user->photo && file_exists(public_path($uploadPath . $user->photo))) {
                    unlink(public_path($uploadPath . $user->photo));
                }

                $user->photo = $filename;
                $user->save();

                return back()->with('message', 'Profile photo updated successfully')
                             ->with('alert-type', 'success');
            }

            return back()->with('message', 'No photo selected')
                         ->with('alert-type', 'warning');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())
                         ->with('message', 'Please select a valid image file')
                         ->with('alert-type', 'error');
        } catch (\Exception $e) {
            \Log::error('Photo upload failed: ' . $e->getMessage());
            return back()->with('message', 'An error occurred while uploading your photo')
                         ->with('alert-type', 'error');
        }
    }

    /**
     * Delete student's profile photo
     */
    public function deletePhoto()
    {
        try {
            $user = Auth::user();
            $uploadPath = 'upload/student_images/';

            if ($user->photo && file_exists(public_path($uploadPath . $user->photo))) {
                unlink(public_path($uploadPath . $user->photo));
            }

            $user->photo = null;
            $user->save();

            return back()->with('message', 'Profile photo removed successfully')
                         ->with('alert-type', 'success');

        } catch (\Exception $e) {
            \Log::error('Photo deletion failed: ' . $e->getMessage());
            return back()->with('message', 'An error occurred while removing your photo')
                         ->with('alert-type', 'error');
        }
    }
}
