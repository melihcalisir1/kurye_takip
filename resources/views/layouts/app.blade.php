<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Restoran Paneli') | Kurye Takip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: #f4f6fb;
        }
        .sidebar {
            min-height: 100vh;
            background: #22223b;
            color: #fff;
            padding: 2rem 1rem 1rem 1rem;
            position: fixed;
            left: 0;
            top: 0;
            width: 220px;
            z-index: 100;
            box-shadow: 2px 0 12px rgba(44,62,80,0.07);
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }
        .sidebar .sidebar-title {
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 2.2rem;
            letter-spacing: 1px;
            text-align: center;
            color: #f2e9e4;
        }
        .sidebar .nav-link {
            color: #f2e9e4;
            font-weight: 600;
            font-size: 1.08rem;
            margin-bottom: 1.1rem;
            border-radius: 8px;
            padding: 0.7rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            transition: background 0.18s, color 0.18s;
            border: none;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: linear-gradient(90deg, #4f8a8b 0%, #08d9d6 100%);
            color: #fff;
            box-shadow: 0 2px 8px rgba(8,217,214,0.08);
        }
        .sidebar .nav-link i {
            min-width: 22px;
            text-align: center;
            font-size: 1.15rem;
        }
        .sidebar .logout-link {
            margin-top: auto;
            color: #e07a5f;
            opacity: 0.85;
            font-weight: 600;
            border-radius: 8px;
        }
        .sidebar .logout-link:hover {
            opacity: 1;
            background: rgba(224,122,95,0.13);
            color: #fff;
        }
        .main-content {
            margin-left: 220px;
            padding: 2.5rem 2rem 1.5rem 2rem;
            min-height: 100vh;
            background: #f4f6fb;
        }
        @media (max-width: 900px) {
            .sidebar {
                width: 60px;
                padding: 1.2rem 0.3rem;
            }
            .sidebar .sidebar-title, .sidebar .nav-link span {
                display: none;
            }
            .main-content {
                margin-left: 60px;
                padding: 1.2rem 0.5rem;
            }
            .sidebar .nav-link {
                justify-content: center;
                padding: 0.7rem 0.5rem;
            }
        }
        .sidebar .nav-link.btn {
            background: linear-gradient(90deg, #08d9d6 0%, #4f8a8b 100%);
            color: #fff;
            font-weight: 700;
            margin: 0 0 0.5rem 0;
            box-shadow: 0 2px 8px rgba(8,217,214,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0.7rem 1rem;
            font-size: 1.08rem;
            border-radius: 8px;
        }
        .sidebar .nav-link.btn:hover {
            background: linear-gradient(90deg, #4f8a8b 0%, #08d9d6 100%);
            color: #fff;
        }
        .sidebar .nav-link.btn.active,
        .sidebar .nav-link.btn:focus {
            background: linear-gradient(90deg, #4f8a8b 0%, #08d9d6 100%);
            color: #fff;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-title">
            <i class="fas fa-store me-2"></i> Restoran
        </div>
        <a href="{{ route('restaurant.dashboard') }}" class="nav-link{{ request()->routeIs('restaurant.dashboard') ? ' active' : '' }}">
            <i class="fas fa-chart-line"></i> <span>Dashboard</span>
        </a>
        <a href="{{ route('restaurant.menus') }}" class="nav-link{{ request()->routeIs('restaurant.menus') ? ' active' : '' }}">
            <i class="fas fa-utensils"></i> <span>Menüler</span>
        </a>
        <a href="{{ route('restaurant.couriers.index') }}" class="nav-link{{ request()->routeIs('restaurant.couriers.*') ? ' active' : '' }}">
            <i class="fas fa-motorcycle"></i> <span>Kuryelerim</span>
        </a>
        @if(auth()->check() && auth()->user()->hasRole('restaurant'))
            <a class="nav-link{{ (request()->routeIs('restaurant.orders') || request()->routeIs('restaurant.orders.show')) ? ' active' : '' }}"
                href="{{ route('restaurant.orders') }}">
                <i class="fas fa-shopping-cart"></i> <span>Siparişler</span>
            </a>
            <a class="nav-link{{ request()->routeIs('restaurant.orders.create') ? ' btn btn-primary text-white' : '' }}"
                href="{{ route('restaurant.orders.create') }}">
                <i class="fas fa-plus"></i> <span>Yeni Sipariş</span>
            </a>
            <a href="{{ route('restaurant.profile.show') }}" class="nav-link{{ request()->routeIs('restaurant.profile.show') ? ' active' : '' }}">
            <i class="fas fa-user"></i> <span>Profilim</span>
        </a>
        @endif
        <a href="{{ route('logout') }}" class="nav-link logout-link">
            <i class="fas fa-sign-out-alt"></i> <span>Çıkış</span>
        </a>
    </div>
    <div class="main-content">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html> 