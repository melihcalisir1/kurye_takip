@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<style>
    .dashboard-center {
        max-width: 700px;
        margin: 0 auto;
    }
    .dashboard-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        justify-content: center;
        margin-bottom: 2.5rem;
    }
    .dashboard-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(44,62,80,0.09);
        padding: 2rem 2.2rem 1.5rem 2.2rem;
        min-width: 200px;
        flex: 1 1 200px;
        max-width: 220px;
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: box-shadow 0.3s, transform 0.3s;
    }
    .dashboard-card:hover {
        box-shadow: 0 8px 32px rgba(44,62,80,0.16);
        transform: translateY(-4px) scale(1.03);
    }
    .dashboard-icon {
        font-size: 2.2rem;
        margin-bottom: 0.7rem;
        padding: 18px;
        border-radius: 50%;
        color: #fff;
        margin-top: -2.2rem;
        margin-bottom: 1.1rem;
    }
    .dashboard-icon.total { background: linear-gradient(135deg, #9C27B0 0%, #E040FB 100%); }
    .dashboard-icon.active { background: linear-gradient(135deg, #007AFF 0%, #00C6FB 100%); }
    .dashboard-icon.passive { background: linear-gradient(135deg, #FF6B6B 0%, #FF8E8E 100%); }
    .dashboard-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 0.3rem;
        text-align: center;
    }
    .dashboard-value {
        font-size: 2.2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.2rem;
        text-align: center;
    }
    .dashboard-btn-area {
        display: flex;
        justify-content: center;
        margin-top: 2.5rem;
    }
    .dashboard-btn {
        background: linear-gradient(135deg, #9C27B0 0%, #E040FB 100%);
        color: #fff;
        font-weight: 600;
        font-size: 1.15rem;
        border: none;
        border-radius: 14px;
        padding: 1.2rem 2.5rem;
        box-shadow: 0 4px 20px rgba(156,39,176,0.10);
        display: flex;
        align-items: center;
        gap: 1rem;
        text-decoration: none;
        transition: all 0.3s;
    }
    .dashboard-btn:hover {
        background: linear-gradient(135deg, #8e24aa 0%, #e040fb 100%);
        color: #fff;
        transform: translateY(-2px) scale(1.03);
    }
    @media (max-width: 800px) {
        .dashboard-cards { flex-direction: column; gap: 1.2rem; }
        .dashboard-card { max-width: 100%; min-width: 0; }
    }
</style>
<div class="dashboard-center">
    <h2 class="page-title">Dashboard</h2>
    <div class="dashboard-cards">
        <div class="dashboard-card">
            <div class="dashboard-icon total"><i class="fas fa-motorcycle"></i></div>
            <div class="dashboard-title">Toplam Kurye</div>
            <div class="dashboard-value">{{ isset($restaurant) && $restaurant->couriers ? $restaurant->couriers->count() : 0 }}</div>
        </div>
        <div class="dashboard-card">
            <div class="dashboard-icon active"><i class="fas fa-check-circle"></i></div>
            <div class="dashboard-title">Aktif Kurye</div>
            <div class="dashboard-value">{{ isset($restaurant) && $restaurant->couriers ? $restaurant->couriers->where('status', 'active')->count() : 0 }}</div>
        </div>
        <div class="dashboard-card">
            <div class="dashboard-icon passive"><i class="fas fa-times-circle"></i></div>
            <div class="dashboard-title">Pasif Kurye</div>
            <div class="dashboard-value">{{ isset($restaurant) && $restaurant->couriers ? $restaurant->couriers->where('status', 'inactive')->count() : 0 }}</div>
        </div>
    </div>
    <div class="dashboard-btn-area">
        <a href="{{ isset($restaurant) ? route('admin.restaurants.couriers.index', $restaurant->id) : '#' }}" class="dashboard-btn">
            <i class="fas fa-motorcycle"></i> Kuryeleri Yönet
        </a>
    </div>
</div>
@endsection
