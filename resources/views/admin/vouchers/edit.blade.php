@can('vouchers.edit')
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
                        <span class="premium-tag">
                            Voucher Management
                        </span>
                        <h2 class="text-white">Edit Voucher</h2>
                        <p>Update voucher details</p>
                    </div>

                </div>

                <div class="premium-header-right">

                    <a href="{{ route('vouchers.index') }}" class="premium-back-btn">
                        <i class="fas fa-arrow-left"></i>
                         Back to Vouchers
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

        <form action="{{ route('vouchers.update', $voucher->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="card premium-block">

                <div class="card-body">

                    <div class="row">

                        <!-- Voucher Code -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Voucher Code <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="voucher_code" class="form-control"
                                value="{{ old('voucher_code', $voucher->voucher_code) }}" placeholder="Enter Voucher Code"
                                readonly>
                            <span class="text-primary">You cannot change the code</span>

                            @error('voucher_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Vendor -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Vendor <span class="text-danger">*</span>
                            </label>

                            <select name="vendor_id" class="form-control">

                                <option value="">Select Vendor</option>

                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" {{ old('vendor_id', $voucher->vendor_id) == $vendor->id ? 'selected' : '' }}>
                                        {{ $vendor->vendor_name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('vendor_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Purchase Date -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Purchase Date
                            </label>

                            <input type="date" name="purchase_date" class="form-control"
                                value="{{ old('purchase_date', $voucher->purchase_date) }}">

                            @error('purchase_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Expiry Date -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Expiry Date
                            </label>

                            <input type="date" name="expiry_date" class="form-control"
                                value="{{ old('expiry_date', $voucher->expiry_date) }}">

                            @error('expiry_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Purchase Price -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Purchase Price
                            </label>

                            <input type="number" step="0.01" name="purchase_price" class="form-control"
                                value="{{ old('purchase_price', $voucher->purchase_price) }}"
                                placeholder="Enter Purchase Price">

                            @error('purchase_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Cost -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Cost
                            </label>

                            <input type="number" step="0.01" name="cost" class="form-control"
                                value="{{ old('cost', $voucher->cost) }}" placeholder="Enter Cost">

                            @error('cost')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Status
                            </label>

                            <select name="status" class="form-control">
                                <option value="1" {{ old('status', $voucher->status) == 1 ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="0" {{ old('status', $voucher->status) == 0 ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>

                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Remarks -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">
                                Remarks
                            </label>

                            <textarea name="remarks" rows="4" class="form-control"
                                placeholder="Enter Remarks">{{ old('remarks', $voucher->remarks) }}</textarea>

                            @error('remarks')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-4">

                        <button type="submit" class="btn btn-save">
                            <i class="fas fa-me-2"></i>
                            Update Voucher
                        </button>

                        <a href="{{ route('vouchers.index') }}" class="btn"
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
@else
    @php
        abort(403);
    @endphp
@endcan
