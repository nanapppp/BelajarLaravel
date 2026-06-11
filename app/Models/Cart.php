<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // PERBAIKAN: Ganti 'id' menjadi 'user_id' agar diizinkan masuk ke database
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];

    /**
     * Relasi ke model Product (Keranjang ini berisi produk apa)
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Relasi ke model User (Keranjang ini milik siapa)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}