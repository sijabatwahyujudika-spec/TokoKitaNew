<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tokokita')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fbff 0%, #eef6ff 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #12324a;
        }
        .page-shell {
            min-height: 100vh;
            padding: 24px 0 40px;
        }
        .glass-card {
            background: rgba(255,255,255,0.9);
            border: 1px solid rgba(18,50,74,0.08);
            box-shadow: 0 12px 35px rgba(18,50,74,0.12);
            border-radius: 20px;
        }
        .hero-title {
            font-size: 2rem;
            font-weight: 700;
        }
        .hero-subtitle {
            color: #5f7790;
            max-width: 700px;
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
        }
        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
        }
        .navbar-custom {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(18,50,74,0.08);
        }
        .footer-custom {
            background: #0f172a;
            color: #cbd5e1;
            padding: 24px 0;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-custom navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="/">Tokokita</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto gap-2">
                    <li class="nav-item"><a class="nav-link" href="/produk">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="/pesanan">Pesanan</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                        <form id="logout-form" action="/logout" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else
                        <li class="nav-item"><a class="btn btn-primary-custom btn-sm" href="/login">Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="page-shell">
        <div class="container py-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm" role="alert">
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="glass-card p-4 p-md-5">
                @yield('content')
            </div>
        </div>
    </div>

    <footer class="footer-custom">
        <div class="container text-center">
            <div class="fw-semibold">Tokokita</div>
            <small>Desain modern untuk pengalaman belanja dan manajemen produk yang lebih nyaman.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>