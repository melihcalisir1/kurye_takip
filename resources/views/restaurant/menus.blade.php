@extends('layouts.app')
@section('title', 'Menüler')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title mb-0">Menülerim</h2>
        <a href="{{ route('restaurant.menus.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Menü Ekle
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($menus->isEmpty())
        <div class="alert alert-info">
            Henüz menü eklenmemiş. Hemen bir menü ekleyerek başlayabilirsiniz!
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($menus as $menu)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        @if($menu->images)
                            @php
                                $images = json_decode($menu->images);
                                $firstImage = $images[0] ?? null;
                            @endphp
                            @if($firstImage)
                                <img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top" alt="{{ $menu->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-utensils fa-3x text-muted"></i>
                                </div>
                            @endif
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-utensils fa-3x text-muted"></i>
                            </div>
                        @endif

                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $menu->name }}</h5>
                                @if($menu->is_featured)
                                    <span class="badge bg-warning text-dark">Öne Çıkan</span>
                                @endif
                            </div>
                            
                            <p class="card-text text-muted small mb-2">{{ $menu->category }}</p>
                            
                            @if($menu->description)
                                <p class="card-text">{{ Str::limit($menu->description, 100) }}</p>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    @if($menu->discount_price)
                                        <span class="text-decoration-line-through text-muted">{{ $menu->price }} {{ $menu->currency }}</span>
                                        <span class="text-danger fw-bold ms-2">{{ $menu->discount_price }} {{ $menu->currency }}</span>
                                    @else
                                        <span class="fw-bold">{{ $menu->price }} {{ $menu->currency }}</span>
                                    @endif
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route('restaurant.menus.edit', $menu) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('restaurant.menus.destroy', $menu) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bu menüyü silmek istediğinizden emin misiniz?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            @if($menu->ingredients)
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="fas fa-list"></i> İçindekiler: {{ Str::limit($menu->ingredients, 50) }}
                                    </small>
                                </div>
                            @endif

                            @if($menu->portion)
                                <div class="mt-1">
                                    <small class="text-muted">
                                        <i class="fas fa-weight"></i> Porsiyon: {{ $menu->portion }}
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection 