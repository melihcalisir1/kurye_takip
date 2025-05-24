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