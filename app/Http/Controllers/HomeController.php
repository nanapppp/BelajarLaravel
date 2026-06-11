<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman home/dashboard
     */
    public function index()
{
    // 🔥 CEK APAKAH SUDAH LOGIN
    if (auth()->check()) {

        // 🔥 CEK ROLE ADMIN
        if (auth()->user()->role == 'admin') {

            // DATA KHUSUS ADMIN
            $totalProducts = Product::count();
            $totalCategories = Category::count();
            $totalStock = Product::sum('stock');

            $recentProducts = Product::with('category')
                ->latest()
                ->take(5)
                ->get();

            // 👉 ADMIN MASUK KE DASHBOARD
            return view('layouts.welcome1', compact(
                'totalProducts',
                'totalCategories',
                'totalStock',
                'recentProducts'
            ));
        }
    }

    // 👉 TAMU + MEMBER MASUK KE HALAMAN INDEX
    return view('index');
}

}