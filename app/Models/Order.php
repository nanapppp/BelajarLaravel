<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal',
        'total',
        'status',
        'payment_status',
        'payment_proof'
    ];

    public function details()
    {
        return $this->hasMany(DetailOrder::class);
    }

    public function items()
    {
        return $this->hasMany(DetailOrder::class);
    }
}