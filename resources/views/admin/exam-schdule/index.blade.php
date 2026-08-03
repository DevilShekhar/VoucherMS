@can('exam-schedules.index')
    @extends('layouts.app')
    @section('content')
        <section class="section premium-dashboard">
            <div class="premium-header">
                <div class="premium-header-overlay"></div>
                <div class="premium-header-left">
                    <div class="premium-header-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="premium-header-content">
                        <span class="premium-tag">EXAM MANAGEMENT</span>
                        <h2 class="text-white">Exam Schedule</h2>
                        <p>Manage all scheduled exams</p>
                    </div>
                </div>
                <!-- Decorative Shapes -->
                <div class="shape circle-1"></div>
                <div class="shape circle-2"></div>
                <div class="shape circle-3"></div>
                <div class="dots"></div>
            </div>
        </section>
        <section class="section premium-dashboard pt-0">
            <div class="card premium-block">

                {{-- Header --}}
                <div class="card-header premium-card-header">
                    <div>
                        <h4 class="mb-1">All Exam Schedules</h4>
                        <p class="header-subtext mb-0">
                            View and manage scheduled examinations
                        </p>
                    </div>
                </div>

                <div class="card-body">

                    {{-- Filter Form --}}
                    <form method="POST" action="{{ route('exam-schedules.index') }}" class="mb-4">
                        @csrf

                        <div class="row g-3 align-items-end">

                            <div class="col-lg-2 col-md-6">
                                <label class="form-label fw-semibold">From Date</label>
                                <input type="date" name="from_date" value="{{ old('from_date') }}" class="form-control">
                            </div>

                            <div class="col-lg-2 col-md-6">
                                <label class="form-label fw-semibold">To Date</label>
                                <input type="date" name="to_date" value="{{ old('to_date') }}" class="form-control">
                            </div>

                            <div class="col-lg-2 col-md-6">
                                <label class="form-label">Course Category</label>

                                <select name="course_category_id" id="course_category_id" class="form-control">
                                    <option value="">Select Category</option>

                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-2 col-md-6">
                                <label class="form-label">Course</label>

                                <select name="course_id" id="course_id" class="form-control">
                                    <option value="">Select Course</option>

                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->course_name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('course_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-12">
                                <div class="d-flex gap-2 h-100 align-items-end">
                                    <button type="submit" class="btn btn-success flex-fill">
                                        <i class="fas fa-filter me-1"></i>
                                        Filter
                                    </button>

                                    <a href="{{ route('exam-schedules.index') }}" class="btn btn-secondary flex-fill">
                                        <i class="fas fa-undo me-1"></i>
                                        Reset
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Candidate Name</th>
                                    <th>Course Category</th>
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
                                        <td>{{ $schedule->candidate->course?->category?->name ?? '-' }}</td>
                                        <td>{{ $schedule->candidate->course->course_name ?? '-' }}</td>
                                        <td>{{ $schedule->center->center_name ?? '-' }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($schedule->exam_date)->format('d M Y') }} |
                                            {{ \Carbon\Carbon::parse($schedule->exam_time)->format('h:i A') }}
                                        </td>
                                        <td>
                                            @if($schedule->exam_status == 'Scheduled')
                                                <span class="badge bg-primary">Scheduled</span>
                                            @elseif($schedule->exam_status == 'Completed')
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-danger">Cancelled</span>
                                            @endif
                                        </td>
                                        <td>{{ $schedule->createdBy->name ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('exam-schedules.show', $schedule->id) }}"
                                                class="btn btn-info btn-sm me-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
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
        <script>
            $(document).ready(function () {

                $('#course_category_id').change(function () {

                    let categoryId = $(this).val();

                    $('#course_id').html('<option value="">Loading...</option>');

                    if (categoryId == '') {
                        $('#course_id').html('<option value="">Select Course</option>');
                        return;
                    }

                    $.ajax({
                        url: '/courses/by-category/' + categoryId,
                        type: 'GET',
                        success: function (response) {

                            let options = '<option value="">Select Course</option>';

                            $.each(response, function (index, course) {
                                options += `<option value="${course.id}">
                                                            ${course.course_name}
                                                        </option>`;
                            });

                            $('#course_id').html(options);
                        }
                    });

                });

            });

        </script>
    @endsection
@else
    @php
        abort(403);
    @endphp
@endcan
