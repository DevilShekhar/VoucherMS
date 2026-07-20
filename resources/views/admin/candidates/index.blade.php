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
        <div class="card premium-block">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
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

    <script>
$(document).ready(function() {
    let currentCandidateId = null;

    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Upload Document Button Click
    $('.upload-doc-btn').on('click', function() {
        currentCandidateId = $(this).data('candidate-id');
        $('#modal_candidate_id').val(currentCandidateId);
        $('#modal_candidate_info').text($(this).data('candidate-name') + ' (' + $(this).data('candidate-code') + ')');

        $('#uploadDocForm')[0].reset();
        $('#uploadDocModal').modal('show');
    });

    // Submit Upload with Immediate Reload using SweetAlert
    $('#submitUploadBtn').on('click', function() {
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
            success: function(response) {
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
                setTimeout(function() {
                    window.location.reload();
                }, 1500);
            },
            error: function(xhr) {
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
    $('#uploadDocModal').on('hidden.bs.modal', function() {
        $('#uploadDocForm')[0].reset();
    });
});
</script>
@endsection
