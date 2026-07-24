@extends('layouts.app')

@section('content')

    <!-- Premium Header -->
    <section class="section premium-dashboard">
        <div class="premium-header">
            <div class="premium-header-overlay"></div>

            <div class="premium-header-left">
                <div class="premium-header-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="premium-header-content">
                    <span class="premium-tag">Analytics & Reports</span>
                    <h1 class="text-white">Reports Dashboard</h1>
                    <p>Lead, Candidate & Voucher Analytics</p>
                </div>
            </div>

            <div class="premium-header-right">
                <a href="{{ route('dashboard.export.leads') }}" class="premium-back-btn me-3">
                    <i class="fas fa-file-excel"></i>
                    Download Leads
                </a>
                <a href="{{ route('dashboard.export.vouchers') }}" class="premium-back-btn">
                    <i class="fas fa-file-excel"></i>
                    Download Vouchers
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

        <div class="row g-4">

            <!-- Total Leads -->
            <div class="col-xl-3 col-md-6">
                <div class="card premium-block border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted">Total Leads</small>
                                <h2 class="fw-bold mt-2">{{ number_format($report['total_leads']) }}</h2>
                                <small class="text-primary">
                                    <i class="fas fa-users"></i> All Leads
                                </small>
                            </div>
                            <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                                 style="width:60px;height:60px;">
                                <i class="fas fa-users fa-xl text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Candidates -->
            <div class="col-xl-3 col-md-6">
                <div class="card premium-block border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted">Candidates</small>
                                <h2 class="fw-bold mt-2">{{ number_format($report['total_candidates']) }}</h2>
                                <small class="text-success">
                                    <i class="fas fa-user-graduate"></i> Enrolled
                                </small>
                            </div>
                            <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                                 style="width:60px;height:60px;">
                                <i class="fas fa-user-graduate fa-xl text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Converted Leads -->
            <div class="col-xl-3 col-md-6">
                <div class="card premium-block border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted">Converted Leads</small>
                                <h2 class="fw-bold mt-2">{{ number_format($report['converted_leads']) }}</h2>
                                <small class="text-success">
                                    <i class="fas fa-check-circle"></i> Successful
                                </small>
                            </div>
                            <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                                 style="width:60px;height:60px;">
                                <i class="fas fa-check-circle fa-xl text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Vouchers -->
            <div class="col-xl-3 col-md-6">
                <div class="card premium-block border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <small class="text-muted">Total Vouchers</small>
                                <h2 class="fw-bold mt-2">{{ number_format($report['total_vouchers']) }}</h2>
                                <small class="text-warning">
                                    <i class="fas fa-ticket-alt"></i> Generated
                                </small>
                            </div>
                            <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center"
                                 style="width:60px;height:60px;">
                                <i class="fas fa-ticket-alt fa-xl text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Voucher Status Cards -->
        <div class="row mt-4 g-4">
            <div class="col-lg-4">
                <div class="card premium-block text-center">
                    <div class="card-body">
                        <i class="fas fa-ticket-alt text-success fa-3x mb-3"></i>
                        <h3 class="fw-bold">{{ $report['available_vouchers'] }}</h3>
                        <div class="text-muted">Available Vouchers</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card premium-block text-center">
                    <div class="card-body">
                        <i class="fas fa-check-circle text-primary fa-3x mb-3"></i>
                        <h3 class="fw-bold">{{ $report['used_vouchers'] }}</h3>
                        <div class="text-muted">Used Vouchers</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card premium-block text-center">
                    <div class="card-body">
                        <i class="fas fa-times-circle text-danger fa-3x mb-3"></i>
                        <h3 class="fw-bold">{{ $report['expired_vouchers'] }}</h3>
                        <div class="text-muted">Expired Vouchers</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Executive Performance -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card premium-block">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-users text-warning me-2"></i>
                            Executive Performance
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Executive</th>
                                        <th class="text-center">Assigned Leads</th>
                                        <th class="text-center">Converted</th>
                                        <th class="text-center">Candidates</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($executives as $executive)
                                        <tr>
                                            <td><strong>{{ $executive['name'] }}</strong></td>
                                            <td class="text-center">
                                                <span class="badge bg-primary">{{ $executive['total_leads'] }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success">{{ $executive['converted'] }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info">{{ $executive['candidates'] }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">No executive data found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Summary + Recent Enrollments -->
        <div class="row mt-4 g-4">
            <div class="col-lg-6">
                <div class="card premium-block h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-alt text-warning me-2"></i>
                            Monthly Summary
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Month</th>
                                        <th class="text-center">Leads</th>
                                        <th class="text-center">Candidates</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($monthlyReport as $month)
                                        <tr>
                                            <td>{{ $month['month'] }}</td>
                                            <td class="text-center"><span class="badge bg-primary">{{ $month['leads'] }}</span></td>
                                            <td class="text-center"><span class="badge bg-success">{{ $month['candidates'] }}</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-5">No monthly data available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Candidates -->
            <div class="col-lg-6">
                <div class="card premium-block h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-user-graduate text-warning me-2"></i>
                            Recent Enrollments
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Candidate</th>
                                        <th>Course</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentCandidates as $candidate)
                                        <tr>
                                            <td>{{ $candidate->first_name }} {{ $candidate->last_name }}</td>
                                            <td>{{ $candidate->course->course_name ?? '-' }}</td>
                                            <td>{{ $candidate->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-5">No recent enrollments found.</td>
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

@endsection
