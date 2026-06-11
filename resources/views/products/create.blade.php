@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="fw-bold">➕ Tambah Produk Baru</h2>
                <p class="text-muted">Isi form di bawah untuk menambahkan produk baru</p>
            </div>

            <!-- Alert Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>❌ Terjadi kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Form Create -->
            <form action="{{ route('products.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="bg-white p-4 rounded shadow">
                @csrf

                <!-- Nama Produk -->
                <div class="mb-3">
                    <label for="nama" class="form-label fw-bold">Nama Produk</label>
                    <input type="text" 
                           class="form-control @error('nama') is-invalid @enderror" 
                           id="nama" 
                           name="nama" 
                           value="{{ old('nama') }}"
                           placeholder="Masukkan nama produk"
                           required>
                    @error('nama')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Harga -->
                <div class="mb-3">
                    <label for="harga" class="form-label fw-bold">Harga (Rp)</label>
                    <input type="number" 
                           class="form-control @error('harga') is-invalid @enderror" 
                           id="harga" 
                           name="harga" 
                           value="{{ old('harga') }}"
                           step="0.01"
                           placeholder="0"
                           required>
                    @error('harga')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Stok -->
                <div class="mb-3">
                    <label for="stock" class="form-label fw-bold">Stok</label>
                    <input type="number" 
                           class="form-control @error('stock') is-invalid @enderror" 
                           id="stock" 
                           name="stock" 
                           value="{{ old('stock') }}"
                           placeholder="0"
                           required>
                    @error('stock')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="mb-3">
                    <label for="category_id" class="form-label fw-bold">Kategori</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" 
                            id="category_id" 
                            name="category_id"
                            required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              id="deskripsi" 
                              name="deskripsi"
                              rows="4"
                              placeholder="Masukkan deskripsi produk">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Gambar -->
                <div class="mb-4">
                    <label for="foto" class="form-label fw-bold">Gambar Produk</label>
                    <input type="file" 
                           class="form-control @error('foto') is-invalid @enderror" 
                           id="foto" 
                           name="foto"
                           accept="foto/*">
                    <small class="form-text text-muted d-block mt-2">
                        📝 Format: JPEG, PNG, JPG, GIF | Ukuran maksimal: 2MB
                    </small>
                    @error('foto')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success btn-lg flex-grow-1">
                        ➕ Tambah Produk
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-lg">
                        ← Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection