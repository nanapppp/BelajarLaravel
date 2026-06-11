@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Keranjang</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($carts->isEmpty())
        <div class="alert alert-danger">Keranjang kosong</div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; @endphp

                @foreach($carts as $cart)
                    @php 
                        $total = $cart->product->harga * $cart->quantity;
                        $grandTotal += $total;
                    @endphp

                    <tr>
                        <td>{{ $cart->product->nama }}</td>
                        <td>Rp {{ number_format($cart->product->harga) }}</td>
                        <td>{{ $cart->quantity }}</td>
                        <td>Rp {{ number_format($total) }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="3"><b>Total</b></td>
                    <td><b>Rp {{ number_format($grandTotal) }}</b></td>
                </tr>
            </tbody>
        </table>

       <form action="{{ route('cart.store') }}" method="POST">
    @csrf
    <button type="submit">Checkout</button>
</form>
    @endif
</div>
@endsection
