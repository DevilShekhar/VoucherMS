@extends('layouts.app')

@section('content')
    <section class="section premium-dashboard">
        <div class="premium-floating-header">
            <div class="header-content">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div>
                        <span class="header-badge">Candidate Management</span>
                        <h2>Create Candidate</h2>
                        <p>Convert lead into candidate</p>
                    </div>
                </div>
                <div class="premium-head-actions">
                    <a href="{{ route('candidates.index') }}" class="btn btn-create"
                        style="background: var(--cloth); color: var(--ink);">
                        <i class="fas fa-arrow-left"></i> Back to Candidates
                    </a>
                </div>
            </div>
        </div>
    </section>

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
        <form action="{{ route('candidates.store') }}" method="POST">
            @csrf

            <div class="card premium-block">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Select Lead <span class="text-danger">*</span></label>
                            <select name="lead_id" id="lead_id" class="form-select" required
                                onchange="fillLeadData(this.value)">
                                <option value="">-- Choose Converted Lead --</option>
                                @foreach($leads as $lead)
                                    <option value="{{ $lead->id }}" {{ old('lead_id') == $lead->id ? 'selected' : '' }}>
                                        {{ $lead->lead_no }} - {{ $lead->candidate_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Center <span class="text-danger">*</span></label>
                            <select name="center_id" id="center_id" class="form-select" required>
                                <option value="">-- Select Center --</option>
                                @foreach($centers as $center)
                                    <option value="{{ $center->id }}">{{ $center->center_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Course <span class="text-danger">*</span></label>
                            <select name="course_id" id="course_id" class="form-select" required>
                                <option value="">-- Select Course --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" id="first_name" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mobile <span class="text-danger">*</span></label>
                            <input type="text" name="mobile" id="mobile" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Company</label>
                            <input type="text" name="company" id="company" class="form-control">
                        </div>

                        <!-- Other fields -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">-- Select --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control">
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" rows="3" class="form-control"></textarea>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" id="city" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">State</label>
                            <input type="text" name="state" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control">
                        </div>

                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-create">
                            <i class="fas fa-save"></i> Save Candidate
                        </button>
                        <a href="{{ route('candidates.index') }}" class="btn"
                            style="background: var(--cloth); color: var(--ink);">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection

@section('scripts')
    <script>
        function fillLeadData(leadId) {
            if (!leadId) return;

            fetch(`/candidates/lead/${leadId}`)
                .then(response => response.json())
                .then(data => {
                    // Auto-fill fields
                    document.getElementById('first_name').value = data.candidate_name || '';
                    document.getElementById('mobile').value = data.mobile || '';
                    document.getElementById('email').value = data.email || '';
                    document.getElementById('company').value = data.company || '';
                    document.getElementById('city').value = data.city || '';

                    // Auto-select Center & Course
                    if (data.center_id) {
                        document.getElementById('center_id').value = data.center_id;
                    }
                    if (data.course_id) {
                        document.getElementById('course_id').value = data.course_id;
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
