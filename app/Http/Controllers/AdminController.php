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
    public function __construct()
    {
        $this->middleware('verified');
    }

    public function AdminDashboard()
    {
        $user = Auth::user();

        if (! $user->hasAnyRole(['superadmin', 'hod', 'campus_registrar', 'kihbt_registrar', 'director'])) {
            if ($user->hasRole('applicant')) {
                return redirect()->route('applicant.dashboard');
            }
            if ($user->hasAnyRole(['accounts', 'cash_office'])) {
                return redirect()->route('accounts.dashboard');
            }
            abort(404);
        }

        $campusId  = $user->campus_id;
        $baseQuery = Training::with(['course', 'college', 'user']);

        if (! $user->hasRole('superadmin') && ! $user->hasRole('kihbt_registrar')) {
            $baseQuery->where('college_id', $campusId);
        }

        $draftCount    = (clone $baseQuery)->where('status', Training::STATUS_DRAFT)->count();
        $pendingCount  = (clone $baseQuery)->where('status', Training::STATUS_PENDING_REGISTRAR)->count();
        $approvedCount = (clone $baseQuery)->where('status', Training::STATUS_APPROVED)->count();
        $rejectedCount = (clone $baseQuery)->where('status', Training::STATUS_REJECTED)->count();

        $globalApprovedTrainings = Training::where('status', Training::STATUS_APPROVED)->count();
        $globalRejectedTrainings = Training::where('status', Training::STATUS_REJECTED)->count();

        $hodDraftTrainings         = 0;
        $hodPendingRegistrar       = 0;
        $hodRejectedTrainings      = 0;
        $registrarPendingTrainings = 0;
        $registrarToHqTrainings    = 0;
        $hqQueueTrainings          = 0;
        $directorQueueTrainings    = 0;

        $recentQuery     = (clone $baseQuery);
        $hodDepartments  = [];
        $hodCourses      = [];
        $hodOfficialName = '';
        $hodTotalCourses = 0;
        $hodLongCourses  = 0;
        $hodShortCourses = 0;

        if ($user->hasRole('hod')) {

            $hodBase = (clone $baseQuery)->where('user_id', $user->id);

            $hodDraftTrainings    = (clone $hodBase)->where('status', Training::STATUS_DRAFT)->count();
            $hodPendingRegistrar  = (clone $hodBase)->where('status', Training::STATUS_PENDING_REGISTRAR)->count();
            $hodRejectedTrainings = (clone $hodBase)->where('status', Training::STATUS_REJECTED)->count();

            $recentQuery    = $hodBase;
            $hodDepartments = AcademicDepartment::with(['college'])
                ->where('hod_user_id', $user->id)
                ->get();

            $hodCourses = Course::with(['academicDepartment', 'college'])
                ->whereIn('academic_department_id', $hodDepartments->pluck('id'))
                ->get()
                ->groupBy('course_mode');

            $hodOfficialName = trim("{$user->surname} {$user->firstname} {$user->othername}");
            $hodTotalCourses = $hodCourses->flatten()->count();
            $hodLongCourses  = $hodCourses->get('Long Term')?->count()  ?? 0;
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
            // superadmin — sees everything
            $recentQuery->whereNotNull('id');
        }

        $recentTrainings = $recentQuery->orderByDesc('created_at')->take(10)->get();

        // ✅ FIXED: users table has no 'name' column — use firstname/surname
        $userName    = trim("{$user->firstname} {$user->surname}") ?: $user->email;
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

    // =========================================================

    public function Logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // =========================================================

    public function AdminProfile()
    {
        $id        = Auth::id();
        $adminData = User::findOrFail($id);
        return view('admin.admin_profile_view', compact('adminData'));
    }

    // =========================================================

    public function AdminProfileStore(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $id   = Auth::id();
        $data = User::findOrFail($id);

        // ✅ FIXED: No 'name' column — split full name into firstname & surname
        $nameParts      = explode(' ', trim($request->name), 2);
        $data->firstname = $nameParts[0] ?? '';
        $data->surname   = $nameParts[1] ?? '';

        $data->email   = $request->email;
        $data->phone   = $request->phone;
        $data->address = $request->address;

        $data->save();

        return redirect()->back()->with([
            'message'    => 'Admin Profile Updated Successfully',
            'alert-type' => 'success',
        ]);
    }

    // =========================================================

    /**
     * ✅ ADDED: Handle profile photo upload separately.
     */
    public function AdminProfilePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $id   = Auth::id();
        $data = User::findOrFail($id);

        $file     = $request->file('photo');
        $oldPhoto = public_path('upload/admin_images/' . $data->photo);

        // Remove old photo if it exists
        if ($data->photo && file_exists($oldPhoto)) {
            @unlink($oldPhoto);
        }

        $filename    = date('YmdHi') . '_' . $file->getClientOriginalName();
        $file->move(public_path('upload/admin_images'), $filename);
        $data->photo = $filename;
        $data->save();

        return redirect()->back()->with([
            'message'    => 'Profile photo updated successfully',
            'alert-type' => 'success',
        ]);
    }

    // =========================================================

    public function AdminChangePassword()
    {
        return view('admin.admin_change_password');
    }

    // =========================================================

    public function AdminUpdatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        if (! Hash::check($request->old_password, Auth::user()->password)) {
            return back()->with('error', "Old Password Doesn't Match!");
        }

        User::whereId(Auth::id())->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('status', 'Password Changed Successfully');
    }

    // =========================================================
    // Admin User Management
    // =========================================================

    public function AllAdmin()
    {
        $alladminuser = User::latest()->get();
        return view('backend.admin.all_admin', compact('alladminuser'));
    }

    public function AddAdmin()
    {
        $roles = Role::all();
        return view('backend.admin.add_admin', compact('roles'));
    }

    public function StoreAdmin(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
        ]);

        $nameParts = explode(' ', trim($request->name), 2);

        $user                    = new User();
        $user->firstname         = $nameParts[0] ?? '';
        $user->surname           = $nameParts[1] ?? '';
        $user->email             = $request->email;
        $user->phone             = $request->phone;
        $user->must_change_password = 1;
        $user->password          = Hash::make('password');
        $user->save();

        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        return redirect()->route('admin.users.index')->with([
            'message'    => 'New Admin User Created Successfully',
            'alert-type' => 'success',
        ]);
    }

    public function EditAdmin($id)
    {
        $roles     = Role::all();
        $adminuser = User::findOrFail($id);
        return view('backend.admin.edit_admin', compact('roles', 'adminuser'));
    }

    public function UpdateAdmin(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // ✅ FIXED: No 'name' column — split into firstname/surname
        $nameParts       = explode(' ', trim($request->name), 2);
        $user->firstname = $nameParts[0] ?? '';
        $user->surname   = $nameParts[1] ?? '';
        $user->email     = $request->email;
        $user->phone     = $request->phone;
        $user->save();

        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        return redirect()->route('admin.users.index')->with([
            'message'    => 'Admin User Updated Successfully',
            'alert-type' => 'success',
        ]);
    }

    public function DeleteAdmin($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with([
            'message'    => 'Admin User Deleted Successfully',
            'alert-type' => 'success',
        ]);
    }
}