@extends('layouts.app')
@section('title', 'Kurye Detayı')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kurye Detayları</h3>
                    <div class="card-tools">
                        <a href="{{ route('restaurant.couriers.index') }}" class="btn btn-sm btn-default">
                            <i class="fas fa-arrow-left"></i> Geri
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Kurye Bilgileri</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Ad Soyad</th>
                                    <td>{{ $courier->name }}</td>
                                </tr>
                                <tr>
                                    <th>E-posta</th>
                                    <td>{{ $courier->email }}</td>
                                </tr>
                                <tr>
                                    <th>Telefon</th>
                                    <td>{{ $courier->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Plaka</th>
                                    <td>{{ $courier->plate }}</td>
                                </tr>
                                <tr>
                                    <th>Durum</th>
                                    <td>
                                        <span class="badge badge-{{ $courier->status === 'active' ? 'success' : 'danger' }}">
                                            {{ $courier->status === 'active' ? 'Aktif' : 'Pasif' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4>İstatistikler</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>{{ $todayDeliveries }}</h3>
                                            <p>Bugünkü Teslimatlar</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-shopping-bag"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3>{{ $monthlyDeliveries }}</h3>
                                            <p>Aylık Teslimatlar</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Aktif Siparişler</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sipariş No</th>
                                            <th>Müşteri</th>
                                            <th>Adres</th>
                                            <th>Durum</th>
                                            <th>Oluşturulma Tarihi</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($activeOrders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->customer_name }}</td>
                                            <td>{{ $order->delivery_address }}</td>
                                            <td>
                                                <span class="badge badge-{{ $order->status === 'picked_up' ? 'warning' : 'info' }}">
                                                    {{ $order->status === 'picked_up' ? 'Teslim Alındı' : 'Atandı' }}
                                                </span>
                                            </td>
                                            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('restaurant.orders.show', $order) }}" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Aktif sipariş bulunmuyor.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Son Teslimatlar</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sipariş No</th>
                                            <th>Müşteri</th>
                                            <th>Adres</th>
                                            <th>Teslim Tarihi</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentDeliveries as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->customer_name }}</td>
                                            <td>{{ $order->delivery_address }}</td>
                                            <td>{{ $order->delivered_at->format('d.m.Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('restaurant.orders.show', $order) }}" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Son teslimat bulunmuyor.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 