@extends('admin.layout.app')

@section('title', 'Restoran Yönetimi')

@section('content')
    <div class="content-container">
        <a href="{{ route('admin.dashboard') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Geri Dön
        </a>

        <div class="page-header">
            <h2 class="page-title">Restoran Yönetimi</h2>
            <button class="add-restaurant-btn" data-bs-toggle="modal" data-bs-target="#addRestaurantModal">
                <i class="fas fa-plus"></i>
                Yeni Restoran Ekle
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                @if(is_array(session('success')))
                    {{ session('success')['message'] }}
                    @if(isset(session('success')['credentials']))
                        <hr>
                        <strong>Giriş Bilgileri:</strong><br>
                        E-posta: {{ session('success')['credentials']['email'] }}<br>
                        Şifre: {{ session('success')['credentials']['password'] }}
                    @endif
                @else
                    {{ session('success') }}
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Arama Kutusu -->
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Restoran adı veya adres ile ara...">
        </div>

        <!-- Restoran Tablosu -->
        <div class="restaurant-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>Restoran Adı</th>
                        <th>Telefon</th>
                        <th>Adres</th>
                        <th>Kurye Sayısı</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($restaurants as $restaurant)
                    <tr>
                        <td>{{ $restaurant->name }}</td>
                        <td>{{ $restaurant->phone }}</td>
                        <td>{{ $restaurant->address }}</td>
                        <td>{{ $restaurant->couriers_count }}</td>
                        <td>
                            <span class="status-badge status-{{ $restaurant->status }}">
                                {{ $restaurant->status === 'active' ? 'Aktif' : 'Pasif' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.restaurants.couriers', $restaurant) }}" class="action-btn courier-btn" title="Kuryeler">
                                    <i class="fas fa-motorcycle"></i>
                                </a>
                                <a href="#" class="action-btn edit-btn" title="Düzenle" data-bs-toggle="modal" data-bs-target="#editRestaurantModal{{ $restaurant->id }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.restaurants.destroy', $restaurant) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete-btn" title="Sil" onclick="return confirm('Bu restoranı silmek istediğinize emin misiniz?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Düzenleme Modal -->
                    <div class="modal fade" id="editRestaurantModal{{ $restaurant->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Restoran Düzenle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.restaurants.update', $restaurant) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Restoran Adı</label>
                                            <input type="text" class="form-control" name="name" value="{{ $restaurant->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Telefon</label>
                                            <input type="tel" class="form-control" name="phone" value="{{ $restaurant->phone }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Adres</label>
                                            <textarea class="form-control" name="address" rows="3" required>{{ $restaurant->address }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Durum</label>
                                            <select class="form-select" name="status">
                                                <option value="active" {{ $restaurant->status === 'active' ? 'selected' : '' }}>Aktif</option>
                                                <option value="inactive" {{ $restaurant->status === 'inactive' ? 'selected' : '' }}>Pasif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                                        <button type="submit" class="btn btn-primary">Kaydet</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Yeni Restoran Ekleme Modal -->
    <div class="modal fade" id="addRestaurantModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yeni Restoran Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.restaurants.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Restoran Adı</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telefon</label>
                            <input type="tel" class="form-control" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Adres</label>
                            <textarea class="form-control" name="address" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Durum</label>
                            <select class="form-select" name="status">
                                <option value="active">Aktif</option>
                                <option value="inactive">Pasif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .content-container {
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    .page-title {
        font-weight: 700;
        font-size: 1.8rem;
        color: #2c3e50;
        margin: 0;
    }
    .add-restaurant-btn {
        background: linear-gradient(135deg, #4CAF50 0%, #8BC34A 100%);
        color: white;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s;
    }
    .add-restaurant-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(76,175,80,0.3);
        color: white;
    }
    .search-box {
        background: white;
        border-radius: 10px;
        padding: 0.8rem 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .search-box input {
        border: none;
        outline: none;
        font-size: 1rem;
        width: 100%;
    }
    .search-box i {
        color: #6c757d;
    }
    .restaurant-table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .table {
        margin: 0;
    }
    .table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #2c3e50;
        border: none;
        padding: 1rem;
    }
    .table td {
        padding: 1rem;
        vertical-align: middle;
        border-color: #f1f1f1;
    }
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .status-active {
        background: #e3fcef;
        color: #00a854;
    }
    .status-inactive {
        background: #fff1f0;
        color: #ff4d4f;
    }
    .action-btn {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.3s;
    }
    .edit-btn {
        background: #007AFF;
    }
    .delete-btn {
        background: #FF6B6B;
    }
    .courier-btn {
        background: #4CAF50;
    }
    .action-btn:hover {
        transform: translateY(-2px);
        color: white;
    }
    .back-btn {
        color: #6c757d;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    .back-btn:hover {
        color: #2c3e50;
    }
    .alert {
        border-radius: 10px;
        margin-bottom: 1.5rem;
    }
</style>
@endpush 