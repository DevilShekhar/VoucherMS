@extends('layouts.app')

@section('content')

    <section class="section premium-dashboard">
        <div class="premium-header">
            <div class="premium-header-overlay"></div>
            <div class="premium-header-left">
                <div class="premium-header-icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div class="premium-header-content">
                    <span class="premium-tag"> VOUCHER MANAGEMENT</span>
                    <h2 class="text-white">Vouchers</h2>
                    <p>{{ $voucherRequest->request_no }}</p>
                </div>
            </div>
            <div class="premium-header-right">
                <a href="{{ route('voucher-requests.index') }}" class="premium-back-btn text-success">
                    <i class="fas fa-arrow-left"></i> Back
                </a>

                @if($voucherRequest->status == 'Approved')
                    <form id="allocateForm" action="{{ route('voucher-requests.allocate', $voucherRequest) }}" method="POST"
                        class="m-0">
                        @csrf
                        <button type="button" id="allocateBtn" class="premium-back-btn text-success"
                            title="Allocate voucher to this candidate">
                            <i class="fas fa-ticket-alt"></i> Allocate Voucher
                        </button>
                    </form>
                @endif

            </div>
            <!-- Decorative Shapes -->
            <div class="shape circle-1"></div>
            <div class="shape circle-2"></div>
            <div class="shape circle-3"></div>
            <div class="dots"></div>
        </div>
    </section>
    <section class="section premium-dashboard pt-0">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="premium-request-card mb-4">
            <div class="premium-request-header">
                <div class="header-left">
                    <div class="voucher-title">
                        <div class="voucher-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <span>Course & Voucher Request Information</span>
                    </div>
                </div>
                <div class="header-right">
                    <div class="header-illustration">
                        <i class="fas fa-file-signature"></i>
                    </div>
                </div>
            </div>
            <div class="premium-request-body">
                <div class="row g-0">
                    <!-- Request No -->
                    <div class="col-xl-4 col-md-6">
                        <div class="detail-box">
                            <div class="detail-icon blue">
                                <i class="far fa-file-alt"></i>
                            </div>
                            <div class="detail-content">
                                <span>Request No</span>
                                <h6>{{ $voucherRequest->request_no }}</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Course -->
                    <div class="col-xl-4 col-md-6">
                        <div class="detail-box">
                            <div class="detail-icon indigo">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="detail-content">
                                <span>Course</span>
                                <h6>{{ $voucherRequest->candidate->course->course_name ?? '-' }}</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Center -->
                    <div class="col-xl-4 col-md-6">
                        <div class="detail-box">
                            <div class="detail-icon purple">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="detail-content">
                                <span>Center</span>
                                <h6>{{ $voucherRequest->center->center_name ?? '-' }}</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Date -->
                    <div class="col-xl-4 col-md-6">
                        <div class="detail-box no-border">
                            <div class="detail-icon green">
                                <i class="far fa-calendar-alt"></i>
                            </div>
                            <div class="detail-content">
                                <span>Requested Date</span>
                                <h6>{{ $voucherRequest->requested_at ? \Carbon\Carbon::parse($voucherRequest->requested_at)->format('d M Y h:i A') : '-' }}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-0 mt-3">
                    <!-- Current Status -->
                    <div class="col-xl-4 col-md-6">
                        <div class="detail-box">
                            <div class="detail-icon emerald">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="detail-content">
                                <span>Current Status</span>
                                @if($voucherRequest->status == 'Pending')
                                    <span class="status-badge pending">Pending</span>
                                @elseif($voucherRequest->status == 'Approved')
                                    <span class="status-badge success">Approved</span>
                                @elseif($voucherRequest->status == 'Allocated')
                                    <span class="status-badge primary">Allocated</span>
                                @else
                                    <span class="status-badge danger">Rejected</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Approval -->
                    <div class="col-xl-4 col-md-6">
                        <div class="detail-box">
                            <div class="detail-icon orange">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="detail-content">
                                <span>Approval</span>
                                @if($voucherRequest->admin_approval == 'Approved')
                                    <span class="status-badge success">Approved</span>
                                @elseif($voucherRequest->admin_approval == 'Rejected')
                                    <span class="status-badge danger">Rejected</span>
                                @else
                                    <span class="status-badge pending">Pending</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Requested By -->
                    <div class="col-xl-4 col-md-6">
                        <div class="detail-box no-border">
                            <div class="detail-icon violet">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="detail-content">
                                <span>Requested By</span>
                                <h6>{{ $voucherRequest->requestedBy->name ?? '-' }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="remarks-panel mt-4">
                    <div class="remarks-header">
                        <i class="fas fa-comment-dots"></i>
                        <span>Remarks</span>
                    </div>
                    <div class="remarks-body">
                        {{ $voucherRequest->remarks ?: 'No remarks available.' }}
                    </div>
                </div>
            </div>
        </div>
        <div class="premium-request-card mb-4">
            <!-- Card Header -->
            <div class="premium-request-header">
                <div class="voucher-title">
                    <div class="voucher-icon">
                        <i class="fas fa-user-graduate text-white"></i>
                    </div>
                    <span>Candidate Information</span>
                </div>
            </div>
            <div class="premium-request-body">
                <div class="row g-0">
                    <!-- Candidate Code -->
                    <div class="col-xl-4 col-md-6">
                        <div class="detail-box">
                            <div class="detail-icon blue">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <div class="detail-content">
                                <span>Candidate Code</span>
                                <h6>{{ $voucherRequest->candidate->candidate_code }}</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Candidate Name -->
                    <div class="col-xl-4 col-md-6">
                        <div class="detail-box">
                            <div class="detail-icon indigo">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="detail-content">
                                <span>Candidate Name</span>
                                <h6>
                                    {{ $voucherRequest->candidate->first_name }}
                                    {{ $voucherRequest->candidate->last_name }}
                                </h6>
                            </div>
                        </div>
                    </div>
                    <!-- Mobile -->
                    <div class="col-xl-4 col-md-6">
                        <div class="detail-box">
                            <div class="detail-icon green">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="detail-content">
                                <span>Mobile</span>
                                <h6>
                                    {{ $voucherRequest->candidate->mobile }}
                                </h6>
                            </div>
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="col-xl-4 col-md-6">
                        <div class="detail-box no-border">
                            <div class="detail-icon purple">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="detail-content">
                                <span>Email</span>
                                <h6>{{ $voucherRequest->candidate->email ?? '-' }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Status -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="detail-box">
                            <div class="detail-icon emerald">
                                <i class="fas fa-user-check"></i>
                            </div>
                            <div class="detail-content">
                                <span>Status</span>
                                <span class="status-badge success">
                                    {{ $voucherRequest->candidate->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Voucher Panel -->
                <div class="voucher-panel mt-4">
                    <div class="voucher-header">
                        <div class="voucher-title">
                            <div class="voucher-icon">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <span>Allocated Voucher</span>
                        </div>
                        <div class="voucher-badge">
                            <i class="fas fa-award"></i>
                        </div>
                    </div>
                    <div class="voucher-body">
                        <div class="row g-0">
                            <!-- Voucher Code -->
                            <div class="col-md-4">
                                <div class="voucher-item">
                                    <span>Voucher Code</span>
                                    <h6>
                                        @if(in_array(auth()->user()->role_id, [1, 2, 3]))
                                            {{ $voucherRequest->voucher->voucher_code }}
                                        @else
                                            ************
                                        @endif
                                    </h6>
                                </div>
                            </div>
                            <!-- Status -->
                            <div class="col-md-4">
                                <div class="voucher-item">
                                    <span>Status</span>
                                    <h6>
                                        {{ $voucherRequest->voucher->status }}
                                    </h6>
                                </div>
                            </div>
                            <!-- Expiry -->
                            <div class="col-md-4">
                                <div class="voucher-item no-border">
                                    <span>Expiry Date</span>
                                    <h6>
                                        {{ \Carbon\Carbon::parse($voucherRequest->voucher->expiry_date)->format('d M Y') }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($voucherRequest->status == 'Pending')
            <div class="row g-4">
                <!-- Approval Form -->
                <div class="col-lg-8">
                    <div class="premium-request-card approval-card">
                        <div class="premium-request-header">
                            <div class="header-left">
                                <div class="header-icon success">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h4>Approval</h4>
                                    <p class="text-white">Approve or reject this voucher request.</p>
                                </div>
                            </div>
                        </div>
                        <div class="premium-request-body">
                            <form action="{{ route('voucher-requests.approve', $voucherRequest) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <!-- Action -->
                                    <div class="col-md-4 mb-4">
                                        <label class="form-label">
                                            Action
                                        </label>
                                        <select class="form-select premium-input" name="action" required>
                                            <option value="">Select Action</option>
                                            <option value="Approved"> Approve </option>
                                            <option value="Rejected"> Reject </option>
                                        </select>
                                    </div>
                                    <!-- Selling Price -->
                                    <div class="col-md-4 mb-4" id="sellingPriceBox">

                                        <label class="form-label">
                                            Selling Price
                                            <span class="text-danger">*</span>
                                        </label>

                                        @if($voucherRequest->voucher)
                                            <div class="alert alert-info py-2 mb-2">
                                                <strong>Purchase Price:</strong>
                                                ₹{{ number_format($voucherRequest->voucher->purchase_price, 2) }}
                                            </div>
                                        @endif

                                        <div class="input-group">
                                            <span class="input-group-text">₹</span>
                                            <input type="number" class="form-control premium-input" name="selling_price"
                                                step="0.01" min="0" placeholder="Enter selling price" value="{{ number_format($voucherRequest->voucher->purchase_price) }}">
                                        </div>
                                    </div>
                                    <!-- Remarks -->
                                    <div class="col-md-4 mb-4">
                                        <label class="form-label"> Remarks </label>
                                        <textarea class="form-control premium-input" rows="3" name="remarks"
                                            placeholder="Enter remarks..."></textarea>
                                    </div>
                                </div>
                                <button class="btn btn-success premium-submit-btn">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Submit Decision
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Information Card -->
                <div class="col-lg-4">
                    <div class="important-card">
                        <div class="important-overlay"></div>
                        <div class="important-content">
                            <div class="important-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <h5>
                                Important Information
                            </h5>
                            <p>
                                Please review all voucher details carefully
                                before approving or rejecting this request.
                            </p>
                            <ul>
                                <li>
                                    Verify candidate details
                                </li>
                                <li>
                                    Confirm voucher availability
                                </li>
                                <li>
                                    Check selling price
                                </li>
                                <li>
                                    Review remarks before submission
                                </li>
                            </ul>
                        </div>
                        <div class="important-image">
                            <i class="fas fa-clipboard-check"></i>
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
