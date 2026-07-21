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
                        <h2>{{ $candidate->first_name }} {{ $candidate->last_name ?? '' }}</h2>
                        <p><strong>Code:</strong> {{ $candidate->candidate_code }}</p>
                    </div>
                </div>
                <div class="premium-head-actions">
                    <a href="{{ route('candidates.index') }}" class="btn mb-2"
                        style="background:var(--cloth);color:var(--ink);">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <button class="btn btn-warning mb-2 upload-doc-btn" data-candidate-id="{{ $candidate->id }}"
                        data-candidate-name="{{ $candidate->first_name }} {{ $candidate->last_name ?? '' }}"
                        data-candidate-code="{{ $candidate->candidate_code }}">
                        <i class="fas fa-upload"></i> Upload Document
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="section premium-dashboard pt-0">
        <!-- Personal Information Card -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card premium-block">
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Side - Personal Info -->
                            <div class="col-lg-5">
                                <div class="d-flex align-items-start">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($candidate->first_name) }}&background=0d6efd&color=fff"
                                        class="rounded-circle border" width="130" height="130">
                                    <div class="ms-4">
                                        <h3 class="fw-bold">{{ $candidate->first_name }} {{ $candidate->last_name }}</h3>
                                        <h5 class="text-muted">{{ $candidate->candidate_code }}</h5>
                                        <span
                                            class="badge bg-{{ $candidate->status == 'Active' ? 'success' : 'warning' }} mt-2">
                                            {{ $candidate->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side - Key Info -->
                            <div class="col-lg-7">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <th width="25%">Mobile</th>
                                        <td>{{ $candidate->mobile }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $candidate->email ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Company</th>
                                        <td>{{ $candidate->company ?: '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>City</th>
                                        <td>{{ $candidate->city ?: '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Information Card -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card premium-block">
                    <div class="card-header bg-white">
                        <h5><i class="fas fa-info-circle"></i> Candidate Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="25%">Field</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Course</th>
                                        <td>{{ $candidate->course->course_name ?? 'Not Assigned' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Center</th>
                                        <td>{{ $candidate->center->center_name ?? 'Not Assigned' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Executive</th>
                                        <td>{{ $candidate->executive->name ?? 'Not Assigned' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>{{ $candidate->gender ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth</th>
                                        <td>{{ $candidate->dob ? $candidate->dob->format('d M Y') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ $candidate->created_at->format('d M Y h:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{ $candidate->updated_at->format('d M Y h:i A') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card premium-block">
                    <div class="card-header bg-white">
                        <h5>
                            <i class="fas fa-money-bill-wave text-success"></i>
                            Payment History
                        </h5>
                    </div>

                    <div class="card-body">

                        @if($candidate->payments->count())

                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">

                                    <thead class="table-light">
                                        <tr>
                                            <th>Payment No</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Paid</th>
                                            <th>Pending</th>
                                            <th>Status</th>
                                            <th>Mode</th>
                                            <th>Receipt</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach($candidate->payments as $payment)

                                            @php
                                                $transaction = $payment->transactions->first();
                                            @endphp

                                            <tr>

                                                <td>
                                                    <strong>{{ $payment->payment_no }}</strong>
                                                </td>

                                                <td>
                                                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                                                </td>

                                                <td>
                                                    ₹ {{ number_format($payment->net_amount, 2) }}
                                                </td>

                                                <td class="text-success fw-bold">
                                                    ₹ {{ number_format($payment->paid_amount, 2) }}
                                                </td>

                                                <td class="text-danger fw-bold">
                                                    ₹ {{ number_format($payment->pending_amount, 2) }}
                                                </td>

                                                <td>

                                                    @if($payment->payment_status == 'Paid')
                                                        <span class="badge bg-success">Paid</span>

                                                    @elseif($payment->payment_status == 'Partial')
                                                        <span class="badge bg-warning">Partial</span>

                                                    @else
                                                        <span class="badge bg-danger">Pending</span>
                                                    @endif

                                                </td>

                                                <td>
                                                    {{ $transaction->payment_mode ?? '-' }}
                                                </td>

                                                <td>

                                                    @if($transaction && $transaction->receipt)

                                                        <a href="{{ Storage::url($transaction->receipt) }}" target="_blank"
                                                            class="btn btn-sm btn-info">

                                                            <i class="fas fa-file"></i>

                                                        </a>

                                                    @else

                                                        -

                                                    @endif

                                                </td>

                                                <td>

                                                    <a href="{{ route('payments.show', $payment->id) }}"
                                                        class="btn btn-sm btn-primary">

                                                        <i class="fas fa-eye"></i>

                                                    </a>

                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>
                            </div>

                        @else

                            <div class="text-center py-5">

                                <i class="fas fa-money-bill-wave fa-4x text-muted mb-3"></i>

                                <h6>No Payment Recorded</h6>

                                <p class="text-muted mb-0">
                                    Payment history will appear here once a payment is recorded.
                                </p>

                            </div>

                        @endif

                    </div>
                </div>
            </div>
        </div>
        <!-- Documents Section -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card premium-block">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-folder-open"></i> Uploaded Documents</h5>
                        <button class="btn btn-success btn-sm upload-doc-btn" data-candidate-id="{{ $candidate->id }}"
                            data-candidate-name="{{ $candidate->first_name }} {{ $candidate->last_name ?? '' }}"
                            data-candidate-code="{{ $candidate->candidate_code }}">
                            <i class="fas fa-upload"></i> Upload New
                        </button>
                    </div>
                    <div class="card-body">
                        @if($candidate->documents->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">#</th>
                                            <th width="20%">Document Type</th>
                                            <th width="30%">File Name</th>
                                            <th width="15%">Preview</th>
                                            <th width="15%">Uploaded Date</th>
                                            <th width="15%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($candidate->documents as $index => $doc)
                                            @php
                                                $extension = strtolower(pathinfo($doc->file_name, PATHINFO_EXTENSION));
                                                $iconClass = 'fa-file';
                                                $colorClass = 'text-secondary';

                                                if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                                    $iconClass = 'fa-file-image';
                                                    $colorClass = 'text-success';
                                                } elseif ($extension == 'pdf') {
                                                    $iconClass = 'fa-file-pdf';
                                                    $colorClass = 'text-danger';
                                                } elseif (in_array($extension, ['doc', 'docx'])) {
                                                    $iconClass = 'fa-file-word';
                                                    $colorClass = 'text-primary';
                                                } elseif (in_array($extension, ['xls', 'xlsx'])) {
                                                    $iconClass = 'fa-file-excel';
                                                    $colorClass = 'text-success';
                                                } elseif (in_array($extension, ['zip', 'rar'])) {
                                                    $iconClass = 'fa-file-archive';
                                                    $colorClass = 'text-warning';
                                                }
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>
                                                    <span class="badge"
                                                        style="background: #0d6efd; color: white; padding: 6px 12px; font-size: 0.85rem;">
                                                        <i class="fas {{ $iconClass }} me-1"></i>
                                                        {{ $doc->document_type }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="fw-medium">{{ $doc->file_name }}</span>
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fas fa-hdd me-1"></i>
                                                        {{ number_format($doc->file_size ?? 0, 2) }} KB
                                                    </small>
                                                </td>
                                                <td>
                                                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                        <img src="{{ Storage::url($doc->file_path) }}" class="img-thumbnail"
                                                            style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;"
                                                            alt="{{ $doc->document_type }}"
                                                            onclick="window.open('{{ Storage::url($doc->file_path) }}', '_blank')">
                                                    @else
                                                        <div class="text-center" style="font-size: 2rem; color: #6c757d;">
                                                            <i class="fas {{ $iconClass }} {{ $colorClass }}"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span>{{ $doc->created_at->format('d M Y') }}</span>
                                                        <small class="text-muted">{{ $doc->created_at->format('h:i A') }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                                                            class="btn btn-primary" data-bs-toggle="tooltip" title="View Document">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ Storage::url($doc->file_path) }}" download
                                                            class="btn btn-secondary" data-bs-toggle="tooltip"
                                                            title="Download Document">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <strong>Total Documents: {{ $candidate->documents->count() }}</strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-4x mb-3"></i>
                                <p class="mb-2">No documents uploaded yet.</p>
                                <button class="btn btn-success btn-sm upload-doc-btn" data-candidate-id="{{ $candidate->id }}"
                                    data-candidate-name="{{ $candidate->first_name }} {{ $candidate->last_name ?? '' }}"
                                    data-candidate-code="{{ $candidate->candidate_code }}">
                                    <i class="fas fa-upload"></i> Upload First Document
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadDocModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-upload text-success"></i> Upload Document
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadDocForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="candidate_id" id="modal_candidate_id">

                        <div class="mb-3">
                            <label class="form-label">Candidate Information</label>
                            <div class="p-3 bg-light rounded">
                                <p id="modal_candidate_info" class="fw-bold mb-0"></p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Document Type <span class="text-danger">*</span></label>
                            <select name="document_type" class="form-select" required>
                                <option value="">-- Select Document Type --</option>
                                <option value="Aadhaar">Aadhaar Card</option>
                                <option value="PAN">PAN Card</option>
                                <option value="Photo">Passport Photo</option>
                                <option value="Education">Education Certificate</option>
                                <option value="Experience">Experience Letter</option>
                                <option value="Resume">Resume / CV</option>
                                <option value="Other">Other Document</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload File <span class="text-danger">*</span></label>
                            <input type="file" name="document" class="form-control" required>
                            <small class="text-muted">Supported formats: JPG, PNG, PDF, DOC, DOCX (Max: 5MB)</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="button" id="submitUploadBtn" class="btn btn-success">
                        <i class="fas fa-upload"></i> Upload Document
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            let currentCandidateId = null;

            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Upload Document Button Click
            $('.upload-doc-btn').on('click', function () {
                currentCandidateId = $(this).data('candidate-id');
                $('#modal_candidate_id').val(currentCandidateId);
                $('#modal_candidate_info').text($(this).data('candidate-name') + ' (' + $(this).data('candidate-code') + ')');

                $('#uploadDocForm')[0].reset();
                $('#uploadDocModal').modal('show');
            });

            // Submit Upload with Immediate Reload using SweetAlert
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

                        // Show success message using SweetAlert
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

                        // Immediate page reload after toast
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);
                    },
                    error: function (xhr) {
                        let errorMsg = "Upload failed! Please try again.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }

                        // Show error message using SweetAlert
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

            // Reset form when modal is hidden
            $('#uploadDocModal').on('hidden.bs.modal', function () {
                $('#uploadDocForm')[0].reset();
            });
        });
    </script>
@endsection
