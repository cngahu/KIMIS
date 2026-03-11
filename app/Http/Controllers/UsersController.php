<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use Spatie\Permission\Middleware\RoleMiddleware;

class UsersController extends Controller
{
    //
    public function ApplicantDashboard()
    {
        dd('AM IN DASHBOARD');
        $user=User::find(Auth::user()->id);
//        if($user->must_change_password==1)
//        {
//            return redirect()->route('admin.change.password');
//        }
//        else{
//
//        }

        return view('applicant.index',compact('user'));


    }


    public function ApplicantLogout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function ApplicantProfile(){

        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile_view',compact('adminData'));

    } // End Mehtod

    public function ApplicantDProfile(){

        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('applicant.profile_view',compact('adminData'));

    } // End Mehtod

    public function ApplicantProfileStore(Request $request)
{
    $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email|max:255',
        'phone'   => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
    ]);

    $id   = Auth::id();
    $data = User::findOrFail($id);

    // ✅ FIXED: No 'name' column — split full name into firstname & surname
    $nameParts       = explode(' ', trim($request->name), 2);
    $data->firstname = $nameParts[0] ?? '';
    $data->surname   = $nameParts[1] ?? '';

    $data->email   = $request->email;
    $data->phone   = $request->phone;
    $data->address = $request->address;

    if ($request->hasFile('photo')) {
        $file     = $request->file('photo');
        $oldPhoto = public_path('upload/admin_images/' . $data->photo);

        if ($data->photo && file_exists($oldPhoto)) {
            @unlink($oldPhoto);
        }

        $filename    = date('YmdHi') . '_' . $file->getClientOriginalName();
        $file->move(public_path('upload/admin_images'), $filename);
        $data->photo = $filename;
    }

    $data->save();

    return redirect()->back()->with([
        'message'    => 'Profile Updated Successfully',
        'alert-type' => 'success',
    ]);
}


    public function ApplicantChangePassword(){
        return view('admin.admin_change_password');
    } // End Mehtod

    public function ApplicantUpdatePassword(Request $request){
        // Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        // Match The Old Password
        if (!Hash::check($request->old_password, auth::user()->password)) {
            return back()->with("error", "Old Password Doesn't Match!!");
        }

        // Update The new password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)

        ]);
        return back()->with("status", " Password Changed Successfully");

    } // End Mehtod

    //Admin User All Method


}
