@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold">📂 Data Kategori</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('category.create') }}" class="btn btn-success btn-lg">
                ➕ Tambah Kategori
            </a>
        </div>
    </div>

    <!-- Alert -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✓ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            ✗ {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tabel -->
    <div class="table-responsive bg-white rounded shadow">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th style="width: 10%">No</th>
                    <th style="width: 40%">Nama Kategori</th>
                    <th style="width: 20%">Jumlah Produk</th>
                    <th style="width: 30%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $category->category_name }}</strong></td>
                        <td>
                            <span class="badge bg-info">
                                {{ $category->products()->count() }} produk
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('category.show', $category->id) }}" 
                                   class="btn btn-info">
                                    👁️ View
                                </a>
                                <a href="{{ route('category.edit', $category->id) }}" 
                                   class="btn btn-warning">
                                    ✏️ Edit
                                </a>
                                
                                <form action="{{ route('category.destroy', $category->id) }}" 
                                      method="POST" 
                                      style="display: inline;"
                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger"
                                            {{ $category->products()->count() > 0 ? 'disabled' : '' }}>
                                        🗑️ Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-5">
                            <p class="fs-6">Tidak ada data kategori</p>
                            <a href="{{ route('category.create') }}" class="btn btn-sm btn-success">
                                ➕ Tambah Kategori Sekarang
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection