<?php

namespace App\Http\Controllers\Student;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class StudentAuthController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showChangePassword()
    {
        return view('student.student_change_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password'     => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with('error', "Current password doesn't match.");
        }

        User::whereId(auth()->id())->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('status', 'Password changed successfully.');
    }
}