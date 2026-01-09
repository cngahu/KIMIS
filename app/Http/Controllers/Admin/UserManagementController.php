<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicDepartment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use App\Models\College;
use App\Mail\UserAccountCreatedMail;
use App\Models\Course;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->input('search');
        $status   = $request->input('status');
        $roleName = $request->input('role');

        $query = User::with('roles');

        // ✅ Exclude students
        $query->whereDoesntHave('roles', function ($q) {
            $q->where('name', 'student');
        });

        // 🔍 Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('surname', 'like', "%{$search}%")
                    ->orWhere('firstname', 'like', "%{$search}%")
                    ->orWhere('othername', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // 🟢 Status filter
        if ($status) {
            $query->where('status', $status);
        }

        // 🎭 Role filter (optional dropdown)
        if ($roleName) {
            $query->whereHas('roles', function ($q) use ($roleName) {
                $q->where('name', $roleName);
            });
        }

        $users = $query->orderBy('surname')
            ->orderBy('firstname')
            ->paginate(10)
            ->appends($request->query());

        $roles = Role::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'roles', 'search', 'status', 'roleName'));
    }

    public function indexStudent(Request $request)
    {
        $search   = $request->input('search');
        $status   = $request->input('status');

        $query = User::with('roles');

        // ✅ Only students
        $query->whereHas('roles', function ($q) {
            $q->where('name', 'student');
        });

        // 🔍 Search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('surname', 'like', "%{$search}%")
                    ->orWhere('firstname', 'like', "%{$search}%")
                    ->orWhere('othername', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // 🟢 Status filter
        if ($status) {
            $query->where('status', $status);
        }

        $users = $query->orderBy('surname')
            ->orderBy('firstname')
            ->paginate(10)
            ->appends($request->query());

        // (Optional) only show "student" in dropdown, or keep all roles
        $roles = Role::orderBy('name')->get();
        $roleName = 'student';

        return view('admin.users.index_student', compact('users', 'roles', 'search', 'status', 'roleName'));
    }

    public function create()
    {
        $roles    = Role::orderBy('name')->get();
        $campuses = College::orderBy('name')->get();

        return view('admin.users.create', compact('roles', 'campuses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'surname'     => 'required|string|max:255',
            'firstname'   => 'required|string|max:255',
            'othername'   => 'nullable|string|max:255',
            'email'       => 'nullable|email|max:255|unique:users,email',
            'phone'       => 'nullable|string|max:50',
            'address'     => 'nullable|string|max:255',
            'city'        => 'nullable|string|max:255',
            'nationalid'  => 'nullable|string|max:100',
            'national_id' => 'nullable|string|max:100',

            'role'        => 'required|exists:roles,name',
            'campus_id'   => 'required_if:role,hod|exists:colleges,id',

            'code'        => 'nullable|string|max:50|unique:users,code',
            'status'      => 'required|in:active,inactive',

            // ✅ HOD departments (AcademicDepartment IDs)
            'academic_department_ids'   => 'required_if:role,hod|array|min:1',
            'academic_department_ids.*' => 'integer|exists:academic_departments,id',
        ]);

        $code = $data['code'] ?? strtoupper(Str::random(8));

        $user = new User();
        $user->surname     = $data['surname'];
        $user->firstname   = $data['firstname'];
        $user->othername   = $data['othername'] ?? null;
        $user->email       = $data['email'] ?? null;
        $user->phone       = $data['phone'] ?? null;
        $user->address     = $data['address'] ?? null;
        $user->city        = $data['city'] ?? null;
        $user->code        = $code;
        $user->status      = $data['status'];
        $user->nationalid  = $data['nationalid'] ?? null;
        $user->national_id = $data['national_id'] ?? null;
        $user->campus_id   = $data['campus_id'] ?? null;

        $user->must_change_password = 1;
        $user->password = Hash::make($code);
        $user->save();

        $user->syncRoles([$data['role']]);

        // ✅ Assign HOD to selected academic departments (by setting hod_user_id)
        if ($data['role'] === 'hod') {
            $validDepartmentIds = AcademicDepartment::where('college_id', $user->campus_id)
                ->whereIn('id', $data['academic_department_ids'])
                ->pluck('id')
                ->toArray();

            // Make sure those departments point to this user as HOD
            AcademicDepartment::whereIn('id', $validDepartmentIds)
                ->update(['hod_user_id' => $user->id]);

            // ✅ Auto-sync courses under those departments
            $autoCourseIds = Course::where('college_id', $user->campus_id)
                ->whereIn('department_id', $validDepartmentIds)
                ->pluck('id')
                ->toArray();

            $user->courses()->sync($autoCourseIds);
        } else {
            // If not HOD, no course assignments
            $user->courses()->sync([]);
        }

        if (!empty($user->email)) {
            Mail::to($user->email)->send(new UserAccountCreatedMail($user, $code));
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully. Login code: ' . $code);
    }

    public function edit(User $user)
    {
        $roles    = Role::orderBy('name')->get();
        $campuses = College::orderBy('name')->get();

        $userRole = $user->roles()->pluck('name')->first();
        $userAcademicDepartmentIds = $user->departments()->pluck('academic_departments.id')->toArray();

        return view('admin.users.edit', compact(
            'user','roles','campuses','userRole','userAcademicDepartmentIds'
        ))->with([
            'context'   => 'users',
            'backRoute' => route('admin.users.index'),
            'lockRoleToStudent' => false,
        ]);
    }

    public function editStudent(User $user)
    {
        $roles    = Role::orderBy('name')->get();
        $campuses = College::orderBy('name')->get();

        $userRole = $user->roles()->pluck('name')->first();
        $userAcademicDepartmentIds = $user->departments()->pluck('academic_departments.id')->toArray();

        return view('admin.users.edit', compact(
            'user','roles','campuses','userRole','userAcademicDepartmentIds'
        ))->with([
            'context'   => 'students',
            'backRoute' => route('admin.users.students'),
            'lockRoleToStudent' => true, // ✅ lock role when editing student
        ]);
    }


    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'surname'     => 'required|string|max:255',
            'firstname'   => 'required|string|max:255',
            'othername'   => 'nullable|string|max:255',
            'email'       => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'phone'       => 'nullable|string|max:50',
            'address'     => 'nullable|string|max:255',
            'city'        => 'nullable|string|max:255',
            'nationalid'  => 'nullable|string|max:100',
            'national_id' => 'nullable|string|max:100',
            'status'      => 'required|in:active,inactive',

            'role'        => 'required|exists:roles,name',
            'campus_id'   => 'required_if:role,hod|exists:colleges,id',

            // ✅ Use AcademicDepartment IDs (same as store)
            'academic_department_ids'   => 'required_if:role,hod|array|min:1',
            'academic_department_ids.*' => 'integer|exists:academic_departments,id',
        ]);

        $user->fill([
            'surname'     => $data['surname'],
            'firstname'   => $data['firstname'],
            'othername'   => $data['othername'] ?? null,
            'email'       => $data['email'] ?? null,
            'phone'       => $data['phone'] ?? null,
            'address'     => $data['address'] ?? null,
            'city'        => $data['city'] ?? null,
            'status'      => $data['status'],
            'nationalid'  => $data['nationalid'] ?? null,
            'national_id' => $data['national_id'] ?? null,
            'campus_id'   => $data['campus_id'] ?? null,
        ])->save();

        $user->syncRoles([$data['role']]);

        if ($data['role'] === 'hod') {
            $validDepartmentIds = AcademicDepartment::where('college_id', $user->campus_id)
                ->whereIn('id', $data['academic_department_ids'])
                ->pluck('id')
                ->toArray();

            // ✅ Remove HOD assignment from departments this user used to manage but are no longer selected
            AcademicDepartment::where('hod_user_id', $user->id)
                ->whereNotIn('id', $validDepartmentIds)
                ->update(['hod_user_id' => null]);

            // ✅ Assign selected departments to this HOD
            AcademicDepartment::whereIn('id', $validDepartmentIds)
                ->update(['hod_user_id' => $user->id]);

            // ✅ Auto-sync courses under selected departments
            $autoCourseIds = Course::where('college_id', $user->campus_id)
                ->whereIn('department_id', $validDepartmentIds)
                ->pluck('id')
                ->toArray();

            $user->courses()->sync($autoCourseIds);
        } else {
            // ✅ If role is NOT hod, clear any departments where this user is hod
            AcademicDepartment::where('hod_user_id', $user->id)
                ->update(['hod_user_id' => null]);

            $user->courses()->sync([]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // Optional: clear HOD assignments before deleting
        AcademicDepartment::where('hod_user_id', $user->id)
            ->update(['hod_user_id' => null]);

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
