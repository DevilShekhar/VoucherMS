@extends('layouts.app')

@section('content')
    <section class="section premium-dashboard">
        <div class="premium-floating-header">
            <div class="header-content">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-key"></i>
                    </div>
                    <div>
                        <span class="header-badge">
                            Permission Management
                        </span>
                        <h2>Edit Permission</h2>
                        <p>Update permission details in the system</p>
                    </div>
                </div>
                <div class="premium-head-actions">
                    <a href="{{ route('permissions.index') }}" class="btn btn-create" style="background: var(--cloth); color: var(--ink);">
                        <i class="fas fa-arrow-left"></i>
                        Back to Permissions
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="section premium-dashboard pt-0">
        <form method="POST" action="{{ route('permissions.update', $permission->id) }}">
            @csrf
            @method('PUT')

            <div class="card premium-block">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="permissionName" class="form-label" style="font-weight: 600; font-size: 13px; color: var(--ink); margin-bottom: 6px; display: block;">
                            Permission Name
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="permissionName"
                            class="form-control"
                            placeholder="Enter permission name (e.g., create-order, edit-user)"
                            value="{{ old('name', $permission->name) }}"
                            style="width: 100%; padding: 10px 14px; border: 1px solid var(--line); border-radius: 8px; background: var(--card); color: var(--ink); font-size: 14px; transition: all .2s ease;"
                            required
                        >
                        @error('name')
                            <span style="color: var(--rust); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--line); display: flex; gap: 12px; flex-wrap: wrap;">
                        <button type="submit" class="btn btn-create">
                            <i class="fas fa-save"></i>
                            Update Permission
                        </button>
                        <a href="{{ route('permissions.index') }}" class="btn" style="background: var(--cloth); color: var(--ink); padding: 10px 24px; border-radius: 10px; font-weight: 600; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: all .2s ease;">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
