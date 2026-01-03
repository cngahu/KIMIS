<?php

namespace App\Http\Controllers;

use App\Models\AcademicDepartment;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\Training;

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
        $user = Auth::user();

        if (! $user->hasAnyRole(['superadmin', 'hod', 'campus_registrar', 'kihbt_registrar', 'director'])) {
            if ($user->hasRole('applicant')) {
                return redirect()->route('applicant.dashboard');
            }
            abort(404);
        }

        $campusId = $user->campus_id; // from users table

        // Base query for trainings visible to this user (scoped by campus for some roles)
        $baseQuery = Training::with(['course', 'college', 'user']);

        // Superadmin and KIHBT Registrar see ALL colleges, others see only their own campus/college
        if (! $user->hasRole('superadmin') && ! $user->hasRole('kihbt_registrar')) {
            $baseQuery->where('college_id', $campusId);
        }

        // === GLOBAL COUNTS (campus-scoped for non-super/non-kihbt_registrar) ===
        $draftCount    = (clone $baseQuery)->where('status', Training::STATUS_DRAFT)->count();
        $pendingCount  = (clone $baseQuery)->where('status', Training::STATUS_PENDING_REGISTRAR)->count();
        $approvedCount = (clone $baseQuery)->where('status', Training::STATUS_APPROVED)->count();
        $rejectedCount = (clone $baseQuery)->where('status', Training::STATUS_REJECTED)->count();

        // ✅ NEW: Truly global counts (all campuses) for KIHBT Registrar & Director summary cards
        $globalApprovedTrainings = Training::where('status', Training::STATUS_APPROVED)->count();
        $globalRejectedTrainings = Training::where('status', Training::STATUS_REJECTED)->count();

        // Init role-specific counters
        $hodDraftTrainings         = 0;
        $hodPendingRegistrar       = 0;
        $hodRejectedTrainings      = 0;
        $registrarPendingTrainings = 0;
        $registrarToHqTrainings    = 0;
        $hqQueueTrainings          = 0;
        $directorQueueTrainings    = 0;

        // Start from the same base for "recent" list
        $recentQuery = (clone $baseQuery);
        $hodDepartments=[];
        $hodCourses=[];
        $hodOfficialName='';
        $hodTotalCourses =0;
        $hodLongCourses  = 0;
        $hodShortCourses = 0;


        // === ROLE-SPECIFIC SCOPE ON TOP OF CAMPUS FILTER ===
        if ($user->hasRole('hod')) {

            $hodBase = (clone $baseQuery)->where('user_id', $user->id);

            $hodDraftTrainings    = (clone $hodBase)->where('status', Training::STATUS_DRAFT)->count();
            $hodPendingRegistrar  = (clone $hodBase)->where('status', Training::STATUS_PENDING_REGISTRAR)->count();
            $hodRejectedTrainings = (clone $hodBase)->where('status', Training::STATUS_REJECTED)->count();

            $recentQuery = $hodBase;
            $hodDepartments = AcademicDepartment::with(['college'])
                ->where('hod_user_id', $user->id)
                ->get();

            $hodCourses = Course::with(['academicDepartment', 'college'])
                ->whereIn(
                    'academic_department_id',
                    $hodDepartments->pluck('id')
                )
                ->get()
                ->groupBy('course_mode'); // Long Term | Short Term

            $hodOfficialName = trim(
                "{$user->surname} {$user->firstname} {$user->othername}"
            );
            $hodTotalCourses = $hodCourses->flatten()->count();
            $hodLongCourses  = $hodCourses->get('Long Term')?->count() ?? 0;
            $hodShortCourses = $hodCourses->get('Short Term')?->count() ?? 0;


        } elseif ($user->hasRole('campus_registrar')) {

            $recentQuery->whereIn('status', [
                Training::STATUS_PENDING_REGISTRAR,
                Training::STATUS_REGISTRAR_APPROVED_HQ,
                Training::STATUS_REJECTED,
            ]);

            $registrarPendingTrainings = (clone $baseQuery)
                ->where('status', Training::STATUS_PENDING_REGISTRAR)
                ->count();

            $registrarToHqTrainings = (clone $baseQuery)
                ->where('status', Training::STATUS_REGISTRAR_APPROVED_HQ)
                ->count();

        } elseif ($user->hasRole('kihbt_registrar')) {

            // HQ registrar: sees all campuses already
            $recentQuery->whereIn('status', [
                Training::STATUS_REGISTRAR_APPROVED_HQ,
                Training::STATUS_HQ_REVIEWED,
                Training::STATUS_REJECTED,
            ]);

            $hqQueueTrainings = (clone $baseQuery)
                ->where('status', Training::STATUS_REGISTRAR_APPROVED_HQ)
                ->count();

        } elseif ($user->hasRole('director')) {

            $recentQuery->whereIn('status', [
                Training::STATUS_HQ_REVIEWED,
                Training::STATUS_APPROVED,
                Training::STATUS_REJECTED,
            ]);

            $directorQueueTrainings = (clone $baseQuery)
                ->where('status', Training::STATUS_HQ_REVIEWED)
                ->count();

        } else {
            // superadmin
            $recentQuery->whereNotNull('id');
        }

        // Last 10 trainings for the dashboard table
        $recentTrainings = $recentQuery
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $userName    = $user->name ?? $user->email;
        $primaryRole = $user->getRoleNames()->first();

        return view('admin.index', compact(
            'draftCount',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'hodDraftTrainings',
            'hodPendingRegistrar',
            'hodRejectedTrainings',
            'registrarPendingTrainings',
            'registrarToHqTrainings',
            'hqQueueTrainings',
            'directorQueueTrainings',
            'recentTrainings',
            'userName',
            'primaryRole',
            // 👇 NEW
            'globalApprovedTrainings',
            'globalRejectedTrainings',
            'hodDepartments',
            'hodCourses',
            'hodOfficialName',
            'hodTotalCourses',
            'hodLongCourses',
            'hodShortCourses',


        ));
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
