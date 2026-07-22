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
                            Location Management
                        </span>
                        <h2>Create New Location</h2>
                        <p>Add a new Location to the system</p>
                    </div>
                </div>
                <div class="premium-head-actions">
                    <a href="{{ route('locations.index') }}" class="btn btn-create" style="background: var(--cloth); color: var(--ink);">
                        <i class="fas fa-arrow-left"></i>
                        Back to Locations
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="section premium-dashboard pt-0">
        <form method="POST" action="{{ route('locations.store') }}">
            @csrf

            <div class="card premium-block">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="LocationName" class="form-label" style="font-weight: 600; font-size: 13px; color: var(--ink); margin-bottom: 6px; display: block;">
                            Location Name
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="LocationName"
                            class="form-control"
                            placeholder="Enter Locations name (e.g., Admin, Manager, Editor)"
                            style="width: 100%; padding: 10px 14px; border: 1px solid var(--line); border-radius: 8px; background: var(--card); color: var(--ink); font-size: 14px; transition: all .2s ease;"
                            required
                        >
                        @error('name')
                            <span style="color: var(--rust); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--line); display: flex; gap: 12px; flex-wrap: wrap;">
                        <button type="submit" class="btn btn-create">
                            <i class="fas fa-plus-circle"></i>
                            Create Location
                        </button>
                        <a href="{{ route('locations.index') }}" class="btn" style="background: var(--cloth); color: var(--ink); padding: 10px 24px; border-radius: 10px; font-weight: 600; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: all .2s ease;">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
