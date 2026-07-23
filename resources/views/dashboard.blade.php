@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')
    <section class="section premium-dashboard">
        <div class="premium-floating-header">
            <div class="header-content">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div>
                        <span class="header-badge">
                            Overview
                        </span>
                        <h2>Dashboard</h2>
                        <p>Good {{ $timeOfDay ?? 'afternoon' }}, {{ auth()->user()->name ?? 'Admin' }}! Here's what's
                            happening across your campus today.</p>
                    </div>
                </div>
                <div class="premium-head-actions">
                    <span style="font-size: 13px; color: var(--ink-soft); display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-calendar-alt" style="color: var(--ember);"></i>
                        {{ now()->format('l, F j, Y') }}
                    </span>
                </div>
            </div>
        </div>
    </section>
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

                <table class="table table-hover">

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
                                            <span class="badge bg-secondary">Used</span>
                                            @break

                                        @case('Expired')
                                            <span class="badge bg-warning text-dark">Expired</span>
                                            @break

                                        @case('Cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
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

            <div class="mt-4">
                {{ $vouchers->links() }}
            </div>

        </div>
    </div>
</section>

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

    <section class="section premium-dashboard pt-0">
        <!-- Stats Cards - Desktop Grid / Mobile Slider -->
        <div class="stat-grid-container" style="position: relative;">
            <div class="stat-grid" id="statGrid"
                style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 24px; transition: transform 0.3s ease;">
                <div class="stat-card d1"
                    style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius); padding: 20px 24px; box-shadow: var(--shadow); min-width: 200px;">
                    <div class="top" style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div class="icon ember"
                            style="width: 44px; height: 44px; border-radius: 10px; background: var(--ember-soft); color: var(--ember); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>
                    <div class="num"
                        style="font-family: 'Fraunces', serif; font-size: 28px; font-weight: 600; margin: 12px 0 4px;">1,284
                    </div>
                    <div class="lbl" style="font-size: 13px; color: var(--ink-soft);">Enrolled students</div>
                    <div class="delta up" style="font-size: 12px; font-weight: 600; color: var(--sage); margin-top: 4px;">
                        <i class="fas fa-arrow-up"></i> 3.1% this term
                    </div>
                </div>

                <div class="stat-card d2"
                    style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius); padding: 20px 24px; box-shadow: var(--shadow); min-width: 200px;">
                    <div class="top" style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div class="icon sage"
                            style="width: 44px; height: 44px; border-radius: 10px; background: var(--sage-bg); color: var(--sage); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            <i class="fas fa-book-open"></i>
                        </div>
                    </div>
                    <div class="num"
                        style="font-family: 'Fraunces', serif; font-size: 28px; font-weight: 600; margin: 12px 0 4px;">42
                    </div>
                    <div class="lbl" style="font-size: 13px; color: var(--ink-soft);">Active courses</div>
                    <div class="delta up" style="font-size: 12px; font-weight: 600; color: var(--sage); margin-top: 4px;">
                        <i class="fas fa-arrow-up"></i> 2 new this month
                    </div>
                </div>

                <div class="stat-card d3"
                    style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius); padding: 20px 24px; box-shadow: var(--shadow); min-width: 200px;">
                    <div class="top" style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div class="icon rust"
                            style="width: 44px; height: 44px; border-radius: 10px; background: var(--rust-bg); color: var(--rust); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            <i class="fas fa-file-pen"></i>
                        </div>
                    </div>
                    <div class="num"
                        style="font-family: 'Fraunces', serif; font-size: 28px; font-weight: 600; margin: 12px 0 4px;">17
                    </div>
                    <div class="lbl" style="font-size: 13px; color: var(--ink-soft);">Assignments pending review</div>
                    <div class="delta down" style="font-size: 12px; font-weight: 600; color: var(--rust); margin-top: 4px;">
                        <i class="fas fa-arrow-down"></i> 5 fewer than last week
                    </div>
                </div>

                <div class="stat-card d4"
                    style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius); padding: 20px 24px; box-shadow: var(--shadow); min-width: 200px;">
                    <div class="top" style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div class="icon ink"
                            style="width: 44px; height: 44px; border-radius: 10px; background: var(--cloth); color: var(--ink); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            <i class="fas fa-chalkboard-user"></i>
                        </div>
                    </div>
                    <div class="num"
                        style="font-family: 'Fraunces', serif; font-size: 28px; font-weight: 600; margin: 12px 0 4px;">28
                    </div>
                    <div class="lbl" style="font-size: 13px; color: var(--ink-soft);">Instructors</div>
                    <div class="delta up" style="font-size: 12px; font-weight: 600; color: var(--sage); margin-top: 4px;">
                        All active
                    </div>
                </div>
            </div>

            <!-- Slider Navigation (visible on mobile) -->
            <div class="slider-nav" id="sliderNav"
                style="display: none; justify-content: center; gap: 8px; margin-top: 8px; margin-bottom: 20px;">
                <button class="slider-dot active" data-index="0"
                    style="width: 10px; height: 10px; border-radius: 50%; border: 2px solid var(--ember); background: var(--ember); cursor: pointer; padding: 0; transition: all 0.3s ease;"></button>
                <button class="slider-dot" data-index="1"
                    style="width: 10px; height: 10px; border-radius: 50%; border: 2px solid var(--ember); background: transparent; cursor: pointer; padding: 0; transition: all 0.3s ease;"></button>
                <button class="slider-dot" data-index="2"
                    style="width: 10px; height: 10px; border-radius: 50%; border: 2px solid var(--ember); background: transparent; cursor: pointer; padding: 0; transition: all 0.3s ease;"></button>
                <button class="slider-dot" data-index="3"
                    style="width: 10px; height: 10px; border-radius: 50%; border: 2px solid var(--ember); background: transparent; cursor: pointer; padding: 0; transition: all 0.3s ease;"></button>
            </div>
        </div>

        <!-- Recent Enrollments Table -->
        <div class="panel d5"
            style="background: var(--card); border: 1px solid var(--line); border-radius: var(--radius); box-shadow: var(--shadow);">
            <div class="panel-head"
                style="display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; border-bottom: 1px solid var(--line);">
                <h2 style="font-family: 'Fraunces', serif; font-size: 18px; font-weight: 600; margin: 0;">Recent Enrollments
                </h2>
                <a href="#" style="font-size: 13px; color: var(--ember); text-decoration: none; font-weight: 600;">
                    View all <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div style="padding: 0; overflow-x: auto; -webkit-overflow-scrolling: touch;">
                <table class="table"
                    style="width: 100%; border-collapse: collapse; font-size: 13px; margin: 0; min-width: 600px;">
                    <thead>
                        <tr>
                            <th
                                style="text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: .05em; color: var(--ink-soft); font-family: 'IBM Plex Mono', monospace; padding: 14px 20px; border-bottom: 2px solid var(--line); font-weight: 600;">
                                Student</th>
                            <th
                                style="text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: .05em; color: var(--ink-soft); font-family: 'IBM Plex Mono', monospace; padding: 14px 20px; border-bottom: 2px solid var(--line); font-weight: 600;">
                                Course</th>
                            <th
                                style="text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: .05em; color: var(--ink-soft); font-family: 'IBM Plex Mono', monospace; padding: 14px 20px; border-bottom: 2px solid var(--line); font-weight: 600;">
                                Instructor</th>
                            <th
                                style="text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: .05em; color: var(--ink-soft); font-family: 'IBM Plex Mono', monospace; padding: 14px 20px; border-bottom: 2px solid var(--line); font-weight: 600;">
                                Progress</th>
                            <th
                                style="text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: .05em; color: var(--ink-soft); font-family: 'IBM Plex Mono', monospace; padding: 14px 20px; border-bottom: 2px solid var(--line); font-weight: 600;">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 12px 20px; border-bottom: 1px solid var(--line); white-space: nowrap;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div
                                        style="width: 28px; height: 28px; border-radius: 50%; background: var(--gold-gradient); display: flex; align-items: center; justify-content: center; color: #1A1410; font-weight: 700; font-size: 11px; box-shadow: var(--gold-glow); flex-shrink: 0;">
                                        A</div>
                                    Aisha Kapoor
                                </div>
                            </td>
                            <td style="padding: 12px 20px; border-bottom: 1px solid var(--line); white-space: nowrap;">Data
                                Structures 101</td>
                            <td style="padding: 12px 20px; border-bottom: 1px solid var(--line); white-space: nowrap;">Dr.
                                Rao</td>
                            <td
                                style="padding: 12px 20px; border-bottom: 1px solid var(--line); font-weight: 600; color: var(--sage); white-space: nowrap;">
                                82%</td>
                            <td style="padding: 12px 20px; border-bottom: 1px solid var(--line); white-space: nowrap;">
                                <span class="status-pill done"
                                    style="display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 600; padding: 4px 14px; border-radius: 99px; background: var(--sage-bg); color: var(--sage); font-family: 'IBM Plex Mono', monospace; text-transform: uppercase; letter-spacing: .03em; white-space: nowrap;">
                                    <i class="fas fa-circle-check"></i> Active
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 20px; border-bottom: 1px solid var(--line); white-space: nowrap;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div
                                        style="width: 28px; height: 28px; border-radius: 50%; background: var(--gold-gradient); display: flex; align-items: center; justify-content: center; color: #1A1410; font-weight: 700; font-size: 11px; box-shadow: var(--gold-glow); flex-shrink: 0;">
                                        R</div>
                                    Rohan Mehta
                                </div>
                            </td>
                            <td style="padding: 12px 20px; border-bottom: 1px solid var(--line); white-space: nowrap;">
                                Linear Algebra</td>
                            <td style="padding: 12px 20px; border-bottom: 1px solid var(--line); white-space: nowrap;">Prof.
                                Iyer</td>
                            <td
                                style="padding: 12px 20px; border-bottom: 1px solid var(--line); font-weight: 600; color: var(--ember); white-space: nowrap;">
                                34%</td>
                            <td style="padding: 12px 20px; border-bottom: 1px solid var(--line); white-space: nowrap;">
                                <span class="status-pill pending"
                                    style="display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 600; padding: 4px 14px; border-radius: 99px; background: var(--ember-soft); color: var(--ember-dark); font-family: 'IBM Plex Mono', monospace; text-transform: uppercase; letter-spacing: .03em; white-space: nowrap;">
                                    <i class="fas fa-clock"></i> In Progress
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 20px; border-bottom: 1px solid var(--line); white-space: nowrap;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div
                                        style="width: 28px; height: 28px; border-radius: 50%; background: var(--gold-gradient); display: flex; align-items: center; justify-content: center; color: #1A1410; font-weight: 700; font-size: 11px; box-shadow: var(--gold-glow); flex-shrink: 0;">
                                        S</div>
                                    Sara Iqbal
                                </div>
                            </td>
                            <td style="padding: 12px 20px; border-bottom: 1px solid var(--line); white-space: nowrap;">World
                                History</td>
                            <td style="padding: 12px 20px; border-bottom: 1px solid var(--line); white-space: nowrap;">Dr.
                                Nair</td>
                            <td
                                style="padding: 12px 20px; border-bottom: 1px solid var(--line); font-weight: 600; color: var(--sage); white-space: nowrap;">
                                100%</td>
                            <td style="padding: 12px 20px; border-bottom: 1px solid var(--line); white-space: nowrap;">
                                <span class="status-pill done"
                                    style="display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 600; padding: 4px 14px; border-radius: 99px; background: var(--sage-bg); color: var(--sage); font-family: 'IBM Plex Mono', monospace; text-transform: uppercase; letter-spacing: .03em; white-space: nowrap;">
                                    <i class="fas fa-circle-check"></i> Completed
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 20px; border-bottom: 1px solid var(--line); white-space: nowrap;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div
                                        style="width: 28px; height: 28px; border-radius: 50%; background: var(--gold-gradient); display: flex; align-items: center; justify-content: center; color: #1A1410; font-weight: 700; font-size: 11px; box-shadow: var(--gold-glow); flex-shrink: 0;">
                                        K</div>
                                    Kunal Shah
                                </div>
                            </td>
                            <td style="padding: 12px 20px; border-bottom: 1px solid var(--line); white-space: nowrap;">
                                Organic Chemistry</td>
                            <td style="padding: 12px 20px; border-bottom: 1px solid var(--line); white-space: nowrap;">Dr.
                                Rao</td>
                            <td
                                style="padding: 12px 20px; border-bottom: 1px solid var(--line); font-weight: 600; color: var(--rust); white-space: nowrap;">
                                0%</td>
                            <td style="padding: 12px 20px; border-bottom: 1px solid var(--line); white-space: nowrap;">
                                <span class="status-pill failed"
                                    style="display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 600; padding: 4px 14px; border-radius: 99px; background: var(--rust-bg); color: var(--rust); font-family: 'IBM Plex Mono', monospace; text-transform: uppercase; letter-spacing: .03em; white-space: nowrap;">
                                    <i class="fas fa-circle-xmark"></i> Withdrawn
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
