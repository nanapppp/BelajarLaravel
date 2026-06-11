<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'id',
        'tanggal',
        'total'
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
