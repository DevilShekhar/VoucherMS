@extends('layouts.app')

@section('content')

    <section class="section premium-dashboard">
    <div class="premium-header">
        <div class="premium-header-overlay"></div>
        <div class="premium-header-left">
            <div class="premium-header-icon">
                <i class="fas fa-edit"></i>
            </div>
            <div class="premium-header-content">
                <span class="premium-tag">VOUCHER VENDOR MANAGEMENT</span>
                <h2 class="text-white">Edit Voucher Vendor</h2>
                <p>Update voucher vendor details</p>
            </div>
        </div>
        <div class="premium-header-right">
            <a href="{{ route('voucher-vendors.index') }}" class="premium-back-btn">
                <i class="fas fa-arrow-left"></i> Back to Vendors
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

                        <button type="submit" class="btn btn-save">
    <i class="fas fa-save me-2"></i> Update Vendor
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
