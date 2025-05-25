@extends('couriers.layout.app')
@section('title', 'Aktif Siparişler')
@section('content')
<h2 class="mb-4">Aktif Siparişlerim</h2>
@if($orders->isEmpty())
    <div class="alert alert-info">Şu anda aktif siparişiniz yok.</div>
@else
    <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
        @foreach($orders as $order)
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">#{{ $order->id }} - {{ $order->customer_name }}</h5>
                        <p class="card-text mb-1"><strong>Adres:</strong> {{ $order->delivery_address }}</p>
                        <p class="card-text mb-1"><strong>Telefon:</strong> {{ $order->customer_phone }}</p>
                        <p class="card-text mb-1"><strong>Tutar:</strong> {{ number_format($order->total_amount, 2) }} TL</p>
                        <p class="card-text mb-1"><strong>Durum:</strong> <span class="badge bg-{{ $order->status_color }}">{{ $order->status_text }}</span></p>
                        <a href="{{ route('courier.orders.show', $order) }}" class="btn btn-primary btn-sm mt-2">Detay</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection 