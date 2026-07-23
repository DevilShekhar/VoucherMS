@extends('layouts.app')

@section('content')

    <section class="section premium-dashboard">

        <div class="premium-floating-header">

            <div class="header-content">

                <div class="header-left">

                    <div class="header-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>

                    <div>

                        <span class="header-badge">
                            Roles Management
                        </span>

                        <h2>Edit Role</h2>

                        <p>Update role details</p>

                    </div>

                </div>

                <div class="premium-head-actions">

                    <a href="{{ route('roles.index') }}" class="btn btn-create"
                        style="background: var(--cloth); color: var(--ink);">

                        <i class="fas fa-arrow-left"></i>
                        Back to Roles

                    </a>

                </div>

            </div>

        </div>

    </section>

    <section class="section premium-dashboard pt-0">

        <form method="POST" action="{{ route('roles.update', $role->id) }}">

            @csrf
            @method('PUT')

            <div class="card premium-block">

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Role Name <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}"
                                placeholder="Enter Role Name">

                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>

                            <select name="status" class="form-control">

                                <option value="1" {{ old('status', $role->status) == 1 ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="0" {{ old('status', $role->status) == 0 ? 'selected' : '' }}>
                                    Inactive
                                </option>

                            </select>

                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-12 mb-3">

                            <label class="form-label">
                                Description
                            </label>

                            <textarea name="description" rows="4" class="form-control"
                                placeholder="Enter Role Description">{{ old('description', $role->description) }}</textarea>

                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                    </div>

                    <div class="mt-4">

                        <button type="submit" class="btn btn-save">
                            <i class="fas fa-save me-2"></i> Update Role
                        </button>

                        <a href="{{ route('roles.index') }}" class="btn"
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