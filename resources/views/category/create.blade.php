@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="fw-bold">➕ Tambah Kategori Baru</h2>
                <p class="text-muted">Isi form di bawah untuk menambahkan kategori baru</p>
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

            <!-- Form -->
            <form action="{{ route('category.store') }}" 
                  method="POST"
                  class="bg-white p-4 rounded shadow">
                @csrf

                <div class="mb-4">
                    <label for="category_name" class="form-label fw-bold">Nama Kategori</label>
                    <input type="text" 
                           class="form-control @error('category_name') is-invalid @enderror" 
                           id="category_name" 
                           name="category_name" 
                           value="{{ old('category_name') }}"
                           placeholder="Masukkan nama kategori"
                           required>
                    <small class="form-text text-muted d-block mt-2">
                        Contoh: Elektronik, Makanan, Pakaian, dll
                    </small>
                    @error('category_name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success btn-lg flex-grow-1">
                        ➕ Tambah Kategori
                    </button>
                    <a href="{{ route('category.index') }}" class="btn btn-secondary btn-lg">
                        ← Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection