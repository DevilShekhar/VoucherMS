@extends('layouts.app')

@section('title', 'Edit Lead')

@section('content')
    <section class="section premium-dashboard">
        <div class="premium-floating-header">
            <div class="header-content">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div>
                          <span class="header-badge">Lead Management</span>
                          <h2>Edit Lead</h2>
                          <p>Update lead information</p>
                    </div>
                </div>
                <div class="premium-head-actions">
                    <a href="{{ route('leads.index') }}" class="btn btn-create"
                        style="background: var(--cloth); color: var(--ink);">
                        <i class="fas fa-arrow-left"></i> Back to Leads
                    </a>
                </div>
            </div>
        </div>
    </section>
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
                            <label class="form-label">Course</label>
                            <select name="course_id" class="form-select">
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id', $lead->course_id) == $course->id ? 'selected' : '' }}>
                                        {{ $course->course_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Center</label>
                            <select name="center_id" class="form-select">
                                <option value="">Select Center</option>
                                @foreach($centers as $center)
                                    <option value="{{ $center->id }}" {{ old('center_id', $lead->center_id) == $center->id ? 'selected' : '' }}>
                                        {{ $center->center_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if(auth()->user()->role_id != 4)
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Assigned To</label>
                                <select name="assigned_to" class="form-select">
                                    <option value="">Auto Assign</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('assigned_to', $lead->assigned_to) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
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

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-create">
                            <i class="fas fa-save"></i> Update Lead
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

@endsection
