@extends('admin.layout.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-bg">
    <div class="container py-4">
        <div class="welcome-box mb-4">
            <h1 class="fw-bold mb-1">Hoş geldin, Admin!</h1>
            <div class="text-muted">Sistemin genel özetini aşağıda bulabilirsin.</div>
        </div>
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6 col-12">
                <div class="stat-card2">
                    <div class="stat-icon2 stat-green">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Toplam Restoran</div>
                        <div class="stat-value2">{{ $stats['totalRestaurants'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="stat-card2">
                    <div class="stat-icon2 stat-blue">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Aktif Restoran</div>
                        <div class="stat-value2">{{ $stats['activeRestaurants'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="stat-card2">
                    <div class="stat-icon2 stat-red">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Pasif Restoran</div>
                        <div class="stat-value2">{{ $stats['inactiveRestaurants'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="stat-card2">
                    <div class="stat-icon2 stat-purple">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Toplam Kurye</div>
                        <div class="stat-value2">{{ $stats['totalCouriers'] }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 mt-2">
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('admin.restaurants') }}" class="big-action-btn">
                    <i class="fas fa-store"></i>
                    <span>Restoranları ve Kuryeleri Yönet</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.dashboard-bg {
    min-height: 100vh;
    background: linear-gradient(135deg, #f8fafc 60%, #e0e7ff 100%);
    position: relative;
}
.welcome-box {
    background: rgba(255,255,255,0.95);
    border-radius: 18px;
    padding: 2rem 2.5rem 1.5rem 2.5rem;
    box-shadow: 0 4px 24px rgba(44,62,80,0.07);
    margin-bottom: 2rem;
}
.stat-card2 {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(44,62,80,0.08);
    padding: 2.2rem 1.2rem 1.2rem 1.2rem;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    gap: 1.2rem;
    min-height: 120px;
    transition: box-shadow 0.2s, transform 0.2s;
}
.stat-card2:hover {
    box-shadow: 0 8px 32px rgba(44,62,80,0.13);
    transform: translateY(-4px) scale(1.03);
}
.stat-icon2 {
    position: absolute;
    right: 18px;
    bottom: 10px;
    font-size: 4.5rem;
    opacity: 0.08;
    pointer-events: none;
    z-index: 0;
}
.stat-green { color: #4CAF50; }
.stat-blue { color: #007AFF; }
.stat-red { color: #FF6B6B; }
.stat-purple { color: #9C27B0; }
.stat-info {
    position: relative;
    z-index: 1;
}
.stat-label {
    font-size: 1.1rem;
    color: #6c757d;
    font-weight: 600;
    margin-bottom: 0.2rem;
}
.stat-value2 {
    font-size: 2.2rem;
    font-weight: 800;
    color: #2c3e50;
    letter-spacing: 1px;
}
.big-action-btn {
    display: flex;
    align-items: center;
    gap: 1.1rem;
    background: linear-gradient(135deg, #007AFF 0%, #00C6FB 100%);
    color: #fff;
    border-radius: 14px;
    font-size: 1.2rem;
    font-weight: 700;
    padding: 1.3rem 2rem;
    box-shadow: 0 4px 24px rgba(44,62,80,0.10);
    text-decoration: none;
    transition: box-shadow 0.2s, transform 0.2s, background 0.2s;
}
.big-action-btn i {
    font-size: 2rem;
}
.big-action-btn:hover {
    background: linear-gradient(135deg, #005bb5 0%, #00b4d8 100%);
    color: #fff;
    transform: translateY(-2px) scale(1.03);
    box-shadow: 0 8px 32px rgba(44,62,80,0.13);
}
@media (max-width: 768px) {
    .welcome-box {
        padding: 1.2rem 1rem 1rem 1rem;
    }
    .stat-card2 {
        flex-direction: column;
        align-items: flex-start;
        min-height: 100px;
        padding: 1.2rem 0.8rem 1rem 0.8rem;
    }
    .stat-icon2 {
        font-size: 3.2rem;
        right: 10px;
        bottom: 6px;
    }
    .big-action-btn {
        font-size: 1rem;
        padding: 1rem 1.2rem;
    }
}
</style>
@endpush 