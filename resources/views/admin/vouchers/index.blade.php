@can('vouchers.index')
    @extends('layouts.app')
    @section('content')
        <section class="section premium-dashboard">
            <div class="premium-header">
                <div class="premium-header-overlay"></div>
                <div class="premium-header-left">
                    <div class="premium-header-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="premium-header-content">
                        <span class="premium-tag"> VOUCHER MANAGEMENT</span>
                        <h2 class="text-white">Vouchers</h2>
                        <p>Manage all vouchers</p>
                    </div>
                </div>
                <div class="premium-header-right">
                    <button type="button" class="premium-back-btn text-danger" data-bs-toggle="modal"
                        data-bs-target="#bulkUploadModal">
                        <i class="fas fa-file-excel"></i> Bulk Upload
                    </button>
                    <a href="{{ route('vouchers.create') }}" class="premium-back-btn text-success">
                        <i class="fas fa-plus-circle"></i> Add Voucher
                    </a>
                    <a href="{{ asset('samples/voucher_sample.xlsx') }}" class="premium-back-btn text-primary" download>
                        <i class="fas fa-download"></i> Download Sample Excel
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

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {!! session('success') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {!! session('error') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card premium-block">

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle" id="datatable">

                            <thead>

                                <tr>

                                    <th width="60">#</th>
                                    <th>Course Category</th>
                                    <th>Course Name</th>
                                    <th>Voucher Code</th>
                                    <th>Vendor</th>
                                    <th>Purchase Date</th>
                                    <th>Expiry Date</th>
                                    <th>Purchase Price</th>
                                    <th>Cost</th>
                                    <th>Voucher Status</th>
                                    <th>Created By</th>
                                    <th>Update By</th>
                                    @can('vouchers.edit')
                                        <th width="180" class="text-center">Action</th>
                                    @endcan

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($vouchers as $key => $voucher)

                                    <tr>

                                        <td>{{ $vouchers->firstItem() + $key }}</td>
                                        <td>{{ $voucher->courseCategory->name ?? '-' }}</td>
                                        <td>{{ $voucher->course->course_name ?? '-' }}</td>

                                        @php
                                            $canViewVoucher = in_array(auth()->user()->role_id, [1, 2, 3]);
                                        @endphp

                                        <td>
                                            @if($canViewVoucher)
                                                <span class="voucher-code-display" style="cursor:pointer"
                                                    onclick="toggleVoucherCode(this)">
                                                    <span class="voucher-code-hidden">*******</span>
                                                    <span class="voucher-code-visible" style="display:none;">
                                                        {{ $voucher->voucher_code }}
                                                    </span>
                                                    <i class="fas fa-eye voucher-eye-icon ms-1 text-secondary"></i>
                                                </span>
                                            @else
                                                <span class="text-muted">
                                                    *******
                                                </span>
                                            @endif
                                        </td>

                                        <td>{{ $voucher->vendor->vendor_name ?? '-' }}</td>

                                        <td>
                                            {{ $voucher->purchase_date ? \Carbon\Carbon::parse($voucher->purchase_date)->format('d M Y') : '-' }}
                                        </td>

                                        <td>
                                            {{ $voucher->expiry_date ? \Carbon\Carbon::parse($voucher->expiry_date)->format('d M Y') : '-' }}
                                        </td>

                                        <td>
                                            ₹{{ number_format($voucher->purchase_price, 2) }}
                                        </td>

                                        <td>
                                            ₹{{ number_format($voucher->cost, 2) }}
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = match ($voucher->status) {
                                                    'Available' => 'success',
                                                    'Allocated' => 'primary',
                                                    'Used' => 'danger',
                                                    'Expired' => 'warning',
                                                    'Cancelled' => 'info',
                                                    default => 'light',
                                                };
                                            @endphp

                                            <span class="badge bg-{{ $badgeClass }}">
                                                {{ $voucher->status }}
                                            </span>
                                        </td>
                                        <td>{{ $voucher->creator->name ?? '-' }}</td>
                                        <td>{{ $voucher->updater->name ?? '-' }}</td>
                                        @can('vouchers.edit')
                                            <td class="text-center">

                                                <a href="{{ route('vouchers.edit', $voucher->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST"
                                                    class="d-inline">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this voucher?')">

                                                        <i class="fas fa-trash"></i>

                                                    </button>

                                                </form>

                                            </td>
                                        @endcan

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="10" class="text-center py-4">
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
        <!-- Bulk Upload Modal -->
        <div class="modal fade" id="bulkUploadModal" tabindex="-1" aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <form action="{{ route('vouchers.bulk-upload') }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        <div class="modal-header">

                            <h5 class="modal-title">
                                <i class="fas fa-file-excel text-success"></i>
                                Bulk Upload Vouchers
                            </h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                        </div>

                        <div class="modal-body">

                            <div class="mb-3">

                                <label class="form-label">
                                    Select Excel / CSV File
                                </label>

                                <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>

                            </div>

                            <div class="alert alert-info mb-0">
                                <strong>Required Columns:</strong><br>

                                voucher_code,
                                vendor_name,
                                purchase_date,
                                expiry_date,
                                purchase_price,
                                cost
                            </div>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Cancel
                            </button>

                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-upload"></i>
                                Upload
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    @endsection
@else
    @php
        abort(403);
    @endphp
@endcan
