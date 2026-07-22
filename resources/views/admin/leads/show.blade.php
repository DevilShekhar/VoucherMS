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
                        <span class="header-badge">Lead Management</span>
                        <h2>Lead Details</h2>
                        <p>Complete lead information</p>
                    </div>
                </div>
                <div class="premium-head-actions">
                    <a href="{{ route('leads.index') }}" class="btn mb-2" style="background:var(--cloth);color:var(--ink);">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-create mb-2">
                        <i class="fas fa-edit"></i> Edit Lead
                    </a>
                    <button class="btn btn-dark mb-2" data-bs-toggle="modal" data-bs-target="#addFollowupModal">
                        <i class="fas fa-phone"></i> Add Follow Up
                    </button>

                </div>
            </div>
        </div>
    </section>

    <section class="section premium-dashboard pt-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="card premium-block">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-4">
                                <div class="d-flex">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($lead->candidate_name) }}&background=f5f5f5&color=000"
                                        class="rounded-circle border" width="150" height="150">
                                    <div class="ms-4">
                                        <h3 class="fw-bold mb-1">{{ $lead->candidate_name }}</h3>
                                        <div class="text-muted">{{ $lead->lead_no }}</div>
                                        <div class="mt-3">
                                            <div><i class="fas fa-envelope text-warning"></i> {{ $lead->email ?: '-' }}
                                            </div>
                                            <div><i class="fas fa-phone text-warning"></i> {{ $lead->mobile }}</div>
                                            <div><i class="fas fa-building text-warning"></i> {{ $lead->company ?: '-' }}
                                            </div>
                                            <div><i class="fas fa-map-marker-alt text-warning"></i> {{ $lead->city ?: '-' }}
                                            </div>
                                        </div>
                                        <span class="badge bg-warning text-dark mt-3">{{ strtoupper($lead->status) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <th width="40%">Assigned To</th>
                                        <td>{{ $lead->assignedUser->name ?? 'Unassigned' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Center</th>
                                        <td>{{ $lead->center->center_name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Course</th>
                                        <td>{{ $lead->course->course_name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Priority</th>
                                        <td>
                                            @if($lead->priority == 'High')
                                                <span class="badge bg-danger">High</span>
                                            @elseif($lead->priority == 'Medium')
                                                <span class="badge bg-warning text-dark">Medium</span>
                                            @else
                                                <span class="badge bg-success">Low</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-lg-4">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <th width="40%">Status</th>
                                        <td><span class="badge bg-dark">{{ $lead->status }}</span></td>
                                    </tr>
                                    <tr>
                                        <th>Created By</th>
                                        <td>{{ $lead->createdBy->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ $lead->created_at->format('d M Y h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{ $lead->updated_at->format('d M Y h:i A') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-6">
                <div class="card premium-block h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle text-warning"></i> Lead Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th width="35%">Candidate</th>
                                <td>{{ $lead->candidate_name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $lead->email ?: '-' }}</td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td>{{ $lead->mobile }}</td>
                            </tr>
                            <tr>
                                <th>Company</th>
                                <td>{{ $lead->company ?: '-' }}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{ $lead->city ?: '-' }}</td>
                            </tr>
                            <tr>
                                <th>Course</th>
                                <td>{{ $lead->course->course_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Center</th>
                                <td>{{ $lead->center->center_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Remarks</th>
                                <td>{{ $lead->remarks ?: '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Communication Section - Now shows real data -->
            <div class="col-lg-6 mt-3">
                <div class="card premium-block h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-comments text-warning"></i> Communication</h5>
                        <button class="btn btn-create btn-sm" data-bs-toggle="modal" data-bs-target="#addFollowupModal">
                            <i class="fas fa-plus"></i> Add Follow-up
                        </button>
                    </div>
                    <div class="card-body">
                        @if($lead->followups->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                <h5>No Communication Yet</h5>
                                <p class="text-muted">All communication records will appear here.</p>
                            </div>
                        @else
                            <div class="list-group">
                                @foreach($lead->followups->take(3) as $followup) <!-- Show latest 3 -->
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <strong>{{ \Carbon\Carbon::parse($followup->followup_date)->format('d M Y') }}</strong>
                                            <small>{{ $followup->createdBy?->name ?? 'System' }}</small>
                                        </div>
                                        <p class="mb-1">{{ Str::limit($followup->discussion, 90) }}</p>
                                        <small class="text-muted">
                                            Status: <span class="badge bg-info">{{ $followup->status }}</span>
                                            @if($followup->next_followup)
                                                | Next: {{ \Carbon\Carbon::parse($followup->next_followup)->format('d M Y') }}
                                            @endif
                                        </small>
                                    </div>
                                @endforeach
                            </div>
                            @if($lead->followups->count() > 3)
                                <div class="text-center mt-3">
                                    <small><a href="#followup-history" class="text-warning">View all follow-ups ↓</a></small>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="row mt-4">
        <!-- Follow-up History (Full with Pagination) -->
        <div class="col-lg-12 mb-2" id="followup-history">
            <div class="card premium-block h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-history text-warning"></i> Follow-up History</h5>
                    <button class="btn btn-sm btn-create" data-bs-toggle="modal" data-bs-target="#addFollowupModal">
                        <i class="fas fa-plus"></i> Add Follow-up
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-white">
                                <tr>
                                    <th>Date</th>
                                    <th>Discussion</th>
                                    <th>Next Follow-up</th>
                                    <th>Status</th>
                                    <th>By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lead->followups as $followup)
                                                        <tr>
                                                            <td>
                                                                {{ $followup->followup_date
                                    ? \Carbon\Carbon::parse($followup->followup_date)->format('d M Y, h:i A')
                                    : now()->format('d M Y, h:i A') }}
                                                            </td>
                                                            <td>{{ Str::limit($followup->discussion, 80) }}</td>
                                                            <td>
                                                                @if($followup->next_followup)
                                                                    {{ \Carbon\Carbon::parse($followup->next_followup)->format('d M Y, h:i A') }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge bg-{{ in_array($followup->status, ['Converted', 'Closed']) ? 'success' : 'info' }}">
                                                                    {{ $followup->status }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $followup->createdBy?->name ?? 'System' }}</td>
                                                        </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="fas fa-phone-alt fa-3x text-muted mb-3"></i>
                                            <h6>No Follow-up Available</h6>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ====================== ADD FOLLOW-UP MODAL ====================== -->
    <div class="modal fade" id="addFollowupModal" tabindex="-1" aria-labelledby="addFollowupModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFollowupModalLabel">Add New Follow-up</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('leads.followups.store', $lead) }}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <!-- Today's Follow-up (with Time) -->
                            <div class="col-md-6">
                                <label class="form-label">Follow-Up Date & Time</label>
                                <input type="datetime-local" name="followup_date" class="form-control"
                                    value="{{ now()->format('Y-m-d\TH:i') }}">
                                <small class="text-muted">Automatically set to the current date and time.</small>
                            </div>

                            <!-- Next Follow-up (with Time) -->
                            <div class="col-md-6">
                                <label class="form-label">Next Follow-up Date <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="next_followup" class="form-control"
                                    value="{{ old('next_followup') }}" min="{{ now()->format('Y-m-d') }}T00:00">
                                <small class="text-muted">Next day onwards</small>
                            </div>
                            <div class="mt-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="Pending">Pending</option>
                                    <option value="Contacted">Contacted</option>
                                    <option value="Interested">Interested</option>
                                    <option value="Not Interested">Not Interested</option>
                                    <option value="Converted">Converted</option>
                                </select>
                            </div>
                        </div>



                        <div class="mt-3">
                            <label class="form-label">Discussion <span class="text-danger">*</span></label>
                            <textarea name="discussion" class="form-control" rows="5" required
                                placeholder="Write detailed discussion with the candidate...">{{ old('discussion') }}</textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Follow-up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
