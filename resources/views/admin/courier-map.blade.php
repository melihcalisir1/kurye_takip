@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Kurye Konumları</div>

                <div class="card-body">
                    <div id="map" style="height: 600px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"></script>
<script>
function initMap() {
    // İstanbul merkezi
    const center = { lat: 41.0082, lng: 28.9784 };
    
    // Haritayı oluştur
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 12,
        center: center,
    });

    // Kuryeleri haritada göster
    const couriers = @json($couriers);
    
    couriers.forEach(courier => {
        if (courier.latitude && courier.longitude) {
            const marker = new google.maps.Marker({
                position: { lat: parseFloat(courier.latitude), lng: parseFloat(courier.longitude) },
                map: map,
                title: courier.name,
                icon: {
                    url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                }
            });

            // Marker'a tıklandığında bilgi penceresi göster
            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div>
                        <h5>${courier.name}</h5>
                        <p>Plaka: ${courier.plate}</p>
                        <p>Durum: ${courier.status === 'active' ? 'Aktif' : 'Pasif'}</p>
                        <p>Son Güncelleme: ${new Date(courier.last_location_update).toLocaleString()}</p>
                    </div>
                `
            });

            marker.addListener("click", () => {
                infoWindow.open(map, marker);
            });
        }
    });
}

// Sayfa yüklendiğinde haritayı başlat
window.onload = initMap;
</script>
@endpush
@endsection 