@extends('layouts.app')

@section('content')

    <section class="section premium-dashboard">
        <div class="premium-page-head">
            <div class="premium-page-title">
                <span class="mini-badge">Role Management</span>
                <h2>Manage Permissions</h2>
                <p>Role: <b>{{ $role->name }}</b></p>
            </div>
        </div>

    </section>


    <section class="section premium-dashboard pt-0">

        <form method="POST" action="{{ route('roles.permissions.update', ['role' => $role->id]) }}">
            @csrf

            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

                <!-- Left Side: Search -->
                <input type="text"
                    id="searchPermission"
                    class="form-control"
                    style="max-width: 360px;"
                    placeholder=" Search permissions...">

                <!-- Right Side: Buttons -->
                <div class="d-flex align-items-center gap-3">
                    <button type="button" id="selectAllBtn" class="btn btn-primary">
                        Select All
                    </button>

                    <a href="{{ route('roles.index') }}" class="btn btn-back" style="color: blue">
                        <i class="fas fa-arrow-left"></i>
                        Back to Roles
                    </a>
                </div>

            </div>

            <div class="permissions-grid" id="permissionsGrid">

                @foreach ($permissions as $permission)
                    <div class="permission-card">
                        <label class="permission-label">
                            <input type="checkbox" class="permission-checkbox" name="permissions[]"
                                value="{{ $permission->name }}" {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>

                            <span class="permission-name">
                                {{ ucwords(str_replace(['.', '_', '-'], ' ', $permission->name)) }}
                            </span>
                        </label>
                    </div>
                @endforeach

            </div>

            <div class="sticky-footer">
                <button type="submit" class="btn-save">
                    💾 Save Permissions
                </button>
            </div>
        </form>

    </section>

    <style>
        .permissions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 12px;
        }

        .permission-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 14px 16px;
            transition: all 0.2s ease;
        }

        .permission-card:hover {
            border-color: #6366f1;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.05);
        }

        .permission-label {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            margin: 0;
        }

        .permission-checkbox {
            width: 18px;
            height: 18px;
            accent-color: #4f46e5;
            cursor: pointer;
        }

        .permission-name {
            font-size: 14.5px;
            color: #374151;
            font-weight: 500;
            line-height: 1.4;
        }

        .permission-card input:checked+.permission-name {
            color: #1e2937;
            font-weight: 600;
        }

        .btn-select-all {
            padding: 10px 20px;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-select-all:hover {
            background: #4338ca;
        }

        .btn-save {
            padding: 14px 32px;
            background: #16a34a;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }

        .btn-save:hover {
            background: #15803d;
        }

        .sticky-footer {
            position: sticky;
            bottom: 20px;
            text-align: right;
            margin-top: 30px;
            z-index: 10;
        }

        .mini-badge {
            background: #e0e7ff;
            color: #4338ca;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const checkboxes = document.querySelectorAll('.permission-checkbox');
            const searchInput = document.getElementById('searchPermission');
            const selectAllBtn = document.getElementById('selectAllBtn');

            // Toggle active state on checkbox change
            function updateCardStates() {
                checkboxes.forEach(cb => {
                    const card = cb.closest('.permission-card');
                    if (cb.checked) {
                        card.style.borderColor = '#6366f1';
                        card.style.backgroundColor = '#f0f9ff';
                    } else {
                        card.style.borderColor = '#e5e7eb';
                        card.style.backgroundColor = '#fff';
                    }
                });
            }

            updateCardStates();

            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateCardStates);
            });

            // Search functionality
            searchInput.addEventListener('input', function () {
                const term = this.value.toLowerCase().trim();

                document.querySelectorAll('.permission-card').forEach(card => {
                    const text = card.textContent.toLowerCase();
                    card.style.display = text.includes(term) ? '' : 'none';
                });
            });

            // Select All / Deselect All
            let allSelected = false;

            selectAllBtn.addEventListener('click', function () {
                allSelected = !allSelected;

                checkboxes.forEach(cb => {
                    cb.checked = allSelected;
                });

                this.textContent = allSelected ? 'Deselect All' : 'Select All';
                updateCardStates();
            });

            // Optional: Make entire card clickable
            document.querySelectorAll('.permission-card').forEach(card => {
                card.addEventListener('click', function (e) {
                    if (e.target.type !== 'checkbox') {
                        const checkbox = this.querySelector('input[type="checkbox"]');
                        checkbox.checked = !checkbox.checked;
                        updateCardStates();
                    }
                });
            });
        });
    </script>

@endsection
