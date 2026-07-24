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
                        <h2>Voucher Request Details</h2>
                        <p>{{ $voucherRequest->request_no }}</p>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">

                    <a href="{{ route('voucher-requests.index') }}" class="btn btn-create">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>

                    @if($voucherRequest->status == 'Approved')
                        <form id="allocateForm" action="{{ route('voucher-requests.allocate', $voucherRequest) }}" method="POST"
                            class="m-0">
                            @csrf

                            <button type="button" id="allocateBtn" class="btn btn-primary" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Allocate voucher to this candidate">
                                <i class="fas fa-ticket-alt"></i> Allocate Voucher
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        </div>

    </section>

    <section class="section premium-dashboard pt-0">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card premium-block mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-book"></i> Course & Voucher Request Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <strong>Request No</strong><br>
                        {{ $voucherRequest->request_no }}
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Course</strong><br>
                        <strong class="text-primary">{{ $voucherRequest->candidate->course->course_name ?? '-' }}</strong>
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Center</strong><br>
                        {{ $voucherRequest->center->center_name ?? '-' }}
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Requested Date</strong><br>
                        {{ $voucherRequest->requested_at ? \Carbon\Carbon::parse($voucherRequest->requested_at)->format('d M Y h:i A') : '-' }}
                    </div>

                    <div class="col-md-3 mb-3">
                        <strong>Current Status</strong><br>
                        @if($voucherRequest->status == 'Pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($voucherRequest->status == 'Approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($voucherRequest->status == 'Allocated')
                            <span class="badge bg-primary">Allocated</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Approval</strong><br>
                        @if($voucherRequest->admin_approval == 'Approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($voucherRequest->admin_approval == 'Rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Requested By</strong><br>
                        {{ $voucherRequest->requestedBy->name ?? '-' }}
                    </div>

                    <div class="col-md-12 mt-3">
                        <strong>Remarks</strong><br>
                        <div class="border rounded p-3 bg-light">
                            {{ $voucherRequest->remarks ?: '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card premium-block mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-user-graduate"></i> Candidate Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <strong>Candidate Code</strong><br>
                        {{ $voucherRequest->candidate->candidate_code }}
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Candidate Name</strong><br>
                        {{ $voucherRequest->candidate->first_name }} {{ $voucherRequest->candidate->last_name }}
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Mobile</strong><br>
                        {{ $voucherRequest->candidate->mobile }}
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Email</strong><br>
                        {{ $voucherRequest->candidate->email ?? '-' }}
                    </div>
                    <div class="col-md-3 mb-3">
                        <strong>Status</strong><br>
                        <span class="badge bg-success">{{ $voucherRequest->candidate->status }}</span>
                    </div>

                    <div class="card border-success mt-4">

                        <div class="card-header bg-success text-white">
                            <i class="fas fa-ticket-alt"></i>
                            Allocated Voucher
                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4">
                                    <strong>Voucher Code</strong><br>
                                    {{ $voucherRequest->voucher->voucher_code }}
                                </div>

                                <div class="col-md-4">
                                    <strong>Status</strong><br>
                                    {{ $voucherRequest->voucher->status }}
                                </div>

                                <div class="col-md-4">
                                    <strong>Expiry Date</strong><br>
                                    {{ \Carbon\Carbon::parse($voucherRequest->voucher->expiry_date)->format('d M Y') }}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>

        
            @if($voucherRequest->status == 'Pending')
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card premium-block">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-check-circle"></i> Approval
                                </h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('voucher-requests.approve', $voucherRequest) }}" method="POST">
                                    @csrf                                


                                    <div class="mb-3">
                                        <label class="form-label">Action</label>
                                        <select class="form-select" name="action" required>
                                            <option value="">Select Action</option>
                                            <option value="Approved">Approve</option>
                                            <option value="Rejected">Reject</option>
                                        </select>
                                    </div>
                                    <div class="mb-3" id="sellingPriceBox">
                                        <label class="form-label">
                                            Selling Price <span class="text-danger">*</span>
                                        </label>

                                        <input type="number" class="form-control" name="selling_price" step="0.01" min="0">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Remarks</label>
                                        <textarea name="remarks" class="form-control" rows="4"
                                            placeholder="Enter remarks..."></textarea>
                                    </div>
                                    <button class="btn btn-success w-100">
                                        <i class="fas fa-save"></i> Submit Decision
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        

    </section>
    <script>
        
        document.getElementById('allocateBtn').addEventListener('click', function () {

            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to allocate a voucher to this candidate.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Allocate'
            }).then((result) => {
                if (result.isConfirmed) {

                    // Submit the form
                    document.getElementById('allocateForm').submit();

                    // Optional: Show loading toast
                    Swal.fire({
                        title: 'Allocating...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }
            });
        });

        // Show success toast if redirected back with success message
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });
        @endif
    </script>
@endsection
