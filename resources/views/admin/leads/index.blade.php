@extends('layouts.app')

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
                    <h2 class="text-white">Manage Leads</h2>
                    <p>View and manage all leads</p>
                </div>

            </div>

            <div class="premium-header-right">

                <a href="{{ route('leads.create') }}" class="premium-back-btn">
                    <i class="fas fa-plus"></i>
                    Add Lead
                </a>

            </div>

            <!-- Decorative Shapes -->
            <div class="shape circle-1"></div>
            <div class="shape circle-2"></div>
            <div class="shape circle-3"></div>
            <div class="dots"></div>

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

                <div class="filter-card">

                    <div class="filter-header">

                        <div>

                            <div class="filter-title">

                                <div class="filter-icon blue">

                                    <i class="fas fa-list-check"></i>

                                </div>

                                <div>

                                    <h3>Filter by Status</h3>

                                    <p>View leads based on current status</p>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="status-grid">

                        <!-- All Leads -->

                        <a href="{{ request()->url() }}" class="status-item {{ !request('status') ? 'active-card' : '' }}">

                            <div class="status-circle blue">

                                <i class="fas fa-list"></i>

                            </div>

                            <h5>All Leads</h5>

                            <span class="status-count">

                                {{ $counts['all'] ?? $leads->total() }}

                            </span>

                        </a>

                        <!-- New -->

                        <a href="{{ request()->fullUrlWithQuery(['status' => 'New']) }}"
                            class="status-item {{ request('status') == 'New' ? 'active-card' : '' }}">

                            <div class="status-circle green">

                                <i class="fas fa-plus"></i>

                            </div>

                            <h5>New</h5>

                            <span class="status-count">

                                {{ $counts['New'] ?? 0 }}

                            </span>

                        </a>

                        <!-- Contacted -->

                        <a href="{{ request()->fullUrlWithQuery(['status' => 'Contacted']) }}"
                            class="status-item {{ request('status') == 'Contacted' ? 'active-card' : '' }}">

                            <div class="status-circle info">

                                <i class="fas fa-phone"></i>

                            </div>

                            <h5>Contacted</h5>

                            <span class="status-count">

                                {{ $counts['Contacted'] ?? 0 }}

                            </span>

                        </a>

                        <!-- Interested -->

                        <a href="{{ request()->fullUrlWithQuery(['status' => 'Interested']) }}"
                            class="status-item {{ request('status') == 'Interested' ? 'active-card' : '' }}">

                            <div class="status-circle pink">

                                <i class="fas fa-heart"></i>

                            </div>

                            <h5>Interested</h5>

                            <span class="status-count">

                                {{ $counts['Interested'] ?? 0 }}

                            </span>

                        </a>

                        <!-- Not Interested -->

                        <a href="{{ request()->fullUrlWithQuery(['status' => 'Not Interested']) }}"
                            class="status-item {{ request('status') == 'Not Interested' ? 'active-card' : '' }}">

                            <div class="status-circle orange">

                                <i class="fas fa-thumbs-down"></i>

                            </div>

                            <h5>Not Interested</h5>

                            <span class="status-count">

                                {{ $counts['Not Interested'] ?? 0 }}

                            </span>

                        </a>

                        <!-- Converted -->

                        <a href="{{ request()->fullUrlWithQuery(['status' => 'Converted']) }}"
                            class="status-item {{ request('status') == 'Converted' ? 'active-card' : '' }}">

                            <div class="status-circle success">

                                <i class="fas fa-check"></i>

                            </div>

                            <h5>Converted</h5>

                            <span class="status-count">

                                {{ $counts['Converted'] ?? 0 }}

                            </span>

                        </a>

                    </div>

                </div>

                <!-- Priority Card -->

                <div class="filter-card mt-4">

                    <div class="filter-header">

                        <div class="filter-title">

                            <div class="filter-icon red">

                                <i class="fas fa-flag"></i>

                            </div>

                            <div>

                                <h3>Filter by Priority</h3>

                                <p>View leads based on priority level</p>

                            </div>

                        </div>

                    </div>

                    <div class="priority-grid">

                        <a href="{{ request()->fullUrlWithQuery(['priority' => 'High']) }}"
                            class="priority-item high {{ request('priority') == 'High' ? 'active-priority' : '' }}">

                            <i class="fas fa-arrow-up"></i>

                            <span>High Priority</span>

                            <strong>{{ $counts['High'] ?? 0 }}</strong>

                        </a>

                        <a href="{{ request()->fullUrlWithQuery(['priority' => 'Medium']) }}"
                            class="priority-item medium {{ request('priority') == 'Medium' ? 'active-priority' : '' }}">

                            <i class="fas fa-minus"></i>

                            <span>Medium Priority</span>

                            <strong>{{ $counts['Medium'] ?? 0 }}</strong>

                        </a>

                        <a href="{{ request()->fullUrlWithQuery(['priority' => 'Low']) }}"
                            class="priority-item low {{ request('priority') == 'Low' ? 'active-priority' : '' }}">

                            <i class="fas fa-arrow-down"></i>

                            <span>Low Priority</span>

                            <strong>{{ $counts['Low'] ?? 0 }}</strong>

                        </a>

                    </div>

                </div>


                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="datatable">
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
                                            <span class="assigned-user" data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                data-bs-placement="top" data-bs-html="true" title="{{ $lead->assignedUser->name }}"
                                                data-bs-content="
                                                              <div class='small'>
                                                                  <div><i class='fas fa-envelope me-1'></i> {{ $lead->assignedUser->email ?? '—' }}</div>
                                                                  <div class='mt-1'><i class='fas fa-phone me-1'></i> {{ $lead->assignedUser->mobile ?? '—' }}</div>
                                                              </div>
                                                          ">
                                                {{ $lead->assignedUser->name }}
                                                <span class="badge bg-success ms-2">Assigned</span>
                                            </span>
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
                                        <form action="{{ route('leads.destroy', $lead->id) }}" method="POST"
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
                                    <td colspan="11" class="text-center py-4">No Leads Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Bootstrap popovers
            const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl, {
                    container: 'body',
                    trigger: 'hover focus'   // hover + keyboard/focus
                });
            });
        });
    </script>
@endsection
