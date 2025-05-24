@extends('layouts.app')
@section('title', 'Menü Düzenle')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">Menü Düzenle</h2>
        <a href="{{ route('restaurant.menus') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Geri Dön
        </a>
    </div>

    <form method="POST" action="{{ route('restaurant.menus.update', $menu) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Menü Adı</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $menu->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Açıklama</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $menu->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                        <option value="">Seçiniz</option>
                        <option value="Çorba" {{ old('category', $menu->category) == 'Çorba' ? 'selected' : '' }}>Çorba</option>
                        <option value="Ana Yemek" {{ old('category', $menu->category) == 'Ana Yemek' ? 'selected' : '' }}>Ana Yemek</option>
                        <option value="Tatlı" {{ old('category', $menu->category) == 'Tatlı' ? 'selected' : '' }}>Tatlı</option>
                        <option value="İçecek" {{ old('category', $menu->category) == 'İçecek' ? 'selected' : '' }}>İçecek</option>
                        <option value="Salata" {{ old('category', $menu->category) == 'Salata' ? 'selected' : '' }}>Salata</option>
                        <option value="Fast Food" {{ old('category', $menu->category) == 'Fast Food' ? 'selected' : '' }}>Fast Food</option>
                        <option value="Kahvaltı" {{ old('category', $menu->category) == 'Kahvaltı' ? 'selected' : '' }}>Kahvaltı</option>
                        <option value="Vegan" {{ old('category', $menu->category) == 'Vegan' ? 'selected' : '' }}>Vegan</option>
                        <option value="Diğer" {{ old('category', $menu->category) == 'Diğer' ? 'selected' : '' }}>Diğer</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price" class="form-label">Fiyat</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $menu->price) }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="discount_price" class="form-label">İndirimli Fiyat</label>
                            <input type="number" step="0.01" class="form-control @error('discount_price') is-invalid @enderror" id="discount_price" name="discount_price" value="{{ old('discount_price', $menu->discount_price) }}">
                            @error('discount_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="currency" class="form-label">Para Birimi</label>
                    <input type="text" class="form-control @error('currency') is-invalid @enderror" id="currency" name="currency" value="{{ old('currency', $menu->currency) }}" required>
                    @error('currency')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="portion" class="form-label">Porsiyon</label>
                    <input type="text" class="form-control @error('portion') is-invalid @enderror" id="portion" name="portion" value="{{ old('portion', $menu->portion) }}">
                    @error('portion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="calories" class="form-label">Kalori</label>
                    <input type="number" class="form-control @error('calories') is-invalid @enderror" id="calories" name="calories" value="{{ old('calories', $menu->calories) }}">
                    @error('calories')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="ingredients" class="form-label">İçindekiler</label>
                    <textarea class="form-control @error('ingredients') is-invalid @enderror" id="ingredients" name="ingredients" rows="3">{{ old('ingredients', $menu->ingredients) }}</textarea>
                    @error('ingredients')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="extras" class="form-label">Ekstralar</label>
                    <textarea class="form-control @error('extras') is-invalid @enderror" id="extras" name="extras" rows="3">{{ old('extras', $menu->extras) }}</textarea>
                    @error('extras')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tags" class="form-label">Etiketler</label>
                    <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" value="{{ old('tags', $menu->tags) }}">
                    @error('tags')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input @error('is_featured') is-invalid @enderror" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $menu->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Öne Çıkan Menü</label>
                        @error('is_featured')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="images" class="form-label">Görseller</label>
                    <input type="file" class="form-control @error('images') is-invalid @enderror" id="images" name="images[]" multiple accept="image/*">
                    @error('images')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    @if($menu->images)
                        <div class="mt-2">
                            <label class="form-label">Mevcut Görseller</label>
                            <div class="row">
                                @foreach(json_decode($menu->images) as $image)
                                    <div class="col-md-4 mb-2">
                                        <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail" alt="Menü Görseli">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Kaydet
            </button>
            <a href="{{ route('restaurant.menus') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> İptal
            </a>
        </div>
    </form>
@endsection 