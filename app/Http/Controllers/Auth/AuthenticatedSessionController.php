<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Services\Audit\AuditLogService;
use App\Services\Auth\OTPService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

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
     * Handle an incoming authentication request (credentials only).
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1) Validate + authenticate username/password
        $request->authenticate();

        $user = $request->user();

        // 2) Log audit
        app(AuditLogService::class)->log('login.credentials_valid', $user);

        // 3) Store user id for 2FA
        session([
            '2fa:user:id' => $user->id,
        ]);

        // 4) Log out the session temporarily (user not fully logged in yet)
        Auth::logout();

        // 5) Redirect to "choose OTP method" page
        return redirect()->route('otp.channel.form');
    }

    /**
     * Destroy an authenticated session (logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        $audit = app(AuditLogService::class);
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

    /**
     * Show the OTP verification form.
     */
    public function showOtpForm(): View
    {
        if (!session('2fa:user:id')) {
            return redirect()->route('login')->withErrors('Session expired.');
        }

        $channel = session('2fa:channel', 'email');
        return view('auth.verify-otp', compact('channel'));
    }

    /**
     * Verify OTP and complete login.
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate(['otp' => 'required|digits:6']);

        $userId = session('2fa:user:id');
        if (!$userId) {
            return redirect()->route('login')->withErrors('Session expired.');
        }

        $user = User::findOrFail($userId);
        $otpService = app(OTPService::class);
        $audit = app(AuditLogService::class);

        // Validate OTP
        $otp = $otpService->validateCode($user, $request->otp);

        if (!$otp) {
            $audit->log('otp.failed', $user, ['entered_code' => $request->otp]);
            return back()->withErrors(['otp' => 'Invalid OTP code']);
        }

        // Mark OTP as used
        $otpService->markUsed($otp);
        $audit->log('otp.verified', $user);

        // ✅ Login the user after successful OTP
        Auth::login($user);
        $request->session()->regenerate();

        // Clear 2FA session data
        session()->forget('2fa:user:id');
        session()->forget('2fa:channel');
        

        // ✅ Role-based redirects using NAMED ROUTES
        if ($user->hasRole('applicant')) {
            return redirect()->route('applicant.dashboard');
        }

        if ($user->hasRole('student')) {
            return redirect()->route('student.student_dashboard');
        }

        if ($user->hasAnyRole([
            'superadmin',
            'hod',
            'campus_registrar',
            'kihbt_registrar',
            'director',
            'accounts',
            'cash_office',
            'Principal',
            'Deputy Principal Academics',
        ])) {
            return redirect()->route('admin.dashboard');
        }

        // ⚠️ Fallback: No matching role found
        Log::warning('Login failed: no matching role', [
            'user_id' => $user->id,
            'email' => $user->email,
            'roles' => $user->getRoleNames()->toArray(),
        ]);

        return redirect()->route('login')
            ->withErrors('Your account does not have an authorized role. Please contact support.');
    }

    /**
     * Resend OTP to user.
     */
    public function resendOtp(Request $request): RedirectResponse
    {
        $audit = app(AuditLogService::class);
        $userId = session('2fa:user:id');

        if (!$userId) {
            $audit->log('otp.resend_failed', null, ['reason' => 'missing_session_user']);
            return redirect()->route('login')->withErrors('Your session has expired. Please log in again.');
        }

        $user = User::find($userId);
        if (!$user) {
            $audit->log('otp.resend_failed', null, ['reason' => 'user_not_found', 'user_id' => $userId]);
            return redirect()->route('login')->withErrors('Invalid session. Please log in again.');
        }

        try {
            $otpService = app(OTPService::class);
            $channel = $request->query('channel', session('2fa:channel', 'email'));

            session(['2fa:channel' => $channel]);
            $otpService->generate($user, $channel);

            $audit->log('otp.resent', $user, ['channel' => $channel]);

            return back()->with(
                'status',
                'A new OTP has been sent via ' . ($channel === 'sms' ? 'SMS to your phone.' : 'email.')
            );
        } catch (\Exception $e) {
            $audit->log('otp.resend_failed', $user, ['error' => $e->getMessage()]);
            return back()->withErrors('Failed to resend OTP. Please try again.');
        }
    }

    /**
     * Show OTP channel selection form.
     */
    public function showOtpChannelForm(): View
    {
        $userId = session('2fa:user:id');

        if (!$userId) {
            return redirect()->route('login')->withErrors('Session expired. Please log in again.');
        }

        $user = User::findOrFail($userId);
        return view('auth.choose-otp-channel', compact('user'));
    }

    /**
     * Handle OTP channel selection.
     */
    public function chooseOtpChannel(Request $request): RedirectResponse
    {
        $userId = session('2fa:user:id');

        if (!$userId) {
            return redirect()->route('login')->withErrors('Session expired. Please log in again.');
        }

        $user = User::findOrFail($userId);

        $data = $request->validate([
            'otp_channel' => ['required', Rule::in(['email', 'sms'])],
        ]);

        $channel = $data['otp_channel'];

        // If SMS selected, check if phone exists
        if ($channel === 'sms' && empty($user->phone)) {
            return back()->withErrors([
                'otp_channel' => 'Phone number is not available. Please choose Email or update your profile.',
            ])->withInput();
        }

        session(['2fa:channel' => $channel]);

        $otpService = app(OTPService::class);
        $audit = app(AuditLogService::class);

        try {
            $otpService->generate($user, $channel);
            $audit->log('otp.generated', $user, ['channel' => $channel]);

            return redirect()->route('otp.verify.form')
                ->with('status', 'A verification code has been sent to your ' . ($channel === 'sms' ? 'phone.' : 'email.'));
        } catch (\Throwable $e) {
            $audit->log('otp.generate_failed', $user, [
                'channel' => $channel,
                'error' => $e->getMessage(),
            ]);

            return back()->withErrors('Failed to send OTP. Please try again or choose another method.');
        }
    }
}
