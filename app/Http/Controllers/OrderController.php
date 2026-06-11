<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Memastikan hanya user yang sudah login yang bisa mengakses controller ini.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan daftar pesanan milik user yang sedang login.
     */
    public function index(Request $request)
    {
        // Memfilter pesanan berdasarkan user_id yang sedang login
        $query = Order::with(['items.product.category'])
            ->where('user_id', Auth::id()) 
            ->latest();

        // Filter berdasarkan status jika dipilih (Semua Status, Menunggu, dll)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan bulan jika dipilih
        if ($request->filled('month')) {
            $query->whereYear('created_at',  substr($request->month, 0, 4))
                  ->whereMonth('created_at', substr($request->month, 5, 2));
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail dari satu pesanan tertentu.
     */
    public function show(Order $order)
    {
        // Keamanan: Pastikan hanya pemilik pesanan yang bisa melihat detail ini
        abort_if($order->user_id !== Auth::id(), 403, 'Anda tidak memiliki akses ke pesanan ini.');

        $order->load(['items.product.category']);

        return view('orders.show', compact('order'));
    }

    /**
     * Menampilkan halaman pembayaran (misal: QRIS / Petunjuk Transfer).
     */
    public function payment(Order $order)
    {
        // Keamanan: Pastikan hanya pemilik pesanan yang bisa membayar
        abort_if($order->user_id !== Auth::id(), 403, 'Anda tidak memiliki akses ke halaman ini.');
        
        // Cek jika pesanan sudah dibayar sebelumnya
        abort_if($order->payment_status === 'paid', 403, 'Pesanan ini sudah berhasil dibayar.');

        $order->load(['items.product']);
        
        return view('orders.payment', compact('order'));
    }

    /**
     * Mengisi/mengupload bukti pembayaran setelah user melakukan transfer.
     */
    public function uploadPayment(Request $request, Order $order)
    {
        // Keamanan: Pastikan user yang upload adalah pemilik pesanan
        abort_if($order->user_id !== Auth::id(), 403);

        // Validasi file bukti pembayaran
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'payment_proof.required' => 'Bukti pembayaran wajib diupload.',
            'payment_proof.image'    => 'File harus berupa gambar.',
            'payment_proof.max'      => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Simpan file gambar ke folder storage/app/public/payment_proofs
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        // Update status pembayaran ke 'review' agar Admin bisa memeriksa di halaman admin
        $order->update([
            'payment_proof'  => $path,
            'payment_status' => 'review', // Menunggu konfirmasi admin
        ]);

        return redirect()
            ->route('orders.show', $order->id)
            ->with('success', 'Bukti pembayaran berhasil dikirim! Pesanan akan diproses setelah dikonfirmasi admin.');
    }

    /**
     * Membatalkan pesanan (Hanya bisa dilakukan jika status pesanan masih 'pending').
     */
    public function cancel(Order $order)
    {
        // Keamanan: Pastikan user yang membatalkan adalah pemilik pesanan
        abort_if($order->user_id !== Auth::id(), 403);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}