@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }
    .welcome-section {
        background: linear-gradient(135deg, #9C27B0 0%, #E040FB 100%);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(156,39,176,0.15);
    }
    .welcome-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .welcome-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }
    .stat-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.2rem;
    }
    .stat-icon.total { background: linear-gradient(135deg, #9C27B0 0%, #E040FB 100%); color: white; }
    .stat-icon.active { background: linear-gradient(135deg, #007AFF 0%, #00C6FB 100%); color: white; }
    .stat-icon.passive { background: linear-gradient(135deg, #FF6B6B 0%, #FF8E8E 100%); color: white; }
    .stat-title {
        font-size: 1rem;
        color: #6c757d;
        font-weight: 600;
    }
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0.5rem 0;
    }
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }
    .action-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
    }
    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .action-icon {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: #9C27B0;
    }
    .action-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #2c3e50;
    }
    .action-description {
        font-size: 0.9rem;
        color: #6c757d;
    }
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1rem;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .quick-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-container">
    <div class="welcome-section">
        <h1 class="welcome-title">Hoş Geldiniz, {{ auth()->user()->name }}!</h1>
        <p class="welcome-subtitle">Restoran yönetim panelinize hoş geldiniz. Buradan tüm işlemlerinizi yönetebilirsiniz.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon total">
                    <i class="fas fa-motorcycle"></i>
                </div>
                <div class="stat-title">Toplam Kurye</div>
            </div>
            <div class="stat-value">{{ isset($restaurant) && $restaurant->couriers ? $restaurant->couriers->count() : 0 }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon active">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-title">Aktif Kurye</div>
            </div>
            <div class="stat-value">{{ isset($restaurant) && $restaurant->couriers ? $restaurant->couriers->where('status', 'active')->count() : 0 }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon passive">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-title">Pasif Kurye</div>
            </div>
            <div class="stat-value">{{ isset($restaurant) && $restaurant->couriers ? $restaurant->couriers->where('status', 'inactive')->count() : 0 }}</div>
        </div>
    </div>

    <div class="quick-actions">
        <a href="{{ route('restaurant.couriers.index') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-motorcycle"></i>
            </div>
            <div class="action-title">Kurye Yönetimi</div>
            <div class="action-description">Kuryelerinizi ekleyin, düzenleyin ve yönetin</div>
        </a>

        <a href="{{ route('restaurant.menus') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-utensils"></i>
            </div>
            <div class="action-title">Menü Yönetimi</div>
            <div class="action-description">Menülerinizi düzenleyin ve yeni ürünler ekleyin</div>
        </a>

        <a href="{{ route('restaurant.orders') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="action-title">Siparişler</div>
            <div class="action-description">Gelen siparişleri görüntüleyin ve yönetin</div>
        </a>
    </div>
</div>
@endsection
