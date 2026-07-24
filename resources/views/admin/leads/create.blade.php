@extends('layouts.app')

@section('title', 'Create Lead')

@section('content')

    <!-- Header -->
    <section class="section premium-dashboard">
        <div class="premium-header">
            <div class="premium-header-overlay"></div>
            <div class="premium-header-left">
                <div class="premium-header-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="premium-header-content">
                    <span class="premium-tag">LEAD MANAGEMENT</span>
                    <h2 class="text-white">Create Lead</h2>
                    <p>Add a new lead / candidate</p>
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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('leads.store') }}" method="POST">
            @csrf

            <div class="card premium-block">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mobile <span class="text-danger">*</span></label>
                            <input type="tel" name="mobile" class="form-control" value="{{ old('mobile') }}">
                            @error('mobile')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        @if(Auth::user()->hasAnyRole(['Manager', 'Owner', 'Super Admin']))
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Location
                                </label>

                                <select name="location_id" id="location" class="form-select">

                                    <option value="">Select Location</option>

                                    @foreach($locations as $location)

                                        <option value="{{ $location->id }}">
                                            {{ $location->name }}
                                        </option>

                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Assign To
                                    <small class="text-muted">(Leave empty for auto assignment)</small>
                                </label>
                                <select name="assigned_to" class="form-select">
                                    <option value="">Auto Assign (Round Robin)</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
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
                            <label class="form-label">Candidate Name <span class="text-danger">*</span></label>
                            <input type="text" name="candidate_name" class="form-control"
                                value="{{ old('candidate_name') }}">
                            @error('candidate_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>



                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Company</label>
                            <input type="text" name="company" class="form-control" value="{{ old('company') }}">
                            @error('company')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city') }}">
                            @error('city')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Course <span class="text-danger">*</span></label>
                            <select name="course_id" id="course_id" class="form-select">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->course_name }}
                                    </option>
                                @endforeach
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3" id="other_course_div" style="display: none;">
                            <label class="form-label">New Course Name <span class="text-danger">*</span></label>
                            <input type="text" name="other_course_name" id="other_course_name" class="form-control"
                                value="{{ old('other_course_name') }}" placeholder="Enter new course name">
                        </div>

                        <script>
                            document.getElementById('course_id').addEventListener('change', function () {
                                const div = document.getElementById('other_course_div');
                                div.style.display = (this.value === 'other') ? 'block' : 'none';
                            });

                            // Trigger on page load if "other" was selected
                            if (document.getElementById('course_id').value === 'other') {
                                document.getElementById('other_course_div').style.display = 'block';
                            }
                        </script>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Priority</label>
                            <select name="priority" class="form-select">
                                <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ old('priority', 'Medium') == 'Medium' ? 'selected' : '' }}>Medium
                                </option>
                                <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                            </select>
                            @error('priority')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <input type="hidden" name="status" value="New">

                        <div class="col-12 mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" rows="4" class="form-control">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-save">
                            <i class="fas fa-save me-2"></i> Save Lead
                        </button>
                        <a href="{{ route('leads.index') }}" class="btn"
                            style="background: var(--cloth); color: var(--ink);">
                            <i class="fas fa-times"></i> Cancel
                        </a>
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

                    $('select[name="assigned_to"]').html(options); // Replace old options
                }
            });

        });
    </script>
@endsection