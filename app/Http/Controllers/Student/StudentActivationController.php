<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Masterdata;
use App\Models\User;
use App\Services\ContinuingStudentActivationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentActivationCredentialsMail;

class StudentActivationController extends Controller
{
    /**
     * STEP 1: Show admission number form
     */
    public function start()
    {
        return view('student.activation.step1');
    }

    /**
     * STEP 2: Verify admission number
     */
    public function verifyAdmission0(Request $request)
    {

        $request->validate([
            'admissionno' => ['required'],
        ]);

        $student = Masterdata::where('admissionNo', $request->admissionno)->first();

        if (!$student) {
            return back()->withErrors([
                'admissionno' => 'Admission number not found in our records.',
            ]);
        }

        return view('student.activation.step2', compact('student'));
    }
    public function verifyAdmission(Request $request)
    {
        $request->validate([
            'admissionno' => ['required'],
        ]);

        $student = Masterdata::where('admissionNo', $request->admissionno)->first();

        if (! $student) {
            return back()->withErrors([
                'admissionno' => 'Admission number not found in our records.',
            ]);
        }

        // ✅ NEW CHECK: already activated
        if ($student->is_activated) {
            return back()->withErrors([
                'admissionno' => 'This account has already been activated.
            Please log in using the credentials sent to your email.
            If you did not receive the email, kindly contact the ICT Office for assistance.',
            ]);
        }

        return view('student.activation.step2', compact('student'));
    }


    /**
     * STEP 3: Create student user account
     */
    public function complete0(Request $request)
    {
        $request->validate([
            'admissionno' => ['required'],
            'phone'       => ['required'],
            'email'       => ['required', 'email'],
        ]);

        $student = Masterdata::where('admissionNo', $request->admissionno)->firstOrFail();



        // Prevent double activation
        if (User::where('username', $student->admissionNo)->exists()) {
            return redirect()->route('login')
                ->with('error', 'Account already activated. Please login.');
        }

        // Generate temporary password
        $temporaryPassword = Str::random(10);

        $user = User::create([
            'username'     => $student->admissionNo,
            'surname'      => $student->full_name,
            'firstname'    => $student->full_name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'national_id'  => $student->idno,
            'campus_id'    => $student->campus_id,
            'userrole'     => 'student',
            'password'     => Hash::make($temporaryPassword),
            'must_change_password' => 1,
        ]);

        // ✅ Assign Spatie role
        $user->assignRole('student');
// ✅ Send email with username + password
        Mail::to($request->email)->send(
            new StudentActivationCredentialsMail(
                $user->username,
                $temporaryPassword,
                $user->firstname ?? $user->surname ?? 'Student'
            )
        );

        // 🔔 OTP will be sent on first login (next step)
        // event(new StudentFirstLoginOtpEvent($student));

        return redirect()
            ->route('student.activation.success')
            ->with('activation_email', $request->email);
    }


    public function complete(Request $request)
    {
        $validated = $request->validate([
            'admissionno' => ['required'],
            'email'       => ['required', 'email'],
            'phone'       => ['required'],
        ]);

        try {
            $student = app(ContinuingStudentActivationService::class)
                ->activate($validated);

            return redirect()
                ->route('student.activation.success')
                ->with('success', 'Account activated successfully. Please check your email.');

        } catch (\Throwable $e) {

            Log::error('Student activation failed', [
                'admissionno' => $validated['admissionno'],
                'error' => $e->getMessage(),
            ]);

//            return back()->with('error', $e->getMessage());
            Log::error('Student activation failed', [
                'admissionno' => $validated['admissionno'],
                'exception' => $e,
            ]);

            return redirect()
                ->route('student.activation.start')
                ->withInput()
                ->with('activation_error', true);


        }
    }

}
