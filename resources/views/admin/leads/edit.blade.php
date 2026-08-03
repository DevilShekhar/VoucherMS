@can('leads.edit')
@extends('layouts.app')

@section('title', 'Edit Lead')

    @section('content')

        <!-- Header -->
        <section class="section premium-dashboard">

            <div class="premium-header">

                <div class="premium-header-overlay"></div>

                <div class="premium-header-left">

                    <div class="premium-header-icon">
                        <i class="fas fa-user-edit"></i>
                    </div>

                    <div class="premium-header-content">
                        <span class="premium-tag">LEAD MANAGEMENT</span>
                        <h2 class="text-white">Edit Lead</h2>
                        <p>Update lead information</p>
                    </div>

                </div>

                <div class="premium-header-right">

                    <a href="{{ route('leads.index') }}" class="premium-back-btn">
                        <i class="fas fa-arrow-left"></i>
                        Back to Leads
                    </a>

                </div>

                <!-- Decorative Shapes -->
                <div class="shape circle-1"></div>
                <div class="shape circle-2"></div>
                <div class="shape circle-3"></div>
                <div class="dots"></div>

            </div>

        </section>

        <!-- Form -->
        <section class="section premium-dashboard pt-0">
            <form action="{{ route('leads.update', $lead->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card premium-block">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Candidate Name <span class="text-danger">*</span></label>
                                <input type="text" name="candidate_name" class="form-control"
                                    value="{{ old('candidate_name', $lead->candidate_name) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mobile <span class="text-danger">*</span></label>
                                <input type="tel" name="mobile" class="form-control" value="{{ old('mobile', $lead->mobile) }}"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $lead->email) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company</label>
                                <input type="text" name="company" class="form-control"
                                    value="{{ old('company', $lead->company) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city', $lead->city) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Course Category</label>

                                <select name="course_category_id" id="course_category_id" class="form-select">
                                    <option value="">Select Category</option>

                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('course_category_id', $lead->course_category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Course</label>
                                <select name="course_id" id="course_id" class="form-select">
                                    <option value="">Select Course</option>

                                    @foreach($courses->where('course_category_id', old('course_category_id', $lead->course_category_id)) as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id', $lead->course_id) == $course->id ? 'selected' : '' }}>
                                            {{ $course->course_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if(Auth::user()->hasAnyRole(['Manager', 'Owner', 'Super Admin', 'Admin']))
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Distribution Location
                                        <small class="text-muted">(Where vouchers will be distributed)</small>
                                    </label>

                                    <select name="location_id" id="location" class="form-select">
                                        <option value="">Select Location</option>

                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}" {{ old('location_id', $lead->location_id) == $location->id ? 'selected' : '' }}>
                                                {{ $location->name }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @error('location_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        Assign To
                                        <small class="text-muted">(Leave empty for auto assignment)</small>
                                    </label>

                                    <select name="assigned_to" class="form-select" id="assigned_to">
                                        <option value=""></option>

                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('assigned_to', $lead->assigned_to) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('assigned_to')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            @endif

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Priority</label>
                                <select name="priority" class="form-select">
                                    <option value="Low" {{ old('priority', $lead->priority) == 'Low' ? 'selected' : '' }}>Low
                                    </option>
                                    <option value="Medium" {{ old('priority', $lead->priority) == 'Medium' ? 'selected' : '' }}>
                                        Medium</option>
                                    <option value="High" {{ old('priority', $lead->priority) == 'High' ? 'selected' : '' }}>High
                                    </option>
                                </select>
                            </div>

                            <input type="hidden" name="status" value="{{ old('status', $lead->status) }}">

                            <div class="col-12 mb-3">
                                <label class="form-label">Remarks</label>
                                <textarea name="remarks" rows="4"
                                    class="form-control">{{ old('remarks', $lead->remarks) }}</textarea>
                            </div>

                        </div>

                        <div class="form-footer">
                            <a href="{{ route('leads.index') }}" class="btn btn-cancel">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-save me-2"></i> Update Lead
                            </button>

                        </div>
                    </div>
                </div>
            </form>
        </section>
        <script>
            $('#location').on('change', function () {

                let locationId = $(this).val();

                $.ajax({
                    url: "{{ route('sales.executives.by.location') }}",
                    type: "GET",
                    data: {
                        location_id: locationId
                    },
                    success: function (users) {

                        let options = '<option value="">Auto Assign (Round Robin)</option>';

                        $.each(users, function (i, user) {
                            options += `<option value="${user.id}">${user.name}</option>`;
                        });

                        $('select[name="assigned_to"]').html(options);
                    }
                });

            });
        </script>

        <script>
            $(document).ready(function () {
                $('#assigned_to').select2({
                    theme: 'bootstrap-5',
                    placeholder: 'Search User...',
                    allowClear: true,
                    width: '100%'
                });
            });
        </script>
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
