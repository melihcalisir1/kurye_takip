@extends('layouts.app')
@section('title', 'Kurye Yönetimi')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Kurye Yönetimi</h2>
        <a href="{{ route('restaurant.couriers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Yeni Kurye Ekle
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Ad Soyad</th>
                            <th>Telefon</th>
                            <th>E-posta</th>
                            <th>Durum</th>
                            <th>Bugünkü Teslimat</th>
                            <th>Son Görülme</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($couriers as $courier)
                            <tr>
                                <td>{{ $courier->name }}</td>
                                <td>{{ $courier->phone }}</td>
                                <td>{{ $courier->user->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $courier->status === 'active' ? 'success' : 'danger' }}">
                                        {{ $courier->status === 'active' ? 'Aktif' : 'Pasif' }}
                                    </span>
                                </td>
                                <td>{{ $courier->orders->count() }}</td>
                                <td>{{ $courier->last_seen_at ? $courier->last_seen_at->diffForHumans() : 'Hiç görülmedi' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('restaurant.couriers.show', $courier) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Detay">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('restaurant.couriers.edit', $courier) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Düzenle">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('restaurant.couriers.toggle-status', $courier) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-{{ $courier->status === 'active' ? 'secondary' : 'success' }}"
                                                    title="{{ $courier->status === 'active' ? 'Pasif Yap' : 'Aktif Yap' }}">
                                                <i class="fas fa-{{ $courier->status === 'active' ? 'ban' : 'check' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('restaurant.couriers.destroy', $courier) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Bu kuryeyi silmek istediğinizden emin misiniz?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Sil">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Henüz kurye bulunmuyor.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table th {
        font-weight: 600;
        background: #f8f9fa;
    }
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
    .badge {
        padding: 0.5em 0.8em;
        font-weight: 500;
    }
</style>
@endsection 