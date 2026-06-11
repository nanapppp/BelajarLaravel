@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">📦 Data Produk</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('products.create') }}" class="btn btn-success btn-lg">
                ➕ Tambah Produk Baru
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>✓ Sukses!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>✗ Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive bg-white rounded shadow">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 15%">Nama Produk</th>
                    <th style="width: 12%">Harga</th>
                    <th style="width: 8%">Stok</th>
                    <th style="width: 15%">Kategori</th>
                    <th style="width: 20%">Deskripsi</th>
                    <th style="width: 10%">Gambar</th>
                    <th style="width: 15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $product->nama }}</strong></td>
                        <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge @if($product->stock > 50) bg-success @elseif($product->stock > 0) bg-warning @else bg-danger @endif">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>{{ $product->category->category_name }}</td>
                        <td>
                            <small class="text-muted">
                                {{ Str::limit($product->deskripsi, 50) }}
                            </small>
                        </td>
                        <td>
                            @if ($product->foto)
                                <img src="{{ asset('storage/image/' . $product->foto) }}" 
                                     alt="{{ $product->product_name }}" 
                                     class="img-thumbnail"
                                     style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <span class="badge bg-secondary">Tidak ada</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('products.show', $product->id) }}" 
                                   class="btn btn-info btn-sm" title="View">
                                    👁️ View
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}" 
                                   class="btn btn-warning btn-sm" title="Edit">
                                    ✏️ Edit
                                </a>
                                
                                <form action="{{ route('products.destroy', $product->id) }}" 
                                      method="POST" 
                                      style="display: inline;"
                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm" 
                                            title="Delete">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <p class="fs-6">Tidak ada data produk</p>
                            <a href="{{ route('products.create') }}" class="btn btn-sm btn-success">
                                ➕ Tambah Produk Sekarang
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection