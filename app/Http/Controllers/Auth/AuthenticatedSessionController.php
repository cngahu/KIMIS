<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\Audit\AuditLogService;
use App\Services\Auth\OTPService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Middleware\RoleMiddleware;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        $request->authenticate();

        $request->session()->regenerate();

        if($request->user()->hasRole('applicant')){
            $url='applicant/dashboard';
        }
        elseif($request->user()->hasRole('superadmin')){
            $url='/dashboard';
        }

        elseif($request->user()->hasRole('hod')){
            $url='/dashboard';
        }

        elseif($request->user()->hasRole('campus_registrar')){
            $url='/dashboard';
        }

        elseif($request->user()->hasRole('kihbt_registrar')) {
            $url = '/dashboard';
        }

        elseif($request->user()->hasRole('director')) {
            $url = '/dashboard';
        }


        else {
            abort(403);
        }
        return redirect($url);
//        return redirect()->intended(RouteServiceProvider::HOME);
       // return redirect()->intended($url);
    }
    public function store0(LoginRequest $request)
    {
        // First: validate email + password
        $request->authenticate();

        // At this point credentials are correct but we DO NOT log in fully yet
        $user = $request->user();

        // log audit
        app(\App\Services\Audit\AuditLogService::class)->log('login.credentials_valid', $user);

        // generate OTP
        app(\App\Services\Auth\OTPService::class)->generate($user);

        // store user ID in session temporarily
        session(['2fa:user:id' => $user->id]);

        // logout the session temporarily
        Auth::logout();

        return redirect()->route('otp.verify.form');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $audit = app(AuditLogService::class);

        // Capture the user before logout happens
        $user = auth()->user();

        // Log the exit event
        if ($user) {
            $audit->log('user.logout', $user);
        }

        // Logout sequence
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function showOtpForm()
    {
        if (!session('2fa:user:id')) {
            return redirect()->route('login')->withErrors('Session expired.');
        }

        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $userId = session('2fa:user:id');
        $user = User::findOrFail($userId);

        $otpService = app(OTPService::class);
        $audit = app(AuditLogService::class);

        // Validate OTP
        $otp = $otpService->validateCode($user, $request->otp);

        if (!$otp) {
            $audit->log('otp.failed', $user, [
                'entered_code' => $request->otp
            ]);

            return back()->withErrors(['otp' => 'Invalid OTP code']);
        }

        // Mark OTP as used
        $otpService->markUsed($otp);

        // Log success
        $audit->log('otp.verified', $user);

        // Log in fully
        Auth::login($user);
        $request->session()->regenerate();

        // ROLE REDIRECT
        if ($user->hasRole('applicant')) {
            return redirect('applicant/dashboard');
        }
        elseif ($user->hasRole('superadmin')) {
            return redirect('/dashboard');
        }

        elseif ($user->hasRole('hod')) {
            return redirect('/dashboard');
        }

        elseif($request->user()->hasRole('campus_registrar')) {
            $url = '/dashboard';
        }
        elseif($request->user()->hasRole('kihbt_registrar')){
            $url='/dashboard';
         }

        elseif($request->user()->hasRole('director')) {
            $url = '/dashboard';
        }
        abort(403);
    }
    public function resendOtp()
    {
        $audit = app(\App\Services\Audit\AuditLogService::class);

        // Validate session user
        $userId = session('2fa:user:id');
        if (!$userId) {
            $audit->log('otp.resend_failed', null, ['reason' => 'missing_session_user']);
            return redirect('/login')->withErrors('Your session has expired. Please log in again.');
        }

        $user = User::find($userId);
        if (!$user) {
            $audit->log('otp.resend_failed', null, ['reason' => 'user_not_found', 'user_id' => $userId]);
            return redirect('/login')->withErrors('Invalid session. Please log in again.');
        }

        try {
            $otpService = app(\App\Services\Auth\OTPService::class);

            // Generate new OTP
            $otpService->generate($user);

            // Log success
            $audit->log('otp.resent', $user);

            return back()->with('status', 'A new OTP has been sent to your email.');

        } catch (\Exception $e) {

            // Log failure
            $audit->log('otp.resend_failed', $user, [
                'error' => $e->getMessage()
            ]);

            return back()->withErrors('Failed to resend OTP. Please try again.');
        }
    }



}
