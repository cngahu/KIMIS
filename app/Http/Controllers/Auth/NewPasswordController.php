<?php
    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Auth\Events\PasswordReset;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Password;
    use Illuminate\Support\Str;
    use Illuminate\Validation\Rules;
    use Illuminate\View\View;

    class NewPasswordController extends Controller
    {
        public function create(Request $request): View
        {
        return view('auth.reset-password', ['request' => $request]);
        }

        public function store(Request $request): RedirectResponse
        {
        $request->validate([
        'token' => ['required'],
        'email' => ['required', 'email'],
        'password' => [
        'required',
        'confirmed',

        // ✅ Password Policy
        Rules\Password::min(10)
        ->mixedCase()     // upper + lower
        ->numbers()
        ->symbols()
        ->uncompromised(), // checks against known leaked passwords (if supported)
        ],
        ]);

        $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user) use ($request) {

        $user->forceFill([
        'password' => Hash::make($request->password),
        'remember_token' => Str::random(60),

        // ✅ Expiry handling
        'must_change_password' => 0,
        'password_changed_at' => now(),
        'password_expires_at' => now()->addDays(30),
        ])->save();

        event(new PasswordReset($user));
        }
        );

        return $status == Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()
        ->withInput($request->only('email'))
        ->withErrors(['email' => __($status)]);
        }
        }
