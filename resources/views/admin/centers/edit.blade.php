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

                        <h2>Edit Center</h2>

                        <p>Update center information</p>

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

        <form action="{{ route('centers.update', $center->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="card premium-block">

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Center Code</label>

                            <input type="text" name="center_code" class="form-control"
                                value="{{ old('center_code', $center->center_code) }}">

                            @error('center_code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Center Name</label>

                            <input type="text" name="center_name" class="form-control"
                                value="{{ old('center_name', $center->center_name) }}">

                            @error('center_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Manager</label>

                            <select name="center_exe_id" class="form-control">

                                <option value="">Select Manager</option>

                                @foreach($centerexes as $centerexe)

                                    <option value="{{ $centerexe->id }}" {{ old('center_exe_id', $center->centerexe) == $centerexe->id ? 'selected' : '' }}>

                                        {{ $centerexe->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Phone</label>

                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $center->phone) }}">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Email</label>

                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $center->email) }}">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Country</label>

                            <input type="text" name="country" class="form-control"
                                value="{{ old('country', $center->country) }}">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">State</label>

                            <input type="text" name="state" class="form-control" value="{{ old('state', $center->state) }}">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">City</label>

                            <input type="text" name="city" class="form-control" value="{{ old('city', $center->city) }}">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Pincode</label>

                            <input type="text" name="pincode" class="form-control"
                                value="{{ old('pincode', $center->pincode) }}">

                        </div>

                        <div class="col-12 mb-3">

                            <label class="form-label">Address</label>

                            <textarea name="address" rows="3"
                                class="form-control">{{ old('address', $center->address) }}</textarea>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Status</label>

                            <select name="status" class="form-control">

                                <option value="1" {{ old('status', $center->status) == 1 ? 'selected' : '' }}>

                                    Active

                                </option>

                                <option value="0" {{ old('status', $center->status) == 0 ? 'selected' : '' }}>

                                    Inactive

                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="mt-4">

                        <button type="submit" class="btn btn-create">

                            <i class="fas fa-save"></i>

                            Update Center

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
