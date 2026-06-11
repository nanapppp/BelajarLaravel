<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\DetailOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // ✅ tampilkan cart
   // tampilkan cart
public function index()
{
    $carts = Cart::with('product')
        ->where('id', Auth::id())
        ->get();

    return view('cart.index', compact('carts'));
}

// tambah ke cart
public function add($id)
{
    $cart = Cart::where('id', Auth::id())
        ->where('product_id', $id)
        ->first();

    if ($cart) {
        $cart->increment('quantity');
    } else {
        Cart::create([
            'id' => Auth::id(),
            'product_id' => $id,
            'quantity' => 1
        ]);
    }

    return back()->with('success', 'Produk masuk ke keranjang');
}


// checkout
public function store()
{
    $carts = Cart::with('product')
        ->where('id', Auth::id())
        ->get();

    if ($carts->isEmpty()) {
        return back()->with('error', 'Keranjang kosong');
    }

    $total = $carts->sum(function ($c) {
        return $c->product->harga * $c->quantity;
    });

    $order = Order::create([
        'tanggal' => now(),
        'total' => $total,
        'status' => 'pending',
        'payment_status' => 'unpaid',
    ]);

    foreach ($carts as $cart) {
        DetailOrder::create([
            'order_id' => $order->id,
            'product_id' => $cart->product_id,
            'quantity' => $cart->quantity,
        ]);
    }

    Cart::where('id', Auth::id())->delete();

    return redirect()->route('orders.index')
        ->with('success', 'Checkout berhasil!');
}
}