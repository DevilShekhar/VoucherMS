@extends('layouts.app')
@section('page-title', 'Dashboard')
@section('content')
    <section class="dashboard-banner">
        <div class="dashboard-card">
            <!-- Background Decoration -->
            <div class="banner-shape"></div>
            <div class="row align-items-center">
                <!-- Left Content -->
                <div class="col-lg-7">
                    <div class="d-flex align-items-start">
                        <div class="dashboard-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div class="ms-4">
                            <span class="overview-badge">
                                OVERVIEW
                            </span>
                            <h1 class="dashboard-title">
                                Dashboard
                            </h1>
                            <div class="title-line"></div>
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
                            <p class="welcome-text">
                                Welcome back!
                                Good {{ $timeOfDay }},
                                <strong>{{ Auth::user()->name }}</strong>.
                                <br>
                                <small>
                                    We hope you're having a productive day.
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Right Side -->
                <div class="col-lg-5">
                    <div class="dashboard-actions">
                        <!-- Date -->
                        <div class="date-box">
                            <i class="far fa-calendar-alt"></i>
                            {{ now()->format('l, F d, Y') }}
                        </div>
                        <!-- Buttons -->
                        @can('download-excel')
                        <div class="action-buttons">
                            <a href="{{ route('dashboard.export.leads') }}"
                            class="btn-download btn-green">
                                <i class="fas fa-file-excel"></i>
                                Download Leads
                            </a>
                            <a href="{{ route('dashboard.export.vouchers') }}"
                            class="btn-download btn-blue">
                                <i class="fas fa-file-excel"></i>
                                Download Vouchers
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-4">
        <div class="card border-0 shadow-lg rounded-4 report-filter-card">
            <div class="card-header-reports border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center">
                        <div class="filter-icon">
                            <i class="fas fa-filter"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-0 text-white">Lead Report</h4>
                            <small class="text-white-50">
                                Filter leads and export professional Excel reports
                            </small>
                        </div>
                    </div>
                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                        <i class="fas fa-file-excel text-success me-1"></i>
                        Excel Export
                    </span>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('dashboard.export.leads.filter') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-calendar-alt text-primary me-1"></i>
                                From Date
                            </label>
                            <input type="date"
                                name="from_date"
                                value="{{ request('from_date') }}"
                                class="form-control filter-input">
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-calendar-check text-success me-1"></i>
                                To Date
                            </label>
                            <input type="date"
                                name="to_date"
                                value="{{ request('to_date') }}"
                                class="form-control filter-input">
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                Location
                            </label>
                            <select name="location_id" class="form-select filter-input">
                                <option value="">All Locations</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}"
                                        {{ request('location_id') == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-flag text-warning me-1"></i>
                                Status
                            </label>
                            <select name="status" class="form-select filter-input">
                                <option value="">All Status</option>
                                @foreach(['New','Contacted','Interested','Not Interested','Converted','Closed'] as $status)
                                    <option value="{{ $status }}"
                                        {{ request('status')==$status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-user-tie text-info me-1"></i>
                                Sales Executive
                            </label>
                            <select name="executive_id" class="form-select filter-input">
                                <option value="">All Executives</option>
                                @foreach($executives as $executive)
                                    <option value="{{ $executive->id }}"
                                        {{ request('executive_id')==$executive->id ? 'selected' : '' }}>
                                        {{ $executive->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 d-flex align-items-end">
                            <div class="d-grid w-100">
                                <button type="submit" class="btn btn-success btn-md export-btn">
                                    <i class="fas fa-file-excel me-2"></i>
                                    Export Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="mb-4">
    <div class="card border-0 shadow-lg rounded-4 report-filter-card">

        <div class="card-header-voucher-report border-0 py-3 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <div class="d-flex align-items-center">

                    <div class="filter-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>

                    <div class="ms-3">
                        <h4 class="mb-0 text-white">
                            Voucher Report
                        </h4>

                        <small class="text-white">
                            Filter vouchers and export professional Excel reports
                        </small>
                    </div>

                </div>

                <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                    <i class="fas fa-file-excel text-success me-1"></i>
                    Excel Export
                </span>

            </div>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('dashboard.export.vouchers.filter') }}" method="GET">

                <div class="row g-3">

                    <div class="col-lg-3 col-md-6">

                        <label class="form-label fw-semibold">
                            <i class="fas fa-calendar-alt text-primary me-1"></i>
                            From Date
                        </label>

                        <input type="date"
                               name="from_date"
                               value="{{ request('from_date') }}"
                               class="form-control filter-input">

                    </div>

                    <div class="col-lg-3 col-md-6">

                        <label class="form-label fw-semibold">
                            <i class="fas fa-calendar-check text-success me-1"></i>
                            To Date
                        </label>

                        <input type="date"
                               name="to_date"
                               value="{{ request('to_date') }}"
                               class="form-control filter-input">

                    </div>

                    <div class="col-lg-3 col-md-6">

                        <label class="form-label fw-semibold">
                            <i class="fas fa-building text-warning me-1"></i>
                            Vendor
                        </label>

                        <select name="vendor_id" class="form-select filter-input">

                            <option value="">All Vendors</option>

                            @foreach($vendors as $vendor)

                                <option value="{{ $vendor->id }}"
                                    {{ request('vendor_id') == $vendor->id ? 'selected' : '' }}>

                                    {{ $vendor->vendor_name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-lg-3 col-md-6">

                        <label class="form-label fw-semibold">
                            <i class="fas fa-layer-group text-danger me-1"></i>
                            Status
                        </label>

                        <select name="status" class="form-select filter-input">

                            <option value="">All Status</option>

                            @foreach(['Available','Allocated','Used','Expired','Cancelled'] as $status)

                                <option value="{{ $status }}"
                                    {{ request('status') == $status ? 'selected' : '' }}>

                                    {{ $status }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-12 mt-4">

                        <div class="d-flex justify-content-end gap-2">

                            <a href="{{ route('dashboard') }}"
                               class="btn btn-outline-secondary px-4">

                                <i class="fas fa-rotate-left me-2"></i>

                                Reset

                            </a>

                            <button type="submit"
                                    class="btn btn-success export-btn px-4">

                                <i class="fas fa-file-excel me-2"></i>

                                Export Voucher Excel

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>
</section>
{{-- Other users --}}

@can('student-data')
<section class="dashboard-stats">
    <div class="row g-4">
        <!-- Enrolled Students -->
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="premium-stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-top">
                        <h2>{{ number_format($totalStudents) }}</h2>
                        <span class="trend up">
                            <i class="fas fa-users"></i>
                            Students
                        </span>
                    </div>
                    <h5>Enrolled Students</h5>
                    <p>Total registered students.</p>
                </div>
            </div>
        </div>
        <!-- Active Courses -->
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="premium-stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-top">
                        <h2>{{ number_format($activeCourses) }}</h2>
                        <span class="trend success">
                            <i class="fas fa-check-circle"></i>
                            Active
                        </span>
                    </div>
                    <h5>Active Courses</h5>
                    <p>Available courses.</p>
                </div>
            </div>
        </div>
        <!-- Pending Leads -->
        <div class="col-xl-3 col-lg-6 col-md-6">
            <div class="premium-stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-file-signature"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-top">
                        <h2>{{ number_format($pendingLeads) }}</h2>
                        <span class="trend warning">
                            <i class="fas fa-clock"></i>
                            Pending
                        </span>
                    </div>
                    <h5>Pending Leads</h5>
                    <p>Waiting for follow-up.</p>
                </div>
            </div>
        </div>
        @endcan

        @can('scheduledexams')
        <!-- Scheduled Exams -->
        <div class="col-xl-3 col-lg-6 col-md-6">
            <a href="{{ route('exam-schedules.index') }}" class="text-decoration-none">
                <div class="premium-stat-card">
                    <div class="stat-icon purple">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-top">
                            <h2>{{ number_format($scheduledExams) }}</h2>
                            <span class="trend success">
                                <i class="fas fa-calendar"></i>
                                Scheduled
                            </span>
                        </div>

                        <h5>Scheduled Exams</h5>
                        <p>Upcoming exams.</p>
                    </div>
                </div>
            </a>
        </div>
        @endcan
    </div>
</section>
@can('view-voucher-earning')
<section>
    <div class="row g-4">
            <!-- Voucher Purchase -->
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="premium-stat-card">
                <div class="stat-icon red">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-top">
                        <h2>₹{{ number_format($totalVoucherPurchase,2) }}</h2>
                        <span class="trend danger">
                            <i class="fas fa-money-bill-wave"></i>
                            Purchase
                        </span>
                    </div>
                    <h5>Voucher Purchase</h5>
                    <p>Total voucher purchase amount.</p>
                </div>
            </div>
        </div>
        <!-- Selling Amount -->
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="premium-stat-card">
                <div class="stat-icon teal">
                    <i class="fa-solid fa-indian-rupee-sign"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-top">
                        <h2>₹{{ number_format($totalSellingAmount,2) }}</h2>
                        <span class="trend teal">
                            <i class="fas fa-arrow-up"></i>
                            Sales
                        </span>
                    </div>
                    <h5>Total Selling</h5>
                    <p>Total paid amount received.</p>
                </div>
            </div>
        </div>
        <!-- Total Earnings -->
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="premium-stat-card">
                <div class="stat-icon success bg-success">
               <i class="fas fa-rupee-sign"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-top ">
                        <h2>₹{{ number_format($totalEarning, 2) }}</h2>
                        <span class="trend success ">
                            <i class="fas fa-coins"></i>
                            Earnings
                        </span>
                    </div>
                    <h5>Total Earnings</h5>
                    <p>Total profit (Selling Amount − Voucher Purchase).</p>
                </div>
            </div>
        </div>
    <div>
</section>
@endcan

@can('view-voucher')
<section class="section premium-dashboard pt-0">
    <div class="card premium-block">

        {{-- Header --}}
        <div class="profile-section-title d-flex flex-wrap justify-content-between align-items-center gap-3">

            {{-- Left Side --}}
            <div class="d-flex align-items-center">
                <div class="title-icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div class="ms-3">
                    <h4 class="mb-1 text-white">All Vouchers</h4>
                    <p class="text-white-50 mb-0">Voucher Management</p>
                </div>
            </div>

            {{-- Right Side - All Counts --}}
            <div class="d-flex flex-wrap align-items-center gap-3 text-white">
                <div class="text-center">
                    <small class="d-block text-white-50">Available</small>
                    <strong class="fs-5">{{ $availableCount }}</strong>
                </div>
                <div class="text-center">
                    <small class="d-block text-white-50">Allocated</small>
                    <strong class="fs-5">{{ $allocatedCount }}</strong>
                </div>
                <div class="text-center">
                    <small class="d-block text-white-50">Used</small>
                    <strong class="fs-5">{{ $usedCount }}</strong>
                </div>
                <div class="text-center">
                    <small class="d-block text-white-50">Expired</small>
                    <strong class="fs-5">{{ $expiredCount }}</strong>
                </div>
                <div class="text-center">
                    <small class="d-block text-white-50">Cancelled</small>
                    <strong class="fs-5">{{ $cancelledCount }}</strong>
                </div>
                <div class="text-center border-start border-light ps-3">
                    <small class="d-block text-white-50">Total Vouchers</small>
                    <strong class="fs-5">{{ number_format($vouchers->total()) }}</strong>
                </div>
            </div>

        </div>

        <div class="card-body">

            {{-- Table --}}
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
                                <td>{{ $voucher->vendor->vendor_name ?? '-' }}</td>
                                <td>
                                    <span class="voucher-code-display" style="cursor: pointer;"
                                          onclick="toggleVoucherCode(this)">
                                        <span class="voucher-code-hidden">••••••••</span>
                                        <span class="voucher-code-visible" style="display: none;">
                                            {{ $voucher->voucher_code }}
                                        </span>
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
                                            <small class="text-warning fw-bold">
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
                                            <span class="badge bg-warning text-dark">Expired</span>
                                            @break
                                        @case('Cancelled')
                                            <span class="badge bg-info">Cancelled</span>
                                            @break
                                        @default
                                            <span class="badge bg-light text-dark">{{ $voucher->status }}</span>
                                    @endswitch
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">No vouchers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</section>
@endcan

<section class="mb-4">
    <div class="card border-0 shadow-lg rounded-4 report-filter-card">

        <div class="card-header-voucher border-0 py-3 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <div class="d-flex align-items-center">
                    <div class="filter-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>

                    <div class="ms-3">
                        <h4 class="mb-0 text-white">
                            Exam Schedule Report
                        </h4>

                        <small class="text-white ">
                            Filter exam schedules and view records instantly
                        </small>
                    </div>
                </div>

                <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                    <i class="fas fa-search text-primary me-1"></i>
                    Live Filter
                </span>

            </div>
        </div>

        <div class="card-body p-4">

            <div class="row g-3">

                <!-- From Date -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-calendar-alt text-primary me-1"></i>
                        From Date
                    </label>

                    <input type="date"
                           id="from_date"
                           class="form-control filter-input">
                </div>

                <!-- To Date -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-calendar-check text-success me-1"></i>
                        To Date
                    </label>

                    <input type="date"
                           id="to_date"
                           class="form-control filter-input">
                </div>

                <!-- Exam Mode -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-laptop-house text-info me-1"></i>
                        Exam Mode
                    </label>

                    <select id="exam_mode"
                            class="form-select filter-input">

                        <option value="">All Modes</option>
                        <option value="center">Center</option>
                        <option value="online">Online</option>

                    </select>
                </div>

                <!-- Center -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-building text-warning me-1"></i>
                        Center
                    </label>

                    <select id="center_id"
                            class="form-select filter-input">

                        <option value="">All Centers</option>

                        @foreach($centers as $center)
                            <option value="{{ $center->id }}">
                                {{ $center->center_name }}
                            </option>
                        @endforeach

                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">
                        Course Category
                    </label>

                    <select name="course_category_id" id="course_category_id" class="form-select filter-input">
                        <option value="">Select Category</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">
                        Course
                    </label>

                    <select name="course_id" id="course_id" class="form-select filter-input">
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

                <!-- Filter Button -->
                <div class="col-lg-2 d-flex align-items-end">

                    <div class="d-grid w-100">

                        <button type="button"
                                id="filterBtn"
                                class="btn btn-success btn-md export-btn">

                            <i class="fas fa-search me-2"></i>
                            Filter

                        </button>

                    </div>

                </div>

            </div>

            <hr class="my-4">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr>
                            <th width="5%">#</th>
                            <th>Candidate</th>
                            <th>Course Category</th>
                            <th>Course</th>
                            <th>Exam Mode</th>
                            <th>Center</th>
                            <th>Exam Date</th>
                            <th>Exam Time</th>
                            <th>Status</th>
                        </tr>

                    </thead>

                    <tbody id="scheduleTable">

                        <tr>

                            <td colspan="7" class="text-center py-5">

                                <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>

                                <br>

                                <strong class="text-muted">
                                    Select filters and click Filter
                                </strong>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</section>

@can('lead-card')
<section class="section premium-dashboard pt-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="card premium-block">
                <div class="profile-section-title d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="title-icon">
                            <i class="fas fa-calendar-day text-white me-2"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-1"> Today's Lead Updates</h4>
                            <p class="text-white mb-0">All follow-ups scheduled for today • Updated in real-time</p>
                        </div>
                    </div>
                    <div class="voucher-count">
                        <span class="badge bg-white text-dark px-3 py-2">TODAY</span>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="card-header bg-white">
                        <form method="POST" action="{{ route('dashboard') }}">
                            @csrf
                            <div class="row align-items-end">

                                @can('locations.index')
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Location</label>
                                    <select name="location_id" class="form-select">
                                        <option value="">All Locations</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}"
                                                {{ old('location_id', request('location_id')) == $location->id ? 'selected' : '' }}>
                                                {{ $location->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endcan

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">From Date</label>
                                    <input type="date"
                                           name="from_date"
                                           class="form-control"
                                           value="{{ old('from_date', request('from_date')) }}">
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">To Date</label>
                                    <input type="date"
                                           name="to_date"
                                           class="form-control"
                                           value="{{ old('to_date', request('to_date')) }}">
                                </div>

                                <div class="col-md-3 mb-3 d-flex gap-2">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-filter me-1"></i>
                                        Filter
                                    </button>

                                    <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100">
                                        <i class="fas fa-undo me-1"></i>
                                        Reset
                                    </a>
                                </div>

                            </div>
                        </form>
                    </div>

                    <div class="table-responsive" style="max-height: 320px; overflow-y: auto;">
                        <table class="table table-hover mb-0" id="datatable">
                            <thead class="table-light bg-white">
                                <tr>
                                    <th>Lead No</th>
                                    <th>Candidate Name</th>
                                    <th>Mobile</th>
                                    <th>Executive</th>
                                    <th>Course Category</th>
                                    <th>Course</th>
                                    <th>Today's Follow-up</th>
                                    <th>Status</th>
                                    <th>Next Follow-up</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($todayLeads->groupBy('lead_id') as $leadId => $followups)
                                    @php
                                        $item = $followups->sortByDesc('followup_date')->first();
                                    @endphp

                                    <tr style="cursor:pointer"
                                        onclick="window.location='{{ route('leads.index', ['lead_no' => $item->lead->lead_no]) }}'">

                                        <td>
                                            <strong>{{ $item->lead->lead_no }}</strong>
                                            @if($followups->count() > 1)
                                                <br>
                                                <small class="badge bg-primary">
                                                    {{ $followups->count() }} Updates
                                                </small>
                                            @endif
                                        </td>
                                        <td>{{ $item->lead->candidate_name }}</td>
                                        <td>{{ $item->lead->mobile }}</td>
                                        <td>{{ $item->lead->assignedUser->name ?? '-' }}</td>
                                        <td>{{ $item->lead->course?->category?->name ?? '-' }}</td>
                                        <td>{{ $item->lead->course->course_name ?? '-' }}</td>
                                        <td class="text-primary">
                                            <strong>
                                                {{ \Carbon\Carbon::parse($item->followup_date)->format('d M Y h:i A') }}
                                            </strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $item->status }}
                                            </span>
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
                                        <td colspan="9" class="text-center py-5">
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
@endcan
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
    <script>
        function loadExamSchedules() {
            $.ajax({
                url: "{{ route('dashboard.exam.schedule.filter') }}",
                type: "GET",
                data: {
                    from_date: $('#from_date').val(),
                    to_date: $('#to_date').val(),
                    exam_mode: $('#exam_mode').val(),
                    center_id: $('#center_id').val(),
                    course_category_id: $('#course_category_id').val(),
                    course_id: $('#course_id').val()
                },
                success: function(response) {

                    let html = "";

                    if(response.length == 0){
                        html = `
                            <tr>
                                <td colspan="9" class="text-center">
                                    No Records Found
                                </td>
                            </tr>`;
                    }else{

                        $.each(response,function(index,row){

                            html += `
                            <tr>
                                <td>${index+1}</td>

                                <td>
                                    ${row.candidate ? row.candidate.first_name + ' ' + (row.candidate.last_name ?? '') : '-'}
                                </td>

                                <td>${row.candidate?.course?.category?.name ?? '-'}</td>

                                <td>${row.candidate?.course?.course_name ?? '-'}</td>

                                <td>${row.exam_mode}</td>

                                <td>${row.center ? row.center.center_name : '-'}</td>

                                <td>${row.exam_date}</td>

                                <td>${row.exam_time}</td>

                                <td>${row.exam_status}</td>
                            </tr>`;
                        });
                    }

                    $('#scheduleTable').html(html);
                }
            });
        }

        $(document).ready(function () {

            loadExamSchedules();

            $('#filterBtn').click(function (e) {
                e.preventDefault();
                loadExamSchedules();
            });

            $('#from_date,#to_date,#exam_mode,#center_id').change(function () {
                loadExamSchedules();
            });
            $('#course_category_id').on('change', function () {
                loadExamSchedules();
            });

            $('#course_id').on('change', function () {
                loadExamSchedules();
            });

        });

    </script>
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
