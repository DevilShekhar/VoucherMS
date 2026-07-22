@extends('layouts.app')
@section('content')
    <section class="section premium-dashboard">
        <div class="premium-floating-header">
            <div class="header-content">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div>
                        <span class="header-badge">Exam Management</span>
                        <h2>Exam Schedule</h2>
                        <p>Manage all scheduled exams</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section premium-dashboard pt-0">
        <div class="card premium-block">
            <div class="card-header premium-card-header">
                <div>
                    <h4 class="mb-1">All Exam Schedules</h4>
                    <p class="header-subtext mb-0">
                        View and manage scheduled examinations
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
                                <th>Exam Date Time</th>                               
                                <th>Status</th>
                                <th>Created By</th>
                                <th width="140">Action</th>
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
                                    <td> {{ $schedule->candidate->course->course_name ?? '-' }}</td>
                                    <td>
                                        {{ $schedule->center->center_name ?? '-' }}
                                    </td>                                    
                                    <td>
                                        {{ \Carbon\Carbon::parse($schedule->exam_date)->format('d M Y') }} |   {{ \Carbon\Carbon::parse($schedule->exam_time)->format('h:i A') }}
                                    </td>
                                     
                                    <td>
                                        @if($schedule->exam_status=='Scheduled')
                                            <span class="badge bg-primary">Scheduled</span>
                                        @elseif($schedule->exam_status=='Completed')
                                            <span class="badge bg-success"> Completed </span>
                                        @else
                                            <span class="badge bg-danger"> Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $schedule->createdBy->name ?? '-' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('exam-schedules.show',$schedule->id) }}"
                                            class="btn btn-info btn-sm me-1">
                                                <i class="fas fa-eye"></i>
                                            </a>                                                 
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                        <h6>No Exam Schedule Found</h6>
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