@extends('layouts.app')

@section('content')

    <section class="section premium-dashboard">

        <div class="premium-floating-header">

            <div class="header-content">

                <div class="header-left">

                    <div class="header-icon">
                        <i class="fas fa-user-edit"></i>
                    </div>

                    <div>

                        <span class="header-badge">
                            User Management
                        </span>

                        <h2>Edit User</h2>

                        <p>Update user information</p>

                    </div>

                </div>

                <div class="premium-head-actions">

                    <a href="{{ route('users.index') }}" class="btn btn-create"
                        style="background: var(--cloth); color: var(--ink);">

                        <i class="fas fa-arrow-left"></i>
                        Back to Users

                    </a>

                </div>

            </div>

        </div>

    </section>

    <section class="section premium-dashboard pt-0">

        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="card premium-block">

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Role <span class="text-danger">*</span>
                            </label>

                            <select name="role_id" class="form-control">

                                <option value="">Select Role</option>

                                @foreach($roles as $role)

                                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>

                                        {{ $role->name }}

                                    </option>

                                @endforeach

                            </select>

                            @error('role_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Employee Code <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="employee_code" class="form-control"
                                value="{{ old('employee_code', $user->employee_code) }}">

                            @error('employee_code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Full Name <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">

                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Email <span class="text-danger">*</span>
                            </label>

                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">

                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Mobile <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="mobile" class="form-control"
                                value="{{ old('mobile', $user->mobile) }}">

                            @error('mobile')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Profile Photo
                            </label>

                            <input type="file" name="profile_photo" class="form-control">

                            @error('profile_photo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            @if($user->profile_photo)

                                <div class="mt-2">

                                    <img src="{{ asset('storage/' . $user->profile_photo) }}" width="80" height="80"
                                        class="rounded border" style="object-fit:cover;">

                                </div>

                            @endif

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>

                            <select name="status" class="form-select">
                                <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                    </div>

                    <div class="mt-4">

                        <button type="submit" class="btn btn-create">

                            <i class="fas fa-save"></i>
                            Update User

                        </button>

                        <a href="{{ route('users.index') }}" class="btn"
                            style="background: var(--cloth); color: var(--ink);">

                            <i class="fas fa-times"></i>
                            Cancel

                        </a>

                    </div>

                </div>

            </div>

        </form>

    </section>

@endsection
