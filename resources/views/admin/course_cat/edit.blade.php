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
                <span class="premium-tag">COURSE CATEGORY</span>
                <h2 class="text-white">Edit Course Category</h2>
                <p>Update course category details</p>
            </div>
        </div>

        <div class="premium-header-right">
            <a href="{{ route('course-category.index') }}" class="premium-back-btn">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="shape circle-1"></div>
        <div class="shape circle-2"></div>
        <div class="shape circle-3"></div>
        <div class="dots"></div>
    </div>
</section>

<section class="section premium-dashboard pt-0">

    <form action="{{ route('course-category.update', $courseCategory->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card premium-block">
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Category Name
                    </label>

                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $courseCategory->name) }}"
                           placeholder="Enter category name">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-footer">
                    <a href="{{ route('course-category.index') }}" class="btn btn-cancel">
                        <i class="fas fa-times"></i> Cancel
                    </a>

                    <button type="submit" class="btn btn-save">
                        <i class="fas fa-save"></i> Update Category
                    </button>
                </div>

            </div>
        </div>

    </form>

</section>

@endsection
