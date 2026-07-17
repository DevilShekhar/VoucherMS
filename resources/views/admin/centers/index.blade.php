@extends('layouts.app')

@section('content')

<section class="section premium-dashboard">

    <div class="premium-floating-header">

        <div class="header-content">

            <div class="header-left">

                <div class="header-icon">
                    <i class="fas fa-building"></i>
                </div>

                <div>
                    <span class="header-badge">
                        Center Management
                    </span>

                    <h2>Training Centers</h2>

                    <p>Manage all training centers</p>
                </div>

            </div>

            <div class="premium-head-actions">

                <a href="{{ route('centers.create') }}" class="btn btn-create">

                    <i class="fas fa-plus"></i>

                    Add Center

                </a>

            </div>

        </div>

    </div>

</section>

<section class="section premium-dashboard pt-0">

    <div class="card premium-block">

        <div class="card-body">

            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>#</th>
                            <th>Center Code</th>
                            <th>Center Name</th>
                            <th>Manager</th>
                            <th>Phone</th>
                            <th>City</th>
                            <th>Status</th>
                            <th width="120">Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($centers as $center)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $center->center_code }}</td>

                            <td>{{ $center->center_name }}</td>

                            <td>{{ $center->manager->name ?? '-' }}</td>

                            <td>{{ $center->phone ?? '-' }}</td>

                            <td>{{ $center->city ?? '-' }}</td>

                            <td>

                                @if($center->status)

                                    <span class="badge bg-success">

                                        Active

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        Inactive

                                    </span>

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('centers.edit',$center->id) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="fas fa-edit"></i>

                                </a>

                                <form action="{{ route('centers.destroy',$center->id) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this center?')">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="8" class="text-center">

                                No Centers Found

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</section>

@endsection
