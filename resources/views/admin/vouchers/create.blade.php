@can('vouchers.create')
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
                            VOUCHER MANAGEMENT
                        </span>
                        <h2 class="text-white">Add Voucher</h2>
                        <p>Create a new voucher</p>
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

            <form action="{{ route('vouchers.store') }}" method="POST">

                @csrf

                <div class="card premium-block">

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Course Category <span class="text-danger">*</span></label>

                                <select name="course_category_id" id="course_category_id" class="form-control" required>

                                    <option value="">Select Category</option>

                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Course <span class="text-danger">*</span></label>

                                <select name="course_id" id="course_id" class="form-control" required>

                                    <option value="">Select Course</option>
                                </select>
                            </div>
                            <!-- Voucher Code -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Voucher Code <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="voucher_code" class="form-control check-unique"
                                    value="{{ old('voucher_code') }}" placeholder="Enter Voucher Code" data-table="vouchers"
                                    data-column="voucher_code" data-message="This voucher code already exists.">

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
                                        <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                            {{ $vendor->vendor_name }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('vendor_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Certification -->


                            <!-- Purchase Date -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Purchase Date
                                </label>

                                <input type="date" name="purchase_date" class="form-control" value="{{ old('purchase_date') }}">

                                @error('purchase_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Expiry Date -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Expiry Date
                                </label>

                                <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date') }}">

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
                                    value="{{ old('purchase_price') }}" placeholder="Enter Purchase Price">

                                @error('purchase_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Cost -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Cost
                                </label>

                                <input type="number" step="0.01" name="cost" class="form-control" value="{{ old('cost') }}"
                                    placeholder="Enter Cost">

                                @error('cost')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Remarks -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label">
                                    Remarks
                                </label>

                                <textarea name="remarks" rows="4" class="form-control"
                                    placeholder="Enter Remarks">{{ old('remarks') }}</textarea>

                                @error('remarks')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-footer">
                            <a href="{{ route('vouchers.index') }}" class="btn btn-cancel">

                                <i class="fas fa-times"></i>
                                Cancel

                            </a>
                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-save me-2"></i>
                                Save Voucher
                            </button>



                        </div>

                    </div>

                </div>

            </form>

        </section>

        <script>
            $(document).ready(function () {

                $('#course_category_id').change(function () {

                    let categoryId = $(this).val();

                    $('#course_id').html('<option value="">Loading...</option>');

                    if (categoryId == '') {
                        $('#course_id').html('<option value="">Select Course</option>');
                        return;
                    }

                    $.ajax({
                        url: '/courses/by-category/' + categoryId,
                        type: 'GET',
                        success: function (response) {

                            let options = '<option value="">Select Course</option>';

                            $.each(response, function (index, course) {
                                options += `<option value="${course.id}">
                                            ${course.course_name}
                                        </option>`;
                            });

                            $('#course_id').html(options);
                        }
                    });

                });

            });

        </script>
    @endsection
@else
    @php
        abort(403);
    @endphp
@endcan
