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
                            location Management
                        </span>

                        <h2>Edit location</h2>

                        <p>Update location details</p>

                    </div>

                </div>

                <div class="premium-head-actions">

                    <a href="{{ route('locations.index') }}" class="btn btn-create"
                        style="background: var(--cloth); color: var(--ink);">

                        <i class="fas fa-arrow-left"></i>
                        Back to location

                    </a>

                </div>

            </div>

        </div>

    </section>

    <section class="section premium-dashboard pt-0">

        <form method="POST" action="{{ route('locations.update', $location->id) }}">

            @csrf
            @method('PUT')

            <div class="card premium-block">

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                location Name <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="name" class="form-control" value="{{ old('name', $location->name) }}"
                                placeholder="Enter location Name">

                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>
                        <div class="mt-4">

                            <button type="submit" class="btn btn-create">

                                <i class="fas fa-save"></i>

                                Update Location

                            </button>

                            <a href="{{ route('locations.index') }}" class="btn"
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