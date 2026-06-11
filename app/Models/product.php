<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
        'nama',
        'harga',
        'stock',
        'deskripsi',
        'foto',
        'category_id'
    ];

    // Relasi ke tabel categories (One to Many inverse)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}