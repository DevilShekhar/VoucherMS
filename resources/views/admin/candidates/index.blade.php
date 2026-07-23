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
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card premium-block">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle"  id="datatable">
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
                                                                    <td class="text-nowrap">
                                                                        <a href="{{ route('candidates.show', $candidate->id) }}" class="btn btn-sm btn-info">
                                                                            <i class="fas fa-eye"></i>
                                                                        </a>
                                                                        <a href="{{ route('candidates.edit', $candidate) }}" class="btn btn-sm btn-primary">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>

                                                                        <button type="button" class="btn btn-sm btn-success upload-doc-btn"
                                                                            data-candidate-id="{{ $candidate->id }}"
                                                                            data-candidate-name="{{ $candidate->first_name }} {{ $candidate->last_name }}"
                                                                            data-candidate-code="{{ $candidate->candidate_code }}">
                                                                            <i class="fas fa-upload"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-sm btn-warning payment-btn"
                                                                            data-id="{{ $candidate->id }}"
                                                                            data-name="{{ $candidate->first_name }} {{ $candidate->last_name }}"
                                                                            data-code="{{ $candidate->candidate_code }}"
                                                                            data-course="{{ $candidate->course->course_name ?? '-' }}"
                                                                            data-center="{{ $candidate->center->center_name ?? '-' }}">
                                                                            <i class="fas fa-money-bill-wave"></i>
                                                                        </button>
                                                                        {{-- {{ dd($candidate->voucherRequest?->toArray()) }} --}}
                                                                       @if($candidate->voucherRequest)

                                                                        @php
                                                                            $request = $candidate->voucherRequest;
                                                                        @endphp

                                                                        @if($request->status == 'Allocated')
                                                                            <span class="badge bg-success">
                                                                                <i class="fas fa-check-circle"></i> Voucher Allocated
                                                                            </span>

                                                                        @elseif($request->status == 'Pending')
                                                                            <span class="badge bg-warning text-dark">
                                                                                <i class="fas fa-clock"></i> Request Pending
                                                                            </span>

                                                                        @elseif($request->status == 'Approved')
                                                                            <span class="badge bg-info">
                                                                                <i class="fas fa-check"></i> Approved
                                                                            </span>

                                                                        @elseif($request->status == 'Rejected')
                                                                            <span class="badge bg-danger">
                                                                                <i class="fas fa-times"></i> Rejected
                                                                            </span>

                                                                        @endif

                                                                    @else

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-dark request-voucher-btn"
                                        data-candidate-id="{{ $candidate->id }}"
                                        data-candidate-name="{{ $candidate->first_name }} {{ $candidate->last_name }}"
                                        data-candidate-code="{{ $candidate->candidate_code }}"
                                        data-center-id="{{ $candidate->center_id }}"
                                    >
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-primary exam-schedule-btn"
                                        data-id="{{ $candidate->id }}"
                                        data-name="{{ $candidate->first_name }} {{ $candidate->last_name }}"
                                        data-center="{{ $candidate->center_id }}"                                    
                                        data-voucher="{{ optional($candidate->voucherRequest)->voucher_id }}">
                                        <i class="fas fa-calendar-alt"></i>
                                    </button>

                                @endif
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
            </div>
        </div>
    </section>
    <!-- Exam Schedule Modal -->
    <div class="modal fade" id="examScheduleModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="examScheduleForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-calendar-alt text-primary"></i>
                            Exam Schedule
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="candidate_id" id="exam_candidate_id">                       
                        <input type="hidden" name="voucher_id" id="exam_voucher_id">
                        <div class="mb-3">
                            <label class="form-label">Candidate</label>
                            <input type="text" id="exam_candidate_name" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"> Exam Date</label>
                            <input type="date"  class="form-control" name="exam_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"> Exam Time</label>
                            <input type="time" class="form-control" name="exam_time" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"> Exam Center <span class="text-danger">*</span></label>
                            <select class="form-select" name="center_id" id="exam_center_id" required>
                                <option value="">-- Select Center --</option>
                                @foreach($centers as $center)
                                    <option value="{{ $center->id }}">
                                        {{ $center->center_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button"> Close</button>
                        <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Save Schedule</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Upload Document Modal -->
    <div class="modal fade" id="uploadDocModal" tabindex="-1" aria-labelledby="uploadDocModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadDocForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="candidate_id" id="modal_candidate_id" value="">

                        <div class="mb-3">
                            <label>Candidate</label>
                            <p id="modal_candidate_info" class="fw-bold"></p>
                        </div>

                        <div class="mb-3">
                            <label>Document Type <span class="text-danger">*</span></label>
                            <select name="document_type" class="form-select" required>
                                <option value="">-- Select --</option>
                                <option value="Aadhaar">Aadhaar Card</option>
                                <option value="PAN">PAN Card</option>
                                <option value="Photo">Photo</option>
                                <option value="Education">Education Proof</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Upload File <span class="text-danger">*</span></label>
                            <input type="file" name="document" class="form-control" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="submitUploadBtn" class="btn btn-success">Upload</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1">
        <form id="paymentForm" enctype="multipart/form-data">
            @csrf

            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-money-bill-wave text-success"></i> Record Payment
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="candidate_id" id="payment_candidate_id">

                        <div class="alert alert-light border">
                            <h6 id="paymentCandidateName"></h6>
                            <small>
                                Code: <span id="paymentCandidateCode"></span>
                            </small>
                            <br>
                            <small>
                                Course: <span id="paymentCourse"></span>
                            </small>
                            <br>
                            <small>
                                Center: <span id="paymentCenter"></span>
                            </small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Total Amount <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="total_amount" step="0.01" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Discount Amount</label>
                                <input type="number" class="form-control" value="0" name="discount_amount" step="0.01">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Tax Amount</label>
                                <input type="number" class="form-control" value="0" name="tax_amount" step="0.01">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Paid Amount <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="amount" step="0.01" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Payment Date</label>
                                <input type="date" class="form-control" value="{{ now()->format('Y-m-d') }}"
                                    name="payment_date">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Payment Mode <span class="text-danger">*</span></label>
                                <select class="form-select" name="payment_mode" id="payment_mode" required>
                                    <option value="">Select Payment Mode</option>
                                    <option value="Cash">Cash</option>
                                    <option value="UPI">UPI</option>
                                    <option value="Card">Card</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
                            </div>

                            <!-- Receipt Upload Section - Visible for UPI, Bank Transfer, Card -->
                            <div class="col-md-6 mb-3" id="receipt_section" style="display:none;">
                                <label>Upload Receipt <span id="receipt_required" style="display:none;"
                                        class="text-danger">*</span></label>
                                <input type="file" name="receipt" id="receipt" class="form-control"
                                    accept=".jpg,.jpeg,.png,.pdf">
                                <small class="text-muted">
                                    Allowed: JPG, JPEG, PNG, PDF (Max: 5MB)
                                </small>
                            </div>

                            <div class="col-12 mb-3">
                                <label>Remarks</label>
                                <textarea class="form-control" name="remarks" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">
                            <i class="fas fa-times"></i> Close
                        </button>
                        <button class="btn btn-success" id="savePaymentBtn" type="submit">
                            <i class="fas fa-save"></i> Save Payment
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Request Modal --}}
    <div class="modal fade" id="voucherRequestModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="voucherRequestForm" method="POST" action="{{ route('voucher-requests.store') }}">
                @csrf

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Send Voucher Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" name="candidate_id" id="voucher_candidate_id">
                        <input type="hidden" name="center_id" id="voucher_center_id">

                        <div class="mb-3">
                            <label class="form-label">Candidate</label>
                            <div class="form-control bg-light" id="voucher_candidate_info"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea class="form-control" name="remarks" rows="3"
                                placeholder="Enter remarks (optional)"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-paper-plane"></i>
                            Send Request
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <script>
$(document).ready(function () {

    // ================= EXAM SCHEDULE =================

    $(document).on('click', '.exam-schedule-btn', function () {

        $('#exam_candidate_id').val($(this).data('id'));
        $('#exam_candidate_name').val($(this).data('name'));       
        $('#exam_voucher_id').val($(this).data('voucher'));

        let centerId = $(this).data('center');

        if(centerId){
            $('#exam_center_id').val(centerId);
        }else{
            $('#exam_center_id').val('');
        }

        $('#examScheduleModal').modal('show');
    });

    // Submit Exam Schedule
    $('#examScheduleForm').submit(function(e){

        e.preventDefault();

        $.ajax({

            url: "{{ route('exam-schedules.store') }}",
            type: "POST",
            data: $(this).serialize(),

            success:function(response){

                $('#examScheduleModal').modal('hide');

                Swal.fire({
                    icon:'success',
                    title:'Success',
                    text:response.message
                });

                setTimeout(function(){
                    location.reload();
                },1000);
            },

            error:function(xhr){

                let message = xhr.responseJSON?.message ?? 'Something went wrong';

                Swal.fire({
                    icon:'error',
                    title:'Error',
                    text:message
                });
            }

        });

    });

    

});
</script>

    <script>
        $(document).ready(function () {
            let currentCandidateId = null;

            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();

            // ==================== UPLOAD DOCUMENT ====================
            $('.upload-doc-btn').on('click', function () {
                currentCandidateId = $(this).data('candidate-id');
                $('#modal_candidate_id').val(currentCandidateId);
                $('#modal_candidate_info').text($(this).data('candidate-name') + ' (' + $(this).data(
                    'candidate-code') + ')');

                $('#uploadDocForm')[0].reset();
                $('#uploadDocModal').modal('show');
            });

            $('#submitUploadBtn').on('click', function () {
                const form = $('#uploadDocForm')[0];
                const formData = new FormData(form);
                formData.set('candidate_id', currentCandidateId);

                const submitBtn = $(this);
                submitBtn.prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin"></i> Uploading...');

                $.ajax({
                    url: "{{ route('candidates.documents.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#uploadDocModal').modal('hide');
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: response.message || 'Document uploaded successfully!',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            background: '#1e2937',
                            color: '#e2e8f0',
                            customClass: {
                                popup: 'colored-toast'
                            },
                            didOpen: (toast) => {
                                toast.style.borderLeft = '5px solid #10b981';
                                toast.addEventListener('mouseenter', Swal.stopTimer);
                                toast.addEventListener('mouseleave', Swal.resumeTimer);
                            }
                        });
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);
                    },
                    error: function (xhr) {
                        let errorMsg = "Upload failed! Please try again.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: errorMsg,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            background: '#1e2937',
                            color: '#e2e8f0',
                            customClass: {
                                popup: 'colored-toast'
                            },
                            didOpen: (toast) => {
                                toast.style.borderLeft = '5px solid #ef4444';
                                toast.addEventListener('mouseenter', Swal.stopTimer);
                                toast.addEventListener('mouseleave', Swal.resumeTimer);
                            }
                        });
                        submitBtn.prop('disabled', false)
                            .html('<i class="fas fa-upload"></i> Upload Document');
                    }
                });
            });



            $('#uploadDocModal').on('hidden.bs.modal', function () {
                $('#uploadDocForm')[0].reset();
            });

            // ==================== PAYMENT MODAL ====================
            // Show Payment Modal
            $(document).on('click', '.payment-btn', function () {
                $('#payment_candidate_id').val($(this).data('id'));
                $('#paymentCandidateName').text($(this).data('name'));
                $('#paymentCandidateCode').text($(this).data('code'));
                $('#paymentCourse').text($(this).data('course'));
                $('#paymentCenter').text($(this).data('center'));

                // Reset form
                $('#paymentForm')[0].reset();
                $('#receipt_section').hide();
                $('#receipt').removeAttr('required');
                $('#receipt_required').hide();

                $('#paymentModal').modal('show');
            });

            // Show/Hide Receipt Upload based on Payment Mode
            $('#payment_mode').on('change', function () {
                const mode = $(this).val();
                const receiptSection = $('#receipt_section');
                const receiptInput = $('#receipt');
                const receiptRequired = $('#receipt_required');

                // Show receipt upload for UPI, Bank Transfer, Card, Cheque
                if (mode === 'UPI' || mode === 'Bank Transfer' || mode === 'Card' || mode === 'Cheque') {
                    receiptSection.show('slow');
                    receiptInput.prop('required', true);
                    receiptRequired.show();
                } else {
                    receiptSection.hide('slow');
                    receiptInput.prop('required', false);
                    receiptRequired.hide();
                    receiptInput.val(''); // Clear file input
                }
            });

            // Submit Payment Form
            $('#paymentForm').on('submit', function (e) {
                e.preventDefault();

                const form = this;
                const formData = new FormData(form);
                const btn = $('#savePaymentBtn');

                btn.prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin"></i> Saving...');

                $.ajax({
                    url: "{{ route('payments.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#paymentModal').modal('hide');
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: response.message || 'Payment recorded successfully!',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            background: '#1e2937',
                            color: '#e2e8f0',
                            customClass: {
                                popup: 'colored-toast'
                            },
                            didOpen: (toast) => {
                                toast.style.borderLeft = '5px solid #10b981';
                                toast.addEventListener('mouseenter', Swal.stopTimer);
                                toast.addEventListener('mouseleave', Swal.resumeTimer);
                            }
                        });
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    },
                    error: function (xhr) {
                        btn.prop('disabled', false)
                            .html('<i class="fas fa-save"></i> Save Payment');

                        let errors = '';
                        if (xhr.status == 422) {
                            $.each(xhr.responseJSON.errors, function (key, value) {
                                errors += value[0] + '<br>';
                            });
                        } else {
                            errors = xhr.responseJSON?.message ?? 'Something went wrong.';
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            html: errors,
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            });

            // Reset form when modal is hidden
            $('#paymentModal').on('hidden.bs.modal', function () {
                $('#paymentForm')[0].reset();
                $('#receipt_section').hide();
                $('#receipt').removeAttr('required');
                $('#receipt_required').hide();
                $('#savePaymentBtn').prop('disabled', false)
                    .html('<i class="fas fa-save"></i> Save Payment');
            });
        });

        //voucher request
        $(document).on('click', '.request-voucher-btn', function () {

            let voucherStatus = $(this).data('voucher-status');

            if (voucherStatus === 'Allocated') {
                Swal.fire({
                    icon: 'info',
                    title: 'Voucher Already Allocated',
                    text: 'A voucher has already been allocated to this candidate. A new request cannot be created.',
                    confirmButtonColor: '#3085d6'
                });

                return;
            }

            $('#voucher_candidate_id').val($(this).data('candidate-id'));
            $('#voucher_center_id').val($(this).data('center-id'));

            $('#voucher_candidate_info').html(
                '<strong>' + $(this).data('candidate-name') + '</strong><br>' +
                '<small>' + $(this).data('candidate-code') + '</small>'
            );

            $('#voucherRequestModal').modal('show');
        });
    </script>
    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'No vouchers are currently available. Please add a new voucher to assign to this student.',
                text: "{{ session('error') }}",
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if(session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'No vouchers are currently available. Please add a new voucher to assign to this student.',
                text: "{{ session('warning') }}",
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection
