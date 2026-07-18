@extends('layouts.app')

@section('content')
<section class="section premium-dashboard">
    <div class="premium-floating-header">
        <div class="header-content">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div>
                    <span class="header-badge">Candidate Management</span>
                    <h2>Candidates</h2>
                    <p>Manage all converted candidates</p>
                </div>
            </div>
            <div class="premium-head-actions">
                <a href="{{ route('candidates.create') }}" class="btn btn-create">
                    <i class="fas fa-plus"></i> Add New Candidate
                </a>
            </div>
        </div>
    </div>
</section>

<section class="section premium-dashboard pt-0">
    <div class="card premium-block">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-white">
                        <tr>
                            <th>Candidate Code</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Course</th>
                            <th>Center</th>
                            <th>Executive</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidates as $candidate)
                            <tr>
                                <td><strong>{{ $candidate->candidate_code }}</strong></td>
                                <td>{{ $candidate->first_name }} {{ $candidate->last_name }}</td>
                                <td>{{ $candidate->mobile }}</td>
                                <td>{{ $candidate->email ?: '-' }}</td>
                                <td>{{ $candidate->course->course_name ?? '-' }}</td>
                                <td>{{ $candidate->center->center_name ?? '-' }}</td>
                                <td>{{ $candidate->executive->name ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $candidate->status == 'Active' ? 'success' : 'warning' }}">
                                        {{ $candidate->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <i class="fas fa-user-graduate fa-3x text-muted mb-3"></i>
                                    <h6>No Candidates Found</h6>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            {{-- <div class="d-flex justify-content-between align-items-center mt-3">
                {{ $candidates->links(['element' => 'pagination::simple']) }}
            </div> --}}
        </div>
    </div>
</section>
@endsection
