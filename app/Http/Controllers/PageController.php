<?php

class PageController extends Controller
{
    public function home() {
        return view('products.beranda');
    }

    public function products() {
        $products = [
            ['name'=>'Makanan', 'price'=>'25.000'],
            ['name'=>'Minuman', 'price'=>'75.000'],
            ['name'=>'Snack', 'price'=>'120.000'],
        ];
        return view('products', compact('products'));
    }

    public function categories() {
        $categories = ['Makanan', 'Minuman', 'Snack'];
        return view('categories', compact('categories'));
    }
}