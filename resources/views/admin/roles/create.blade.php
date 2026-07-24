@extends('layouts.app')

@section('content')
    <section class="section premium-dashboard">
    <div class="premium-header">
        <div class="premium-header-overlay"></div>
        <div class="premium-header-left">
            <div class="premium-header-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="premium-header-content">
                <span class="premium-tag">ROLES MANAGEMENT</span>
                <h2 class="text-white">Create New Role</h2>
                <p>Add a new role to the system</p>
            </div>
        </div>
        <div class="premium-header-right">
            <a href="{{ route('roles.index') }}" class="premium-back-btn">
                <i class="fas fa-arrow-left"></i> Back to Roles
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
        <form method="POST" action="{{ route('roles.store') }}">
            @csrf

            <div class="card premium-block">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="roleName" class="form-label" style="font-weight: 600; font-size: 13px; color: var(--ink); margin-bottom: 6px; display: block;">
                            Role Name
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="roleName"
                            class="form-control"
                            placeholder="Enter role name (e.g., Admin, Manager, Editor)"
                            style="width: 100%; padding: 10px 14px; border: 1px solid var(--line); border-radius: 8px; background: var(--card); color: var(--ink); font-size: 14px; transition: all .2s ease;"
                            required
                        >
                        @error('name')
                            <span style="color: var(--rust); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--line); display: flex; gap: 12px; flex-wrap: wrap;">
                        <button type="submit" class="btn btn-save">
                            <i class="fas fa-plus-circle me-2"></i>
                            Create Role
                        </button>
                        <a href="{{ route('roles.index') }}" class="btn" style="background: var(--cloth); color: var(--ink); padding: 10px 24px; border-radius: 10px; font-weight: 600; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: all .2s ease;">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
