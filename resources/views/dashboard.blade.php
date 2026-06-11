<!-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
 -->

    @extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-md-8">
            <div class="bg-gradient-primary text-white p-5 rounded-lg shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h1 class="display-4 fw-bold mb-3">📦 Selamat Datang di Nanap shop</h1>
                <p class="lead mb-0">Kelola data produk dan kategori dengan mudah dan aman</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center">
                <div class="display-1" style="font-size: 5rem;">📊</div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="row mb-5">
        <!-- Total Produk -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow" style="transition: all 0.3s ease;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div style="font-size: 3rem; color: #667eea;">📦</div>
                        <div class="ms-4">
                            <p class="text-muted mb-1">Total Produk</p>
                            <h3 class="mb-0">{{ $totalProducts ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light border-0">
                    <a href="{{ route('products.index') }}" class="text-decoration-none text-primary">
                        Kelola Produk →
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Kategori -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow" style="transition: all 0.3s ease;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div style="font-size: 3rem; color: #f6ad55;">📂</div>
                        <div class="ms-4">
                            <p class="text-muted mb-1">Total Kategori</p>
                            <h3 class="mb-0">{{ $totalCategories ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light border-0">
                    <a href="{{ route('category.index') }}" class="text-decoration-none text-primary">
                        Kelola Kategori →
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Stok -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow" style="transition: all 0.3s ease;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div style="font-size: 3rem; color: #68d391;">📈</div>
                        <div class="ms-4">
                            <p class="text-muted mb-1">Total Stok</p>
                            <h3 class="mb-0">{{ $totalStock ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light border-0">
                    <a href="{{ route('products.index') }}" class="text-decoration-none text-primary">
                        Lihat Detail →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4">⚡ Akses Cepat</h3>
        </div>
        <div class="col-md-6 mb-3">
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg w-100 rounded-lg" style="padding: 1rem;">
                <i class="fas fa-plus"></i> Tambah Produk Baru
            </a>
        </div>
        <div class="col-md-6 mb-3">
            <a href="{{ route('category.create') }}" class="btn btn-success btn-lg w-100 rounded-lg" style="padding: 1rem;">
                <i class="fas fa-plus"></i> Tambah Kategori Baru
            </a>
        </div>
        <div class="col-md-6 mb-3">
            <a href="{{ route('products.index') }}" class="btn btn-info btn-lg w-100 rounded-lg" style="padding: 1rem;">
                <i class="fas fa-list"></i> Lihat Semua Produk
            </a>
        </div>
        <div class="col-md-6 mb-3">
            <a href="{{ route('category.index') }}" class="btn btn-warning btn-lg w-100 rounded-lg" style="padding: 1rem;">
                <i class="fas fa-list"></i> Lihat Semua Kategori
            </a>
        </div>
    </div>

    <!-- Recent Products Section -->
    @if(isset($recentProducts) && count($recentProducts) > 0)
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">🆕 Produk Terbaru</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentProducts as $product)
                            <tr>
                                <td>
                                    <strong>{{ $product->product_name }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $product->category->category_name }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge @if($product->stock > 50) bg-success @elseif($product->stock > 0) bg-warning @else bg-danger @endif">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Features Section -->
    <div class="row mb-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4">✨ Fitur Aplikasi</h3>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 text-center shadow-sm h-100">
                <div class="card-body p-4">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">➕</div>
                    <h5 class="card-title">Create</h5>
                    <p class="card-text text-muted">Tambahkan produk dan kategori baru dengan mudah</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 text-center shadow-sm h-100">
                <div class="card-body p-4">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">👁️</div>
                    <h5 class="card-title">Read</h5>
                    <p class="card-text text-muted">Lihat daftar produk dan detail lengkapnya</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 text-center shadow-sm h-100">
                <div class="card-body p-4">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">✏️</div>
                    <h5 class="card-title">Update</h5>
                    <p class="card-text text-muted">Edit informasi produk dan kategori</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card border-0 text-center shadow-sm h-100">
                <div class="card-body p-4">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">🗑️</div>
                    <h5 class="card-title">Delete</h5>
                    <p class="card-text text-muted">Hapus data yang sudah tidak diperlukan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Section -->
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info border-0 rounded-lg" role="alert">
                <div class="d-flex align-items-start">
                    <div style="font-size: 1.5rem; margin-right: 1rem;">ℹ️</div>
                    <div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
        transform: translateY(-5px);
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .rounded-lg {
        border-radius: 0.5rem;
    }
</style>
@endsection

    <!-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> -->
