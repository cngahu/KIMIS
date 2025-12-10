@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Edit User</h4>
            <a href="{{ route('admin.users.index') }}" class="btn btn-light border btn-sm">
                Back
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                Please correct the errors below.
            </div>
        @endif

        <div class="card radius-10">
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Surname *</label>
                            <input type="text" name="surname"
                                   value="{{ old('surname', $user->surname) }}"
                                   class="form-control @error('surname') is-invalid @enderror">
                            @error('surname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">First Name *</label>
                            <input type="text" name="firstname"
                                   value="{{ old('firstname', $user->firstname) }}"
                                   class="form-control @error('firstname') is-invalid @enderror">
                            @error('firstname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Other Name</label>
                            <input type="text" name="othername"
                                   value="{{ old('othername', $user->othername) }}"
                                   class="form-control @error('othername') is-invalid @enderror">
                            @error('othername') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone"
                                   value="{{ old('phone', $user->phone) }}"
                                   class="form-control @error('phone') is-invalid @enderror">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Campus</label>
                            <select name="campus_id" class="form-select @error('campus_id') is-invalid @enderror">
                                <option value="">-- Select Campus --</option>
                                @foreach($campuses as $campus)
                                    <option value="{{ $campus->id }}"
                                        {{ (int)old('campus_id', $user->campus_id ?? 0) === $campus->id ? 'selected' : '' }}>
                                        {{ $campus->name }} ({{ $campus->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('campus_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Code</label>
                            <input type="text" name="code"
                                   value="{{ old('code', $user->code) }}"
                                   class="form-control @error('code') is-invalid @enderror">
                            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">
                                Changing this will also reset the password to the new code and mark
                                “must change password”.
                            </small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <input type="text" name="address"
                                   value="{{ old('address', $user->address) }}"
                                   class="form-control @error('address') is-invalid @enderror">
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city"
                                   value="{{ old('city', $user->city) }}"
                                   class="form-control @error('city') is-invalid @enderror">
                            @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Status *</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Roles --}}
                        <select name="roles[]" class="form-select" multiple>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ in_array($role->name, old('roles', $userRoleNames)) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>

                        {{-- Permissions --}}
{{--                        <div class="col-md-6">--}}
{{--                            <label class="form-label">Direct Permissions</label>--}}
{{--                            <select name="permissions[]" class="form-select" multiple>--}}
{{--                                @foreach($permissions as $permission)--}}
{{--                                    <option value="{{ $permission->name }}"--}}
{{--                                        {{ in_array($permission->name, old('permissions', $userPermissionNames)) ? 'selected' : '' }}>--}}
{{--                                        {{ $permission->name }}--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}

                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
