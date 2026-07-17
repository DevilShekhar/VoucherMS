@extends('layouts.app')

@section('content')

    <section class="section premium-dashboard">

        <div class="premium-floating-header">

            <div class="header-content">

                <div class="header-left">

                    <div class="header-icon">
                        <i class="fas fa-edit"></i>
                    </div>

                    <div>

                        <span class="header-badge">
                            Voucher Vendor Management
                        </span>

                        <h2>Edit Voucher Vendor</h2>

                        <p>Update voucher vendor details</p>

                    </div>

                </div>

                <div class="premium-head-actions">

                    <a href="{{ route('voucher-vendors.index') }}" class="btn btn-create"
                        style="background: var(--cloth); color: var(--ink);">
                        <i class="fas fa-arrow-left"></i>
                        Back to Vendors
                    </a>

                </div>

            </div>

        </div>

    </section>

    <section class="section premium-dashboard pt-0">

        <form action="{{ route('voucher-vendors.update', $voucherVendor->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="card premium-block">

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Vendor Name <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="vendor_name" class="form-control"
                                value="{{ old('vendor_name', $voucherVendor->vendor_name) }}">

                            @error('vendor_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Contact Person</label>

                            <input type="text" name="contact_person" class="form-control"
                                value="{{ old('contact_person', $voucherVendor->contact_person) }}">

                            @error('contact_person')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Phone Number</label>

                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $voucherVendor->phone) }}">

                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Email Address</label>

                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $voucherVendor->email) }}">

                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>

                    </div>

                    <div class="mt-4">

                        <button type="submit" class="btn btn-create">
                            <i class="fas fa-save"></i>
                            Update Vendor
                        </button>

                        <a href="{{ route('voucher-vendors.index') }}" class="btn"
                            style="background: var(--cloth); color: var(--ink);">

                            <i class="fas fa-times"></i>
                            Cancel

                        </a>

                    </div>

                </div>

            </div>

        </form>

    </section>

@endsection
