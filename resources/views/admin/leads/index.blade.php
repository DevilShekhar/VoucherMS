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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Lead No</th>
                                <th>Candidate Name</th>
                                <th>CAndidate Mobile No.</th>
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
                                        <strong>{{ $lead->candidate_name }}</strong>
                                        @if($lead->email)
                                            <br>
                                            <small class="text-muted">{{ $lead->email }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $lead->mobile }}</td>
                                    <td>{{ $lead->course->course_name ?? '-' }}</td>
                                    <td>{{ $lead->center->center_name ?? '-' }}</td>
                                    <td>
                                        @if($lead->assignedUser)
                                            {{ $lead->assignedUser->name }}
                                            <span class="badge bg-success ms-2">
                                                <i class="fas fa-user-check me-1"></i> Assigned
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-user-clock me-1"></i> Unassigned
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ optional($lead->createdBy)->name ?? '-' }}
                                    </td>
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
                                        <span class="badge bg-info">{{ $lead->status }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('leads.show', $lead->id) }}"
                                           class="btn btn-sm btn-info me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('leads.edit', $lead->id) }}"
                                           class="btn btn-sm btn-warning me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('leads.destroy', $lead->id) }}"
                                              method="POST"
                                              class="delete-form d-inline">
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
                                    <td colspan="10" class="text-center py-4">No Leads Found</td>
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

    <!-- Success Toast -->
    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,
                background: 'rgba(15, 23, 42, 0.9)',
                color: '#f1f5f9',
                didOpen: (toast) => {
                    toast.style.borderLeft = '5px solid #10b981';
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
        </script>
    @endif

    <!-- SweetAlert Delete Confirmation -->
    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Delete Lead?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Delete',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#EF4444',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

@endsection
