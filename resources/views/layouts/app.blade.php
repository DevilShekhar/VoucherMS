<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Admin') }}</title>

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap 5 CSS for modal -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* public/css/custom.css */

        /* ---------- Premium Luxury Admin Theme ---------- */
        :root {
            --paper: #FBF8F3;
            --cloth: #F5EDE0;
            --card: #FFFFFF;
            --ink: #1A1410;
            --ink-soft: #6B5D4E;
            --line: #E5D9C8;
            --ember: #C8963E;
            --ember-dark: #A87D30;
            --ember-soft: #F5EDE0;
            --sage: #8B7A5A;
            --sage-bg: #F0E8D8;
            --rust: #C0392B;
            --rust-bg: #FDE8E5;
            --sidebar-bg: #1A1410;
            --sidebar-ink: #F5EDE0;
            --sidebar-soft: #B8A68C;
            --sidebar-hover: #2A2118;
            --shadow: 0 4px 20px rgba(26, 20, 16, 0.08);
            --dropdown-shadow: 0 10px 40px rgba(26, 20, 16, 0.15);
            --radius: 12px;
            --gold-gradient: linear-gradient(135deg, #C8963E 0%, #E8C97A 50%, #C8963E 100%);
            --gold-glow: 0 4px 20px rgba(200, 150, 62, 0.3);
        }

        html[data-theme="dark"] {
            --paper: #1A1410;
            --cloth: #2A2118;
            --card: #241D16;
            --ink: #F5EDE0;
            --ink-soft: #B8A68C;
            --line: #3D3228;
            --ember: #D4A84A;
            --ember-dark: #C8963E;
            --ember-soft: #2A2118;
            --sage: #A89070;
            --sage-bg: #2A2118;
            --rust: #E85A4A;
            --rust-bg: #3D1A14;
            --sidebar-bg: #0D0A08;
            --sidebar-ink: #F5EDE0;
            --sidebar-soft: #B8A68C;
            --sidebar-hover: #1A1410;
            --shadow: 0 4px 24px rgba(0, 0, 0, .5);
            --dropdown-shadow: 0 10px 40px rgba(0, 0, 0, .6);
            --gold-gradient: linear-gradient(135deg, #D4A84A 0%, #E8C97A 50%, #D4A84A 100%);
            --gold-glow: 0 4px 20px rgba(212, 168, 74, 0.2);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--paper);
            color: var(--ink);
            transition: background .35s ease, color .35s ease;
        }

        /* ---------- Scrollbar Styling ---------- */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--cloth);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--ember);
            border-radius: 99px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--ember-dark);
        }

        /* ---------- Sidebar ---------- */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            background: #FDFCF8;
            color: var(--sidebar-ink);
            display: flex;
            flex-direction: column;
            transition: width .3s ease, background .35s ease, transform .3s ease;
            z-index: 40;
            border-right: 1px solid var(--line);
            box-shadow: var(--shadow);
        }

        .sidebar-icon {
            color: #d4af37;
            /* Gold */
        }

        .sidebar-icon:hover {
            color: #f4c542;
        }

        .sidebar.collapsed {
            width: 72px;
        }

        .sb-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 24px 20px;
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 20px;
            white-space: nowrap;
            overflow: hidden;
            color: var(--sidebar-ink);
            border-bottom: 1px solid var(--line);
            color: black;
        }

        .sb-brand .dot {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--gold-gradient);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #1A1410;
            box-shadow: var(--gold-glow);
        }

        .sb-brand span.label {
            opacity: 1;
            transition: opacity .2s ease;
        }

        .sidebar.collapsed .sb-brand span.label {
            opacity: 0;
            width: 0;
        }

        .sb-brand .brand-sub {
            font-size: 10px;
            font-weight: 400;
            opacity: 0.6;
            display: block;
            font-family: 'Inter', sans-serif;
        }

        .sb-section {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10px;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--sidebar-soft);
            padding: 20px 20px 8px;
            white-space: nowrap;
            overflow: hidden;
            font-weight: 600;
        }

        .sidebar.collapsed .sb-section {
            opacity: 0;
            height: 10px;
            padding-top: 0;
            padding-bottom: 0;
        }

        .sb-nav {
            list-style: none;
            margin: 0;
            padding: 0 12px;
            margin-bottom: 2rem;
            flex: 1;
            overflow-y: auto;
        }

        .sb-nav li {
            margin-bottom: 2px;
        }

        .sb-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 10px;
            color: var(--sidebar-soft);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            position: relative;
            transition: all 0.25s ease;
            color: #2C2218;
        }

        .sb-link i {
            width: 20px;
            text-align: center;
            font-size: 15px;
            flex-shrink: 0;
            transition: transform 0.25s ease;
            color: #d4af37;
        }

        .sb-link:hover {
            background: #F5E6A8;
            /* Soft Golden */
            color: #8B6B00;
            /* Dark Golden */
            transform: translateX(4px);
        }

        .sb-link:hover i {
            transform: scale(1.1);
        }

        .sb-link.active {
            background: var(--gold-gradient);
            color: #1A1410;
            font-weight: 600;
            box-shadow: var(--gold-glow);
        }

        .sb-link.active i {
            color: #1A1410;
        }

        .sb-link .badge-pill {
            margin-left: auto;
            background: var(--rust);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 99px;
            font-family: 'IBM Plex Mono', monospace;
            transition: transform 0.25s ease;
        }

        .sb-link:hover .badge-pill {
            transform: scale(1.05);
        }

        .sidebar.collapsed .sb-link span,
        .sidebar.collapsed .sb-link .badge-pill {
            display: none;
        }

        .sb-foot {
            padding: 16px 20px;
            border-top: 1px solid var(--line);
            display: flex;
            align-items: center;
            gap: 12px;
            white-space: nowrap;
            overflow: hidden;
            color: black;
        }

        .sb-foot .av {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--gold-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1A1410;
            font-weight: 700;
            flex-shrink: 0;
            font-size: 14px;
            box-shadow: var(--gold-glow);
        }

        .sb-foot .who {
            font-size: 13px;
            font-weight: 600;
            color: black;
        }

        .sb-foot .role {
            font-size: 11px;
            color: var(--sidebar-soft);
        }

        .sidebar.collapsed .sb-foot .txt {
            display: none;
        }

        /* ---------- Shell ---------- */
        .shell {
            margin-left: 250px;
            transition: margin-left .3s ease;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .shell.collapsed {
            margin-left: 72px;
        }

        /* ---------- Navbar ---------- */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 30;
            background: var(--card);
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 32px;
            transition: background .35s ease, border-color .35s ease, box-shadow .2s ease;
        }

        .navbar.scrolled {
            box-shadow: var(--shadow);
        }

        .nb-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .icon-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid var(--line);
            background: transparent;
            color: var(--ink-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .2s ease;
            flex-shrink: 0;
        }

        .icon-btn:hover {
            background: var(--cloth);
            color: var(--ember);
            transform: scale(1.05);
        }

        .crumb {
            font-size: 13px;
            color: var(--ink-soft);
        }

        .crumb b {
            color: var(--ink);
            font-weight: 600;
        }

        .crumb i {
            color: var(--ember);
        }

        .nb-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--cloth);
            border: 1px solid var(--line);
            border-radius: 99px;
            padding: 7px 16px;
            font-size: 13px;
            color: var(--ink-soft);
            width: 240px;
            transition: all .2s ease;
        }

        .search-box:focus-within {
            border-color: var(--ember);
            box-shadow: 0 0 0 3px rgba(200, 150, 62, 0.15);
        }

        .search-box input {
            border: none;
            background: none;
            outline: none;
            color: var(--ink);
            font-size: 13px;
            width: 100%;
            font-family: 'Inter', sans-serif;
        }

        .theme-switch {
            width: 52px;
            height: 28px;
            border-radius: 99px;
            background: var(--cloth);
            border: 1px solid var(--line);
            position: relative;
            cursor: pointer;
            flex-shrink: 0;
            transition: background .3s ease;
        }

        .theme-switch .knob {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: var(--gold-gradient);
            color: #1A1410;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            transition: transform .35s cubic-bezier(.4, 1.6, .5, 1), background .3s ease;
            box-shadow: var(--gold-glow);
        }

        html[data-theme="dark"] .theme-switch .knob {
            transform: translateX(24px);
        }

        .bell-wrap {
            position: relative;
        }

        .bell-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--rust);
            border: 2px solid var(--card);
        }

        /* ---------- User Dropdown ---------- */
        .profile-dropdown {
            position: relative;
            cursor: pointer;
        }

        .profile-trigger {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 12px 4px 4px;
            border-radius: 99px;
            border: 1px solid var(--line);
            background: var(--card);
            transition: all .2s ease;
        }

        .profile-trigger:hover {
            border-color: var(--ember);
            background: var(--cloth);
        }

        .profile-trigger .av {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--gold-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1A1410;
            font-weight: 700;
            font-size: 13px;
            box-shadow: var(--gold-glow);
        }

        .profile-trigger .info {
            display: flex;
            flex-direction: column;
            line-height: 1.3;
        }

        .profile-trigger .info .name {
            font-size: 13px;
            font-weight: 600;
            color: var(--ink);
        }

        .profile-trigger .info .role-label {
            font-size: 11px;
            color: var(--ink-soft);
        }

        .profile-trigger .chevron {
            color: var(--ink-soft);
            font-size: 12px;
            transition: transform .3s ease;
            margin-left: 4px;
        }

        .profile-dropdown.active .chevron {
            transform: rotate(180deg);
        }

        .dropdown-menu-custom {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            min-width: 260px;
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--dropdown-shadow);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all .3s ease;
            z-index: 50;
            overflow: hidden;
        }

        .profile-dropdown.active .dropdown-menu-custom {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-header-custom {
            padding: 16px 20px;
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dropdown-header-custom .av-lg {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--gold-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1A1410;
            font-weight: 700;
            font-size: 16px;
            flex-shrink: 0;
            box-shadow: var(--gold-glow);
        }

        .dropdown-header-custom .info h4 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            color: var(--ink);
        }

        .dropdown-header-custom .info p {
            margin: 2px 0 0;
            font-size: 12px;
            color: var(--ink-soft);
        }

        .dropdown-divider {
            height: 1px;
            background: var(--line);
            margin: 4px 0;
        }

        .dropdown-item-custom {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            color: var(--ink);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all .2s ease;
            border: none;
            background: none;
            width: 100%;
            cursor: pointer;
        }

        .dropdown-item-custom:hover {
            background: var(--sidebar-hover);
            color: var(--ember);
        }

        .dropdown-item-custom i {
            width: 18px;
            color: var(--ink-soft);
            font-size: 14px;
        }

        .dropdown-item-custom:hover i {
            color: var(--ember);
        }

        .dropdown-item-custom.text-danger {
            color: var(--rust);
        }

        .dropdown-item-custom.text-danger:hover {
            background: var(--rust-bg);
            color: var(--rust);
        }

        .dropdown-item-custom.text-danger i {
            color: var(--rust);
        }

        .dropdown-item-custom .badge-pill {
            margin-left: auto;
            background: var(--rust);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 99px;
            font-family: 'IBM Plex Mono', monospace;
        }

        /* ---------- Main Content Styles ---------- */
        main {
            flex: 1;
            padding: 32px 32px;
        }

        /* Custom styles for management */
        .premium-dashboard {
            padding: 20px 0;
        }

        .pt-0 {
            padding-top: 0 !important;
        }

        .premium-floating-header {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 24px 28px;
            margin-bottom: 24px;
            box-shadow: var(--shadow);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-icon {
            width: 48px;
            height: 30px;
            border-radius: var(--radius);
            background: var(--gold-gradient);
            color: #1A1410;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: var(--gold-glow);
        }

        .header-badge {
            display: inline-block;
            background: var(--ember-soft);
            color: var(--ember-dark);
            font-size: 11px;
            font-weight: 600;
            padding: 2px 12px;
            border-radius: 99px;
            text-transform: uppercase;
            letter-spacing: .03em;
        }

        .header-left h2 {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 24px;
            margin: 4px 0 2px;
        }

        .header-left p {
            color: var(--ink-soft);
            font-size: 13px;
            margin: 0;
        }

        .premium-head-actions .btn {
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .2s ease;
            text-decoration: none;
        }

        .btn-create {
            background: var(--gold-gradient);
            color: #1A1410;
            border: none;
            box-shadow: var(--gold-glow);
        }

        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(200, 150, 62, 0.4);
            color: #1A1410;
        }

        .premium-block {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .card-body {
            padding: 20px;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .table th {
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--ink-soft);
            font-family: 'IBM Plex Mono', monospace;
            padding: 14px 16px;
            border-bottom: 2px solid var(--line);
            font-weight: 600;
        }

        .table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--line);
            vertical-align: middle;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .table tr:hover td {
            background: var(--cloth);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background: rgba(0, 0, 0, .02);
        }

        .table-hover tbody tr:hover {
            background: var(--cloth);
        }

        .badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge.bg-success {
            background: var(--sage-bg);
            color: white;
        }

        .badge.bg-danger {
            background: var(--rust-bg);
            color: var(--rust);
        }

        .badge.text-white {
            color: #fff;
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 11px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
            transition: all .2s ease;
        }

        .btn-primary {
            background: var(--gold-gradient);
            color: #10131a;
            box-shadow: var(--gold-glow);
            border-color: #ffffff;
            border-radius: 10px;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(200, 150, 62, 0.35);
            color: #1A1410;
        }

        .btn-danger {
            background: var(--rust);
            color: #fff;
        }

        .btn-danger:hover {
            background: #A83226;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(192, 57, 43, 0.25);
        }

        .btn-success {
            background: var(--sage);
            color: #fff;
        }

        .btn-success:hover {
            background: #7A6A4A;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(139, 122, 90, 0.25);
        }

        .text-center {
            text-align: center;
        }

        .border {
            border: 1px solid var(--line);
        }

        .rounded {
            border-radius: 8px;
        }

        .bg-light {
            background: var(--cloth);
        }

        .p-3 {
            padding: 16px;
        }

        .mt-3 {
            margin-top: 16px;
        }

        .mb-2 {
            margin-bottom: 8px;
        }

        .col-md-3 {
            width: 25%;
            float: left;
            padding: 0 8px;
        }

        .col-md-4 {
            width: 33.33%;
            float: left;
            padding: 0 8px;
        }

        .col-12 {
            width: 100%;
            clear: both;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -8px;
        }

        .row::after {
            content: '';
            clear: both;
            display: table;
        }

        label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            font-size: 13px;
        }

        label input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        /* Modal overrides for Bootstrap compatibility */
        .modal-content {
            background: var(--card) !important;
            border: 1px solid var(--line) !important;
            border-radius: var(--radius) !important;
        }

        .modal-header {
            border-bottom: 1px solid var(--line) !important;
        }

        .modal-footer {
            border-top: 1px solid var(--line) !important;
        }

        .modal-title {
            color: var(--ink) !important;
        }

        .modal-header .btn-close {
            filter: none !important;
            opacity: 0.6;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
        }

        .modal .btn-success {
            background: var(--gold-gradient) !important;
            color: #1A1410 !important;
            border: none !important;
            box-shadow: var(--gold-glow);
        }

        .modal .btn-success:hover {
            box-shadow: 0 4px 16px rgba(200, 150, 62, 0.35);
        }

        .delete-form {
            display: inline;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ---------- Footer ---------- */
        footer {
            border-top: 1px solid var(--line);
            padding: 18px 32px;
            margin-top: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 12.5px;
            color: var(--ink-soft);
            transition: border-color .35s ease;
        }

        footer a {
            color: var(--ink-soft);
            text-decoration: none;
            margin-left: 20px;
            transition: color .2s ease;
        }

        footer a:hover {
            color: var(--ember);
        }

        footer i {
            color: var(--ember);
        }

        /* ---------- Mobile ---------- */
        .mobile-only {
            display: none;
        }

        @media (max-width:900px) {
            .sidebar {
                transform: translateX(-100%);
                width: 250px;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .shell,
            .shell.collapsed {
                margin-left: 0;
            }

            .search-box {
                display: none;
            }

            .mobile-only {
                display: flex;
            }

            .scrim {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .4);
                z-index: 35;
                opacity: 0;
                pointer-events: none;
                transition: opacity .3s ease;
            }

            .scrim.show {
                opacity: 1;
                pointer-events: auto;
            }

            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .premium-head-actions {
                width: 100%;
            }

            .premium-head-actions .btn {
                width: 100%;
                justify-content: center;
            }

            .col-md-3,
            .col-md-4 {
                width: 50%;
            }

            .profile-trigger .info {
                display: none;
            }
        }

        @media (max-width:560px) {

            .col-md-3,
            .col-md-4 {
                width: 100%;
            }

            .table {
                font-size: 12px;
            }

            .table th:nth-child(3),
            .table td:nth-child(3) {
                display: none;
            }

            main {
                padding: 20px 16px;
            }

            .navbar {
                padding: 12px 16px;
            }
        }

        /* Utility classes for Laravel */
        .min-h-screen {
            min-height: 100vh;
        }

        .shadow {
            box-shadow: var(--shadow);
        }

        .bg-gray-100,
        .dark\:bg-gray-900 {
            background: transparent;
        }

        .max-w-7xl {
            max-width: 100%;
        }

        .mx-auto {
            margin: 0;
        }

        .py-6 {
            padding-top: 0;
            padding-bottom: 0;
        }

        .px-4 {
            padding-left: 0;
            padding-right: 0;
        }

        .sm\:px-6,
        .lg\:px-8 {
            padding-left: 0;
            padding-right: 0;
        }

        header.bg-white,
        .dark\:bg-gray-800 {
            background: transparent;
        }

        /* ---------- Ultra Minimal Scrollbar ---------- */
        ::-webkit-scrollbar {
            width: 3px;
            height: 3px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: transparent;
            border-radius: 99px;
            transition: background 0.3s ease;
        }

        *:hover::-webkit-scrollbar-thumb {
            background: var(--ember);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--ember-dark);
        }

        /* For Firefox */
        * {
            scrollbar-width: thin;
            scrollbar-color: transparent transparent;
        }

        *:hover {
            scrollbar-color: var(--ember) transparent;
        }

        /* Table scrollbar - show only on hover */
        .table-responsive::-webkit-scrollbar {
            width: 3px;
            height: 3px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: transparent;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: transparent;
            border-radius: 99px;
            transition: background 0.3s ease;
        }

        .table-responsive:hover::-webkit-scrollbar-thumb {
            background: var(--ember);
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: var(--ember-dark);
        }

        .avatar-placeholder {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fdee99, #edbd3a);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .colored-toast {
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.3);
        }

        .swal2-toast {
            border-radius: 12px !important;
        }

        .timeline {
            position: relative;
            padding-left: 20px;
        }

        .timeline:before {
            content: "";
            position: absolute;
            left: 8px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e5e5e5;
        }

        .timeline-item {
            position: relative;
            padding-left: 30px;
            margin-bottom: 25px;
        }

        .timeline-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            position: absolute;
            left: 2px;
            top: 5px;
            border: 3px solid #fff;
            box-shadow: 0 0 0 2px #d9a441;
        }

        .timeline-content h6 {
            font-weight: 600;
        }

        .timeline-content small {
            color: #777;
        }
    </style>
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

        <div class="sb-section">Main</div>
        <ul class="sb-nav text sidebar-icon">
            <li><a href="{{ route('dashboard') }}" class="sb-link"><i
                        class="fas fa-th-large"></i><span>Dashboard</span></a></li>
            <li><a href="#" class="sb-link"><i class="fas fa-star"></i><span>Feedback</span></a></li>
        </ul>

        <div class="sb-section">Management</div>
        <ul class="sb-nav">
            <li>
                <a href="{{ route('users.index') }}"
                    class="sb-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="fas fa-user-plus"></i>
                    <span>Manage Users</span>
                </a>
            </li>
            <li>
                <a href="{{ route('roles.index') }}"
                    class="sb-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                    <i class="fas fa-user-shield"></i>
                    <span>Manage Roles</span>
                </a>
            </li>
            {{-- <li>
                <a href="{{ route('permissions.index') }}"
                    class="sb-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                    <i class="fas fa-key"></i>
                    <span>Manage Permissions</span>
                </a>
            </li> --}}
        </ul>

        <div class="sb-section">Master Data</div>
        <ul class="sb-nav">
            <li>
                <a href="{{ route('voucher-vendors.index') }}"
                    class="sb-link {{ request()->routeIs('voucher-vendors.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    <span>Voucher Vendors</span>
                </a>
            </li>
            <li>
                <a href="{{ route('centers.index') }}"
                    class="sb-link {{ request()->routeIs('centers.*') ? 'active' : '' }}">
                    <i class="fas fa-store-alt"></i>
                    <span>Manage Centers</span>
                </a>
            </li>
            <li>
                <a href="{{ route('courses.index') }}"
                    class="sb-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span>Manage Courses</span>
                </a>
            </li>
            <li>
                <a href="{{ route('leads.index') }}"
                    class="sb-link {{ request()->routeIs('leads.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span>Manage Leads</span>
                </a>
            </li>
            <li>
                <a href="{{ route('candidates.index') }}"
                    class="sb-link {{ request()->routeIs('candidates.*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate"></i>
                    <span>Manage Candidates</span>
                </a>
            </li>
            <li>
                <a href="{{ route('payments.index') }}"
                    class="sb-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                    <i class="fas fa-money-check-alt"></i>
                    <span>Manage Payment</span>
                </a>
            </li>
            <li>
                <a href="{{ route('vouchers.index') }}"
                    class="sb-link {{ request()->routeIs('vouchers.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Manage Voucher</span>
                </a>
            </li>
            <li>
                <a href="{{ route('voucher-requests.index') }}"
                    class="sb-link {{ request()->routeIs('voucher-requests.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Manage VoucherRequests</span>
                </a>
            </li>
            <li>
                <a href="#" class="sb-link">
                    <i class="fas fa-users"></i>
                    <span>Students</span>
                </a>
            </li>
            <li>
                <a href="#" class="sb-link">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports</span>
                </a>
            </li>
        </ul>


        <div class="sb-section">System</div>
        <ul class="sb-nav">
            <li><a href="#" class="sb-link"><i class="fas fa-cog"></i><span>Settings</span></a></li>
            <li><a href="#" class="sb-link"><i class="fas fa-question-circle"></i><span>Help</span></a></li>
        </ul>

        <div class="sb-foot">
            <div class="av">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="txt">
                <div class="who">{{ Auth::user()->name ?? 'Admin User' }}</div>
                <div class="role">
                    {{ Auth::user()->roles->first()?->name ? ucwords(str_replace('_', ' ', Auth::user()->roles->first()->name)) : 'Administrator' }}
                </div>
            </div>
        </div>
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
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search anything...">
                </div>
                <div class="theme-switch" id="themeSwitch" title="Toggle theme">
                    <div class="knob" id="themeKnob"><i class="fas fa-sun"></i></div>
                </div>
                <div class="bell-wrap">
                    <button class="icon-btn"><i class="fas fa-bell"></i></button>
                    <span class="bell-dot"></span>
                </div>

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
                        <a href="#" class="dropdown-item-custom">
                            <i class="fas fa-cog"></i> Account Settings
                        </a>
                        <a href="#" class="dropdown-item-custom">
                            <i class="fas fa-envelope"></i> Messages
                            <span class="badge-pill"
                                style="margin-left:auto; background: var(--rust); color:#fff; font-size:10px; padding:2px 8px; border-radius:99px;">3</span>
                        </a>

                        <div class="dropdown-divider"></div>

                        <a href="#" class="dropdown-item-custom" id="helpLink">
                            <i class="fas fa-question-circle"></i> Help & Support
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
    <audio id="notificationSound" preload="auto">
        <source src="{{ asset('assets/sounds/notification.mp3') }}" type="audio/mpeg">
    </audio>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        let shownNotifications = [];
        const notificationAudio = document.getElementById('notificationSound');

        notificationAudio.loop = true;
        notificationAudio.volume = 1.0;

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

                        notificationAudio.play()
                            .then(() => {
                                notificationAudio.pause();
                                notificationAudio.currentTime = 0;
                            })
                            .catch((err) => {
                                console.log(err);
                            });

                    }

                });

            }

        });


        /* ============================================================
           Check Notification
        ============================================================ */

        function checkLeadNotifications() {

            fetch("{{ route('lead.notifications') }}")
                .then(response => response.json())
                .then(data => {

                    if (data.length === 0) {
                        return;
                    }

                    let notification = data[0];

                    if (shownNotifications.includes(notification.id)) {
                        return;
                    }

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

                                notificationAudio.play()
                                    .then(() => {
                                        console.log("Audio Playing");
                                    })
                                    .catch((err) => {
                                        console.log("Play Error", err);
                                    });

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
                        })
                            .then(() => {

                                window.location.href = "/leads/" + notification.lead_id;

                            });

                    });

                });

        }

        checkLeadNotifications();

        setInterval(checkLeadNotifications, 5000);

    </script>

    <script>

        function checkVoucherNotifications() {

            fetch("{{ route('voucher-request-notifications.latest') }}")
                .then(response => response.json())
                .then(data => {

                    if (data.length === 0) {
                        return;
                    }

                    let notification = data[0];

                    if (shownNotifications.includes('voucher-' + notification.id)) {
                        return;
                    }

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

                                notificationAudio.currentTime = 0;
                                notificationAudio.loop = true;

                                notificationAudio.play()
                                    .catch(err => console.log(err));

                            }

                        }

                    }).then(() => {

                        notificationAudio.pause();
                        notificationAudio.currentTime = 0;

                        fetch("/voucher-request-notifications/" + notification.id + "/read", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json"
                            }
                        })
                            .then(() => {

                                window.location.href =
                                    "/voucher-requests/" + notification.voucher_request_id;

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

</body>

</html>
