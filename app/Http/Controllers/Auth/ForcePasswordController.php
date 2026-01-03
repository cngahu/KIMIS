<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ForcePasswordController extends Controller
{
    public function show()
    {
        return view('auth.force_password_change');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => ['required'],
            'password' => [
                'required',
                'confirmed',
                // ✅ Strong password policy:
                Password::min(10)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        $user->password = Hash::make($request->password);

        // ✅ mark changed + set expiry to 30 days from now
        $user->password_changed_at = now();
        $user->password_expires_at = now()->addDays(30);

        // ✅ clear must-change flag if you use it
        $user->must_change_password = 0;

        $user->save();

        if(Auth::user()->hasRole('student')){
            return redirect()->route('student.dashboard')->with('success', 'Password updated. It will expire in 30 days.');
        }
        else
        {
            return redirect()->route('dashboard')->with('success', 'Password updated. It will expire in 30 days.');
        }

//        return redirect()->route('dashboard')->with('success', 'Password updated. It will expire in 30 days.');
    }
}
