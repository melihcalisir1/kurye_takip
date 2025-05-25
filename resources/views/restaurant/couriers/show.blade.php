@extends('layouts.app')
@section('title', 'Kurye Detayı')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Kurye Detayı</h2>
        <div class="btn-group">
            <a href="{{ route('restaurant.couriers.edit', $courier) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Düzenle
            </a>
            <form action="{{ route('restaurant.couriers.toggle-status', $courier) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-{{ $courier->status === 'active' ? 'secondary' : 'success' }}">
                    <i class="fas fa-{{ $courier->status === 'active' ? 'ban' : 'check' }}"></i>
                    {{ $courier->status === 'active' ? 'Pasif Yap' : 'Aktif Yap' }}
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <!-- Kurye Bilgileri -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-circle mb-3">
                            <i class="fas fa-motorcycle"></i>
                        </div>
                        <h4>{{ $courier->name }}</h4>
                        <span class="badge bg-{{ $courier->status === 'active' ? 'success' : 'danger' }}">
                            {{ $courier->status === 'active' ? 'Aktif' : 'Pasif' }}
                        </span>
                    </div>
                    <div class="info-list">
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <span>{{ $courier->phone }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <span>{{ $courier->user->email }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <span>Son görülme: {{ $courier->last_seen_at ? $courier->last_seen_at->diffForHumans() : 'Hiç görülmedi' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- İstatistikler -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">İstatistikler</h5>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-value">{{ $todayDeliveries }}</div>
                            <div class="stat-label">Bugünkü Teslimat</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $monthlyDeliveries }}</div>
                            <div class="stat-label">Aylık Teslimat</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktif Siparişler -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-4">Aktif Siparişler</h5>
                    @if($activeOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sipariş No</th>
                                        <th>Müşteri</th>
                                        <th>Adres</th>
                                        <th>Durum</th>
                                        <th>İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activeOrders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->customer_name }}</td>
                                            <td>{{ Str::limit($order->delivery_address, 30) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $order->status === 'assigned' ? 'warning' : 'info' }}">
                                                    {{ $order->status === 'assigned' ? 'Atandı' : 'Teslim Alındı' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('restaurant.orders.show', $order) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center mb-0">Aktif sipariş bulunmuyor.</p>
                    @endif
                </div>
            </div>

            <!-- Son Teslimatlar -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Son Teslimatlar</h5>
                    @if($recentDeliveries->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sipariş No</th>
                                        <th>Müşteri</th>
                                        <th>Teslim Tarihi</th>
                                        <th>İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentDeliveries as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->customer_name }}</td>
                                            <td>{{ $order->delivered_at->format('d.m.Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('restaurant.orders.show', $order) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center mb-0">Henüz teslimat yapılmamış.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #9C27B0 0%, #E040FB 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: white;
        font-size: 2rem;
    }
    .info-list {
        margin-top: 1.5rem;
    }
    .info-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.8rem 0;
        border-bottom: 1px solid #eee;
    }
    .info-item:last-child {
        border-bottom: none;
    }
    .info-item i {
        width: 20px;
        color: #9C27B0;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    .stat-item {
        text-align: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
    }
    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.3rem;
    }
    .stat-label {
        font-size: 0.9rem;
        color: #6c757d;
    }
    .table th {
        font-weight: 600;
        background: #f8f9fa;
    }
    .badge {
        padding: 0.5em 0.8em;
        font-weight: 500;
    }
</style>
@endsection 