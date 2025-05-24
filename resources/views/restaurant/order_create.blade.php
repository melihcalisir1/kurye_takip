@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Yeni Sipariş Oluştur</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('restaurant.orders.store') }}" id="orderForm">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="customer_name" class="form-label">Müşteri Adı</label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                    id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="customer_phone" class="form-label">Müşteri Telefonu</label>
                                <input type="tel" class="form-control @error('customer_phone') is-invalid @enderror" 
                                    id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required>
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="delivery_address" class="form-label">Teslimat Adresi</label>
                            <textarea class="form-control @error('delivery_address') is-invalid @enderror" 
                                id="delivery_address" name="delivery_address" rows="3" required>{{ old('delivery_address') }}</textarea>
                            @error('delivery_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="courier_id" class="form-label">Kurye</label>
                            <select class="form-select @error('courier_id') is-invalid @enderror" 
                                id="courier_id" name="courier_id" required>
                                <option value="">Kurye Seçin</option>
                                @foreach($couriers as $courier)
                                    <option value="{{ $courier->id }}" {{ old('courier_id') == $courier->id ? 'selected' : '' }}>
                                        {{ $courier->name }} (Aktif Sipariş: {{ $courier->active_orders_count }})
                                    </option>
                                @endforeach
                            </select>
                            @error('courier_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Menü Öğeleri</label>
                            <div id="menuItems">
                                <div class="menu-item mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-select menu-select" name="items[0][menu_id]" required>
                                                <option value="">Menü Seçin</option>
                                                @foreach($menus as $menu)
                                                    <option value="{{ $menu->id }}" 
                                                        data-price="{{ $menu->price }}"
                                                        data-discount="{{ $menu->discount_price }}">
                                                        {{ $menu->name }} - {{ number_format($menu->price, 2) }} {{ $menu->currency }}
                                                        @if($menu->discount_price)
                                                            (İndirimli: {{ number_format($menu->discount_price, 2) }} {{ $menu->currency }})
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" class="form-control quantity-input" 
                                                name="items[0][quantity]" min="1" value="1" required>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-danger remove-item">Sil</button>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <input type="text" class="form-control" 
                                                name="items[0][notes]" placeholder="Özel notlar...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" id="addMenuItem">+ Menü Ekle</button>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Sipariş Notları</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <h5>Toplam Tutar: <span id="totalAmount">0.00</span> TL</h5>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Siparişi Oluştur</button>
                            <a href="{{ route('restaurant.orders') }}" class="btn btn-secondary">İptal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.getElementById('menuItems');
    const addMenuItemBtn = document.getElementById('addMenuItem');
    let itemCount = 1;

    // Menü öğesi ekle
    addMenuItemBtn.addEventListener('click', function() {
        const template = menuItems.querySelector('.menu-item').cloneNode(true);
        const inputs = template.querySelectorAll('input, select');
        
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace('[0]', `[${itemCount}]`));
            }
            if (input.type === 'number') {
                input.value = 1;
            } else if (input.type === 'text') {
                input.value = '';
            } else if (input.tagName === 'SELECT') {
                input.selectedIndex = 0;
            }
        });

        menuItems.appendChild(template);
        itemCount++;
        updateTotalAmount();
    });

    // Menü öğesi sil
    menuItems.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            if (menuItems.querySelectorAll('.menu-item').length > 1) {
                e.target.closest('.menu-item').remove();
                updateTotalAmount();
            }
        }
    });

    // Miktar veya menü değiştiğinde toplam tutarı güncelle
    menuItems.addEventListener('change', function(e) {
        if (e.target.classList.contains('menu-select') || e.target.classList.contains('quantity-input')) {
            updateTotalAmount();
        }
    });

    // Toplam tutarı hesapla
    function updateTotalAmount() {
        let total = 0;
        const items = menuItems.querySelectorAll('.menu-item');
        
        items.forEach(item => {
            const select = item.querySelector('.menu-select');
            const quantity = parseInt(item.querySelector('.quantity-input').value) || 0;
            
            if (select.selectedIndex > 0) {
                const option = select.options[select.selectedIndex];
                const price = parseFloat(option.dataset.discount) || parseFloat(option.dataset.price);
                total += price * quantity;
            }
        });

        document.getElementById('totalAmount').textContent = total.toFixed(2);
    }
});
</script>
@endpush
@endsection 