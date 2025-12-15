<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) return $next($request);

        $onForcePage =
            $request->routeIs('password.force') ||
            $request->routeIs('password.force.update') ||
            $request->routeIs('logout');

        $mustChange = (int)($user->must_change_password ?? 0) === 1;
        $expired = $user->password_expires_at && now()->greaterThan($user->password_expires_at);

        if (($mustChange || $expired) && !$onForcePage) {
            return redirect()
                ->route('password.force')
                ->with('warning', $expired
                    ? 'Your password has expired. Please set a new one.'
                    : 'You must change your password before continuing.');
        }

        return $next($request);
    }
}
