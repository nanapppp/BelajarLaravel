<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        $categories = Category::all();
        return view('category.category', compact('categories'));
    }

    // Menampilkan form create kategori
    public function create()
    {
        return view('category.create');
    }

    // Proses menyimpan kategori baru
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name'
        ]);

        // Simpan ke database
        Category::create($validated);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Menampilkan detail kategori
    public function show($id)
    {
        $category = Category::with('products')->findOrFail($id);
        return view('category.show', compact('category'));
    }

    // Menampilkan form edit kategori
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    // Proses update kategori
    public function update(Request $request, $id)
    {
        // Validasi - unique kecuali id sekarang
        $validated = $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name,' . $id
        ]);

        // Update kategori
        $category = Category::findOrFail($id);
        $category->update($validated);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil diupdate!');
    }

    // Menghapus kategori
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Cek apakah kategori memiliki produk
        if ($category->products()->count() > 0) {
            return redirect()->route('category.index')
                ->with('error', 'Tidak bisa menghapus kategori yang memiliki produk!');
        }

        // Hapus kategori
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Kategori berhasil dihapus!');
    }
}