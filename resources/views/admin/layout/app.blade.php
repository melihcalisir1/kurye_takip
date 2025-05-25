<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 60%, #e0e7ff 100%);
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #232526 0%, #414345 100%);
            color: white;
            padding-top: 20px;
            box-shadow: 2px 0 18px 0 rgba(44,62,80,0.08);
            border-top-right-radius: 24px;
            border-bottom-right-radius: 24px;
        }
        .sidebar-header {
            padding: 28px 20px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            margin-bottom: 20px;
        }
        .sidebar-header h4 {
            font-weight: 800;
            font-size: 2rem;
            letter-spacing: 1px;
            color: #fff;
            margin: 0;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.85);
            padding: 13px 24px;
            margin: 7px 0;
            font-size: 1.13rem;
            font-weight: 600;
            border-radius: 10px;
            display: flex;
            align-items: center;
            transition: background 0.2s, color 0.2s;
        }
        .sidebar .nav-link i {
            font-size: 1.2rem;
            margin-right: 10px;
            transition: color 0.2s;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background: linear-gradient(90deg, #007AFF 0%, #00C6FB 100%);
        }
        .sidebar .nav-link.active {
            background: linear-gradient(90deg, #4CAF50 0%, #8BC34A 100%);
            color: #fff;
        }
        .sidebar .nav-link.active i {
            color: #fff;
        }
        .main-content {
            padding: 36px 32px 32px 32px;
            background: rgba(255,255,255,0.97);
            border-radius: 22px;
            min-height: 96vh;
            margin: 24px 0;
            box-shadow: 0 4px 32px rgba(44,62,80,0.08);
        }
        @media (max-width: 991px) {
            .sidebar {
                border-radius: 0;
                min-height: auto;
            }
            .main-content {
                border-radius: 0;
                margin: 0;
                padding: 18px 8px 18px 8px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="sidebar-header">
                    <h4>Admin Panel</h4>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                           href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.restaurants') ? 'active' : '' }}" 
                           href="{{ route('admin.restaurants') }}">
                            <i class="fas fa-utensils me-2"></i> Restoranlar
                        </a>
                    </li>
                    
                    <li class="nav-item mt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link border-0 bg-transparent text-white">
                                <i class="fas fa-sign-out-alt me-2"></i> Çıkış Yap
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html> 