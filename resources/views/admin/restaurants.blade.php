<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoran Yönetimi | Kurye Takip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: #f8f9fa;
        }
        .admin-header {
            background: linear-gradient(135deg, #007AFF 0%, #00C6FB 100%);
            padding: 1rem 2rem;
            color: white;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        .admin-title {
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0;
        }
        .admin-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .admin-name {
            font-weight: 600;
            font-size: 1rem;
        }
        .logout-btn {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            background: rgba(255,255,255,0.1);
            transition: all 0.3s;
        }
        .logout-btn:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }
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
</head>
<body>
    <!-- Admin Header -->
    <header class="admin-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="admin-title">Admin Panel</h1>
                <div class="admin-info">
                    <div class="admin-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="admin-name">Admin</span>
                    <a href="/logout" class="logout-btn">
                        <i class="fas fa-sign-out-alt me-2"></i>Çıkış
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Content -->
    <div class="content-container">
        <a href="/admin/dashboard" class="back-btn">
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
            <div class="alert alert-success">
                {{ session('success') }}
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 