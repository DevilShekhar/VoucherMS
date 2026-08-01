@can('exam-schedules.index')
@extends('layouts.app')

@section('content')

<section class="section premium-dashboard">
    <div class="premium-header">
        <div class="premium-header-overlay"></div>

        <div class="premium-header-left">
            <div class="premium-header-icon">
                <i class="fas fa-building"></i>
            </div>

            <div class="premium-header-content">
                <span class="premium-tag">EXAM MANAGEMENT</span>
                <h2 class="text-white">Center Exam Schedule</h2>
                <p>Manage all center exam schedules</p>
            </div>
        </div>

        <div class="shape circle-1"></div>
        <div class="shape circle-2"></div>
        <div class="shape circle-3"></div>
        <div class="dots"></div>
    </div>
</section>

<section class="section premium-dashboard pt-0">
    <div class="card premium-block">

        <div class="card-header premium-card-header">
            <div>
                <h4 class="mb-1">All Center Exam Schedules</h4>
                <p class="header-subtext mb-0">
                    View and manage all scheduled center examinations.
                </p>
            </div>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle" id="examScheduleTable">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Candidate Name</th>
                            <th>Course</th>
                            <th>Center</th>
                            <th>Exam Date & Time</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th width="120">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($examSchedules as $schedule)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ $schedule->candidate->first_name ?? '' }}
                                    {{ $schedule->candidate->last_name ?? '' }}
                                </td>

                                <td>
                                    {{ $schedule->candidate->course->course_name ?? '-' }}
                                </td>

                                <td>
                                    {{ $schedule->center->center_name ?? '-' }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($schedule->exam_date)->format('d M Y') }}
                                    <br>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($schedule->exam_time)->format('h:i A') }}
                                    </small>
                                </td>

                                <td>

                                    @if($schedule->exam_status == 'Scheduled')
                                        <span class="badge bg-primary">
                                            Scheduled
                                        </span>

                                    @elseif($schedule->exam_status == 'Completed')

                                        <span class="badge bg-success">
                                            Completed
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Cancelled
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $schedule->createdBy->name ?? '-' }}
                                </td>

                                <td>

                                    <a href="{{ route('exam-schedules.show',$schedule->id) }}"
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="text-center py-5">

                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>

                                    <h6>No Center Exam Schedule Found</h6>

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

@else

@php
    abort(403);
@endphp

@endcan