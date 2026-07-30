<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Certification Voucher Management System</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/fav-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/fav-icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/fav-icon.png') }}">
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap"
        rel="stylesheet">

    <!-- Include SweetAlert2 and jQuery for your modals -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/dataTables.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap 5 CSS for modal -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customes.css') }}">

</head>

<body>

    <!-- Scrim for mobile -->
    <div class="scrim" id="scrim"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sb-brand">
            <div class="dot"><i class="fas fa-graduation-cap"></i></div>
            <span class="label">
                {{ config('app.name', 'Admin Panal') }}
                <span class="brand-sub">Admin Panel</span>
            </span>
        </div>

        <ul class="sb-nav">
            <li><a href="{{ route('dashboard') }}" class="sb-link"><i
                        class="fas fa-th-large"></i><span>Dashboard</span></a></li>
            @can('locations.index')
                <li>
                    <a href="{{ route('locations.index') }}"
                        class="sb-link {{ request()->routeIs('locations.*') ? 'active' : '' }}">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Locations</span>
                    </a>
                </li>
            @endcan
            @can('users.index')
                <li>
                    <a href="{{ route('users.index') }}"
                        class="sb-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="fas fa-user-plus"></i>
                        <span>Users</span>
                    </a>
                </li>
            @endcan

            @can('roles.index')
                <li>
                    <a href="{{ route('roles.index') }}"
                        class="sb-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                        <i class="fas fa-user-shield"></i>
                        <span>Roles</span>
                    </a>
                </li>
            @endcan

            @can('permissions.index')
                {{-- <li>
                    <a href="{{ route('permissions.index') }}"
                        class="sb-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                        <i class="fas fa-key"></i>
                        <span>Manage Permissions</span>
                    </a>
                </li> --}}
            @endcan

            @can('voucher-vendors.index')
                <li>
                    <a href="{{ route('voucher-vendors.index') }}"
                        class="sb-link {{ request()->routeIs('voucher-vendors.*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        <span>Voucher Vendors</span>
                    </a>
                </li>
            @endcan

            @can('centers.index')
                <li>
                    <a href="{{ route('centers.index') }}"
                        class="sb-link {{ request()->routeIs('centers.*') ? 'active' : '' }}">
                        <i class="fas fa-store-alt"></i>
                        <span>Centers</span>
                    </a>
                </li>
            @endcan

            @can('courses.index')
                <li>
                    <a href="{{ route('courses.index') }}"
                        class="sb-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i>
                        <span>Courses</span>
                    </a>
                </li>
            @endcan

            @can('leads.index')
                <li>
                    <a href="{{ route('leads.index') }}"
                        class="sb-link {{ request()->routeIs('leads.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-phone-volume"></i>
                        <span>Leads</span>
                    </a>
                </li>
            @endcan

            @can('candidates.index')
                <li>
                    <a href="{{ route('candidates.index') }}"
                        class="sb-link {{ request()->routeIs('candidates.*') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate"></i>
                        <span>Candidates</span>
                    </a>
                </li>
            @endcan
            @can('exam-schedules.index')
                <li>
                    <a href="{{ route('exam-schedules.index') }}"
                        class="sb-link {{ request()->routeIs('exam-schedules.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Exam Schedule</span>
                    </a>
                </li>
            @endcan

            @can('payments.index')
                <li>
                    <a href="{{ route('payments.index') }}"
                        class="sb-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                        <i class="fas fa-money-check-alt"></i>
                        <span>Payment</span>
                    </a>
                </li>
            @endcan

            @can('vouchers.index')
                <li class="sb-item">
                    <a href="javascript:void(0);" class="sb-link {{ request()->routeIs('vouchers.*') ? 'active' : '' }}"
                        id="voucherMenu">
                        <i class="fas fa-ticket-alt"></i>
                        <span>Voucher</span>
                        <i class="fas fa-chevron-down ms-auto" id="voucherArrow"></i>
                    </a>
                    <ul class="sb-submenu" id="voucherSubmenu">
                        <li>
                            <a href="{{ route('vouchers.index') }}"
                                class="{{ request()->routeIs('vouchers.index') ? 'active' : '' }}">
                                All Vouchers
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('vouchers.status', 'available') }}">
                                Available
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('vouchers.status', 'allocated') }}">
                                Allocated
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('vouchers.status', 'used') }}">
                                Used
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('vouchers.status', 'expired') }}">
                                Expired
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('vouchers.status', 'cancelled') }}">
                                Cancelled
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('voucher-requests.index')
                <li class="sb-item">
                    <a href="javascript:void(0);"
                        class="sb-link {{ request()->routeIs('voucher-requests.*') ? 'active' : '' }}"
                        id="voucherRequestMenu">

                        <i class="fas fa-file-signature"></i>
                        <span>Voucher Requests</span>

                        <i class="fas fa-chevron-down ms-auto" id="voucherRequestArrow"></i>
                    </a>

                    <ul class="sb-submenu" id="voucherRequestSubmenu">
                        <li>
                            <a href="{{ route('voucher-requests.index') }}"
                                class="{{ request()->routeIs('voucher-requests.index') ? 'active' : '' }}">
                                All Requests
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('voucher-requests.status', 'Pending') }}"
                                class="{{ request()->is('voucher-requests/status/Pending') ? 'active' : '' }}">
                                Pending
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('voucher-requests.status', 'Approved') }}"
                                class="{{ request()->is('voucher-requests/status/Approved') ? 'active' : '' }}">
                                Approved
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('voucher-requests.status', 'Rejected') }}"
                                class="{{ request()->is('voucher-requests/status/Rejected') ? 'active' : '' }}">
                                Rejected
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('report-index')
                <li>
                    <a href="{{ route('reports.index') }}" class="sb-link">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports</span>
                    </a>
                </li>
            @endcan
        </ul>
    </aside>

    <!-- Shell -->
    <div class="shell" id="shell">
        <!-- Navbar -->
        <div class="navbar" id="navbar">
            <div class="nb-left">

                <button class="icon-btn mobile-only" id="mobileBtn" title="Open menu"><i
                        class="fas fa-bars"></i></button>
                <div class="crumb">
                    <i class="fas fa-home" style="color: var(--ember);"></i>
                    &nbsp;/&nbsp; <b>@yield('page-title', 'Dashboard')</b>
                </div>
            </div>
            <div class="nb-right">

                <!-- User Dropdown -->
                <div class="profile-dropdown" id="profileDropdown">
                    <div class="profile-trigger" id="profileTrigger">
                        <div class="av">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="info">
                            <span class="name">{{ Auth::user()->name }}</span>
                            <span class="role-label">
                                {{ Auth::user()->roles->first()?->name ? ucwords(str_replace('_', ' ', Auth::user()->roles->first()->name)) : 'System User' }}
                            </span>
                        </div>
                        <i class="fas fa-chevron-down chevron"></i>
                    </div>

                    <div class="dropdown-menu-custom">
                        <div class="dropdown-header-custom">
                            <div class="av-lg">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="info">
                                <h4>{{ Auth::user()->name }}</h4>
                                <p>{{ Auth::user()->email }}</p>
                            </div>
                        </div>

                        <div class="dropdown-divider"></div>

                        <a href="{{ route('profile.edit') }}" class="dropdown-item-custom">
                            <i class="fas fa-user-circle"></i> My Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}" style="width:100%;">
                            @csrf
                            <button type="submit" class="dropdown-item-custom text-danger"
                                style="width:100%; text-align:left; border:none; background:none; cursor:pointer;">
                                <i class="fas fa-sign-out-alt"></i> Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer>
            <div>
                <i class="fas fa-graduation-cap" style="color: var(--ember);"></i>
                &nbsp;© {{ date('Y') }} {{ config('app.name', 'Admin Panal') }} — Education Admin Panel
            </div>
            <div>
                <a href="#">Documentation</a>
                <a href="#">Support</a>
                <a href="#">Status</a>
                <a href="#">Privacy</a>
            </div>
        </footer>
    </div>
    {{-- Lead Notification Sound --}}
    <audio id="notificationSound" preload="auto">
        <source src="{{ asset('assets/sounds/notification.mp3') }}" type="audio/mpeg">
    </audio>

    {{-- Voucher Request Notification Sound --}}
    <audio id="voucherNotificationSound" preload="auto">
        <source src="{{ asset('assets/sounds/voucher-request-notification.mp3') }}" type="audio/mpeg">
    </audio>

    <audio id="followupNotificationSound" preload="auto">
        <source src="{{ asset('assets/sounds/follow-up.mp3') }}" type="audio/mpeg">
    </audio>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let shownNotifications = [];

        const notificationAudio = document.getElementById('notificationSound');
        const voucherAudio = document.getElementById('voucherNotificationSound');

        notificationAudio.volume = 1.0;
        voucherAudio.volume = 1.0;

        /* ============================================================
           Enable Notification Sound (Only Once)
        ============================================================ */
        document.addEventListener("DOMContentLoaded", function () {
            if (!localStorage.getItem("audioEnabled")) {
                Swal.fire({
                    title: "Enable Notification Sound",
                    text: "Click Enable to allow notification sounds.",
                    icon: "question",
                    confirmButtonText: "Enable",
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        localStorage.setItem("audioEnabled", "1");

                        // Unlock both audios
                        notificationAudio.play().then(() => {
                            notificationAudio.pause();
                            notificationAudio.currentTime = 0;
                        }).catch(() => { });

                        voucherAudio.play().then(() => {
                            voucherAudio.pause();
                            voucherAudio.currentTime = 0;
                        }).catch(() => { });
                    }
                });
            }
        });

        /* ============================================================
           Lead Notifications
        ============================================================ */
        function checkLeadNotifications() {
            fetch("{{ route('lead.notifications') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) return;

                    let notification = data[0];

                    if (shownNotifications.includes(notification.id)) return;

                    shownNotifications.push(notification.id);

                    Swal.fire({
                        icon: 'info',
                        title: notification.title,
                        html: "<b>" + notification.message + "</b>",
                        confirmButtonText: "Open Lead",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            if (localStorage.getItem("audioEnabled") == "1") {
                                notificationAudio.currentTime = 0;
                                notificationAudio.loop = true;
                                notificationAudio.play().catch(err => console.log(err));
                            }
                        }
                    }).then(() => {
                        notificationAudio.pause();
                        notificationAudio.currentTime = 0;

                        fetch("/lead-notifications/" + notification.id + "/read", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json"
                            }
                        }).then(() => {
                            window.location.href = "/leads/" + notification.lead_id;
                        });
                    });
                });
        }

        checkLeadNotifications();
        setInterval(checkLeadNotifications, 5000);

        /* ============================================================
           Voucher Request Notifications (with special sound)
        ============================================================ */
        function checkVoucherNotifications() {
            fetch("{{ route('voucher-request-notifications.latest') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) return;

                    let notification = data[0];

                    if (shownNotifications.includes('voucher-' + notification.id)) return;

                    shownNotifications.push('voucher-' + notification.id);

                    Swal.fire({
                        icon: 'info',
                        title: notification.title,
                        html: "<b>" + notification.message + "</b>",
                        confirmButtonText: "Open Request",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            if (localStorage.getItem("audioEnabled") == "1") {
                                voucherAudio.currentTime = 0;
                                voucherAudio.loop = true;
                                voucherAudio.play().catch(err => console.log(err));
                            }
                        }
                    }).then(() => {
                        voucherAudio.pause();
                        voucherAudio.currentTime = 0;

                        fetch("/voucher-request-notifications/" + notification.id + "/read", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json"
                            }
                        }).then(() => {
                            window.location.href = "/voucher-requests/" + notification.voucher_request_id;
                        });
                    });
                });
        }

        checkVoucherNotifications();
        setInterval(checkVoucherNotifications, 5000);
    </script>

    <!-- Scripts -->
    @yield('scripts')

    <script>
        // Sidebar collapse (desktop)
        const sidebar = document.getElementById('sidebar');
        const shell = document.getElementById('shell');
        const collapseBtn = document.getElementById('collapseBtn');
        if (collapseBtn) {
            collapseBtn.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                shell.classList.toggle('collapsed');
            });
        }

        // Mobile sidebar open/close
        const scrim = document.getElementById('scrim');
        const mobileBtn = document.getElementById('mobileBtn');
        if (mobileBtn) {
            mobileBtn.addEventListener('click', () => {
                sidebar.classList.add('open');
                scrim.classList.add('show');
            });
        }
        if (scrim) {
            scrim.addEventListener('click', () => {
                sidebar.classList.remove('open');
                scrim.classList.remove('show');
            });
        }

        // Navbar shadow on scroll
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 4);
        });

        // Theme toggle
        const html = document.documentElement;
        const themeSwitch = document.getElementById('themeSwitch');
        const themeKnob = document.getElementById('themeKnob');
        if (themeSwitch) {
            themeSwitch.addEventListener('click', () => {
                const isDark = html.getAttribute('data-theme') === 'dark';
                html.setAttribute('data-theme', isDark ? 'light' : 'dark');
                themeKnob.innerHTML = isDark ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
            });
        }

        // Profile Dropdown Toggle
        const profileDropdown = document.getElementById('profileDropdown');
        const profileTrigger = document.getElementById('profileTrigger');

        if (profileTrigger) {
            profileTrigger.addEventListener('click', (e) => {
                e.stopPropagation();
                profileDropdown.classList.toggle('active');
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (profileDropdown && !profileDropdown.contains(e.target)) {
                profileDropdown.classList.remove('active');
            }
        });

        // Close dropdown on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && profileDropdown) {
                profileDropdown.classList.remove('active');
            }
        });

        // Active link switching
        document.querySelectorAll('.sb-link').forEach(link => {
            link.addEventListener('click', function (e) {
                if (!this.getAttribute('href') || this.getAttribute('href') === '#') {
                    e.preventDefault();
                }
                document.querySelectorAll('.sb-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Close mobile sidebar on window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 900) {
                sidebar.classList.remove('open');
                scrim.classList.remove('show');
            }
        });
    </script>
    <!-- SweetAlert Success -->
    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,
                background: '#1e2937',
                color: '#e2e8f0',
                customClass: {
                    popup: 'colored-toast'
                },
                didOpen: (toast) => {
                    toast.style.borderLeft = '5px solid #10b981';
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
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
                    title: 'Delete?',
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
    <script>
        function toggleVoucherCode(element) {
            const hidden = element.querySelector('.voucher-code-hidden');
            const visible = element.querySelector('.voucher-code-visible');
            const icon = element.querySelector('.voucher-eye-icon');

            if (hidden.style.display === 'none') {
                // Currently showing - hide it
                hidden.style.display = 'inline';
                visible.style.display = 'none';
                icon.className = 'fas fa-eye voucher-eye-icon';
                icon.style.marginLeft = '5px';
                icon.style.fontSize = '0.8rem';
                icon.style.color = '#6c757d';
            } else {
                // Currently hidden - show it
                hidden.style.display = 'none';
                visible.style.display = 'inline';
                icon.className = 'fas fa-eye-slash voucher-eye-icon';
                icon.style.marginLeft = '5px';
                icon.style.fontSize = '0.8rem';
                icon.style.color = '#0d6efd';
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let isFollowupPopupOpen = false;

        function checkFollowupReminders() {
            if (isFollowupPopupOpen) return;

            $.ajax({
                url: "{{ route('leads.followups.reminders') }}",
                method: 'GET',
                success: function (response) {
                    console.log('Follow-up response:', response);

                    if (response.reminders && response.reminders.length > 0) {
                        let item = response.reminders[0];

                        // Correct field mapping based on your API
                        let leadName = item.lead_name
                            || item.lead?.name
                            || item.lead?.full_name
                            || item.name
                            || ('Lead #' + (item.lead_id || item.id));

                        let followupTime = item.followup_date
                            || item.followup_time
                            || item.follow_up_time
                            || '-';

                        // Format date nicely
                        if (followupTime && followupTime !== '-') {
                            try {
                                followupTime = new Date(followupTime).toLocaleString('en-IN', {
                                    day: '2-digit',
                                    month: 'short',
                                    year: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    hour12: true
                                });
                            } catch (e) { }
                        }

                        let discussion = item.discussion
                            || item.note
                            || item.notes
                            || item.remark
                            || item.remarks
                            || '-';

                        isFollowupPopupOpen = true;

                        Swal.fire({
                            icon: 'warning',
                            title: '⏰ Follow-up Reminder!',
                            html: `
                            <strong>${leadName}</strong><br>
                            <small>${followupTime}</small><br><br>
                            ${discussion}
                        `,
                            showCancelButton: true,
                            confirmButtonText: 'Mark as Done',
                            cancelButtonText: 'Snooze 10 mins',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                if (localStorage.getItem("audioEnabled") == "1") {
                                    const audio = document.getElementById('followupNotificationSound');
                                    if (audio) {
                                        audio.currentTime = 0;
                                        audio.loop = true;
                                        audio.play().catch(err => console.log(err));
                                    }
                                }
                            }
                        }).then((result) => {
                            const audio = document.getElementById('followupNotificationSound');
                            if (audio) {
                                audio.pause();
                                audio.currentTime = 0;
                            }

                            isFollowupPopupOpen = false;

                            if (result.isConfirmed) {
                                markFollowupDone(item.id);
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                snoozeFollowup(item.id);
                            }
                        });
                    }
                },
                error: function () {
                    console.log('Reminder check failed');
                }
            });
        }

        function markFollowupDone(id) {
            $.ajax({
                url: `/lead-followups/${id}/mark-done`,
                method: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Marked as Done',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        }

        function snoozeFollowup(id) {
            $.ajax({
                url: `/lead-followups/${id}/snooze`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    minutes: 10
                },
                success: function () {
                    Swal.fire({
                        icon: 'info',
                        title: 'Snoozed for 10 minutes',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        }

        setInterval(checkFollowupReminders, 10000);

        $(document).ready(function () {
            checkFollowupReminders();
        });
    </script>
    <script>
        $(document).ready(function () {
            if ($('#datatable tbody tr').length > 0 &&
                $('#datatable tbody tr td[colspan]').length === 0) {

                $('#datatable').DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    pageLength: 10
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            tooltipTriggerList.map(function (el) {
                return new bootstrap.Tooltip(el);
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            function initSidebarDropdown(menuId, submenuId, arrowId) {

                const menu = document.getElementById(menuId);
                const submenu = document.getElementById(submenuId);
                const arrow = document.getElementById(arrowId);

                if (!menu || !submenu || !arrow) return;

                // Auto open when submenu has active link
                if (submenu.querySelector('.active')) {
                    submenu.classList.add('show');
                    arrow.classList.add('rotate');
                }

                menu.addEventListener('click', function () {
                    submenu.classList.toggle('show');
                    arrow.classList.toggle('rotate');
                });
            }

            // Voucher
            initSidebarDropdown(
                'voucherMenu',
                'voucherSubmenu',
                'voucherArrow'
            );

            // Voucher Requests
            initSidebarDropdown(
                'voucherRequestMenu',
                'voucherRequestSubmenu',
                'voucherRequestArrow'
            );

        });
    </script>

</body>

</html>
