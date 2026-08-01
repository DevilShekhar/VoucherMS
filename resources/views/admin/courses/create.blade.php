@can('courses.create')
    @extends('layouts.app')

    @section('content')

        <section class="section premium-dashboard">

            <div class="premium-header">

                <div class="premium-header-overlay"></div>

                <div class="premium-header-left">

                    <div class="premium-header-icon">
                        <i class="fas fa-book"></i>
                    </div>

                    <div class="premium-header-content">
                        <span class="premium-tag">COURSE MANAGEMENT</span>
                        <h2 class="text-white">Create Course</h2>
                        <p>Add a new course</p>
                    </div>

                </div>

                <div class="premium-header-right">

                    <a href="{{ route('courses.index') }}" class="premium-back-btn">
                        <i class="fas fa-arrow-left"></i>
                        Back to Courses
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
            <form action="{{ route('courses.store') }}" method="POST">
                @csrf

                <div class="card premium-block">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label">Course Category</label>

                                <select name="course_category_id"
                                    class="form-select @error('course_category_id') is-invalid @enderror">
                                    <option value="">Select Category</option>

                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('course_category_id', $course->course_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('course_category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Course Code</label>
                                <input type="text" name="course_code" class="form-control check-unique"
                                    value="{{ old('course_code') }}" placeholder="Enter course code" data-table="courses"
                                    data-column="course_code" data-message="This course code already exists.">
                                @error('course_code')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Course Name</label>
                                <input type="text" name="course_name" class="form-control" value="{{ old('course_name') }}"
                                    placeholder="Enter course name">
                                @error('course_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" rows="4" class="form-control"
                                    placeholder="Enter course description">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="form-footer">
                            <a href="{{ route('courses.index') }}" class="btn btn-cancel">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-save me-2"></i> Save Course
                            </button>

                        </div>
                    </div>
                </div>
            </form>
        </section>

    @endsection
@else
    @php
        abort(403);
    @endphp
@endcan
