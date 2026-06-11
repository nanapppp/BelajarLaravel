<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Daftar pesanan milik user yang sedang login.
     */
    public function index(Request $request)
    {
        $query = Order::with(['items.product.category'])
            ->where('id', Auth::id())
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('month')) {
            $query->whereYear('created_at',  substr($request->month, 0, 4))
                  ->whereMonth('created_at', substr($request->month, 5, 2));
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('orders.index', compact('orders'));
    }

    /**
     * Detail satu pesanan.
     */
    public function show(Order $order)
    {
        // Pastikan hanya pemilik yang bisa lihat
        abort_if($order->user_id !== Auth::id(), 403);

        $order->load(['items.product.category']);

        return view('orders.show', compact('order'));
    }

    /**
     * Batalkan pesanan (hanya saat status masih pending).
     */
    /**
     * Halaman pembayaran QRIS
     */
    public function payment(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);
        abort_if($order->payment_status === 'paid', 403, 'Pesanan ini sudah dibayar.');

        $order->load(['items.product']);
        return view('orders.payment', compact('order'));
    }

    /**
     * Upload bukti pembayaran QRIS
     */
    public function uploadPayment(Request $request, Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'payment_proof.required' => 'Bukti pembayaran wajib diupload.',
            'payment_proof.image'    => 'File harus berupa gambar.',
            'payment_proof.max'      => 'Ukuran gambar maksimal 2MB.',
        ]);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $order->update([
            'payment_proof'  => $path,
            'payment_status' => 'review',   // admin perlu konfirmasi
        ]);

        return redirect()
            ->route('orders.show', $order->id)
            ->with('success', 'Bukti pembayaran berhasil dikirim! Pesanan akan diproses setelah dikonfirmasi admin.');
    }

    public function cancel(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 403);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}