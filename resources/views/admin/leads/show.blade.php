@extends('layouts.app')

@section('content')
    <section class="section premium-dashboard pt-0">
        <div class="lead-hero">
            <div class="lead-hero-overlay"></div>
            <div class="lead-hero-content">
                <div class="lead-left">
                    <div class="lead-avatar">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="lead-details">
                        <span class="lead-module">
                            <i class="fas fa-layer-group"></i>
                            Lead Management
                        </span>
                        <h2>{{ $lead->first_name }} {{ $lead->last_name }}</h2>
                        <p class="lead-code">
                            <i class="fas fa-id-card"></i>
                            Lead Code :
                            <strong>{{ $lead->lead_code }}</strong>
                        </p>                   
                    </div>
                </div>
                <div class="lead-right">
                    <div class="lead-status">
                        @if($lead->status=='Converted')
                            <span class="status-pill success">
                                <i class="fas fa-check-circle"></i>
                                Converted
                            </span>
                        @elseif($lead->status=='Closed')
                            <span class="status-pill danger">
                                <i class="fas fa-times-circle"></i>
                                Closed
                            </span>
                        @else
                            <span class="status-pill warning">
                                <i class="fas fa-clock"></i>
                                {{ $lead->status }}
                            </span>
                        @endif
                    </div>
                    <div class="hero-buttons">
                        <a href="{{ route('leads.index') }}" class="hero-btn light">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back</span>
                        </a>
                        <a href="{{ route('leads.edit',$lead->id) }}" class="hero-btn primary">
                            <i class="fas fa-edit"></i>
                            <span>Edit</span>
                        </a>
                        <button class="hero-btn dark"
                                data-bs-toggle="modal"
                                data-bs-target="#addFollowupModal">
                            <i class="fas fa-phone-volume"></i>
                            <span>Follow Up</span>
                        </button>
                    </div>
                </div>
        </div>
        </div>
    </section>

    <section class="section premium-dashboard pt-0">
        <div class="row">
            <div class="col-12">
                <div class="lead-profile-card">
                    <div class="row align-items-center g-0">
                        <!-- Left Profile -->
                        <div class="col-xl-6">
                            <div class="lead-profile-left">
                                <div class="lead-avatar">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($lead->candidate_name) }}&background=f5f5f5&color=0f172a&size=200"
                                       alt="Lead">
                                    <span class="avatar-badge">
                                        <i class="fas fa-star"></i>
                                    </span>
                                </div>
                                <div class="lead-profile-content">
                                    <span class="lead-module">
                                        <i class="fas fa-layer-group"></i>
                                        Lead Management
                                    </span>
                                    <h2>
                                       {{ $lead->candidate_name }}
                                    </h2>
                                    <div class="lead-number">
                                        {{ $lead->lead_no }}
                                    </div>
                                    <div class="lead-contact-list">
                                        <div class="lead-contact-item">
                                            <div class="contact-icon warning">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <span>{{ $lead->email ?: '-' }}</span>
                                        </div>
                                        <div class="lead-contact-item">
                                            <div class="contact-icon success">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                            <span>{{ $lead->mobile }}</span>
                                        </div>
                                        <div class="lead-contact-item">
                                            <div class="contact-icon primary">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            <span>{{ $lead->company ?: '-' }}</span>
                                        </div>
                                        <div class="lead-contact-item">
                                            <div class="contact-icon danger">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                            <span>{{ $lead->city ?: '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Right Information -->
                        <div class="col-xl-6">
                            <div class="lead-information-grid">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="lead-info-item">
                                            <div class="lead-info-icon blue">
                                                <i class="fas fa-user-check"></i>
                                            </div>
                                            <div>
                                                <label>Assigned To</label>
                                                <h6>{{ $lead->assignedUser->name ?? 'Unassigned' }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="lead-info-item">
                                            <div class="lead-info-icon purple">
                                                <i class="fas fa-circle-check"></i>
                                            </div>
                                            <div>
                                                <label>Status</label>
                                                <h6>
                                                    @if($lead->status=='Converted')
                                                        <span class="status-chip success">Converted</span>
                                                    @elseif($lead->status=='Closed')
                                                        <span class="status-chip danger">Closed</span>
                                                    @else
                                                        <span class="status-chip warning">{{ $lead->status }}</span>
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="lead-info-item">
                                            <div class="lead-info-icon green">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            <div>
                                                <label>Center</label>
                                                <h6>{{ $lead->center->center_name ?? '-' }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="lead-info-item">
                                            <div class="lead-info-icon orange">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <label>Created By</label>
                                                <h6>{{ $lead->createdBy->name ?? '-' }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="lead-info-item">
                                            <div class="lead-info-icon orange">
                                                <i class="fas fa-book-open"></i>
                                            </div>
                                            <div>
                                                <label>Course</label>
                                                <h6>{{ $lead->course->course_name ?? '-' }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="lead-info-item">
                                            <div class="lead-info-icon indigo">
                                                <i class="fas fa-calendar-plus"></i>
                                            </div>
                                            <div>
                                                <label>Created At</label>
                                                <h6>{{ $lead->created_at->format('d M Y h:i A') }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="lead-info-item">
                                            <div class="lead-info-icon red">
                                                <i class="fas fa-bolt"></i>
                                            </div>
                                            <div>
                                                <label>Priority</label>
                                                <h6>
                                                    @if($lead->priority=='High')
                                                        <span class="priority-chip high">High</span>
                                                    @elseif($lead->priority=='Medium')
                                                        <span class="priority-chip medium">Medium</span>
                                                    @else
                                                        <span class="priority-chip low">Low</span>
                                                    @endif
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="lead-info-item">
                                            <div class="lead-info-icon violet">
                                                <i class="fas fa-calendar-check"></i>
                                            </div>
                                            <div>
                                                <label>Updated At</label>
                                                <h6>{{ $lead->updated_at->format('d M Y h:i A') }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="lead-info-item remarks-card">
                                            <div class="lead-info-icon cyan">
                                                <i class="fas fa-comment-dots"></i>
                                            </div>
                                            <div class="remarks-content">
                                                <label>Remarks</label>
                                                <p>
                                                   {{ $lead->remarks ?: 'No remarks available.' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </section>

    <div class="row mt-4">
        <div class="col-lg-12" id="followup-history">
            <div class="premium-profile-card">
                <div class="profile-section-title">
                    <div class="title-icon success">
                        <i class="fas fa-history"></i>
                    </div>
                    <div>
                        <h4>Follow-up History</h4>
                        <p>Complete communication timeline of this lead</p>
                    </div>
                    <button class="premium-add-btn ms-auto" data-bs-toggle="modal"  data-bs-target="#addFollowupModal">
                        <i class="fas fa-plus"></i>
                        Add Follow-up
                    </button>
                </div>
                <div class="profile-body">
                    @forelse($lead->followups as $followup)
                        <div class="timeline-item">
                            <div class="timeline-dot">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <div>
                                        <h5> {{ $followup->followup_date ? \Carbon\Carbon::parse($followup->followup_date)->format('d M Y, h:i A') : now()->format('d M Y, h:i A') }}</h5>
                                        <small>  By {{ $followup->createdBy?->name ?? 'System' }} </small>
                                    </div>
                                    <div>
                                        @if($followup->status=='Converted')
                                            <span class="status-chip success"> Converted </span>
                                        @elseif($followup->status=='Closed')
                                            <span class="status-chip danger"> Closed </span>
                                        @else
                                            <span class="status-chip warning"> {{ $followup->status }} </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="timeline-body">
                                    {{ $followup->discussion }}
                                </div>
                                <div class="timeline-footer">
                                    <span>
                                        <i class="fas fa-calendar-alt"></i>
                                        Next Follow-up : {{ $followup->next_followup ? \Carbon\Carbon::parse($followup->next_followup)->format('d M Y, h:i A'): 'Not Scheduled' }} 
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-history"></i>
                            <h5>No Follow-up History</h5>
                            <p>
                                Follow-up history will appear here once communication starts.
                            </p>
                        </div>
                    @endforelse
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
