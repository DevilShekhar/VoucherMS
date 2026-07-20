@extends('layouts.app')

@section('content')
<section class="section premium-dashboard">
    <div class="premium-floating-header">
        <div class="header-content">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div>
                    <span class="header-badge">Payment Management</span>
                    <h2>All Payments</h2>
                </div>
            </div>
            <div class="premium-head-actions">
                <a href="{{ route('payments.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add Payment
                </a>
            </div>
        </div>
    </div>
</section>

<section class="section premium-dashboard pt-0">
    <div class="card premium-block">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Payment No</th>
                            <th>Candidate</th>
                            <th>Total</th>
                            <th>Paid</th>
                            <th>Pending</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td><strong>{{ $payment->payment_no }}</strong></td>
                            <td>{{ $payment->candidate->first_name ?? '' }} {{ $payment->candidate->last_name ?? '' }}</td>
                            <td>₹ {{ number_format($payment->total_amount, 2) }}</td>
                            <td>₹ {{ number_format($payment->paid_amount, 2) }}</td>
                            <td>₹ {{ number_format($payment->pending_amount, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $payment->payment_status == 'Paid' ? 'success' : 'warning' }}">
                                    {{ $payment->payment_status }}
                                </span>
                            </td>
                            <td>{{ $payment->payment_date ? $payment->payment_date->format('d M Y') : '-' }}</td>
                            {{-- <td>
                                <a href="{{ route('candidates.show', $payment->candidate) }}" class="btn btn-sm btn-primary">
                                    View
                                </a>
                            </td> --}}
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center py-5">No payments found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
