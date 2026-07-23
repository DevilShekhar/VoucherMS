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
                <span class="premium-tag"> ROLES MANAGEMENT</span>
                <h2 class="text-white">Roles</h2>
                <p>Manage all roles and their permissions</p>
            </div>
        </div>
        <div class="premium-header-right">
            <a href="{{ route('roles.create') }}" class="premium-back-btn">
                <i class="fas fa-plus-circle"></i> Add Role
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
                <table class="table table-hover align-middle" id="datatable">
                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>Role Name</th>
                            <th>Status</th>
                            <th width="250" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $roleItem)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="fw-bold">
                                    {{ ucwords(str_replace('_', ' ', $roleItem->name)) }}
                                </td>
                                <td>
                                    @if ($roleItem->status == 1)
                                        <span class="status-pill status-active">
                                            <span class="dot"></span> Active
                                        </span>
                                    @else
                                        <span class="status-pill status-inactive">
                                            <span class="dot"></span> Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('roles.permissions', $roleItem->id) }}" class="btn btn-sm btn-primary me-1">
                                        Manage Permission
                                    </a>
                                    <a href="{{ route('roles.edit', $roleItem->id) }}" class="btn btn-sm btn-warning me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($roleItem->status == 1)
                                        <form action="{{ route('roles.destroy', $roleItem->id) }}" method="POST" class="delete-form d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    No Roles Found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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
