<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Bengkel Motor')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@2.2.2/css/dataTables.bootstrap5.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: linear-gradient(135deg, #1e1e2f 0%, #2d2d44 100%);
            padding: 0 1.5rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .topbar .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .topbar .navbar-brand i {
            font-size: 1.5rem;
            color: #a78bfa;
        }

        .topbar .nav-link {
            color: rgba(255,255,255,0.7);
            font-weight: 500;
            padding: 1rem 1rem;
            transition: all 0.2s;
            border-bottom: 3px solid transparent;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .topbar .nav-link:hover,
        .topbar .nav-link.active {
            color: #fff;
            border-bottom-color: #a78bfa;
            background: rgba(255,255,255,0.05);
        }

        .topbar .nav-link i {
            font-size: 1.1rem;
        }

        .topbar .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            padding: 0.5rem;
            min-width: 200px;
            margin-top: 0.5rem;
        }

        .topbar .dropdown-item {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #374151;
        }

        .topbar .dropdown-item:hover {
            background: #f3f0ff;
            color: #6d28d2;
        }

        .role-badge {
            font-size: 0.7rem;
            padding: 0.2rem 0.6rem;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-admin {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
        }

        .role-kasir {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: #fff;
        }

        .avatar-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #a78bfa, #7c3aed);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .main-wrapper {
            flex: 1;
            padding: 1.5rem;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .page-header p {
            color: #6b7280;
            margin: 0.25rem 0 0;
            font-size: 0.9rem;
        }

        .content-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            border: 1px solid #e5e7eb;
            padding: 1.5rem;
        }

        .table th {
            border-top: none;
            color: #6b7280;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            vertical-align: middle;
            color: #374151;
        }

        .btn-action {
            padding: 0.25rem 0.65rem;
            font-size: 0.8rem;
            border-radius: 6px;
        }

        .page-footer {
            text-align: center;
            padding: 1rem;
            color: #9ca3af;
            font-size: 0.8rem;
            border-top: 1px solid #e5e7eb;
            margin-top: auto;
        }

        .alert {
            border-radius: 12px;
            border: none;
        }

        @media (max-width: 991.98px) {
            .topbar .nav-link {
                border-bottom: none;
                padding: 0.6rem 1rem;
                border-radius: 8px;
            }
            .topbar .nav-link:hover,
            .topbar .nav-link.active {
                background: rgba(255,255,255,0.1);
                border-bottom: none;
            }
        }
    </style>
</head>
<body>
    <nav class="topbar navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('img/motor.svg') }}" alt="Motor" height="24">
                Bengkel Motor
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-grid-1x2-fill"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.pelanggan.*') ? 'active' : '' }}" href="{{ route('admin.pelanggan.index') }}">
                            <i class="bi bi-people-fill"></i> Pelanggan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.kendaraan.*') ? 'active' : '' }}" href="{{ route('admin.kendaraan.index') }}">
                            <i class="bi bi-truck-front-fill"></i> Kendaraan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.servis.*') ? 'active' : '' }}" href="{{ route('admin.servis.index') }}">
                            <i class="bi bi-tools"></i> Servis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.master-servis.*') ? 'active' : '' }}" href="{{ route('admin.master-servis.index') }}">
                            <i class="bi bi-box-seam-fill"></i> Paket Servis
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('sparepart.*') || request()->routeIs('kategori-barang.*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-boxes"></i> Inventory
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.kategori-barang.index') }}"><i class="bi bi-tags-fill"></i> Kategori Barang</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.sparepart.index') }}"><i class="bi bi-box-seam-fill"></i> Sparepart</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-file-earmark-bar-graph-fill"></i> Laporan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.laporan.keuangan') }}"><i class="bi bi-currency-dollar"></i> Keuangan</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.laporan.performa') }}"><i class="bi bi-speedometer2"></i> Performa Servis</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.laporan.stok') }}"><i class="bi bi-exclamation-triangle"></i> Stok Menipis</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.konten.*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-layout-text-window"></i> Konten Website
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.konten.fitur.index') }}"><i class="bi bi-star"></i> Fitur Layanan</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.konten.about.index') }}"><i class="bi bi-info-circle"></i> About</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.konten.gallery.index') }}"><i class="bi bi-images"></i> Galeri</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.konten.kontak.index') }}"><i class="bi bi-envelope"></i> Kontak</a></li>
                        </ul>
                    </li>
                    @if (Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            <i class="bi bi-shield-lock-fill"></i> Pengguna
                        </a>
                    </li>
                    @endif
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown" style="border-bottom: none;">
                            <span class="avatar-circle">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            <span>{{ Auth::user()->name }}</span>
                            <span class="role-badge {{ Auth::user()->role === 'admin' ? 'role-admin' : 'role-kasir' }}">
                                {{ Auth::user()->role }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="px-3 py-2 text-muted" style="font-size: 0.8rem;">
                                <i class="bi bi-shield-check me-1"></i>
                                Level {{ ucfirst(Auth::user()->role) }}
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item" type="submit">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-wrapper">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 py-2">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </div>

    <div class="page-footer">
        &copy; {{ date('Y') }} Bengkel Motor. All rights reserved.
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $.fn.dataTable.ext.errMode = 'none';
    </script>
    @stack('scripts')
</body>
</html>