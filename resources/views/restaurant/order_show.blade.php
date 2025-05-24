@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Sipariş #{{ $order->id }}</h4>
                    <a href="{{ route('restaurant.orders') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Geri
                    </a>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Müşteri Bilgileri</h5>
                            <p>
                                <strong>Ad Soyad:</strong> {{ $order->customer_name }}<br>
                                <strong>Telefon:</strong> {{ $order->customer_phone }}<br>
                                <strong>Adres:</strong> {{ $order->delivery_address }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5>Sipariş Bilgileri</h5>
                            <p>
                                <strong>Durum:</strong> 
                                <span class="badge bg-{{ $order->status_color }}">
                                    {{ $order->status_text }}
                                </span><br>
                                <strong>Kurye:</strong> 
                                @if($order->courier)
                                    {{ $order->courier->name }}
                                @else
                                    <span class="text-muted">Atanmamış</span>
                                @endif<br>
                                <strong>Tarih:</strong> {{ $order->created_at->format('d.m.Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <h5>Sipariş Detayları</h5>
                    <div class="table-responsive mb-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Ürün</th>
                                    <th>Adet</th>
                                    <th>Birim Fiyat</th>
                                    <th>Toplam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            {{ $item->menu->name }}
                                            @if($item->notes)
                                                <br>
                                                <small class="text-muted">{{ $item->notes }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>
                                            @if($item->discount_price)
                                                <del>{{ number_format($item->price, 2) }} TL</del><br>
                                                {{ number_format($item->discount_price, 2) }} TL
                                            @else
                                                {{ number_format($item->price, 2) }} TL
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->discount_price)
                                                {{ number_format($item->discount_price * $item->quantity, 2) }} TL
                                            @else
                                                {{ number_format($item->price * $item->quantity, 2) }} TL
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Toplam Tutar:</th>
                                    <th>{{ number_format($order->total_amount, 2) }} TL</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($order->notes)
                        <div class="mb-4">
                            <h5>Sipariş Notları</h5>
                            <p class="text-muted">{{ $order->notes }}</p>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <div>
                            @if($order->status === 'pending' || $order->status === 'preparing')
                                <form action="{{ route('restaurant.orders.update-status', $order) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="ready">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check"></i> Hazır
                                    </button>
                                </form>
                            @endif

                            @if($order->status === 'ready')
                                <form action="{{ route('restaurant.orders.update-status', $order) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="picked_up">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-truck"></i> Kurye Aldı
                                    </button>
                                </form>
                            @endif

                            @if($order->status === 'picked_up')
                                <form action="{{ route('restaurant.orders.update-status', $order) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="delivered">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-flag-checkered"></i> Teslim Edildi
                                    </button>
                                </form>
                            @endif
                        </div>

                        @if($order->status !== 'delivered' && $order->status !== 'cancelled')
                            <form action="{{ route('restaurant.orders.update-status', $order) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Siparişi iptal etmek istediğinize emin misiniz?')">
                                    <i class="fas fa-times"></i> İptal Et
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 