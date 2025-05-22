<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Kurye Takip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: #f8f9fa;
        }
        .admin-header {
            background: linear-gradient(135deg, #007AFF 0%, #00C6FB 100%);
            padding: 1rem 2rem;
            color: white;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        .admin-title {
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0;
        }
        .admin-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .admin-name {
            font-weight: 600;
            font-size: 1rem;
        }
        .logout-btn {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            background: rgba(255,255,255,0.1);
            transition: all 0.3s;
        }
        .logout-btn:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .content-container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .page-title {
            font-weight: 700;
            font-size: 1.8rem;
            color: #2c3e50;
            margin-bottom: 2rem;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .stat-title {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .stat-value {
            font-weight: 700;
            font-size: 1.8rem;
            color: #2c3e50;
            margin: 0;
        }
        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        .action-btn {
            background: white;
            border: none;
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
            color: #2c3e50;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .action-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            color: #2c3e50;
        }
        .action-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        .restaurant-icon {
            background: linear-gradient(135deg, #4CAF50 0%, #8BC34A 100%);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Admin Header -->
    <header class="admin-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="admin-title">Admin Panel</h1>
                <div class="admin-info">
                    <div class="admin-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="admin-name">Admin</span>
                    <a href="{{ route('logout') }}" class="logout-btn">
                        <i class="fas fa-sign-out-alt me-2"></i>Çıkış
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Content -->
    <div class="content-container">
        <h2 class="page-title">Dashboard</h2>

        <!-- İstatistikler -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #4CAF50 0%, #8BC34A 100%); color: white;">
                    <i class="fas fa-store"></i>
                </div>
                <div class="stat-title">Toplam Restoran</div>
                <p class="stat-value">{{ $stats['totalRestaurants'] }}</p>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #007AFF 0%, #00C6FB 100%); color: white;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-title">Aktif Restoran</div>
                <p class="stat-value">{{ $stats['activeRestaurants'] }}</p>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #FF6B6B 0%, #FF8E8E 100%); color: white;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-title">Pasif Restoran</div>
                <p class="stat-value">{{ $stats['inactiveRestaurants'] }}</p>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #9C27B0 0%, #E040FB 100%); color: white;">
                    <i class="fas fa-motorcycle"></i>
                </div>
                <div class="stat-title">Toplam Kurye</div>
                <p class="stat-value">{{ $stats['totalCouriers'] }}</p>
            </div>
        </div>

        <!-- Hızlı İşlemler -->
        <div class="action-buttons">
            <a href="{{ route('admin.restaurants') }}" class="action-btn">
                <div class="action-icon restaurant-icon">
                    <i class="fas fa-store"></i>
                </div>
                <div>
                    <div style="font-size: 0.9rem; color: #6c757d;">Restoran Yönetimi</div>
                    <div>Restoranları ve Kuryeleri Yönet</div>
                </div>
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 