@extends('layouts.app')

@section('content')


<section class="section premium-dashboard">

    <div class="card student-profile-card border-0">

        <div class="student-cover">

    <div class="cover-pattern"></div>

    <div class="exam-title">

        <div class="exam-icon">
            <i class="fas fa-calendar-check"></i>
        </div>

        <div>

            <h3>Student Exam Schedule</h3>

            <p>
                Examination Information & Status
            </p>

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
                                    <span>
                                        {{ $examSchedule->candidate->course->course_name ?? '-' }}
                                    </span>
                                </div>

                                <div class="meta-item">
                                    <i class="fas fa-building text-success"></i>
                                    <span>
                                        {{ $examSchedule->center->center_name ?? '-' }}
                                    </span>
                                </div>

                                <div class="meta-item">
                                    <i class="fas fa-calendar-day text-warning"></i>
                                    <span>
                                        {{ \Carbon\Carbon::parse($examSchedule->exam_date)->format('d F Y') }}
                                    </span>
                                    <i class="fas fa-clock text-danger"></i>
                                    <span>
                                        {{ \Carbon\Carbon::parse($examSchedule->exam_time)->format('h:i A') }}
                                    </span>
                                </div>

                               
                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-4 text-end">

                    @if($examSchedule->exam_status=='Scheduled')

                        <span class="status-pill scheduled">
                            <i class="fas fa-calendar-check me-2"></i>
                            Scheduled
                        </span>

                    @elseif($examSchedule->exam_status=='Completed')

                        <span class="status-pill completed">
                            <i class="fas fa-check-circle me-2"></i>
                            Completed
                        </span>

                    @else

                        <span class="status-pill cancelled">
                            <i class="fas fa-times-circle me-2"></i>
                            Cancelled
                        </span>

                    @endif

                    <div class="mt-4">

                        <a href="{{ route('exam-schedules.index') }}"
                           class="btn btn-light border px-4">

                            <i class="fas fa-arrow-left me-2"></i>
                            Back

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
<style>
.student-profile-card{
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 15px 40px rgba(0,0,0,.08);
    background:#fff;
}

.student-cover{
    position:relative;
    height:170px;
    background:linear-gradient(135deg,#2563eb,#4f46e5);
    overflow:hidden;
}
.cover-pattern{
    position:absolute;
    inset:0;
    background-image:
        radial-gradient(rgba(255,255,255,.15) 2px,transparent 2px);
    background-size:30px 30px;
}
.exam-title{
    position:absolute;
    left:40px;
    bottom:28px;
    display:flex;
    align-items:center;
    gap:18px;
    color:#fff;
    z-index:2;
}

.exam-title h3{
    margin:0;
    font-size:30px;
    font-weight:700;
}

.exam-title p{
    margin:5px 0 0;
    opacity:.9;
}

.exam-icon{
    width:70px;
    height:70px;
    border-radius:16px;
    background:rgba(255,255,255,.15);
    backdrop-filter:blur(6px);
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:30px;
}


.student-avatar{
    width:110px;
    height:110px;
    border-radius:50%;
    background:#fff;
    border:6px solid #fff;
    margin-top:-75px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:45px;
    color:#355CFF;
    box-shadow:0 10px 30px rgba(0,0,0,.15);
}

.student-details{
    margin-left:25px;
}

.profile-tag{
    display:inline-block;
    background:#EEF3FF;
    color:#355CFF;
    padding:7px 18px;
    border-radius:30px;
    font-weight:600;
    margin-bottom:15px;
}

.student-name{
    font-size:32px;
    font-weight:700;
    color:#1e293b;
}

.student-meta{
    display:flex;
    flex-wrap:wrap;
    gap:18px;
    margin-top:18px;
}

.meta-item{
    display:flex;
    align-items:center;
    gap:8px;
    background:#f8fafc;
    padding:10px 18px;
    border-radius:10px;
    font-weight:600;
}

.status-pill{
    display:inline-block;
    padding:12px 30px;
    border-radius:40px;
    color:#fff;
    font-weight:700;
    font-size:15px;
}

.scheduled{
    background:#0d6efd;
}

.completed{
    background:#198754;
}

.cancelled{
    background:#dc3545;
}
    </style>
@endsection