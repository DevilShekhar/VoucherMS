@can('candidates.show')
    @extends('layouts.app')

    @section('content')
        <section class="section premium-dashboard pt-0">
            <div class="candidate-hero">
                <div class="candidate-hero-overlay"></div>
                <div class="candidate-hero-content">
                    <div class="candidate-left">
                        <div class="candidate-avatar">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="candidate-details">
                            <span class="hero-badge">
                                Candidate Management
                            </span>
                            <h2>
                                {{ $candidate->first_name }}
                                {{ $candidate->last_name ?? '' }}
                            </h2>
                            <div class="candidate-meta">
                                <div class="meta-item">
                                    <i class="fas fa-id-card"></i>
                                    <span>
                                        {{ $candidate->candidate_code }}
                                    </span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-circle text-success"></i>
                                    <span>
                                        {{ $candidate->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="candidate-actions">
                        <a href="{{ route('candidates.index') }}" class="btn btn-light premium-btn">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back
                        </a>
                        <button class="btn premium-upload-btn upload-doc-btn" data-candidate-id="{{ $candidate->id }}"
                            data-candidate-name="{{ $candidate->first_name }} {{ $candidate->last_name ?? '' }}"
                            data-candidate-code="{{ $candidate->candidate_code }}">
                            <i class="fas fa-upload me-2"></i>
                            Upload Document
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <section class="candidate-information-section mt-4">
            <!-- Quick Information -->
            <div class="premium-profile-card">
                <div class="profile-section-title">
                    <div class="title-icon">
                        <i class="fas fa-address-card"></i>
                    </div>
                    <div>
                        <h4>Quick Information</h4>
                        <p>Basic contact information of the candidate</p>
                    </div>
                </div>
                <div class="profile-body">
                    <div class="row g-4">
                        <div class="col-lg-3 col-md-6">
                            <div class="info-box">
                                <div class="info-icon blue">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <span>Mobile</span>
                                    <h6>{{ $candidate->mobile }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="info-box text-center">
                                <div class="info-icon green">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <span>Email</span>
                                    <h6>{{ $candidate->email ?: '-' }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="info-box">
                                <div class="info-icon orange">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div>
                                    <span>Company</span>
                                    <h6>{{ $candidate->company ?: '-' }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="info-box">
                                <div class="info-icon purple">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <span>City</span>
                                    <h6>{{ $candidate->city ?: '-' }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Candidate Details -->
            <div class="premium-profile-card mt-4">
                <div class="profile-section-title">
                    <div class="title-icon success">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div>
                        <h4>Candidate Details</h4>
                        <p>Academic and profile information</p>
                    </div>
                </div>
                <div class="profile-body">
                    <div class="row g-4">
                        <div class="col-lg-3 col-md-6">
                            <div class="info-box">
                                <div class="info-icon blue">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div>
                                    <div class="mb-2">
                                        <label class="text-muted small fw-semibold">Course Category</label>
                                        <h6 class="mb-0">
                                            {{ $candidate->course?->category?->name ?? 'Not Assigned' }}
                                        </h6>
                                    </div>

                                    <div>
                                        <label class="text-muted small fw-semibold">Course</label>
                                        <h6 class="mb-0">
                                            {{ $candidate->course?->course_name ?? 'Not Assigned' }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="info-box">
                                <div class="info-icon green">
                                    <i class="fas fa-school"></i>
                                </div>
                                <div>
                                    <span>Center</span>
                                    <h6>{{ $candidate->center->center_name ?? 'Not Assigned' }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="info-box">
                                <div class="info-icon orange">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div>
                                    <span>Executive</span>
                                    <h6>{{ $candidate->executive->name ?? 'Not Assigned' }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="info-box">
                                <div class="info-icon purple">
                                    <i class="fas fa-venus-mars"></i>
                                </div>
                                <div>
                                    <span>Gender</span>
                                    <h6>{{ $candidate->gender ?? '-' }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="info-box">
                                <div class="info-icon blue">
                                    <i class="fas fa-birthday-cake"></i>
                                </div>
                                <div>
                                    <span>Date of Birth</span>
                                    <h6>{{ $candidate->dob ? $candidate->dob->format('d M Y') : '-' }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="info-box">
                                <div class="info-icon green">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <div>
                                    <span>Created At</span>
                                    <h6>{{ $candidate->created_at->format('d M Y h:i A') }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="info-box">
                                <div class="info-icon orange">
                                    <i class="fas fa-history"></i>
                                </div>
                                <div>
                                    <span>Updated At</span>
                                    <h6>{{ $candidate->updated_at->format('d M Y h:i A') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section premium-dashboard  ">
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card premium-block">
                        <div class="profile-section-title">
                            <div class="title-icon success">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div>
                                <h4>Payment History</h4>
                                <p>Track all candidate payment transactions</p>
                            </div>
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
                        <div class="profile-section-title d-flex justify-content-between align-items-center">
                            <div class="title-icon success">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <div>
                                <h4>Uploaded Documents</h4>
                            </div>
                            <div>
                                <button class="btn btn-success btn-sm upload-doc-btn" data-candidate-id="{{ $candidate->id }}"
                                    data-candidate-name="{{ $candidate->first_name }} {{ $candidate->last_name ?? '' }}"
                                    data-candidate-code="{{ $candidate->candidate_code }}">
                                    <i class="fas fa-upload"></i> Upload New
                                </button>
                            </div>
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
@else
    @php
        abort(403);
    @endphp
@endcan
