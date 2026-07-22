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
                        <h2>Roles</h2>
                        <p>Manage all roles and their permissions</p>
                    </div>
                </div>
                <div class="premium-head-actions">
                    <a href="{{ route('roles.create') }}" class="btn btn-create">
                        <i class="fas fa-plus"></i>
                        Add Role
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="section premium-dashboard pt-0">
        <div class="card premium-block">
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Role Name</th>
                            <th>Status</th>
                            <th width="250">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $roleItem)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>
                                        {{ ucwords(str_replace('_', ' ', $roleItem->name)) }}
                                    </strong>
                                </td>
                                <td>
                                    @if ($roleItem->status == 1)
                                        <span class="badge bg-success text-white">Active</span>
                                    @else
                                        <span class="badge bg-danger text-white">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('roles.permissions', $roleItem->id) }}" class="btn btn-sm btn-primary">
                                        Manage Permission
                                    </a>
                                    <a href="{{ route('roles.edit', $roleItem->id) }}" class="btn btn-sm btn-warning">

                                        <i class="fas fa-edit"></i>

                                    </a>
                                    @if($roleItem->status == 1)
                                        <form action="{{ route('roles.destroy', $roleItem->id) }}" method="POST" class="delete-form"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    No Roles Found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}'
            });
        </script>
    @endif

    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Delete Role?',
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
