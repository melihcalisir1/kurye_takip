@extends('couriers.layout.app')
@section('title', 'Sipariş Detayı')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Sipariş #{{ $order->id }}</h2>
        <a href="{{ route('courier.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Geri Dön
        </a>
    </div>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">Müşteri Bilgileri</div>
                <div class="card-body">
                    <p><strong>Ad Soyad:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Telefon:</strong> {{ $order->customer_phone }}</p>
                    <p><strong>Adres:</strong> <span id="adresKopyala">{{ $order->delivery_address }}</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-success text-white">Restoran Bilgileri</div>
                <div class="card-body">
                    <p><strong>Restoran:</strong> {{ $order->restaurant->name }}</p>
                    <p><strong>Adres:</strong> {{ $order->restaurant->address }}</p>
                    <p><strong>Telefon:</strong> {{ $order->restaurant->phone }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-info text-white">Sipariş Detayları</div>
        <div class="card-body">
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
                            <td>{{ $item->menu->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 2) }} TL</td>
                            <td>{{ number_format($item->price * $item->quantity, 2) }} TL</td>
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
            @if($order->notes)
                <div class="mt-3">
                    <strong>Sipariş Notu:</strong>
                    <p class="text-muted">{{ $order->notes }}</p>
                </div>
            @endif
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->delivery_address) }}" target="_blank" class="btn btn-outline-primary">
            <i class="fas fa-map-marker-alt"></i> Haritada Göster
        </a>
        <button type="button" class="btn btn-outline-info" onclick="kopyalaAdres()">
            <i class="fas fa-copy"></i> Adresi Kopyala
        </button>
        <a href="tel:{{ $order->customer_phone }}" class="btn btn-outline-success">
            <i class="fas fa-phone"></i> Müşteriyi Ara
        </a>
    </div>
    <div class="d-flex gap-2 mt-4">
        @if($order->status === 'assigned')
            <form action="{{ route('courier.orders.update-status', $order->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="picked_up">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-box"></i> Siparişi Aldım
                </button>
            </form>
        @elseif($order->status === 'picked_up')
            <form action="{{ route('courier.orders.update-status', $order->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="delivered">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-flag-checkered"></i> Teslim Ettim
                </button>
            </form>
        @endif
    </div>
</div>
@push('scripts')
<script>
function kopyalaAdres() {
    const adres = document.getElementById('adresKopyala').innerText;
    navigator.clipboard.writeText(adres);
    alert('Adres kopyalandı!');
}
</script>
@endpush
@endsection 