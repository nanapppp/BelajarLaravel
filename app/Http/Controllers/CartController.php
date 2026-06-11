<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\DetailOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Memastikan hanya user yang sudah login yang bisa mengelola keranjang.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan isi keranjang belanja milik user yang sedang login.
     */
    public function index()
    {
        $carts = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('cart.index', compact('carts'));
    }

    /**
     * Tambah produk ke dalam keranjang belanja.
     */
    public function add($id)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();

        if ($cart) {
            // Jika produk sudah ada di keranjang, cukup tambahkan jumlahnya
            $cart->increment('quantity');
        } else {
            // Jika belum ada, buat data baru dengan menyertakan user_id
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $id,
                'quantity'   => 1
            ]);
        }

        return back()->with('success', 'Produk berhasil masuk ke keranjang.');
    }

    /**
     * Proses checkout: Mengubah isi keranjang menjadi pesanan (order).
     */
    public function store()
    {
        $carts = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Keranjang belanja Anda masih kosong.');
        }

        // Menghitung total harga dari seluruh produk yang ada di keranjang
        $total = $carts->sum(function ($c) {
            return $c->product ? ($c->product->harga * $c->quantity) : 0;
        });

        // Buat data induk pesanan (Order)
        $order = Order::create([
            'user_id'        => Auth::id(),
            'tanggal'        => now()->toDateString(),
            'total'          => $total,
            'status'         => 'pending',
            'payment_status' => 'unpaid',
        ]);

        // Pindahkan setiap item dari keranjang ke detail pesanan
        foreach ($carts as $cart) {
            DetailOrder::create([
                'order_id'   => $order->id,
                'product_id' => $cart->product_id,
                'quantity'   => $cart->quantity,
            ]);
        }

        // Kosongkan keranjang belanja user setelah berhasil checkout
        Cart::where('user_id', Auth::id())->delete();

        // Alihkan langsung ke halaman pembayaran QRIS membawa ID order baru
        return redirect()->route('orders.payment', $order->id)
            ->with('success', 'Checkout berhasil! Silakan lakukan pembayaran.');
    }
}