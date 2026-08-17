<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts & Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        @font-face {
            font-family: 'Cairo';
            src: url('{{ asset("fonts/Cairo-Regular.ttf") }}') format('truetype');
            font-weight: 400;
            font-style: normal;
        }
        @font-face {
            font-family: 'Cairo';
            src: url('{{ asset("fonts/Cairo-SemiBold.ttf") }}') format('truetype');
            font-weight: 600;
            font-style: normal;
        }
        @font-face {
            font-family: 'Cairo';
            src: url('{{ asset("fonts/Cairo-Bold.ttf") }}') format('truetype');
            font-weight: 700;
            font-style: normal;
        }

        html, body {
            height: 100%;
            font-family: 'Cairo', system-ui, -apple-system, sans-serif !important;
        }
        .form-control, .form-select, input[type="text"], input[type="email"], input[type="password"], textarea {
            direction: rtl;
            text-align: right;
        }
        #app {
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }
        .navbar {
            z-index: 1030;
            flex-shrink: 0;
        }
        .wrapper {
            display: flex;
            flex: 1;
            overflow: hidden;
        }
        .sidebar {
            width: 250px;
            overflow-y: auto;
            transition: all 0.3s ease-in-out;
            white-space: nowrap;
        }
        .sidebar.collapsed {
            margin-left: -250px;
        }
        .sidebar .nav-link {
            color: #495057;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }
        .sidebar .nav-link:hover:not(.active) {
            background-color: #f1f3f5;
            color: #0d6efd;
        }
        .sidebar .nav-link.active {
            box-shadow: 0 4px 6px -1px rgba(13, 110, 253, 0.25);
        }
        .sidebar .btn-logout:hover {
            background-color: #fca5a5 !important;
            transition: background-color 0.2s ease;
        }
        .main-content {
            flex: 1;
            overflow-y: auto;
            background-color: #f4f6f9;
        }
        #sidebarToggle {
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        #sidebarToggle:hover {
            opacity: 0.7;
        }

        /* Modern Dashboard Component Styles */
        .custom-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #cbd5e1;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        .custom-card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #cbd5e1;
            padding: 16px 20px;
        }
        .custom-table-container {
            padding: 16px;
        }
        .custom-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 0;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }
        .custom-table thead th {
            background-color: #edf2f7 !important; /* Distinct column header background color */
            color: #1e293b !important;
            font-size: 0.825rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-bottom: 2px solid #cbd5e1 !important;
            padding: 14px 16px;
        }
        .custom-table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #e2e8f0 !important; /* Clear, visible divider line */
            color: #1e293b;
            font-size: 0.875rem;
            background-color: #ffffff;
        }
        .custom-table tbody tr:hover td {
            background-color: #f8fafc;
        }
        .custom-table tbody tr:last-child td {
            border-bottom: none !important;
        }
        .search-box {
            position: relative;
            width: 260px;
        }
        .search-box input {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 6px 36px 6px 12px;
            font-size: 0.85rem;
            width: 100%;
            transition: all 0.2s ease;
        }
        .search-box input:focus {
            background-color: #ffffff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }
        .search-box i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
            pointer-events: none;
        }
        /* Flatpickr Custom Styling matching design mockup */
        .flatpickr-calendar {
            border-radius: 12px !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
            border: 1px solid #cbd5e1 !important;
            font-family: inherit !important;
            padding: 8px !important;
            background: #ffffff !important;
        }
        .flatpickr-months {
            align-items: center !important;
        }
        .flatpickr-current-month {
            font-size: 100% !important;
            font-weight: 600 !important;
            color: #1e293b !important;
        }
        .flatpickr-day {
            border-radius: 50% !important;
            color: #334155 !important;
            font-weight: 500 !important;
        }
        .flatpickr-day.selected, .flatpickr-day.selected:hover {
            background: #3b82f6 !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
        }
        .flatpickr-day.today {
            border: 1px solid #cbd5e1 !important;
            background: #f1f5f9 !important;
        }
        .flatpickr-day:hover {
            background: #e2e8f0 !important;
        }
        .flatpickr-weekday {
            color: #64748b !important;
            font-weight: 700 !important;
            font-size: 80% !important;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid px-3">
                @auth
                    <button id="sidebarToggle" class="btn btn-link link-dark p-0 me-3 text-decoration-none border-0" type="button" title="Toggle Sidebar">
                        <i class="bi bi-list fs-3"></i>
                    </button>
                @endauth

                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="wrapper">
            @auth
                @include('layouts.sidebar')
            @endauth
            
            <main class="main-content py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            
            if (sidebarToggle && sidebar) {
                // Restore state from localStorage if available
                if (localStorage.getItem('sidebar_collapsed') === 'true') {
                    sidebar.classList.add('collapsed');
                }

                sidebarToggle.addEventListener('click', function () {
                    sidebar.classList.toggle('collapsed');
                    localStorage.setItem('sidebar_collapsed', sidebar.classList.contains('collapsed'));
                });
            }

            // Table Live Search
            const searchInputs = document.querySelectorAll('.table-search-input');
            searchInputs.forEach(input => {
                input.addEventListener('keyup', function() {
                    const term = this.value.toLowerCase();
                    const card = this.closest('.card');
                    if (card) {
                        const tbody = card.querySelector('table tbody');
                        if (tbody) {
                            const rows = tbody.querySelectorAll('tr');
                            let hasVisible = false;
                            rows.forEach(row => {
                                // Skip empty state rows
                                if (row.querySelector('td[colspan]')) return;
                                
                                const text = row.textContent.toLowerCase();
                                if (text.includes(term)) {
                                    row.style.display = '';
                                }
                            });
                        }
                    }
                });
            });

            // Flatpickr Date Picker Initialization
            if (typeof flatpickr !== 'undefined') {
                flatpickr('.datepicker, .flatpickr-date, input[type="date"]', {
                    dateFormat: "Y-m-d",
                    allowInput: true,
                    disableMobile: "true"
                });
            }
        });
    </script>
</body>
</html>
