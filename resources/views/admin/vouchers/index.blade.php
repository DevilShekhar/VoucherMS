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

                    <a href="{{ route('vouchers.create') }}" class="btn btn-create">
                        <i class="fas fa-plus-circle"></i>
                        Add Voucher
                    </a>

                </div>

            </div>

        </div>

    </section>

    <section class="section premium-dashboard pt-0">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card premium-block">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th width="60">#</th>
                                <th>Voucher Code</th>
                                <th>Vendor</th>
                                <th>Purchase Date</th>
                                <th>Expiry Date</th>
                                <th>Purchase Price</th>
                                <th>Cost</th>
                                <th>Status</th>
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
                                            <span class="voucher-code-hidden">••••••••</span>
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

                                    <td>
                                        @if($voucher->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
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

                <div class="mt-3">

                    {{ $vouchers->links() }}

                </div>

            </div>

        </div>

    </section>

@endsection
