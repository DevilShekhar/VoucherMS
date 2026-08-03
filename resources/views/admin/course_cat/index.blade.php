@can('course-category.index')
@extends('layouts.app')

@section('content')

    <section class="section premium-dashboard">
        <div class="premium-header">
            <div class="premium-header-overlay"></div>

            <div class="premium-header-left">
                <div class="premium-header-icon">
                    <i class="fas fa-list"></i>
                </div>
                <div class="premium-header-content">
                    <span class="premium-tag">COURSE CATEGORY</span>
                    <h2 class="text-white">Course Categories</h2>
                    <p>Manage all course categories</p>
                </div>
            </div>

            <div class="premium-header-right">
                <a href="{{ route('course-category.create') }}" class="premium-back-btn">
                    <i class="fas fa-plus"></i> Add Category
                </a>
            </div>

            <div class="shape circle-1"></div>
            <div class="shape circle-2"></div>
            <div class="shape circle-3"></div>
            <div class="dots"></div>
        </div>
    </section>

    <section class="section premium-dashboard pt-0">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card premium-block">
            <div class="card-body table-responsive">

                <table class="table table-bordered table-hover align-middle" id="datatable">
                    <thead class="table-light">
                        <tr>
                            <th width="70">#</th>
                            <th>Category Name</th>
                            <th>Created At</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($courseCategories as $key => $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $category->name }}</td>

                                <td>{{ $category->created_at->format('d M Y') }}</td>
                                <td>{{ $category->creator->name ?? '-' }}</td>
                                <td>{{ $category->updater->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('course-category.edit', $category->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('course-category.destroy', $category->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Delete this category?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    No course categories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>
        </div>

    </section>

@endsection
@else
    @php
        abort(403);
    @endphp
@endcan
