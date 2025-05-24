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
            background: linear-gradient(135deg, #4CAF50 0%, #8BC34A 100%);
            color: white;
            padding: 2rem 1rem 1rem 1rem;
            position: fixed;
            left: 0;
            top: 0;
            width: 230px;
            z-index: 100;
            box-shadow: 2px 0 12px rgba(44,62,80,0.07);
        }
        .sidebar .sidebar-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 2.5rem;
            letter-spacing: 1px;
        }
        .sidebar .nav-link {
            color: white;
            font-weight: 600;
            font-size: 1.08rem;
            margin-bottom: 1.1rem;
            border-radius: 8px;
            padding: 0.7rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            transition: background 0.2s;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.18);
            color: #fff;
        }
        .sidebar .logout-link {
            margin-top: 2.5rem;
            color: #fff;
            opacity: 0.8;
        }
        .sidebar .logout-link:hover {
            opacity: 1;
            background: rgba(255,255,255,0.13);
        }
        .main-content {
            margin-left: 230px;
            padding: 2.5rem 2rem 1.5rem 2rem;
        }
        @media (max-width: 900px) {
            .sidebar {
                width: 70px;
                padding: 1.2rem 0.3rem;
            }
            .sidebar .sidebar-title, .sidebar .nav-link span {
                display: none;
            }
            .main-content {
                margin-left: 70px;
                padding: 1.2rem 0.5rem;
            }
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
        <a href="{{ isset($restaurant) ? route('admin.restaurants.couriers.index', $restaurant->id) : '#' }}" class="nav-link{{ request()->is('admin/restaurants/*/couriers') ? ' active' : '' }}">
            <i class="fas fa-motorcycle"></i> <span>Kuryelerim</span>
        </a>
        <a href="#" class="nav-link">
            <i class="fas fa-user"></i> <span>Profilim</span>
        </a>
        <a href="{{ route('logout') }}" class="nav-link logout-link">
            <i class="fas fa-sign-out-alt"></i> <span>Çıkış</span>
        </a>
        @if(auth()->check() && auth()->user()->hasRole('restaurant'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('restaurant.orders*') ? 'active' : '' }}" 
                    href="{{ route('restaurant.orders') }}">
                    <i class="fas fa-shopping-cart"></i> Siparişler
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link btn btn-primary text-white ms-2" 
                    href="{{ route('restaurant.orders.create') }}">
                    <i class="fas fa-plus"></i> Yeni Sipariş
                </a>
            </li>
        @endif
    </div>
    <div class="main-content">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html> 