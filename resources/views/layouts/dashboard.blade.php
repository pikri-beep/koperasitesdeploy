<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Koperasi MP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    body {
        background-color: #f8f9fa;
    }

    .nav-link:hover {
        color: #dc3545 !important;
    }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
        <div class="container">
            <a class="navbar-brand fw-bold text-danger" href="{{ route('dashboard') }}">
                <i class="fas fa-university me-2"></i>KOPERASI MP
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/dashboard/cicilan">Cicilan</a></li>
                    <li class="nav-item"><a class="nav-link" href="/dashboard/modal">Modal</a></li>
                    <li class="nav-item"><a class="nav-link" href="/dashboard/penarikan">Penarikan</a></li>
                    <li class="nav-item"><a class="nav-link" href="/dashboard/pinjaman">Pinjaman</a></li>

                    <li class="nav-item d-none d-lg-block mx-2 text-secondary">|</li>

                    <li class="nav-item">
                        <a class="btn btn-danger btn-sm px-3 rounded-pill fw-bold" href="/">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>