@extends('couriers.layout.app')
@section('title', 'Kurye Paneli')
@section('content')
    <h2 class="mb-4">Merhaba, {{ auth()->user()->name }}!</h2>
    <div class="row mb-4">
        <div class="col-md-4">
            <a href="{{ route('courier.orders.active') }}" class="text-decoration-none">
                <div class="card text-bg-primary mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Aktif Sipariş</h5>
                        <p class="display-5 fw-bold mb-0">{{ $activeOrders->count() }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('courier.orders.delivered') }}" class="text-decoration-none">
                <div class="card text-bg-success mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Bugün Teslim Edilen</h5>
                        <p class="display-5 fw-bold mb-0">{{ $deliveredOrders->where('delivered_at', '>=', now()->startOfDay())->count() }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('courier.orders.delivered') }}" class="text-decoration-none">
                <div class="card text-bg-secondary mb-3">
                    <div class="card-body text-center">
                        <h5 class="card-title">Toplam Teslim</h5>
                        <p class="display-5 fw-bold mb-0">{{ $deliveredOrders->count() }}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="alert alert-info">
        Aktif ve geçmiş siparişlerinizi sol menüden görebilirsiniz.
    </div>
@endsection