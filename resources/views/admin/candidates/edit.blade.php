@can('candidates.edit')
    @extends('layouts.app')

    @section('content')
        <section class="section premium-dashboard">
            <div class="premium-header">
                <div class="premium-header-overlay"></div>
                <div class="premium-header-left">
                    <div class="premium-header-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="premium-header-content">
                        <span class="premium-tag">Candidate Management</span>
                        <h1 class="text-white">Edit</h2>
                            <p>Edit converted candidate</p>
                    </div>
                </div>
                <!-- Decorative Shapes -->
                <div class="shape circle-1"></div>
                <div class="shape circle-2"></div>
                <div class="shape circle-3"></div>
                <div class="dots"></div>
            </div>
        </section>
        <section class="section premium-dashboard pt-0">
            <div class="card premium-block">
                <div class="card-body">
                    <form action="{{ route('candidates.update', $candidate) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" class="form-control"
                                    value="{{ old('first_name', $candidate->first_name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control"
                                    value="{{ old('last_name', $candidate->last_name) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mobile <span class="text-danger">*</span></label>
                                <input type="text" name="mobile" class="form-control"
                                    value="{{ old('mobile', $candidate->mobile) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $candidate->email) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ $candidate->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $candidate->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ $candidate->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control"
                                    value="{{ $candidate->dob ? $candidate->dob->format('Y-m-d') : '' }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company</label>
                                <input type="text" name="company" class="form-control"
                                    value="{{ old('company', $candidate->company) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">GST Number</label>
                                <input type="text" name="gst_number" class="form-control"
                                    value="{{ old('gst_number', $candidate->gst_number) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Center <span class="text-danger">*</span></label>
                                <select name="center_id" class="form-select">
                                    <option value="">Select Center</option>
                                    @foreach($centers as $center)
                                        <option value="{{ $center->id }}" {{ $candidate->center_id == $center->id ? 'selected' : '' }}>
                                            {{ $center->center_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="col-md-6 mb-3">
                                <label class="form-label">Course <span class="text-danger">*</span></label>
                                <select name="course_id" class="form-select">
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ $candidate->course_id == $course->id ? 'selected' : ''
                                        }}>
                                        {{ $course->course_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    Course Category
                                </label>

                                <select name="course_category_id" id="course_category_id" class="form-select">
                                    <option value="">Select Category</option>

                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    Course
                                </label>

                                <select name="course_id" id="course_id" class="form-select">
                                    <option value="">Select Course</option>

                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->course_name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('course_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control"
                                    rows="3">{{ old('address', $candidate->address) }}</textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city', $candidate->city) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control"
                                    value="{{ old('state', $candidate->state) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control"
                                    value="{{ old('country', $candidate->country) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="Active" {{ $candidate->status == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ $candidate->status == 'Inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                    <option value="Completed" {{ $candidate->status == 'Completed' ? 'selected' : '' }}>Completed
                                    </option>
                                    <option value="Cancelled" {{ $candidate->status == 'Cancelled' ? 'selected' : '' }}>Cancelled
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-footer">
                            <a href="{{ route('candidates.show', $candidate) }}" class="btn btn-cancel">Cancel</a>
                            <button type="submit" class="btn btn-save">Update Candidate</button>

                        </div>
                    </form>
                </div>
            </div>
        </section>
        <script>
            $(document).ready(function () {

                $('#course_category_id').change(function () {

                    let categoryId = $(this).val();

                    $('#course_id').html('<option value="">Loading...</option>');

                    if (categoryId == '') {
                        $('#course_id').html('<option value="">Select Course</option>');
                        return;
                    }

                    $.ajax({
                        url: '/courses/by-category/' + categoryId,
                        type: 'GET',
                        success: function (response) {

                            let options = '<option value="">Select Course</option>';

                            $.each(response, function (index, course) {
                                options += `<option value="${course.id}">
                                                                    ${course.course_name}
                                                                </option>`;
                            });

                            $('#course_id').html(options);
                        }
                    });

                });

            });

        </script>
    @endsection
@else
    @php
        abort(403);
    @endphp
@endcan
