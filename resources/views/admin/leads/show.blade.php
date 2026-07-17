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
                <a href="{{ route('leads.edit',$lead->id) }}" class="btn btn-create mb-2">
                    <i class="fas fa-edit"></i> Edit Lead
                </a>
                <a href="#" class="btn btn-dark mb-2">
                    <i class="fas fa-phone"></i> Follow Up
                </a>
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
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($lead->candidate_name) }}&background=f5f5f5&color=000" class="rounded-circle border" width="150" height="150">
                            <div class="ms-4">
                                <h3 class="fw-bold mb-1">{{ $lead->candidate_name }}</h3>
                                <div class="text-muted">{{ $lead->lead_no }}</div>
                                <div class="mt-3">
                                    <div><i class="fas fa-envelope text-warning"></i> {{ $lead->email ?: '-' }}</div>
                                    <div><i class="fas fa-phone text-warning"></i> {{ $lead->mobile }}</div>
                                    <div><i class="fas fa-building text-warning"></i> {{ $lead->company ?: '-' }}</div>
                                    <div><i class="fas fa-map-marker-alt text-warning"></i> {{ $lead->city ?: '-' }}</div>
                                </div>
                                <span class="badge bg-warning text-dark mt-3">{{ strtoupper($lead->status) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <table class="table table-borderless mb-0">
                            <tr><th width="40%">Assigned To</th><td>{{ $lead->assignedUser->name ?? 'Unassigned' }}</td></tr>
                            <tr><th>Center</th><td>{{ $lead->center->center_name ?? '-' }}</td></tr>
                            <tr><th>Course</th><td>{{ $lead->course->course_name ?? '-' }}</td></tr>
                            <tr><th>Priority</th><td>
                                @if($lead->priority=='High')
                                    <span class="badge bg-danger">High</span>
                                @elseif($lead->priority=='Medium')
                                    <span class="badge bg-warning text-dark">Medium</span>
                                @else
                                    <span class="badge bg-success">Low</span>
                                @endif
                            </td></tr>
                        </table>
                    </div>
                    <div class="col-lg-4">
                        <table class="table table-borderless mb-0">
                            <tr><th width="40%">Status</th><td><span class="badge bg-dark">{{ $lead->status }}</span></td></tr>
                            <tr><th>Created By</th><td>{{ $lead->createdBy->name ?? '-' }}</td></tr>
                            <tr><th>Created At</th><td>{{ $lead->created_at->format('d M Y h:i A') }}</td></tr>
                            <tr><th>Updated At</th><td>{{ $lead->updated_at->format('d M Y h:i A') }}</td></tr>
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
                    <tr><th width="35%">Candidate</th><td>{{ $lead->candidate_name }}</td></tr>
                    <tr><th>Email</th><td>{{ $lead->email ?: '-' }}</td></tr>
                    <tr><th>Mobile</th><td>{{ $lead->mobile }}</td></tr>
                    <tr><th>Company</th><td>{{ $lead->company ?: '-' }}</td></tr>
                    <tr><th>City</th><td>{{ $lead->city ?: '-' }}</td></tr>
                    <tr><th>Course</th><td>{{ $lead->course->course_name ?? '-' }}</td></tr>
                    <tr><th>Center</th><td>{{ $lead->center->center_name ?? '-' }}</td></tr>
                    <tr><th>Remarks</th><td>{{ $lead->remarks ?: '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card premium-block h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-comments text-warning"></i> Communication</h5>
            </div>
            <div class="card-body text-center py-5">
                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                <h5>No Communication Found</h5>
                <p class="text-muted">Communication history will appear here once follow-ups are added.</p>
                <a href="#" class="btn btn-create"><i class="fas fa-plus"></i> Add Follow-up</a>
            </div>
        </div>
    </div>
</div>
</section>

<div class="row mt-4">
    {{-- Follow-up History --}}
    <div class="col-lg-6 mb-2">
        <div class="card premium-block h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-history text-warning"></i> Follow-up History</h5>
                <a href="#" class="btn btn-sm btn-create"><i class="fas fa-plus"></i> Add Follow-up</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-white">
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Mode</th>
                                <th>Executive</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="fas fa-phone-alt fa-3x text-muted mb-3"></i>
                                    <h6>No Follow-up Available</h6>
                                    <small class="text-muted">Follow-up history will appear here.</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white text-center">
                <a href="#" class="btn btn-outline-warning"><i class="fas fa-list"></i> View All Follow-ups</a>
            </div>
        </div>
    </div>

    {{-- Activity Timeline --}}
    <div class="col-lg-6 mb-2">
        <div class="card premium-block h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-stream text-warning"></i> Activity Timeline</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Lead Created</h6>
                            <small class="text-muted">{{ $lead->created_at->format('d M Y h:i A') }}</small>
                            <div class="text-muted">by {{ $lead->createdBy->name ?? '-' }}</div>
                        </div>
                    </div>

                    @if($lead->assignedUser)
                    <div class="timeline-item">
                        <div class="timeline-dot bg-warning"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Lead Assigned</h6>
                            <small>Assigned to <strong>{{ $lead->assignedUser->name }}</strong></small>
                        </div>
                    </div>
                    @endif

                    <div class="timeline-item">
                        <div class="timeline-dot bg-info"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Current Status</h6>
                            <span class="badge bg-dark">{{ $lead->status }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white text-center">
                <a href="#" class="btn btn-outline-warning"><i class="fas fa-clock"></i> View Full Timeline</a>
            </div>
        </div>
    </div>
</div>
@endsection
