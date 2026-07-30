@can('locations.create')
@extends('layouts.app')

@section('content')
    <section class="section premium-dashboard">
        <div class="premium-header">
            <div class="premium-header-overlay"></div>
            <div class="premium-header-left">
                <div class="premium-header-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="premium-header-content">
                    <span class="premium-tag">Location Management</span>
                    <h2 class="text-white">Create New Location</h2>
                    <p>Add a new Location to the system</p>
                </div>
            </div>
            <div class="premium-header-right">
                <a href="{{ route('locations.index') }}" class="premium-back-btn">
                   <i class="fas fa-arrow-left"></i> Back To Location
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
                            placeholder="Enter Locations name"
                            style="width: 100%; padding: 10px 14px; border: 1px solid var(--line); border-radius: 8px; background: var(--card); color: var(--ink); font-size: 14px; transition: all .2s ease;"
                            required
                        >
                        @error('name')
                            <span style="color: var(--rust); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-footer">
                         <a href="{{ route('locations.index') }}" class="btn btn-cancel">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-save">
                            <i class="fas fa-plus-circle"></i>
                            Create Location
                        </button>

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
