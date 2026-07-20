@extends('layouts.app')

@section('content')

<section class="section premium-dashboard">
    <div class="premium-floating-header">
        <div class="header-content">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-receipt"></i>
                </div>
                <div>
                    <span class="header-badge">Payment Management</span>
                    <h2>Payment Details</h2>
                    <small class="text-muted">{{ $payment->payment_no }}</small>
                </div>
            </div>

            <div>
                <a href="{{ route('payments.index') }}" class="btn btn-create">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
</section>

<section class="section premium-dashboard pt-0">

    {{-- Candidate Information --}}
    <div class="card premium-block mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-user"></i>
                Candidate Information
            </h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <strong>Candidate</strong><br>
                    {{ $payment->candidate->first_name }}
                    {{ $payment->candidate->last_name }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Candidate Code</strong><br>
                    {{ $payment->candidate->candidate_code }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Mobile</strong><br>
                    {{ $payment->candidate->mobile }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Course</strong><br>
                    {{ $payment->candidate->course->course_name ?? '-' }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Center</strong><br>
                    {{ $payment->candidate->center->center_name ?? '-' }}
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Email</strong><br>
                    {{ $payment->candidate->email ?? '-' }}
                </div>

            </div>

        </div>
    </div>

    {{-- Payment Summary --}}
    <div class="card premium-block mb-4">

        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-money-check-alt"></i>
                Payment Summary
            </h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-3 mb-3">
                    <strong>Total Amount</strong><br>
                    ₹ {{ number_format($payment->total_amount,2) }}
                </div>

                <div class="col-md-3 mb-3">
                    <strong>Discount</strong><br>
                    ₹ {{ number_format($payment->discount_amount,2) }}
                </div>

                <div class="col-md-3 mb-3">
                    <strong>Tax</strong><br>
                    ₹ {{ number_format($payment->tax_amount,2) }}
                </div>

                <div class="col-md-3 mb-3">
                    <strong>Net Amount</strong><br>
                    ₹ {{ number_format($payment->net_amount,2) }}
                </div>

                <div class="col-md-3 mb-3">
                    <strong>Paid</strong><br>
                    ₹ {{ number_format($payment->paid_amount,2) }}
                </div>

                <div class="col-md-3 mb-3">
                    <strong>Pending</strong><br>
                    ₹ {{ number_format($payment->pending_amount,2) }}
                </div>

                <div class="col-md-3 mb-3">
                    <strong>Status</strong><br>

                    @if($payment->payment_status=='Paid')
                        <span class="badge bg-success">Paid</span>

                    @elseif($payment->payment_status=='Partial')

                        <span class="badge bg-warning">
                            Partial
                        </span>

                    @else

                        <span class="badge bg-danger">
                            Pending
                        </span>

                    @endif

                </div>

                <div class="col-md-3 mb-3">
                    <strong>Date</strong><br>
                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                </div>

            </div>

        </div>

    </div>

    {{-- Transaction History --}}
    <div class="card premium-block">

        <div class="card-header">

            <h5 class="mb-0">
                <i class="fas fa-history"></i>
                Payment History
            </h5>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Date</th>

                            <th>Amount</th>

                            <th>Mode</th>

                            <th>Transaction No.</th>

                            <th>Bank</th>

                            <th>Receipt</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($payment->transactions as $transaction)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y h:i A') }}
                                </td>

                                <td>
                                    ₹ {{ number_format($transaction->amount,2) }}
                                </td>

                                <td>
                                    {{ $transaction->payment_mode }}
                                </td>

                                <td>
                                    {{ $transaction->transaction_no ?? '-' }}
                                </td>

                                <td>
                                    {{ $transaction->bank_name ?? '-' }}
                                </td>

                                <td>

                                    @if($transaction->receipt)

                                        <a href="{{ asset('storage/'.$transaction->receipt) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-success">

                                            <i class="fas fa-download"></i>

                                        </a>

                                    @else

                                        -

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

@endsection
