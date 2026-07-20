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
                        <h2>Add New Payment</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section premium-dashboard pt-0">
        <div class="card premium-block">
            <div class="card-body">
                <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                    @csrf

                    <div class="row mb-4">
                        <div class="col-md-8">
                            <label class="form-label">Select Candidate <span class="text-danger">*</span></label>
                            <select name="candidate_id" id="candidate_id" class="form-select" required>
                                <option value="">-- Select Converted Candidate --</option>
                                @forelse($candidates as $candidate)
                                    <option value="{{ $candidate->id }}">
                                        {{ $candidate->first_name }} {{ $candidate->last_name ?? '' }}
                                        — {{ $candidate->candidate_code }}
                                    </option>
                                @empty
                                    <option value="" disabled>No converted candidates found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <!-- Candidate Details Card (Dynamic) -->
                    <div id="candidate_details" class="card mb-4" style="display: none;">
                        <div class="card-header bg-light">
                            <h5>Candidate Information</h5>
                        </div>
                        <div class="card-body" id="candidate_info">
                            <!-- Filled by JavaScript -->
                        </div>
                    </div>

                    <!-- Payment Form Fields -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Total Amount <span class="text-danger">*</span></label>
                            <input type="number" name="total_amount" step="0.01" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Discount Amount</label>
                            <input type="number" name="discount_amount" step="0.01" class="form-control" value="0">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Tax Amount</label>
                            <input type="number" name="tax_amount" step="0.01" class="form-control" value="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Payment Date</label>
                            <input type="date" name="payment_date" class="form-control"
                                value="{{ now()->format('Y-m-d') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Payment Mode <span class="text-danger">*</span></label>
                            <select name="payment_mode" class="form-select" required>
                                <option value="">Select Mode</option>
                                <option value="Cash">Cash</option>
                                <option value="UPI">UPI</option>
                                <option value="Card">Card</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Cheque">Cheque</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Paid Amount <span class="text-danger">*</span></label>
                            <input type="number" name="amount" step="0.01" class="form-control" required>
                        </div>

                        <div class="col-12 mb-3">
                            <label>Remarks</label>
                            <textarea name="remarks" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">Save Payment</button>
                        <a href="{{ route('payments.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function () {
            $('#candidate_id').change(function () {
                const candidateId = $(this).val();
                if (!candidateId) {
                    $('#candidate_details').hide();
                    return;
                }

                // Correct URL with 'admin' prefix
                $.get('/admin/candidates/' + candidateId + '/details', function (data) {
                    let html = `
                    <p><strong>Name:</strong> ${data.first_name} ${data.last_name || ''}</p>
                    <p><strong>Code:</strong> ${data.candidate_code}</p>
                    <p><strong>Course:</strong> ${data.course_name || '-'}</p>
                    <p><strong>Center:</strong> ${data.center_name || '-'}</p>
                    <p><strong>Mobile:</strong> ${data.mobile}</p>
                    <p><strong>Email:</strong> ${data.email || '-'}</p>
                `;
                    $('#candidate_info').html(html);
                    $('#candidate_details').show();
                }).fail(function () {
                    alert('Failed to load candidate details');
                });
            });
        });
    </script>
@endsection
