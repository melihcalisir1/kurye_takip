<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kurye Paneli') | Kurye Takip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="manifest" href="/manifest.json">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="prototurk.com">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<link href="/pwa/img/iphone5_splash.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/pwa/img/iphone6_splash.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/pwa/img/iphoneplus_splash.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
<link href="/pwa/img/iphonex_splash.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
<link href="/pwa/img/ipad_splash.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/pwa/img/ipadpro1_splash.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/pwa/img/ipadpro2_splash.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link rel="apple-touch-icon" sizes="128x128" href="/pwa/img/128x128.png">
<link rel="apple-touch-icon-precomposed" sizes="128x128" href="/pwa/img/128x128.png">
<link rel="icon" sizes="192x192" href="/pwa/img/192x192.png">
<link rel="icon" sizes="128x128" href="/pwa/img/128x128.png">
<script>
        if ('serviceWorker' in navigator) {
        	window.addEventListener('load', function () {
        		navigator.serviceWorker.register('/sw.js?v=3');
        	});
        }
    </script>
    @laravelPWA

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: #f4f6fb;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #9C27B0 0%, #E040FB 100%);
            color: white;
            padding: 2rem 1rem 1rem 1rem;
            position: fixed;
            left: 0;
            top: 0;
            width: 220px;
            z-index: 100;
            box-shadow: 2px 0 12px rgba(44,62,80,0.07);
        }
        .sidebar .sidebar-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 2.2rem;
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
            margin-left: 220px;
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
            <i class="fas fa-motorcycle me-2"></i> Kurye
        </div>
        <a href="{{ route('courier.dashboard') }}" class="nav-link{{ request()->routeIs('courier.dashboard') ? ' active' : '' }}">
            <i class="fas fa-home"></i> <span>Dashboard</span>
        </a>
        <a href="{{ route('courier.orders.active') }}" class="nav-link{{ request()->routeIs('courier.orders.active') ? ' active' : '' }}">
            <i class="fas fa-list"></i> <span>Aktif Siparişler</span>
        </a>
        <a href="{{ route('courier.orders.delivered') }}" class="nav-link{{ request()->routeIs('courier.orders.delivered') ? ' active' : '' }}">
            <i class="fas fa-check"></i> <span>Teslim Edilenler</span>
        </a>
        <a href="{{ route('courier.profile') }}" class="nav-link{{ request()->routeIs('courier.profile') ? ' active' : '' }}">
            <i class="fas fa-user"></i> <span>Profilim</span>
        </a>
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