@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')
    <section class="section premium-dashboard">
    <div class="card premium-block shadow-sm">

        <div class="card-body py-4 px-4">
            <div class="header-content d-flex justify-content-between align-items-start flex-wrap gap-4">

                <!-- Left Side -->
                <div class="header-left d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-chart-pie fa-3x" style="color: #1e40af;"></i>
                    </div>
                    <div>
                        <span class="header-badge px-3 py-1"
                              style="background-color: #1e40af; color: white; border-radius: 30px; font-size: 0.85rem;">
                            Overview
                        </span>

                        <h2 class="mb-2 mt-2" style="color: #1e3a8a;">Dashboard</h2>
                        <!-- Enhanced Greeting -->
                       @php
                        $hour = now()->hour;

                        if ($hour >= 5 && $hour < 12) {
                            $timeOfDay = 'Morning';
                        } elseif ($hour >= 12 && $hour < 17) {
                            $timeOfDay = 'Afternoon';
                        } elseif ($hour >= 17 && $hour < 21) {
                            $timeOfDay = 'Evening';
                        } else {
                            $timeOfDay = 'Night';
                        }
                    @endphp

                    <p class="mb-0 fw-medium" style="font-size: 1.1rem; color: #1e3a8a;">
                        👋 Welcome back! Good {{ $timeOfDay }}, <strong>{{ Auth::user()->name }}</strong>.
                        We hope you're having a productive day.
                    </p>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="d-flex flex-column align-items-end gap-3">
                    <span style="font-size: 13px; color: #334155; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-calendar-alt" style="color: #f59e0b;"></i>
                        {{ now()->format('l, F j, Y') }}
                    </span>
                    <div class="d-flex gap-2">
                        <a href="{{ route('dashboard.export.leads') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-file-excel"></i> Download Leads
                        </a>

                        <a href="{{ route('dashboard.export.vouchers') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-file-excel"></i> Download Vouchers
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Super admin --}}
{{-- <section class="section premium-dashboard pt-0">
    <!-- Stats Cards -->
    <div class="stat-grid-container mb-4">
        <div class="stat-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">

            <!-- 1. Enrolled Students -->
            <div class="stat-card" style="background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-wrapper" style="width: 48px; height: 48px; background: #E9EEFE; color: #4F46E5; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
                <div class="num" style="font-size: 32px; font-weight: 700; color: #1e293b; margin-bottom: 4px;">
                    {{ number_format($totalStudents ?? 0) }}
                </div>
                <div class="lbl" style="color: #64748b; font-size: 14px; font-weight: 500;">Enrolled Students</div>
            </div>

            <!-- 2. Active Courses -->
            <div class="stat-card" style="background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-wrapper" style="width: 48px; height: 48px; background: #E9EEFE; color: #4F46E5; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                        <i class="fas fa-book-open"></i>
                    </div>
                </div>
                <div class="num" style="font-size: 32px; font-weight: 700; color: #1e293b; margin-bottom: 4px;">
                    {{ $activeCourses ?? 0 }}
                </div>
                <div class="lbl" style="color: #64748b; font-size: 14px; font-weight: 500;">Active Courses</div>
            </div>

            <!-- 3. Assignments Pending Review -->
            <div class="stat-card" style="background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-wrapper" style="width: 48px; height: 48px; background: #E9EEFE; color: #4F46E5; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                        <i class="fas fa-file-pen"></i>
                    </div>
                </div>
                <div class="num" style="font-size: 32px; font-weight: 700; color: #1e293b; margin-bottom: 4px;">
                    {{ $pendingLeads ?? 0 }}
                </div>
                <div class="lbl" style="color: #64748b; font-size: 14px; font-weight: 500;">Pending Leads</div>
                <div class="delta mt-2" style="color: #f59e0b; font-size: 13px; font-weight: 600;">
                    <i class="fas fa-clock me-1"></i> Requires Follow-up
                </div>
            </div>

            <!-- 4. Scheduled Exams -->
            <div class="stat-card" style="background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-wrapper" style="width: 48px; height: 48px; background: #E9EEFE; color: #4F46E5; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
                <div class="num" style="font-size: 32px; font-weight: 700; color: #1e293b; margin-bottom: 4px;">
                    {{ $scheduledExams ?? 0 }}
                </div>
                <div class="lbl" style="color: #64748b; font-size: 14px; font-weight: 500;">Scheduled Exams</div>
                <div class="delta up mt-2" style="color: #10b981; font-size: 13px; font-weight: 600;">
                    <i class="fas fa-check-circle me-1"></i> Active
                </div>
            </div>

        </div>
    </div>

    <!-- Recent Enrollments -->
    <div class="panel" style="background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06); overflow: hidden;">
        <div class="panel-head d-flex justify-content-between align-items-center px-4 py-3 border-bottom">
            <h2 style="font-size: 18px; font-weight: 600; margin: 0; color: #1e293b;">Recent Enrollments</h2>
            <a href="{{ route('candidates.index') }}" class="text-primary fw-semibold text-decoration-none">
                View All <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0" style="font-size: 14px;">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Student</th>
                        <th>Course</th>
                        <th>Center</th>
                        <th>Status</th>
                        <th>Enrolled On</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentEnrollments ?? [] as $candidate)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle" style="width: 32px; height: 32px; background: #E9EEFE; color: #4F46E5; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 13px;">
                                        {{ strtoupper(substr($candidate->first_name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $candidate->first_name }} {{ $candidate->last_name }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $candidate->course->course_name ?? 'N/A' }}</td>
                            <td>{{ $candidate->center->center_name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-success">Converted</span>
                            </td>
                            <td>{{ $candidate->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No recent enrollments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section> --}}

{{-- Other users --}}
<section class="section premium-dashboard pt-0">
    <!-- Stats Cards -->
    <div class="stat-grid-container mb-4">
        <div class="stat-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(245px, 1fr)); gap: 22px;">

            <!-- 1. Enrolled Students -->
            <div class="stat-card" style="background: #ffffff; border: 1px solid #e0e7ff; border-radius: 20px; padding: 28px 24px; box-shadow: 0 10px 30px rgba(79, 70, 229, 0.08); transition: all 0.3s ease;">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="icon-wrapper" style="width: 54px; height: 54px; background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
                <div class="num" style="font-size: 36px; font-weight: 700; color: #1e293b; margin-bottom: 6px; font-family: 'Inter', system-ui;">
                    {{ number_format($totalStudents ?? 0) }}
                </div>
                <div class="lbl" style="color: #64748b; font-size: 14.5px; font-weight: 500;">Enrolled Students</div>
            </div>

            <!-- 2. Active Courses -->
            <div class="stat-card" style="background: #ffffff; border: 1px solid #e0e7ff; border-radius: 20px; padding: 28px 24px; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.08); transition: all 0.3s ease;">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="icon-wrapper" style="width: 54px; height: 54px; background: linear-gradient(135deg, #10b981, #059669); color: white; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);">
                        <i class="fas fa-book-open"></i>
                    </div>
                </div>
                <div class="num" style="font-size: 36px; font-weight: 700; color: #1e293b; margin-bottom: 6px; font-family: 'Inter', system-ui;">
                    {{ $activeCourses ?? 0 }}
                </div>
                <div class="lbl" style="color: #64748b; font-size: 14.5px; font-weight: 500;">Active Courses</div>
            </div>

            <!-- 3. Pending Leads -->
            <div class="stat-card" style="background: #ffffff; border: 1px solid #e0e7ff; border-radius: 20px; padding: 28px 24px; box-shadow: 0 10px 30px rgba(245, 158, 11, 0.08); transition: all 0.3s ease;">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="icon-wrapper" style="width: 54px; height: 54px; background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);">
                        <i class="fas fa-file-pen"></i>
                    </div>
                </div>
                <div class="num" style="font-size: 36px; font-weight: 700; color: #1e293b; margin-bottom: 6px; font-family: 'Inter', system-ui;">
                    {{ $pendingLeads ?? 0 }}
                </div>
                <div class="lbl" style="color: #64748b; font-size: 14.5px; font-weight: 500;">Pending Leads</div>
                <div class="mt-3" style="color: #f59e0b; font-size: 13.5px; font-weight: 600;">
                    <i class="fas fa-clock me-1"></i> Requires Follow-up
                </div>
            </div>

            <!-- 4. Scheduled Exams -->
            <div class="stat-card" style="background: #ffffff; border: 1px solid #e0e7ff; border-radius: 20px; padding: 28px 24px; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.08); transition: all 0.3s ease;">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="icon-wrapper" style="width: 54px; height: 54px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3);">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
                <div class="num" style="font-size: 36px; font-weight: 700; color: #1e293b; margin-bottom: 6px; font-family: 'Inter', system-ui;">
                    {{ $scheduledExams ?? 0 }}
                </div>
                <div class="lbl" style="color: #64748b; font-size: 14.5px; font-weight: 500;">Scheduled Exams</div>
                <div class="mt-3" style="color: #10b981; font-size: 13.5px; font-weight: 600;">
                    <i class="fas fa-check-circle me-1"></i> Active
                </div>
            </div>

        </div>
    </div>

    <!-- Recent Enrollments -->
    <div class="panel" style="background: #ffffff; border: 1px solid #e0e7ff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06); overflow: hidden;">
        <div class="panel-head d-flex justify-content-between align-items-center px-5 py-4 border-bottom">
            <h2 style="font-size: 19px; font-weight: 600; margin: 0; color: #1e293b;">Recent Enrollments</h2>
            <a href="{{ route('candidates.index') }}" class="text-indigo-600 fw-semibold text-decoration-none d-flex align-items-center gap-1">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0" style="font-size: 14.5px;">
                <thead class="table-light">
                    <tr>
                        <th class="ps-5">Student</th>
                        <th>Course</th>
                        <th>Center</th>
                        <th>Status</th>
                        <th>Enrolled On</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentEnrollments ?? [] as $candidate)
                        <tr>
                            <td class="ps-5">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle" style="width: 36px; height: 36px; background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 14px;">
                                        {{ strtoupper(substr($candidate->first_name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $candidate->first_name }} {{ $candidate->last_name }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $candidate->course->course_name ?? 'N/A' }}</td>
                            <td>{{ $candidate->center->center_name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge" style="background: #10b981; color: white; padding: 6px 14px; border-radius: 30px; font-size: 12.5px;">Converted</span>
                            </td>
                            <td>{{ $candidate->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No recent enrollments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

@can('view-voucher')
 <section class="section premium-dashboard pt-0">
    <div class="card premium-block">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">All Vouchers</h5>

                <span class="badge bg-primary fs-6">
                    Total Vouchers : {{ $vouchers->total() }}
                </span>
            </div>

            <div class="table-responsive">

                <table class="table table-hover" id="datatable">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Vendor Name</th>
                            <th>Voucher Code</th>
                            <th>Expiry Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($vouchers as $voucher)

                            <tr>

                                <td>{{ $loop->iteration + ($vouchers->firstItem() ?? 0) - 1 }}</td>

                                <td>
                                    {{ $voucher->vendor->vendor_name ?? '-' }}
                                </td>

                                <td>
                                        <span class="voucher-code-display" style="cursor: pointer;"
                                            onclick="toggleVoucherCode(this)">
                                            <span class="voucher-code-hidden">••••••••</span>
                                            <span class="voucher-code-visible"
                                                style="display: none;">{{ $voucher->voucher_code }}</span>
                                            <i class="fas fa-eye voucher-eye-icon"
                                                style="margin-left: 5px; font-size: 0.8rem; color: #6c757d;"></i>
                                        </span>
                                    </td>

                                    <td>
                                        @if($voucher->expiry_date)
                                            {{ \Carbon\Carbon::parse($voucher->expiry_date)->format('d M Y') }}

                                            @if(\Carbon\Carbon::parse($voucher->expiry_date)->isPast() && $voucher->status != 'Expired')
                                                <br>
                                                <small class="text-danger fw-bold">Expired</small>
                                            @elseif(\Carbon\Carbon::parse($voucher->expiry_date)->diffInDays(now(), false) <= 7 &&
                                                    \Carbon\Carbon::parse($voucher->expiry_date)->isFuture())
                                                <br>
                                                <small class="text-warning fw-bold" style="color:rgb(187 95 255) !important">
                                                    Expires in {{ floor(now()->diffInDays(\Carbon\Carbon::parse($voucher->expiry_date))) }} day(s)
                                                </small>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                <td>
                                    @switch($voucher->status)

                                        @case('Available')
                                            <span class="badge bg-success">Available</span>
                                            @break

                                        @case('Allocated')
                                            <span class="badge bg-primary">Allocated</span>
                                            @break

                                        @case('Used')
                                            <span class="badge bg-danger text-white">Used</span>
                                            @break

                                        @case('Expired')
                                            <span class="badge bg-warning text-white">Expired</span>
                                            @break

                                        @case('Cancelled')
                                            <span class="badge bg-info">Cancelled</span>
                                            @break

                                        @default
                                            <span class="badge bg-light text-dark">
                                                {{ $voucher->status }}
                                            </span>

                                    @endswitch

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    No vouchers found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>
</section>
@endcan

<section class="section premium-dashboard pt-0">
    <div class="row">
        <div class="col-lg-12">

            <div class="card premium-block">

                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-calendar-day text-warning me-2"></i>
                            Today's Lead Updates
                        </h5>
                        <small class="text-muted">
                            All follow-ups scheduled for today • Updated in real-time
                        </small>
                    </div>
                    <span class="badge bg-warning text-dark px-3 py-2">
                        TODAY
                    </span>
                </div>

                <div class="card-body p-0">
                    <div class="card-header bg-white">

                        <form method="GET" action="{{ route('dashboard') }}">
                            <div class="row align-items-end">

                                <div class="col-md-4">
                                    <label class="form-label">Location</label>

                                    <select name="location_id"
                                            class="form-select"
                                            onchange="this.form.submit()">

                                        <option value="">All Locations</option>

                                        @foreach($locations as $location)

                                            <option value="{{ $location->id }}"
                                                {{ request('location_id') == $location->id ? 'selected' : '' }}>

                                                {{ $location->name }}

                                            </option>

                                        @endforeach

                                    </select>
                                </div>

                            </div>
                        </form>

                    </div>
                    <div class="table-responsive" style="max-height: 320px; overflow-y: auto;">
                        <table class="table table-hover mb-0">
                            <thead class="table-light bg-white">
                                <tr>
                                    <th>Lead No</th>
                                    <th>Candidate Name</th>
                                    <th>Mobile</th>
                                    <th>Executive</th>
                                    <th>Course</th>
                                    <th>Today's Follow-up</th>
                                    <th>Status</th>
                                    <th>Next Follow-up</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($todayLeads as $item)
                                    <tr>
                                        <td><strong>{{ $item->lead->lead_no ?? '-' }}</strong></td>
                                        <td>{{ $item->lead->candidate_name }}</td>
                                        <td>{{ $item->lead->mobile }}</td>
                                        <td>{{ $item->lead->assignedUser->name ?? '-' }}</td>
                                        <td>{{ $item->lead->course->course_name ?? '-' }}</td>
                                        <td class="text-primary">
                                            <strong>{{ \Carbon\Carbon::parse($item->followup_date)->format('d M Y h:i A') }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $item->status }}</span>
                                        </td>
                                        <td>
                                            @if($item->next_followup)
                                                {{ \Carbon\Carbon::parse($item->next_followup)->format('d M Y h:i A') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                            <h6 class="text-muted">No Leads for Today</h6>
                                            <small class="text-muted">All today's follow-ups will appear here.</small>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>



    <style>
        /* Mobile Responsive Styles */
        @media (max-width: 1024px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }

            .slider-nav {
                display: none !important;
            }
        }

        @media (max-width: 768px) {
            .stat-grid {
                display: flex !important;
                overflow-x: auto !important;
                scroll-snap-type: x mandatory !important;
                gap: 16px !important;
                padding: 4px 4px 16px 4px !important;
                scroll-behavior: smooth !important;
                -webkit-overflow-scrolling: touch !important;
                margin-bottom: 8px !important;
            }

            .stat-grid .stat-card {
                flex: 0 0 85% !important;
                scroll-snap-align: start !important;
                min-width: 0 !important;
                margin-right: 0 !important;
            }

            .stat-grid::-webkit-scrollbar {
                display: none !important;
            }

            .slider-nav {
                display: flex !important;
            }

            .slider-dot.active {
                background: var(--ember) !important;
                transform: scale(1.2) !important;
            }

            .slider-dot {
                width: 10px !important;
                height: 10px !important;
                border-radius: 50% !important;
                border: 2px solid var(--ember) !important;
                background: transparent !important;
                cursor: pointer !important;
                padding: 0 !important;
                transition: all 0.3s ease !important;
            }

            .slider-dot.active {
                background: var(--ember) !important;
                transform: scale(1.2) !important;
            }

            .slider-dot:hover {
                transform: scale(1.1) !important;
            }
        }

        @media (max-width: 480px) {
            .stat-grid .stat-card {
                flex: 0 0 90% !important;
            }

            .panel-head {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 8px;
            }

            .panel-head h2 {
                font-size: 16px !important;
            }

            .table {
                font-size: 12px !important;
            }

            .table th,
            .table td {
                padding: 10px 12px !important;
            }

            .status-pill {
                font-size: 10px !important;
                padding: 3px 10px !important;
            }

            .btn-sm {
                padding: 4px 10px !important;
                font-size: 10px !important;
            }
        }
    </style>

    <script>
        // Card Slider functionality for mobile
        document.addEventListener('DOMContentLoaded', function () {
            const statGrid = document.getElementById('statGrid');
            const dots = document.querySelectorAll('.slider-dot');
            let currentIndex = 0;
            let isDragging = false;
            let startX = 0;
            let scrollLeft = 0;

            if (statGrid) {
                // Update active dot based on scroll position
                statGrid.addEventListener('scroll', function () {
                    const cardWidth = this.querySelector('.stat-card')?.offsetWidth || 0;
                    const scrollPosition = this.scrollLeft;
                    const newIndex = Math.round(scrollPosition / (cardWidth + 16));

                    if (newIndex !== currentIndex && newIndex < dots.length) {
                        currentIndex = newIndex;
                        dots.forEach((dot, index) => {
                            dot.classList.toggle('active', index === currentIndex);
                        });
                    }
                });

                // Click on dot to scroll to specific card
                dots.forEach((dot, index) => {
                    dot.addEventListener('click', function () {
                        const cardWidth = statGrid.querySelector('.stat-card')?.offsetWidth || 0;
                        const gap = 16;
                        statGrid.scrollTo({
                            left: index * (cardWidth + gap),
                            behavior: 'smooth'
                        });
                        currentIndex = index;
                        dots.forEach(d => d.classList.remove('active'));
                        this.classList.add('active');
                    });
                });

                // Touch drag support
                statGrid.addEventListener('touchstart', function (e) {
                    isDragging = true;
                    startX = e.touches[0].pageX - this.offsetLeft;
                    scrollLeft = this.scrollLeft;
                });

                statGrid.addEventListener('touchmove', function (e) {
                    if (!isDragging) return;
                    e.preventDefault();
                    const x = e.touches[0].pageX - this.offsetLeft;
                    const walk = (x - startX) * 1.5;
                    this.scrollLeft = scrollLeft - walk;
                });

                statGrid.addEventListener('touchend', function () {
                    isDragging = false;
                });
            }
        });
    </script>
@endsection
