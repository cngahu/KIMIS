<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules:
     * - Keep input name as "email" (your login form uses it)
     * - Allow students to type admission number here, so do NOT enforce email format
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string'], // ✅ changed from 'email' to 'string'
            'password' => ['required', 'string'],
            'otp_channel' => ['nullable', 'in:email,sms'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $loginInput = $this->input('email'); // admissionNo OR email depending on user type

        /**
         * 1) If this login input matches a STUDENT (by username or email),
         *    authenticate as that user (student-only special case).
         */
        $student = User::where(function ($q) use ($loginInput) {
            $q->where('username', $loginInput)
                ->orWhere('email', $loginInput);
        })
            ->whereHas('roles', function ($q) {
                $q->where('name', 'student');
            })
            ->first();

        if ($student) {
            // Attempt login by user id (prevents non-students using username)
            if (! Auth::attempt(['id' => $student->id, 'password' => $this->input('password')], $this->boolean('remember'))) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'email' => trans('auth.failed'),
                ]);
            }

            RateLimiter::clear($this->throttleKey());
            return;
        }

        /**
         * 2) Everyone else (admins/staff/applicants/etc) logs in ONLY by email (default behavior)
         */
        if (! Auth::attempt(['email' => $loginInput, 'password' => $this->input('password')], $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        // keep original throttling behavior
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}
