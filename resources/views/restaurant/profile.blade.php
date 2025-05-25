@extends('layouts.app')
@section('title', 'Profilim')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Profilim</h3>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#profileEditModal">
                        <i class="fas fa-edit"></i> Güncelle
                    </button>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <table class="table table-bordered">
                        <tr>
                            <th>Restoran Adı</th>
                            <td>{{ $restaurant->name }}</td>
                        </tr>
                        <tr>
                            <th>Telefon</th>
                            <td>{{ $restaurant->phone }}</td>
                        </tr>
                        <tr>
                            <th>Adres</th>
                            <td>{{ $restaurant->address }}</td>
                        </tr>
                        <tr>
                            <th>E-posta</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Durum</th>
                            <td>{{ $restaurant->status === 'active' ? 'Aktif' : 'Pasif' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Profil Güncelleme Modalı -->
    <div class="modal fade" id="profileEditModal" tabindex="-1" aria-labelledby="profileEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileEditModalLabel">Profil Bilgilerini Güncelle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <form method="POST" action="{{ route('restaurant.profile.update') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>Restoran Adı</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $restaurant->name) }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Telefon</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $restaurant->phone) }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Adres</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $restaurant->address) }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Yeni Şifre</label>
                            <input type="password" name="password" class="form-control" autocomplete="new-password">
                        </div>
                        <div class="form-group mb-3">
                            <label>Yeni Şifre (Tekrar)</label>
                            <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 