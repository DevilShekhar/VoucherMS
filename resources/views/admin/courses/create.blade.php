@extends('layouts.app')

@section('content')

    <section class="section premium-dashboard">
        <div class="premium-floating-header">
            <div class="header-content">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div>
                        <span class="header-badge">Course Management</span>
                        <h2>Create Course</h2>
                        <p>Add a new course</p>
                    </div>
                </div>
                <div class="premium-head-actions">
                    <a href="{{ route('courses.index') }}" class="btn btn-create"
                       style="background: var(--cloth); color: var(--ink);">
                        <i class="fas fa-arrow-left"></i> Back to Courses
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="section premium-dashboard pt-0">
        <form action="{{ route('courses.store') }}" method="POST">
            @csrf

            <div class="card premium-block">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Course Code</label>
                            <input type="text" name="course_code" class="form-control"
                                   value="{{ old('course_code') }}" placeholder="Enter course code">
                            @error('course_code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Course Name</label>
                            <input type="text" name="course_name" class="form-control"
                                   value="{{ old('course_name') }}" placeholder="Enter course name">
                            @error('course_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="4" class="form-control"
                                      placeholder="Enter course description">{{ old('description') }}</textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-create">
                            <i class="fas fa-save"></i> Save Course
                        </button>
                        <a href="{{ route('courses.index') }}" class="btn"
                           style="background: var(--cloth); color: var(--ink);">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </section>

@endsection
