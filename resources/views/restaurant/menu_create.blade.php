@extends('layouts.app')
@section('title', 'Menü Ekle')
@section('content')
    <h2 class="page-title mb-4">Menü Ekle</h2>
    <form method="POST" action="{{ route('restaurant.menus.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Menü Adı</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Açıklama</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select class="form-select" id="category" name="category" required>
                        <option value="">Seçiniz</option>
                        <option value="Çorba">Çorba</option>
                        <option value="Ana Yemek">Ana Yemek</option>
                        <option value="Tatlı">Tatlı</option>
                        <option value="İçecek">İçecek</option>
                        <option value="Salata">Salata</option>
                        <option value="Fast Food">Fast Food</option>
                        <option value="Kahvaltı">Kahvaltı</option>
                        <option value="Vegan">Vegan</option>
                        <option value="Diğer">Diğer</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="price" class="form-label">Fiyat</label>
                    <div class="input-group">
                        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                        <select class="form-select" name="currency" style="max-width: 80px;">
                            <option value="₺">₺</option>
                            <option value="$">$</option>
                            <option value="€">€</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="discount_price" class="form-label">İndirimli Fiyat</label>
                    <input type="number" step="0.01" class="form-control" id="discount_price" name="discount_price">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="images" class="form-label">Görsel</label>
                    <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple>
                </div>
                <div class="mb-3">
                    <label for="portion" class="form-label">Gramaj / Porsiyon</label>
                    <input type="text" class="form-control" id="portion" name="portion" placeholder="Örn: 250gr, 1 porsiyon">
                </div>
                
                <div class="mb-3">
                    <label for="calories" class="form-label">Kalori (kcal)</label>
                    <input type="number" min="0" class="form-control" id="calories" name="calories">
                </div>
                <div class="mb-3">
                    <label for="ingredients" class="form-label">Malzemeler</label>
                    <input type="text" class="form-control" id="ingredients" name="ingredients" placeholder="Virgül ile ayırın: Domates, Peynir, Zeytin">
                </div>
                
                <div class="mb-3">
                    <label for="extras" class="form-label">Ekstra Seçenekler</label>
                    <input type="text" class="form-control" id="extras" name="extras" placeholder="Örn: Ekstra Peynir, Acı Sos, Büyük Boy">
                </div>
                <div class="mb-3">
                    <label for="tags" class="form-label">Etiketler</label>
                    <input type="text" class="form-control" id="tags" name="tags" placeholder="Örn: Çok Satan, Yeni, Vegan">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Kaydet</button>
        <a href="{{ route('restaurant.menus') }}" class="btn btn-secondary">İptal</a>
    </form>
@endsection 