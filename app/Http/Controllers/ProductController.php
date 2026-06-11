<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // ✅ INDEX (BEDA ADMIN & MEMBER)
    public function index()
    {
        $products = Product::with('category')->get();

        // 👉 ADMIN
        if (auth()->check() && auth()->user()->role == 'admin') {
            return view('products.index', compact('products'));
        }

        // 👉 MEMBER / TAMU
        return view('products.product', compact('products'));
    }

    // ✅ CREATE (HANYA ADMIN)
    public function create()
    {
        if (!auth()->check() || auth()->user()->role != 'admin') {
            abort(403);
        }

        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // ✅ STORE (HANYA ADMIN)
    public function store(Request $request)
    {
        if (!auth()->check() || auth()->user()->role != 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // ✅ optional
            'category_id' => 'required|exists:categories,id'
        ]);

        $filename = null;

        // 👉 Upload foto jika ada (optional)
        if ($request->hasFile('foto')) {
            $filename = time() . '.' . $request->foto->extension();
            $request->foto->storeAs('public/image', $filename);
            // ✅ Tersimpan di: storage/app/public/image/{filename}
            // ✅ Diakses via: asset('storage/image/{filename}')
        }

        Product::create([
            'nama'        => $validated['nama'],
            'harga'       => $validated['harga'],
            'stock'       => $validated['stock'],
            'deskripsi'   => $validated['deskripsi'],
            'foto'        => $filename, // null jika tidak upload
            'category_id' => $validated['category_id']
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    // ✅ SHOW (SEMUA BOLEH)
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    // ✅ EDIT (HANYA ADMIN)
    public function edit($id)
    {
        if (!auth()->check() || auth()->user()->role != 'admin') {
            abort(403);
        }

        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    // ✅ UPDATE (HANYA ADMIN)
    public function update(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->role != 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'nama'        => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // ✅ optional
            'category_id' => 'required|exists:categories,id'
        ]);

        $product = Product::findOrFail($id);

        // 👉 Kalau upload foto baru
        if ($request->hasFile('foto')) {

            // Hapus foto lama jika ada
            // ✅ Path: storage/app/public/image/
            if ($product->foto && file_exists(storage_path('app/public/image/' . $product->foto))) {
                unlink(storage_path('app/public/image/' . $product->foto));
            }

            // Simpan foto baru
            $filename = time() . '.' . $request->foto->extension();
            $request->foto->storeAs('public/image', $filename);

            $validated['foto'] = $filename;
        } else {
            // ✅ Tidak upload foto → pertahankan foto lama
            unset($validated['foto']);
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diupdate!');
    }

    // ✅ DELETE (HANYA ADMIN)
    public function destroy($id)
    {
        if (!auth()->check() || auth()->user()->role != 'admin') {
            abort(403);
        }

        $product = Product::findOrFail($id);

        // 👉 Hapus foto jika ada
        // ✅ Path: storage/app/public/image/
        if ($product->foto && file_exists(storage_path('app/public/image/' . $product->foto))) {
            unlink(storage_path('app/public/image/' . $product->foto));
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}