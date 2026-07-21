@extends('layouts.app')

@section('content')

    <section class="section premium-dashboard">

        <div class="premium-floating-header">

            <div class="header-content">

                <div class="header-left">

                    <div class="header-icon">
                        <i class="fas fa-users"></i>
                    </div>

                    <div>

                        <span class="header-badge">
                            User Management
                        </span>

                        <h2>Create User</h2>

                        <p>Add a new user to the system</p>

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

        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="card premium-block">

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Role <span class="text-danger">*</span></label>

                            <select name="role_id" class="form-control">

                                <option value="">Select Role</option>

                                @foreach($roles as $role)

                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>

                                        {{ $role->name }}

                                    </option>

                                @endforeach

                            </select>

                            @error('role_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Employee Code <span class="text-danger">*</span></label>

                            <input type="text" name="employee_code" class="form-control" value="{{ old('employee_code') }}"
                                placeholder="Enter Employee Code">

                            @error('employee_code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Full Name <span class="text-danger">*</span></label>

                            <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                placeholder="Enter Full Name">

                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Email <span class="text-danger">*</span></label>

                            <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                placeholder="Enter Email">

                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Mobile <span class="text-danger">*</span></label>

                            <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}"
                                placeholder="Enter Mobile Number">

                            @error('mobile')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Profile Photo</label>

                            <input type="file" name="profile_photo" class="form-control">

                            @error('profile_photo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Password <span class="text-danger">*</span></label>

                            <input type="password" name="password" class="form-control" placeholder="Enter Password">

                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>

                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Confirm Password">

                        </div>



                    </div>

                    <div class="mt-4">

                        <button type="submit" class="btn btn-create">

                            <i class="fas fa-save"></i>

                            Save User

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
