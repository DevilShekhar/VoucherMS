@extends('layouts.app')

@section('content')

<section class="section premium-dashboard">

    <div class="premium-header">

        <div class="premium-header-overlay"></div>

        <div class="premium-header-left">

            <div class="premium-header-icon">
                <i class="fas fa-book"></i>
            </div>

            <div class="premium-header-content">
                <span class="premium-tag">COURSE MANAGEMENT</span>
                <h2 class="text-white">Courses</h2>
                <p>Manage all available courses</p>
            </div>

        </div>

        <div class="premium-header-right">

            <a href="{{ route('courses.create') }}" class="premium-back-btn">
                <i class="fas fa-plus"></i>
                Add Course
            </a>

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
            <div class="card-header premium-card-header">
                <div>
                    <h4 class="mb-1">All Courses</h4>
                    <p class="header-subtext mb-0">Manage training courses</p>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle"  id="datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Status</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses as $course)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $course->course_code }}</td>
                                    <td>{{ $course->course_name }}</td>
                                    <td>
                                        @if($course->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger text-white">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('courses.edit', $course->id) }}"
                                           class="btn btn-warning btn-sm me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('courses.destroy', $course->id) }}"
                                              method="POST"
                                              class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        No Courses Found
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
