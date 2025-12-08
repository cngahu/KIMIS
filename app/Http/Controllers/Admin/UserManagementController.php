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
            'campus_id'   => 'nullable|exists:colleges,id',

            'code'        => 'nullable|string|max:50|unique:users,code',

            'status'      => 'required|in:active,inactive',

            // roles are passed as NAMES from the form
            'roles'       => 'array',
            'roles.*'     => 'exists:roles,name',
        ]);

        // Generate code if not provided
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
        $user->password             = Hash::make($code); // login using code as first password

        $user->save();

        // Attach roles by NAME (Spatie will give all permissions from those roles)
        if (!empty($data['roles'])) {
            $user->syncRoles($data['roles']); // already names
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully. Login code: '.$code);
    }
//    public function edit(User $user)
//    {
//        $roles    = \Spatie\Permission\Models\Role::orderBy('name')->get();
//        $campuses = College::orderBy('name')->get();
//
//        return view('admin.users.edit', compact('user', 'roles', 'campuses'));
//    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $campuses = College::orderBy('name')->get();
        // Add these two lines:
        $userRoleNames = $user->roles->pluck('name')->toArray();
        $userPermissionNames = $user->permissions->pluck('name')->toArray();

        return view('admin.users.edit', compact(
            'user',
            'roles',
            'permissions',
            'userRoleNames',
            'campuses',
            'userPermissionNames'
        ));
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
            'campus_id'  => 'nullable|exists:colleges,id',
            'status'     => 'required|in:active,inactive',

            // 🔑 IMPORTANT
            'roles'      => 'nullable|array',
            'roles.*'    => 'string|exists:roles,name',
        ]);

        $user->surname     = $data['surname'];
        $user->firstname   = $data['firstname'];
        $user->othername   = $data['othername'] ?? null;
        $user->email       = $data['email'] ?? null;
        $user->phone       = $data['phone'] ?? null;
        $user->address     = $data['address'] ?? null;
        $user->city        = $data['city'] ?? null;
        $user->status      = $data['status'];
        $user->nationalid  = $data['nationalid'] ?? null;
        $user->national_id = $data['national_id'] ?? null;
        $user->campus_id   = $data['campus_id'] ?? null;

        $user->save();

        // 🔑 ROLES: use names directly, no query by id
        $roles = $data['roles'] ?? [];   // if nothing selected, empty array

        $user->syncRoles($roles);

        return redirect()
            ->route('admin.users.index')
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
