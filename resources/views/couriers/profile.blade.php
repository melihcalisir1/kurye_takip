@extends('couriers.layout.app')
@section('title', 'Profilim')
@section('content')
<div class="container" style="max-width: 600px;">
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Profilim</h3>
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
                    <th>Ad Soyad</th>
                    <td>{{ $courier->name }}</td>
                </tr>
                <tr>
                    <th>Telefon</th>
                    <td>{{ $courier->phone }}</td>
                </tr>
                <tr>
                    <th>E-posta</th>
                    <td>{{ $courier->user->email ?? '' }}</td>
                </tr>
            </table>
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
                <form method="POST" action="{{ route('courier.profile.update') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Ad Soyad</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $courier->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telefon</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $courier->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-posta</label>
                            <input type="email" class="form-control" id="email" value="{{ $courier->user->email ?? '' }}" disabled>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label for="password" class="form-label">Yeni Şifre (opsiyonel)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Yeni Şifre Tekrarı</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
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