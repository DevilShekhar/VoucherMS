@extends('layouts.app')

@section('content')
<!-- Header -->
<section class="section premium-dashboard">
    <div class="premium-floating-header">
        <div class="header-content">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div>
                    <span class="header-badge">Lead Management</span>
                    <h2>Manage Leads</h2>
                    <p>View and manage all leads</p>
                </div>
            </div>
            <div class="premium-head-actions">
                <a href="{{ route('leads.create') }}" class="btn btn-create">
                    <i class="fas fa-plus"></i> Add Lead
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Content -->
<section class="section premium-dashboard pt-0">
    <div class="card premium-block">
        <div class="card-header premium-card-header">
            <div>
                <h4>Leads List</h4>
                <p class="header-subtext">Filter leads by status</p>
            </div>
        </div>

        <div class="card-body">
            <!-- Status Filter Buttons -->
            <div class="d-flex flex-wrap gap-2 mb-4 lead-filters">
                <a href="{{ request()->url() }}"
                   class="btn {{ !request('status') ? 'btn-primary' : 'btn-light border' }}">
                    <i class="fas fa-list-ul me-2"></i> All Leads
                    <span class="badge bg-white text-dark ms-2">{{ $counts['all'] ?? $leads->total() }}</span>
                </a>

                <a href="{{ request()->fullUrlWithQuery(['status' => 'New']) }}"
                   class="btn {{ request('status') == 'New' ? 'btn-primary' : 'btn-light border' }}">
                    <i class="fas fa-plus-circle me-2"></i> New
                    <span class="badge bg-white text-dark ms-2">{{ $counts['New'] ?? 0 }}</span>
                </a>

                <a href="{{ request()->fullUrlWithQuery(['status' => 'Contacted']) }}"
                   class="btn {{ request('status') == 'Contacted' ? 'btn-primary' : 'btn-light border' }}">
                    <i class="fas fa-phone me-2"></i> Contacted
                    <span class="badge bg-white text-dark ms-2">{{ $counts['Contacted'] ?? 0 }}</span>
                </a>

                <a href="{{ request()->fullUrlWithQuery(['status' => 'Interested']) }}"
                   class="btn {{ request('status') == 'Interested' ? 'btn-primary' : 'btn-light border' }}">
                    <i class="fas fa-heart me-2"></i> Interested
                    <span class="badge bg-white text-dark ms-2">{{ $counts['Interested'] ?? 0 }}</span>
                </a>

                <a href="{{ request()->fullUrlWithQuery(['status' => 'Not Interested']) }}"
                   class="btn {{ request('status') == 'Not Interested' ? 'btn-primary' : 'btn-light border' }}">
                    <i class="fas fa-thumbs-down me-2"></i> Not Interested
                    <span class="badge bg-white text-dark ms-2">{{ $counts['Not Interested'] ?? 0 }}</span>
                </a>

                <a href="{{ request()->fullUrlWithQuery(['status' => 'Converted']) }}"
                   class="btn {{ request('status') == 'Converted' ? 'btn-primary' : 'btn-light border' }}">
                    <i class="fas fa-check-circle me-2"></i> Converted
                    <span class="badge bg-white text-dark ms-2">{{ $counts['Converted'] ?? 0 }}</span>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle"  id="datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Lead No</th>
                            <th>Candidate Name</th>
                            <th>Candidate Mobile No.</th>
                            <th>Course</th>
                            <th>Center</th>
                            <th>Assigned To</th>
                            <th>Added By</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th width="160">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $lead)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $lead->lead_no }}</td>
                                <td>
                                    <strong>{{ $lead->candidate_name ?? '-'}}</strong>
                                    @if($lead->email)
                                        <br><small class="text-muted">{{ $lead->email }}</small>
                                    @endif
                                </td>
                                <td>{{ $lead->mobile }}</td>
                                <td>{{ $lead->course->course_name ?? '-' }}</td>
                                <td>{{ $lead->center->center_name ?? '-' }}</td>
                                <td>
                                    @if($lead->assignedUser)
                                        {{ $lead->assignedUser->name }}
                                        <span class="badge bg-success ms-2">Assigned</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Unassigned</span>
                                    @endif
                                </td>
                                <td>{{ optional($lead->createdBy)->name ?? '-' }}</td>
                                <td>
                                    @if($lead->priority == 'High')
                                        <span class="badge bg-danger">High</span>
                                    @elseif($lead->priority == 'Medium')
                                        <span class="badge bg-warning text-dark">Medium</span>
                                    @else
                                        <span class="badge bg-success">Low</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $lead->latestFollowup?->status ?? 'New' }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-sm btn-info me-1 mb-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-sm btn-warning me-1 mb-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-4">No Leads Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $leads->links() }}
            </div>
        </div>
    </div>
</section>

<!-- Success Toast & Delete Confirmation (Keep your existing scripts) -->
@if (session('success'))
    <script>
        Swal.fire({ /* your toast code */ });
    </script>
@endif

<script>
    // Your delete confirmation script
    document.querySelectorAll('.delete-form').forEach(form => { /* ... */ });
</script>
@endsection
