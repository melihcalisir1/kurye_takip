@extends('couriers.layout.app')
@section('title', 'Teslim Edilen Siparişler')
@section('content')
<h2 class="mb-4">Teslim Edilen Siparişlerim</h2>
@if($orders->isEmpty())
    <div class="alert alert-info">Henüz teslim ettiğiniz sipariş yok.</div>
@else
    <div class="row row-cols-1 row-cols-md-2 g-4">
        @foreach($orders as $order)
            <div class="col">
                <div class="card h-100 border-success">
                    <div class="card-body">
                        <h5 class="card-title">#{{ $order->id }} - {{ $order->customer_name }}</h5>
                        <p class="card-text mb-1"><strong>Adres:</strong> {{ $order->delivery_address }}</p>
                        <p class="card-text mb-1"><strong>Teslim Tarihi:</strong> {{ $order->delivered_at ? $order->delivered_at->format('d.m.Y H:i') : '-' }}</p>
                        <p class="card-text mb-1"><strong>Tutar:</strong> {{ number_format($order->total_amount, 2) }} TL</p>
                        <a href="{{ route('courier.orders.show', $order) }}" class="btn btn-outline-primary btn-sm mt-2">Detay</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection 