<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use App\Models\College;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserAccountCreatedMail;
use App\Models\Course;
use App\Models\Departmentt;
class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->input('search');
        $status   = $request->input('status');
        $roleName = $request->input('role');

        $query = User::with('roles');

        // 🔍 Search by name, email, phone, or code
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

        // 🎭 Role filter
        if ($roleName) {
            $query->whereHas('roles', function ($q) use ($roleName) {
                $q->where('name', $roleName);
            });
        }

        $users = $query
            ->orderBy('surname')
            ->orderBy('firstname')
            ->paginate(10)
            ->appends($request->query()); // keep filters when paginating

        // For role dropdown
        $roles = Role::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'roles', 'search', 'status', 'roleName'));
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

            // NEW

            'department_ids'   => 'required_if:role,hod|array',
            'department_ids.*' => 'integer|exists:departmentts,id',

//            'course_ids'       => 'nullable|array',
//            'course_ids.*'     => 'integer|exists:courses,id',
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

        if ($data['role'] === 'hod') {

            // ✅ Only departments from the selected campus are allowed
            $validDepartmentIds = Departmentt::where('college_id', $user->campus_id)
                ->whereIn('id', $data['department_ids'])
                ->pluck('id')
                ->toArray();

            $user->departments()->sync($validDepartmentIds);

            // ✅ AUTO: assign ALL courses under selected departments (and campus)
            $autoCourseIds = Course::where('college_id', $user->campus_id)
                ->whereIn('department_id', $validDepartmentIds)
                ->pluck('id')
                ->toArray();

            $user->courses()->sync($autoCourseIds);

        } else {
            $user->departments()->sync([]);
            $user->courses()->sync([]);
        }

        if (!empty($user->email)) {
            Mail::to($user->email)->send(new UserAccountCreatedMail($user, $code));
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully. Login code: '.$code);
    }



//    public function edit(User $user)
//    {
//        $roles    = \Spatie\Permission\Models\Role::orderBy('name')->get();
//        $campuses = College::orderBy('name')->get();
//
//        return view('admin.users.edit', compact('user', 'roles', 'campuses'));
//    }

//    public function edit(User $user)
//    {
//        $roles = Role::orderBy('name')->get();
//        $campuses = College::orderBy('name')->get();
//
//        $userRole = $user->roles()->pluck('name')->first();
//        $userCourseIds = $user->courses()->pluck('courses.id')->toArray();
//
//        return view('admin.users.edit', compact('user','roles','campuses','userRole','userCourseIds'));
//    }

    public function edit(User $user)
    {
        $roles    = Role::orderBy('name')->get();
        $campuses = College::orderBy('name')->get();

        $userRole = $user->roles()->pluck('name')->first();

        // NEW
        $userDepartmentIds = $user->departments()->pluck('departmentts.id')->toArray();

        return view('admin.users.edit', compact('user','roles','campuses','userRole','userDepartmentIds'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'surname'    => 'required|string|max:255',
            'firstname'  => 'required|string|max:255',
            'othername'  => 'nullable|string|max:255',
            'email'      => 'nullable|email|max:255|unique:users,email,'.$user->id,
            'phone'      => 'nullable|string|max:50',
            'address'    => 'nullable|string|max:255',
            'city'       => 'nullable|string|max:255',
            'nationalid' => 'nullable|string|max:100',
            'national_id'=> 'nullable|string|max:100',
            'status'     => 'required|in:active,inactive',

            'role'       => 'required|exists:roles,name',
            'campus_id'  => 'required_if:role,hod|exists:colleges,id',

            'department_ids'   => 'required_if:role,hod|array|min:1',
            'department_ids.*' => 'integer|exists:departmentts,id',
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

            $validDepartmentIds = Departmentt::where('college_id', $user->campus_id)
                ->whereIn('id', $data['department_ids'])
                ->pluck('id')
                ->toArray();

            $user->departments()->sync($validDepartmentIds);

            $autoCourseIds = Course::where('college_id', $user->campus_id)
                ->whereIn('department_id', $validDepartmentIds)
                ->pluck('id')
                ->toArray();

            $user->courses()->sync($autoCourseIds);

        } else {
            $user->departments()->sync([]);
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

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
