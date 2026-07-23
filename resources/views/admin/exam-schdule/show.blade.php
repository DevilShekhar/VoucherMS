@extends('layouts.app')

@section('content')
    <section class="section premium-dashboard">
        <div class="card student-profile-card border-0">
            <div class="student-cover">
                <div class="cover-pattern"></div>
                <div class="exam-title d-flex justify-content-between align-items-center flex-wrap">
                    <!-- Left -->
                    <div class="d-flex align-items-center">
                        <div class="exam-icon me-3">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <h3 class="mb-1">Student Exam Schedule</h3>
                            <p class="mb-2 text-white">
                                Examination Information & Status
                            </p>
                            @if($examSchedule->voucher)
                                <div class="d-flex flex-wrap gap-2">
                                    @can('view-voucher')
                                    <span class="badge bg-primary fs-6 px-3 py-2">
                                        <i class="fas fa-ticket-alt me-1"></i>
                                        Voucher : <strong>{{ $examSchedule->voucher->voucher_code }}</strong>
                                    </span>
                                    @endcan
                                    <span class="badge
                                        @if($examSchedule->voucher->status == 'Used')
                                            bg-danger text-white
                                        @elseif($examSchedule->voucher->status == 'Available')
                                            bg-success
                                        @elseif($examSchedule->voucher->status == 'Allocated')
                                            bg-warning text-dark
                                        @else
                                            bg-secondary
                                        @endif
                                        fs-6 px-3 py-2">
                                        <i class="fas
                                            @if($examSchedule->voucher->status == 'Used')
                                                fa-times-circle
                                            @elseif($examSchedule->voucher->status == 'Available')
                                                fa-check-circle
                                            @elseif($examSchedule->voucher->status == 'Allocated')
                                                fa-hourglass-half
                                            @else
                                                fa-info-circle
                                            @endif
                                            me-1"></i>
                                        {{ $examSchedule->voucher->status }}
                                    </span>
                                    <span class="badge bg-dark fs-6 px-3 py-2">
                                        <i class="fas fa-building me-1"></i>
                                        {{ $examSchedule->voucher->vendor->vendor_name ?? '-' }}
                                    </span>
                                </div>
                            @else
                                <span class="badge bg-secondary fs-6 px-3 py-2">
                                    No Voucher Allocated
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center">
                            <div class="student-avatar">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div class="student-details">
                                <span class="profile-tag">
                                    <i class="fas fa-calendar-check me-1"></i>
                                    Student Exam Schedule
                                </span>
                                <h2 class="student-name mb-2">
                                    {{ $examSchedule->candidate->first_name ?? '' }}
                                    {{ $examSchedule->candidate->last_name ?? '' }}
                                </h2>
                                <div class="student-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-book text-primary"></i>
                                        <span>{{ $examSchedule->candidate->course->course_name ?? '-' }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-building text-success"></i>
                                        <span>{{ $examSchedule->center->center_name ?? '-' }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-calendar-day text-warning"></i>
                                        <span>{{ \Carbon\Carbon::parse($examSchedule->exam_date)->format('d F Y') }}</span>
                                        <i class="fas fa-clock text-danger"></i>
                                        <span>{{ \Carbon\Carbon::parse($examSchedule->exam_time)->format('h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 text-end">
                        @if($examSchedule->exam_status == 'Scheduled')
                            <span class="status-pill scheduled">
                                <i class="fas fa-calendar-check me-2"></i>Scheduled
                            </span>
                        @elseif($examSchedule->exam_status == 'Completed')
                            <span class="status-pill completed">
                                <i class="fas fa-check-circle me-2"></i>Completed
                            </span>
                        @else
                            <span class="status-pill cancelled">
                                <i class="fas fa-times-circle me-2"></i>Cancelled
                            </span>
                        @endif

                        <div class="mt-4 d-flex gap-2 justify-content-end">
                            <!-- Mark as Used Button - Only show if voucher exists and not used -->
                            @if($examSchedule->voucher && $examSchedule->voucher->status != 'Used')
                                <button class="btn btn-warning btn-lg" data-bs-toggle="modal"
                                    data-bs-target="#voucherStatusModal{{ $examSchedule->id }}">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Mark as Used
                                </button>
                            @endif

                            <a href="{{ route('exam-schedules.index') }}" class="btn btn-light border px-4">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Voucher Details Horizontal Table - Show when voucher is used -->
        @if($examSchedule->voucher && $examSchedule->voucher->status == 'Used')
            <div class="card mt-4 border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-check-circle me-2"></i>
                        Voucher Usage Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    @can('view-voucher')
                                    <th><i class="fas fa-ticket-alt me-2 text-primary"></i>Voucher Code</th>
                                    @endcan
                                    <th><i class="fas fa-user me-2 text-primary"></i>Student Name</th>
                                    <th><i class="fas fa-building me-2 text-primary"></i>Vendor</th>
                                    <th><i class="fas fa-calendar-check me-2 text-primary"></i>Exam Date</th>
                                    <th><i class="fas fa-clock me-2 text-primary"></i>Exam Time</th>
                                    <th><i class="fas fa-check-circle me-2 text-success"></i>Status</th>
                                    <th><i class="fas fa-sticky-note me-2 text-primary"></i>Remarks</th>
                                    <th><i class="fas fa-calendar-alt me-2 text-primary"></i>Used Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @can('view-voucher')
                                    <td>
                                        <strong class="text-primary">{{ $examSchedule->voucher->voucher_code }}</strong>
                                    </td>
                                    @endcan
                                    <td>
                                        {{ $examSchedule->candidate->first_name ?? '' }}
                                        {{ $examSchedule->candidate->last_name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $examSchedule->voucher->vendor->vendor_name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($examSchedule->exam_date)->format('d F Y') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($examSchedule->exam_time)->format('h:i A') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-danger text-white">
                                            <i class="fas fa-check me-1"></i>Used
                                        </span>
                                    </td>
                                    <td>
                                        {{ $examSchedule->voucher->remarks ?? 'No remarks provided' }}
                                    </td>
                                    <td>
                                        {{ $examSchedule->voucher->updated_at ? \Carbon\Carbon::parse($examSchedule->voucher->updated_at)->format('d F Y h:i A') : '-' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </section>

    <!-- Modal -->
    <div class="modal fade" id="voucherStatusModal{{ $examSchedule->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('vouchers.mark-used', $examSchedule->voucher_id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-check-circle me-2 text-warning"></i>
                            Mark Voucher as Used
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Reason / Remarks <span class="text-danger">*</span>
                            </label>
                            <textarea name="remarks" class="form-control" rows="4" required
                                placeholder="Enter reason for marking voucher as used..."></textarea>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Please provide a detailed reason for marking this voucher as used.
                            </small>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            @can('view-voucher')
                            <strong>Voucher Code:</strong> {{ $examSchedule->voucher->voucher_code }}<br>
                            @endcan
                            <strong>Student:</strong> {{ $examSchedule->candidate->first_name ?? '' }}
                            {{ $examSchedule->candidate->last_name ?? '' }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancel
                        </button>
                        <button class="btn btn-success">
                            <i class="fas fa-check-circle me-1"></i>Mark as Used
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .student-profile-card {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
            background: #fff;
        }

        .student-cover {
            position: relative;
            height: 170px;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            overflow: hidden;
        }

        .cover-pattern {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, .15) 2px, transparent 2px);
            background-size: 30px 30px;
        }

        .exam-title {
            position: absolute;
            left: 40px;
            bottom: 28px;
            display: flex;
            align-items: center;
            gap: 18px;
            color: #fff;
            z-index: 2;
            right: 40px;
        }

        .exam-title h3 {
            margin: 0;
            font-size: 30px;
            font-weight: 700;
        }

        .exam-title p {
            margin: 5px 0 0;
            opacity: .9;
        }

        .exam-icon {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .15);
            backdrop-filter: blur(6px);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
        }

        .student-avatar {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: #fff;
            border: 6px solid #fff;
            margin-top: -75px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 45px;
            color: #355CFF;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
            flex-shrink: 0;
        }

        .student-details {
            margin-left: 25px;
            flex: 1;
        }

        .profile-tag {
            display: inline-block;
            background: #EEF3FF;
            color: #355CFF;
            padding: 7px 18px;
            border-radius: 30px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .student-name {
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
        }

        .student-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            margin-top: 18px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f8fafc;
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 600;
        }

        .status-pill {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 40px;
            color: #fff;
            font-weight: 700;
            font-size: 15px;
        }

        .scheduled {
            background: #0d6efd;
        }

        .completed {
            background: #198754;
        }

        .cancelled {
            background: #dc3545;
        }

        .table th {
            font-weight: 600;
            color: #1e293b;
            white-space: nowrap;
            background-color: #f8f9fa;
        }

        .table td {
            vertical-align: middle;
        }

        .card-header {
            border-radius: 8px 8px 0 0 !important;
        }

        .badge {
            font-weight: 500;
        }

        /* Horizontal table scroll for mobile */
        .table-responsive {
            overflow-x: auto;
        }

        .table {
            min-width: 900px;
        }

        @media (max-width: 768px) {
            .exam-title {
                left: 20px;
                right: 20px;
                bottom: 15px;
            }

            .exam-title h3 {
                font-size: 22px;
            }

            .student-avatar {
                width: 80px;
                height: 80px;
                font-size: 32px;
                margin-top: -55px;
            }

            .student-name {
                font-size: 24px;
            }

            .student-details {
                margin-left: 15px;
            }

            .student-meta {
                gap: 10px;
            }

            .meta-item {
                padding: 6px 12px;
                font-size: 13px;
            }

            .table {
                min-width: 700px;
            }
        }
    </style>
@endsection
