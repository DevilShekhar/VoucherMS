
@extends('layouts.app')
    @section('content')
    <section class="section premium-dashboard">
        <div class="premium-header">
            <div class="premium-header-overlay"></div>
            <div class="premium-header-left">
                <div class="premium-header-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="premium-header-content">
                    <span class="premium-tag"> USER MANAGEMENT</span>
                    <h1>Create User</h1>
                    <p>Add a new user to the system</p>
                </div>
            </div>
            <div class="premium-header-right">
                <a href="{{ route('users.index') }}" class="premium-back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Users
                </a>
            </div>
            <!-- Decorative Shapes -->
            <div class="shape circle-1"></div>
            <div class="shape circle-2"></div>
            <div class="shape circle-3"></div>
            <div class="dots"></div>
        </div>
    </section>
    <section class="section premium-dashboard pt-0">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card premium-block">
                <div class="card-body">
                    <div class="row">
                        <!-- Role -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user-tag"></i>
                                </span>
                                <select name="role_id" class="form-control">
                                    <option value="">Select Role</option>

                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}"
                                            @selected(old('role_id') == $role->id)>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('role_id')
                            <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <!-- Employee Code -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Employee Code <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-id-badge"></i>
                                </span>
                                <input type="text" name="employee_code" class="form-control" value="{{ old('employee_code') }}" placeholder="Enter Employee Code">
                            </div>
                            @error('employee_code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- Full Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter Full Name">
                            </div>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- Email -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Enter Email">
                            </div>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- Mobile -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mobile <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}" placeholder="Enter Mobile Number">
                            </div>
                            @error('mobile')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- Profile Photo -->
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold">
                                Profile Photo
                            </label>
                            <label class="upload-area">
                                <input type="file" name="profile_photo" id="profile_photo" accept="image/*">
                                <div class="upload-content">
                                    <div class="upload-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Click to upload or drag and drop </h6>
                                        <p class="mb-0">   JPG, PNG (Max. 2MB) </p>
                                    </div>
                                </div>
                                <div id="imagePreview" class="image-preview d-none">
                                    <img id="previewImg">
                                </div>
                            </label>
                            @error('profile_photo')
                                <small class="text-danger"> {{ $message }}</small>
                            @enderror
                        </div>
                        <!-- Password -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password">
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- Confirm Password -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Location <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user-tag"></i>
                                </span>
                                <select name="location_id" class="form-control">
                                    <option value="">Select Location</option>

                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}"
                                            @selected(old('location_id') == $location->id)>
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('location_id')
                            <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="form-footer">
                        <a href="{{ route('users.index') }}" class="btn btn-cancel">
                            <i class="fas fa-times me-2"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-save">
                            <i class="fas fa-save me-2"></i> Save User
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
