@extends('layouts.app')

@section('content')
    <section class="section premium-dashboard">
        <div class="premium-header">
            <div class="premium-header-overlay"></div>
            <div class="premium-header-left">
                <div class="premium-header-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="premium-header-content">
                    <span class="premium-tag"> USER MANAGEMENT</span>
                    <h2 class="text-white">Users</h2>
                    <p>Manage all system users</p>
                </div>
            </div>
            <div class="premium-header-right">
                <a href="{{ route('users.create') }}" class="premium-back-btn">
                    <i class="fas fa-plus-circle"></i> Add User
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
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card premium-block">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>Photo</th>
                                <th>Employee Code</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Location</th>
                                <th>Mobile</th>
                                <th>Status</th>
                                <th width="170" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $key => $user)
                                <tr>
                                    <td>{{ $users->firstItem() + $key }}</td>
                                    <td>
                                        @if($user->profile_photo && file_exists(public_path('storage/' . $user->profile_photo)))
                                            <img src="{{ asset('storage/' . $user->profile_photo) }}" width="45" height="45"
                                                class="rounded-circle" style="object-fit: cover;">
                                        @else
                                            <div class="avatar-placeholder">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $user->employee_code }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->role?->name ?? '-' }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->location?->name ?? '-' }}</td>
                                    <td>{{ $user->mobile }}</td>
                                    <td>
                                        @if($user->status == '1')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger text-white">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                            class="delete-form d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- SweetAlert Success -->
    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        </script>
    @endif

    <!-- Delete Confirmation with SweetAlert -->
    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Delete User?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Delete',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#EF4444',
                    cancelButtonColor: '#6B7A8D'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

@endsection
