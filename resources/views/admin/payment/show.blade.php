@can('payments.show')
@extends('layouts.app')
@section('content')
    <section class="section premium-dashboard">
        <div class="premium-header">
            <div class="premium-header-overlay"></div>
            <div class="premium-header-left">
                <div class="premium-header-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="premium-header-content">
                    <span class="premium-tag">Payment Management</span>
                    <h1 class="text-white">Payment</h1>
                    <p>{{ $payment->payment_no }}</p>
                </div>
            </div>
            <div class="premium-header-right">
                <a href="{{ route('payments.index') }}" class="premium-back-btn">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <!-- Decorative Shapes -->
            <div class="shape circle-1"></div>
            <div class="shape circle-2"></div>
            <div class="shape circle-3"></div>
            <div class="dots"></div>
        </div>
    </section>

    <section class="section premium-dashboard pt-0">
        <div class="card premium-block shadow-sm border-0 mb-4">
            <div class="premium-request-header">
                <div class="d-flex align-items-center">
                    <div class="header-icon me-3">
                        <i class="fas fa-user-graduate text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Candidate Information</h5>
                        <small class="text-white">Candidate profile details</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="info-box">
                            <div class="info-icon bg-primary">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="info-content">
                                <span>Candidate Name</span>
                                <h6>
                                    {{ $payment->candidate->first_name }}
                                    {{ $payment->candidate->last_name }}
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="info-box">
                            <div class="info-icon bg-success">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <div class="info-content">
                                <span>Candidate Code</span>
                                <h6>{{ $payment->candidate->candidate_code }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="info-box">
                            <div class="info-icon bg-info">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="info-content">
                                <span>Mobile Number</span>
                                <h6>{{ $payment->candidate->mobile }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="info-box">
                            <div class="info-icon bg-warning">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div class="info-content">
                                <span>Course</span>
                                <h6>{{ $payment->candidate->course->course_name ?? '-' }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="info-box">
                            <div class="info-icon bg-danger">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="info-content">
                                <span>Center</span>
                                <h6>{{ $payment->candidate->center->center_name ?? '-' }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="info-box">
                            <div class="info-icon bg-secondary">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="info-content">
                                <span>Email Address</span>
                                <h6>{{ $payment->candidate->email ?? '-' }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card premium-block mb-4">
            <div class="premium-request-header">
                <div class="d-flex align-items-center">
                    <div class="header-icon me-3">
                        <i class="fas fa-money-check-alt text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Payment Summary</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="border rounded-4 p-3 h-100 bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted text-uppercase fw-semibold">Total Amount</small>
                                    <h4 class="fw-bold text-dark mb-0 mt-2">
                                        ₹ {{ number_format($payment->total_amount, 2) }}
                                    </h4>
                                </div>
                                <div class="fs-2 text-primary">
                                    <i class="fas fa-wallet"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="border rounded-4 p-3 h-100 bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted text-uppercase fw-semibold">Discount</small>
                                    <h4 class="fw-bold text-success mb-0 mt-2">
                                        ₹ {{ number_format($payment->discount_amount, 2) }}
                                    </h4>
                                </div>
                                <div class="fs-2 text-success">
                                    <i class="fas fa-tags"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="border rounded-4 p-3 h-100 bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted text-uppercase fw-semibold">Tax</small>
                                    <h4 class="fw-bold text-warning mb-0 mt-2">
                                        ₹ {{ number_format($payment->tax_amount, 2) }}
                                    </h4>
                                </div>
                                <div class="fs-2 text-warning">
                                    <i class="fas fa-percent"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="border rounded-4 p-3 h-100 bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted text-uppercase fw-semibold">Net Amount</small>
                                    <h4 class="fw-bold text-primary mb-0 mt-2">
                                        ₹ {{ number_format($payment->net_amount, 2) }}
                                    </h4>
                                </div>
                                <div class="fs-2 text-primary">
                                    <i class="fas fa-coins"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="border rounded-4 p-3 h-100 bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted text-uppercase fw-semibold">Paid Amount</small>
                                    <h4 class="fw-bold text-success mb-0 mt-2">
                                        ₹ {{ number_format($payment->paid_amount, 2) }}
                                    </h4>
                                </div>
                                <div class="fs-2 text-success">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="border rounded-4 p-3 h-100 bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted text-uppercase fw-semibold">Pending Amount</small>
                                    <h4 class="fw-bold text-danger mb-0 mt-2">
                                        ₹ {{ number_format($payment->pending_amount, 2) }}
                                    </h4>
                                </div>
                                <div class="fs-2 text-danger">
                                    <i class="fas fa-hourglass-half"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="border rounded-4 p-3 h-100 bg-light">
                            <small class="text-muted text-uppercase fw-semibold d-block mb-2">
                                Payment Status
                            </small>
                            @if($payment->payment_status == 'Paid')
                                <span class="badge bg-success fs-6 px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i> Paid
                                </span>
                            @elseif($payment->payment_status == 'Partial')
                                <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                    <i class="fas fa-clock me-1"></i> Partial
                                </span>
                            @else
                                <span class="badge bg-danger fs-6 px-3 py-2">
                                    <i class="fas fa-times-circle me-1"></i> Pending
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="border rounded-4 p-3 h-100 bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted text-uppercase fw-semibold">Payment Date</small>
                                    <h5 class="fw-bold text-dark mb-0 mt-2">
                                        {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                                    </h5>
                                </div>
                                <div class="fs-2 text-info">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card premium-block">
            <div class="premium-payment-request-header d-flex justify-content-between align-items-center">

                <div class="d-flex align-items-center">
                    <div class="header-icon me-3">
                        <i class="fas fa-history text-white"></i>
                    </div>

                    <div>
                        <h5 class="mb-0">Payment History</h5>
                    </div>
                </div>

                @if(!$payment->invoice)
                    <form action="{{ route('payments.generateInvoice', $payment) }}" method="POST" class="generate-invoice-form">
                        @csrf
                        <button type="submit" class="btn btn-light"><i class="fas fa-file-invoice"></i>  Generate Invoice</button>
                    </form>
                @else
                    <div class="d-flex gap-2">
                        <a href="{{ route('invoices.download', $payment->invoice->id) }}"  class="btn btn-success"> <i class="fas fa-download"></i> Download Invoice </a>
                        @if($payment->candidate && !empty($payment->candidate->email))
                            <form action="{{ route('payments.sendInvoiceEmail', $payment) }}" method="POST" class="send-email-form">
                                @csrf
                                <button type="submit" class="btn btn-warning"> <i class="fas fa-envelope"></i> Send Email </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Payment No.</th>
                                <th>Net Amount</th>
                                <th>Paid</th>
                                <th>Pending</th>
                                <th>Status</th>
                                <th>Mode</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($paymentHistory as $history)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($history->payment_date)->format('d M Y') }}</td>
                                    <td>{{ $history->payment_no }}</td>
                                    <td> ₹ {{ number_format($history->net_amount, 2) }}</td>
                                    <td> ₹ {{ number_format($history->paid_amount, 2) }}</td>
                                    <td>₹ {{ number_format($history->pending_amount, 2) }}</td>
                                    <td>
                                        @if($history->payment_status == 'Paid')
                                            <span class="badge bg-success">
                                                Paid
                                            </span>
                                        @elseif($history->payment_status == 'Partial')
                                            <span class="badge bg-warning">
                                                Partial
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $history->transactions->first()->payment_mode ?? '-' }}
                                    </td>
                                    <td>
                                    @if($history->invoice)

                                    <a href="{{ route('invoices.download',$history->invoice->id) }}"
                                    class="btn btn-success btn-sm">

                                        <i class="fas fa-download"></i>

                                    </a>

                                    @else

                                    <form action="{{ route('payments.generateInvoice',$history) }}"
                                        method="POST"
                                        onsubmit="return confirm('Generate Invoice?')">

                                        @csrf

                                        <button class="btn btn-primary btn-sm">
                                            <i class="fas fa-file-invoice text-white"></i>
                                        </button>

                                    </form>

                                    @endif

                                </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        No Payment Transactions Found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.generate-invoice-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Generate Invoice?',
                        text: "Are you sure you want to generate this invoice?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Generate',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });        
        </script>
        <script>
            document.querySelectorAll('.send-email-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Send Invoice Email?',
                        text: "Are you sure you want to send this invoice to the candidate's email?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Send',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        </script>
        
@endsection
@else
    @php
        abort(403);
    @endphp
@endcan
