@extends('layouts.app')

@section('content')

<section class="section premium-dashboard">
    <div class="premium-floating-header">
        <div class="header-content">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div>
                    <span class="header-badge">Voucher Management</span>
                    <h2>Voucher Requests</h2>
                    <p>Manage voucher approval requests</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section premium-dashboard pt-0">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card premium-block">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>
                            <th>#</th>
                            <th>Request No</th>
                            <th>Candidate</th>
                            <th>Candidate Code</th>
                            <th>Center</th>
                            <th>Requested By</th>
                            <th>Requested On</th>
                            <th>Admin</th>
                            <th>Super Admin</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($requests as $request)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <strong>{{ $request->request_no }}</strong>
                            </td>

                            <td>
                                {{ $request->candidate->first_name }}
                                {{ $request->candidate->last_name }}
                            </td>

                            <td>
                                {{ $request->candidate->candidate_code }}
                            </td>

                            <td>
                                {{ $request->center->center_name ?? '-' }}
                            </td>

                            <td>
                                {{ $request->requestedBy->name ?? '-' }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($request->requested_at)->format('d M Y h:i A') }}
                            </td>

                            <td>

                                @if($request->admin_approval=='Approved')
                                    <span class="badge bg-success">Approved</span>

                                @elseif($request->admin_approval=='Rejected')
                                    <span class="badge bg-danger">Rejected</span>

                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif

                            </td>

                            <td>

                                @if($request->superadmin_approval=='Approved')
                                    <span class="badge bg-success">Approved</span>

                                @elseif($request->superadmin_approval=='Rejected')
                                    <span class="badge bg-danger">Rejected</span>

                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif

                            </td>

                            <td>

                                @if($request->status=='Allocated')
                                    <span class="badge bg-primary">Allocated</span>

                                @elseif($request->status=='Approved')
                                    <span class="badge bg-success">Approved</span>

                                @elseif($request->status=='Rejected')
                                    <span class="badge bg-danger">Rejected</span>

                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif

                            </td>

                            <td>

                                <a href="{{ route('voucher-requests.show',$request->id) }}"
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="11" class="text-center py-5">

                                <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>

                                <h6>No Voucher Requests Found</h6>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $requests->links() }}
            </div>

        </div>

    </div>

</section>

@endsection
