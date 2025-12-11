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
use Illuminate\Validation\Rule;

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
            $url='student/dashboard';
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
        elseif($request->user()->hasRole('student')) {
            return redirect('student/dashboard');
        }

        else {
            abort(403);
        }
        return redirect($url);
//        return redirect()->intended(RouteServiceProvider::HOME);
       // return redirect()->intended($url);
    }
    public function store1(LoginRequest $request)
    {
        // 1) Validate + authenticate username/password
        $request->authenticate();

        $user = $request->user();

        // 2) Log audit
        app(\App\Services\Audit\AuditLogService::class)->log('login.credentials_valid', $user);

        // 3) Store user id for 2FA
        session([
            '2fa:user:id' => $user->id,
            // don't decide channel yet – leave for next step
        ]);

        // 4) Log out the session temporarily (user not fully logged in yet)
        Auth::logout();

        // 5) Redirect to "choose OTP method" page
        return redirect()->route('otp.channel.form');
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

        $channel = session('2fa:channel', 'email');

        return view('auth.verify-otp', compact('channel'));
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
        elseif($request->user()->hasRole('student')) {
            return redirect('student/dashboard');
        }
        else
        {
            dd('Am here');
            dd('Am here');
        }
        abort(403);
    }
    public function resendOtp(Request $request)
    {
        $audit = app(AuditLogService::class);

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
            $otpService = app(OTPService::class);

            // Get channel from query or session (default email)
            $channel = $request->query('channel', session('2fa:channel', 'email'));

            // Remember latest choice
            session(['2fa:channel' => $channel]);

            // Generate new OTP using that channel
            $otpService->generate($user, $channel);

            $audit->log('otp.resent', $user, ['channel' => $channel]);

            return back()->with(
                'status',
                'A new OTP has been sent via ' . ($channel === 'sms' ? 'SMS to your phone.' : 'email.')
            );

        } catch (\Exception $e) {

            $audit->log('otp.resend_failed', $user, [
                'error' => $e->getMessage()
            ]);

            return back()->withErrors('Failed to resend OTP. Please try again.');
        }
    }

    public function showOtpChannelForm()
    {
        $userId = session('2fa:user:id');

        if (!$userId) {
            return redirect()->route('login')->withErrors('Session expired. Please log in again.');
        }

        $user = User::findOrFail($userId);

        // we pass the user so we can show email & phone, and know if phone exists
        return view('auth.choose-otp-channel', compact('user'));
    }

    public function chooseOtpChannel(Request $request)
    {
        $userId = session('2fa:user:id');

        if (!$userId) {
            return redirect()->route('login')->withErrors('Session expired. Please log in again.');
        }

        $user = User::findOrFail($userId);

        // validate the choice
        $data = $request->validate([
            'otp_channel' => ['required', Rule::in(['email', 'sms'])],
        ]);

        $channel = $data['otp_channel'];

        // ✅ if SMS selected, check if phone exists
        if ($channel === 'sms' && (empty($user->phone))) {
            return back()->withErrors([
                'otp_channel' => 'Phone number is not available. Please choose Email or update your profile.',
            ])->withInput();
        }

        // remember chosen channel
        session(['2fa:channel' => $channel]);

        // generate + send OTP using selected channel
        $otpService = app(OTPService::class);
        $audit      = app(AuditLogService::class);

        try {
            $otpService->generate($user, $channel);

            $audit->log('otp.generated', $user, ['channel' => $channel]);

            return redirect()->route('otp.verify.form')
                ->with('status', 'A verification code has been sent to your ' . ($channel === 'sms' ? 'phone.' : 'email.'));
        } catch (\Throwable $e) {
            $audit->log('otp.generate_failed', $user, [
                'channel' => $channel,
                'error'   => $e->getMessage(),
            ]);

            return back()->withErrors('Failed to send OTP. Please try again or choose another method.');
        }
    }



}
