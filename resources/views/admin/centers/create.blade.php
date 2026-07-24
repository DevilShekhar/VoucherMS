@extends('layouts.app')

@section('content')

    <section class="section premium-dashboard">

    <div class="premium-header">

        <div class="premium-header-overlay"></div>

             <div class="premium-header-left">

                    <div class="premium-header-icon">
                        <i class="fas fa-building"></i>
                    </div>

                <div class="premium-header-content">
                    <span class="premium-tag">CENTER MANAGEMENT</span>
                    <h2 class="text-white">Create Center</h2>
                    <p>Add a new training center</p>
                </div>

        </div>

        <div class="premium-header-right">

            <a href="{{ route('centers.index') }}" class="premium-back-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Centers
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
                                Center Executive
                            </label>

                            <select name="center_exe_id" class="form-control">

                                <option value="">Select Cenetr Executive</option>

                                @foreach($centerexes as $centerexe)

                                    <option value="{{ $centerexe->id }}" {{ old('center_exe_id') == $centerexe->id ? 'selected' : '' }}>

                                       {{ $centerexe->name }} ({{ $centerexe->email }})

                                    </option>

                                @endforeach

                            </select>

                            @error('center_exe_id')
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
                    </div>

                    <div class="mt-4">

                        <button type="submit" class="btn btn-save">

                            <i class="fas fa-save me-2"></i>

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
