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
                        Voucher Vendor Management
                    </span>

                    <h2>Voucher Vendors</h2>

                    <p>Manage all voucher vendors</p>

                </div>

            </div>

            <div class="premium-head-actions">

                <a href="{{ route('voucher-vendors.create') }}" class="btn btn-create">
                    <i class="fas fa-plus-circle"></i>
                    Add Vendor
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

                <table class="table table-hover align-middle" id="datatable">

                    <thead>

                        <tr>

                            <th width="60">#</th>

                            <th>Vendor Name</th>

                            <th>Contact Person</th>

                            <th>Phone</th>

                            <th>Email</th>

                            <th>Created On</th>

                            <th width="180" class="text-center">Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($voucherVendors as $key => $vendor)

                            <tr>

                                <td>{{ $voucherVendors->firstItem() + $key }}</td>

                                <td>{{ $vendor->vendor_name }}</td>

                                <td>{{ $vendor->contact_person ?: '-' }}</td>

                                <td>{{ $vendor->phone ?: '-' }}</td>

                                <td>{{ $vendor->email ?: '-' }}</td>

                                <td>{{ $vendor->created_at->format('d M Y') }}</td>

                                <td class="text-center">

                                    <a href="{{ route('voucher-vendors.edit',$vendor->id) }}"
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('voucher-vendors.destroy',$vendor->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this vendor?')">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="text-center py-4">

                                    No voucher vendors found.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $voucherVendors->links() }}

            </div>

        </div>

    </div>

</section>

@endsection
