@can('candidates.create')
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
                        <span class="premium-tag">Candidate Management</span>
                        <h2 class="text-white">Create Candidate</h2>
                        <p>Add new candidate with complete details</p>
                    </div>
                </div>
                <div class="premium-header-right">
                    <a href="{{ route('candidates.index') }}" class="premium-back-btn">
                        <i class="fas fa-arrow-left"></i>
                        Back to Candidates
                    </a>
                </div>
                <div class="shape circle-1"></div>
                <div class="shape circle-2"></div>
                <div class="shape circle-3"></div>
                <div class="dots"></div>
            </div>
        </section>

        <section class="section premium-dashboard pt-0">
            @if ($errors->any())
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card premium-block">
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle"></i>
                        A new lead will be automatically created and marked as converted when you submit this form.
                    </div>

                    <form action="{{ route('candidates.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    Center <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="center_id"
                                    id="center_id"
                                    class="form-control"
                                    required
                                    {{ optional(Auth::user()->role)->name === 'Center Admin' ? 'disabled' : '' }}>

                                    <option value="">-- Select Center --</option>

                                    @foreach($centers as $center)
                                        <option value="{{ $center->id }}"
                                            {{ old('center_id', $centers->first()->id ?? '') == $center->id ? 'selected' : '' }}>
                                            {{ $center->center_name }}
                                        </option>
                                    @endforeach

                                </select>

                                @if(optional(Auth::user()->role)->name === 'Center Admin')
                                    <input type="hidden"
                                        name="center_id"
                                        value="{{ $centers->first()->id ?? '' }}">
                                @endif

                                @error('center_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Course Category</label>
                                <select name="course_category_id" id="course_category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('course_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Course <span class="text-danger">*</span></label>
                                <select name="course_id" id="course_id" class="form-control" required>
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

                            <div class="col-md-4 mb-3">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" id="first_name" class="form-control" required value="{{ old('first_name') }}">
                                @error('first_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="">-- Select --</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Mobile <span class="text-danger">*</span></label>
                                <input type="text" name="mobile" id="mobile" class="form-control" required value="{{ old('mobile') }}">
                                @error('mobile')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Company</label>
                                <input type="text" name="company" id="company" class="form-control" value="{{ old('company') }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">GST Number</label>
                                <input type="text" name="gst_number" class="form-control" value="{{ old('gst_number') }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" id="city" class="form-control" value="{{ old('city') }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control" value="{{ old('state') }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" value="{{ old('country') }}">
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" rows="2" class="form-control">{{ old('address') }}</textarea>
                            </div>
                        </div>

                        <div class="form-footer">
                            <a href="{{ route('candidates.index') }}" class="btn btn-cancel">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-save"></i> Create Candidate
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    @endsection

    @section('scripts')
        <script>
            $(document).ready(function() {
                // Course Category Filter
                $('#course_category_id').change(function() {
                    let categoryId = $(this).val();
                    $('#course_id').html('<option value="">Loading...</option>');

                    if (categoryId == '') {
                        $('#course_id').html('<option value="">Select Course</option>');
                        return;
                    }

                    $.ajax({
                        url: '/courses/by-category/' + categoryId,
                        type: 'GET',
                        success: function(response) {
                            let options = '<option value="">Select Course</option>';
                            $.each(response, function(index, course) {
                                options += `<option value="${course.id}">${course.course_name}</option>`;
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
