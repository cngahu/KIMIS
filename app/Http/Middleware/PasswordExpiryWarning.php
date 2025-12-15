<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PasswordExpiryWarning
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->password_expires_at) {
            $daysLeft = now()->startOfDay()->diffInDays(
                $user->password_expires_at->startOfDay(),
                false // allow negative
            );

            // Show warning only when 0..5 days remain
            if ($daysLeft >= 0 && $daysLeft <= 5) {
                // avoid flashing repeatedly within same session page flow
                if (!session()->has('password_expiry_warning_shown')) {
                    session()->flash(
                        'warning',
                        "Your password will expire in {$daysLeft} day(s). Please change it now."
                    );
                    session(['password_expiry_warning_shown' => true]);
                }
            }
        }

        return $next($request);
    }
}
