<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    // protected $user;

                public function __construct()
                    {
                        $this->middleware('verified');
                        $this->user = Auth::User();
                    }

    public function AdminDashboard()
    {
        $user = Auth::user(); // no need to re-find

        // 1) Staff dashboard: superadmin + hod
        if ($user->hasAnyRole(['superadmin', 'hod','campus_registrar'])) {
            return view('admin.index');
        }

        // 2) If somehow an applicant hits /dashboard, redirect them properly
        if ($user->hasRole('applicant')) {
            return redirect()->route('applicant.dashboard');
        }

        // 3) Everyone else: forbidden (or 404 if you prefer hiding it)
        abort(403); // or abort(404);
    }


    public function Logout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function AdminProfile(){

        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile_view',compact('adminData'));

    } // End Mehtod

    public function AdminProfileStore(Request $request){

        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;


        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // End Mehtod

    public function AdminChangePassword(){
        return view('admin.admin_change_password');
    } // End Mehtod

    public function AdminUpdatePassword(Request $request){
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
    public function AllAdmin(){

        $alladminuser=User::latest()->get();
        return view('backend.admin.all_admin',compact('alladminuser'));

    }
    public function AddAdmin(){

        $roles = Role::all();
        return view('backend.admin.add_admin',compact('roles'));
    }// End Method

    public function StoreAdmin(Request $request){

        $user = new User();
        $user->surname = $request->name;
        $user->firstname = "";
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->must_change_password=1;
        $user->password = Hash::make('password');
        $user->save();

        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        $notification = array(
            'message' => 'New Admin User Created Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.admin')->with($notification);

    }// End Method

    public function EditAdmin($id){

        $roles = Role::all();
        $adminuser = User::findOrFail($id);
        return view('backend.admin.edit_admin',compact('roles','adminuser'));

    }// End Method


    public function UpdateAdmin(Request $request){

        $admin_id = $request->id;

        $user = User::findOrFail($admin_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        $notification = array(
            'message' => 'Admin User Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.admin')->with($notification);

    }// End Method



    public function DeleteAdmin($id){

        $user = User::findOrFail($id);
        if (!is_null($user)) {
            $user->delete();
        }

        $notification = array(
            'message' => 'Admin User Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }// End Method


}
