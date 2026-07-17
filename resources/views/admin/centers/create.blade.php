@extends('layouts.app')

@section('content')

    <section class="section premium-dashboard">

        <div class="premium-floating-header">

            <div class="header-content">

                <div class="header-left">

                    <div class="header-icon">
                        <i class="fas fa-building"></i>
                    </div>

                    <div>

                        <span class="header-badge">
                            Center Management
                        </span>

                        <h2>Create Center</h2>

                        <p>Add a new training center</p>

                    </div>

                </div>

                <div class="premium-head-actions">

                    <a href="{{ route('centers.index') }}" class="btn btn-create"
                        style="background: var(--cloth); color: var(--ink);">

                        <i class="fas fa-arrow-left"></i>
                        Back to Centers

                    </a>

                </div>

            </div>

        </div>

    </section>

    <section class="section premium-dashboard pt-0">

        <form action="{{ route('centers.store') }}" method="POST">

            @csrf

            <div class="card premium-block">

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Center Code <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="center_code" class="form-control" value="{{ old('center_code') }}"
                                placeholder="Enter Center Code">

                            @error('center_code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Center Name <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="center_name" class="form-control" value="{{ old('center_name') }}"
                                placeholder="Enter Center Name">

                            @error('center_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Center Manager
                            </label>

                            <select name="manager_id" class="form-control">

                                <option value="">Select Manager</option>

                                @foreach($managers as $manager)

                                    <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>

                                        {{ $manager->name }}

                                    </option>

                                @endforeach

                            </select>

                            @error('manager_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Phone
                            </label>

                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"
                                placeholder="Enter Phone">

                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                placeholder="Enter Email">

                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Country
                            </label>

                            <input type="text" name="country" class="form-control" value="{{ old('country') }}"
                                placeholder="Enter Country">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                State
                            </label>

                            <input type="text" name="state" class="form-control" value="{{ old('state') }}"
                                placeholder="Enter State">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                City
                            </label>

                            <input type="text" name="city" class="form-control" value="{{ old('city') }}"
                                placeholder="Enter City">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Pincode
                            </label>

                            <input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}"
                                placeholder="Enter Pincode">

                        </div>

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Address
                            </label>

                            <textarea name="address" rows="3" class="form-control"
                                placeholder="Enter Address">{{ old('address') }}</textarea>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select name="status" class="form-control">

                                <option value="1" selected>Active</option>

                                <option value="0">Inactive</option>

                            </select>

                        </div>

                    </div>

                    <div class="mt-4">

                        <button type="submit" class="btn btn-create">

                            <i class="fas fa-save"></i>

                            Save Center

                        </button>

                        <a href="{{ route('centers.index') }}" class="btn"
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
