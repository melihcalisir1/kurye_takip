<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurye Dashboard | Kurye Takip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: #f8f9fa;
        }
        .courier-header {
            background: linear-gradient(135deg, #9C27B0 0%, #E040FB 100%);
            padding: 1rem 2rem;
            color: white;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        .courier-title {
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0;
        }
        .courier-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .courier-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .courier-name {
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
        .status-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
        .status-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .status-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .status-title {
            font-weight: 600;
            font-size: 1.2rem;
            color: #2c3e50;
            margin: 0;
        }
        .status-info {
            color: #6c757d;
            margin-bottom: 1rem;
        }
        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .status-active {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .status-inactive {
            background: #ffebee;
            color: #c62828;
        }
        .restaurant-info {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .restaurant-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .restaurant-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4CAF50 0%, #8BC34A 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .restaurant-title {
            font-weight: 600;
            font-size: 1.2rem;
            color: #2c3e50;
            margin: 0;
        }
        .restaurant-details {
            color: #6c757d;
        }
    </style>
</head>
<body>
    <!-- Kurye Header -->
    <header class="courier-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="courier-title">Kurye Panel</h1>
                <div class="courier-info">
                    <div class="courier-avatar">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <span class="courier-name">{{ Auth::user()->name }}</span>
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

        <!-- Durum Kartı -->
        <div class="status-card">
            <div class="status-header">
                <div class="status-icon" style="background: linear-gradient(135deg, #9C27B0 0%, #E040FB 100%); color: white;">
                    <i class="fas fa-motorcycle"></i>
                </div>
                <h3 class="status-title">Kurye Durumu</h3>
            </div>
            <div class="status-info">
                Şu anki durumunuz:
                <span class="status-badge {{ Auth::user()->status === 'active' ? 'status-active' : 'status-inactive' }}">
                    {{ Auth::user()->status === 'active' ? 'Aktif' : 'Pasif' }}
                </span>
            </div>
        </div>

        <!-- Restoran Bilgileri -->
        <div class="restaurant-info">
            <div class="restaurant-header">
                <div class="restaurant-icon">
                    <i class="fas fa-store"></i>
                </div>
                <h3 class="restaurant-title">{{ Auth::user()->courier->restaurant->name }}</h3>
            </div>
            <div class="restaurant-details">
                <p><strong>Adres:</strong> {{ Auth::user()->courier->restaurant->address }}</p>
                <p><strong>Telefon:</strong> {{ Auth::user()->courier->restaurant->phone }}</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 