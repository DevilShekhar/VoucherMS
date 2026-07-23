@extends('layouts.app')

@section('content')

    <section class="section premium-dashboard">

        <div class="premium-floating-header">

            <div class="header-content">

                <div class="header-left">

                    <div class="header-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>

                    <div>

                        <span class="header-badge">
                            Voucher Management
                        </span>

                        <h2>Vouchers</h2>

                        <p>Manage all vouchers</p>

                    </div>

                </div>

                <div class="premium-head-actions">

                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                        data-bs-target="#bulkUploadModal">
                        <i class="fas fa-file-excel"></i>
                        Bulk Upload
                    </button>

                    <a href="{{ route('vouchers.create') }}" class="btn btn-outline-success">
                        <i class="fas fa-plus-circle"></i>
                        Add Voucher
                    </a>
                    <a href="{{ asset('samples/voucher_sample.xlsx') }}" class="btn btn-outline-primary" download>
                        <i class="fas fa-download"></i>
                        Download Sample Excel
                    </a>

                </div>

            </div>

        </div>

    </section>

    <section class="section premium-dashboard pt-0">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {!! session('success') !!}
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
                                <th>Voucher Code</th>
                                <th>Vendor</th>
                                <th>Purchase Date</th>
                                <th>Expiry Date</th>
                                <th>Purchase Price</th>
                                <th>Cost</th>
                                <th width="180" class="text-center">Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($vouchers as $key => $voucher)

                                <tr>

                                    <td>{{ $vouchers->firstItem() + $key }}</td>

                                    <td>
                                        <span class="voucher-code-display" style="cursor: pointer;"
                                            onclick="toggleVoucherCode(this)">
                                            <span class="voucher-code-hidden">*******</span>
                                            <span class="voucher-code-visible"
                                                style="display: none;">{{ $voucher->voucher_code }}</span>
                                            <i class="fas fa-eye voucher-eye-icon"
                                                style="margin-left: 5px; font-size: 0.8rem; color: #6c757d;"></i>
                                        </span>
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

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-upload"></i>
                            Upload
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

@endsection
