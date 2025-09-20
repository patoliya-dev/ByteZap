<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Attendance System')</title>

    {{-- Bootstrap 5 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Attendance System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                @auth
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('attendance-dashboard') ? 'active' : '' }}"
                           href="{{ route('register.form') }}">
                           Add User
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('attendance.data') ? 'active' : '' }}"
                           href="{{ route('attendance.data') }}">
                           Attendances
                        </a>
                    </li>
                </ul>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="container">
        @yield('content')
    </main>

    {{-- Footer --}}
    {{-- <footer class="bg-dark text-white text-center py-3 mt-5">
        <small>© {{ date('Y') }} Attendance System</small>
    </footer> --}}

    {{-- Bootstrap JS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/attendance-export.js') }}"></script>
</body>
</html>
