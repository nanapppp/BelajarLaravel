@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <div class="row mb-4">
        <div class="col-md-12 text-center">
            <h2>Daftar Produk</h2>
            <p class="text-muted">Pilih produk yang ingin kamu beli</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">

                    {{-- GAMBAR --}}
                    @if($product->foto)
                        <img src="{{ asset('storage/image/' . $product->foto) }}"
                             class="card-img-top"
                             style="height:200px; object-fit:cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light"
                             style="height:200px;">
                            <span class="text-muted">No Image</span>
                        </div>
                    @endif

                    {{-- BODY --}}
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->nama }}</h5>

                        <p class="mb-1 text-muted">
                            {{ $product->category->category_name ?? '-' }}
                        </p>

                        <h6 class="text-primary">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </h6>

                        <small class="text-muted">
                            Stok: {{ $product->stock }}
                        </small>

                        <p class="mt-2">
                            {{ \Illuminate\Support\Str::limit($product->deskripsi, 50) }}
                        </p>
                    </div>

                    {{-- FOOTER --}}
                    <div class="card-footer bg-white border-0 text-center">

                        @auth
                            @if($product->stock > 0)
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">

                                    <button type="submit" class="btn btn-primary w-100">
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary w-100" disabled>
                                    Stok Habis
                                </button>
                            @endif
                        @endauth

                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">
                                Login untuk beli
                            </a>
                        @endguest

                    </div>

                </div>
            </div>

        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Tidak ada produk</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
