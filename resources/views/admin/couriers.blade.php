@extends('admin.layout.app')

@section('title', 'Kurye Yönetimi')

@section('content')
    <div class="content-container">
        <a href="{{ route('admin.restaurants') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Restoranlara Dön
        </a>

        <div class="page-header">
            <h2 class="page-title">{{ $restaurant->name }} - Kurye Yönetimi</h2>
            <button class="add-courier-btn" data-bs-toggle="modal" data-bs-target="#addCourierModal">
                <i class="fas fa-plus"></i>
                Yeni Kurye Ekle
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
            <input type="text" placeholder="Kurye adı veya plaka ile ara...">
        </div>

        <!-- Kurye Tablosu -->
        <div class="courier-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kurye Adı</th>
                        <th>Telefon</th>
                        <th>Plaka</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($couriers as $courier)
                    <tr>
                        <td>{{ $courier->name }}</td>
                        <td>{{ $courier->phone }}</td>
                        <td>{{ $courier->plate }}</td>
                        <td>
                            <span class="status-badge status-{{ $courier->status }}">
                                {{ $courier->status === 'active' ? 'Aktif' : 'Pasif' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#locationModal{{ $courier->id }}">
                                    <i class="fas fa-map-marker-alt"></i> Konum
                                </button>
                                <a href="#" class="action-btn edit-btn" title="Düzenle" data-bs-toggle="modal" data-bs-target="#editCourierModal{{ $courier->id }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.restaurants.couriers.destroy', [$restaurant, $courier]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete-btn" title="Sil" onclick="return confirm('Bu kuryeyi silmek istediğinize emin misiniz?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Düzenleme Modal -->
                    <div class="modal fade" id="editCourierModal{{ $courier->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Kurye Düzenle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.restaurants.couriers.update', [$restaurant, $courier]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Kurye Adı</label>
                                            <input type="text" class="form-control" name="name" value="{{ $courier->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Telefon</label>
                                            <input type="tel" class="form-control" name="phone" value="{{ $courier->phone }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Plaka</label>
                                            <input type="text" class="form-control" name="plate" value="{{ $courier->plate }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Durum</label>
                                            <select class="form-select" name="status">
                                                <option value="active" {{ $courier->status === 'active' ? 'selected' : '' }}>Aktif</option>
                                                <option value="inactive" {{ $courier->status === 'inactive' ? 'selected' : '' }}>Pasif</option>
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

                    <!-- Konum Modal -->
                    <div class="modal fade" id="locationModal{{ $courier->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ $courier->name }} - Konum</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="map{{ $courier->id }}" style="height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Kurye Ekle Modal -->
    <div class="modal fade" id="addCourierModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yeni Kurye Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.restaurants.couriers.store', $restaurant->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Ad Soyad</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telefon</label>
                            <input type="tel" class="form-control" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Durum</label>
                            <select class="form-select" name="status" required>
                                <option value="active">Aktif</option>
                                <option value="inactive">Pasif</option>
                            </select>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Kurye için otomatik olarak bir e-posta ve şifre oluşturulacaktır. Bu bilgiler kurye giriş yapabilmesi için gereklidir.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                        <button type="submit" class="btn btn-primary">Ekle</button>
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
    .add-courier-btn {
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
    .add-courier-btn:hover {
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
    .courier-table {
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

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
@foreach($couriers as $courier)
function initMap{{ $courier->id }}() {
    if (!document.getElementById('map{{ $courier->id }}')) return;
    
    const position = [{{ $courier->latitude ?? 41.0082 }}, {{ $courier->longitude ?? 28.9784 }}];
    
    const map = L.map('map{{ $courier->id }}').setView(position, 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    const marker = L.marker(position).addTo(map);
    
    const popup = L.popup()
        .setContent(`
            <div>
                <h5>{{ $courier->name }}</h5>
                <p>Plaka: {{ $courier->plate }}</p>
                <p>Durum: {{ $courier->status === 'active' ? 'Aktif' : 'Pasif' }}</p>
                <p>Son Güncelleme: {{ $courier->last_location_update ? $courier->last_location_update->format('d.m.Y H:i:s') : 'Bilgi yok' }}</p>
            </div>
        `);

    marker.bindPopup(popup);
}

// Modal açıldığında haritayı başlat
document.getElementById('locationModal{{ $courier->id }}').addEventListener('shown.bs.modal', function () {
    initMap{{ $courier->id }}();
});
@endforeach
</script>
@endpush 