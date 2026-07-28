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
                    </div>
                </div>
            </div>
        </div>
    </section>
{{-- Other users --}}
 

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
        <!-- Scheduled Exams -->
        <div class="col-xl-3 col-lg-6 col-md-6">
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
        </div>
          
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
        <div class="profile-section-title d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="title-icon">
                    <i class="fas fa-address-card"></i>
                </div>
                <div class="ms-3">
                    <h4 class="mb-1">All Vouchers</h4>
                    <p class="text-white mb-0">Voucher Management</p>
                </div>
            </div>
            <div class="voucher-count">
                <span class="count-label">Total Vouchers</span>
                <h3>{{ number_format($vouchers->total()) }}</h3>
            </div>
        </div>
        <div class="card-body">           
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
                <div class="profile-section-title d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="title-icon">
                     <i class="fas fa-calendar-day text-white me-2"></i>
                </div>
                <div class="ms-3">
                    <h4 class="mb-1"> Today's Lead Updates</h4>
                    <p class="text-white mb-0">  All follow-ups scheduled for today • Updated in real-time</p>
                </div>
            </div>
            <div class="voucher-count">
                 <span class="badge bg-white text-dark px-3 py-2">TODAY</span>
            </div>
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
