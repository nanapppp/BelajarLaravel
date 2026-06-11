<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CRUD App - Aplikasi Manajemen Produk')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #68d391;
            --warning-color: #f6ad55;
            --danger-color: #f56565;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; }
        
        body {
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        /* ── Navbar ── */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,.1);
            padding: 1rem 0;
        }
        .navbar-brand { font-weight: 700; font-size: 1.5rem; color: white !important; }
        .nav-link { color: rgba(255,255,255,.85) !important; font-weight: 500; margin: 0 .5rem; transition: all .3s; }
        .nav-link:hover { color: white !important; transform: translateY(-2px); }

        /* User Avatar */
        .user-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: rgba(255,255,255,.25);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .85rem;
            border: 2px solid rgba(255,255,255,.5);
            color: white; flex-shrink: 0; transition: all .3s;
        }
        .nav-item.dropdown:hover .user-avatar { background: rgba(255,255,255,.35); border-color: white; }

        /* Dropdown */
        .dropdown-menu {
            border: none; border-radius: .75rem;
            box-shadow: 0 10px 30px rgba(0,0,0,.15);
            min-width: 230px; margin-top: .75rem !important;
            overflow: hidden; animation: dropdownFade .2s ease;
        }
        @keyframes dropdownFade {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .dropdown-user-info {
            padding: .85rem 1rem;
            background: linear-gradient(135deg, #f0f4ff 0%, #f8f0ff 100%);
            border-bottom: 1px solid #e9ecef;
        }
        .dropdown-user-info .user-name  { font-weight: 700; color: #2d3748; font-size: .95rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .dropdown-user-info .user-email { font-size: .78rem; color: #718096; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .dropdown-user-info .user-role  {
            display: inline-block; margin-top: .35rem;
            font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em;
            padding: .18rem .55rem; border-radius: 99px;
        }
        .role-admin  { background: #fed7e2; color: #97266d; }
        .role-member { background: #c6f6d5; color: #276749; }

        .dropdown-item {
            padding: .65rem 1rem; font-weight: 500; color: #4a5568;
            transition: all .2s; display: flex; align-items: center; gap: .6rem;
        }
        .dropdown-item:hover { background-color: #f0f4ff; color: var(--primary-color); }
        .dropdown-item.text-danger { color: var(--danger-color) !important; }
        .dropdown-item.text-danger:hover { background-color: #fff5f5; color: #c53030 !important; }
        .dropdown-item i { width: 16px; text-align: center; }

        /* Login/Register buttons */
        .btn-login-nav {
            background: rgba(255,255,255,.2);
            border: 1.5px solid rgba(255,255,255,.5);
            border-radius: .5rem; color: white !important;
            padding: .4rem 1rem !important; font-size: .9rem; transition: all .3s;
        }
        .btn-login-nav:hover { background: rgba(255,255,255,.35) !important; border-color: white !important; transform: translateY(-1px); }

        /* Main */
        main { flex: 1; padding: 2rem 0; }
        .container { max-width: 1200px; }

        /* Cards */
        .card { border: none; border-radius: .75rem; transition: all .3s; }
        .card:hover { box-shadow: 0 10px 30px rgba(0,0,0,.1); }

        /* Buttons */
        .btn { border-radius: .5rem; font-weight: 600; padding: .6rem 1.5rem; transition: all .3s; }
        .btn-primary { background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); border: none; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102,126,234,.4); }
        .btn-success { background-color: var(--success-color); border: none; }
        .btn-success:hover { background-color: #56c787; transform: translateY(-2px); }
        .btn-warning { background-color: var(--warning-color); border: none; color: white; }
        .btn-info    { background-color: #4299e1; border: none; }

        /* Badges, Alerts, Table */
        .badge { padding: .5rem .75rem; font-weight: 600; border-radius: .5rem; }
        .alert { border-radius: .75rem; border: none; }
        .alert-success { background-color: rgba(104,211,145,.1); color: #2d5a3d; }
        .alert-danger  { background-color: rgba(245,101,101,.1); color: #5a2d2d; }
        .alert-info    { background-color: rgba(66,153,225,.1);  color: #2d4a5a; }
        .table { background-color: white; }
        .table thead { background-color: #f8f9fa; }
        .table-hover tbody tr:hover { background-color: #f8f9fa; }

        /* Footer */
        footer {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white; padding: 2rem 0; margin-top: auto;
        }
        footer a { color: rgba(255,255,255,.85); text-decoration: none; transition: all .3s; }
        footer a:hover { color: white; }

        @media (max-width: 768px) {
            .navbar-brand { font-size: 1.25rem; }
            .display-4 { font-size: 2rem !important; }
            main { padding: 1rem 0; }
            .dropdown-menu { margin-top: .25rem !important; }
        }

        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: var(--primary-color); border-radius: 5px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--secondary-color); }
    </style>
</head>
<body>

<!-- ════════════════════════════════════ NAVBAR ════════════════════════════════════ -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-cube"></i> 00's love
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navba r-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">

                {{-- ═══ TAMU ═══ --}}
                @guest
                    <li class="nav-item">
                        <a class="nav-link btn-login-nav" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="nav-link btn-login-nav" href="{{ route('register') }}">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    </li>
                @endguest

                {{-- ═══ SUDAH LOGIN ═══ --}}
                @auth

                    {{-- ── MEMBER ── --}}
                    @if(auth()->user()->role == 'member')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">
                                <i class="fas fa-home"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">
                                <i class="fas fa-box"></i> Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart"></i> Cart
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.index') }}">
                                <i class="fas fa-receipt"></i> Order
                            </a>
                        </li>
                    @endif

                    {{-- ── ADMIN ── --}}
                    @if(auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">
                                <i class="fas fa-box"></i> Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('category.index') }}">
                                <i class="fas fa-folder"></i> Kategori
                            </a>
                        </li>
                        {{-- Admin bisa lihat semua order --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.index') }}">
                                <i class="fas fa-list-alt"></i> Semua Order
                            </a>
                        </li>
                    @endif

                    {{-- ── DROPDOWN USER ── --}}
                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                           href="#" data-bs-toggle="dropdown">
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">

                            {{-- Info Singkat User --}}
                            <li>
                                <div class="dropdown-user-info">
                                    <div class="user-name">{{ auth()->user()->name }}</div>
                                    <div class="user-email">{{ auth()->user()->email }}</div>
                                    <span class="user-role {{ auth()->user()->role == 'admin' ? 'role-admin' : 'role-member' }}">
                                        <i class="fas {{ auth()->user()->role == 'admin' ? 'fa-shield-alt' : 'fa-user' }} me-1"></i>
                                        {{ ucfirst(auth()->user()->role) }}
                                    </span>
                                </div>
                            </li>

                            <li><hr class="dropdown-divider m-0"></li>

                            {{-- Profil Saya --}}
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="fas fa-user-circle"></i> Profil Saya
                                </a>
                            </li>

                            {{-- Riwayat Order (member) --}}
                            @if(auth()->user()->role == 'member')
                            <li>
                                <a class="dropdown-item" href="{{ route('orders.index') }}">
                                    <i class="fas fa-receipt"></i> Riwayat Order
                                </a>
                            </li>
                            @endif

                            <li><hr class="dropdown-divider m-0"></li>

                            {{-- Logout --}}
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>

                        </ul>
                    </li>

                @endauth

            </ul>
        </div>
    </div>
</nav>

<!-- ════════════════════════════════════ CONTENT ════════════════════════════════════ -->
<main>
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<!-- ════════════════════════════════════ FOOTER ════════════════════════════════════ -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5 class="fw-bold mb-2"><i class="fas fa-cube me-2"></i>00's love</h5>
                <p class="mb-0" style="color: rgba(255,255,255,.75);">
                    Aplikasi manajemen produk dan kategori yang mudah digunakan dengan fitur lengkap CRUD.
                </p>
            </div>
            <div class="col-md-6 text-md-end text-center mt-4 mt-md-0">
                <p class="mb-2"><strong>Quick Links:</strong></p>
                <div>
                    <a href="{{ route('products.index') }}" class="me-3">Produk</a>
                    <a href="{{ route('category.index') }}" class="me-3">Kategori</a>
                    <a href="{{ route('products.create') }}">Tambah Produk</a>
                </div>
            </div>
        </div>
        <hr class="my-4" style="border-color: rgba(255,255,255,.2);">
        <div class="text-center" style="color: rgba(255,255,255,.65); font-size: .875rem;">
            &copy; {{ date('Y') }} Nanap Shop. All rights reserved.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>