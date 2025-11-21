<?php

namespace App\Http\Middleware;

use App\Models\Admission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmissionInProgress
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (auth()->user()->userrole === 'student') {

            $admission = Admission::where('user_id', auth()->id())->first();

            if ($admission && $admission->status !== 'admitted') {
                return redirect()->route('admission.dashboard');
            }
        }

        return $next($request);
    }

}
